<?PHP
session_start();
include("condition.php");

include("function/setting.php");

include("function/functions.php");

//include("function/sendmail.php");

$id = $_SESSION['ebank_user_id'];



$password = get_user_password($id);

if (isset($_SESSION['fog_pass']))
{

    echo "<B style=\"color:#008000;\">" . $_SESSION['fog_pass'] . "</B>";

    unset($_SESSION['fog_pass']);
}

if (isset($_POST['change_password']))
{

    $old_password = $_REQUEST['old_password'];

    $new_password = $_REQUEST['new_password'];

    $con_new_password = $_REQUEST['con_new_password'];



    $q = mysql_query("select * from users where id_user = '$id' and password = '$old_password' ");

    $num = mysql_fetch_array($q);

    if ($num > 0)
    {

        if ($new_password == $con_new_password)
        {

            $sql = "UPDATE users SET password = '$new_password' WHERE id_user = '$id'";

            $insert_q = mysql_query($sql);



            $username = get_user_name($id);

            $date = date('Y-m-d');

            $updated_by = $username . " Your self";

            include("function/logs_messages.php");

            data_logs($id, $data_log[2][0], $data_log[2][1], $log_type[1]);



            echo "<B style=\"color:#008000;\">$pass_update </B>";
        }
        else
        {
            echo "<B style=\"color:#FF0000;\">$confirm_pass</B>";
        }
    }
    else
    {
        echo "<B style=\"color:#FF0000;\">$correct_pass</B>";
    }
}
elseif (isset($_POST['change_sec_code']))
{

    $old_sec_code = $_REQUEST['old_sec_code'];

    $new_sec_code = $_REQUEST['new_sec_code'];

    $con_sec_code = $_REQUEST['con_sec_code'];



    $q = mysql_query("select * from users where id_user = '$id' and user_pin = '$old_sec_code' ");

    $num = mysql_fetch_array($q);

    if ($num > 0)
    {

        if ($new_sec_code == $con_sec_code)
        {

            $sql = "UPDATE users SET user_pin = '$new_sec_code' WHERE id_user = '$id'";

            $insert_q = mysql_query($sql);



            $username = get_user_name($id);

            $date = date('Y-m-d');

            $updated_by = $username . " Your self";

            include("function/logs_messages.php");

            data_logs($id, $data_log[2][0], $data_log[2][1], $log_type[1]);



            echo "<B style=\"color:#008000;\">Security Code Updated Successfully</B>";
        }
        else
        {
            echo "<B style=\"color:#FF0000;\">Please enter correct confirm Security Code</B>";
        }
    }
    else
    {
        echo "<B style=\"color:#FF0000;\">Please Enter Correct Old Security Code !</B>";
    }
}
elseif (isset($_POST['confirm']))
{

    $sql = "select * from users where id_user = '$id' ";

    $query = mysql_query($sql);

    $num = mysql_num_rows($query);

    while ($row = mysql_fetch_array($query))
    {

        $user_pin = $row['user_pin'];

        $username = $row['username '];

        $to = $row['email'];
    }

    $_SESSION['fog_pass'] = "We have sent the Security Code to your E-mail !!";

    $title = 'Security Code';

    $full_message = 'Your security code is ' . $user_pin . " www.ebank.tv";

    $email = $to;
    $name  = $username;
    $title = 'Security Code';
    $content = 'Your security code is ' . $user_pin . "";
    sendMail($email,$name,$title,$content);
    echo '<script type="text/javascript">';

    echo 'window.location="index.php?page=edit-password";';

    echo '</script>';
}
?>

