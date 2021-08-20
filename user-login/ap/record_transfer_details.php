    <?php
session_start();
include('configPhp.php');
$po_number=$_POST['po_number'];
$reference_number=$_POST['reference_number'];
$transfer_from=$_POST['transfer_from'];
$transfer_to=$_POST['transfer_to'];
$amount=$_POST['amount'];
$remarks=$_POST['remarks'];
$transaction_type=$_POST['transaction_type'];
$transfer_date=$_POST['transfer_date'];
$transfered_by=$_SESSION['username'];

if(mysql_query("INSERT INTO transfer_details(reference_number,transfer_from,transfer_to,amount,remarks,transaction_type,transfer_date,transfered_by)
                                VALUES('$reference_number','$transfer_from','$transfer_to','$amount','$remarks','$transaction_type','$transfer_date','$transfered_by');")) {

    mysql_query("UPDATE check_voucher set reference_number='$reference_number', status='paid' where po_number=$po_number ");

    echo "<h1>Transaction Successful...";

}else {
    echo "<script>";
    echo "alert('Transaction Failed');";
    echo "window.history.back();";
    echo "</script>";
}


?>