<?php include 'config.php';

$payment_id = $_GET['pid'];

$data = array();

function formattedName($name) {
    $nameArr = explode('-', $name);
    return trim(ucwords(strtolower($nameArr[1])));
}

$sql_payment = $con->query("SELECT * FROM payment WHERE payment_id='{$payment_id}'");
$rs_payment = $sql_payment->fetch_assoc();

$bArr = explode("-", $rs_payment['branch_code']);

$data['date'] = $rs_payment['date'];
$data['supplier'] = $rs_payment['supplier_name'];
$data['voucher'] = $rs_payment['voucher_no'];
$data['branch'] = $bArr[1];
$data['acc_name'] = $rs_payment['account_name'];
$data['acc_no'] = $rs_payment['account_number'];
$data['ts_fee'] = number_format($rs_payment['ts_fee'], 2);
$data['sub_total'] = number_format($rs_payment['sub_total'], 2);
$data['grand_total'] = number_format($rs_payment['grand_total'], 2);

$_sql_details = $con->query("SELECT * FROM payment_details WHERE payment_id='" . $rs_payment['branch_code'] . "'");
$_sql_adj = $con->query("SELECT * FROM payment_adjustment WHERE payment_id='" . $rs_payment['branch_code'] . "'");

$details = $_sql_details->fetch_all(MYSQLI_ASSOC);
$adjustments = $_sql_adj->fetch_all(MYSQLI_ASSOC);

$_details = array();
$_adjustments = array();

foreach($details as $detail) {
    $detail['adj_amount'] = number_format($detail['adj_amount'], 2);
    $detail['adj_price'] = number_format($detail['adj_price'], 2);
    $detail['amount'] = number_format($detail['amount'], 2);
    $detail['price'] = number_format($detail['price'], 2);

    $_details[] = $detail;
}

foreach($adjustments as $adj) {
    $adj['amount'] = number_format($adj['amount'], 2);
    $_adjustments[] = $adj;
}

$data['details'] = $_details;
$data['adjustments'] = $_adjustments;

$data['ap'] = formattedName($rs_payment['ap']);
$data['verifier'] = formattedName($rs_payment['verifier']);
$data['signatory'] = formattedName($rs_payment['signatory']);

echo json_encode($data);


?>