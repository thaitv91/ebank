<?php
session_start();

include("condition.php");

include("function/setting.php");

include("function/e_pin.php");

include("function/functions.php");

include("function/send_mail.php");

require_once("pagination.php");



$user_id = $_SESSION['ebank_user_id'];

function getCount($user_id, $date, $mode)
{
   if ($mode == 1)
        return mysql_num_rows(mysql_query("select * from e_pin where user_id=$user_id and date = '$date'"));
    else
        return mysql_num_rows(mysql_query("select * from e_pin where user_id=$user_id and date = '$date' and mode ='$mode'"));
}

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
                $err_file = 'Please upload your payment receipt or enter your BTC address.';
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

                echo '<script>$(document).ready(function () {
                        // Handler for .ready() called.
                        window.setTimeout(function () {
                            location.href = "/index.php?page=epin_request";
                        }, 5000);
                    });</script>';
            }
        }
        ?>
        <div class="box box-primary" style="padding: 15px">
            <div class="row">

                <form class="form-horizontal form-epin"  action="" method="post" enctype="multipart/form-data">
                    <div class="col-md-6 col-sm-12">

                        <table class="table table-bordered table-epin">
                            <thead>
                                <tr>
                                    <th>Number of e-PINs</th>
                                    <th>Price</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?= $epin_array['no_pin'] ?></td>
                                    <td>$12.00</td>
                                    <td>$<?= $epin_array['plan_id'] ?>.00</td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="text-align:right; font-weight: bold">Sub Total</td>
                                    <td><strong><?= $epin_array['plan_id'] ?>.00 USD</strong><br><strong><?= $epin_array['btc'] ?> BTC </strong></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-group">
                            <label class="col-md-4 col-sm-12 col-xs-12 control-label">Attach your payment receipt</label>
                            <div class="col-md-5 col-sm-12 col-xs-12">
                                <label for="file-upload" class="custom-file-upload">
                                    <i class="fa fa-cloud-upload"></i> Custom Upload
                                </label>
                                <!-- <input id="file-upload" type="file" name="file"/> -->
                                <input id="file-upload" type="file" name="file">
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="col-md-4 col-sm-12 col-xs-12 control-label">Or enter your BTC address</label>
                            <div class="col-md-8 col-sm-12 col-xs-12"><input type="text" class="col-sm-12 form-control" name="btc_address" style="border: 1px solid #ccc; padding: 6px 12px"></div>
                        </div>
                        <p style="color: #ff0000"><?= $err_file ?></p>
                        <p>After sending the payment to <strong>3NrBXaecWGSTqNzzUnGPEP5huwhvdWTjqV</strong> (our Bitcoin address), please either upload your payment receipt or enter your Bitcoint address used to send the payment in the box above. You will receive e-PINs within 12 hours.</p>

                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="well well-epin">
                            <h4>Bitcoin Payment Details</h4>
                            <p>Please copy the BTC address or scan the QR code below to send BTC</p>
                            <div class="row">
                                <div class="col-sm-12 col-sx-12">
                                    <div class="row">
                                        <div class="col-sm-12 col-xs-12 content-code">
                                            <p>Send exactly <strong><?= $epin_array['btc'] ?> BTC</strong> to this address:</p>
                                            <p class="qrcode">
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="fa fa-building-o fa-rotate-180" aria-hidden="true"></i></div>
                                                <div id="qrcode_input" class="form-control">3NrBXaecWGSTqNzzUnGPEP5huwhvdWTjqV</div>
                                            </div>
                                            </p>

                                            <p><a href="javascript:;" class="btn btn-copy btn-default" data-clipboard-action="copy" data-clipboard-target="#qrcode_input" >Copy address</a></p>
                                        </div>
                                        <div class="col-sm-12 line-sm">
                                            <img src="images/2222.png">
                                        </div>
                                        <div class="col-sm-12 col-xs-12 qrcode-img">
                                            <img src="images/qrcode.png" style="margin-top:15px">
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>


                        <!-- <div class="well well-epin">
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

                        </div> -->
                    </div>
                    <div class="col-sm-12 col-lg-offset-5">
                        <input type="submit" class="btn btn-primary" style="font-size:18px" name="confirm" value="Confirm your payment">
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
            $err_epin = 'Please select a e-PIN package or enter e-PIN amount';
        }
        else if (empty($user_pin))
        {
            $err_user_epin = 'Please enter Security Code';
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
                $err_user_epin = 'Security Code is incorrect';
            }
        }
    }
    ?>


    <div class="box box-primary" style="padding-bottom: 20px">
        <div class="box-header"><h3 class="box-title">Buy Ticket</h3></div>
        <form class="form-inline form-epin"  action="" method="post" enctype="multipart/form-data">
            <div class="col-lg-9 col-lg-offset-1 col-md-10 col-md-offset-1 col-sm-12 col-sm-offset-0 col-xs-12">
                <div class="row">
                    <div class="form-group">
                        <label class="col-md-3 col-sm-12 col-xs-12 control-label">Select an Ticket package</label>
                        <div class="col-md-9 col-sm-12 col-xs-12 epin-radio">
                            <div class="row">
                                <div class="col-md-2 col-sm-4 col-xs-6 text-center">
                                    <img src="images/5epin.png"><br>
                                    <input type="radio" name="epin1" value="5">
                                </div>
                                <div class="col-md-2 col-sm-4 col-xs-6 text-center">
                                    <img src="images/10epin.png"><br>
                                    <input type="radio" name="epin1" value="10">
                                </div>
                                <div class="col-md-2 col-sm-4 col-xs-6 text-center">
                                    <img src="images/15epin.png"><br>
                                    <input type="radio" name="epin1" value="15">
                                </div>
                                <div class="col-md-2 col-sm-4 col-xs-6 text-center">
                                    <img src="images/20epin.png"><br>
                                    <input type="radio" name="epin1" value="20">
                                </div>
                                <div class="col-md-2 col-sm-4 col-xs-6 text-center">
                                    <img src="images/25epin.png"><br>
                                    <input type="radio" name="epin1" value="25">
                                </div>
                                <div class="col-md-2 col-sm-4 col-xs-6 text-center">
                                    <img src="images/30epin.png"><br>
                                    <input type="radio"  name="epin1" value="30">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 col-sm-12 col-xs-12 control-label">Enter Ticket amount</label>
                        <div class="col-md-9 col-sm-12 col-xs-12">
                            <div class="row">
                                <div class="col-md-2 col-sm-9 col-xs-9 epin-field">
                                    <input type="text" name="txtepin" id="txtepin" class="form-control" value="0">
                                </div>
                                <div class="col-md-2 col-sm-3 col-xs-3 epin-field">
                                    <label class="epin-text">Ticket</label>
                                </div>
                                <div class="col-md-2 col-sm-9 col-xs-9 epin-field">
                                    <input type="text" id="txtusd" name="txtusd" class="form-control" value="0">
                                </div>
                                <div class="col-md-2 col-sm-3 col-xs-3 epin-field">
                                    <label class="epin-text">USD</label>
                                </div>
                                <div class="col-md-2 col-sm-9 col-xs-9 epin-field">
                                    <input type="text" id="txtbtc" name="txtbtc" class="form-control" value="0">
                                </div>
                                <div class="col-md-2 col-sm-3 col-xs-3 epin-field">
                                    <label class="epin-text">BTC</label>
                                </div>
                                <p style="color: #ff0000"><?= $err_epin ?></p>
                            </div>
                        </div>
                    </div>
                    <br>

                    <div id="mining_profit_crypt_conv" style="display:none">
                        <span class="crypt-side dis-inl">
                            <input class="val_btc val-crypt" type="text" value="-">
                            <span class="cr-label dis-inl">BTC</span></span>
                        <span class="equal-course">=</span><span class="course-side dis-inl">
                            <input class="val_course val-crypt" type="text" id="btcusd" value="---">
                        </span>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 col-sm-12 col-xs-12 control-label">Enter Security Code</label>
                        <div class="col-md-9 col-sm-12 col-xs-12">
                            <div class="row">
                                <div class="col-md-4 col-sm-6 col-xs-12"> <input type="password" name="user_epin" class="form-control"><p style="color: #ff0000"><?= $err_user_epin ?></p></div>
                                <div class="col-md-4 col-sm-6 col-xs-12"> <input type="submit" name="ebuy" class="btn btn-primary btn-submit-epin" value="SUBMIT"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div style="clear:both"></div>
        </form>
    </div>
    <div class="row">


        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="box box-primary" style="padding: 15px">
                <div class="box-header"><h3 class="box-title">Ticket history</h3></div>
                <?php
                $used_epin = mysql_query("SELECT date, 
                            count(*) total, 
                            sum(case when mode = 0 and user_id = $user_id then 1 else 0 end) Transfer_epin, 
                            sum(case when mode = 0 and transfer_to = $user_id then 1 else 0 end) Received_epin,
                            sum(case when mode = 1 and user_id = $user_id then 1 else 0 end) Request_epin,
                            sum(case when mode = 2 and user_id = $user_id then 1 else 0 end) Pd_epin
                            from epin_history 
                            group by date ORDER BY date DESC ");   							
                ?>
	<input type='hidden' id='current_page' />
                <input type='hidden' id='show_per_page' />
                <table id="content_pagenavigation" class="table table-bordered table-epin" style="background-color: #fff">
                    <thead>
                        <tr>
                            <th width="25%">Date</th>
                            <th width="25%">Number of Ticket Received</th>
                            <th width="25%">Number of Ticket Used</th>
                            <th width="25%">Number of Ticket Transferred</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                       // var_dump(mysql_fetch_array($used_epin)); exit;
                        while ($row = mysql_fetch_array($used_epin))
                        {
                           if( (empty($row['Received_epin'])) && (empty($row['Pd_epin'])) && (empty($row['Transfer_epin'])) && (empty($row['Request_epin']))){

                            }else{
                            ?>
                            <tr>
                                <td><?=date("d-m-Y", strtotime($row['date']) ) ?></td>
                                <td><?=$row['Received_epin'] + $row['Request_epin']?></td>
                                <td><?=$row['Pd_epin']?></td>
                                <td><?=$row['Transfer_epin']?></td>
                            </tr>
                        <?php }} ?>
                    </tbody>
                </table>
                <nav><ul class="pagination" id="page_navigation"></ul></nav>
            </div>
        </div>

    </div>
    <?php
}
?>
<style>
    input[type="file"] {
        display: none;
    }
    .custom-file-upload {
        border: 1px solid #0EC31C;
        background-color: #0EC31C;
        color:#fff;
        display: inline-block;
        padding: 6px 12px;
        cursor: pointer;
    }
    .form-control{width: 100%;}
    @media screen and (max-width: 768px) {
        .line-md{display: none;}
        .line-sm{display: block; text-align: center;}
        .qrcode-img{ text-align: center;}
        .form-control{width: 100%;}
        .control-label{text-align: left !important; margin-bottom: 10px !important;}
    }
    .qrcode-img{ text-align: center;}
    .line-sm{display: block; text-align: center;}
    .epin-field{padding-right: 0;}
    .epin-field label{font-weight: 400;}
    .btn-submit-epin{width: 100%;}
    .form-epin .form-group {
        margin-bottom: 25px;
        width: 100%;
    }
    .epin-field-oper{padding: 0;}
    .form-epin .form-group input[type="text"],.form-epin .form-group input[type="password"],.form-epin .form-group input[type="file"]{
        min-height: 45px;
        border: 1px solid #3c8dbc;
        border-radius: 5px !important;
        color: #3c8dbc;
        font-size: 18px;
        width: 100%;
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
    @media screen and (max-width: 1500px  ) and  (min-width: 1200px  ){
        .form-epin .form-group .epin-text{
            padding: 10px;
            font-size: 17px;
        }
    }
    @media screen and (max-width: 1600px  ) and  (min-width: 992px  ){
        .epin-radio img{width: 100%;}
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
                        <p class="test">THANK YOU FOR YOUR PAYMENT</p>
                        <P>You will receive your e-PINs within 12 hours</P>
                        <!--<p>  <a href="javascript:void(0)" data-dismiss="modal" aria-label="Close">Close</a></p>-->
                        <p>  <a class="btn btn-success" href="/index.php?page=epin_request" data-dismiss="modal" aria-label="Close">Close</a></p>
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
<script src="/js/clipboard.min.js"></script>
<script>
    var clipboard = new Clipboard('.btn-copy');

    clipboard.on('success', function (e) {
        console.log(e);
    });

    clipboard.on('error', function (e) {
        console.log(e);
    });
</script>
<script>

    $("document").ready(
            function () {
                $(".epin-radio input:radio").click(
                        function () {
                            var btcusd = (parseInt($(this).val()) * 12) / parseInt($('#btcusd').val());
                            $('#txtepin').val($(this).val());
                            $('#txtusd').val(parseInt($(this).val()) * 12);
                            $('#txtbtc').val(btcusd.toFixed(4));
                        }
                );
            }
    );
    $("#txtepin").keyup(function (event) {
        var txtusd = parseInt($(this).val()) * 12;
        var txtbtc = (parseInt($(this).val()) * 12) / parseInt($('#btcusd').val()) + parseInt(0.0001);
        $('#txtusd').val(txtusd);
        $('#txtbtc').val(txtbtc.toFixed(2));
    })</script>