<?php
include("configPhp.php");
?>
<style>
    .table{
        font-size: 15px;
        text-align: left;
    }
</style>
<center>
    <h5>Add New</h5>
    <form action="add_new_exec.php" method="POST">
        <table class="table">
            <tr>
                <td>Username: </td>
                <td><input type="text" name="username" value="" required></td>
            </tr>
            <tr>
                <td>Password: </td>
                <td><input type="password" name="password" value="" required></td>
            </tr>
            <tr>
                <td>First Name: </td>
                <td><input type="text" name="firstname" value="" required></td>
            </tr>
            <tr>
                <td>Last Name: </td>
                <td><input type="text" name="lastname" value="" required></td>
            </tr>
            <tr>
                <td>Initial: </td>
                <td><input type="text" name="initial" value="" required></td>
            </tr>
            <tr>
                <td>Position: </td>
                <td><select name="position">
                        <option value="Accounts Payable">Accounts Payable</option>
                        <option value="Reliever">Reliever</option>
                    </select></td>
            </tr>
            <tr>
                <td align="center" colspan="2"><input type="submit" name="submit" value="Submit"></td>
            </tr>
        </table>
    </form>
</center>