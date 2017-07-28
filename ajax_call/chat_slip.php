<?php
ini_set('display_errors','off');
session_start();
include "../config.php";
$p = $_REQUEST['p'];
$r = $_REQUEST['r'];
$s = $_REQUEST['s'];
$sql = "select username from users where id_user = '$p'";
$query = mysql_query($sql);
$row = mysql_fetch_array($query);
$chat_name = $row[0];
$ts = time();
$date = new DateTime("@$ts");
$chat_open_time = $date->format('Y-m-d H:i:s');
//$_SESSION['chat_open_time'] = $chat_open_time;
if(1)
{
	$color = "#33383d";
	$margin = "Profit";
	$type = 'A';
}
else
{
	$color = "#faa9ba";
	$margin = "Liability";
	$type = 'B';
}

$date = date("Y-m-d");

?>
<script type="text/javascript" src="js/future.js"></script>
<div style="padding: 0 0 10px;color: #41B515;font-size: 20px;font-family: 'Source Sans Pro',sans-serif;font-weight: 500;text-shadow: 0px 0px 0 #FFFFFF;text-align: left;">
	Live On-Line Chat : 
	<span style="color:#6b6b6b; margin-left:5px;"><?php print $chat_name;?></span>
</div>


<div>
<div>

<div id="chat_res" style="overflow: auto; overflow-x: hidden; height:130px;"></div>
<div>

	<input type="hidden" name="s_id" id="s_id" value="<?php print $s; ?>"  />
	<input type="hidden" name="r_id" id="r_id" value="<?php print $p; ?>"  />
	<input type="hidden" name="date" id="date"value="<?php print $date; ?>"  />

<table style="text-shadow:0px 0px 0 #FFFFFF;" width="100%" border="0" cellpadding="3" cellspacing="0"> 
	<tbody>
	<tr>
		<td style="color:#333; font-size:12px; padding-left:0px;" colspan="2" valign="top" align="left">
			<div id="msg_text">
			<textarea name="msg" id="msg" style="width:100%" placeholder="Type Here"></textarea></div>
		</td>
	</tr>
	<tr>
		<td colspan="2" valign="top">
		<p id="#alert_id"></p>
			<input type="submit" name="submit" id="chat_submit" value="Send" class="btn btn-info">
			<input name="Close" value="Close" onClick="CloseChatWindow();" type="button" class="btn btn-default closer-chat">
			<span class="btn btn-success btn-file">
		        <i class="fa fa-paperclip" aria-hidden="true"></i><input id="attachment_chat" data-id="<?=$p?>" type='file' onchange='getFilename(this)'/>
		    </span>
		</td>
	</tr>
	</tbody>
</table>
</div>

</div>
<!--<div style="background-color:<?php print $color;?>; color:#000; padding:10px; height:180px; font-size:16px; display:none" id="successMessage"><br>
	<input name="Close" value="Close" onClick="CloseBetWindow();" type="button">
</div>-->
</div>

<STYLE TYPE="text/css">
	    .btn-file {
        position: relative;
        overflow: hidden;
    }
    .btn-file input[type=file] {
        position: absolute;
        top: 0;
        right: 0;
        min-width: 100%;
        min-height: 100%;
        font-size: 100px;
        text-align: right;
        filter: alpha(opacity=0);
        opacity: 0;
        outline: none;
        background: white;
        cursor: inherit;
        display: block;
    }
</STYLE>