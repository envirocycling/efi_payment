<?php
@session_start();
include('configPhp.php');
$user_id=$_SESSION['user_id'];
$current_pass=$_POST['current_pass'];
$new_pass=$_POST['new_pass'];
$confirm_pass=$_POST['confirm_pass'];

$query="SELECT * FROM users where user_id='$user_id'";
$result=mysql_query($query);
$row = mysql_fetch_array($result);
$old_password=$row['password'];


if($new_pass=='' || $current_pass =='' || $confirm_pass=='') {
    echo "<script>
alert('Please fill out all fields');
window.location = 'settings.php';
</script>";
} else if($current_pass != $old_password) {
    echo "<script>
alert('The current password you entered does not match.');
window.location = 'settings.php';
</script>";
} else if($new_pass != $confirm_pass) {
    echo "<script>
alert('confirmation and new password did not match');
window.location = 'settings.php';
</script>";
} else {
    mysql_query("UPDATE users set password='$new_pass' where user_id='$user_id'");
    echo "<script>
alert('Password changed successfully!!!');
window.location = 'settings.php';
</script>";
}
?>