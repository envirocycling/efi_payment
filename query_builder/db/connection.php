<?php

$hostname = 'localhost';
$dbname = 'efi_paydb';
$username = 'root';
$password = '';

$dsn = "mysql:host={$hostname};dbname={$dbname}";

$pdo = new PDO($dsn, $username, $password);

$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

?>