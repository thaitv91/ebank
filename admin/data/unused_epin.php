<?php
session_start();

include("condition.php");

include("../function/functions.php");

include("pagination.php");

$limit = 25;
$count = mysql_num_rows(mysql_query("select * from e_pin where mode = 1"));
$num_page = $count / $limit;
$limit_count = isset($_GET['p']) ? $_GET['p'] : 0 * $limit;
$query = mysql_query("SELECT * FROM e_pin where mode = 1 ORDER BY id DESC  LIMIT $limit_count,$limit");
if ($count != 0)
{
    ?>

    <table class="table table-bordered"> 

        <thead>

            <tr>	

                <th class="text-center">E-pin</th>	

                <th class="text-center">User Id</th>	

                <th class="text-center">Date</th>	

            </tr>

        </thead>

        <?php
        while ($row = mysql_fetch_array($query))
        {

            $epin = $row['epin'];

            $date = $row['date'];

            $user_id = get_user_name($row['user_id']);
            ?>	

            <tr>

                <td class="text-center"><?= $epin; ?></td>

                <td class="text-center"><?= $user_id; ?></td>

                <td class="text-center"><?= $date; ?></td>

            </tr>

            <?php
        }

        echo "</table>";
    }
    else
    {
        echo "<B style=\"color:#ff0000;\">There is no E-pin to show !!</B>";
    }
    ?>



    <?php
    $config = array(
        'current_page' => isset($_GET['p']) ? $_GET['p'] : 1, // Trang hiện tại
        'total_record' => $count, // Tổng số record
        'limit' => $limit, // limit
        'link_full' => 'index.php?page=unused_epin&p={page}', // Link full có dạng như sau: domain/com/page/{page}
        'link_first' => 'index.php?page=unused_epin', // Link trang đầu tiên
        'range' => 9 // Số button trang bạn muốn hiển thị 
    );
    $paging = new Pagination();
    $paging->init($config);
    echo $paging->html();
    ?>