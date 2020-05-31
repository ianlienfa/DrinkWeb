<?php 
require_once "/opt/lampp/htdocs/DrinkWeb/include/include.php";
require_once "/opt/lampp/htdocs/DrinkWeb/control/db_check.php";
require_once dirname(__FILE__)."/login_nav.php";
if (isset($_POST['loginbtn'])&&isset($_POST['account'])&&isset($_POST['passwd']))
{
    $db = new DBController();
    $conn = $db->connectDB();
    $userid=login($conn,$_POST['account'],$_POST['passwd']);
    if ($userid!=0)
    {
        setcookie('login',$userid,time()+3600);
        setcookie('LAST_ACTIVITY',time(),time()+3600);
        header("Location: ./home.php"); //將網址改為登入成功後要導向的頁面
    }else{
        echo "<script>Swal.fire({
            title: 'Incorrect Username or Password!',
            icon: 'error',
            confirmButtonText: 'OK'
        })
        </script>";
    }
    $db->unconnectDB();
    unset($db);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="css/login_style.css">
</head>
<body>  
<div class="container">
    <div class="row align-items-center" style="height: 100%;">
        <div class="col text-center">
            <h1>Login</h1>
            <form method="post" action='login.php' id="formlogin" style="text-align:center; margin-top: 10px;">
                <div class="inputdiv"><h6>Account</h6>
                    <input type="text" name="account" class="login_input" autocomplete="off">
                </div>
                <div class="inputdiv">
                <h6>Password</h6>
                    <input type="password" name="passwd" class="login_input" autocomplete="off">
                </div>
                <div class="inputdiv">
                    <input type="submit" name="loginbtn" id="loginbtn" value="Login" onmouseover="this.style.backgroundColor='white'; this.style.color='black';" onmouseout="this.style.backgroundColor='black'; this.style.color='white';">
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>