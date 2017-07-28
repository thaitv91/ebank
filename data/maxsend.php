<?php
define("IN_PHP", true);
session_start();
include('condition.php');
include('function/setting.php');
include("function/functions.php");
?>	


<?php
$ebank_user_id = $_SESSION['ebank_user_id'];
$users_query = mysql_query("SELECT * FROM users");
while ($user = mysql_fetch_array($users_query)) {
    $ebank_user_id = $user['id_user'];
    $q_tree = mysql_query("SELECT * FROM users WHERE real_parent = $ebank_user_id");
    $count = mysql_num_rows($q_tree);
    $max_send = -1;
    if ($count == 0) {
        $max_send = 4;
    }

    if ($count == 1) {
        $max_send = 6;
    }

    if ($count == 2) {
        $max_send = 8;
    }

    if ($count == 3) {
        $max_send = 10;
    }
    $max_query = mysql_query("UPDATE users SET max_send_value = $max_send WHERE id_user = $ebank_user_id");
}
echo "<script type=\"text/javascript\">";

echo "window.location = \"index.php\"";

echo "</script>";
?>

