<?php @session_start();
include './../../configPhp.php';

if (isset($_GET['disapprove'])) {
    $payment_id = $_GET['disapprove'];
    if($con->query("UPDATE payment SET status='disapproved',disapproved_date='" . date("Y/m/d") . "', disapproved_time='" . date("h:i:s a") . "' WHERE payment_id='{$payment_id}'")) {
        echo "<script>
            alert('Successfully Disapproved.');
        location.replace('index.php');
        </script>";
    } else {
        echo "<script>
            alert('Error: Something went wrong');
        location.replace('index.php');
        </script>";
    }
}

if (isset($_GET['approve_id'])) {
    $payment_id = $_GET['approve_id'];
    if($con->query("UPDATE payment SET status='approved',approved_date='" . date("Y/m/d") . "', approved_time='" . date("h:i:s a") . "' WHERE payment_id='{$payment_id}'")) {
        echo "<script>
            alert('Successfully Approved.');
        location.replace('index.php');
        </script>";
    } else {
        echo "<script>
            alert('Error: Something went wrong');
        location.replace('index.php');
        </script>";
    }
}

if (isset($_GET['process_id'])) {
    $payment_id = $_GET['process_id'];
    $date = date("Y/m/d");
    $time = date("h:i:s a");

    if($con->query("UPDATE payment SET status='generated',approved_date='{$date}', approved_time='{$time}', transfer_date='{$date}',transfer_time='{$time}' WHERE payment_id='{$payment_id}'")) {
        echo "<script>
            alert('Process complete.');
        location.replace('gcash.php');
        </script>";
    } else {
        echo "<script>
            alert('Error: Something went wrong');
        location.replace('gcash.php');
        </script>";
    }
}

if (isset($_GET['cancel_id'])) {

    $payment_id = $_GET['cancel_id'];

    $_selects = $con->query("SELECT * from payment WHERE payment_id='{$payment_id}' and status='generated'");
    $selects = $_selects->num_rows;

    if ($selects == 0) {

        if($con->query("UPDATE payment SET status='' WHERE payment_id='{$payment_id}'")) {
            echo "<script>
                    alert('Successfully Cancel.');
                location.replace('index.php');
                </script>";
        } else {
            echo "<script>
                alert('Error: Something went wrong');
            location.replace('index.php');
            </script>";
        }
    }
}

if(isset($_GET['payment_id'])) {
    $payment_id = $_GET['payment_id'];

    $sql_payment = $con->query("SELECT * FROM payment WHERE payment_id='{$payment_id}'");
    $rs_payment = $sql_payment->fetch_assoc();

    $que = preg_split("[-]", $rs_payment['branch_code']);

    $_sql_details = $con->query("SELECT * FROM payment_details WHERE payment_id='" . $rs_payment['branch_code'] . "'");

    $_sql_adj = $con->query("SELECT * FROM payment_adjustment WHERE payment_id='" . $rs_payment['branch_code'] . "'");
}

?>

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


