<style>
    th{
        border-bottom: solid;
        padding-left:20px;
    }
    td{
        padding-left:20px;
        border-bottom: solid;
        border-width: 1px;
    }
</style>
<?php
session_start();
$po_number_list=$_SESSION['po_number_list'];
echo "<h3>Press confirm to finalize batch</h3><hr>";
echo "<table border=1>";
echo "<th>Po #</th>";
echo "<th>CV #</th>";
echo "<th>Supplier ID</th>";
echo "<th>Supplier Name</th>";
echo "<th>Amount</th>";
include("configPhp.php");
foreach($po_number_list as $po_number) {
    echo "<tr>";
    echo "<td>$po_number</td>";
    $query="SELECT * FROM check_voucher where po_number=$po_number";
    $result=mysql_query($query);
    if($row = mysql_fetch_array($result)) {
        echo "<td>".$row['cv_no']."</td>";
        echo "<td>".$row['supplier_id']."</td>";
        echo "<td>".$row['supplier_name']."</td>";
        echo "<td>".$row['final_amount']."</td>";
    }
    echo "</tr>";

}

echo "</table>";
?>