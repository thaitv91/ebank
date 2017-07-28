<?php
ini_set("display_errors" , "off");
session_start();

require("function/functions.php");
require_once("pagination.php");

$id = $_SESSION['ebank_user_id'];

$limit = 10;
$page = isset($_GET['p']) ? $_GET['p'] : 0;
if($page >0){
    $limit_count = $page * $limit - 1;
}else{
    $limit_count = 0;
}
$paging = new Pagination();
$count_used_epin = mysql_num_rows(mysql_query("SELECT sum(income) as t_income, date, user_id FROM user_income WHERE income > 0 AND user_id = ".$id." AND type = ".$income_type[7]."  group by date"));


$sql = "SELECT sum(income) as t_income, date, user_id FROM user_income WHERE income > 0 AND user_id = ".$id." AND type = ".$income_type[7]."  group by date";
$query = mysql_query($sql);
$totalrows = mysql_num_rows($query);
if($totalrows == 0)
{
    echo "<B style=\"color:#FF0000; font-size:14px;\">$there_are</B>";
}
else
{
    //find sponsor bonus for user
    $q_sponsor = mysql_query("SELECT sum(income) as t_income, date, user_id FROM user_income WHERE income > 0 AND user_id = ".$id." AND type = ".$income_type[7]."  group by date order by date DESC LIMIT $limit_count,$limit");
?>

    <!-- commission summary bonus -->
        <div class="box box-primary" style="padding: 15px">
        <div class="box-header"><h3 class="box-title">Commission Summary - Sponsor Bonus</h3></div>
        <table class="table table-bordered table-hover">

            <thead>
                <tr>
                    <th class="text-center">Date</th>
                    <th class="text-center">Amount</th>
                    <th class="text-center">Details</th>
                </tr>
            </thead>

            <?php
            while($abc=mysql_fetch_array($q_sponsor))
            {
            ?>
            <tr>
                <th class="text-center"><?=date("d-m-Y", strtotime($abc['date']) )?></th>
                <th class="text-center" style="padding-right:20px;"><?=number_format($abc['t_income']);?></th>
                <th class="text-center"><a class="btn btn-warning" href="index.php?page=participants&p=<?=$page?>&id=<?=$abc['user_id']?>&date=<?=$abc['date']?>">View Details</a></th>
            </tr>
            <?php }?>
        </table>
        <?php
            $config = array(
                'current_page' => isset($_GET['p']) ? $_GET['p'] : 1, // Trang hiện tại
                'total_record' => $count_used_epin, // Tổng số record
                'limit' => $limit, // limit
                'link_full' => 'index.php?page=participants&p={page}', // Link full có dạng như sau: domain/com/page/{page}
                'link_first' => 'index.php?page=participants', // Link trang đầu tiên
                'range' => 9 // Số button trang bạn muốn hiển thị
            );
            $paging->init($config);
            echo $paging->html();
        ?>    
    </div>
    <p></p>




    <!-- commission details -->
    <div class="box box-primary" style="padding: 15px">
        <div class="box-header"><h3 class="box-title">Commission Details <?=' - '.$_GET['date']?></h3></div>
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th class="text-center">Date</th>
                    <th class="text-center">Related PH ID</th>
                    <th class="text-center">Amount</th>
                    <th class="text-center">Description</th>
                </tr>
            </thead>

        <?php
        $user_id = $_GET['id'];
        $date_income = $_GET['date'];

        $d_income = mysql_query("SELECT * FROM user_income WHERE user_id = ".$id." AND date = '".$date_income."' AND type = ".$income_type[7]." order by date");
        while($row = mysql_fetch_array($d_income))
        {
            $tb_investment = mysql_query("SELECT user_id FROM investment_request WHERE id = ".$row['investment_id']."");
            $row_investment = mysql_fetch_array($tb_investment);
            // get user
            $tb_user = mysql_query("SELECT * FROM users WHERE id_user=".$row_investment['user_id']."");
            $row_user = mysql_fetch_array($tb_user);
        ?>
            <tr>
                <th class="text-center"><?=date("d-m-Y", strtotime($row['date']) );?></th>
                <th class="text-center">PH06980<?=$row['investment_id'];?></th>
                <th class="text-center"><?=number_format($row['income']);?></th>
                <th class="text-center"><?=number_format($row['income']);?> of sponsor bonus for referring <?=$row_user['username'];?></th>
            </tr>
        <?php
        } ?>
        </table>
    </div>
    <!-- page navigation -->
<?php
}

function get_user_full_investment($id)
{
    $q = mysql_query("select sum(amount) from investment_request where user_id = '$id' ");
    while($row = mysql_fetch_array($q))
    {
        $total_invst = $row[0];
    }
    if($total_invst == '')
        $total_invst = 0;
    return $total_invst;
}
?>

<style>
    table thead tr th, table tbody tr td{
        padding: 10px !important;
    }
</style>