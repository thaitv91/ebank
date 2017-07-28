<?php
include("condition.php");

include("function/setting.php");

include("function/send_mail.php");

include("function/functions.php");

include("function/wallet_message.php");



$id = $_SESSION['ebank_user_id'];

$position = $_SESSION['position'];

function getCount($date, $user_id)
{
    return mysql_num_rows(mysql_query("select * from epin_history where transfer_to='$user_id' and date = '$date'"));
}

$error = '';
if (isset($_POST['submit']))
{

    $user_pin = $_REQUEST['user_pin'];

    $pin_no = $_REQUEST['pin_no'];

    $request_pin = $_REQUEST['request_pin'];

    $requested_user = $_REQUEST['requested_user'];

    $comment = mysql_real_escape_string($_POST['comment'], $con);

    $requested_user_id = get_new_user_id($requested_user);

    $request_date = $systems_date;

    if ($requested_user_id == 0)
    {

        $error = "Please Enter correct Username !";
    }
    else
    {

        $query = mysql_query("select * from users where id_user = '$id' and user_pin = '$user_pin' ");

        $num = mysql_num_rows($query);

        if ($num > 0)
        {



            if ($id == $requested_user_id)
            {
                echo $error = "Please Transfer To Another Member";
            }
            else
            {

                $left_amount = $current_amount - $request_amount;

                $query = mysql_query("select * from e_pin where user_id = '$id' and mode = 1 limit  $pin_no");

                $pin_num = mysql_num_rows($query);

                if ($pin_num > 0)
                {

                    if ($pin_num >= $pin_no)
                    {

                        while ($row = mysql_fetch_array($query))
                        {

                            $epin_id = $row['id'];

                            $epin_type = $row['epin_type'];

                            $epin_ids = $row['epin_id'];



                            $sql_updt = "update e_pin set user_id = '$requested_user_id' , 

							date = '$request_date' where id = '$epin_id' ";

                            mysql_query($sql_updt);



                            $qus = "select * from e_pin as t1 inner join epin_history as t2 on 

							t1.id = t2.epin_id and t1.user_id = '$id' and t1.mode = 1 limit $pin_no ";

                            $query_epin = mysql_query($qus);

                            while ($rok = mysql_fetch_array($query_epin))
                            {

                                $epin_new_id = $rok['id'];

                                $generate_id = $rok['generate_id'];

                                $transfer_to = $rok['transfer_to'];
                            }

                            $insert_sql = "insert into epin_history (epin_id, generate_id , 

							user_id ,transfer_to, date) values ('$epin_id' , '$generate_id' , 

							'$id' ,'$requested_user_id', '$request_date')";

                            mysql_query($insert_sql);



                            /* $message = "Registration E-Pin is successfully transfered to you. www.poorvanchalservices.net";

                              $phone = get_user_phone($requested_user_id);

                              send_sms($phone,$message); */
                        }

                        $sqlkk = "update epin_request set num_of_pin='$pin_no' where epin_id='$epin_ids'";

                        mysql_query($sqlkk);



                        /* $time = date('Y-m-d H:i:s');

                          $sqlss = "insert into epin_request (generate_by, epin_for , num_of_pin , mode , date , time , epin_type , comment , epin_id , process_datetime) values ('$id' , '$requested_user_id' ,'$pin_no' , 1 , '$request_date' , '$time' , '$epin_type' , '$comment' , '0' , '$time')";

                          mysql_query($sqlss); */



                        $_SESSION['epin_success'] = "<B style=\"color:#008000;\">You request of transfer E-pin " . $request_pin . " has completed successfully !!</B>";

                        echo "<script type=\"text/javascript\">";

                        echo "window.location = \"index.php?page=pin-transfer-to-member\"";

                        echo "</script>";
                    }
                    else
                    {
                        $error = "You Can Transfer Only $pin_num E-pin !!";
                    }
                }
                else
                {
                    $error = "Please Enter Correct Number to Transfer !!";
                }
            }
        }
        else
        {
            $error = "Please enter correct Transaction Password !";
        }
    }
}

