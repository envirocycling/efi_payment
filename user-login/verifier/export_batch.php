<?php
@session_start();
include 'configPhp.php';
function xlsBOF() {
    echo pack("ssssss", 0x809, 0x8, 0x0, 0x10, 0x0, 0x0);
    return;
}
function xlsEOF() {
    echo pack("ss", 0x0A, 0x00);
    return;
}
function xlsWriteNumber($Row, $Col, $Value) {
    echo pack("sssss", 0x203, 14, $Row, $Col, 0x0);
    echo pack("d", $Value);
    return;
}
function xlsWriteLabel($Row, $Col, $Value) {
    $L = strlen($Value);
    echo pack("ssssss", 0x204, 8 + $L, $Row, $Col, 0x0, $L);
    echo $Value;
    return;
}
header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Content-Type: application/force-download");
header("Content-Type: application/octet-stream");
header("Content-Type: application/download");
;
header("Content-Disposition: attachment;filename=batch_payment_".$_POST['ref_number']."_".date("Y/m/d").".xls");
header("Content-Transfer-Encoding: binary ");
xlsBOF();

xlsWriteLabel(0,0,"ACCOUNT NAME");
xlsWriteLabel(0,1,"ACCOUNT NUMBER");
xlsWriteLabel(0,2,"AMOUNT");
xlsWriteLabel(0,3,"REMARKS");
$xlsRow = 1;

$id_array = preg_split("[_]",$_POST['id']);
foreach ($id_array as $id) {
    mysql_query("UPDATE payment SET reference_number='".$_POST['ref_number']."',transfer_date='".date("Y/m/d")."',transfer_by='".$_SESSION['user_id']."' WHERE payment_id='$id'");
    $sql_details = mysql_query("SELECT * FROM payment WHERE payment_id='$id'");
    $rs_details = mysql_fetch_array($sql_details);
    xlsWriteLabel($xlsRow,0,$rs_details['account_name']);
    xlsWriteLabel($xlsRow,1,$rs_details['account_number']);
    xlsWriteLabel($xlsRow,2,number_format($rs_details['grand_total'],2));
    xlsWriteLabel($xlsRow,3,$rs_details['remarks']);
    $xlsRow++;
}

xlsEOF();

echo "<script>
    alert('Exported Successfully...');
window.history.back();
</script>
";
?>