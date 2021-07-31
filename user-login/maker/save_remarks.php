<?php
session_start();
include 'configPhp.php';

mysql_query("UPDATE payment SET remarks='".$_POST['remarks']."' WHERE payment_id='".$_POST['id']."'");

?>