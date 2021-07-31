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
        <h1>Input Journal Entry Criteria</h1><hr>
        <form action="report_expense_summary.php" method="POST">
            <h2>
                <?php


                include("configPhp.php");
                $query="SELECT branch from check_voucher group by branch";
                $result=mysql_query($query);

                while( $row = mysql_fetch_array($result)) {
                    echo "<option value='".$row['branch']."'>".$row['branch']."</option>";
                }
                echo "</select>";

                ?>
                <br>
                Date Range:
                <input type='text' id='inputField' name='from' value="<?php echo $_SESSION['date'];?>"onfocus='date1(this.id);' readonly> TO <input type='text' id='inputField2' name='to' value="<?php echo $_SESSION['date'];?>"onfocus='date1(this.id);' readonly> <br>

                <br>
                <input type="submit" value="Generate Journal Entries">
                </form>

                </article>
                </div>




                </div>
                <?php include ('templates/footer.php'); ?>
