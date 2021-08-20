<?php
include("configPhp.php");
$po_number=$_GET['po_number'];

if(mysql_query("UPDATE check_voucher set bh_signature='LLR.jpg' where po_number='$po_number' " )) {

    echo "<script>";
    echo "alert('Payment Order has been approved successfully and has been queued for payment');";
    echo "window.history.back()";
    echo "</script>";

}else {
    echo "<script>";
    echo "alert('Failed to attach signature,, please try again...');";
    echo "window.history.back()";
    echo "</script>";
}

?>