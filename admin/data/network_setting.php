<?php 

session_start();

include("condition.php");

include("../function/setting.php");

function find($result)
{
    $rows = array();
    while ($row = mysql_fetch_array($result))
    {
        $rows[] = $row;
    }
    return $rows;
}

if (!empty($_POST['submit']))
{

    if ($_POST['submit'] == 'Update')
    {

        $plan_cnt = $_REQUEST['plan_cnt'];

		//update tb_time_block
        $time_block      = $_REQUEST['time_block'];
        $time_frozen     = $_REQUEST['time_frozen'];
        $frozen_downline = $_REQUEST['frozen_downline'];
        $time_report     = $_REQUEST['time_report'];
        mysql_query("UPDATE tb_time_block SET time_block ='$time_block' , time_frozen = '$time_frozen' , frozen_downline = '$frozen_downline' , time_report = '$time_report'");

        for ($j = 0; $j < $plan_cnt; $j++)
        {

            $plan_ids = $_REQUEST['plan_id_' . $j];

            $end_amount = $_REQUEST['end_amount_' . $j];

            $plan_names = $_REQUEST['plan_name_' . $j];

            $amounts = $_REQUEST['amount_' . $j];

            $profits = $_REQUEST['profit_' . $j];

            $dayss = $_REQUEST['days_' . $j];

            $direct_inc = $_REQUEST['direct_' . $j];

            $sql = "update plan_setting set plan_name = '$plan_names' , amount = '$amounts' , 

			end_amount = '$end_amount' , days = '$dayss' , profit = '$profits' , 

			direct_inc = '$direct_inc' where id = '$plan_ids' ";

            mysql_query($sql);
        }

        /* for($j = 1; $j <= 6; $j++)

          {

          $min_pd = $_REQUEST['min_pd_'.$j];

          $max_pd = $_REQUEST['max_pd_'.$j];



          $sql = "update pd_setting set min_pd = '$min_pd' , max_pd = '$max_pd' where level = '$j' ";

          mysql_query($sql);

          } */

        for ($j = 1; $j <= 6; $j++)
        {

            $min_pd = $_REQUEST['min_pd_amt' . $j];

            $max_pd = $_REQUEST['max_pd_amt' . $j];

            $min_mw_gd = $_REQUEST['min_mw_gd_amt' . $j];

            $max_mw_gd = $_REQUEST['max_mw_gd_amt' . $j];

            $min_cw_gd = $_REQUEST['min_cw_gd_amt' . $j];

            $max_cw_gd = $_REQUEST['max_cw_gd_amt' . $j];



            $sql = "update pd_gd_amt_setting set min_pd = '$min_pd' , max_pd = '$max_pd',min_mw_gd = '$min_mw_gd' ,min_cw_gd = '$min_cw_gd' where level = '$j' ";

            mysql_query($sql);
        }

        /* for($j = 1; $j <= 6; $j++)

          {

          $min_gd = $_REQUEST['min_gd_'.$j];

          $max_gd = $_REQUEST['max_gd_'.$j];



          $sql = "update gd_setting set min_gd = '$min_gd' , max_gd = '$max_gd' where level = '$j' ";

          mysql_query($sql);

          } */

        for ($j = 1; $j <= 6; $j++)
        {

            $link_time = $_REQUEST['link_time' . $j];



            $sql = "update link_time_limit set hour = '$link_time' where level = '$j' ";

            mysql_query($sql);
        }

        /* for($j = 1; $j <= 6; $j++)

          { */

        $gd_link_time = $_REQUEST['gd_link_time'];



        $sql = "update gd_link_time_limit set hour = '$gd_link_time' ";

        mysql_query($sql);

        //}

        for ($j = 1; $j <= 6; $j++)
        {

            $re_pd_time = $_REQUEST['re_pd_time' . $j];



            $sql = "update re_pd_time set hour = '$re_pd_time' where level = '$j' ";

            mysql_query($sql);
        }

        for ($j = 1; $j <= 6; $j++)
        {

            $day = $_REQUEST['pd_d' . $j];

            $week = $_REQUEST['pd_w' . $j];

            $month = $_REQUEST['pd_m' . $j];



            $sql = "update pd_dwm_setting set day = '$day' , week = '$week',month = '$month' where level = '$j' ";

            mysql_query($sql);
        }

        for ($j = 1; $j <= 6; $j++)
        {

            $day = $_REQUEST['gd_d' . $j];

            $week = $_REQUEST['gd_w' . $j];

            $month = $_REQUEST['gd_m' . $j];



            $sql = "update gd_dwm_setting set day_amt_limit = '$day' , week_amt_limit = '$week', 

			month_amt_limit = '$month' where level = '$j' ";

            mysql_query($sql);
        }

        for ($j = 1; $j <= 6; $j++)
        {

            $day = $_REQUEST['epin_d' . $j];

            $week = $_REQUEST['epin_w' . $j];

            $month = $_REQUEST['epin_m' . $j];



            $sql = "update epin_setting set day = '$day' , week = '$week',month = '$month' where level = '$j' ";

            mysql_query($sql);
        }

        $linc_query = "";

        for ($j = 1; $j < 7; $j++)
        {

            $linc_query .= "level_income_" . $j . " = " . $_REQUEST['level_income_' . $j] . " , ";
        }
        $linc_query .= " id = 1";
        mysql_query("update level_plan set $linc_query where id = 1 ");

//        Vinh Huynh Tu change level

        if (!empty($_POST['level_count']))
        {
            for ($i = 1; $i <= $_POST['level_count']; $i++)
            {
                $level_member = $_POST['level_member_' . $i];
                $level_pd = $_POST['level_pd_' . $i];
                $level_income = $_POST['level_income_' . $i];
                $upsate_level = mysql_query("update tb_level_plan set level_member = '$level_member' , level_pd = '$level_pd',level_income = '$level_income' where id = '$i'");
                $level_plan = mysql_query("update level_plan set level_income_'$i' = '$level_income' where id = 1");
                
            }
        }
		
		//update tb_block_fee
        if (!empty($_POST['block_count']))
        {
            $arr_tim_block = explode(",",$_POST['block_count']);
            foreach ($arr_tim_block as $key => $value) {
                $block = $_POST['block' . $value];
                $frozen = $_POST['frozen' . $value];
                $upsate_level = mysql_query("update tb_block_fee set  frozen = '$frozen',block = '$block' where id = '$value'"); 
            }
            
        }

        $linc_quer = "";

        for ($j = 1; $j < 6; $j++)
        {

            $linc_quer .= "level_income_" . $j . " = " . $_REQUEST['manager_level_income_' . $j] . " , ";
        }



        $linc_quer .= " id = 1";

        mysql_query("update manager_level set $linc_quer where id = 1 ");



        $direct_income_percent = $_REQUEST['direct_income_percent'];

        $binary_income_percent = $_REQUEST['binary_income_percent'];

        $transfer_count = $_REQUEST['transfer_count'];

        $per_day_max_binary_inc = $_REQUEST['per_day_max_binary_inc'];

        $minimum_withdrawal = $_REQUEST['minimum_withdrawal'];

        $ten_level_sponsor_percent = $_REQUEST['ten_level_sponsor_percent'];

        $per_day_multiple_binary_pair = $_REQUEST['per_day_multiple_binary_pair'];

        $real_parent_bonus_inc = $_REQUEST['real_parent_bonus_inc'];



        $first_inv_income = $_REQUEST['first_inv_income'];

        $second_inv_income = $_REQUEST['second_inv_income'];

        $third_inv_income = $_REQUEST['third_inv_income'];

        $fourth_inv_income = $_REQUEST['fourth_inv_income'];

        $registration_fees = $_REQUEST['registration_fees'];

        $thou_nnager_income = $_REQUEST['thou_nnager_income'];

        $epin_value = $_REQUEST['epin_value'];

        $epin_price = $_REQUEST['epin_price'];



        $sql = "update setting set binary_income_percent = '$binary_income_percent' ,  per_day_max_binary_inc = '$per_day_max_binary_inc' , minimum_withdrawal = '$minimum_withdrawal' , first_inv_income = '$first_inv_income' , second_inv_income = '$second_inv_income' , third_inv_income = '$third_inv_income' , fourth_inv_income = '$fourth_inv_income' , registration_fees = '$registration_fees' , thou_nnager_income = '$thou_nnager_income',epin_value = '$epin_value',epin_price = '$epin_price' ";

        mysql_query($sql);

        $up = 1;

        data_logs($id, $pos, $data_log[13][0], $data_log[13][1], $log_type[9]);

        echo "<script type=\"text/javascript\">";

        echo "window.location = \"index.php?page=network_setting\"";

        echo "</script>";
    }

	// add time/ delete time tb_block_fee
    if ($_POST['submit'] == 'Add Time')
    {
        $time = $_POST['block_time'] + 1;
        mysql_query("insert into tb_block_fee (time) values ('$time')");
    }
     if ($_POST['submit'] == 'Delete Time')
    {
        if (!empty($_POST['check_time']))
        {
            foreach ($_POST['check_time'] as $id)
            {
                mysql_query("delete from tb_block_fee where id = '$id' ");
            }
        }
    }

    if ($_POST['submit'] == 'Add Plan')
    {

        mysql_query("insert into plan_setting (plan_name) values ('Enter All Info') ");
    }
    if ($_POST['submit'] == 'Add Level')
    {
        $level_name = $_POST['level_count'] + 1;
        mysql_query("insert into tb_level_plan (level_name) values ('$level_name')");
    }
    if ($_POST['submit'] == 'Delete Level')
    {
        if (!empty($_POST['check_level']))
        {
            foreach ($_POST['check_level'] as $id)
            {
                mysql_query("delete from tb_level_plan where id = '$id' ");
            }
        }
    }
    if ($_POST['submit'] == 'Delete Plan')
    {

        $plan_ids = $_REQUEST['plan_ids'];

        if ($plan_ids == '')
        {

            print "Please Select Any One Plan For Delete !";
        }
        else
        {

            mysql_query("delete from plan_setting where id = '$plan_ids' ");

            mysql_query("ALTER TABLE `plan_setting` DROP `id`");

            mysql_query("ALTER TABLE `plan_setting` ADD `id` INT NOT NULL AUTO_INCREMENT FIRST ,

			ADD PRIMARY KEY ( id )");
        }
    }

    /* echo "<script type=\"text/javascript\">";

      echo "window.location = \"index.php?page=network_setting\"";

      echo "</script>"; */
}

//query tb_time_block
$sql_time_block = mysql_query("SELECT * FROM tb_time_block");
$row_time_block = mysql_fetch_array($sql_time_block);
$time_block      = $row_time_block['time_block'];
$time_frozen     = $row_time_block['time_frozen'];
$frozen_downline = $row_time_block['frozen_downline'];
$time_report     = $row_time_block['time_report'];



$query = mysql_query("select * from setting ");

while ($row = mysql_fetch_array($query))
{

    $registration_fees = $row['registration_fees'];

    $direct_income_percent = $row['direct_income_percent'];

    $binary_income_percent = $row['binary_income_percent'];

    $minimun_invests = $row['minimun_invest'];

    $transfer_count = $row['transfer_count'];

    $minimum_withdrawal = $row['minimum_withdrawal'];

    $ten_level_sponsor_percent = $row['ten_level_sponsor_percent'];

    $per_day_multiple_binary_pair = $row['per_day_multiple_pair'];

    $per_day_max_binary_inc = $row['per_day_max_binary_inc'];

    $real_parent_bonus_inc = $row['real_parent_bonus_inc'];

    $thou_nnager_income = $row['thou_nnager_income'];

    $epin_value = $row['epin_value'];

    $epin_price = $row['epin_price'];
}

$pp = 0;

$q = mysql_query("select * from plan_setting");

while ($row = mysql_fetch_array($q))
{

    $tbl_plan_id[$pp] = $row['id'];

    $plan_name[$pp] = $row['plan_name'];

    $amount[$pp] = $row['amount'];

    $profit[$pp] = $row['profit'];

    $day[$pp] = $row['days'];

    $direct_inc_percent[$pp] = $row['direct_inc'];

    $end_amount[$pp] = $row['end_amount'];

    $pp++;
}



$q = mysql_query("select * from wallet_setting order by id asc ");

$plan_countss = mysql_num_rows($q);

$p = 0;

while ($row = mysql_fetch_array($q))
{

    $wallet_setting_id[$p] = $row['id'];

    $wallet_setting_amount[$p] = $row['amount'];

    $wallet_setting_profit[$p] = $row['inc_percent'];

    $p++;
}



$q = mysql_query("select * from level_plan ");

while ($row = mysql_fetch_array($q))
{

    for ($l = 1; $l < 12; $l++)
    {

        $level_incime_setting[$l] = $row['level_income_' . $l];
    }
}



$q = mysql_query("select * from manager_level ");

while ($row = mysql_fetch_array($q))
{

    for ($l = 1; $l < 6; $l++)
    {

        $manager_level_incime_setting[$l] = $row['level_income_' . $l];
    }
}



if ($up == 1)
{
    print "Updating completed Successfully";
}
?>	

<style>

    input{ width:100px;}

</style>



<table class="table table-bordered">

    <form name="setting" method="post" action="index.php?page=network_setting">

        <input type="hidden" name="plan_cnt" value="<?= $plan_count; ?>"  />

        <thead>

            <tr><th colspan="7">Investment Plans</th></tr> 

            <tr>

                <th width="5%">&nbsp;</th>

                <th>Packages</th>

                <th>Min Amount</th>

                <th>Max Amount (%)</th>

                <th>Profit (%)</th>

                <th>Income Days</th>

                <th>Direct Income</th>

            </tr>

        </thead> 

        <?php
        for ($pi = 0; $pi < $plan_count; $pi++)
        {
            ?>

            <tr>

            <input type="hidden" name="plan_id_<?= $pi; ?>" value="<?= $tbl_plan_id[$pi]; ?>"/>

            <input type="hidden" name="plan_ids" value="<?= $tbl_plan_id[$pi]; ?>"/>

            <td><input type="radio" name="plans_id" value="<?= $tbl_plan_id[$pi]; ?>"/></td>

            <td><input type="text" name="plan_name_<?= $pi; ?>" value="<?= $plan_name[$pi]; ?>" /></td>

            <td><input type="text" name="amount_<?= $pi; ?>" value="<?= $amount[$pi]; ?>" /></td>

            <td><input type="text" name="end_amount_<?= $pi; ?>" value="<?= $end_amount[$pi]; ?>" /></td>

            <td><input type="text" name="profit_<?= $pi; ?>" value="<?= $profit[$pi]; ?>" /></td>

            <td><input type="text" name="days_<?= $pi; ?>" value="<?= $day[$pi]; ?>" /></td>

            <td><input type="text" name="direct_<?= $pi; ?>" value="<?= $direct_inc_percent[$pi]; ?>" /></td>

            </tr>

        <?php }
        ?>

        <tr>

            <td colspan="5">&nbsp;</td>

            <td><input type="submit" name="submit" value="Add Plan" class="btn btn-info"  /></td>

            <td><input type="submit" name="submit" value="Delete Plan" class="btn btn-info"  /></td>

        </tr>



        <tr><td colspan="7">&nbsp;</td></tr> 

        <thead>

            <tr>

                <th colspan="4">Manager Level Income Setting</th>

                <th colspan="3">10 Manager Income</th>

            </tr> 

        </thead>

        <tr>

            <td colspan="4">



                <table class="table table-bordered">

                    <thead>

                        <tr>
                            <th></th>
                            <th>Level</th>
                            <th>Number Member</th>
                            <th>Number PD</th>
                            <th>Income (%)</th>
                        </tr>

                    </thead>

                    <?php
                    $query_level = mysql_query("select * from tb_level_plan ");
                    $rows_list = find($query_level);
                    if (!empty($rows_list))
                    {
                        foreach ($rows_list as $value)
                        {
                            ?>
                            <tr>
                                <td style="width:10px"><input type="checkbox" name="check_level[]" value="<?= $value['id'] ?>"></td>
                                <td>M<?= $value['level_name'] ?></td>
                                <td><input type="text" name="level_member_<?= $value['id'] ?>" value="<?= $value['level_member'] ?>" /></td>
                                <td><input type="text" name="level_pd_<?= $value['id'] ?>" value="<?= $value['level_pd'] ?>" /></td>
                                <td><input type="text" name="level_income_<?= $value['id'] ?>" value="<?= $value['level_income'] ?>" />%</td>
                            </tr>

                            <?php
                        }
                    }
                    ?>
                    <tr>
                        <td colspan="5" class="text-right"><input type="submit" name="submit" value="Add Level" class="btn btn-info"  /> <input type="submit" name="submit" value="Delete Level" class="btn btn-danger"  /></td>
                    </tr>
                    <input type="hidden" name="level_count" value="<?= count($rows_list) ?>">

                </table>

            </td>

            <td colspan="4"> 

                <table class="table table-bordered">

                    <?php
                    for ($li = 1; $li < 6; $li++)
                    {
                        ?>

                        <tr>

                            <td>&nbsp;</td>

                            <td><?= $li; ?></td>

                            <td>

                                <input type="text" name="manager_level_income_<?= $li; ?>" value="<?= $manager_level_incime_setting[$li]; ?>" />

                            </td>

                        </tr>

                    <?php } ?>

                </table>

            </td>

        </tr>

        <tr>

            <th colspan="2">1000 Manager Income</th>

            <td colspan="5">

                <input type="text" name="thou_nnager_income" value="<?= $thou_nnager_income; ?>" />

            </td>

        </tr>

        <tr>

            <th colspan="2">Registration Amount</th>

            <td colspan="5">

                <input type="text" name="registration_fees" value="<?= $registration_fees; ?>" />

            </td>

        </tr>

        <tr>

            <th colspan="2">Other Withdrawal Percentage</th>

            <td colspan="5">

                <input type="text" name="binary_income_percent" value="<?= $binary_income_percent; ?>" />

            </td>

        </tr>

        <?php /* ?> <tr>

          <td width="150" class="td_title"><strong>Per Day Min Binary Pair</strong></td>

          <td colspan="5" style="padding-left:55px;"><input type="text" name="per_day_multiple_binary_pair" style="padding-left:15px; width:120px;" value="<?php echo $per_day_multiple_binary_pair; ?>" class="input-medium" /></td>

          </tr>

          <tr>

          <td colspan="6">&nbsp;</td>

          </tr>

          <tr>

          <td width="150" class="td_title"><strong>Per Day Max Binary Income</strong></td>

          <td colspan="5" style="padding-left:55px;"><input type="text" name="per_day_max_binary_inc" style="padding-left:15px; width:120px;" value="<?php echo $per_day_max_binary_inc; ?>" class="input-medium" /></td>

          </tr>

          <tr>

          <td colspan="6">&nbsp;</td>

          </tr><?php */ ?>

        <tr>

            <th colspan="2">Minimum Withdrawal</th>

            <td colspan="5">

                <input type="text" name="minimum_withdrawal" value="<?= $minimum_withdrawal; ?>" />

            </td>

        </tr>

        <tr>

            <th colspan="2">1 EPin </th>

            <td colspan="5">

                <input type="text" name="epin_value" value="<?= $epin_value; ?>" />

            </td>

        </tr>

        <tr>

            <th colspan="2">1 EPin Price </th>

            <td colspan="5">

                <input type="text" name="epin_price" value="<?= $epin_price; ?>" />

            </td>

        </tr>

        <tr><td colspan="7">&nbsp;</td></tr>

        <thead>

            <tr><th colspan="7">Protection Plan</th></tr>

        </thead>

        <tr>

            <th colspan="4">Penalty Protection</th>

            <td colspan="3">

                <input type="text" name="penalty_protection" value="<?= $penalty_protection; ?>" />

            </td>

        </tr>

        <tr>

            <th colspan="4">User Protection</th>

            <td colspan="3">

                <input type="text" name="user_protection" value="<?= $user_protection; ?>" />

            </td>

        </tr>

        <tr><td colspan="7">&nbsp;</td></tr>

        <!--<thead>

                <tr><th colspan="7">PD/GD Minimum And Maximum Setting</th></tr>

        </thead>

        <tr>

                <td colspan="4">

                        <table class="table table-bordered">

                                <thead><td>Level</td><td>MIN PD</td><td>MAX PD</td></thead>

        <?php
        for ($i = 1; $i <= count($min_pd_settings); $i++)
        {
            ?><tr>

                                                                                                                                                                                                                                                                                                                                                                                                    <td><?= $i; ?></td>

                                                                                                                                                                                                                                                                                                                                                                                                    <td><input type="text" name="min_pd_<?= $i ?>" value="<?= $min_pd_settings[$i] ?>" /></td>

                                                                                                                                                                                                                                                                                                                                                                                                    <td><input type="text" name="max_pd_<?= $i ?>" value="<?= $max_pd_settings[$i] ?>" /></td>

                                                                                                                                                                                                                                                                                                                                                                                            </tr>

            <?php
        }
        ?>

                        </table>

                </td>

                <td colspan="3">

                        <table class="table table-bordered">

                                <thead><td>Level</td><td>MIN GD</td><td>MAX GD</td></thead>

        <?php
        for ($i = 1; $i <= count($min_gd_settings); $i++)
        {
            ?><tr>

                                                                                                                                                                                                                                                                                                                                                                                                    <td><?= $i; ?></td>

                                                                                                                                                                                                                                                                                                                                                                                                    <td><input type="text" name="min_gd_<?= $i ?>" value="<?= $min_gd_settings[$i] ?>" /></td>

                                                                                                                                                                                                                                                                                                                                                                                                    <td><input type="text" name="max_gd_<?= $i ?>" value="<?= $max_gd_settings[$i] ?>" /></td>

                                                                                                                                                                                                                                                                                                                                                                                            </tr>

            <?php
        }
        ?>

                        </table>

                </td>

        </tr>-->

        <thead>

            <tr><th colspan="7">PD/GD Minimum And Maximum Amount Setting</th></tr>

        </thead>

        <tr>

            <td colspan="7">

                <table class="table table-bordered">

                    <thead>

                    <th>Level</th><th>MIN PD Amount</th><th>MAX PD Amount</th>

                    <th>MIN M-Wal GD Amount</th>

                    <th>MIN C-Wal GD Amount</th>

                                <!--<th>MAX C-Wal GD Amount</th><th>MAX M-Wal GD Amount</th>-->

                    </thead>

                    <?php
                    for ($i = 1; $i <= count($min_pd_amt_settings); $i++)
                    {
                        ?>

                        <tr>

                            <td><?= $i; ?></td>

                            <td>

                                <input type="text" name="min_pd_amt<?= $i ?>" value="<?= $min_pd_amt_settings[$i] ?>" />

                            </td>

                            <td>

                                <input type="text" name="max_pd_amt<?= $i ?>" value="<?= $max_pd_amt_settings[$i] ?>" />

                            </td>

                            <td>

                                <input type="text" name="min_mw_gd_amt<?= $i ?>" value="<?= $min_mw_gd_amt_settings[$i] ?>" />

                            </td>

                                                                                                                                                                                                                                                                                                                                                                                    <!--<td>

                                                                                                                                                                                                                                                                                                                                                                                            <input type="text" name="max_mw_gd_amt<?= $i ?>" value="<?= $max_mw_gd_amt_settings[$i] ?>" />

                                                                                                                                                                                                                                                                                                                                                                                    </td>-->

                            <td>

                                <input type="text" name="min_cw_gd_amt<?= $i ?>" value="<?= $min_cw_gd_amt_settings[$i] ?>" />

                            </td>

                                                                                                                                                                                                                                                                                                                                                                                    <!--<td>

                                                                                                                                                                                                                                                                                                                                                                                            <input type="text" name="max_cw_gd_amt<?= $i ?>" value="<?= $max_cw_gd_amt_settings[$i] ?>" />

                                                                                                                                                                                                                                                                                                                                                                                    </td>-->

                        </tr>

                        <?php
                    }
                    ?>

                </table>

            </td>

        </tr>

        <thead>

            <tr><th colspan="7">PD Day Week Month Setting</th></tr>

        </thead>

        <tr>

            <td colspan="7">

                <table class="table table-bordered">

                    <thead><tr><th>Level</th><th>DAY</th><th>WEEK</th><th>MONTH</th></tr></thead>

                    <?php
                    for ($i = 1; $i <= count($pd_dwm_settings); $i++)
                    {
                        ?><tr>

                            <td><?= $i; ?></td>

                            <td><input type="text" name="pd_d<?= $i ?>" value="<?= $pd_dwm_settings[$i][0] ?>" /></td>

                            <td><input type="text" name="pd_w<?= $i ?>" value="<?= $pd_dwm_settings[$i][1] ?>" /></td>

                            <td><input type="text" name="pd_m<?= $i ?>" value="<?= $pd_dwm_settings[$i][2] ?>" /></td>



                        </tr>

                        <?php
                    }
                    ?>

                </table>

            </td>

        </tr>

        <thead>

            <tr><th colspan="7">GD Maximum Amount Day Week Month Setting</th></tr>

        </thead>

        <tr>

            <td colspan="7">

                <table class="table table-bordered">

                    <thead>

                        <tr>

                            <th>Level</th>

                            <th>DAY Maximum Amount</th>

                            <th>WEEK Maximum Amount</th>

                            <th>MONTH Maximum Amount</th>

                        </tr>

                    </thead>

                    <?php
                    for ($i = 1; $i <= count($gd_dwm_amt); $i++)
                    {
                        ?><tr>

                            <td><?= $i; ?></td>

                            <td><input type="text" name="gd_d<?= $i ?>" value="<?= $gd_dwm_amt[$i][0] ?>" /></td>

                            <td><input type="text" name="gd_w<?= $i ?>" value="<?= $gd_dwm_amt[$i][1] ?>" /></td>

                            <td><input type="text" name="gd_m<?= $i ?>" value="<?= $gd_dwm_amt[$i][2] ?>" /></td>

                        </tr>

                        <?php
                    }
                    ?>

                </table>

            </td>

        </tr>



        <thead><tr><th colspan="7">Epin Per Day Limit Setting</th></tr></thead>

        <tr>

            <td colspan="7">

                <table class="table table-bordered">

                                <thead><tr><td>No.</td><td>DAY</td><!--<td>WEEK</td><td>MONTH</td>--></tr></thead>

                    <?php
                    for ($i = 1; $i <= count($epin_setting); $i++)
                    {
                        ?>

                        <tr>

                            <td><?= $i; ?></td>

                            <td><input type="text" name="epin_d<?= $i ?>" value="<?= $epin_setting[$i][0] ?>" /></td>

                                                                                                                                                                                                                                                                                                                                                                                            <!--<td><input type="text" name="epin_w<?= $i ?>" value="<?= $epin_setting[$i][1] ?>" /></td>

                                                                                                                                                                                                                                                                                                                                                                                            <td><input type="text" name="epin_m<?= $i ?>" value="<?= $epin_setting[$i][2] ?>" /></td>-->



                        </tr>

                        <?php
                    }
                    ?>

                </table>

            </td>

        </tr>
		
		<thead><tr><th colspan="7">Time Frozen/Block Setting</th></tr></thead>

        <tr>

            <td colspan="7">

                <table class="table table-bordered">

                    <thead><tr><td>Time Block</td><td>Time Frozen</td><td>Frozen % downline</td><td>Time Report</td></tr></thead>
                    <tr>
                        <td><input type="text" name="time_block" value="<?=$time_block?>" /> hour</td>
                        <td><input type="text" name="time_frozen" value="<?=$time_frozen?>" /> hour</td>
                        <td><input type="text" name="frozen_downline" value="<?=$frozen_downline?>" /> % member</td>
                        <td><input type="text" name="time_report" value="<?=$time_report?>" /> time</td>
                    </tr>
                </table>

            </td>

        </tr>
		
		<thead>
            <tr>
                <th colspan="7">Unblock/Unfreeze fees</th>
            </tr> 
        </thead>
        <tr>
            <td colspan="7">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Time</th>
                            <th>Freeze</th>
                            <th>Block</th>
                        </tr>
                    </thead>
                    <?php
                    $query_level = mysql_query("select * from tb_block_fee ");
                    $rows_list = find($query_level);
                    $arr_time = '';
                    if (!empty($rows_list))
                    {
                        foreach ($rows_list as $value)
                        {
                            $arr_time .= $value['id'].',';
                            ?>
                            <tr>
                                <td style="width:10px"><input type="checkbox" name="check_time[]" value="<?= $value['id'] ?>"></td>
                                <td><?= $value['time'] ?></td>
                                <td><input type="text" name="frozen<?= $value['id'] ?>" value="<?= $value['frozen'] ?>" /></td>
                                <td><input type="text" name="block<?= $value['id'] ?>" value="<?= $value['block'] ?>" /></td>
                            </tr>

                            <?php
                        }
                    }
                    ?>
                    <tr>
                        <td colspan="5" class="text-right"><input type="submit" name="submit" value="Add Time" class="btn btn-info"  /> <input type="submit" name="submit" value="Delete Time" class="btn btn-danger"  /></td>
                    </tr>
                    <input type="hidden" name="block_count" value="<?=$arr_time?>">
					<input type="hidden" name="block_time" value="<?= count($rows_list) ?>">
                </table>
            </td>
        </tr>


        <tr>

            <td colspan="2">

                <table class="table table-bordered">

                    <thead><tr><th colspan="7">Link Time Limit Setting</th></tr></thead>

                        <thead><tr><td>Level</td><td>Hour</td><!--<td>WEEK</td><td>MONTH</td>--></tr></thead>

                    <?php
                    for ($i = 1; $i <= count($max_time); $i++)
                    {
                        ?>

                        <tr>

                            <td><?= $i; ?></td>

                            <td><input type="text" name="link_time<?= $i ?>" value="<?= $max_time[$i] ?>" /></td>

                        </tr>

                        <?php
                    }
                    ?>

                </table>

            </td>

            <td colspan="2">

                <table class="table table-bordered">

                    <thead><tr><th colspan="7">Re PD Time Limit Setting</th></tr></thead>

                        <thead><tr><td>Level</td><td>Hour</td><!--<td>WEEK</td><td>MONTH</td>--></tr></thead>

                    <?php
                    for ($i = 1; $i <= count($re_pd_time); $i++)
                    {
                        ?>

                        <tr>

                            <td><?= $i; ?></td>

                            <td><input type="text" name="re_pd_time<?= $i ?>" value="<?= $re_pd_time[$i] ?>" /></td>

                        </tr>

                        <?php
                    }
                    ?>

                </table>

            </td>

            <td colspan="2">

                <table class="table table-bordered">

                    <thead><tr><th colspan="7">GD Link Time Limit Setting</th></tr></thead>

                    <tr>

                        <th>Hour</th>

                        <td><input type="text" name="gd_link_time" value="<?= $gd_time ?>" /></td>

                    </tr>



                </table>

            </td>

        </tr>

        <tr>

            <td colspan="7" class="text-center">

                <input type="submit" name="submit" value="Update" class="btn btn-info" />

            </td>

        </tr>

    </form>

</table>
