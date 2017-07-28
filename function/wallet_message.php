<?php
function wallet_transfer_message($send,$username,$amount,$to)
{	
	$date = date('Y-m-d');
	if($send == 1)
	{
		$wallet_message[0] = "User ".$username." has transfered amount $ ".$amount ."  <font color=dark>$ </font> to user ".$to." on ".$date."!";
		$wallet_message[1] = "User ".$to." had received amount of $ ".$amount."  <font color=dark>$ </font> form user ".$username." on ".$date."!";
	}
	if($send != 1)
	{
		if($to == 'mode_2'){ $by = "Alert Pay"; } elseif($to == 'mode_3') {$by = "Liberty"; }
		$wallet_message[0] = "User ".$username." requested to the Admin for transfer amount $ ".$amount ."  <font color=dark>$ </font> on ".$date." by ".$by." !";
	}
	return $wallet_message;
}

function request_approval_message($send,$username,$amount,$to)
{
	$date = date('Y-m-d');
	if($send != 1)
	{
		if($to == 'mode_2'){ $by = "Alert Pay"; } elseif($to == 'mode_3') {$by = "Liberty"; }
		$approval_message = "Admin approved the request of amount $ ".$amount ."  <font color=dark>$ </font> from user ".$username." on ".$date." !";
	}
	return $approval_message;
}	