<?php
include("configPhp.php");
mysql_query("Update payment SET status='approved' Where payment_id='".$_GET['id']."'");
?>
<script>
alert("Successful.");
location.replace("index.php");
</script>