<?php
session_start();
include('configPhp.php');

$username = $_POST['username'];
$password = $_POST['password'];

$query = $con->query("SELECT * FROM users WHERE username='$username' and password='$password'");
$users = $query->fetch_assoc();
$check = $query->num_rows;

if ($check < 1) {

    echo "<script>";
    echo "location.replace('index.php?error=1');";
    echo "</script>";

} else if ($users['status'] == 'deactivated') {

    echo "<script>";
    echo "location.replace('index.php?error=1');";
    echo "</script>";

} else {

    $_SESSION['user_id'] = $users['user_id'];
    $_SESSION['username'] = $users['username'];
    $_SESSION['password'] = $users['password'];
    $_SESSION['initial'] = $users['initial'];
    $_SESSION['firstname'] = $users['firstname'];
    $_SESSION['lastname'] = $users['lastname'];
    $_SESSION['branch'] = $users['branch'];
    $_SESSION['position'] = $users['position'];
    $_SESSION['user_type'] = $users['usertype'];
    $_SESSION['signature'] = $users['signature'];

    if ($_SESSION['user_type'] == '1') {

        if ($users['position'] == 'Reliever') {

            $sql_act = $con->query("SELECT * FROM reliever_activate WHERE user_id='".$users['user_id']."' ORDER BY date_to DESC");
            $users_count = $sql_act->num_rows;
            $users_act = $sql_act->fetch_assoc();

            if ($users_count == 0 || $users_act['date_to'] < date("Y/m/d")) {
                echo "<script>";
                echo "alert('Your account is deactivated.');";
                echo "location.replace('index.php');";
                echo "</script>";
            } else {
                $_SESSION['approver_id'] = $users['user_id'];
                echo "<script>";
                echo "location.replace('user-login/approver/');";
                echo "</script>";
            }
        } else {
            $_SESSION['approver_id'] = $users['user_id'];
            echo "<script>";
            echo "location.replace('user-login/approver/');";
            echo "</script>";
        }
    }
    if ($_SESSION['user_type'] == '2') {
        $_SESSION['verifier_id'] = $users['user_id'];
        echo "<script>";
        echo "location.replace('user-login/verifier/');";
        echo "</script>";
    }
    if ($_SESSION['user_type'] == '3') {
        $_SESSION['acctg_id'] = $users['user_id'];
        echo "<script>";
        echo "location.replace('user-login/maker/index_new.php?branch=Pampanga');";
        echo "</script>";
    }

    if ($_SESSION['user_type'] == '6') {
        $_SESSION['acctg_id'] = $users['user_id'];
        echo "<script>";
        echo "location.replace('user-login/checker/');";
        echo "</script>";
    }

    if ($_SESSION['user_type'] == '4') {

        if ($users['position'] == 'Reliever') {

            $sql_act = $con->query("SELECT * FROM reliever_activate WHERE user_id='".$users['user_id']."' ORDER BY date_to DESC");
            $users_count = $sql_act->num_rows;
            $users_act = $sql_act->fetch_assoc();

            if ($users_count == 0 || $users_act['date_to'] < date("Y/m/d")) {
                echo "<script>";
                echo "alert('Your account is deactivated.');";
                echo "location.replace('index.php');";
                echo "</script>";
            } else {
                $_SESSION['bh_id'] = $users['user_id'];
                echo "<script>";
                echo "location.replace('user-login/bh/');";
                echo "</script>";
            }
        } else {
            $_SESSION['bh_id'] = $users['user_id'];
            echo "<script>";
            echo "location.replace('user-login/bh/');";
            echo "</script>";
        }
    }

    if ($_SESSION['user_type'] == '5') {
        $_SESSION['ap_id'] = $users['user_id'];
        echo "<script>";
        echo "location.replace('user-login/ap/');";
        echo "</script>";
    }  if ($_SESSION['user_type'] == '0') {
        $_SESSION['admin_id'] = $users['user_id'];
        echo "<script>";
        echo "location.replace('user-login/admin/index1.php');";
        echo "</script>";
    }

}
?>