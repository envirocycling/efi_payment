<?php
include 'configPhp.php';
$pageWasRefreshed = isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0';

if ($pageWasRefreshed) {

    mysql_query("UPDATE payment SET refresh_print_page='1' WHERE payment_id='" . $_GET['payment_id'] . "'") or die(mysql_error());
}
?>
<style>
    table {
        letter-spacing: 2px;
        margin-top: -3px;
        font-size: 11px;
        font-weight: Light;
        font-family: Copperplate Gothic Light, Arial;
    }
</style>
<script>
    print();
</script>
<body>
    <?php
    date_default_timezone_set("Asia/Singapore");
    include 'configPhp.php';
    mysql_query("UPDATE payment SET click_print_button='1' WHERE payment_id='" . $_GET['payment_id'] . "'") or die(mysql_error());
    mysql_query("UPDATE payment SET printed='1' WHERE payment_id='" . $_GET['payment_id'] . "'");

    $sql_payment = mysql_query("SELECT * FROM payment WHERE payment_id='" . $_GET['payment_id'] . "'");
    $rs_payment = mysql_fetch_array($sql_payment);

// conversion

    function convertNumber($number) {
        list($integer, $fraction) = explode(".", (string) $number);

        $output = "";

        if ($integer{0} == "-") {
            $output = "negative ";
            $integer = ltrim($integer, "-");
        } else if ($integer{0} == "+") {
            $output = "positive ";
            $integer = ltrim($integer, "+");
        }

        if ($integer{0} == "0") {
            $output .= "zero";
        } else {
            $integer = str_pad($integer, 36, "0", STR_PAD_LEFT);
            $group = rtrim(chunk_split($integer, 3, " "), " ");
            $groups = explode(" ", $group);

            $groups2 = array();
            foreach ($groups as $g) {
                $groups2[] = convertThreeDigit($g{0}, $g{1}, $g{2});
            }

            for ($z = 0; $z < count($groups2); $z++) {
                if ($groups2[$z] != "") {
                    $output .= $groups2[$z] . convertGroup(11 - $z) . (
                            $z < 11 && !array_search('', array_slice($groups2, $z + 1, -1)) && $groups2[11] != '' && $groups[11]{0} == '0' ? " " : ", "
                            );
                }
            }

            $output = rtrim($output, ", ");
        }

//        if ($fraction > 0) {
//            $output .= " point";
//            for ($i = 0; $i < strlen($fraction); $i++) {
//                $output .= " " . convertDigit($fraction{$i});
//            }
//        }

        return $output;
    }

    function convertGroup($index) {
        switch ($index) {
            case 11:
                return " decillion";
            case 10:
                return " nonillion";
            case 9:
                return " octillion";
            case 8:
                return " septillion";
            case 7:
                return " sextillion";
            case 6:
                return " quintrillion";
            case 5:
                return " quadrillion";
            case 4:
                return " trillion";
            case 3:
                return " billion";
            case 2:
                return " million";
            case 1:
                return " thousand";
            case 0:
                return "";
        }
    }

    function convertThreeDigit($digit1, $digit2, $digit3) {
        $buffer = "";

        if ($digit1 == "0" && $digit2 == "0" && $digit3 == "0") {
            return "";
        }

        if ($digit1 != "0") {
            $buffer .= convertDigit($digit1) . " hundred";
            if ($digit2 != "0" || $digit3 != "0") {
                $buffer .= " ";
            }
        }

        if ($digit2 != "0") {
            $buffer .= convertTwoDigit($digit2, $digit3);
        } else if ($digit3 != "0") {
            $buffer .= convertDigit($digit3);
        }

        return $buffer;
    }

    function convertTwoDigit($digit1, $digit2) {
        if ($digit2 == "0") {
            switch ($digit1) {
                case "1":
                    return "ten";
                case "2":
                    return "twenty";
                case "3":
                    return "thirty";
                case "4":
                    return "forty";
                case "5":
                    return "fifty";
                case "6":
                    return "sixty";
                case "7":
                    return "seventy";
                case "8":
                    return "eighty";
                case "9":
                    return "ninety";
            }
        } else if ($digit1 == "1") {
            switch ($digit2) {
                case "1":
                    return "eleven";
                case "2":
                    return "twelve";
                case "3":
                    return "thirteen";
                case "4":
                    return "fourteen";
                case "5":
                    return "fifteen";
                case "6":
                    return "sixteen";
                case "7":
                    return "seventeen";
                case "8":
                    return "eighteen";
                case "9":
                    return "nineteen";
            }
        } else {
            $temp = convertDigit($digit2);
            switch ($digit1) {
                case "2":
                    return "twenty-$temp";
                case "3":
                    return "thirty-$temp";
                case "4":
                    return "forty-$temp";
                case "5":
                    return "fifty-$temp";
                case "6":
                    return "sixty-$temp";
                case "7":
                    return "seventy-$temp";
                case "8":
                    return "eighty-$temp";
                case "9":
                    return "ninety-$temp";
            }
        }
    }

    function convertDigit($digit) {
        switch ($digit) {
            case "0":
                return "zero";
            case "1":
                return "one";
            case "2":
                return "two";
            case "3":
                return "three";
            case "4":
                return "four";
            case "5":
                return "five";
            case "6":
                return "six";
            case "7":
                return "seven";
            case "8":
                return "eight";
            case "9":
                return "nine";
        }
    }

    $num = round($rs_payment['grand_total'], 2);
    $paymentsss = $rs_payment['grand_total'] . ".00";
    $check = preg_split("/[.]/", $num);

    $amount = strtoupper(convertNumber($paymentsss));
    if (empty($check[1])) {
        $cents = " and 00/100 only";
        $amount .=strtoupper($cents);
    } else {
        if (strlen($check[1]) == 1) {
            $cents = " and $check[1]0/100 only";
        } else {
            $cents = " and $check[1]/100 only";
        }
        $amount .=strtoupper($cents);
    }

