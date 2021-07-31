<?php include('templates/template.php'); ?>
<link rel="stylesheet" type="text/css" media="all" href="jsDatePick_ltr.min.css" />
<script type="text/javascript" src="jsDatePick.min.1.3.js"></script>
<script type="text/javascript">
    function date1(str){
        new JsDatePick({
            useMode:2,
            target:str,
            dateFormat:"%Y/%m/%d"

        });
    };
</script>
<div class="tabs">
    <div id="tab-1" class="tab">
        <h1>Expense Report Filter Form</h1><hr>
        <form action="report_expense_summary.php" method="POST">
            <h2> 
                <?php
                @session_start();
                include("configPhp.php");
                ?>
                Date Range:
                <input type='text' id='inputField' name='from' value="<?php echo date("Y/m/d");?>"onfocus='date1(this.id);' readonly> TO <input type='text' id='inputField2' name='to' value="<?php echo date("Y/m/d");?>"onfocus='date1(this.id);' readonly> <br>
                <br>
                <input type="submit" value="Generate Report">
                </form>
                </article>
                </div>
                </div>
                <?php include ('templates/footer.php'); ?>
