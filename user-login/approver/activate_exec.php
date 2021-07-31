<?php
@session_start();
include("configPhp.php");
if ($_POST['from'] < date("Y/m/d")) {
    echo "<script>";
    echo "alert('Error range1.');";
    echo "history.back();";
    echo "</script>";
} else if ($_POST['from'] > $_POST['to']) {
    echo "<script>";
    echo "alert('Error range2.');";
    echo "history.back();";
    echo "</script>";
} else {
    $sql_check = mysql_query("SELECT * FROM reliever_activate WHERE `user_id`='".$_POST['user_id']."' and `date_from`='".$_POST['from']."' and `date_to`='".$_POST['to']."'");
    $rs_check = mysql_num_rows($sql_check);
    echo $rs_check;
    if ($rs_check > 0) {
        echo "<script>";
        echo "alert('Data already inserted.');";
        echo "history.back();";
        echo "</script>";
    } else {
        mysql_query("INSERT INTO reliever_activate (user_id, date_from, date_to, encoded_by, date_activate)
        VALUES ('".$_POST['user_id']."','".$_POST['from']."','".$_POST['to']."','".$_SESSION['user_id']."','".date("Y/m/d")."')");
        echo "<script>";
        echo "alert('Successfully Added.');";
        echo "location.replace('reliever_accounts.php');";
        echo "</script>";
    }
}

?>












