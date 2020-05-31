<?php 
require_once "/opt/lampp/htdocs/DrinkWeb/include/include.php";
require_once "/opt/lampp/htdocs/DrinkWeb/control/db_check.php";
require_once dirname(__FILE__)."/login_nav.php";
if (isset($_POST['resetbtn'])&&isset($_POST['oldpasswd'])&&isset($_POST['newpasswd'])&&isset($_POST['checknewpasswd']))
{
    $db = new DBController();
    $conn = $db->connectDB();
    resetpasswd($conn,$_COOKIE['login'],$_POST['oldpasswd'],$_POST['newpasswd'],$_POST['checknewpasswd']);
    $db->unconnectDB();
    unset($db);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
    <link rel="stylesheet" href="css/login_style.css">
</head>
<body>  
<div class="container">
    <div class="row align-items-center" style="height: 100%;">
        <div class="col text-center">
            <h1>Reset Password</h1>
            <form method="post" action='reset_passwd.php' id="formlogin" style="text-align:center; margin-top: 10px;">
                <div class="inputdiv"><h6>Old Password</h6>
                    <input type="password" name="oldpasswd" class="login_input" autocomplete="off">
                </div>
                <div class="inputdiv">
                <h6>New Password</h6>
                    <input type="password" name="newpasswd" class="login_input" autocomplete="off">
                </div>
                <div class="inputdiv">
                <h6>Check New Password</h6>
                    <input type="password" name="checknewpasswd" class="login_input" autocomplete="off">
                </div>
                <div class="inputdiv">
                    <input type="submit" name="resetbtn" id="loginbtn" value="Reset" onmouseover="this.style.backgroundColor='white'; this.style.color='black';" onmouseout="this.style.backgroundColor='black'; this.style.color='white';">
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>