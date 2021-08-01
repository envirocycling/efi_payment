<style>
    .input{
        border-style:hidden;
        width: 200px;
        text-align:center;
        border-bottom: solid;
        border-width:1.5px;
        font-size: 15px;
    }
    .form_input{
        font-size: 15px;
    }
    .textarea{
        width: 200px;
        font-size: 15px;
    }
</style>

<?php
@session_start();
include './../../configPhp.php';


if(isset($_GET['payment_id'])) {

    $payment_id = $_GET['payment_id'];

    $sql_payment = $con->query("SELECT * FROM payment WHERE payment_id='{$payment_id}'");
    $rs_payment = $sql_payment->fetch_assoc();

    echo "<center>";
    echo "<div style='padding: 20px;'>";
    echo "<h4>Payment Order</h4>";
    echo "<table width='750'>";
    echo "<tr>";
    echo "<td align='center'>Date: <input type='text' class='input' value='" . $rs_payment['date'] . "' size='20' name='date' readonly></td>";
    echo "<td align='center'>Supplier: <input type='text' class='input' value='" . $rs_payment['supplier_name'] . "' size='20' name='supplier' readonly></td>";
    echo "<td align='center'>CV#: <input type='text' class='input' value='" . $rs_payment['voucher_no'] . "' size='20' name='voucher_no' readonly></td>";
    echo "</tr>";
    echo "</table>";
    echo "<table width='750'>";
    echo "<tr>";
    $que = preg_split("[-]", $rs_payment['branch_code']);
    echo "<td align='center'>Branch: <input type='text' class='input' value='$que[0]' size='20' name='supplier' readonly></td>";
    echo "<td align='center'>Acct Name: <input type='text' class='input' value='" . $rs_payment['account_name'] . "' size='20' name='account_name' readonly></td>";
    echo "<td align='center'>Acct No.: <input type='text' class='input' value='" . $rs_payment['account_number'] . "' size='20' name='voucher_no' readonly></td>";
    echo "</tr>";
    echo "</table>";
    echo "<hr>";
    echo "<h5>Delivery Breakdown</h5>";
    echo "<table>";
    echo "<tr>";
    echo "<tr>";
    echo "<td><b>WP Grade</b></td>";
    echo "<td><b>Weight</b></td>";
    echo "<td></td>";
    echo "<td><b>Price</b></td>";
    echo "<td></td>";
    echo "<td><b>Amount</b></td>";
    echo "</tr>";

    $_sql_details = $con->query("SELECT * FROM payment_details WHERE payment_id='" . $rs_payment['branch_code'] . "'");

    while ($rs_details = $_sql_details->fetch_array()) {
        echo "<tr>";
        echo "<td align='center'>" . $rs_details['wp_grade'] . "</td>";
        echo "<td align='right'>" . $rs_details['net_weight'] . "</td>";
        echo "<td align='center'>--------------------</td>";
        echo "<td align='center'>" . $rs_details['price'] . "</td>";
        echo "<td align='center'>--------------------</td>";
        echo "<td align='right'>" . number_format($rs_details['amount'], 2) . "</td>";
        echo "</tr>";
    }

    echo "</table>";
    echo "---------------------------------------------------------------------------------------------------------------------";
    echo "<h5>Sub Total: " . $rs_payment['sub_total'] . "</h5>";
    echo "***********************************************************************************";
    echo "<h5>Adjustments</h5>";
    echo "<table>";
    echo "<tr>";
    echo "<td><b>TS Fee:</b></td>";
    echo "<td>-----------------------------------------</td>";
    echo "<td align='right'>" . number_format($rs_payment['ts_fee'], 2) . "</td>";
    echo "</tr>";

    $_sql_details = $con->query("SELECT * FROM payment_details WHERE payment_id='" . $rs_payment['branch_code'] . "'");
    while ($rs_details = $_sql_details->fetch_array()) {
        echo "<tr>";
        echo "<td><b>ADD</b></td>";
        echo "<td>-----------------------------------------</td>";

        echo "<td align='right'>" . number_format((float) $rs_details['adj_amount'], 2) . "</td>";
        echo "</tr>";
    }

    $_sql_adj = $con->query("SELECT * FROM payment_adjustment WHERE payment_id='" . $rs_payment['branch_code'] . "'");
    while ($rs_adj = $_sql_adj->fetch_array()) {
        echo "<tr>";
        echo "<td><b>" . $rs_adj['desc'] . ":</b></td>";
        echo "<td>-----------------------------------------</td>";
        if ($rs_adj['adj_type'] == 'add') {
            echo "<td align='right'>" . number_format($rs_adj['amount'], 2) . "</td>";
        } else {
            echo "<td align='right'>(" . number_format($rs_adj['amount'], 2) . ")</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
    echo "---------------------------------------------------";
    echo "<h5>Grand Total: " . $rs_payment['grand_total'] . "</h5>";
    echo "<hr>";
    echo "<table>";
    echo "<tr>";
    echo "<td align='center'>AP: <input type='text' class='input' name='ap' value='" . $rs_payment['ap'] . "' readonly></td>";
    echo "</tr>";
    echo "</table>";
    echo "<table>";
    echo "<tr>";
    echo "<td align='center'>Signatory: <input type='text' class='input' name='signatory' value='" . $rs_payment['signatory'] . "' readonly></td>";
    echo "</tr>";
    echo "</table>";

        echo "<br><br>";
        echo "</div>";
        echo "</center>";

    }

 ?>


