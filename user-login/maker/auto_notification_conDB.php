<?php
session_start();
$_SESSION['acctg_id'] = $_SESSION['acctg_id'];

    include('configPhp.php');
    $sql_chk = mysql_query("SELECT * from payment WHERE branch_code NOT LIKE '%Pampanga%' and printed='0' and status='approved' and printed_date='0000-00-00 00:00:00'") or die(mysql_error());
    $ajax_return = '';
    if(mysql_num_rows($sql_chk) > 0){
        $arr_branch_all = array();
        $arr_branch = array();
        while($row_chk = mysql_fetch_array($sql_chk)){
            $explode_branch = explode('-',$row_chk['branch_code']);
            $branch = strtoupper($explode_branch[0]);
            array_push($arr_branch_all,$branch);
        }
        $arr_branch = array_unique($arr_branch_all);
        
        foreach ($arr_branch as $fr_branch){
            $sql_chk = mysql_query("SELECT * from payment WHERE branch_code LIKE '%$fr_branch%' and printed='0' and status='approved' and printed_date='0000-00-00 00:00:00'") or die(mysql_error());
            $ajax_return .= 'You have '.mysql_num_rows($sql_chk).' PO request to print from '.$fr_branch.'.~';
        }
        
        echo $ajax_return;
    }
?>