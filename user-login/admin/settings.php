<?php
@session_start();
include('templates/template.php');
?>
<style>
    .table{

    }
    input{
        font-size: 15px;
        width: 200px;
        height: 20px;
    }
    .submit{
        color: black;
        font-size: 15px;
        width: 150px;
        height: 20px;
    }
    .submit2{
        color: black;
        font-size: 15px;
        width: 100px;
        height: 20px;
    }

</style>
<div class="tabs">
    <div id="tab-1" class="tab">
        <h1>Change Password</h1><hr>
        <form action="changePass.php" method="POST">

            <table class="table">
                <tr>
                    <td>
                        <label>
                            <h4> Username:</h4> </label>
                    </td>
                    <td>
                        <input type="text" name="username" value="<?php echo $_SESSION['username'];?>" readonly/>
                    </td>
                </tr>

                <tr>

                    <td>

                        <label>

                            <h4> Current Password:</h4> </label>

                    </td>

                    <td>

                        <input type="password" name="current_pass" value="" />

                    </td>

                </tr>

                <tr>

                    <td>

                        <label>

                            <h4> New Password:</h4> </label>

                    </td>

                    <td>

                        <input type="password" name="new_pass" value="" />

                    </td>

                </tr>



                <tr>

                    <td>

                        <label>

                            <h4> Confirm Password:</h4> </label>

                    </td>

                    <td>

                        <input type="password" name="confirm_pass" value="" />

                    </td>

                </tr>

                <tr>

                    <td>



                    </td>

                    <td>

                        <input class="submit" type="submit" value="Change Password"/>

                    </td>

                </tr>



            </table>

        </form>

  
        </article>
    </div>




</div>
<?php include ('templates/footer.php'); ?>
