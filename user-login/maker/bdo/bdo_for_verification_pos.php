<?php include("bdo_header.php");

// Datatables data
if (isset($_POST['submit'])) {

    $from = $_POST['from'];
    $to = $_POST['to'];
    $_branch = $_POST['branch'];

    $query = "SELECT * FROM payment WHERE status='generated' and (transfer_date >= '$from' and transfer_date <= '$to') and branch_code like '%$_branch%' and bank_code = 'BDO_MAIN'";
} else {
    $query = "SELECT * FROM payment WHERE status = 'generated' and maker_approved_noti = '0' and bank_code = 'BDO_MAIN'";
}

$_result = $con->query($query);

//Get all branches
$queryBranches = $con->query("SELECT * FROM branches");

//notify all generated
$con->query("UPDATE payment SET maker_approved_noti='1' WHERE status='generated' and bank_code = 'BDO_MAIN'");

?>

    <!-- Main Content -->
        <div id="content">
            <div class="c1">
                
            <?php include('bdo_nav.php');?>

                <!-- content -->
                <div class="content">
                    <div id="tab-1" class="tab">

                        <div class="content-header">

                            <div class="content-header__title">
                                <span class="content-header__title-bdo">
                                    <span class="content-header__title-bdo-blue">BD</span><span class="content-header__title-bdo-yellow">O</span> 
                                </span> 
                                <span class="content-header__title-title">Verification Payment Orders</span>
                            </div>

                            <form action="bdo_for_verification_pos.php" method="POST">
                                <div class="filter-group">
                                    <input class="inputs" type='text' id='inputField' name='from' value="<?= isset($_POST['submit']) ? $_POST['from'] : date("Y/m/d"); ?>" onfocus='date1(this.id);' readonly>
                                    TO
                                    <input class="inputs" type='text' id='inputField2' name='to' value="<?= isset($_POST['submit']) ? $_POST['to'] : date("Y/m/d"); ?>"onfocus='date1(this.id);' readonly>

                                    <select name="branch" class="selectFilter">
                                        <option value="">All Branch</option>  
                                        <?php while ($res = $queryBranches->fetch_array()): ?>
                                        <option value="<?= $res['branch_name'] ?>" <?= isset($_POST['branch']) ? 'selected' : '';  ?> ><?= $res['branch_name'] ?></option>
                                        <?php endwhile; ?>
                                    </select>

                                    <input type="submit" name="submit" class="btnFilter" value="Filter" />
                                </div>
                            </form>
                        </div>
                        
                            <table class="data display datatable" id="example">
                                <thead>
                                    <th>Branch Code</th>
                                    <th>Supplier Name</th>
                                    <th>Acct. Name</th>
                                    <th>Acct. Number</th>
                                    <th>Voucher No.</th>
                                    <th>Amount</th>
                                    <th>Date Submit</th>
                                    <th>Date Approved</th>
                                    <th>Action</th>
                                </thead>

                                <tbody>
                                    <?php while($row = $_result->fetch_array()): ?>
                                    <tr>
                                        <td><?= $row['branch_code'] ?></td>
                                        <td><?= $row['supplier_name'] ?></td>
                                        <td><?= $row['account_name'] ?></td>
                                        <td><?= $row['account_number'] ?></td>
                                        <td><?= $row['voucher_no'] ?></td>
                                        <td>Php <?= number_format($row['grand_total'], 2); ?></td>
                                        <td><?= date("M d, Y", strtotime($row['date'])) . " " . date("h:i a", strtotime($row['time'])); ?></td>
                                        <?php
                                        $approvedDate = '';
                                        if ($row['approved_date'] != '') {
                                            $approvedDate .= date("M d, Y", strtotime($row['approved_date']));
                                        }
                                        if ($row['approved_time'] != '') {
                                            $approvedDate .= " " . date("h:i a", strtotime($row['approved_time']));
                                        }
                                        ?>
                                        <td><?= $approvedDate ?></td>
                                        <td>
                                            <a rel='facebox' href='./../ifrm_cv.php?payment_id=<?= $row['payment_id'] ?>'><button>View</button></a>
                                        </td>
                                    </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                    </div>
                </div>
                <!-- end content -->
            </div>
        </div>
        <!-- End Main Content -->
        
<?php include('bdo_footer.php'); ?>

