<?php
session_start();
require_once("config.php");
include("function/functions.php");
require_once("pagination.php");
$id = $_SESSION['ebank_user_id'];
$username = $_SESSION['ebank_user_name'];
if (isset($_GET['did']))
{
    $did = $_GET['did'];
    mysql_query("DELETE FROM `message` WHERE id='$did'");
    echo "<script type=\"text/javascript\">";

    echo "window.location = \"index.php?page=inbox\"";

    echo "</script>";
}
?><div class="box box-primary" style="padding:20px">    <div class="box-header"><h3 class="box-title">Inbox</h3></div>    <?php
if (isset($_REQUEST['rply_submit']) and $_SESSION['reply_sess'] == 1)
{
    $_SESSION['reply_sess'] = 0;
    $u_id = $_REQUEST['ms_id'];
    $message = $_REQUEST['rply'];
    $title = "Send Reply By " . $username;
    $message_date = $systems_date;
    $time = date("Y-m-d H:i:s", strtotime($message_date));
    mysql_query("INSERT INTO message (id_user,receive_id, title, message, message_date,time)                 VALUES ('$id','0' , '$title' , '$message', '$message_date','$time') ");
    echo "<font color=green size=2><strong>Message send successfully!</strong></font>";
}
if (isset($_POST['read']))
{
    $table_id = $_POST['table_id'];
    $_SESSION['reply_sess'] = 1;
    mysql_query("update message set mode = 1 where id = '$table_id' ");
    $query = mysql_query("SELECT * FROM message WHERE id = '$table_id'");
    while ($row = mysql_fetch_array($query))
    {
        $receive_id = $row['receive_id'];
        $title = $row['title'];
        $message = $row['message'];
        $date_mes = $row['message_date'];
        $mode = $row['mode'];
        $date = date('d-m-Y', strtotime($date));
    }
    $qqq = mysql_query("SELECT * FROM admin");
    while ($rrrr = mysql_fetch_array($qqq))
    {
        $name = $rrrr['username'];
    }
    ?>        
        <div style="padding:10px;">       
            <div>Title : <?= $title; ?></div>        
            <div>To : <?= $name; ?></div>   
            <div>Date : <?= $date_mes; ?></div>    
            <div>Message : <?= $message; ?></div>      
        </div>    
        <div style="height:auto; text-align:left; width:100%; padding:10px; margin:20px 0 0 10px;">   
            <form action="" method="post">        
                <input type="hidden" name="ms_id" value="<?= $receive_id ?>" />       
                <textarea name="rply" style="width:95%; padding:10px; min-height:100px; overflow:hidden;" placeholder="Reply"></textarea><p></p>  
                <input type="submit" class="btn btn-success" name="rply_submit" value="Send Reply" />       
                <p></p>       
            </form>        
        </div>   
        <?php
    }
    else
    {
        $limit = 20;
        $limit_count = isset($_GET['p']) ? $_GET['p'] : 0 * $limit;
        $paging = new Pagination();
        $num = mysql_num_rows(mysql_query("select * from message where receive_id = '$id' and id_user = 0 order by id desc"));
        $query = mysql_query("SELECT * FROM message where receive_id = '$id' and id_user = 0 order by id desc LIMIT $limit_count,$limit");
        if ($num > 0)
        {
            ?>            
            <table class="table table-bordered table-hover">                
                <thead>                    
                    <tr>                        
                        <th width="15%">Sender</th>                        
                        <th>Subject</th>                        
                        <th width="20%">Date</th>                    
                    </tr>                
                </thead>                        
                <?php
                while ($row = mysql_fetch_array($query))
                {
                    $id = $row['id'];
                    $receive_id = $row['receive_id'];
                    //$receive_id = get_receive_id($row['receive_id']);                    
                    $title = $row['title'];
                    //$message = $row['message'];                    
                    $date = $row['message_date'];
                    $time = $row['time'];
                    $mode = $row['mode'];
                    $ticket_no = $row['ticket_no'];
                    $date = date('d-m-Y', strtotime($date));
                    $time = date('d M Y H:i:s A', strtotime($time));
                    $que = mysql_query("SELECT * FROM admin");
                    while ($rrr = mysql_fetch_array($que))
                    {
                        $name = $rrr['username'];
                    }
                    ?>                    
                    <tr>                    
                    <form action="" method="post">                        
                        <input type="hidden" name="table_id" value="<?= $id; ?>"  />                        
                        <td>                            
                            <input type="submit" name="read" value="<?= $name; ?>" style="width:150px; height:20px; background:none; border:none; box-shadow:none; text-align:left; color:#3F94D1; text-decoration:underline; <?php
                            if ($mode == 0)
                            {
                                ?> font-weight:bold; <?php
                                   }
                                   ?>" />                        
                        </td>                        
                        <td>                            
                            <input type="submit" name="read" value="<?= $title; ?>" style="width:150px; height:20px; background:none; border:none; box-shadow:none;  text-align:left; color:#3F94D1; text-decoration:underline; <?php
                            if ($mode == 0)
                            {
                                ?> font-weight:bold; <?php
                                   }
                                   ?>" />                        
                        </td>                        
                        <td <?php
                        if ($mode == 0)
                        {
                            ?> style="font-weight:bold; <?php
                            }
                            ?>">                            
                            <i class="fa fa-calendar"></i> <?= $time; ?>                        
                        </td>
                        <td>
                            <a href="index.php?page=inbox&did=<?= $id ?>">Delete</a>
                        </td>
                    </form>                    
                    </tr>                    
                    <?php
                }
                echo "</table>";
                $config = array(
                    'current_page' => isset($_GET['p']) ? $_GET['p'] : 1,
                    'total_record' => $count_used_epin,
                    'limit' => $limit,
                    'link_full' => 'index.php?page=inbox&p={page}',
                    'link_first' => 'index.php?page=inbox',
                    'range' => 9
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