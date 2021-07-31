<?php
@session_start();
include("configPhp.php");
$file=$_FILES['attachment']['tmp_name'];
$image= addslashes(file_get_contents($_FILES['attachment']['tmp_name']));
$image_name= addslashes($_FILES['attachment']['name']);
$image_size= getimagesize($_FILES['attachment']['tmp_name']);

move_uploaded_file($_FILES["attachment"]["tmp_name"],"../../signatures/" . $_SESSION['initial'].".jpg");
$attachment="../../signatures/" . $_SESSION['initial'].".jpg";


if($image_size==False) {
    echo "<script>";
    echo "alert('Error this file is not an image.');";
    echo "window.history.back();";
    echo "</script>";
} else {
    mysql_query("UPDATE users SET signature='$attachment' WHERE user_id='".$_SESSION['user_id']."'");
    $_SESSION['signature'] = $attachment;
    echo "<script>";
    echo "alert('Successfully Update');";
    echo "location.replace('settings.php.');";
    echo "</script>";

}
?>