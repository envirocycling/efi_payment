<?php 

function Query($q) {

	include './../../configPhp.php';

	$sql = $con->query($q);
	// Fetch all
	return $sql->fetch_all(MYSQLI_ASSOC);
	// Free result set
	$sql->free_result();
	$con->close();
}

function getPendingPayments($bank, $branch, $start, $end) {

	include './../../configPhp.php';

	$sql = $con->query("SELECT * FROM `payment` WHERE `branch_code` LIKE '%{$branch}%' AND bank_code LIKE '%{$bank}%' AND (`date`>='{$start}' AND `date`<='{$end}') AND `status`='';");
	// Fetch all
	return $sql->fetch_all(MYSQLI_ASSOC);
	// Free result set
	$sql->free_result();
	$con->close();
}

function getGeneratedPayments($bank, $branch, $start, $end) {

	include './../../configPhp.php';

	$sql = $con->query("SELECT * FROM `payment` WHERE `branch_code` LIKE '%{$branch}%' AND bank_code LIKE '%{$bank}%' AND (`date`>='{$start}' AND `date`<='{$end}') AND `status`='generated' AND `printed`='1';");
	// Fetch all
	return $sql->fetch_all(MYSQLI_ASSOC);
	// Free result set
	$sql->free_result();
	$con->close();
}

function getCancelledPayments($bank, $branch, $start, $end) {

	include './../../configPhp.php';

	$sql = $con->query("SELECT * FROM `payment` WHERE `branch_code` LIKE '%{$branch}%' AND bank_code LIKE '%{$bank}%' AND (`date`>='{$start}' AND `date`<='{$end}') AND (`status`='cancelled' OR `status`='disapproved');");
	// Fetch all
	return $sql->fetch_all(MYSQLI_ASSOC);
	// Free result set
	$sql->free_result();
	$con->close();
}

 ?>