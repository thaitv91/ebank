<?php
include("pagination.php");
$user_id = $_SESSION['ebank_user_id'];
?>
<?php
$limit = 5;
$count = mysql_num_rows(mysql_query("select * from account where user_id = '$user_id' and wall_type = 'Main Wallet'"));
$limit_count = isset($_GET['p']) ? $_GET['p'] : 0 * $limit;
$query = mysql_query("SELECT * FROM account where user_id = '$user_id' and wall_type = 'Main Wallet' ORDER BY id DESC  LIMIT $limit_count,$limit");
if ($count > 0)
{
    ?>
    <div class="box box-primary" style="padding: 15px; margin-top:-20px;"> 
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Credit </th>
                    <th>Debit </th>
                    <th>Description</th>
                    <th>Balance </th>

                </tr>
            </thead>
            <?php
            $sr_no = 1;
            while ($row = mysql_fetch_array($query))
            {
                $cr = $row['cr'];
                $dr = $row['dr'];
                $date = $row['date'];
                $desc = $row['account'];
                $wal_bal = $row['wallet_balance'];

                //$date = date('d M Y H:i:s A');
                ?>
                <tr>
                    <td><?=  date('d-m-Y', strtotime($date)); ?></td>
                    <td><?= number_format($cr); ?></td>
                    <td><?= number_format($dr); ?></td>
                    <td><?= $desc; ?></td>
                    <td><?= number_format($wal_bal); ?></td>
                </tr>

                <?php
                $sr_no++;
            }
            ?>
        </table>
        <?php
        $config = array(
            'current_page' => isset($_GET['p']) ? $_GET['p'] : 1, // Trang hiện tại
            'total_record' => $count, // Tổng số record
            'limit' => $limit, // limit
            'link_full' => 'index.php?page=main_wallet&p={page}', // Link full có dạng như sau: domain/com/page/{page}
            'link_first' => 'index.php?page=main_wallet', // Link trang đầu tiên
            'range' => 9 // Số button trang bạn muốn hiển thị 
        );
        $paging = new Pagination();
        $paging->init($config);
        echo $paging->html();
        ?>
    </div>

    <?php
}
else
{
    echo "<p></p><B style=\"color:#ff0000;\">&nbsp;There are no information to show</B><p></p>";
}
?>
<style>
    table thead tr th, table tbody tr td{
        padding: 10px !important;


    }
</style>