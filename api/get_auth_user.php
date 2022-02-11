<?php session_start();

$userID = $_SESSION['user_id'];
$userName = $_SESSION['username'];
$initial = $_SESSION['initial'];
$firstName = $_SESSION['firstname'];
$lastName = $_SESSION['lastname'];
$branch = $_SESSION['branch'];
$position = $_SESSION['position'];

if(isset($useID) && isset($userName)) {
    echo json_encode(array(
        'status' => 200,
        'user' => array(
            'user_id' => $userID,
            'username' => $userName,
            'initial' => $initial,
            'name' => "{$firstName} {$lastName}",
            'branch' => $branch,
            'position' => $position
        )
    ));
} else {
    echo json_encode(array(
        'status' => 402,
        'error' => 'Unauthorized'
    ));
}

?>