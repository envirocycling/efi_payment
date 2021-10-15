<?php

include 'configPhp.php';

$posted = isset($_POST['submit']);
$success = false;
$message = '';

if($posted) {
    
    $voucher = trim($_POST['voucher']);
    
    if($voucher === '') {
        $success = false;
        $message = 'Voucher # must not empty'; 
    } else {
        
        $q = $con->query("SELECT * FROM `payment` WHERE `voucher_no` LIKE '{$voucher}'");
        $num_rows = $q->num_rows;
        
        if($num_rows >= 1) {

            $ddate = date('Y/m/d');
            $dtime = date('H:i');
            
            $res = $con->query("UPDATE `payment` SET `status`='disapproved', `disapproved_date`='{$ddate}',`disapproved_time`='{$dtime}' WHERE `voucher_no`='{$voucher}';");
            
            if($res) {
                $success = true;
                $message = "Okay na :D";
            } else {
                $success = false;
                $message = "Something went wrong.";
            }
            
        } else {
            
            $success = false;
            $message = "Payment Not found with Voucher#: {$voucher}"; 
            
        }
        
    }
    
}


?>

<style>
    
    .wrapper {
        background: #ccc;
        padding: 30px; 
        border: 1px solid #000;
        position: absolute; 
        left: 50%;
        top: 10%; 
        transform: translateX(-50%);
    }
    
    
    .output {
        color: #fff;
        display: block;
        margin-top: 10px;
        padding: 5px;
        text-align: center;
    }
    
    .success {
        background: green;
    }
    
    .error {
        background: red;
    }
    

</style>

<div class="wrapper">
    <form method="POST">

        <h3>Cancel Payment</h3>
        
        <div>
            <label>Enter Voucher #: </label>
            <input type="text" name="voucher">
            <button type="submit" name="submit">Cancel</button>
        </div>
        
        <?php if($posted): ?>
        <div class="output <?= ($success) ? 'success' : 'error'?>">
            <?=$message?>
        </div>    
        <?php endif; ?>
    </form>
</div>

