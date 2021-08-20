<?php
include('configPhp.php');
$reference_number=$_GET['reference_number'];
$result = mysql_query("SELECT * FROM transfer_details where reference_number='$reference_number'");
$row = mysql_fetch_array($result);
echo "<h2> Transaction Details</h2><hr><br>";
echo "<table>";

echo "<tr>";
echo "<td>";
echo "Reference Number: ";
echo "</td>";
echo "<td><u>";
echo $row['reference_number'];
echo "</u></td>";
echo "</tr>";

echo "<tr>";
echo "<td>";
echo "Date of Transaction: ";
echo "</td>";
echo "<td><u>";
echo $row['transfer_date'];
echo "</u></td>";
echo "</tr>";

echo "<tr>";
echo "<td>";
echo "Transferred By: ";
echo "</td>";
echo "<td><u>";
echo $row['transfered_by'];
echo "</u></td>";
echo "</tr>";

echo "<tr>";
echo "<td>";
echo "Transferred from: ";
echo "</td>";
echo "<td><u>";
echo $row['transfer_from'];
echo "</u></td>";
echo "</tr>";


echo "<tr>";
echo "<td>";
echo "Transferred to: ";
echo "</td>";
echo "<td><u>";
echo $row['transfer_to'];
echo "</u></td>";
echo "</tr>";

echo "<tr>";
echo "<td>";
echo "Amount: ";
echo "</td>";
echo "<td><u>";
echo $row['amount'];
echo "</u></td>";
echo "</tr>";

echo "<tr>";
echo "<td>";
echo "Remarks: ";
echo "</td>";
echo "<td><u>";
echo $row['remarks'];
echo "</u></td>";
echo "</tr>";


echo "</table>";
?>
<script>
    function historyBack(){
        window.history.back();
    }
</script>

<br>
<br>
<hr>
<button onclick="historyBack();">Back</button>