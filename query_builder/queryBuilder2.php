<?php

include_once 'db/connection.php';
include_once 'helpers/helpers.php';

function fetch($query, $params) {

	global $pdo;

	$q = $pdo->prepare($query);
	$q->execute($params);
	return $q->fetchAll();

}

function getFirst($query, $params) {

	global $pdo;

	$q = $pdo->prepare($query);
	$q->execute($params);
	$response = $q->fetchAll();

	if (count($response) > 0) {
		return $response[0];
	}

	return null;

}

function getWhere($table, $field, $value) {
	$query = "SELECT * FROM {$table} WHERE {$field} = ? LIMIT 1;";
	return fetch($query, $value);
}


// Query builder
function getGrades() {
	$query = "SELECT * FROM wp_codes GROUP BY major_class ORDER BY wp_code desc;";
	return fetch($query, null);
}


function getBranches() {
	return fetch("SELECT * FROM `branches`;", null);
}


function getTargets() {

	global $month, $branch;

	$query = "SELECT sum(target) as target,wp_grade FROM monthly_target WHERE `month` = '{$month}' and branch like '%{$branch}%' GROUP BY wp_grade;";
	return fetch($query, null);
}

function getTargetsAll() {

	global $branch, $month;

	$query = "SELECT sum(target) as target,wp_grade FROM monthly_target WHERE `month` = '{$month}' AND (`branch` LIKE '%{$branch}%' AND `branch` != '') GROUP BY wp_grade;";
	return fetch($query, null);
}


function getActuals() {

	global $branch, $from, $to;

	$query = "SELECT weight,wp_grade FROM sales WHERE (branch LIKE '%$branch%' AND branch != '') AND (date >= '$from' AND date <='$to') AND wp_grade != '' AND `weight` != 0;";

	//dd($query);

	return fetch($query, null);
}

function getActualsTipco() {

	global $branch, $from, $to;

	$query = "SELECT weight,wp_grade,delivered_to FROM sales WHERE (`branch` LIKE '%{$branch}%' AND `branch` != '') AND (`date` >= '{$from}' AND `date` <= '{$to}') AND wp_grade != '';";

	//dd($query);

	return fetch($query, null);
}


function getActualBranches() {

	global $from, $to;

	$query = "SELECT DISTINCT `branch` FROM sales WHERE branch != '' AND (date >= '$from' AND date <='$to') AND wp_grade != '' AND `weight` != 0;";

	return fetch($query, null);
}

function getClientSalesBranches() {

	global $deliver_to, $from, $to;

	$query = "SELECT DISTINCT `branch` FROM sales WHERE branch != '' AND (date >= '$from' AND date <='$to') AND `delivered_to` LIKE '%{$deliver_to}%' AND wp_grade != '' AND `weight` != 0;";

	return fetch($query, null);
}



function getActualByBranch($branch) {

	global $from, $to;

	$query = "SELECT weight,wp_grade FROM sales WHERE branch LIKE '%$branch%' AND (date >= '$from' AND date <='$to') AND wp_grade != '' AND `weight` != 0;";

	return fetch($query, null);
}

function getClientSalesByBranch($branch) {

	global $deliver_to, $from, $to;

	$query = "SELECT weight,wp_grade FROM sales WHERE branch LIKE '%$branch%' AND (date >= '$from' AND date <='$to') AND `delivered_to` LIKE '%{$deliver_to}%' AND wp_grade != '' AND `weight` != 0;";

	return fetch($query, null);
}



function getOutgoingDates() {

	global $branch, $from, $to;

	$query = "SELECT DISTINCT `date` as date FROM `outgoing` WHERE (`branch` LIKE '%{$branch}%' AND `branch` != '') AND (`date` >= '{$from}' AND `date` <= '{$to}') AND `wp_grade` != '' AND `weight` != 0 ORDER BY DATE ASC;";
	return fetch($query, null);
}



function getSalesDates() {

	global $branch, $from, $to;

	$query = "SELECT DISTINCT `date` as date FROM `sales` where (`branch` LIKE '%{$branch}%' AND `branch` != '') AND (`date` >= '{$from}' AND `date` <= '{$to}') AND `wp_grade` != '' AND `weight` != 0 ORDER BY DATE ASC;";

	return fetch($query, null);
}


function getSales() {

	global $branch,$from, $to;

	$query = "SELECT weight, `date`, `wp_grade` FROM `sales` WHERE (`branch` LIKE '%{$branch}%' AND branch != '') AND (`date` >= '{$from}' AND `date` <= '{$to}') AND `wp_grade` != '' AND `weight` != 0;";

	return fetch($query, null);
}


function getClientSalesDates() {

	global $deliver_to, $from, $to;

	$query = "SELECT DISTINCT `date` as date FROM `sales` where `branch` != '' AND (`date` >= '{$from}' AND `date` <= '{$to}') AND `delivered_to` LIKE '%{$deliver_to}%'  AND `wp_grade` != '' AND `weight` != 0 ORDER BY DATE ASC;";
	return fetch($query, null);
}


function getClientSales() {

	global $deliver_to, $from, $to;

	$query = "SELECT weight, `date`, `wp_grade` FROM `sales` WHERE `branch` != '' AND (`date` >= '{$from}' AND `date` <= '{$to}') AND delivered_to LIKE '%{$deliver_to}%' AND `wp_grade` != '' AND `weight` != 0;";


	return fetch($query, null);
}


function getOutgoings() {

	global $branch,$from, $to;

	$query = "SELECT `weight`, `date`, `wp_grade` FROM `outgoing` WHERE (`branch` LIKE '%{$branch}%' AND  `branch` != '') AND (`date` >= '{$from}' AND `date` <= '{$to}') AND `wp_grade` != '' AND `weight` != 0;";

	return fetch($query, null);
}


function getReceivingDates() {

	global $branch, $from, $to;

	$query = "SELECT DISTINCT `date_delivered` as date FROM `sup_deliveries` WHERE (`branch_delivered` LIKE '%{$branch}%' AND `branch_delivered` != '') AND (`date_delivered` >= '{$from}' AND `date_delivered` <= '{$to}') AND `wp_grade` !='' AND `weight` != 0 ORDER BY `date_delivered` ASC";
	return fetch($query, null);
}

function getReceivings() {

	global $branch,$from, $to;

	$query = "SELECT weight,date_delivered as date , `wp_grade` FROM `sup_deliveries` WHERE (`branch_delivered` like '%{$branch}%' AND `branch_delivered` != '') AND (`date_delivered` >= '{$from}' AND `date_delivered` <= '{$to}') AND `wp_grade` != '' AND `weight` != 0;";

	return fetch($query, null);
}


function getReceivingsAll() {

	global $branch, $from, $to;

	$query = "SELECT weight,`wp_grade` FROM `sup_deliveries` WHERE (`branch_delivered` LIKE '%{$branch}%' AND `branch_delivered` != '') AND (`date_delivered` >= '{$from}' AND `date_delivered` <= '{$to}') AND `weight` != 0 AND `wp_grade` != '';";

	return fetch($query, null);
}

?>