<center>
    <div style='padding: 20px;'>

        <h3>Payment Order</h3>
        
        <table width='750'>
            <tr>
                <td align='center'>
                    Date: <input type='text' class='input' value='<?php echo $rs_payment['date']; ?>' size='20' name='date' readonly>
                </td>
                <td align='center'>
                    Supplier: <input type='text' class='input' value='<?php echo $rs_payment['supplier_name']; ?>' size='20' name='supplier' readonly></td>
                <td align='center'>
                    CV#: <input type='text' class='input' value='<?php echo $rs_payment['voucher_no']; ?>' size='20' name='voucher_no' readonly></td>
            </tr>
        </table>

        <table width='750'>
            <tr>
                <td align='center'>
                    Branch: <input type='text' class='input' value='<?php echo $que[0]; ?>' size='20' name='supplier' readonly>
                </td>
                <td align='center'>
                    Acct Name: <input type='text' class='input' value='<?php echo $rs_payment['account_name']; ?>' size='20' name='account_name' readonly>
                </td>
                <td align='center'>
                    Acct No.: <input type='text' class='input' value='<?php echo $rs_payment['account_number']; ?>' size='20' name='voucher_no' readonly>
                </td>
            </tr>
        </table>

        <hr>

        <h5>Delivery Breakdown</h5>

        <table>
            <tr>
                <td><b>WP Grade</b></td>
                <td><b>Weight</b></td>
                <td></td>
                <td><b>Price</b></td>
                <td></td>
                <td><b>Amount</b></td>
            </tr>

            <?php while ($rs_details = $_sql_details->fetch_array()): ?>
            <tr>
                <td align='center'><?php echo $rs_details['wp_grade']; ?></td>
                <td align='right'><?php echo $rs_details['net_weight']; ?></td>
                <td align='center'>--------------------</td>
                <td align='center'><?php echo $rs_details['price']; ?></td>
                <td align='center'>--------------------</td>
                <td align='right'><?php echo number_format($rs_details['amount'], 2); ?></td>
            </tr>
            <?php endwhile; ?>
        </table>

        <span>---------------------------------------------------------------------------------------------------------------------</span>

        <h5>Sub Total: <?php echo $rs_payment['sub_total']; ?></h5>
        
        ***********************************************************************************
        
        <h5>Adjustments</h5>
        
        <table>
            <tr>
                <td><b>TS Fee:</b></td>
                <td>-----------------------------------------</td>
                <td align='right'><?php echo number_format($rs_payment['ts_fee'], 2); ?></td>
            </tr>

            <?php while ($rs_details = $_sql_details->fetch_array()): ?>
                <tr>
                    <td><b>ADD</b></td>
                    <td>-----------------------------------------</td>
                    <td align='right'><?php echo number_format((float) $rs_details['adj_amount'], 2); ?></td>
                </tr>
            <?php endwhile; ?>

        
            <?php while ($rs_adj = $_sql_adj->fetch_array()): ?>
            <tr>
                <td><b><?php echo $rs_adj['desc']; ?>:</b></td>
                <td>-----------------------------------------</td>
                <?php if ($rs_adj['adj_type'] == 'add'): ?>
                    <td align='right'><?php echo number_format($rs_adj['amount'], 2); ?></td>
                <?php else: ?>
                    <td align='right'>(<?php echo number_format($rs_adj['amount'], 2); ?>)</td>
                <?php endif;?>
            </tr>
            <?php endwhile; ?>
        </table>

        ---------------------------------------------------

        <h5>Grand Total: <?php echo $rs_payment['grand_total']; ?></h5>

        <hr>

        <table>
            <tr>
                <td align='center'>
                    AP: <input type='text' class='input' name='ap' value='<?php echo $rs_payment['ap']; ?>' readonly>
                </td>
            </tr>
        </table>

        <table>
            <tr>
                <td align='center'>
                    Signatory: <input type='text' class='input' name='signatory' value='<?php echo $rs_payment['signatory']; ?>' readonly>
                </td>
            </tr>
        </table>

        <br>

            <?php if($rs_payment['status'] == '' && $rs_payment['bank_code'] != 'GCASH'): ?>
                <a href='ifrm_cv.php?approve_id=<?php echo $rs_payment['payment_id']; ?>'>
                    <button class='btn btn-sm btn-success'>Approve</button>
                </a> | 
                <a href='ifrm_cv.php?disapprove=<?php echo $rs_payment['payment_id']; ?>'>
                    <button class="btn btn-sm btn-danger">Disapprove</button>
                </a>
            <?php elseif($rs_payment['status'] == '' && $rs_payment['bank_code'] == 'GCASH'): ?>
                <a href='ifrm_cv.php?process_id=<?php echo $rs_payment['payment_id']; ?>'>
                    <button class='btn btn-sm btn-primary'>Process</button>
                </a> | 
                <a href='ifrm_cv.php?disapprove=<?php echo $rs_payment['payment_id']; ?>'>
                    <button class="btn btn-sm btn-danger">Cancel</button>
                </a>
            <?php endif;?>
        
        <br><br>
    </div>

</center>