<script type="text/javascript" src="js/provide_donation.js"></script>



    <div class="col-lg-6 col-xs-12">

        <div class="box box-primary" style="padding-bottom: 20px"> 

            <div class="box-header"><h3 class="box-title">Password</h3></div>

            <form name="change_pass"  class="form-horizontal"  action="index.php?page=edit-password" method="post">
                <div class="form-group">
                    <label class="col-sm-4 control-label"><?= $Old_Password; ?></label>
                    <div class="col-sm-8">
                        <input type="password" class="form-control col-lg-11" name="old_password" value="<?= $password; ?>" >
                    </div>
                </div>
                <div class="form-group">
                    <label  class="col-sm-4 control-label"><?= $New_Password ?></label>
                    <div class="col-sm-8">
                        <input type="password" class="form-control col-lg-11"  name="new_password" required>
                    </div>
                </div>
                <div class="form-group">
                    <label  class="col-sm-4 control-label"><?= $Confirm_Password; ?></label>
                    <div class="col-sm-8">
                        <input type="password" class="form-control col-lg-11"  name="con_new_password" required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-8">
                        <button type="submit" name="change_password" class="btn btn-primary">Update</button>
                    </div>
                </div>
<!--                <table class="table table-bordered table-hover">

                    <tr><td colspan="2">&nbsp;</td></tr>

                    <tr>

                        <td><span><?= $Old_Password; ?></span></td>

                        <td><input type="password" name="old_password" value="<?= $password; ?>" /></td >

                    </tr>

                    <tr><td colspan="2">&nbsp;</td></tr>

                    <tr>

                        <td><?= $New_Password; ?></td>

                        <td><input type="text" name="new_password" required /></td>

                    </tr>

                    <tr><td colspan="2">&nbsp;</td></tr>

                    <tr>

                        <td><?= $Confirm_Password; ?></td>

                        <td><input type="text" name="con_new_password" required /></td>

                    </tr>

                    <tr><td colspan="2">&nbsp;</td></tr>

                    <tr>

                        <td colspan="2" class="text-right" style="padding-right:20px;">

                            <input type="submit" name="change_password" value="Update" class="btn btn-info"/>

                        </td>

                    </tr>

                </table>-->

            </form>

        </div>

    </div>

    <div class="col-lg-6 col-xs-12">

        <div class="box box-primary" style="padding-bottom: 20px"> 

            <div class="box-header"><h3 class="box-title">Security Code</h3></div>

            <form name="change_sec_code" class="form-horizontal" action="index.php?page=edit-password" method="post">
                <div class="form-group">
                    <label class="col-sm-4 control-label">Current Security Code</label>
                    <div class="col-sm-8">
                        <input type="password" class="form-control col-lg-11" name="old_sec_code" required>
                    </div>
                </div>
                <div class="form-group">
                    <label  class="col-sm-4 control-label">New Security Code</label>
                    <div class="col-sm-8">
                        <input type="password" class="form-control col-lg-11"  name="new_sec_code" required>
                    </div>
                </div>
                <div class="form-group">
                    <label  class="col-sm-4 control-label">Confirm Security Code</label>
                    <div class="col-sm-8">
                        <input type="password" class="form-control col-lg-11"  name="con_sec_code" required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-7">
                        <button type="submit" name="change_sec_code" class="btn btn-primary">Update</button>
                        <a href="#dialog-forgot_sec_code" data-toggle="modal" class="pull-right">Forgot Security Code</a>
                    </div>
                </div>

<!--                <table class="table table-bordered table-hover">

                    <tr><td colspan="2">&nbsp;</td></tr>

                    <tr>

                        <td>Current Security Code</td>

                        <td><input type="text" name="old_sec_code" required /></td>

                    </tr>

                    <tr><td colspan="2">&nbsp;</td></tr>

                    <tr>

                        <td><span>New Security Code</span></td>

                        <td><input type="password" name="new_sec_code" /></td >

                    </tr>

                    <tr><td colspan="2">&nbsp;</td></tr>

                    <tr>

                        <td>Confirm Security Code</td>

                        <td><input type="text" name="con_sec_code" required /></td>

                    </tr>

                    <tr><td colspan="2">&nbsp;</td></tr>

                    <tr>

                        <td>

                            <a href="#dialog-forgot_sec_code" data-toggle="modal">Forgot Security Code</a>

                        </td>

                        <td class="text-right" style="padding-right:20px;">

                            <input type="submit" name="change_sec_code" value="Update" class="btn btn-info"/>

                        </td>

                    </tr>

                </table>-->

            </form>

        </div>

    </div>



<?php
include 'box_forgot_sec_code.php';
?>