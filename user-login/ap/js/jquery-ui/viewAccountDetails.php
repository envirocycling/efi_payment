<style>
    h1{
        color:white;

    }
</style>

<?php

include("templates/template.php");
?>

<body>


<body>

    <div class="grid_10">
        <div class="box round first grid">


            <h2>
                Change Password</h2>
            <div class="block ">
                <form action="changePass.php" method="POST">
                    <table class="form">

                        <tr>
                            <td>
                                <label>
                                    <h4> Username:</h4> </label>
                            </td>
                            <td>
                                <input type="text" class="mini" name="username" value="<?php echo $_SESSION['username'];?>" readonly/>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <label>
                                    <h4> Current Password:</h4> </label>
                            </td>
                            <td>
                                <input type="password" name="current_pass" class="mini" value="" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>
                                    <h4> New Password:</h4> </label>
                            </td>
                            <td>
                                <input type="password" name="new_pass" class="mini" value="" />
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <label>
                                    <h4> Confirm Password:</h4> </label>
                            </td>
                            <td>
                                <input type="password" name="confirm_pass" class="mini" value="" />
                            </td>
                        </tr>
                        <tr>
                            <td>

                            </td>
                            <td>
                                <input type="submit" value="Change Password"/>
                            </td>
                        </tr>

                    </table>
                </form>
            </div>
        </div>
    </div>
    <div class="clear">
    </div>

<div class="clear">
</div>

</body>
</html>
