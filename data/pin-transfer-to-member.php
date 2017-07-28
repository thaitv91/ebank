<?php
include("condition.php");

include("function/setting.php");

include("function/send_mail.php");

include("function/functions.php");

include("function/wallet_message.php");

require_once("pagination.php");



$id = $_SESSION['ebank_user_id'];

$position = $_SESSION['position'];

function getCount($date)
{
    return mysql_num_rows(mysql_query("select * from epin_history where date = '$date'"));
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

        $error = "Please enter correct Username !";
    }
    else
    {

        $query = mysql_query("select * from users where id_user = '$id' and user_pin = '$user_pin' ");

        $num = mysql_num_rows($query);

        if ($num > 0)
        {



            if ($id == $requested_user_id)
            {
                echo $error = "You cannot transfer to yourself.";
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



                            /* $message = "Registration e-PIN is successfully transferred to you.";

                              $phone = get_user_phone($requested_user_id);

                              send_sms($phone,$message); */
                        }

                        $sqlkk = "update epin_request set num_of_pin='$pin_no' where epin_id='$epin_ids'";

                        mysql_query($sqlkk);



                        /* $time = date('Y-m-d H:i:s');

                          $sqlss = "insert into epin_request (generate_by, epin_for , num_of_pin , mode , date , time , epin_type , comment , epin_id , process_datetime) values ('$id' , '$requested_user_id' ,'$pin_no' , 1 , '$request_date' , '$time' , '$epin_type' , '$comment' , '0' , '$time')";

                          mysql_query($sqlss); */



                        $_SESSION['epin_success'] = "<B style=\"color:#008000;\">You request of transfer Ticket " . $request_pin . " has completed successfully !!</B>";

                        echo "<script type=\"text/javascript\">";

                        echo "window.location = \"index.php?page=pin-transfer-to-member\"";

                        echo "</script>";
                    }
                    else
                    {
                        $error = "You can transfer only $pin_num Ticket.";
                    }
                }
                else
                {
                    $error = "Please enter correct number to Transfer.";
                }
            }
        }
        else
        {
            $error = "Please enter correct Security Code!";
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
            <h3 class="box-title">Ticket transfer to member:</h3>
            <p style="color:#FF0000;"><?= $error ?></p>
        </div>

        <div class="row">
            <div class="col-sm-12 text-center"><label class="control-label" style="font-size: 20px; border-radius:2px;background-color:#11BC15;color:#fff;padding:12px 30px;">Total Ticket available: <?= $num; ?></label></div>
        </div>
        <div class="row" style="margin:25px 0">
            <div class="col-ld-10 col-lg-offset-1 col-md-10 col-md-offset-1 col-sm-12 col-sm-offset-0 col-xs-12">
                <form class="form form-epin" name="money" action="" method="post">
                    <div class="row">
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label class="col-md-4 col-sm-12 col-xs-12 control-label">No of Ticket: </label>
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
                                <label class="col-md-4 col-sm-12 col-xs-12 control-label">Security Code:  </label>
                                <div class="col-md-8 col-sm-12 col-xs-12">
                                    <input type="password" name="user_pin" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <button type="submit" name="submit" class="btn btn-primary" style="padding:12px">Transfer Ticket</button>
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
    echo "<B style=\"color:#FF0000;\">You have no unused Ticket to transfer!</B>";
}
?>



<div class="box box-primary" style="padding: 15px"> 
    <div class="box-header"><h3 class="box-title">Ticket transfer history</h3></div>


    <?php
    $limit = 10;
    $limit_count = isset($_GET['p']) ? ($_GET['p']-1)*$limit-1 : 0 * $limit;
    $paging = new Pagination();
    $count_row = mysql_num_rows(mysql_query("SELECT COUNT(*) as count, user_id,  transfer_to, date FROM epin_history WHERE user_id = $id AND mode = 0 GROUP BY date,transfer_to"));

    $sql = mysql_query("SELECT COUNT(*) as count, user_id,  transfer_to, date FROM epin_history WHERE user_id = $id AND mode = 0 GROUP BY date,transfer_to order by date DESC  LIMIT $limit_count,$limit");

    $num = mysql_num_rows($sql);

    if ($num > 0)
    {
        ?>

        <table class="table table-bordered">

            <tr>

                <th width="25%">Date</th>

                <th width="25%">Sender</th>

                <th width="25%">Receiver</th>

                <th width="25%">Number of Ticket transferred</th>
            </tr>

            <?php
            while ($row = mysql_fetch_array($sql))
            {
                ?>

                <tr>

                    <td><?=date("d-m-Y", strtotime($row['date']) ) ; ?></td>              

                    <td><?=get_user_name($row['user_id']);?></td>

                    <td><?=get_user_name($row['transfer_to']); ?></td>

                    <td><?=$row['count'];?></td>
                </tr>

                <?php
            }?>

        </table>
        <?php
            $config = array(
                'current_page' => isset($_GET['p']) ? $_GET['p'] : 1, // Trang hiện tại
                'total_record' => $count_row, // Tổng số record
                'limit' => $limit, // limit
                'link_full' => 'index.php?page=pin-transfer-to-member&p={page}', // Link full có dạng như sau: domain/com/page/{page}
                'link_first' => 'index.php?page=pin-transfer-to-member', // Link trang đầu tiên
                'range' => 9 // Số button trang bạn muốn hiển thị
            );
            $paging->init($config);
            echo $paging->html();
        ?>
<?php
        }
        else
        {
            echo "<B style=\"color:#FF0000; font-size:14px;\">There is no Ticket to show !</B>";
        }
        ?>

</div>

<style>
    .form-epin .form-group {
        margin: 20px 0 !important;
    }
    .form-epin .form-group input[type="text"],.form-epin .form-group input[type="password"]{
        padding: 5 11px;
        border: 1px solid #3c8dbc;
        border-radius: 5px !important;
        color: #3c8dbc;
        width: 100%;
		height:45px;
    }
    table tbody tr th, table tbody tr td{
        padding: 10px !important;
        text-align: center;

    }

</style>