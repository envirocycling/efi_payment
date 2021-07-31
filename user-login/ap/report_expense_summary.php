<?php
@session_start();
include("configPhp.php");
$branch=$_SESSION['branch'];
$from=$_POST['from'];
$to=$_POST['to'];
$query = "SELECT * FROM payment WHERE status='generated' and branch_code like '%$branch%' and date>='$from' and date<='$to' ORDER BY date";
$result=mysql_query($query);

echo '<style>
table {
    border-collapse: collapse;
    border-spacing: 0;
    margin: 0 15px;
}
tr {
    padding: 3px 0;
}

th {
    background-color: #CCCCCC;
    border: 1px solid #DDDDDD;
    color: red;
    font-weight:bold;
    font-family: trebuchet MS;
    font-size: 15px;
    padding-bottom: 4px;
    padding-left: 6px;
    padding-top: 5px;
    text-align: left;
}
td {
    border: 1px solid #CCCCCC;
    font-size: 15px;
    padding: 3px 7px 2px;
}
</style>
<h2>Envirocycling Fiber Inc.</h2>
<h2>Expense Summary of '.$branch.' branch </h2><br>
<table id="gallerytab" cellspacing="2" cellpadding="1" border="1">
<tr>
<th><font face="Arial, Helvetica, sans-serif">DATE</font></th>
<th><font face="Arial, Helvetica, sans-serif">BRANCH CODE</font></th>
<th><font face="Arial, Helvetica, sans-serif">CV #</font></th>
<th><font face="Arial, Helvetica, sans-serif">REF #</font></th>
<th><font face="Arial, Helvetica, sans-serif">SUPPLIER</font></th>
\<th><font face="Arial, Helvetica, sans-serif">ACCOUNT NAME</font></th>
<th><font face="Arial, Helvetica, sans-serif">ACCOUNT NUMBER</font></th>
<th><font face="Arial, Helvetica, sans-serif">AMOUNT</font></th>
</tr>';

while($row = mysql_fetch_array($result)) {
    echo "<tr>";
    echo "<td>". $row['transfer_date'].  "</td>";
    echo "<td>". $row['branch_code'].  "</td>";
    echo "<td>". $row['voucher_no'].  "</td>";
    echo "<td>". $row['reference_number'].  "</td>";
    echo "<td>". $row['supplier_name'].  "</td>";
    echo "<td>". $row['account_name'].  "</td>";
    echo "<td>". $row['account_number'].  "</td>";
    echo "<td>". number_format($row['grand_total'],2).  "</td>";
    echo "</tr>";



}
echo "<table><br>";



?>