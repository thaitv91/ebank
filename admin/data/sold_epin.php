<?php
session_start();

include("condition.php");

include("../function/functions.php");
include("pagination.php");
?>

<form action="" method="post">

    <table class="table table-bordered"> 

        <thead><tr><th colspan="5">Search By Date</th></tr></thead>

        <tr>

            <th>Start Date</th>

            <td>

                <div class="form-group" id="data_1" style="margin:0px">

                    <div class="input-group date">

                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>

                        <input type="text" name="start_date" />

                    </div>

                </div>

            </td>

            <th>End Date</th>

            <td>

                <div class="form-group" id="data_1" style="margin:0px">

                    <div class="input-group date">

                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>

                        <input type="text" name="end_date" />

                    </div>

                </div>

            </td>

            <td>

                <input type="submit" name="Search" value="Search" class="btn btn-info" />

            </td>

        </tr>

    </table>

</form>

<?php
$limit = 25;
$limit_count = isset($_GET['p']) ? $_GET['p'] : 0 * $limit;
if (isset($_POST['Search']))
{

    $start_date = $_REQUEST['start_date'];

    $end_date = $_REQUEST['end_date'];

    $start_date = date('Y-m-d', strtotime($start_date));

    $end_date = date('Y-m-d', strtotime($end_date));
    $count = mysql_num_rows(mysql_query("select * from e_pin where   user_id != '0' and date >= '$start_date' and date <= '$end_date' "));
    $num_page = $count / $limit;

    $sql = "select * from e_pin where  user_id != '0' and date >= '$start_date' and date <= '$end_date' ORDER BY id DESC  LIMIT $limit_count,$limit";
}
else
{
    $count = mysql_num_rows(mysql_query("select * from e_pin where user_id != '0'"));
    $num_page = $count / $limit;
    $sql = "select * from e_pin where user_id != '0' ORDER BY id DESC  LIMIT $limit_count,$limit";
}
$query = mysql_query($sql);
$num = mysql_num_rows($query);

if ($num != 0)
{
    ?>

    <table class="table table-bordered">  

        <thead>

            <tr>

                <th class="text-center">E-pin</th>

                <th class="text-center">User ID</th>

                <th class="text-center">Date</th>

                <th class="text-center">E-pin Status</th>

            </tr>

        </thead>

        <?php
        while ($row = mysql_fetch_array($query))
        {

            $user_id = $row['user_id'];

            $epin = $row['epin'];

            $date = $row['date'];

            $mode = $row['mode'];

            $user_name = get_user_name($user_id);

            $date = date('d/M/Y', strtotime($date));

            if ($mode == '1')
            {
                $status = "<B style=\"color:#FF0000;\">Unused</B>";
            }
            else
            {
                $status = "<B style=\"color:#008000;\">Used</B>";
            }
            ?>

            <tr>

                <td class="text-center"><?= $epin; ?></td>

                <td class="text-center"><?= $user_name; ?></td>

                <td class="text-center"><?= $date; ?></td>

                <td class="text-center"><?= $status; ?></td>

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
        'link_full' => 'index.php?page=sold_epin&p={page}', // Link full có dạng như sau: domain/com/page/{page}
        'link_first' => 'index.php?page=sold_epin', // Link trang đầu tiên
        'range' => 9 // Số button trang bạn muốn hiển thị 
    );
    $paging = new Pagination();
    $paging->init($config);
    echo $paging->html();
    ?>
    <script src="js/date.js"></script>