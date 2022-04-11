<?php session_start();

if (!isset($_SESSION['bh_id'])) {
    echo "<script>location.replace('../../');</script>";
}

include './../../query_builder/queryBuilder.php';

$activeLink = 'home';

$branch = $_SESSION['branch'];

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
$initial = $_SESSION['initial'];
$position = $_SESSION['position'];
$fn = $_SESSION['firstname'];
$ln = $_SESSION['lastname'];
$name = $fn.' '.$ln;

$branchControl = getUserAccessControl($user_id);

if(isset($_POST['filter'])) {
  $daterange = $_POST['daterange'];
  $dateArr = explode('-', $daterange);
  $startDate = trim($dateArr[0]);
  $endDate = trim($dateArr[1]);
} else {
  $startDate = date('Y/m/01');
  $endDate = date('Y/m/d');
  $daterange = "{$startDate} - {$endDate}";
}

$status = 'Generated';
$header = "({$startDate} - {$endDate})   /  {$status}";
$title = "generated payments";

$paymentsArr = array();

foreach ($branchControl as $key => $value) {
  $branchQ = $value['branch_code'];

  if($branchQ === 'PSG.PMNT' || $branchQ === 'TNZ.PMNT' || $branch === 'MLVR.PMNT') {
    $startDateQ = date('Y-m-d', strtotime($startDate));
    $endDateQ = date('Y-m-d', strtotime($endDate));
  } else {
    $startDateQ = $startDate;
    $endDateQ = $endDate;
    
  }

  $paymentsArr[] = getBHOnlinePayments($position, $branchQ, $initial, $startDateQ, $endDateQ, 'generated');
}


?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>EFI Payment | Branch Head</title>
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

  <link href="./../../assets/facebox/facebox.css" media="screen" rel="stylesheet" type="text/css" />

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

  <style>
    .modal-body {
      height: 95vh;
    }
  </style>

</head>
<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
<body class="hold-transition skin-green layout-top-nav">
<div class="wrapper">

    <?php include_once 'templates/header.php';?>

  <!-- Full Width Column -->
  <div class="content-wrapper">
    <div class="container">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          Online Payment |
          <small><?= strtoupper($header); ?></small>
        </h1>

      </section>

      <!-- Main content -->
      <section class="content">

        <div class="row">
          <div class="col-md-4">
              <div class="box box-success">
                <div class="box-body">
                  <form method="POST">

                    <div class="row">
                      <div class="col-md-12">
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
                      </div>
                    </div>
                    
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <button class="btn btn-success btn-sm btn-block" type="submit" name="filter">Filter</button>
                        </div>
                      </div>
                    </div>

                  </form>
                </div>
              </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
            <div class="box box-success" style="overflow-x: scroll;">
              <div class="box-header">
                  <h4 class="box-title">
                  <?= ucwords($title); ?>
                  </h4>
              </div>

              <div class="box-body">
                <table id="tablepayment" class="table table-bordered table-striped ">
                    <thead class="">
                      <th>Supplier Name</th>
                      <th>Branch</th>
                      <th>Acct. Name</th>
                      <th>Acct. Number</th>
                      <th>Voucher No.</th>
                      <th>Amount</th>
                      <th>Date</th>
                      <th>Processed(DateTime)</th>
                      <th>Status</th>
                      <th>Action</th>
                    </thead>

                    <tbody>
                      <?php foreach ($paymentsArr as $payments): ?>
                        <?php foreach($payments as $payment):

                          $branch = explode('-', $payment['branch_code'])[0];

                          if($branch === 'PSG.PMNT') {
                              $branch = 'Pasig';
                          } else if($branch === 'TNZ.PMNT') {
                              $branch = 'Tanza';
                          } else if($branch === 'MLVR.PMNT') {
                              $branch = 'Malvar';
                          }
                        ?>
                        <tr>
                          <td><?= $payment['supplier_name'] ?></td>
                          <td><?= $branch ?></td>
                          <td><?= $payment['account_name'] ?></td>
                          <td><?= $payment['account_number']  ?></td>
                          <td><?= $payment['voucher_no'] ?></td>
                          <td><?= number_format($payment['grand_total'],2) ?>Php</td>
                          <td><?= $payment['date'] ?></td>
                          <td><?= $payment['transfer_date'].' '. $payment['transfer_time'] ?></td>
                          <td><label class="badge"><?=$status?></label></td>
                          <td>
                            <a rel='facebox' href='ifrm_cv.php?payment_id=<?php echo $payment['payment_id']; ?>'>
                              <button class="btn btn-sm btn-success">View</button>
                            </a>
                          </td>
                        </tr>
                        <?php endforeach;?>
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
  <?php include_once 'templates/footer.php';?>
</div>
<!-- ./wrapper -->

<!-- Modal -->
<div class="modal fade" id="modal-default">
  <div class="modal-dialog modal-dialog-center" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <iframe frameborder="0" scrolling="false" ></iframe>
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

<script src="./../../assets/facebox/facebox.js" type="text/javascript"></script>


<script>

  $('a[rel*=facebox]').facebox({
    loadingImage: 'src/loading.gif',
    closeImage: 'src/closelabel.png'
  });

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
