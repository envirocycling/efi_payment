<?php session_start();

if (!isset($_SESSION['ap_id'])) {
    echo "<script>location.replace('../../');</script>";
}

include './../../query_builder/queryBuilder.php'; 

$branch = $_SESSION['branch'];
$fn = $_SESSION['firstname'];
$ln = $_SESSION['lastname'];
$name = $fn.' '.$ln;

if(isset($_POST['filter'])) {

  $daterange = $_POST['daterange'];
  $bankCode = $_POST['bank_code'];
  $dateArr = explode('-', $daterange);

  $startDate = trim($dateArr[0]);
  $endDate = trim($dateArr[1]);

} else {

  $bankCode = '';
  $startDate = date('Y/m/d');
  $endDate = date('Y/m/d');
  $daterange = "{$startDate} - {$endDate}";

}

$payments = getCancelledPayments($bankCode, $branch, $startDate, $endDate);

?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>EFI Payment | Account Payable</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="./../../assets/adminLTE/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- daterange picker -->
  <link rel="stylesheet" href="./../../assets/adminLTE/bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="./../../assets/adminLTE/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="./../../assets/adminLTE/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="./../../assets/adminLTE/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="./../../assets/adminLTE/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="./../../assets/adminLTE/dist/css/skins/_all-skins.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

  <style>
    .modal-body {
      height: 95vh;
    }
  </style>

</head>
<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
<body class="hold-transition skin-blue layout-top-nav">
<div class="wrapper">

  <header class="main-header">
    <nav class="navbar navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          <a href="index.php" class="navbar-brand"><b>EFI</b> Payment</a>
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
            <i class="fa fa-bars"></i>
          </button>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse pull-left" id="navbar-collapse">

          <ul class="nav navbar-nav">
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Payment Order <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="index.php">Pending Payment</a></li>
                <li class="divider"></li>
                <li><a href="generated_payment.php">Generated Payment</a></li>
                <li class="divider"></li>
                <li><a href="cancelled_payment.php">Cancelled Payment</a></li>
              </ul>
            </li>
          </ul>

        </div>
        <!-- /.navbar-collapse -->
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?=$name?> <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="logout.php">Logout</a></li>
              </ul>
            </li>
          </ul>
        </div>

        <!-- /.navbar-custom-menu -->
      </div>
      <!-- /.container-fluid -->
    </nav>
  </header>
  <!-- Full Width Column -->
  <div class="content-wrapper">
    <div class="container">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          Payment Order |
          <small>cancelled</small>
        </h1>

      </section>

      <!-- Main content -->
      <section class="content">
        <div class="row">
          <div class="col-md-4">
              <div class="box box-danger">
                <div class="box-body">
                  <form method="POST">

                    <div class="form-group">

                      <label>Date Range:</label>

                      <div class="input-group date">
                        <div class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" class="form-control pull-right input-sm" id="daterange" name="daterange" readonly>
                      </div>
                      <!-- /.input group -->
                    </div>

                    <div class="form-group">
                      <label for="bank_code">Bank Code:</label>
                      <select class="form-control input-sm" name="bank_code" id="bank_code">
                        <option value="" <?=$bankCode==''?'selected':''?>>All Bank</option>
                        <option value="SBC" <?=$bankCode=='SBC'?'selected':''?>>SBC</option>
                        <option value="BDO_MAIN" <?=$bankCode=='BDO_MAIN'?'selected':''?>>BDO</option>
                      </select>
                    </div>

                    <div class="form-group">
                      <button class="btn btn-primary btn-sm btn-block" type="submit" name="filter">Filter</button>
                    </div>

                  </form>
                </div>
              </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
            <div class="box box-danger">
            <!-- <div class="box-header">
              <h3 class="box-title">Data Table With Full Features</h3>
            </div> -->
            <!-- /.box-header -->
            <div class="box-body">
              <table id="tablepayment" class="table table-bordered table-striped ">
                <thead class="">
                  <th>Branch Code</th>
                  <th>Supplier Name</th>
                  <th>Acct. Name</th>
                  <th>Acct. Number</th>
                  <th>Voucher No.</th>
                  <th>Amount</th>
                  <th>Date</th>
                  <th>Status</th>
                  <th>Action</th>
                </thead>

              <tbody>
                <?php foreach ($payments as $payment): ?>
                  <tr>
                    <td><?= $payment['branch_code'] ?></td>
                    <td><?= $payment['supplier_name'] ?></td>
                    <td><?= $payment['account_name'] ?></td>
                    <td><?= $payment['account_number']  ?></td>
                    <td><?= $payment['voucher_no'] ?></td>
                    <td><?= number_format($payment['grand_total'],2) ?>Php</td>
                    <td><?= $payment['date'] ?></td>
                    <td><span class="label label-danger">Cancelled</span></td>
                    
                    <td><button class="btn btn-sm btn-primary" id="<?=$payment['payment_id']?>" onclick="handleClick(this.id)" data-toggle="modal" data-payment="" data-target="#modal-default">View</button></td>
                </tr>
                <?php endforeach;?>
                
              </tbody>
            </table>
          </div>
        </div>
          </div>
        </div>

      </section>
      <!-- /.content -->
    </div>
    <!-- /.container -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="container">
      <div class="pull-right hidden-xs">
        <b>Version</b> 01
      </div>
       2021 EFI Payment - ITD
    </div>
    <!-- /.container -->
  </footer>
</div>
<!-- ./wrapper -->

<!-- Modal -->
        <div class="modal fade" id="modal-default">

          <div class="modal-dialog modal-dialog-center modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-body">
                <iframe frameborder="0" scrolling="false" height="100%" width="100%"></iframe>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- End Modal -->

<!-- jQuery 3 -->
<script src="./../../assets/adminLTE/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="./../../assets/adminLTE/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="./../../assets/adminLTE/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- date-range-picker -->
<script src="./../../assets/adminLTE/bower_components/moment/min/moment.min.js"></script>
<script src="./../../assets/adminLTE/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>

<!-- FastClick -->
<script src="./../../assets/adminLTE/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="./../../assets/adminLTE/dist/js/adminlte.min.js"></script>

<!-- DataTables -->
<script src="./../../assets/adminLTE/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="./../../assets/adminLTE/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

<script>

  $('#daterange').daterangepicker({
    startDate: moment().startOf('month'),
    endDate  : moment().endOf('month'),
    opens: 'right',
    locale: {
      format: 'YYYY/MM/DD'
    }
  });

  $('#daterange').val('<?=$daterange?>');

  $('#tablepayment').DataTable({
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : true
    });

  function handleClick(id) {

    $('.modal').find('iframe').attr('src','ifrm_cv.php?payment_id='+id);

  }
</script>

</body>
</html>
