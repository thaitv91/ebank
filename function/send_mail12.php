<?php
function send_mail($message,$to)
{
	//print $message."<br>"." To ".$to;
	
	$subject = "E-mail From Royal Trader Group";

	@mail($to,$subject,$message);
}

function get_email($id,$message)			
{
	$query = mysql_query("select * from users where id_user = '$id' ");
	while($row = mysql_fetch_array($query))
	{
		$email = $row['email'];
	}
	send_mail($message,$email);
}	

function get_message($field)
{
	$query = mysql_query("select * from setting ");
	while($row = mysql_fetch_array($query))
	{
		$message = $row[$field];
	}
return $message;
}

function get_point_message($user_id,$point,$date)
{
$message = "
			<html>
			<head>
			</head>
			<body>
			<p>This email contains points information!</p>
			<table border=1>
				<tr>
					<th>User Id</th><th>Points</th><th>Date</th>
				</tr>
				<tr>
					<td>$user_id</td><td>$point </td><td>$date</td>
				</tr>
			</table>
			</body>
			</html>
			";
return $message;
}