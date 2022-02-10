<?php 
session_start();
include_once 'config.php';

$from = $_GET['from'];
$to = $_GET['to'];
$bank = $_GET['bank'];

$branch = $_SESSION['branch'];
$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
$initial = $_SESSION['initial'];
$position = $_SESSION['position'];

if (isset($user_id) && isset($username)) {

    if($username == 'jed' && $user_id = '26') {
        $branch1 = 'Sauyo';
        $branch2 = 'Kaybiga';
        $branch3 = 'Kaybiga';
    } else if($username == 'CJT' && $user_id = '75') {
        $branch1 = 'Sauyo';
        $branch2 = 'Kaybiga';
        $branch3 = 'Kaybiga';
    } else if($username == 'emilrose' && $user_id = '19') {
        $branch1 = 'Pampanga';
        $branch2 = 'San Fernando';
        $branch3 = 'Calumpit';
    } else {
        $branch1 = $branch;
        $branch2 = $branch;
        $branch3 = $branch;
    }   

    if($position == 'Reliever') {
        $query = "SELECT * FROM payment 
        WHERE `status`='' 
        and `bank_code` like '%{$bank}%' 
        and (`branch_code` like '%{$branch1}%' or `branch_code` like '%{$branch2}%' or branch_code like '%{$branch3}%') 
        and `signatory` like '%{$initial}%' 
        and (`date` >= '{$from}' and `date` <= '{$to}');";
    } else {
        $query = "SELECT * FROM payment WHERE `status`='' 
        and `bank_code` like '%{$bank}%'
        and (`branch_code` like '%{$branch1}%' or branch_code like '%{$branch2}%' or branch_code like '%{$branch3}%') 
        and (`date`>='{$from}' and `date`<='$to');";
    }
    
    $result = $con->query($query);
    $payments = $result->fetch_all(MYSQLI_ASSOC);
    $result->free_result();
	$con->close();

    echo json_encode([
        'status' => 200,
        'data' => $payments
    ]);


} else {
    echo json_encode([
        'status' => 402,
        'message' => 'Unauthorized'
    ]);
}


?>