<?php
@session_start();
include("./../../configPhp.php");

$branch = $_GET['branch'];

if (!isset($_SESSION['acctg_id'])) {
    echo "<script>location.replace('../../');</script>";
}
if($_SESSION['acctg_id'] == '48'){
    include('auto_notification.php');
}

// Datatables data
if (isset($_POST['submit'])) {
    $from = $_POST['from'];
    $to = $_POST['to'];
    $query = "SELECT * FROM payment WHERE status = 'approved' and (date >= '{$from}' and date <= '{$to}') and branch_code like '%{$branch}%' and bank_code = 'OTHER_BANK'";
} else {
    $query = "SELECT * FROM payment WHERE status = 'approved' and branch_code like '%{$branch}%' and bank_code = 'OTHER_BANK'";
}

$_result = $con->query($query);

//Count label data
$queryCountPo = "SELECT * FROM payment WHERE status='approved' and bank_code = 'OTHER_BANK'";
$_resultCountPo = $con->query($queryCountPo);
$resultCountPo = $_resultCountPo->num_rows;

$queryCountPrinted = "SELECT * FROM payment WHERE status='approved' and printed='1' and bank_code = 'OTHER_BANK'";
$_resultCountPrinted = $con->query($queryCountPrinted);
$resultCountPrinted = $_resultCountPrinted->num_rows;

$queryCountGenerated = "SELECT * FROM payment WHERE status='generated' and maker_approved_noti='0' and bank_code = 'OTHER_BANK'";
$_resultCountGenerated = $con->query($queryCountGenerated);
$resultCountGenerated = $_resultCountGenerated->num_rows;

?>

<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <title>EFI Payment System</title>

    <link media="all" rel="stylesheet" type="text/css" href="css/all.css" />
    <link rel="stylesheet" type="text/css" href="css/reset.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="css/text.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="css/grid.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="css/layout.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="css/nav.css" media="screen" />
    <link href="src/facebox.css" media="screen" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" media="all" href="jsDatePick_ltr.min.css" />
    <link rel="stylesheet" href="bdo.css">

    <script src="js/jquery-1.6.4.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="js/jquery-ui/jquery.ui.core.min.js"></script>
    <script src="js/setup.js" type="text/javascript"></script>
    <script src="src/facebox.js" type="text/javascript"></script>
    <script type="text/javascript" src="jsDatePick.min.1.3.js"></script>
    <script type="text/javascript" src="bdo.js"></script>
</head>

<body>
    <div id="wrapper" >

    <!-- Main Content -->
        <div id="content">
            <div class="c1">
                
                <!-- header -->
                <div class="controls">

                    <nav class="links">
                        <ul>
                            <li>
                                <a href="other_index.php?branch=Pampanga" class="">
                                    Request for POs <span class="num"><?= $resultCountPo ?></span>
                                </a>
                            </li>

                            <li>
                                <a href="other_generate_pos.php" class="">
                                    Generate Batch POs <span class="num"><?= $resultCountPrinted ?></span>
                                </a>
                            </li>

                            <li>
                                <a href="other_for_verification_pos.php" class="">
                                    Generated Fund Transfer <span class="num"><?= $resultCountGenerated ?></span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                    
                    <div class="profile-box">
                        <span class="profile">
                            <a href="#" class="section">
                                <img class="image" src="images/img1.png" alt="image description" width="26" height="26" />
                                <span class="text-box">
                                    Welcome
                                    <strong class="name"><?php echo $_SESSION['username']; ?></strong>
                                </span>
                            </a>
                            <a href="#" class="opener">opener</a>
                        </span>
                        <a href="logout.php" class="btn-on">On</a>
                    </div>
                </div>
                <!-- end header -->

                <!-- content -->
                <div class="content">
                    <div id="tab-1" class="tab">

                        <div class="content-header">
                            <div class="content-header__title">
                                <span class="content-header__title-bdo">
                                    <span class="content-header__main-title">EFI</span>
                                </span> 
                                <span class="content-header__sub-title"> Other Bank Payments</span>
                            </div>

                            <form action="other_index.php?branch=<?= $branch ?>" method="POST">
                                <div class="filter-group">
                                    <?php if (isset($_POST['submit'])):  ?>

                                        <input class="inputs" type='text' id='inputField' name='from' value="<?= $_POST['from']; ?>" onfocus='date1(this.id);' readonly>
                                        TO
                                        <input class="inputs" type='text' id='inputField2' name='to' value="<?= $_POST['to']; ?>"onfocus='date1(this.id);' readonly>
                                        <input type="submit" name="submit" class="btnFilter" value="Filter" />

                                    <?php else: ?>

                                        <input class="inputs" type='text' id='inputField' name='from' value="<?= date("Y/m/d"); ?>" onfocus='date1(this.id);' readonly>
                                        TO
                                        <input class="inputs" type='text' id='inputField2' name='to' value="<?= date("Y/m/d"); ?>"onfocus='date1(this.id);' readonly>
                                        <input type="submit" name="submit" class="btnFilter" value="Filter" />

                                    <?php endif;?>
                                </div>
                            </form>
                        </div>

                        <?php include('templates/other_per_branch.php');?>

                        <table class="data display datatable" id="example">
                            <thead>
                                <th>po #</th>
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
                                <?php while($row = mysql_fetch_array($_result)): ?>
                                <tr>
                                    <td><?= $row['payment_id'] ?></td>
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
                                        <a rel='facebox' href='ifrm_cv.php?payment_id=<?= $row['payment_id'] ?>'><button>View</button></a>
                                        <?php if($row['printed'] == '0'): ?>
                                        <button name='<?= $row['payment_id'] ?>' id='<?= $row['payment_id']?>' onclick='openWindow(this.id);'>Print</button>
                                        <?php endif; ?>
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
        
        <!-- Sidenav Menu -->
        <aside id="sidebar">
            <strong class="logo"><a href="#">lg</a></strong>
            <ul class="tabset buttons">
                <li class="sidenav_menu">
                    <a href="<?= $base_url; ?>/index_new.php?branch=Pampanga">SBC</a>
                </li>

                <li class="sidenav_menu  active">
                    <a href="<?= $base_url; ?>/bdo_index.php?branch=Pampanga" >BDO</a>
                </li>

                <li class="sidenav_menu  active">
                    <a href="<?= $base_url; ?>/other_index.php?branch=Pampanga" >OTHER <br> BANK</a>
                </li>

                <li>
                    <a href="settings.php" class="ico8"><span>Settings</span><em></em></a>
                    <span class="tooltip"><span>Settings</span></span>
                </li>
            </ul>
            <span class="shadow"></span>
        </aside>
        <!-- End Sidenav Menu -->

    </div>
</body>


