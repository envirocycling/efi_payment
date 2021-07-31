<script type='text/javascript' src='jquery-1.3.2.min.js'></script>
<link rel="stylesheet" type="text/css" href="css/reset.css" media="screen" />
<link rel="stylesheet" type="text/css" href="css/text.css" media="screen" />
<link rel="stylesheet" type="text/css" href="css/grid.css" media="screen" />
<link rel="stylesheet" type="text/css" href="css/layout.css" media="screen" />
<link rel="stylesheet" type="text/css" href="css/nav.css" media="screen" />
<script src="js/jquery-1.6.4.min.js" type="text/javascript"></script>
<script type="text/javascript" src="js/jquery-ui/jquery.ui.core.min.js"></script>
<script src="js/setup.js" type="text/javascript"></script>

<script type="text/javascript">

    $(document).ready(function () {
        setupLeftMenu();

        $('.datatable').dataTable();
        setSidebarHeight();


    });
</script>

<link href="src/facebox.css" media="screen" rel="stylesheet" type="text/css" />
<script src="src/facebox.js" type="text/javascript"></script>
<script type="text/javascript">
    jQuery(document).ready(function($) {
        $('a[rel*=facebox]').facebox({
            loadingImage : 'src/loading.gif',
            closeImage   : 'src/closelabel.png'
        })
    })
</script>

<table class="data display datatable" id="example">
    <article>
        <?php
        $branch=$_GET['branch'];
        include("configPhp.php");
        $query="SELECT * FROM check_voucher where branch ='$branch'";
        $result=mysql_query($query);
        echo "<thead>";
        echo "<th>po #</th>";

        echo "<th>Supplier ID</th>";
        echo "<th>Supplier Name</th>";
        echo "<th>Date</th>";
        echo "<th>Status</th>";
        echo "<th>Action</th>";
        echo "</thead>";
        while($row = mysql_fetch_array($result)) {
            echo "<tr>";
            echo "<td>" .$row['po_number']. "</td>";

            echo "<td>".$row['supplier_id']."</td>";
            echo "<td>".$row['supplier_name']."</td>";
            echo "<td>".$row['date']."</td>";
            echo "<td>".$row['status']."</td>";
            echo "<td><a rel='facebox' href='printCV.php?irmr=".$row['irmr_no']."&po_number=".$row['po_number']."'><button>View </button></a></td>";
            echo "</tr>";

        }
        ?>

</table>

