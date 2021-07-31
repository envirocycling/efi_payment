<?php include("bdo_header.php");

$userId = $_SESSION['user_id'];
$sql_user = $con->query("SELECT * from users WHERE user_id='$userId'");
$row_user = $sql_user->fetch_array();

// Datatables data
if (isset($_POST['submit'])) {

    $from = $_POST['from'];
    $to = $_POST['to'];

    $query = "SELECT * FROM payment WHERE status='approved' and (date >= '$from' and date <= '$to') and branch_code NOT LIKE '%" . $_SESSION['branch'] . "%' and printed='1' and bank_code = 'BDO_MAIN'";

} else {
    $query = "SELECT * FROM payment WHERE status='approved' and printed='1' and branch_code NOT LIKE '%" . $_SESSION['branch'] . "%' and bank_code = 'BDO_MAIN'";
}

$_result = $con->query($query);

//Get all branches
$queryBranches = $con->query("SELECT * FROM branches");

$ctr = 0;

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
                                <span class="content-header__title-title">Generate Orders</span>
                            </div>

                            <form action="bdo_generate_pos.php" method="POST">
                                <div class="filter-group">
                                    <input class="inputs" type='text' id='inputField' name='from' value="<?= isset($_POST['submit']) ? $_POST['from'] : date("Y/m/d"); ?>" onfocus='date1(this.id);' readonly>
                                    TO
                                    <input class="inputs" type='text' id='inputField2' name='to' value="<?= isset($_POST['submit']) ? $_POST['to'] : date("Y/m/d"); ?>"onfocus='date1(this.id);' readonly>

                                    <select name="branch" class="selectFilter">
                                        <option value="">All Branch</option>  
                                        <?php while ($res = $queryBranches->fetch_array()): ?>
                                        <option value="<?= $res['branch_name'] ?>"><?= $res['branch_name'] ?></option>
                                        <?php endwhile; ?>
                                    </select>

                                    <input type="submit" name="submit" class="btnFilter" value="Filter" />
                                </div>
                            </form>
                        </div>
                        
                        <form name='myform' onsubmit='return OnSubmitForm();' method='POST'>
                            <table class="data display datatable" id="example">
                                <thead>
                                    <th><input type="checkbox" id="selectall"></th>
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
                                        <td><input id='cv_<?= $ctr ?>' class='checkbox' type='checkbox' name='cv_<?= $ctr ?>' value='<?= $row['payment_id']  ?>' /></td>
                                        <td><?= $row['branch_code'] ?></td>
                                        <td><?= $row['supplier_name'] ?></td>
                                        <td><?= $row['account_name'] ?></td>
                                        <td><?= $row['account_number'] ?></td>
                                        <td><?= $row['voucher_no'] ?></td>
                                        <td>Php<?= number_format($row['grand_total'], 2); ?></td>
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
                                    <?php $ctr++; ?>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>

                            <input type="hidden" name="ctr" value="<?= $ctr; ?>">

                            <div class="generate-action">

                                <div class="radio-group">
                                    <div class="radio-group__item">
                                        <input class="radio" type="radio" name="operation" value="1" id="_1" checked />
                                        <label for="_1">Mark as Generated</label>
                                    </div>

                                    <div class="radio-group__item">
                                        <input class="radio" type="radio" name="operation" value="2" id="_2" />
                                        <label for="_2">Generate Batch</label>
                                    </div>
                                </div>
                                
                                <div class="radio-group__item">
                                    <label for="_ref">Reference #: </label>
                                    <input class="ref_num" type="text" name="ref_number" value="" id="_ref" />
                                </div>
                                
                                <button class="radio-group__btn" onclick="return confirm('All data will mark as proccessed, Once you click the [Ok] you cant undo this action.')">Generate</button>

                            </div>

                        </form>
                    </div>
                </div>
                <!-- end content -->
            </div>
        </div>
        <!-- End Main Content -->
        
<?php include('bdo_footer.php'); ?>