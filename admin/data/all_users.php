<?php
session_start();

include("condition.php");

include("../function/functions.php");


$newp = $_GET['p'];

$plimit = "15";



$id = $_SESSION['id'];

$date = date('Y-m-d');

$query = mysql_query("SELECT * FROM users ");

$totalrows = mysql_num_rows($query);

if ($totalrows > 0)
{
    ?>

    <table class="table table-bordered">

        <thead>

            <tr>
                <th colspan="2">

                    Total Member: <?= $totalrows ?> member

                </th>
                <th colspan="3" class="text-right">

                    To Create Excel File <a href="index.php?page=create_excel_file">Click Here</a>

                </th>

            </tr>

            <tr>

                <th class="text-center">SR NO.</th>

                <th class="text-center">User Name</th>

                <th class="text-center">E-mail</th>

                <th class="text-center">Sub member</th>
                <th class="text-center">Sub member PD</th>
            </tr>

        </thead>

        <?php
        $pnums = ceil($totalrows / $plimit);

        if ($newp == '')
        {
            $newp = '1';
        }



        $start = ($newp - 1) * $plimit;

        $starting_no = $start + 1;



        if ($totalrows - $start < $plimit)
        {
            $end_count = $totalrows;
        }
        elseif ($totalrows - $start >= $plimit)
        {
            $end_count = $start + $plimit;
        }







        if ($totalrows - $end_count > $plimit)
        {
            $var2 = $plimit;
        }
        elseif ($totalrows - $end_count <= $plimit)
        {
            $var2 = $totalrows - $end_count;
        }



        $sr_no = $plimit * ($newp - 1);



        $query = mysql_query("SELECT * FROM users LIMIT $start,$plimit ");

        while ($row = mysql_fetch_array($query))
        {

            $sr_no++;

            $id = $row['id_user'];

            $username = get_user_name($id);

            $name = $row['f_name'] . " " . $row['l_name'];

            $liberty_email = $row['liberty_email'];

            $email = $row['email'];



            $alert_email = $row['alert_email'];
            $members = mysql_query("SELECT * FROM users where real_parent=$id");
            $count_member = mysql_num_rows($members);
            
            ?>
            <tr>

                <td class="text-center"><?= $sr_no ?></td>

                <td class="text-center"><?= $username ?></td>

                <td class="text-center"><?= $email ?></td>

                <td class="text-center"><?= $count_member ?></td>
                <td>
                    <?php

                    $i = 0;
                    while ($row1 = mysql_fetch_array($members))
                    {
                        $pid = $row1['id_user'];
                        $countpd = mysql_num_rows(mysql_query("SELECT * FROM income_transfer where user_id=1 and paying_id = 185 and mode=2"));

                        if($countpd >=1)
                            $i  += 1;

                    }
var_dump($i);
                    echo $i;
                    ?>
                </td>
            </tr>
            <?php
        }

        echo "</table>";
        ?>

        <div id="DataTables_Table_0_paginate" class="dataTables_paginate paging_simple_numbers">

            <ul class="pagination">

                <?php
                if ($newp > 1)
                {
                    ?>

                    <li id="DataTables_Table_0_previous" class="paginate_button previous">

                        <a href="<?= "index.php?page=all_users&p=" . ($newp - 1); ?>">Previous</a>

                    </li>

                    <?php
                }

                for ($i = 1; $i <= $pnums; $i++)
                {

                    if ($i != $newp)
                    {
                        ?>

                        <li class="paginate_button ">

                            <a href="<?= "index.php?page=all_users&p=$i"; ?>"><?php print_r("$i"); ?></a>

                        </li>

                        <?php
                    }
                    else
                    {
                        ?><li class="paginate_button active"><a href="#"><?php print_r("$i"); ?></a></li><?php
                    }
                }

                if ($newp < $pnums)
                {
                    ?>

                    <li id="DataTables_Table_0_next" class="paginate_button next">

                        <a href="<?= "index.php?page=all_users&p=" . ($newp + 1); ?>">Next</a>

                    </li>

                    <?php
                }
                ?>

            </ul></div>

        <?php
    }
    else
    {
        print "<B style=\"color:#ff0000;\">There is no joining to Show !!</B>";
    }
    ?>