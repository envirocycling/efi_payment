<?php include 'config.php';

date_default_timezone_set("Asia/Manila");

$data = json_decode(file_get_contents('php://input'));

$payment_id = $data->payment_id;
$bank_code = $data->bank_code;
$cheque_no = $data->cheque_no;
$voucher_no = $data->voucher_no;
$cheque_name = $data->cheque_name;
$supplier_name = mysql_real_escape_string($data->supplier_name);
$sub_total = $data->sub_total;
$ts_fee = $data->ts_fee;
$adjustment = $data->adjustment;
$adjustments = $data->adjustments;
$grand_total = $data->grand_total;
$account_name = mysql_real_escape_string($data->account_name);
$account_number = $data->account_number;
$ap = mysql_real_escape_string($data->ap);
$verifier = mysql_real_escape_string($data->verifier);
$signatory = mysql_real_escape_string($data->signatory);

$details = $data->details;
$adjustments = $data->adjustments;

$pay_id_data = preg_split("[-]", $payment_id)[0];

$sql_check = $con->query("SELECT * FROM payment WHERE branch_code='$payment_id'");
$isExist = $sql_check->fetch_array();

$status = (strtoupper($pay_id_data) === 'PAMPANGA') ? 'approved' : '';

if($isExist == 0) {

    $res = $con->query("INSERT INTO `payment`(`branch_code`, `bank_code`, `cheque_no`, `voucher_no`, `cheque_name`, `supplier_name`, `sub_total`, `ts_fee`, `adjustments`, `grand_total`, `type`, `account_name`, `account_number`, `status`, `ap`, `verifier`, `signatory`,`date`,`time`)
    VALUES ('$payment_id','$bank_code','$cheque_no','$voucher_no','$cheque_name','$supplier_name','$sub_total','$ts_fee','$adjustment','$grand_total','Receiving','$account_name','$account_number','$status','$ap','$verifier','$signatory','" . date("Y/m/d") . "','" . date("h:i:s a") . "')");

    if($res) {
        if(count($details) > 0) {
            foreach($details as $detail) {
                $wp_grade = $detail->grade;
                $net_weight = $detail->weight;
                $price = $detail->price;
                $amount = $detail->amount;
                $adj_price = $detail->adj_price;
                $adj_amount = $detail->adj_amount;

                $con->query("INSERT INTO `payment_details`(`payment_id`, `wp_grade`, `net_weight`, `price`, `amount`, `adj_price`, `adj_amount`)
                VALUES ('$payment_id','$wp_grade','$net_weight','$price','$amount','$adj_price','$adj_amount')");
            }
        }

        if(count($adjustments) > 0) {
            foreach($adjustments as $adjustment) {
                $adj_type = $adjustment->adj_type;
                $desc = $adjustment->desc;
                $amount = $adjustment->amount;
                $con->query("INSERT INTO `payment_adjustment`(`payment_id`, `adj_type`, `desc`, `amount`)
                VALUES ('$payment_id','$adj_type','$desc','$amount')");
            }
        }

        echo json_encode(array(
            'success' => true,
            'message' => 'Payment successfully sent, Please check the online payment.',
            'data' => $data
        ));

    }else {
        echo json_encode(array(
            'success' => false,
            'message' => 'Internal server error. Please contact IT.'
        ));
    }
    
} else {
    echo json_encode(array(
        'success' => false,
        'message' => 'This payment exist online, Please contact IT.'
    ));
}



?>