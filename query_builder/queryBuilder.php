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

function getUserAccessControl($userId) {
	include './../../configPhp.php';

	$sql = $con->query("SELECT `branches`.`branch_name` as `branch_name`, `branches`.`bcode` as `branch_code` FROM `user_access_control` as `uac` 
	INNER JOIN `branches` ON `branches`.`branch_id`=`uac`.`branch_id` 
	WHERE `uac`.`user_id`='{$userId}';");
	// Fetch all
	return $sql->fetch_all(MYSQLI_ASSOC);

	// Free result set
	$sql->free_result();
	$con->close();
}

function getBHOnlinePayments($position, $branch, $initial, $from, $to, $status) {

	include './../../configPhp.php';

	if($position == 'Reliever') {
		if($status == 'cancel') {
			$query = "SELECT * FROM payment WHERE (`status`='disapproved' OR `status`='cancelled') and bank_code != 'GCASH' and branch_code like '%{$branch}%' and signatory like '%{$initial}%' and (date >= '{$from}' and date <= '{$to}');";
		} else {
			$query = "SELECT * FROM payment WHERE `status`='{$status}' and bank_code != 'GCASH' and branch_code like '%{$branch}%' and signatory like '%{$initial}%' and (date >= '{$from}' and date <= '{$to}');";
		}
	} else {
		if($status === 'cancel') {
			$query = "SELECT * FROM payment WHERE (`status`='disapproved' OR `status`='cancelled') and bank_code != 'GCASH' and branch_code like '%{$branch}%' and (date>='{$from}' and date<='$to');";
		} else {
			$query = "SELECT * FROM payment WHERE `status`='{$status}' and bank_code != 'GCASH' and branch_code like '%{$branch}%' and (date>='{$from}' and date<='$to');";
		}
	}

	//var_dump($query);


	$sql = $con->query($query);
	// Fetch all
	return $sql->fetch_all(MYSQLI_ASSOC);
	// Free result set
	$sql->free_result();
	$con->close();
}

function getGCashPayments($position, $branch, $initial, $from, $to, $status) {

	include './../../configPhp.php';

	if($position == 'Reliever') {
		if($status === 'cancel') {
			$query = "SELECT * FROM payment WHERE (`status`='disapproved' OR `status`='cancelled') and bank_code = 'GCASH' and branch_code like '%{$branch}%' and signatory like '%{$initial}%' and (date >= '{$from}' and date <= '{$to}');";
		} else {
			$query = "SELECT * FROM payment WHERE `status`='{$status}' and bank_code = 'GCASH' and branch_code like '%{$branch}%' and signatory like '%{$initial}%' and (date >= '{$from}' and date <= '{$to}');";
		}
	} else {
		if($status === 'cancel') {
			$query = "SELECT * FROM payment WHERE (`status`='disapproved' OR `status`='cancelled') and bank_code = 'GCASH' and branch_code like '%{$branch}%' and (date>='{$from}' and date<='$to');";
		} else {
			$query = "SELECT * FROM payment WHERE `status`='{$status}' and bank_code = 'GCASH' and branch_code like '%{$branch}%' and (date>='{$from}' and date<='$to');";
		}
	}

	$sql = $con->query($query);
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