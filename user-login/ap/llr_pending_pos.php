<?php include('templates/template.php'); ?>
<div class="tabs">
    <div id="tab-1" class="tab">
        <h1>Payment Orders For Approval</h1>
        <table class="data display datatable" id="example">
            <article>

                <?php


                include("configPhp.php");
                $query="SELECT * FROM check_voucher where status='pending' and bh_signature ='LLRTentative.jpg'";
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
                    echo "<td><a rel='facebox' href='ifrm_cv.php?irmr=".$row['irmr_no']."&po_number=".$row['po_number']."'><button>View </button></a></td>";
                    echo "</tr>";

                }
                ?>

        </table>

        </article>
    </div>




</div>
<?php include ('templates/footer.php'); ?>
