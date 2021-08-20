<?php session_start();?>
<?php
$po_number=$_GET['po_number'];
$key = array_search($po_number, $_SESSION['po_number_list']);

if (false !== $key) {
    unset($_SESSION['po_number_list'][$key]);
}else {
    array_push($_SESSION['po_number_list'],$po_number);
}



?>