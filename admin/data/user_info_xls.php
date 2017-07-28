<?php
session_start();
include("condition.php");
include("../function/setting.php");
include("../function/functions.php");
include("../function/send_mail.php");
include("../function/wallet_message.php");
include("../function/direct_income.php");
include("../function/check_income_condition.php");
include("../function/pair_point_calculation.php");

$save_excel_file_path = "D:/xampp/htdocs/server/money_freedom/business/admin/UserInfo/";

$unique_name = "UserInformation".time();
$sep = "\t"; 
$fp = fopen($save_excel_file_path.$unique_name.".xls", "w"); 
$insert = ""; 
$insert_rows = ""; 
$result = mysql_query("SELECT * FROM users $qur_set_search ");     
for ($i = 1; $i < mysql_num_fields($result); $i++)
{
$insert_rows.="Menu \t Parent Menu\t Menu File \t";
}
$insert_rows.="\n";
fwrite($fp, $insert_rows);
while($row = mysql_fetch_row($result))
{
	$insert = "";
	for($j=1; $j<mysql_num_fields($result);$j++)
	{
		if(!isset($row[$j]))
		$insert .= "NULL".$sep;
		elseif ($row[$j] != "")
		$insert .= strip_tags("$row[$j]").$sep;
		else
		$insert .= "".$sep;
	}
	$insert = str_replace($sep."$", "", $insert);
	
	$insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $insert);
	$insert .= "\n";
	fwrite($fp, $insert);
}
fclose($fp);
$full_path = "UserInfo/".$unique_name.".xls";

echo "<script type=\"text/javascript\">";
echo "window.location = \"$full_path\"";
echo "</script>";

