<?php
@session_start();

if (isset($_SESSION['ap'])) {
    echo "<script>location.replace('user-login/ap/');</script>";
}
if (isset($_SESSION['bh_id'])) {
    echo "<script>location.replace('user-login/branch-head/');</script>";
}
if (isset($_SESSION['maker_id'])) {
    echo "<script>location.replace('user-login/maker/');</script>";
}
if (isset($_SESSION['verifier_id'])) {
    echo "<script>location.replace('user-login/verifier/');</script>";
}
if (isset($_SESSION['approver_id'])) {
    echo "<script>location.replace('user-login/approver/');</script>";
}


?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Login</title>

        <!--STYLESHEETS-->
        <link href="css/style.css" rel="stylesheet" type="text/css" />

        <!--SCRIPTS-->
        <script type="text/javascript" src="js/jquery/jquery-1.4.1.min.js"></script>
        <!--Slider-in icons-->
        <script type="text/javascript">
            $(document).ready(function() {
                $(".username").focus(function() {
                    $(".user-icon").css("left","-48px");
                });
                $(".username").blur(function() {
                    $(".user-icon").css("left","0px");
                });

                $(".password").focus(function() {
                    $(".pass-icon").css("left","-48px");
                });
                $(".password").blur(function() {
                    $(".pass-icon").css("left","0px");
                });
            });
        </script>

    </head>
    <body>

        <!--WRAPPER-->
        <div id="wrapper">

            <!--SLIDE-IN ICONS-->
            <div class="user-icon"></div>
            <div class="pass-icon"></div>
            <!--END SLIDE-IN ICONS-->

            <!--LOGIN FORM-->
            <form name="login-form" class="login-form" action="validation.php" method="post">

                <!--HEADER-->
                <div class="header">
                    <h1>Envirocycling Fiber Inc.</h1>
                </div>
                <!--END HEADER-->

                <!--CONTENT-->
                <div class="content">
                    <!--USERNAME--><input name="username" type="text" class="input username" value="Username" onfocus="this.value=''" /><!--END USERNAME-->
                    <!--PASSWORD--><input name="password" type="password" class="input password" value="Password" onfocus="this.value=''" /><!--END PASSWORD-->
                </div>
                <!--END CONTENT-->

                <!--FOOTER-->
                <div class="footer">
                    <!--LOGIN BUTTON--><input type="submit" name="submit" value="Login" class="button" /><!--END LOGIN BUTTON-->
                    <!--REGISTER BUTTON-->
                    <!-- <input type="submit" name="submit" value="Register" class="register" /> -->
                    <!--END REGISTER BUTTON-->
                </div>
                <!--END FOOTER-->

            </form>
            <!--END LOGIN FORM-->

        </div>
        <!--END WRAPPER-->

        <!--GRADIENT--><div class="gradient"></div><!--END GRADIENT-->

    </body>
</html>