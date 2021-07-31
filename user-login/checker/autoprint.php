<?php  
 $page = $_SERVER['PHP_SELF'];
 $sec = "60";
 header("Refresh: $sec; url=$page");
?>

<?php
include('templates/template.php');
include("configPhp.php");
?>
<link rel="stylesheet" type="text/css" media="all" href="jsDatePick_ltr.min.css" />
<script type="text/javascript" src="jsDatePick.min.1.3.js"></script>
<script type="text/javascript">
    function date1(str) {
        new JsDatePick({
            useMode: 2,
            target: str,
            dateFormat: "%Y/%m/%d"

        });
    }
    ;

    function openWindow(str) {
        $("#" + str).hide();
        window.open("print_po.php?payment_id=" + str, 'mywindow', 'width=1020,height=600,left=150,top=20');
    }
</script>
<style>
    .inputs{
        font-size: 14px;
        width: 80px;
        height: 18px
    }
    .select{
        font-size: 14px;
        width: 100px;
        height: 18px
    }
    .submit{
        font-size: 14px;
        height: 23px;
    }
</style>
<br /><br />
<center>
<h2>Auto Printing Activated</h2>
<br /><br />
<img src='Autoprint.gif' /></center>
<?php include ('templates/footer.php'); ?>
<html>
<body>
<html>

 <?php

    date_default_timezone_set("Asia/Singapore");
    include 'configPhp.php';	
$select =mysql_query("SELECT * FROM payment Where status='approved' And printed='0' order by payment_id Asc LIMIT 1 ") or die (mysql_error());
if(mysql_num_rows($select) > 0){
?>
<script>
function openWin() {
    myWindow = window.open("print_po2.php", "myWindow", "width=400, height=200"); 

	  // Opens a new window
}

</script>

<html>
<body onload="openWin()">
</body>
</html>
<?php
}?>
<!--
<script>
    window.close();
</script> -->

</body>
</html>




