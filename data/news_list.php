<?php
session_start();

include("condition.php");
include("pagination.php");
$newp = $_GET['p'];
if (isset($_REQUEST['news_no']))
{

    $qa = mysql_query("select * from news where id='" . $_REQUEST['news_no'] . "'");



    if (mysql_num_rows($qa) != 0)
    {

        $rowa = mysql_fetch_array($qa);
        ?>
        <div class="row">
            <div class="col-sm-11">
                <div style="height:30px; text-align:left; padding-left:10px;"><b>Title : <?= $rowa['title']; ?></b></div>

                <div style="height:30px; text-align:left; padding-left:10px;">Date : <?= $rowa['date']; ?></div>
            </div>
            <div class="col-sm-1"><?= "<a href='index.php?page=news_list' class='btn btn-primary'><i class=\"fa fa-reply\"></i>Back</a><p>&nbsp;</p>"; ?></div>
            <div class="col-sm-12"><p style="padding:10px"><?= $rowa['news'] ?></p></div>
        </div>

        <?php
    }
}
else
{
    $sql = "SELECT t1.user_id, t1.pair_point, t2.amount FROM (SELECT user_id, sum(pair_point) as pair_point   FROM matching_point group by user_id) t1 

LEFT JOIN (SELECT user_id, sum(amount) as amount   FROM income group by user_id) t2 ON t1.user_id=t2.user_id";
    ?>
    <div class="box box-primary" style="padding: 15px"> 
        <table class="table">  
            <thead>
                <tr>
                    <th style="width: 80%">Title</th>
                    <th>Author</th>
                    <th>Date</th>
                </tr>

            </thead>
            <tbody>
                <?php
                $limit = 25;
                $count = mysql_num_rows(mysql_query("select * from news"));
                $limit_count = isset($_GET['p']) ? $_GET['p'] : 0 * $limit;
                $q1 = mysql_query("SELECT * FROM news ORDER BY id DESC  LIMIT $limit_count,$limit");



                while ($id_row = mysql_fetch_array($q1))
                {
                    ?>
                    <tr>
                        <td><a href="index.php?page=news_list&p=<?= !empty($_GET['p']) ? $_GET['p'] : 1 ?>&news_no=<?= $id_row['id'] ?>"><?= $id_row['title'] ?></a></td>
                        <td>Admin</td>
                        <td><?= $id_row['date'] ?></td>	

                    </tr>	

                    <?php
                }
                ?>
            </tbody>

        </table>
    </div>
    <?php
    $config = array(
        'current_page' => isset($_GET['p']) ? $_GET['p'] : 1, // Trang hiện tại
        'total_record' => $count, // Tổng số record
        'limit' => $limit, // limit
        'link_full' => 'index.php?page=news_list&p={page}', // Link full có dạng như sau: domain/com/page/{page}
        'link_first' => 'index.php?page=news_list', // Link trang đầu tiên
        'range' => 9 // Số button trang bạn muốn hiển thị 
    );
    $paging = new Pagination();
    $paging->init($config);
    echo $paging->html();
    ?>



<?php } ?>

<style>
    table thead tr th, table tbody tr td{
        padding: 10px !important;


    }
</style>