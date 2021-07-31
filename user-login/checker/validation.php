<?php
session_start();
include('configPhp.php');
$username = $_POST['username'];
$password = $_POST['password'];
$sql = mysql_query("SELECT * FROM users WHERE username='$username' and password='$password'");
$check = mysql_num_rows($sql);
$rs = mysql_fetch_array($sql);
if ($check < 1) {
    echo "<script>";
    echo "location.replace('index.php?error=1');";
    echo "</script>";
} else if ($rs['status'] == 'deactivated') {
    echo "<script>";
    echo "location.replace('index.php?error=1');";
    echo "</script>";
} else {
    $_SESSION['user_id'] = $rs['user_id'];
    $_SESSION['username'] = $rs['username'];
    $_SESSION['password'] = $rs['password'];
    $_SESSION['initial'] = $rs['initial'];
    $_SESSION['firstname'] = $rs['firstname'];
    $_SESSION['lastname'] = $rs['lastname'];
    $_SESSION['branch'] = $rs['branch'];
    $_SESSION['position'] = $rs['position'];
    $_SESSION['user_type'] = $rs['usertype'];
    $_SESSION['signature'] = $rs['signature'];
    if ($_SESSION['user_type'] == '1') {
        if ($rs['position'] == 'Reliever') {
            $sql_act = mysql_query("SELECT * FROM reliever_activate WHERE user_id='".$rs['user_id']."' ORDER BY date_to DESC");
            $rs_count = mysql_num_rows($sql_act);
            $rs_act = mysql_fetch_array($sql_act);
            if ($rs_count == 0 || $rs_act['date_to'] < date("Y/m/d")) {
                echo "<script>";
                echo "alert('Your account is deactivated.');";
                echo "location.replace('index.php');";
                echo "</script>";
            } else {
                $_SESSION['approver_id'] = $rs['user_id'];
                echo "<script>";
                echo "location.replace('user-login/approver/');";
                echo "</script>";
            }
        } else {
            $_SESSION['approver_id'] = $rs['user_id'];
            echo "<script>";
            echo "location.replace('user-login/approver/');";
            echo "</script>";
        }
    }
    if ($_SESSION['user_type'] == '2') {
        $_SESSION['verifier_id'] = $rs['user_id'];
        echo "<script>";
        echo "location.replace('user-login/verifier/');";
        echo "</script>";
    }
    if ($_SESSION['user_type'] == '3') {
        $_SESSION['acctg_id'] = $rs['user_id'];
        echo "<script>";
        echo "location.replace('user-login/maker/index_new.php?branch=Pampanga');";
        echo "</script>";
    }
    if ($_SESSION['user_type'] == '4') {
        if ($rs['position'] == 'Reliever') {
            $sql_act = mysql_query("SELECT * FROM reliever_activate WHERE user_id='".$rs['user_id']."' ORDER BY date_to DESC");
            $rs_count = mysql_num_rows($sql_act);
            $rs_act = mysql_fetch_array($sql_act);
            if ($rs_count == 0 || $rs_act['date_to'] < date("Y/m/d")) {
                echo "<script>";
                echo "alert('Your account is deactivated.');";
                echo "location.replace('index.php');";
                echo "</script>";
            } else {
                $_SESSION['bh_id'] = $rs['user_id'];
                echo "<script>";
                echo "location.replace('user-login/branch-head/');";
                echo "</script>";
            }
        } else {
            $_SESSION['bh_id'] = $rs['user_id'];
            echo "<script>";
            echo "location.replace('user-login/branch-head/');";
            echo "</script>";
        }
    }
    if ($_SESSION['user_type'] == '5') {
        $_SESSION['ap_id'] = $rs['user_id'];
        echo "<script>";
        echo "location.replace('user-login/ap/');";
        echo "</script>";
    }  if ($_SESSION['user_type'] == '0') {
        $_SESSION['admin_id'] = $rs['user_id'];
        echo "<script>";
        echo "location.replace('user-login/admin/index1.php');";
        echo "</script>";
    }
}
?>