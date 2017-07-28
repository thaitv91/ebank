<?php
session_start();
require_once("../config.php");
if (isset($_GET['did']))
{
    $did = $_GET['did'];
    mysql_query("DELETE FROM `message` WHERE id='$did'");
    echo "<script type=\"text/javascript\">";

    echo "window.location = \"index.php?page=sent_message\"";

    echo "</script>";
}
if (isset($_POST['read']))
{
    $table_id = $_POST['table_id'];
    $query = mysql_query("SELECT * FROM message WHERE id = '$table_id'");
    while ($row = mysql_fetch_array($query))
    {
        $receive_id = $row['receive_id'];
        $title = $row['title'];
        $message = $row['message'];
        $message_date = $row['message_date'];
        $mode = $row['mode'];
    }
    $qqq = mysql_query("SELECT * FROM users WHERE id_user = '$receive_id'");
    while ($rrrr = mysql_fetch_array($qqq))
    {
        $name = $rrrr['f_name'] . " " . $rrrr['l_name'];
    }
    ?> 
    <div style="height:30px; text-align:left">Title : <?= $title; ?></div>
    <div style="height:30px; text-align:left">To : <?= $name; ?></div>
    <div style="height:30px; text-align:left">Date : <?= $message_date; ?></div>
    <div style="height:auto; text-align:left; margin-top:20px;">Message : <?= $message; ?></div>
    <?php
}
else
{
    $query = mysql_query("SELECT * FROM message WHERE id_user = '0' order by id desc");
    $num = mysql_num_rows($query);
    if ($num > 0)
    {
        ?>
        <table class="table table-bordered">  
            <thead>
                <tr>
                    <th class="text-center">Title</th>
                    <th class="text-center">Name</th>
                    <th class="text-center">Message</th>
                    <th class="text-center">Date</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <?php
            while ($row = mysql_fetch_array($query))
            {
                $receive_id = $row['receive_id'];
                $title = $row['title'];
                $message = $row['message'];
                $message_date = $row['message_date'];
                $mode = $row['mode'];
                $id = $row['id'];

                $que = mysql_query("SELECT * FROM users WHERE id_user = '$receive_id'");
                while ($rrr = mysql_fetch_array($que))
                {
                    $name = $rrr['f_name'] . " " . $rrr['l_name'];
                }
                ?>
                <tr>
                    <td><?= $title; ?></td>
                    <td><?= $name; ?></td>
                    <td>
                        <form action="" method="post">
                            <input type="hidden" name="table_id" value="<?= $id; ?>"  />
                            <input type="submit" name="read" value="<?= $message; ?>" style="width:150px; height:20px; background:none; border:none; box-shadow:none; cursor:pointer; " />
                        </form>
                    </td>
                    <td><?= $message_date; ?></td>
                    <td>
                        <a href="index.php?page=sent_message&did=<?= $id ?>">Delete</a>
                    </td>
                </tr>
                <?php
            }
            echo "</table>";
        }
        else
        {
            echo "<B style=\"color:#ff0000;\">There is no information to show !!</B>";
        }
    }
    ?>

