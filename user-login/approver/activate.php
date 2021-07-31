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

<style>
    .table{
        font-size: 15px;
        text-align: left;
    }
</style>
<body>
    <center>
        <h5>Activate Reliever</h5>
        <form action="activate_exec.php" method="POST">
            <input type="hidden" name="user_id" value="<?php echo $_GET['user_id']; ?>">
            <table class="table">
                <tr>
                    <td>From: </td>
                    <td><input type='text'  id='inputField' name='from' value="" onfocus='date1(this.id);' readonly></td>
                </tr>
                <tr>
                    <td>TO: </td>
                    <td><input type='text'  id='inputField2' name='to' value="" onfocus='date1(this.id);' readonly></td>
                </tr>
                <tr>
                    <td align="center" colspan="2"><input type="submit" name="submit" value="Activate"></td>
                </tr>
            </table>
        </form>
    </center>
</body>