<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
  <div class="sidebar-brand-text mx-3">Payment System</div>
</a>

<!-- Divider -->
<hr class="sidebar-divider my-0 mb-4">

<!-- Heading -->
<div class="sidebar-heading">
  Payment Order
</div>

<!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item">
  <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSBC" aria-expanded="true" aria-controls="collapseSBC">
    <i class="fas fa-fw fa-bank"></i>
    <span>SBC</span>
  </a>
  <?php die($base_url);?>
  <div id="collapseSBC" class="collapse" aria-labelledby="headingSBC" data-parent="#accordionSidebar">
    <div class="bg-white py-2 collapse-inner rounded">
      <h6 class="collapse-header">Payment Order:</h6>
      <a class="collapse-item" href="<?= $base_url ?>/sbc">For Approval</a>
      <a class="collapse-item" href="cards.html">For Cancellation</a>
      <a class="collapse-item" href="cards.html">Reports</a>
    </div>
  </div>
</li>

<!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item">
  <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBDO" aria-expanded="true" aria-controls="collapseBDO">
    <i class="fas fa-fw fa-cog"></i>
    <span>BDO</span>
  </a>
  <div id="collapseBDO" class="collapse" aria-labelledby="headingBDO" data-parent="#accordionSidebar">
    <div class="bg-white py-2 collapse-inner rounded">
    <h6 class="collapse-header">Payment Order:</h6>
      <a class="collapse-item" href="buttons.html">For Approval</a>
      <a class="collapse-item" href="cards.html">For Cancellation</a>
      <a class="collapse-item" href="cards.html">Reports</a>
    </div>
  </div>
</li>


<!-- Divider -->
<hr class="sidebar-divider d-none d-md-block">

<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
  <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>

</ul>
<!-- End of Sidebar -->