<?php 
require_once "/opt/lampp/htdocs/DrinkWeb/include/include.php";
require_once "/opt/lampp/htdocs/DrinkWeb/control/db_check.php";
require_once dirname(__FILE__)."/login_nav.php";
if (isset($_POST['registerbtn'])&&isset($_POST['r_account'])&&isset($_POST['r_passwd'])&&isset($_POST['r_checkpasswd'])&&isset($_POST['r_username']))
{
    $db = new DBController();
    $conn = $db->connectDB();
    if (count($_FILES)){
        if (is_uploaded_file($_FILES['r_img']['tmp_name'])) {
            $imgData = addslashes(file_get_contents($_FILES['r_img']['tmp_name']));
            $imageProperties = getimageSize($_FILES['r_img']['tmp_name']);
        }
    }
    register($conn,$_POST['r_account'],$_POST['r_passwd'],$_POST['r_checkpasswd'],$_POST['r_username'],$imgData,$imageProperties['mime']);
    $db->unconnectDB();
    unset($db);
}
?>
<script>
     function show(f) {
        var str = "";
        for (var i = 0; i < f.length; i++) {
            var reader = new FileReader();
            reader.readAsDataURL(f[i]);
            reader.onload = function (e) {
                str += "<img  height='60' width='60' style=\"border-radius:50%; object-position: center; \" id='img' src='" + e.target.result + "'/>";
                $("#img")[0].outerHTML = str;
            }
        }        
    }
</script>
<!DOCTYPE html>
<html>
<head>
    <title>Registration</title>
    <link rel="stylesheet" href="css/login_style.css">
    <link rel="stylesheet" href="css/register_style.css">
</head>
<body>  
<div class="container">
    <div class="row align-items-center" style="height: 100%; margin-top: 10px;">
        <div class="col text-center">
            <h1>Registration</h1>
            <form method="post" action='register.php' id="formlogin" style="text-align:center; margin-top: 10px;" enctype="multipart/form-data">
                <div class="inputdiv">
                    <div class="crop">
                        <img id="img" style="height: 60px; width: 60px;"/>
                    </div>
                    </label>
                    <br>
                    <div id="image" type="button" onmouseover="this.style.backgroundColor='white'; this.style.color='black';" onmouseout="this.style.backgroundColor='black'; this.style.color='white';">Choose Image
                    <input id="r_img" class="inputFile" type="file" name="r_img" onchange="show(this.files)">
                    </div>
                </div>
                <div class="inputdiv"><h6>Username</h6>
                    <input type="text" name="r_username" class="login_input" autocomplete="off">
                </div>
                <div class="inputdiv"><h6>Account</h6>
                    <input type="text" name="r_account" class="login_input" autocomplete="off">
                </div>
                <div class="inputdiv">
                <h6>Password</h6>
                    <input type="password" name="r_passwd" class="login_input" autocomplete="off">
                </div>
                <div class="inputdiv">
                <h6>Check Password</h6>
                    <input type="password" name="r_checkpasswd" class="login_input" autocomplete="off">
                </div>
                <div class="inputdiv">
                    <input type="submit" name="registerbtn" id="loginbtn" value="Registration" onmouseover="this.style.backgroundColor='white'; this.style.color='black';" onmouseout="this.style.backgroundColor='black'; this.style.color='white';">
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>