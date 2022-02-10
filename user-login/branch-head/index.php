<?php @session_start();
include('templates/template.php');
include './../../configPhp.php';

$branch = $_SESSION['branch'];

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
$initial = $_SESSION['initial'];
$position = $_SESSION['position'];

if($branch === 'Pasig') {
    $branch = 'PSG.PMNT';
} else if($branch === 'Tanza') {
    $branch = 'TNZ.PMNT';
}

if($username == 'jed' && $user_id = '26') {
    $branch1 = 'Sauyo';
    $branch2 = 'Kaybiga';
    $branch3 = 'Kaybiga';
} else if($username == 'CJT' && $user_id = '75') {
    $branch1 = 'Sauyo';
    $branch2 = 'Kaybiga';
    $branch3 = 'Kaybiga';
} else if($username == 'emilrose' && $user_id = '19') {
    $branch1 = 'Pampanga';
    $branch2 = 'San Fernando';
    $branch3 = 'Calumpit';
} else{
    $branch1 = $branch;
    $branch2 = $branch;
    $branch3 = $branch;
}

if(isset($_POST['submit'])) {

    $from = $_POST['from'];
    $to = $_POST['to'];

    if($position == 'Reliever') {
        $query = "SELECT * FROM payment WHERE status='' and (branch_code like '%{$branch1}%' or branch_code like '%{$branch2}%' or branch_code like '%{$branch3}%') and signatory like '%{$initial}%' and (date >= '{$from}' and date <= '{$to}');";
    } else {
        $query = "SELECT * FROM payment WHERE status='' and (branch_code like '%{$branch1}%' or branch_code like '%{$branch2}%' or branch_code like '%{$branch3}%') and (date>='{$from}' and date<='$to');";
    }

} else {

    if ($position == 'Reliever') {
        $query = "SELECT * FROM payment WHERE status='' and (branch_code like '%{$branch1}%' or branch_code like '%{$branch2}%' or branch_code like '%{$branch3}%') and signatory like '%{$initial}%'";
    } else {
        $query = "SELECT * FROM payment WHERE status='' and (branch_code like '%{$branch1}%' or branch_code like '%{$branch2}%' or branch_code like '%{$branch3}%')";
    }
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
    };

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
    .submit{
        font-size: 14px;
        height: 23px;
    }
</style>
<div class="tabs">
    <div id="tab-1" class="tab">

        <h1>Payment Orders</h1> <?= $branch; ?>

        <h5>Filtering Options.</h5>

        <form action="index.php" method="POST">
            Date Range: <input class="inputs" type='text' id='inputField' name='from' value="<?php echo date("Y/m/d"); ?>" onfocus='date1(this.id);' readonly> TO <input class="inputs" type='text' id='inputField2' name='to' value="<?php echo date("Y/m/d"); ?>"onfocus='date1(this.id);' readonly>&nbsp;&nbsp;<input class="submit" type="submit" name="submit" value="Submit">
        </form>

        <br>

        <table class="data display datatable" id="example">
            <article>

                <?php
                echo "<thead>";
                echo "<th>po #</th>";
//                echo "<th>Branch Code</th>";
//                echo "<th>Ref. Number</th>";
                echo "<th>Supplier Name</th>";
                echo "<th>Acct. Name</th>";
                echo "<th>Acct. Number</th>";
                echo "<th>Voucher No.</th>";
                echo "<th>Amount</th>";
                echo "<th>Date</th>";
                echo "<th>Status</th>";
                echo "<th>Action</th>";
                echo "</thead>";
                while ($row = $result->fetch_array()) {
                    echo "<tr>";
                    echo "<td>" . $row['payment_id'] . "</td>";
//                    echo "<td>" . $row['branch_code'] . "</td>";
//                    echo "<td>" . $row['reference_number'] . "</td>";
                    echo "<td>" . $row['supplier_name'] . "</td>";
                    echo "<td>" . $row['account_name'] . "</td>";
                    echo "<td>" . $row['account_number'] . "</td>";
                    echo "<td>" . $row['voucher_no'] . "</td>";
                    echo "<td>Php " . number_format($row['grand_total'], 2) . "</td>";
                    echo "<td>" . date("M d, Y", strtotime($row['date'])) . " " . date("h:i a", strtotime($row['time'])) . "</td>";
                    if ($row['status'] == '') {
                        echo "<td>pending</td>";
                    } else {
                        echo "<td>" . $row['status'] . "</td>";
                    }
                    echo "<td>";
                    //echo "<a href='ifrm_cv.php?approve_id=" . $row['payment_id'] . "'><button>Approve</button></a> ";
                    ?>
                    <!-- <a href='ifrm_cv.php?disapprove_id=<?php //echo $row['payment_id']; ?>' onclick="return confirm('Are you sure you want to disapprove this payment? Once you click the [Ok] you cant undo this action.')"><button>Disapprove</button></a> -->

                    <?php
                    echo "<a rel='facebox' href='ifrm_cv.php?payment_id=" . $row['payment_id'] . "'><button>View</button></a> ";
                    echo "<button id=" . $row['payment_id'] . " onclick='openWindow(this.id);
                    '>Print</button></td>";
                    echo "</tr>";
                }
                ?>
        </table>

        </article>
    </div>




</div>
<?php include ('templates/footer.php'); ?>