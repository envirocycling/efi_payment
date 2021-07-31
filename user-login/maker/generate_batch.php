
<?php include('templates/template.php'); ?>
<link rel="stylesheet" type="text/css" media="all" href="jsDatePick_ltr.min.css" />
<script type="text/javascript" src="jsDatePick.min.1.3.js"></script>
<script src="js/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
    function date1(str) {
        new JsDatePick({
            useMode: 2,
            target: str,
            dateFormat: "%Y/%m/%d"

        });
    }
    ;

    $(window).load(function () {
        $(".editbox").hide();
        $("span").click(function () {
            var ID = $(this).attr('id');
            $("#value_" + ID).hide(500);
            $("#edit_" + ID).show(500);
        });
        $("button").click(function () {
            var ID = $(this).attr('id');
            $("#edit_" + ID).hide(500);
            $("#value_" + ID).show(500);
            var remarks = $("#rem_" + ID).val();
            var remarks2 = $("#remarks_" + ID).val();

            alert(remarks + '===' + remarks2);
            $("#value_" + ID).html(remarks2);
            if (remarks != remarks2) {
                var dataString = 'id=' + ID + '&remarks=' + remarks2;
                $.ajax({
                    type: "POST",
                    url: "save_remarks.php",
                    data: dataString,
                    cache: false
                });
            }
        });
    });
</script>
<style>
    .inputs{
        font-size: 14px;
        width: 80px;
        height: 25px
    }
    .submit{
        font-size: 14px;
        height: 23px;
    }
    table{
        border: solid 1px;
        font-size: 20px;
    }
    table td{
        border: solid 1px;
        padding: 3px;
    }
</style>
<div class="tabs">
    <div id="tab-1" class="tab">
        <h1>Generated Batch</h1>
        <table>
            <tr>
                <td>ACCOUNT NAME</td>
                <td>ACCOUNT NUMBER</td>
                <td>AMOUNT</td>
                <td>REMARKS</td>
            </tr>
            <?php
            $ctr = 0;
            $id_array = "";
            while ($ctr < $_POST['ctr']) {
                if (isset($_POST['cv_' . $ctr])) {
                    $sql_payment_det = mysql_query("SELECT * FROM payment WHERE payment_id='" . $_POST['cv_' . $ctr] . "'");
                    $rs_payment_det = mysql_fetch_array($sql_payment_det);
                    
                    mysql_query("UPDATE payment SET status='generated',reference_number='" . $_POST['ref_number'] . "',transfer_date='" . date("Y/m/d") . "',transfer_time='" . date("h:i:s a") . "',transfer_by='" . $_SESSION['user_id'] . "' WHERE payment_id='" . $_POST['cv_' . $ctr] . "'");
                    echo "<tr>";
                    echo "<td>" . $rs_payment_det['cheque_name'] . "</td>";
                    echo "<td>" . $rs_payment_det['account_number'] . "</td>";
                    echo "<td>" . number_format($rs_payment_det['grand_total'], 2) . "</td>";
                    echo "<td>
                            <input type='hidden' id='rem_" . $rs_payment_det['payment_id'] . "' value='" . $rs_payment_det['remarks'] . "'>
                            <span id='" . $rs_payment_det['payment_id'] . "' class='text'>
                            <div id='value_" . $rs_payment_det['payment_id'] . "'>";
                    if ($rs_payment_det['remarks'] == '') {
                        echo "Input";
                    } else {
                        echo $rs_payment_det['remarks'];
                    }
                    echo "</div></span>
                            <div id='edit_" . $rs_payment_det['payment_id'] . "' class='editbox'><textarea id='remarks_" . $rs_payment_det['payment_id'] . "'>" . $rs_payment_det['remarks'] . "</textarea>
                            <button id='" . $rs_payment_det['payment_id'] . "'>Save</button></div>
                                </td>";
                    echo "</tr>";
                    if ($id_array == '') {
                        $id_array.=$rs_payment_det['payment_id'];
                    } else {
                        $id_array.="_" . $rs_payment_det['payment_id'];
                    }
                }
                $ctr++;
            }
            ?>
        </table>
        <form action="export_batch.php" method="POST">

            <input type="hidden" name="id" value="<?php echo $id_array; ?>">
            <br>
            <input type="submit" name="submit" value="EXPORT">
        </form>

        <a href="index.php"><input type="submit" name="back" value="BACK"></a>
        </article>
    </div>




</div>
<?php include ('templates/footer.php'); ?>
