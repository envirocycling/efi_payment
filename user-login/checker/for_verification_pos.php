
<?php
@session_start();
include('templates/template.php');
include("configPhp.php");
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

    function openWindow(str) {
        window.open("print_po.php?payment_id=" + str, 'mywindow', 'width=1020,height=600,left=150,top=20');
    }
</script>
<style>
    .inputs{
        font-size: 14px;
        width: 80px;
        height: 18px
    }
    .select{
        font-size: 14px;
        width: 100px;
        height: 18px
    }
    .submit{
        font-size: 14px;
        height: 23px;
    }
</style>
<div class="tabs">
    <div id="tab-1" class="tab">
        <h1>For Verification POs</h1>
        <h5>Filtering Options.</h5>
        <form action="for_verification_pos.php" method="POST">
            <?php
            if (isset($_POST['submit'])) {
                ?>
                Date Range: <input class="inputs" type='text' id='inputField' name='from' value="<?php echo $_POST['from']; ?>" onfocus='date1(this.id);' readonly> TO <input class="inputs" type='text' id='inputField2' name='to' value="<?php echo $_POST['to']; ?>"onfocus='date1(this.id);' readonly>
                Branch: <select class="select" name="branch">
                    <?php
                    echo "<option name='" . $_POST['branch'] . "'>" . $_POST['branch'] . "</option>";
                    ?>
                    <option value="">All Branch</option>
                    <?php
                    $sql = mysql_query("SELECT * FROM branches");
                    while ($rs = mysql_fetch_array($sql)) {
                        echo "<option name='" . $rs['branch_name'] . "'>" . $rs['branch_name'] . "</option>";
                    }
                    ?>
                </select>
                &nbsp;&nbsp;<input class="submit" type="submit" name="submit" value="Submit">

                <?php
            } else {
                ?>
                Date Range: <input class="inputs" type='text' id='inputField' name='from' value="<?php echo date("Y/m/d"); ?>" onfocus='date1(this.id);' readonly> TO <input class="inputs" type='text' id='inputField2' name='to' value="<?php echo date("Y/m/d"); ?>"onfocus='date1(this.id);' readonly>
                Branch: <select class="select" name="branch">
                    <option value="">All Branch</option>
                    <?php
                    $sql = mysql_query("SELECT * FROM branches");
                    while ($rs = mysql_fetch_array($sql)) {
                        echo "<option name='" . $rs['branch_name'] . "'>" . $rs['branch_name'] . "</option>";
                    }
                    ?>
                </select>
                &nbsp;&nbsp;<input class="submit" type="submit" name="submit" value="Submit">
                <?php
            }
            ?>
        </form>

        <br>
        <table class="data display datatable" id="example">
            <article>

                <?php
                @session_start();
                if (isset($_POST['submit'])) {
                    $query = "SELECT * FROM payment WHERE status='generated' and transfer_date>='" . $_POST['from'] . "' and transfer_date<='" . $_POST['to'] . "' and branch_code like '%" . $_POST['branch'] . "%'";
                } else {
                    $query = "SELECT * FROM payment WHERE status='generated' and maker_approved_noti='0' ";
                }
                $result = mysql_query($query);
                echo "<thead>";
                echo "<th>po #</th>";
                echo "<th>Branch Code</th>";
                echo "<th>Ref. Number</th>";
                echo "<th>Supplier Name</th>";
                echo "<th>Acct. Name</th>";
                echo "<th>Acct. Number</th>";
                echo "<th>Voucher No.</th>";
                echo "<th>Amount</th>";
                echo "<th>Date Submit</th>";
                echo "<th>Date Approved</th>";
                echo "<th>Date Transferred</th>";
//                    echo "<th>Status</th>";
                echo "<th>Action</th>";
                echo "</thead>";
                while ($row = mysql_fetch_array($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['payment_id'] . "</td>";
                    echo "<td>" . $row['branch_code'] . "</td>";
                    echo "<td>" . $row['reference_number'] . "</td>";
                    echo "<td>" . $row['supplier_name'] . "</td>";
                    echo "<td>" . $row['account_name'] . "</td>";
                    echo "<td>" . $row['account_number'] . "</td>";
                    echo "<td>" . $row['voucher_no'] . "</td>";
                    echo "<td>Php " . number_format($row['grand_total'], 2) . "</td>";
                    echo "<td>" . $row['date'] . " " . $row['time'] . "</td>";
                    echo "<td>";
                    if ($row['approved_date'] != '') {
                        echo date("M d, Y", strtotime($row['approved_date']));
                    }
                    if ($row['approved_time'] != '') {
                        echo " " . date("h:i a", strtotime($row['approved_time']));
                    }
                    echo "</td>";
                    echo "<td>";
                    if ($row['transfer_date'] != '') {
                        echo date("M d, Y", strtotime($row['transfer_date']));
                    }
                    if ($row['transfer_time'] != '') {
                        echo " " . date("h:i a", strtotime($row['transfer_time']));
                    }
                    echo "</td>";
//                        if ($row['status'] == '') {
//                            echo "<td>pending</td>";
//                        } else {
//                            echo "<td>" . $row['status'] . "</td>";
//                        }
                    echo "<td><a rel='facebox' href='ifrm_cv.php?payment_id=" . $row['payment_id'] . "'><button>View</button></a></td>";
                    echo "</tr>";
                }


                mysql_query("UPDATE payment SET maker_approved_noti='1' WHERE status='generated'");
                ?>
        </table>

        </article>
    </div>




</div>
<?php include ('templates/footer.php'); ?>
