<?php
$con = mysql_connect("efi.net.ph", "efi_ims", "Hesoyams18");
if (!$con) {
    die('Could not connect: ' . mysql_error());
}
mysql_select_db("efi_ims", $con);
?>