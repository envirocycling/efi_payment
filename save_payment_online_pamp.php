<?php include 'configPhp.php';

$payment_id = $_POST['payment_id'];
$bank_code = $_POST['bank_code'];
$cheque_no = $_POST['cheque_no'];
$voucher_no = $_POST['voucher_no'];
$voucher_noo = $_POST['voucher_noo'];
$cheque_name = $_POST['cheque_name'];
$supplier_name = $_POST['supplier_name'];
$sub_total = $_POST['sub_total'];
$ts_fee = $_POST['ts_fee'];
$adjustments = $_POST['adjustments'];
$grand_total = $_POST['grand_total'];
$account_name = $_POST['account_name'];
$account_number = $_POST['account_number'];
$ap = $_POST['ap'];
$verifier = $_POST['verifier'];
$signatory = $_POST['signatory'];
$url = $_POST['url'];

$que_url = preg_split("[/]",$url);

if ($account_name == '' || $account_number ='') {
    ?>
<script>
    alert('This account does not have a SBC Account.');
    location.replace('http://192.168.1.119/paymentsystem/pending_crs.phpp');
</script>
    <?php
} else {

    $sql_check = mysql_query("SELECT * FROM payment WHERE branch_code='$payment_id'");
    $rs_num_row = mysql_num_rows($sql_check);

    if ($rs_num_row == 0) {

        $con->query("INSERT INTO `payment`(`branch_code`, `bank_code`, `cheque_no`, `voucher_no`, `cheque_name`, `supplier_name`, `sub_total`, `ts_fee`, `adjustments`, `grand_total`, `account_name`, `account_number`, `ap`, `verifier`, `signatory`,`date`)
        VALUES ('$payment_id','$bank_code','$cheque_no','$voucher_no','$cheque_name','$supplier_name','$sub_total','$ts_fee','$adjustments','$grand_total','$account_name','$account_number','$ap','$verifier','$signatory','".date("Y/m/d")."')");

        $ctr = 0;

        while ($ctr < $_POST['ctr_adj']) {

            $adj_type = $_POST['adj_type'.$ctr];
            $desc = $_POST['desc'.$ctr];
            $amount = $_POST['amount'.$ctr];

            $con->query("INSERT INTO `payment_adjustment`(`payment_id`, `adj_type`, `desc`, `amount`)
        VALUES ('$payment_id','$adj_type','$desc','$amount')");
            
            $ctr++;
        }

        $ctr = 0;

        while ($ctr < $_POST['rec_det_adj']) {

            $wp_grade = $_POST['wp_grade'.$ctr];
            $net_weight = $_POST['net_weight'.$ctr];
            $price = $_POST['price'.$ctr];
            $amount = $_POST['amount2'.$ctr];
            $con->query("INSERT INTO `payment_details`(`payment_id`, `wp_grade`, `net_weight`, `price`, `amount`)
            VALUES ('$payment_id','$wp_grade','$net_weight','$price','$amount')");
            $ctr++;
        }

        echo "<form action='http://192.168.1.119/paymentsystem/received_payment.php' method='POST' name='myForm'>";
        echo "<input type='hidden' name='payment_id' value='$payment_id'>";
        echo "<input type='hidden' name='voucher_no' value='$voucher_noo'>";
        echo "</form>";
        echo "
<script>
    document.myForm.submit();
</script>";
    } else {

        ?>
<script>
    alert('This payment already submitted online.');
    location.replace('http://192.168.1.119/paymentsystem/pending_crs.phpp');
</script>
        <?php
    }
}
?>