<?php
session_start();
require_once("config.php");
include("function/functions.php");
require_once("pagination.php");
$id_user = $_SESSION['ebank_user_id'];
if (isset($_GET['did']))
{
    $did = $_GET['did'];
    mysql_query("DELETE FROM `message` WHERE id='$did'");
    echo "<script type=\"text/javascript\">";

    echo "window.location = \"index.php?page=sent_message\"";

    echo "</script>";
}
?>
<div class="box box-primary" style="padding:20px">  
    <div class="box-header"><h3 class="box-title">OutInbox</h3></div>   
    <?php
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
        $qqq = mysql_query("SELECT * FROM admin");
        while ($rrrr = mysql_fetch_array($qqq))
        {
            $name = $rrrr['username'];
        }
        ?> 		
        <div style="padding:10px;">         
            <div>            Title : <?= $title; ?></div>     
            <div>To : <?= $name; ?></div>      
            <div>Date : <?= $message_date; ?></div>    
            <div>Message : <?= $message; ?></div>      
        </div>     
        <?php
    }
    else
    {
        $limit = 20;
        $limit_count = isset($_GET['p']) ? $_GET['p'] : 0 * $limit;
        $paging = new Pagination();
        $num = mysql_num_rows(mysql_query("select * from message where id_user = '$id_user' and receive_id = 0 "));
        $query = mysql_query("SELECT * FROM message where id_user = '$id_user' and receive_id = 0 order by id desc LIMIT $limit_count,$limit");
        if ($num > 0)
        {
            ?>       
            <table class="table table-bordered">      
                <thead>               
                    <tr>                       
                        <th width="15%">Recipient</th>    
                        <th>Subject</th>                    
                        <th width="20%">Date</th>             
                        <th>Action</th>
                    </tr>           
                </thead>                
                <?php
                while ($row = mysql_fetch_array($query))
                {
                    $receive_id = $row['receive_id'];
                    // $receive_id = get_receive_id($row['receive_id']);             
                    $title = $row['title'];
                    $message = $row['message'];
                    $message_date = $row['message_date'];
                    $mode = $row['mode'];

                    $id = $row['id'];
                    $que = mysql_query("SELECT * FROM admin");
                    while ($rrr = mysql_fetch_array($que))
                    {
                        $name = $rrr['username'];
                    }
                    ?>          
                    <tr>                   
                    <form action="" method="post">              
                        <td>                    
                            <input type="hidden" name="table_id" value="<?= $id; ?>"  />               
                            <input type="submit" name="read" value="<?= $name; ?>" style=" height:20px; background:none; border:none; box-shadow:none; cursor:pointer; color:#3F94D1; text-decoration:underline; " />                   
                        </td>      
                        <td>  
                            <input type="submit" name="read" value="<?= $title; ?>" style=" height:20px; background:none; border:none; box-shadow:none; cursor:pointer; color:#3F94D1; text-decoration:underline; " />                
                        </td>     
                        <td><i class="fa fa-calendar"></i> <?= $message_date; ?></td>   
                        <td>
                            <a href="index.php?page=sent_message&did=<?= $id ?>">Delete</a>
                        </td>
                    </form>             
                    </tr>                 
                    <?php
                }
                print "</tbody></table>";
                $config = array(
                    'current_page' => isset($_GET['p']) ? $_GET['p'] : 1, // Trang hiện tại
                    'total_record' => $num, // Tổng số record                 
                    'limit' => $limit, // limit             
                    'link_full' => 'index.php?page=sent_message&p={page}', // Link full có dạng như sau: domain/com/page/{page}   
                    'link_first' => 'index.php?page=sent_message', // Link trang đầu tiên              
                    'range' => 9 // Số button trang bạn muốn hiển thị               
                );
                $paging->init($config);
                echo $paging->html();
            }
            else
            {
                echo "<p></p><B style=\"color:#ff0000;\">There are no information to show</B><p></p>";
            }
        }
        ?></div><style>    table thead tr th, table tbody tr td{        padding: 10px !important;    }</style>