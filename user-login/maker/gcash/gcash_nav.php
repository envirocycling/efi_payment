 <?php
 
 $uriSegments = explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

$lastSegment = end($uriSegments);

$queryCountPo = "SELECT * FROM payment WHERE status='approved' and bank_code = 'GCASH'";
$_resultCountPo = $con->query($queryCountPo);
$resultCountPo = $_resultCountPo->num_rows;

$queryCountPrinted = "SELECT * FROM payment WHERE status='approved' and printed='1' and bank_code = 'GCASH'";
$_resultCountPrinted = $con->query($queryCountPrinted);
$resultCountPrinted = $_resultCountPrinted->num_rows;

$queryCountGenerated = "SELECT * FROM payment WHERE status='generated' and maker_approved_noti='0' and bank_code = 'GCASH'";
$_resultCountGenerated = $con->query($queryCountGenerated);
$resultCountGenerated = $_resultCountGenerated->num_rows;
 
 ?>
 
 <!-- header -->
                <div class="controls">

                    <nav class="links">
                        <ul>
                            <li class="nav-li">
                                <a href="gcash_index.php?branch=Pampanga" class="nav-item <?= $lastSegment === 'gcash_index.php' ? 'nav-item-active' : ''?>">
                                    <span class="nav-item__text">Request for POs</span>
                                    <span class="num <?= $resultCountPo ? 'badge-yellow' : '' ?> "><?= $resultCountPo ?></span>
                                </a>
                            </li>

                            <li class="nav-li">
                                <a href="gcash_generate_pos.php" class="nav-item <?= $lastSegment === 'gcash_generate_pos.php' ? 'nav-item-active' : ''?>">
                                    <span class="nav-item__text">Generate Batch POs</span>
                                    <span class="num <?= $resultCountPrinted ? 'badge-yellow' : '' ?>"><?= $resultCountPrinted ?></span>
                                </a>
                            </li>

                            <li class="nav-li">
                                <a href="gcash_for_verification_pos.php" class="nav-item <?= $lastSegment === 'gcash_for_verification_pos.php' ? 'nav-item-active' : ''?>">
                                    <span class="nav-item__text">Generated Fund Transfer</span>
                                    <span class="num <?= $resultCountGenerated ? 'badge-yellow' : '' ?>"><?= $resultCountGenerated ?></span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                    
                    <div class="profile-box">
                        <span class="profile">
                            <a href="#" class="section">
                                <img class="image" src="./../images/img1.png" alt="image description" width="26" height="26" />
                                <span class="text-box">
                                    Welcome
                                    <strong class="name"><?php echo $_SESSION['username']; ?></strong>
                                </span>
                            </a>
                            <a href="#" class="opener">opener</a>
                        </span>
                        <a href="./../logout.php" class="btn-on">On</a>
                    </div>
                    
                </div>
                <!-- end header -->