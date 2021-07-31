<?php

include("configPhp.php");
@session_start();
$ctr = 0;
while ($ctr < $_POST['ctr']) {
    if (isset($_POST['cv_' . $ctr])) {
        $sql_payment_det = mysql_query("SELECT * FROM payment WHERE payment_id='" . $_POST['cv_' . $ctr] . "'");
        $rs_payment_det = mysql_fetch_array($sql_payment_det);
        mysql_query("UPDATE payment SET status='cancelled',remarks='".$_POST['remarks']."' WHERE payment_id='" . $_POST['cv_' . $ctr] . "'");
    }
    $ctr++;
}
echo "<script>";
echo "alert('Successfully.');";
echo "location.replace('generate_pos.php');";
echo "</script>";
?>