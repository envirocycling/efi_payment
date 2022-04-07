<?php include_once 'controllers/pending.php'; ?>

<!DOCTYPE html>
<html>
<head>
<?php include 'includes/header.php'; ?>
<link rel="stylesheet" href="css/vue-modal.css">
</head>
<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
<body class="hold-transition skin-green layout-top-nav">
<div class="wrapper">

  <!-- Header -->
  <?php include 'includes/nav.php';?>

  <!-- Full Width Column -->
  <div class="content-wrapper" id="app">
    <div class="container">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          My Pending Payments / 
          <small>{{bankOptions[filters.bank]}}</small> / 
          <small>{{ formattedDateRange }}</small>
        </h1>
      </section>

      <!-- Main content -->
      <section class="content">

        <div class="row">
          <div class="col-md-12">
              <div class="box box-success">
                <div class="box-header">
                  Filter Payments
                </div>
                <div class="box-body">

                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Date Range:</label>
                      <date-picker
                        v-model:value="filters.daterange"
                        type="date"
                        range
                        clearable="false"
                        placeholder="Select date range"
                        @change="handleChangeDatePicker"
                      ></date-picker>                    
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="bank_code">Bank:</label>
                      <select class="form-control" id="bank_code">
                          <option v-for="(val, key) in bankOptions" :key="key" value="key">{{val}}</option>
                      </select>                    
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="search">Search:</label>
                      <input class="form-control" type="text">                 
                    </div>
                  </div>
                </div>

                </div>
              </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
            <div class="box box-success">
              <div class="box-body">
                <x-table :payments="payments" :loading="isLoading" :open-modal="openModal"></x-table>
              </div>
            </div>
          </div>
        </div>

        <x-modal v-if="showModal" @close="closeModal" :payment="payment" :modal-title="'Payment Details'"></x-modal>
        
      </section>
      <!-- /.content -->
    </div>
    <!-- /.container -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Footer -->
  <?php include 'includes/footer.php'; ?>

</div>
<!-- ./wrapper -->

<!-- Javasctips -->
<?php include 'includes/scripts.php'; ?>
<script src="js/components/x-table.js" type="module"></script>
<script src="js/components/x-modal.js" type="module"></script>
<script src="js/pending.js" type="module"></script>

</body>
</html>