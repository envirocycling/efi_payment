<?php
include("configPhp.php");
mysql_query("Update payment SET status='canceled' Where payment_id='".$_GET['id']."'") or die (mysql_error());
?>