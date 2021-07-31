<?php
include 'configPhp.php';
$id = $_GET['id'];
echo 'PO_NO.'.$id;
?>
<form action="print_po2.php?id=<?php echo $id;?>" method="post" >
REASON:<textarea name="remarks" cols="15" rows="5" required></textarea>
<input type="submit" value="Submit" onClick="return confirm('Do you want to continue?');">
</form>