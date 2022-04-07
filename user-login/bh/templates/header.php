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
            <li class='<?= $activeLink == "home" ? "active" : ""?>'><a href="index.php">My Online Payments</a></li>
            <li class='<?= $activeLink == "gcash" ? "active" : ""?>'><a href="gcash.php">My GCash Payments</a></li>
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