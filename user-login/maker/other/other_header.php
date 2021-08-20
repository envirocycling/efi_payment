<?php @session_start();
include "./../../../configPhp.php";

$branch = isset($_GET['branch']) ? $_GET['branch'] : '';

if (!isset($_SESSION['acctg_id'])) {
    echo "<script>location.replace('../../../');</script>";
}
if($_SESSION['acctg_id'] == '48'){
    include('auto_notification.php');
}

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
    <title>EFI Payment System | BDO</title>

    <link media="all" rel="stylesheet" type="text/css" href="./../css/all.css" />
    <link rel="stylesheet" type="text/css" href="./../css/reset.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="./../css/text.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="./../css/grid.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="./../css/layout.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="./../css/nav.css" media="screen" />
    <link href="./../src/facebox.css" media="screen" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" media="all" href="./../jsDatePick_ltr.min.css" />
    <link rel="stylesheet" href="other.css">

    <script src="./../js/jquery-1.6.4.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="./../js/jquery-ui/jquery.ui.core.min.js"></script>
    <script src="./../js/setup.js" type="text/javascript"></script>
    <script src="./../src/facebox.js" type="text/javascript"></script>
    <script type="text/javascript" src="./../jsDatePick.min.1.3.js"></script>
    <script type="text/javascript" src="other.js"></script>
</head>

<body>
    <div id="wrapper" >

