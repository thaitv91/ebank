<?php
session_start();

include("condition.php");
include("../function/functions.php");
include("../function/sendmail.php");


if (!empty($_GET['act']) && ($_GET['act'] == "delete"))
{

    $did = $_GET['id'];
    $delete = mysql_query("delete from epin_request where id = '$did'");
    echo "<script type=\"text/javascript\">";

    echo "window.location = \"index.php?page=epin_request\"";

    echo "</script>";
}
if (isset($_POST['submit']))
{

    if ($_SESSION['generate_pin_for_user1'] == 1)
    {

        $new_user = $_REQUEST['username'];

        $epin_amount = $_POST['epin_amount'];

        $epin_number = $_POST['epin_number'];

        $id = $_POST['id'];




        if ($epin_amount == 0)
        {

            $amount = $epin_type = 0;
        }
        else
        {

            $amount = $epin_amount;

            $epin_type = 1;
        }



        $q = mysql_query("select * from users where username = '$new_user' ");

        $num = mysql_num_rows($q);

        if ($num != 0)
        {

            $_SESSION['generate_pin_for_user1'] = 0;

            while ($row = mysql_fetch_array($q))
            {

                $new_user_id = $row['id_user'];
            }

            $epin = "$epin_number E-pin ";

            for ($ii = 0; $ii < $epin_number; $ii++)
            {

                do
                {

                    $unique_epin = mt_rand(1000000000, 9999999999);

                    $query = mysql_query("select * from e_pin where epin = '$unique_epin' ");

                    $num = mysql_num_rows($query);
                }
                while ($num > 0);



                $mode = 1;

                $date = date('Y-m-d');

                $t = date('h:i:s');


                //var_dump("insert into e_pin (epin,amount,user_id , mode , time , date , plan_id) 

                //values ('$unique_epin' ,'$epin_amount', '$new_user_id' , '$mode' , '$t' , '$date' , 0)"); exit;



                mysql_query("insert into e_pin (epin,amount,user_id , mode , time , date , plan_id) 

				values ('$unique_epin' ,'$epin_amount', '$new_user_id' , '$mode' , '$t' , '$date' , 0)");


                //update epin to epin history
                $q_epin_r = mysql_query("SELECT * FROM e_pin WHERE epin = $unique_epin");
                $r_epin_r = mysql_fetch_array($q_epin_r);
                $epin_id_r = $r_epin_r['id'];

                $insert_sql = mysql_query("insert into epin_history (epin_id , user_id , mode , date) values ('$epin_id_r' , '$new_user_id' ,'1', '$date')");

                mysql_query("update epin_request set mode=1 where id='$id'");

                $epin .= $unique_epin . "<br>";
            }

            print "E pin generated Successfully !";

            $epin_generate_username = "rapidforx2";

            $epin_amount = $fees;

            $payee_epin_username = $mew_user;

            //$title = "E-pin mail";

            //$to = get_user_email($new_user_id);

            $from = 0;



            $db_msg = $epin_generate_message;

            //send mail
            $email = get_user_email($new_user_id);
            $name  = get_user_name($new_user_id);
            $title = 'Your have received your e-PINs';
            $content = $epin_number." e-PINs have just been added to your eBank account.<br>Please log in now to make a PH to help the community.";
            sendMail($email,$name,$title,$content);
			
			//send mail
			/*$sender_username = get_user_name($new_user_id);
			$to              = get_user_email($new_user_id);
			$title           = 'Your have received your e-PINs';
			$contentmail     = $epin_number." e-PINs have just been added to your eBank account.<br>Please log in now to make a PH to help the community.";
			$message         = contentEmail($sender_username, $contentmail);
			$send_mail = sendmail($to, $title, $message);*/

            //include("../function/full_message.php");
            //$SMTPMail = new SMTPClient($SmtpServer, $SmtpPort, $SmtpUser, $SmtpPass, $from, $to, $title, $full_message);
            //$SMTPChat = $SMTPMail->SendMail();
			
        }
        else
        {
            echo "<B style=\"color:#ff0000;\">Enter Correct Username !!</B>";
        }
    }
    else
    {
        echo "<B style=\"color:#ff0000;\">There are some conflicts !!</B>";
    }
}
else
{



    $query = mysql_query("select t2.username,t1.* from epin_request t1

						  left join users t2 on t1.user_id = t2.id_user

						  where t1.mode = 0 and t1.active=1");

    $num = mysql_num_rows($query);

    if ($num != 0)
    {

        $_SESSION['generate_pin_for_user1'] = 1;
        ?>

        <table class="table table-bordered"> 

            <thead>

                <tr>	

                    <th class="text-center">username</th>	

                    <th class="text-center">No. Pin</th>

                    <th class="text-center">Date</th>

                    <th class="text-center">BTC Address</th>

                    <th class="text-center">File</th>

                    <th class="text-center">&nbsp;</th>	
                    <th class="text-center">&nbsp;</th>	
                </tr>

            </thead>

            <?php
            $i = 1;



            while ($row = mysql_fetch_array($query))
            {
                $username = $row['username'];

                $plan_id = $row['plan_id'];

                $no_pin = $row['no_pin'];

                $id = $row['id'];

                $date = $row['date'];

                $p_name = $plan_n[$plan_id];
                ?>	

                <tr>


                    <td class="text-center"><?= $username; ?></td>

                    <td class="text-center"><?= $no_pin; ?></td>

                    <td class="text-center"><?= $date; ?></td>

                    <td class="text-center"><?= $row['btc_address']; ?></td>

                    <td class="text-center">  <a href="javascript:void(0)" class="modal-img" data-img="<?= $row['photo'] ?>"><img width="30" src="/images/epin_pay_receipt/<?= $row['photo'] ?>"></a></td>

                    <td class="text-center">

                        <form action="" method="post">

                            <input type="hidden" name="username" value="<?= $username ?>"  />

                            <input type="hidden" name="id" value="<?= $id ?>"  />

                            <input type="hidden" name="epin_number" value="<?= $no_pin ?>"  />

                            <input type="hidden" name="epin_amount" value="<?= $plan_id ?>" />

                            <input type="submit" name="submit" value="Generate" class="btn btn-info" />

                        </form>

                    </td>
                    <td class="text-center">  <a href="index.php?page=epin_request&act=delete&id=<?= $row['id'] ?>">Xóa</a></td>

                </tr>

                <?php
                $i++;
            }

            echo "</table>";
        }
        else
        {
            echo "<B style=\"color:#ff0000;\">There is no Request For E-pin !!</B>";
        }
    }
    ?>



    <div class="modal fade" tabindex="-1" role="dialog" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="modal-epin">
                        <p><img id="viewImg" style="width:400px" src=""></p>
                        <p>  <a href="javascript:void(0)" data-dismiss="modal" aria-label="Close">Close</a></p>
                    </div>
                </div>

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <script>
        $(document).on('click', '.modal-img', function (event) {
            event.preventDefault();
            var img = $(this).attr('data-img');
            var link = "/images/epin_pay_receipt/" + img;
            $('#viewImg').attr('src', link);
            $('#myModal').modal('show');

        });
    </script>