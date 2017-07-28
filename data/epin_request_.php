<?php
session_start();

include("condition.php");

include("function/setting.php");

include("function/e_pin.php");

include("function/functions.php");

include("function/send_mail.php");

require_once("pagination.php");
$user_id = $_SESSION['ebank_user_id'];



$allowedfiletypes = array("jpg", "png");

$uploadfolder = $path;

$uploadfolder = $uploadfolder . "/images/epin_pay_receipt/";



$sys_limit = epin_per_day_limit();

$tot_epin_req_day = tot_epin_request_day($systems_date);

$err_epin = '';
$modal = '';
if ($_GET['act'] == 'confirm')
{
    $ep_id = $_GET['id'];
    $epin_query = mysql_query("select * from epin_request where id = '$ep_id' and active =0");
    while ($row = mysql_fetch_array($epin_query))
    {
        $epin_array = $row;
    }
    if (count($epin_array) > 0)
    {
        $err_file = '';
        if (!empty($_POST['confirm']))
        {

            if (($_POST['btc_address'] == "") and ( $_FILES["file"]["name"] == ""))
            {
                $err_file = 'Ban chua upload file hoặc chưa nhập địa chỉ người gởi bitvoin!';
            }
            else
            {
                $photo = '';
                $btc_address = $_POST['btc_address'];
                if (!empty($_FILES['file']))
                {
                    $fileext = strtolower(substr($_FILES["file"]["name"], strrpos($_FILES["file"]["name"], ".") + 1));
                    $name = "CDBV_EP" . time() . '.' . $fileext;
                    $target_file = $uploadfolder . $name;
                    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file))
                        $photo = $name;
                }
                mysql_query("update epin_request set active = 1 , photo = '$photo', btc_address='$btc_address'  where id = '$ep_id'");
                $modal = 'ok';
            }
        }
        ?>
       <div class="box box-primary" style="padding: 15px">
        <div class="row">

            <form class="form-horizontal form-epin"  action="" method="post" enctype="multipart/form-data">
                <div class="col-sm-6">

                    <table class="table table-bordered table-epin">
                        <thead>
                            <tr>
                                <th>E-pin number</th>
                                <th>Price</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?= $epin_array['no_pin'] ?></td>
                                <td>$5.00</td>
                                <td>$<?= $epin_array['plan_id'] ?>.00</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="text-align:right; font-weight: bold">Sub Total</td>
                                <td><strong><?= $epin_array['plan_id'] ?>.00 USD</strong><br><strong><?= $epin_array['btc'] ?> BTC </strong></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Attach your file here</label>
                        <div class="col-sm-3"><input type="file" class="col-sm-12 form-control" name="file" style="border: 1px solid #ccc; color: #333"></div>

                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Or enter BTC Address</label>
                        <div class="col-sm-9"><input type="text" class="col-sm-12 form-control" name="btc_address" style="border: 1px solid #ccc; padding: 6px 12px"></div>
                    </div>
                    <p style="color: #ff0000"><?= $err_file ?></p>
                    <p>Sau khi chuyển thành công Bitcoin đến <strong>13c3heZzgctorHDHaHvXt9QVt9A4dg7N8a</strong> bạn vui lòng gởi file đính kèm để hoàn thành mua e-Pin. Giao dịch sẽ được xử lý trong 12 giờ.</p>

                </div>
                <div class="col-sm-6">
                    <div class="well well-epin">
                        <h4>Receive Bitcoint</h4>
                        <p>A new address has been created for you to share with others in order to receive bitcoins.</p>
                        <div class="row">
                            <div class="col-sm-10 col-lg-offset-1">
                                <div class="row">
                                    <div class="col-sm-7 content-code">
                                        <p>Send exactly <strong><?= $epin_array['btc'] ?> BTC</strong> to this address:</p>
                                        <p class="qrcode">
                                            <span><img src="images/icon-qrcode.png"></span>
                                            <span>13c3heZzgctorHDHaHvXt9QVt9A4dg7N8a</span>
                                        </p>

                                        <p><button class="btn btn-default">Copy address</button></p>
                                    </div>
                                    <div class="col-sm-1">
                                        <img src="images/bg-or.png">
                                    </div>
                                    <div class="col-sm-3">
                                        <img src="images/qrcode.png" style="margin-top:15px">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-sm-12 col-lg-offset-5">
                    <input type="submit" class="btn btn-primary col-sm-2" style="font-size:18px" name="confirm" value="Confirm your payment">
                </div>
            </form>
        </div>
       </div>
        <?php
    }
    else
    {
        echo "<script type=\"text/javascript\">";

        echo "window.location = \"index.php?page=epin_request\"";

        echo "</script>";
    }
}
else
{
    if (!empty($_POST['ebuy']))
    {

        $no_pin = $_POST['txtepin'];
        $user_pin = $_POST['user_epin'];
        if (empty($no_pin) or $no_pin < 1)
        {
            $err_epin = 'Error không được rỗng hoặc phải lớn hơn 0';
        }
        else if (empty($user_pin))
        {
            $err_user_epin = 'User Epin không được rỗng';
        }
        else
        {
            $date = date('Y-m-d H:i:s', time());
            $pland_id = $_POST['txtusd'];
            $btc = $_POST['txtbtc'];
            $user = mysql_num_rows(mysql_query("select * from users where id_user = '$user_id' and user_pin ='$user_pin'"));
            if ($user > 0)
            {

                $sql = mysql_query("insert into epin_request (user_id, plan_id ,no_pin,date,btc) values ('$user_id' ,'$pland_id','$no_pin','$date','$btc')");
                $id = mysql_insert_id();
                echo "<script type=\"text/javascript\">";

                echo "window.location = \"index.php?page=epin_request&act=confirm&id=$id\"";

                echo "</script>";
            }
            else
            {
                $err_user_epin = 'User Epin không đúng';
            }
        }
    }
    ?>


    <div class="box box-primary" style="padding-bottom: 20px">
        <div class="box-header"><h3 class="box-title">Buy e-PIN</h3></div>
        <form class="form-horizontal form-epin"  action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label class="col-sm-3 control-label">Chọn gói e-Pin bạn muốn mua</label>
                <div class="col-sm-9 epin-radio">
                    <label class="radio-inline">
                        <img src="images/5epin.png"><br>
                        <input type="radio" name="epin1" value="5">
                    </label>
                    <label class="radio-inline">
                        <img src="images/10epin.png"><br>
                        <input type="radio" name="epin1" value="10">
                    </label>
                    <label class="radio-inline">
                        <img src="images/15epin.png"><br>
                        <input type="radio" name="epin1" value="15">
                    </label>
                    <label class="radio-inline">
                        <img src="images/20epin.png"><br>
                        <input type="radio" name="epin1" value="20">
                    </label>
                    <label class="radio-inline">
                        <img src="images/25epin.png"><br>
                        <input type="radio" name="epin1" value="25">
                    </label>
                    <label class="radio-inline">
                        <img src="images/30epin.png"><br>
                        <input type="radio"  name="epin1" value="30">
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Hãy nhập số lượng bạn cần muốn mua</label>
                <div class="col-sm-9">
                    <div class="row">
                        <div class="col-sm-1"> <input type="text" name="txtepin" id="txtepin" class="form-control col-sm-12" value="0"></div>
                        <div class="col-sm-1 epin-text"> <span>e-Pin</span></div>
                        <div class="col-sm-2"> <label class="col-sm-3 epin-label">=</label><input type="text" id="txtusd" name="txtusd" class="form-control col-sm-9" value="0"></div>
                        <div class="col-sm-1 epin-text">USD </div>
                        <div class="col-sm-2"> <label class="col-sm-3 epin-label">=</label><input type="text" id="txtbtc" name="txtbtc" class="form-control col-sm-9" value="0"></div>
                        <div class="col-sm-1 epin-text">BTC</div>
                        <div class="col-sm-12"> <p style="color: #ff0000"><?= $err_epin ?></p></div>
                    </div>

                </div>
            </div>
            <div id="mining_profit_crypt_conv" style="display:none">
                <span class="crypt-side dis-inl">
                    <input class="val_btc val-crypt" type="text" value="-">
                    <span class="cr-label dis-inl">BTC</span></span>
                <span class="equal-course">=</span><span class="course-side dis-inl">
                    <input class="val_course val-crypt" type="text" id="btcusd" value="---">
                </span></div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Enter Security Code</label>
                <div class="col-sm-9">
                    <div class="row">
                        <div class="col-sm-2"> <input type="password" name="user_epin" class="form-control col-sm-12"><p style="color: #ff0000"><?= $err_user_epin ?></p></div>
                        <div class="col-sm-4"> <input type="submit" name="ebuy" class="btn btn-primary col-sm-12" value="SUBMIT"></div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="row">


        <div class="col-sm-6">
            <div class="box box-primary" style="padding: 15px">
                <div class="box-header"><h3 class="box-title">Used e-PIN</h3></div>
                <?php
                $limit = 10;
                $limit_count = isset($_GET['p']) ? $_GET['p'] : 0 * $limit;
                $paging = new Pagination();
                $count_used_epin = mysql_num_rows(mysql_query("select * from e_pin where user_id = '$user_id' and mode = 1"));
                $used_epin = mysql_query("SELECT * FROM e_pin where user_id = '$user_id' and mode = 1 ORDER BY id DESC  LIMIT $limit_count,$limit");
                ?>
                <table class="table table-bordered table-epin" style="background-color: #fff">
                    <thead>
                        <tr>
                            <th>E-pin</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        while ($row = mysql_fetch_array($used_epin))
                        {
                            ?>
                            <tr>
                                <td><?= $row['epin'] ?></td>
                                <td><?= date('d/M/Y', strtotime($row['date'])) ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <?php
                $config = array(
                    'current_page' => isset($_GET['p']) ? $_GET['p'] : 1, // Trang hiện tại
                    'total_record' => $count_used_epin, // Tổng số record
                    'limit' => $limit, // limit
                    'link_full' => 'index.php?page=epin_request&mode=1&p={page}', // Link full có dạng như sau: domain/com/page/{page}
                    'link_first' => 'index.php?page=epin_request&mode=1', // Link trang đầu tiên
                    'range' => 9 // Số button trang bạn muốn hiển thị
                );
                $paging->init($config);
                echo $paging->html();
                ?>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="box box-primary" style="padding: 15px">
                <div class="box-header"><h3 class="box-title">Buy e-PIN</h3></div>
                <?php
                $buy_epin = mysql_query("select * from e_pin where user_id = '$user_id' and mode = 0");
                ?>
                <table class="table table-bordered table-epin" style=" background-color: #fff">
                    <thead>
                        <tr>
                            <th>E-pin</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = mysql_fetch_array($buy_epin))
                        {
                            ?>
                            <tr>
                                <td><?= $row['epin'] ?></td>
                                <td><?= date('d/M/Y', strtotime($row['date'])) ?></td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
                <?php
//                $config1 = array(
//                    'current_page' => isset($_GET['p']) ? $_GET['p'] : 1, // Trang hiện tại
//                    'total_record' => $count, // Tổng số record
//                    'limit' => $limit, // limit
//                    'link_full' => 'index.php?page=epin_request$mode=0&p={page}', // Link full có dạng như sau: domain/com/page/{page}
//                    'link_first' => 'index.php?page=epin_request$mode=0', // Link trang đầu tiên
//                    'range' => 9 // Số button trang bạn muốn hiển thị
//                );
//                $paging->init($config1);
//                echo $paging->html();
                ?>
            </div>
        </div>
    </div>
    <?php
}
?>
<style>
    .form-epin .form-group {
        margin-bottom: 25px;
    }
    .form-epin .form-group input[type="text"],.form-epin .form-group input[type="password"],.form-epin .form-group input[type="file"]{
        min-height: 45px;
        border: 1px solid #3c8dbc;
        border-radius: 5px !important;
        color: #3c8dbc;
        font-size: 18px
    }
    .form-epin .form-group input[type="submit"]{
        min-height: 45px;
        background-color: #3c8dbc;
        border: 0;
        font-size: 18px
    }
    .form-epin .form-group .epin-text{
        padding: 6px;
        background-color: #3c8dbc;
        border-radius: 5px !important;
        color: #fff;;
        font-size: 24px;
        text-align: center;
    }
    .form-epin .form-group .epin-label{
        padding: 6px;
        color: #3c8dbc;;
        font-size: 24px;
        text-align: center;
        font-weight: normal;
        padding-left: 0;
    }
    .epin-radio .radio-inline{
        text-align: center;
        margin-bottom: 20px;
    }
    .epin-radio .radio-inline img{
        margin-bottom: 5px;
    }
    .epin-radio .radio-inline input{
        margin-left: -5px;
    }
    .table-epin{
        border-radius: 5px !important;
    }
    .table-epin tr th, .table-epin tr td{
        padding: 8px !important;
        text-align: center

    }
    .modal-epin{
        text-align: center
    }
    .modal-epin .test{
        font-size: 36px;
        border-bottom: 1px solid #DDD;
        color: #008000;
    }
    .well-epin{
        background-color: #fff;
        padding: 10px 20px;
    }
    .qrcode{
        background: #f5f7f9;
        padding: 0;
    }
    .content-code p{
        margin-bottom: 20px !important
    }
</style>
<?php
if ($modal == 'ok')
{
    ?>
    <script>
        $(document).ready(function () {
            $("#myModal").modal();
        });
    </script>
    <div class="modal fade" tabindex="-1" role="dialog" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!--            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Modal title</h4>
                            </div>-->
                <div class="modal-body">
                    <div class="modal-epin">
                        <p><img src="images/payment_active.png"></p>
                        <p class="test">THANK YOU FOR PAYMENT</p>
                        <P>Vui long cho trong vong 12 gio de nhan e-PIN</P>
                        <!--<p>  <a href="javascript:void(0)" data-dismiss="modal" aria-label="Close">Close</a></p>-->
                        <p>  <a href="index.php?page=epin_request" data-dismiss="modal" aria-label="Close">Close</a></p>
                    </div>
                </div>
                <!--            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary">Save changes</button>
                            </div>-->
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <?php
}
?>
<script>

    $("document").ready(
            function () {
                $(".epin-radio input:radio").click(
                        function () {
                            var btcusd = (parseInt($(this).val()) * 5) / parseInt($('#btcusd').val());
                            $('#txtepin').val($(this).val());
                            $('#txtusd').val(parseInt($(this).val()) * 5);
                            $('#txtbtc').val(btcusd.toFixed(4));
                        }
                );
            }
    );
    $("#txtepin").keyup(function (event) {
        var txtusd = parseInt($(this).val()) * 5;
        var txtbtc = (parseInt($(this).val()) * 5) / parseInt($('#btcusd').val()) + parseInt(0.0001);
        $('#txtusd').val(txtusd);
        $('#txtbtc').val(txtbtc.toFixed(2));
    })</script>