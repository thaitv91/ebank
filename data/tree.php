<?php
define("IN_PHP", true);
session_start();
include('condition.php');
include('function/setting.php');
include("function/functions.php");
?>	


<?php
$ebank_user_id = $_SESSION['ebank_user_id'];
$q_tree = mysql_query("SELECT * FROM users WHERE real_parent = $ebank_user_id");
if(mysql_num_rows($q_tree) > 0){
?>

<div id="middle_data" class="box-body pad row">
<div class="box box-primary" style="padding: 20px">

<ul class="downline_tree">

	<li style="margin-left:-20px;" class="li-0"><span aria-hidden="true" class="fa-stack">
          <i class="fa fa-circle fa-stack-2x"></i>
          <i class="fa fa-user fa-stack-1x fa-inverse"></i>
        </span><?=get_user_name($ebank_user_id);?>
	</li>	
    <?php
        $dem = 1;
        while ($row = mysql_fetch_array($q_tree)) {
    ?>
    <li class="li-1"><span aria-hidden="true" class="fa-stack">
          <i class="fa fa-circle fa-stack-2x"></i>
          <i class="fa fa-user fa-stack-1x fa-inverse"></i>
        </span><?=$row['username']?>

        <?php 
        $q_tree2 = mysql_query("SELECT * FROM users WHERE real_parent = ".$row['id_user']."");
        if(mysql_num_rows($q_tree) > 0){
        ?>
        <ul>
            <?php
            while ($row2 = mysql_fetch_array($q_tree2)) {
            ?>

            <li class="li-2"><span aria-hidden="true" class="fa-stack"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-user fa-stack-1x fa-inverse"></i></span><?=$row2['username']?>

                <?php 
                $q_tree3 = mysql_query("SELECT * FROM users WHERE real_parent = ".$row2['id_user']."");
                if(mysql_num_rows($q_tree3) > 0){
                ?>
                <ul>

                    <?php
                    while ($row3 = mysql_fetch_array($q_tree3)) {
                    ?>
                    <li class="li-3"><span aria-hidden="true" class="fa-stack"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-user fa-stack-1x fa-inverse"></i></span><?=$row3['username']?>

                        <?php 
                        $q_tree4 = mysql_query("SELECT * FROM users WHERE real_parent = ".$row3['id_user']."");
                        if(mysql_num_rows($q_tree4) > 0){
                        ?>
                        <ul>
                             <?php
                            while ($row4 = mysql_fetch_array($q_tree4)) {
                            ?>
                            <li class="li-4"><span aria-hidden="true" class="fa-stack"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-user fa-stack-1x fa-inverse"></i></span><?=$row4['username']?>
                                <?php 
                                $q_tree5 = mysql_query("SELECT * FROM users WHERE real_parent = ".$row4['id_user']."");
                                if(mysql_num_rows($q_tree4) > 0){
                                ?>
                                <ul>
                                     <?php
                                    while ($row5 = mysql_fetch_array($q_tree5)) {
                                    ?>
                                    <li class="li-5"><span aria-hidden="true" class="fa-stack"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-user fa-stack-1x fa-inverse"></i></span><?=$row5['username']?>

                                        <?php 
                                        $q_tree6 = mysql_query("SELECT * FROM users WHERE real_parent = ".$row5['id_user']."");
                                        if(mysql_num_rows($q_tree6) > 0){
                                        ?>
                                        <ul>
                                             <?php
                                            while ($row6 = mysql_fetch_array($q_tree6)) {
                                            ?>
                                            <li class="li-6"><span aria-hidden="true" class="fa-stack"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-user fa-stack-1x fa-inverse"></i></span><?=$row6['username']?>

                                                <?php 
                                                $q_tree7 = mysql_query("SELECT * FROM users WHERE real_parent = ".$row6['id_user']."");
                                                if(mysql_num_rows($q_tree4) > 0){
                                                ?>
                                                <ul>
                                                     <?php
                                                    while ($row7 = mysql_fetch_array($q_tree7)) {
                                                    ?>
                                                    <li class="li-7"><span aria-hidden="true" class="fa-stack"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-user fa-stack-1x fa-inverse"></i></span><?=$row7['username']?></li>
                                                    <?php }?>
                                                </ul>
                                                <?php }?>    
                    

                                            </li>
                                            <?php }?>
                                        </ul>
                                        <?php }?>    
                    
                                    
                                    </li>
                                    <?php }?>
                                </ul>
                                <?php }?>    
                    
                            </li>
                            <?php }?>
                        </ul>
                        <?php }?>    
                    
                    </li>
                    <?php } ?>

                </ul>
                <?php }?>

            </li>

            <?php }?>
        </ul>
        <?php }?>

    </li>

    <?php
        }
    ?>

</ul>
</div>
</div>

<?php
}else{
    echo '<p>Empty member downline</p>';
}
?>




</div> 
<style type="text/css">
    .downline_tree,
    .downline_tree ul {
      list-style-type: none;
      overflow: hidden;
      padding: 0;
    }

    .downline_tree li {
      text-indent: 1%;
      margin-top: 0.2em;
      padding: 0.15em 0 0.5em 0.5em;
      line-height: 22px;
      background-repeat: no-repeat;
      background-size: 24px 24px;
    }

    .downline_tree li ul{padding-left: 20px;}

    .downline_tree li .fa-stack{margin-right:10px;}
    .downline_tree li.li-0 .fa-stack{color:#2594F1;}
    .downline_tree li.li-1 .fa-stack{color:#F3237B;}
    .downline_tree li.li-2 .fa-stack{color:#32B10A;}
    .downline_tree li.li-3 .fa-stack{color:#DAA507;}
    .downline_tree li.li-4 .fa-stack{color:#35CBCA;}
    .downline_tree li.li-5 .fa-stack{color:#986635;}
    .downline_tree li.li-6 .fa-stack{color:#DE5145;}
    .downline_tree li.li-7 .fa-stack{color:#DE66D4;}
    .downline_tree li.contains-items { background-image: url('images/icons/arrow-left.png'); }
    .downline_tree li.items-expanded { background-image: url('images/icons/arrow-down.png'); }
    .downline_tree>li:hover { cursor: pointer; }
    .downline_tree span:hover { background-color: rgba(246, 246, 246, 0.7); }
    @media screen and (max-width: 768px) {
        .downline_tree li{background: none !important;}
    }
</style>


