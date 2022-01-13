<?php date_default_timezone_set("Asia/Manila");

$host = "localhost";
$username = "efi_paydb";
$password = "Hesoyams18";
$database = "efi_paydb";

$con = new mysqli($host, $username, $password, $database);

if($con->connect_error) {
	echo $con->connect_error;
}

$base_url = 'http://paymentsystem.efi.net.ph/user-login/maker';

// $host = "localhost";
// $username = "root";
// $password = "";
// $database = "efi_paydb";

// $con = new mysqli($host, $username, $password, $database);

// if($con->connect_error) {
// 	echo $con->connect_error;
// }

// $base_url = 'http://localhost:8081/efi_payment/user-login/maker';

?>