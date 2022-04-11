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
            <li class="dropdown <?= $activeLink == "home" ? "active" : ""?>">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">My Online Payments <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="index.php">Pending Payments</a></li>
                <li class="divider"></li>
                <li><a href="approved_payment.php">Approved Payments</a></li>
                <li class="divider"></li>
                <li><a href="generated_payment.php">Generated Payments</a></li>
                <li class="divider"></li>
                <li><a href="cancelled_payment.php">Cancelled Payments</a></li>
              </ul>
            </li>

            <li class="dropdown <?= $activeLink == "gcash" ? "active" : ""?>">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">My GCash Payments <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="gcash.php">Pending GCash Payments</a></li>
                <li class="divider"></li>
                <li><a href="paid_gcash_payment.php">Paid GCash Payments</a></li>
                <li class="divider"></li>
                <li><a href="cancelled_gcash_payment.php">Cancelled GCash Payments</a></li>
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