// Conversion

    $total = 0;

    echo "<center>";
    echo "<div>";
    echo "<table height='350' border='0' width='720'>";
    echo "<tr>";
    echo "<td style='vertical-align: top;' height='60' align='center'>";
    echo "<table border='0' width='700' cellspacing='1'>";
    echo "<tr>";
    echo "<td height='15'></td>";
    echo "<td></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td height='19'><b>Account Name: </b>" . strtoupper(utf8_decode($rs_payment['cheque_name'])) . "</td>";
    echo "<td><b>Date:</b> " . date("M") . "&nbsp;" . date("d") . ", " . date("Y") . "</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td height='19'><b>Account No.: </b> " . $rs_payment['account_number'] . "</td>";
    echo "<td><b>Voucher No.:</b> " . $rs_payment['voucher_no'] . "</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td height='15'><b>Amount: </b> $amount</td>";
    echo "<td><b>Bank:</b> " . $rs_payment['bank_code'] . "</td>";
    echo "</tr>";
    echo "</table>";
    echo "</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td style='vertical-align: top;' height='230' align='center'>";
//    echo "<br>";
    echo "<table border='0' height='210' width='650' cellspacing='1'>";
    echo "<tr>";
    echo "<td style='vertical-align: top;' colspan='4'>";
    echo "<br><br>";
    echo "<table border='0' width='650'>";
    if (!empty($que[1])) {
        echo "<tr>";
        echo "<td colspan='2' align='center'>CONSOLIDATED PAYMENT</td>";
        echo "<td>&nbsp;</td>";
        echo "<td>&nbsp;</td>";
        echo "</tr>";
    }
    echo "<tr>";
    echo "<td><b>WP GRADE</b></td>";
    echo "<td align='right'><b>WEIGHT</b></td>";
    echo "<td align='right'><b>PRICE</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
    echo "<td align='right'><b>AMOUNT</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
    echo "</tr>";
    $tr = "";
    $sub_total = 0;

    $sql_details = mysql_query("SELECT * FROM payment_details WHERE payment_id='" . $rs_payment['branch_code'] . "'");
    while ($rs_details = mysql_fetch_array($sql_details)) {
        echo "<tr>";
        echo "<td width='160'>" . $rs_details['wp_grade'] . "</td>";
        echo "<td width='150' align='right'>" . number_format($rs_details['net_weight'], 2) . "</td>";
        if (!empty($rs_details['price'])) {
            echo "<td width='150' align='right'>" . number_format($rs_details['price'], 2) . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
        } else {
            echo "<td width='150' align='right'> </td>";
        }
        echo "<td align='right'>" . number_format($rs_details['amount'], 2) . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
        $sub_total+=$rs_details['amount'];
        echo "</tr>";
        $total+=$rs_details['net_weight'];
    }
    echo "</table>";
    echo "<br>";
    echo "<table border='0' cellspacing='1'>";
    echo "<tr>";
    echo "<td align='center' colspan='4'><b>ADJUSTMENTS</b></td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td width='160' style='vertical-align: top;'><b>TYPE</b></td>";
    echo "<td width='150' align='right' style='vertical-align: top;'><b>DESC</b></td>";
    echo "<td width='150' align='right' style='vertical-align: top;'></td>";
    echo "<td width='150' align='right' style='vertical-align: top;'><b>AMOUNT</b></td>";
    echo "</tr>";


    echo "<tr>";
    echo "<td width='160' style='vertical-align: top;'>DEDUCT</td>";
    echo "<td width='150' align='right' style='vertical-align: top;'>TS FEE</td>";
    echo "<td width='150' align='right' style='vertical-align: top;'></td>";
    echo "<td width='150' align='right' style='vertical-align: top;'>(" . number_format($rs_payment['ts_fee'], 2) . ")&nbsp;&nbsp;</td>";
    echo "</tr>";

    $sql_details = mysql_query("SELECT * FROM payment_details WHERE payment_id='" . $rs_payment['branch_code'] . "'");
    while ($rs_details = mysql_fetch_array($sql_details)) {
        if ($rs_details['adj_price'] != '') {
            echo "<tr>";
            echo "<td width='160' style='vertical-align: top;'><b>ADD</b></td>";
            echo "<td width='150' align='right' style='vertical-align: top;'><b>ADJ</b></td>";
            echo "<td width='150' align='right' style='vertical-align: top;'></td>";
            echo "<td width='150' align='right' style='vertical-align: top;'><b>" . number_format($rs_details['adj_amount'], 2) . "</b></td>";
            echo "</tr>";
        }
    }

    $sql_adj = mysql_query("SELECT * FROM payment_adjustment WHERE payment_id='" . $rs_payment['branch_code'] . "'");
    while ($rs_adj = mysql_fetch_array($sql_adj)) {
        if ($rs_adj['adj_type'] != "") {
            echo "<tr>";
            echo "<td width='160' style='vertical-align: top;'>" . strtoupper($rs_adj['adj_type']) . "</td>";
            echo "<td width='150' align='right' style='vertical-align: top;'>" . strtoupper($rs_adj['desc']) . "</td>";
            echo "<td width='130' align='right' style='vertical-align: top;'></td>";
            echo "<td width='120' align='right' style='vertical-align: top;'>";
            if ($rs_adj['adj_type'] == "deduct") {
                if ($rs_adj['amount'] != "") {
                    echo "(" . number_format($rs_adj['amount'], 2) . ")";
                }
            } else {
                if ($rs_adj['amount'] != "") {
                    echo number_format($rs_adj['amount'], 2);
                }
            }
            echo "&nbsp;&nbsp;</td>";
            echo "</tr>";
        }
    }
    echo "</table>";
    echo "</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td width='120' style='vertical-align: bottom;'><b>TOTAL</b></td>";
    echo "<td width='120' align='right' style='vertical-align: bottom;'>" . number_format($total, 2) . "</td>";
    echo "<td width='130' align='right' style='vertical-align: bottom;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
    echo "<td width='120' align='right' style='vertical-align: bottom; background-color:#FFFF00'>" . number_format($rs_payment['grand_total'], 2) . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
    echo "</tr>";
    echo "</table>";
    echo "<table>";
    echo "<tr>";
    echo "</table>";
    echo "</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td style='vertical-align: top;' align='center'>";
    echo "<table border='0' width='650'>";
    echo "<tr>";
    echo "<td>";
    
    @session_start();
    $sql_maker = mysql_query("SELECT * FROM users WHERE usertype='3' and user_id='".$_SESSION['user_id']."'");
    $rs_maker = mysql_fetch_array($sql_maker);

    $sql_verifier = mysql_query("SELECT * FROM users WHERE usertype='2'");
    $rs_verifier = mysql_fetch_array($sql_verifier);

    $sql_approver = mysql_query("SELECT * FROM users WHERE usertype='1'");
    $rs_approver = mysql_fetch_array($sql_approver);

    $ap = preg_split("[-]", $rs_payment['ap']);
    $signatory = preg_split("[-]", $rs_payment['signatory']);
    echo "<table border='0' width='700'>";
    echo "<tr>";
    echo "<td>";
    echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src='../../signatures/" . $ap[0] . ".jpg' height='60'><br>";
    echo "<b>Prepared By: </b>" . $rs_payment['ap'] . "<br>";
    echo date("M d, Y", strtotime($rs_payment['date'])) . " " . date("h:i a", strtotime($rs_payment['time']));
    echo "</td>";
    echo "<td>";
    if ($rs_payment['status'] != '' && $rs_payment['status'] != 'disapproved') {
        echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src='../../signatures/" . $signatory[0] . ".jpg' height='60'><br>";
    } else {
        echo "<br><br><br><br><br><br>";
    }
    echo "<b>Branch Head: </b>" . $rs_payment['signatory'] . "<br>";
    if ($rs_payment['approved_date'] != '') {
        echo date("M d, Y", strtotime($rs_payment['approved_date']));
    }
    if ($rs_payment['approved_time'] != '') {
        echo " " . date("h:i a", strtotime($rs_payment['approved_time']));
    }
    echo "</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>";
    if ($rs_payment['status'] != '' && $rs_payment['status'] != 'approved' && $rs_payment['status'] != 'disapproved') {
        echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src='../../signatures/" . $rs_maker['initial'] . ".jpg' height='60'><br>";
    } else {
        echo "<br><br><br><br><br><br>";
    }
    echo "<b>Maker : </b>" . $rs_maker['initial'] . "-" . strtoupper($rs_maker['firstname']) . " " . strtoupper($rs_maker['lastname']) . "<br>";
    if ($rs_payment['transfer_date'] != '') {
        echo date("M d, Y", strtotime($rs_payment['transfer_date']));
    }
    if ($rs_payment['transfer_time'] != '') {
        echo " " . date("h:i a", strtotime($rs_payment['transfer_time']));
    }
    echo "</td>";
    echo "<td>";
    if ($rs_payment['status'] != '' && $rs_payment['status'] != 'approved' && $rs_payment['status'] != 'generated' && $rs_payment['status'] != 'disapproved') {
        echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src='../../signatures/" . $rs_verifier['initial'] . ".jpg' height='60'><br>";
    } else {
        echo "<br><br><br><br><br><br>";
    }
    echo "<b>Verifier: </b>" . $rs_verifier['initial'] . "-" . strtoupper($rs_verifier['firstname']) . " " . strtoupper($rs_verifier['lastname']) . "</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td colspan='2'>";
    if ($rs_payment['status'] != '' && $rs_payment['status'] != 'approved' && $rs_payment['status'] != 'generated' && $rs_payment['status'] != 'verified' && $rs_payment['status'] != 'disapproved') {
        echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src='../../signatures/" . $rs_approver['initial'] . ".jpg' height='60'><br>";
    } else {
        echo "<br><br><br><br><br><br>";
    }
    echo "<b>Authorizer : </b>" . $rs_approver['initial'] . "-" . strtoupper($rs_approver['firstname']) . " " . strtoupper($rs_approver['lastname']) . "</td>";
    echo "</tr>";
    echo "</table>";
    echo "</td>";
    echo "</tr>";
    echo "</table>";
    echo "</td>";
    echo "</tr>";
    echo "</table>";
    echo "</div>";
    echo "</center>";
    ?>
</body>
<!--
<script>
    window.close();
</script> -->