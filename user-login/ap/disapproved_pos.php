
<?php
include('templates/template.php');
?>
<link rel="stylesheet" type="text/css" media="all" href="jsDatePick_ltr.min.css" />
<script type="text/javascript" src="jsDatePick.min.1.3.js"></script>
<script type="text/javascript">
    function date1(str) {
        new JsDatePick({
            useMode: 2,
            target: str,
            dateFormat: "%Y/%m/%d"

        });
    }
    ;
</script>
<style>
    .inputs{
        font-size: 14px;
        width: 80px;
        height: 18px
    }
    .submit{
        font-size: 14px;
        height: 23px;
    }
</style>
<div class="tabs">
    <div id="tab-1" class="tab">
        <h1>Disapproved POs</h1>
        <h5>Filtering Options.</h5>
        <form action="disapproved_pos.php" method="POST">
            Date Range: <input class="inputs" type='text' id='inputField' name='from' value="<?php echo date("Y/m/d"); ?>" onfocus='date1(this.id);' readonly> TO <input class="inputs" type='text' id='inputField2' name='to' value="<?php echo date("Y/m/d"); ?>"onfocus='date1(this.id);' readonly>&nbsp;&nbsp;<input class="submit" type="submit" name="submit" value="Submit">
        </form>

        <br>
        <?php
        @session_start();
        include("configPhp.php");
        ?>
        <table class="data display datatable" id="example">
            <article>

                <?php
                if (isset($_POST['submit'])) {
                    $query = "SELECT * FROM payment WHERE status='disapproved' and branch_code like '%" . $_SESSION['branch'] . "%' and date>='" . $_POST['from'] . "' and date<='" . $_POST['to'] . "'";
                } else {
                    $query = "SELECT * FROM payment WHERE status='disapproved' and branch_code like '%" . $_SESSION['branch'] . "%' and ap_disapproved_noti='0'";
                }
                $result = mysql_query($query);
                echo "<thead>";
                echo "<th>po #</th>";
                echo "<th>Branch Code</th>";
//                echo "<th>Ref. Number</th>";
                echo "<th>Supplier Name</th>";
                echo "<th>Acct. Name</th>";
                echo "<th>Acct. Number</th>";
                echo "<th>Voucher No.</th>";
                echo "<th>Amount</th>";
                echo "<th>Date Submit</th>";
                echo "<th>Date Disapproved</th>";
                echo "<th>Status</th>";
                echo "<th>Remarks</th>";
                echo "<th>Action</th>";
                echo "</thead>";
                while ($row = mysql_fetch_array($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['payment_id'] . "</td>";
                    echo "<td>" . $row['branch_code'] . "</td>";
//                    echo "<td>" . $row['reference_number'] . "</td>";
                    echo "<td>" . $row['supplier_name'] . "</td>";
                    echo "<td>" . $row['account_name'] . "</td>";
                    echo "<td>" . $row['account_number'] . "</td>";
                    echo "<td>" . $row['voucher_no'] . "</td>";
                    echo "<td>" . $row['grand_total'] . "</td>";
                    echo "<td>" . date("M d, Y", strtotime($row['date'])) . " " . date("h:i a", strtotime($row['time'])) . "</td>";
                    echo "<td>";
                    if ($row['disapproved_date'] != '') {
                        echo date("M d, Y", strtotime($row['disapproved_date']));
                    }
                    if ($row['disapproved_time'] != '') {
                        echo " " .date("h:i a", strtotime($row['disapproved_time'])) . "</td>";
                    }
                    echo "</td>";
                    if ($row['status'] == '') {
                        echo "<td>pending</td>";
                    } else {
                        echo "<td>" . $row['status'] . "</td>";
                    }
                    echo "<td>" . $row['remarks'] . "</td>";
                    echo "<td><a rel='facebox' href='ifrm_cv.php?payment_id=" . $row['payment_id'] . "'><button>View </button></a></td>";
                    echo "</tr>";
                }

                mysql_query("UPDATE payment SET ap_disapproved_noti='1' WHERE branch_code like '%" . $_SESSION['branch'] . "%'");
                ?>
        </table>

        </article>
    </div>




</div>
<?php include ('templates/footer.php'); ?>
