<?php
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


    $(document).ready(function () {
        $('#selectall').click(function () {  //on click
            if (this.checked) { // check select status
                $('.checkbox').each(function () { //loop through each checkbox
                    this.checked = true;  //select all checkboxes with class "checkbox1"
                });
            } else {
                $('.checkbox').each(function () { //loop through each checkbox
                    this.checked = false; //deselect all checkboxes with class "checkbox1"
                });
            }
        });
    });

    function OnSubmitForm() {
        if (document.myform.operation[0].checked == true)
        {
            document.myform.action = "generate_pos.php";
        }
        else
        if (document.myform.operation[1].checked == true)
        {
            document.myform.action = "payment_next.php";
        }
        return true;
    }

    function OnSubmitForm() {
        if (document.myform.operation[0].checked == true)
        {
            document.myform.action = "mark_as_generated.php";
        }
        return true;
    }
</script>
<style>
    .inputs{
        font-size: 14px;
        width: 80px;
        height: 18px
    }
    .inputs2{
        font-size: 14px;
        width: 120px;
        height: 18px
    }
    .submit{
        font-size: 14px;
        height: 23px;
    }
    .ref_num{
        color: black;
        font-size: 14px;
        height: 20px;
    }
    .radio{
        height: 15px;
        width: 15px;
    }
    .select{
        font-size: 14px;
        width: 100px;
        height: 18px
    }
</style>
<div class="tabs">
    <div id="tab-1" class="tab">
        <h1>Payment Orders</h1>
        <h5>Filtering Options</h5>
        <form action="generate_pos.php" method="POST">
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
        <form name='myform' onsubmit='return OnSubmitForm();' method='POST'>
            <table class="data display datatable" id="example">
                <article>

                    <?php
                    @session_start();
                    if (isset($_POST['submit'])) {
                        $query = "SELECT * FROM payment WHERE status='approved' and date>='" . $_POST['from'] . "' and date<='" . $_POST['to'] . "' and branch_code like '%" . $_POST['branch'] . "%' and printed='1'";
                    } else {
                        $query = "SELECT * FROM payment WHERE status='approved' and printed='1'";
                    }
                    $result = mysql_query($query);
                    echo "<thead>";
                    echo "<th></th>";
                    echo "<th>po #</th>";
                    echo "<th>Branch Code</th>";
//                    echo "<th>Ref. Number</th>";
                    echo "<th>Supplier Name</th>";
                    echo "<th>Acct. Name</th>";
                    echo "<th>Acct. Number</th>";
                    echo "<th>Voucher No.</th>";
                    echo "<th>Amount</th>";
                    echo "<th>Date Submit</th>";
                    echo "<th>Date Approved</th>";
//                    echo "<th>Status</th>";
                    echo "<th>Action</th>";
                    echo "</thead>";
                    $ctr = 0;
                    while ($row = mysql_fetch_array($result)) {
                        echo "<tr>";
                        echo "<td><input id='cv_" . $ctr . "' class='checkbox' type='checkbox' name='cv_" . $ctr . "' value='" . $row['payment_id'] . "'></td>";
                        echo "<td>" . $row['payment_id'] . "</td>";
                        echo "<td>" . $row['branch_code'] . "</td>";
//                        echo "<td>" . $row['reference_number'] . "</td>";
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

//                        if ($row['status'] == '') {
//                            echo "<td>pending</td>";
//                        } else {
//                            echo "<td>" . $row['status'] . "</td>";
//                        }
                        echo "<td><a rel='facebox' href='ifrm_cv.php?payment_id=" . $row['payment_id'] . "'><button>View</button></a></td>";
                        echo "</tr>";
                        $ctr++;
                    }
                    ?>
            </table>
            <table>
                <tr>
                    <td>
                        <input type="hidden" name="ctr" value="<?php echo $ctr; ?>">
                        Select All: <input type="checkbox" id="selectall">
                    </td>
                </tr>
                <tr>
                    <td>
                        <input class="radio" type="radio" name="operation" value="1" checked>Mark as Processed
                    </td>
                </tr>
                <!-- <input type="submit" name="Submit" onclick="return confirm('All data will mark as proccessed when you click OK, Are you sure you want to generate this batch?')"  value="Generate Batch"> -->
                <tr>
                    <td>
                        <button onclick="return confirm('All data will mark as proccessed, Once you click the [Ok] you cant undo this action.')">Submit</button>
                    </td>
                </tr>
            </table>
        </form>
        </article>
    </div>




</div>
<?php include ('templates/footer.php'); ?>
