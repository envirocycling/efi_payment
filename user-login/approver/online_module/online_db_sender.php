<?php
include("onlineconfig.php");
$parameter=$_POST['parameter'];

$parameters=preg_split("[~]",$parameter);




if(mysql_query("INSERT INTO check_voucher(cv_no,irmr_no,supplier_id,supplier_name,name_on_check,bank,control_no,date,breakdown,truck_scale,total_weight,final_ts,final_amount,ap,sic,bh,date_verified,adjustment_amt,adjustment_type,adjustment_desc,ap_signature,bh_signature,cr_number,dr_numbers,status,branch)
                                   VALUES('".$parameters[0]."','$parameters[1]','$parameters[2]','$parameters[3]','$parameters[4]','$parameters[5]','$parameters[6]','$parameters[7]','$parameters[8]','$parameters[9]','$parameters[10]','$parameters[11]','$parameters[12]','$parameters[13]','$parameters[14]','$parameters[15]','$parameters[16]','$parameters[17]','$parameters[18]','$parameters[19]','$parameters[20]','$parameters[21]','$parameters[22]','$parameters[23]','pending','$parameters[25]');
")) {


  echo "<script>";
echo "alert('voucher has been queued successfully...');";
echo "window.history.go(-2);";
  echo "</script>";


}else {

    echo "<script>";
echo "alert('failed to process voucher...');";
echo "window.history.go(-2);";
  echo "</script>";

}


?>