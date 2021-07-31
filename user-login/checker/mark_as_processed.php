<?php
date_default_timezone_set("Asia/Singapore");
include("configPhp.php");
$ctr = $_POST['ctr'];
$num = 0;
$suc = 0;
$err = 0;
while($num <= $ctr){
    if(isset($_POST['cv_'.$num])){
        if(mysql_query("UPDATE payment SET status='processed', processed_date='".date('Y/m/d H:i')."' WHERE payment_id = '".$_POST['cv_'.$num]."'") or die(mysql_error())){
            $suc++;
        }else{
            $err++;
        }
    }
    $num++;
}
echo '<script>
        alert("'.$suc.' Record/s Successful and '.$err.' Record/s Error");
        location.replace("index.php");
    </script>';
