<?php
    ini_set('display_errors','off');
    session_start();
    include "../config.php";
    include('../function/setting.php');
    include('../function/functions.php');


    $user_id = $_SESSION['ebank_user_id'];
    $id_report = $_GET['id'];
    $date = date('Y-m-d H:i:s');

	$uploadfolder = $path;
    $uploadfolder = $uploadfolder . "/images/block_pay_receipt/";

    $report_query = mysql_query("SELECT * FROM report WHERE id = $id_report");
    $row_report   = mysql_fetch_array($report_query);


    $err_file = '';
    if (!empty($_POST['confirm']))
    {

        if (($_POST['btc_address'] == "") and ( $_FILES["file"]["name"] == ""))
        {
            $err_file = 'Error: Please upload a payment receipt or enter your BTC address!';
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
            mysql_query("UPDATE report SET file = '$photo', btc_address = '$btc_address' , date_pay = '$date'  where id = '$id_report'");
            $modal = 'ok';
        }
    }
    ?>
<div class="box box-primary">
<div id="wrap">
    <div class="row">
	<div class="col-md-12" style="padding:15px 0 15px 15px;">
        <form class="form-horizontal form-epin"  action="" method="post" enctype="multipart/form-data">
            <div class="col-md-6 col-sm-12">

                <table class="table table-bordered table-epin">
                    <thead>
                        <tr>
                            <th>Amount</th>
                            <th>Bitcoin</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>$<?= $row_report['usd'] ?></td>
                            <td><?= $row_report['bitcoin'] ?></td>
                        </tr>
                    </tbody>
                </table>
                <div class="form-group">
                    <label class="col-md-4 col-sm-12 col-xs-12 control-label">Attach your payment receipt</label>
                    <div class="col-md-5 col-sm-12 col-xs-12">
                        <label for="file-upload" class="custom-file-upload">
                            <i class="fa fa-cloud-upload"></i> Custom Upload
                        </label>
                        <input id="file-upload" type="file" name="file"/>
                    </div>

                </div>
                <div class="form-group">
                    <label class="col-md-4 col-sm-12 col-xs-12 control-label">Or enter your BTC Address</label>
                    <div class="col-md-8 col-sm-12 col-xs-12"><input type="text" class="form-control" name="btc_address"></div>
                </div>
                <p style="color: #ff0000"><?= $err_file ?></p>
                <p><STRONG>ATTENTION:</STRONG> <?=$alert_report[4]?></p>

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
                                            <div id="qrcode_input" class="form-control">13c3heZzgctorHDHaHvXt9QVt9A4dg7N8a</div>
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
            </div>
            <div class="col-sm-12 text-center">
                <input type="submit" class="btn btn-primary" style="font-size:18px" name="confirm" value="Confirm Your Payment">
            </div>
        </form>
    </div>
	</div>
	</div>
</div>	


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
                <div class="modal-body">
                    <div class="modal-epin text-center">
                        <p><img src="images/payment_active.png"></p>
                        <h3 class="test">THANK YOU FOR YOUR PAYMENT</h3>
                        <P>Your payment will be processed within 12 hours.</P>
                        <p>  <a class="btn btn-success" href="index.php">Close</a></p>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <?php
}
?>   
<script src="/js/clipboard.min.js"></script>
<script>
    var clipboard = new Clipboard('.btn-copy');

    clipboard.on('success', function(e) {
        console.log(e);
    });

    clipboard.on('error', function(e) {
        console.log(e);
    });
</script>

    <style type="text/css">
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
        .qrcode-img{ text-align: center;}
        .line-sm{display: block; text-align: center;}
        @media screen and (max-width: 768px) {
            .line-md{display: none;}
            .line-sm{display: block; text-align: center;}
            .qrcode-img{ text-align: center;}
            .form-control{width: 100%;}
            .control-label{text-align: left !important; margin-bottom: 10px !important;}
        }
		.table>tbody>tr>td, .table>tbody>tr>th, .table>thead:first-child>tr:first-child>th{padding:10px;}

    </style>