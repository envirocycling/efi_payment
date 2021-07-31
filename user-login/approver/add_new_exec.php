<?php
@session_start();
include("configPhp.php");

$sql_check = mysql_query("SELECT * FROM users WHERE username='".$_POST['username']."'");
$rs_check = mysql_num_rows($sql_check);
if ($rs_check > 0) {
    echo "<script>";
    echo "alert('Username already taken.');";
    echo "history.back();";
    echo "</script>";
} else {
    mysql_query("INSERT INTO users (`username`, `password`, `firstname`, `lastname`, `initial`, `branch`, `position`, `usertype`)
        VALUES ('".$_POST['username']."','".$_POST['password']."','".$_POST['firstname']."','".$_POST['lastname']."','".strtoupper($_POST['initial'])."','".$_SESSION['branch']."','Reliever','1')");
    echo "<script>";
    echo "alert('Successfully Added.');";
    echo "location.replace('reliever_accounts.php');";
    echo "</script>";
}

?>
