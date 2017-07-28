<?php

include("menu_calculation.php");

$val = $_REQUEST['page'];
$user_id = $_SESSION['ebank_user_id'];
$class_icon[] = "dashboard";
$class_icon[] = "upload";
$class_icon[] = "download";
$class_icon[] = "edit";
$class_icon[] = "sitemap";
$class_icon[] = "money";
$class_icon[] = "key";
$class_icon[] = "exchange";
$class_icon[] = "envelope";
$class_icon[] = "wechat";
$class_icon[] = "question-circle-o";
$class_icon[] = "bullhorn";
$class_icon[] = "sign-out";

$query = mysql_query("SELECT * FROM users WHERE id_user = '$user_id' ");
while($row = mysql_fetch_array($query))
{
    $image = $row['photo'];
    $active_level = $row['level'];
	$user_name = $row['username'];
}

{ $Online ="Level V$active_level "; }

$query = mysql_query("SELECT * FROM users WHERE id_user = '$user_id' ");
$row = mysql_fetch_array($query);
if($image == ''){ $image = "user.png"; } else { $image = $row['photo']; }
?>

<aside class="main-sidebar">
    <section class="sidebar">
        <div class="user-panel">
            <div class="pull-left image">
                <img src="images/profile_image/<?=$image;?>" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
                <p>
                    <a href="index.php?page=edit-profile">
						<?=$user_name;?>
                    </a>
                </p>
                <p>
                    <span class="star text-yellow">
                        <?=getRating($user_id);?>
                    </span>
                </p>
                <a href="index.php?page=edit-profile">
                    <i class="fa fa-circle text-success"></i><?=$Online;?>
                </a>
            </div>
        </div>
        <ul class="sidebar-menu">
            <?php
                $j=count($menu);
                for($i=0;$i<$j;$i++)
                { 	
                    $class = '';
                    if(is_array($sub_menu[$i]))
                        $cnt = count($sub_menu[$i]);
                    else
                        $cnt = 0;

                    if($cnt > 0) {
                        $main_menu = get_mainmenu($val);
                        $sub_menu_tit =  get_submenu($val);
                        if($sub_menu_tit == $menu[$i][0]){ $class = "active";} ?>
                        <li class="treeview <?= $class; ?>">
                            <a title="<?=$menu[$i][0]; ?>"  href="#" >
                                <i class="fa fa-<?=$class_icon[$i]?>"></i>
                                <i class="fa fa-angle-left pull-right"></i>
                                <span><?=$menu[$i][0];?></span>
                                <span class="label label-primary pull-right"><?=$cnt;?></span>
                            </a>

                            <ul class="treeview-menu">
                            <?php
                                for($k=0;$k<$cnt; $k++) {
                                    $sub_class = "";
                                    if($main_menu == $sub_menu[$i][$k][0]) { $sub_class = "active"; }
                                ?>
                                    <li class="<?=$sub_class;?>">
                                        <a href="index.php?page=<?=$sub_menu[$i][$k][1];?>">
                                            <i class="fa fa-circle-o"></i><?=$sub_menu[$i][$k][0];?>
                                        </a>
                                    </li>
                            <?php 	} ?>
                            </ul>
                        </li>
                    <?php
                        } else {
                            $menu_class = get_mainmenu($val);
                            if($menu[$i][0] == $menu_class){$class = "active";} ?>
                                <li class="<?=$class;?>">
                                    <a href="index.php?page=<?=$menu[$i][1];?>" >
                                        <i class="fa fa-<?=$class_icon[$i]?>"></i><span><?=$menu[$i][0];?></span>
                                    </a>
                                </li>
                    <?php 	}
                        }
                    ?>
        </ul>
    </section>
</aside>





<?php

function getRating($id){

    $query = mysql_query("SELECT * FROM users WHERE id_user = $id");

    $row   = mysql_fetch_array($query);

    $rating = $row['level'];

    $str = '';

    for ($i = 0; $i < $rating; $i++) {

        $str .= '<i class="fa fa-star"></i>';

    }

    for ($i = 0; $i < (6 - $rating); $i++) {

        $str .= '<i class="fa fa-star-o"></i>';

    }

    return $str;

}

?>