$query = mysql_query("select * from e_pin where user_id = '$id' and mode = 1 ");

$num = mysql_num_rows($query);

if ($num != 0)
{

    $msg = $_REQUEST[mg];
    echo $msg;
    ?> 



    <div class="box box-primary" style="padding: 15px"> 
        <div class="box-header">
            <h3 class="box-title">e-PIN transfer to member:</h3>
            <p style="color:#FF0000;"><?= $error ?></p>
        </div>

        <div class="row">
            <div class="col-sm-12 text-center"><label class="control-label" style="font-size: 20px; border-radius:2px;background-color:#11BC15;color:#fff;padding:12px 30px;">Total e-PIN: <?= $num; ?></label></div>
        </div>
        <div class="row" style="margin:25px 0">
            <div class="col-ld-10 col-lg-offset-1 col-md-10 col-md-offset-1 col-sm-12 col-sm-offset-0 col-xs-12">
                <form class="form form-epin" name="money" action="" method="post">
                    <div class="row">
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label class="col-md-4 col-sm-12 col-xs-12 control-label">No of E-pin: </label>
                                <div class="col-md-8 col-sm-12 col-xs-12">
                                    <input type="text" name="pin_no" class="form-control" >
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label class="col-md-4 col-sm-12 col-xs-12 control-label">Requested Username: </label>
                                <div class="col-md-8 col-sm-12 col-xs-12">
                                    <input type="text" name="requested_user" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label class="col-md-4 col-sm-12 col-xs-12 control-label">Security Password:  </label>
                                <div class="col-md-8 col-sm-12 col-xs-12">
                                    <input type="text" name="user_pin" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <button type="submit" name="submit" class="btn btn-primary" style="padding:12px">Tranfer e-PIN</button>
                                </div>
                            </div>
                        </div>
                    </div>







                </form>
            </div>    
        </div>



    </div>



    <?php
}
else
{
    echo "<B style=\"color:#FF0000;\">You Have No Unused Epin to transfer !</B>";
}
?>



<div class="box box-primary" style="padding: 15px"> 
    <div class="box-header"><h3 class="box-title">e-PIN transfer history</h3></div>


    <?php
    $sql = "SELECT t1.*,t2.epin,t2.amount FROM epin_history t1 LEFT JOIN e_pin t2 on t1.epin_id = t2.id WHERE t1.user_id = '$id' group by t2.date,t2.user_id ORDER BY t1.history_id DESC";

    $query = mysql_query($sql);

    $num = mysql_num_rows($query);

    if ($num > 0)
    {
        ?>

        <table class="table table-bordered">

            <tr>

                <th>Date</th>

                <th>Sender</th>

                <th>Receiver</th>

                <th>Number of e-PINs transferred</th>
            </tr>

            <?php
            while ($row = mysql_fetch_array($query))
            {

                $epin = $row['epin'];

                $user_id = get_user_name($row['user_id']);

                $transfer_to = get_user_name($row['transfer_to']);

                $date = $row['date'];



                $amount = number_format($row['amount']);

                $date = date('d-m-Y', strtotime($date));
                ?>

                <tr>

                    <td><?= $date; ?></td>              

                    <td><?= $user_id; ?></td>

                    <td><?= $transfer_to; ?></td>

                    <td><?= getCount($row['date'],$row['transfer_to']) ?></td>
                </tr>

                <?php
            }

            print "</table>";
        }
        else
        {
            echo "<B style=\"color:#FF0000; font-size:14px;\">There is no E-pin to show !</B>";
        }
        ?>

</div>

<style>
    .form-epin .form-group {
        margin: 20px 0 !important;
    }
    .form-epin .form-group input[type="text"],.form-epin .form-group input[type="password"]{
        padding: 22px 11px;
        border: 1px solid #3c8dbc;
        border-radius: 5px !important;
        color: #3c8dbc;
        width: 100%;
    }
    table thead tr th, table tbody tr td{
        padding: 10px !important;


    }

</style>