<?php @session_start();
include('templates/template.php');
include("./../../configPhp.php");

if (isset($_POST['submit'])) {

    $query = "SELECT * FROM payment WHERE status='approved' and date>='" . $_POST['from'] . "' and date<='" . $_POST['to'] . "' and branch_code like '%" . $_GET['branch'] . "%' and bank_code = 'SBC'";
} else {
    $query = "SELECT * FROM payment WHERE status='approved' and branch_code like '%" . $_GET['branch'] . "%' and bank_code = 'SBC'";
}

$result = $con->query($query);

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

    function openWindow(str) {
        $("#" + str).hide();
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

        <h1>Payment Orders</h1>
        <h5>Filtering Options</h5>

        <form action="index_new.php?branch=<?php echo $_GET['branch'];?>" method="POST">
            <?php
            if (isset($_POST['submit'])) {
                ?>
                Date Range: <input class="inputs" type='text' id='inputField' name='from' value="<?php echo $_POST['from']; ?>" onfocus='date1(this.id);' readonly> TO <input class="inputs" type='text' id='inputField2' name='to' value="<?php echo $_POST['to']; ?>"onfocus='date1(this.id);' readonly>
               
                &nbsp;&nbsp;<input class="submit" type="submit" name="submit" value="Submit">

                <?php
            } else {
                ?>
                Date Range: <input class="inputs" type='text' id='inputField' name='from' value="<?php echo date("Y/m/d"); ?>" onfocus='date1(this.id);' readonly> TO <input class="inputs" type='text' id='inputField2' name='to' value="<?php echo date("Y/m/d"); ?>"onfocus='date1(this.id);' readonly>
               
                &nbsp;&nbsp;<input class="submit" type="submit" name="submit" value="Submit">
                <?php
            }
            ?>
        </form>
        <br>
        <?php
        ?>
        <table class="data display datatable" id="example">
		<?php include('templates/per_branch.php');?>
            <article>

                <?php
                
                echo "<thead>";
                echo "<th>po #</th>";
                echo "<th>Branch Code</th>";
                echo "<th>Supplier Name</th>";
                echo "<th>Acct. Name</th>";
                echo "<th>Acct. Number</th>";
                echo "<th>Voucher No.</th>";
                echo "<th>Amount</th>";
                echo "<th>Date Submit</th>";
                echo "<th>Date Approved</th>";
                echo "<th>Action</th>";
                echo "</thead>";

                $ctr = 0;

                while ($row = $result->fetch_array()) {

                    die(var_dump($row));
                    echo "<tr>";
                    echo "<td>" . $row['payment_id'] . "</td>";
                    echo "<td>" . $row['branch_code'] . "</td>";
                    echo "<td>" . $row['supplier_name'] . "</td>";
                    echo "<td>" . $row['account_name'] . "</td>";
                    echo "<td>" . $row['account_number'] . "</td>";
                    echo "<td>" . $row['voucher_no'] . "</td>";
                    echo "<td>Php " . number_format($row['grand_total'], 2) . "</td>";
                    echo "<td>" . date("M d, Y", strtotime($row['date'])) . " " . date("h:i a", strtotime($row['time'])) . "</td>";
                    echo "<td>";
                    if ($row['approved_date'] != '') {
                        echo date("M d, Y", strtotime($row['approved_date']));
                    }
                    if ($row['approved_time'] != '') {
                        echo " " . date("h:i a", strtotime($row['approved_time']));
                    }
                    echo "</td>";
                    echo "<td>";
                    echo "<a rel='facebox' href='ifrm_cv.php?payment_id=" . $row['payment_id'] . "'><button>View</button>";
                    if ($row['printed'] == '0') {
                        echo "</a> <button name='" . $row['payment_id'] . "' id='" . $row['payment_id'] . "' onclick='openWindow(this.id);'>Print</button>";
                    }
                    echo "</td>";
                    echo "</tr>";
                    $ctr++;
                }
                ?>
        </table>
        </article>
    </div>

</div>
<?php include ('templates/footer.php'); ?>
