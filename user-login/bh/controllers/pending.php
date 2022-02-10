<?php session_start();

if (!isset($_SESSION['bh_id'])) {
    echo "<script>location.replace('../../');</script>";
}


?>