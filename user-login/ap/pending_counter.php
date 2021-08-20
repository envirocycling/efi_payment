<style>
    #counter{
        color:white;
        font-size:11px;
        font-weight:bold;
        margin-top:-10px;
    }
</style>
<?php
include('configPhp.php');
$branch=$_GET['branch'];
$query="SELECT count(po_number) FROM check_voucher where branch='$branch'";
$result=mysql_query($query);
while($row = mysql_fetch_array($result)) {
    echo "<span id='counter'><superscript>".$row['count(po_number)']."</superscript></span>";
}

?>