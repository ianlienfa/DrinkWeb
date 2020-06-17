<?php 
ob_start();
require_once "/opt/lampp/htdocs/DrinkWeb/include/include.php";
require_once "/opt/lampp/htdocs/DrinkWeb/control/db_check.php";
require_once dirname(__FILE__)."/store_nav.php";
//require_once dirname(__FILE__)."/js/commentjs.php";

 if(!isset($_COOKIE["login"])&&$_COOKIE["login"]==null)
 {
    echo "<script>Swal.fire({
        title: '須登入才能留言',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Login'
      }).then((result) => {
        if (result.value) {
            window.location = '../views/login.php'
        }
      })</script>";
 }
$db = new DBController();
$conn = $db->connectDB();
?>
<!doctype html>
<html lang="en">
<link rel="stylesheet" href="css/comment.css">
<link rel="stylesheet" href="//at.alicdn.com/t/font_1356455_c5d3d3ohlbq.css">
<link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<style>
    .row
    {
        margin: 20px;
    }
</style>
    
    <div class="card container" id="commentdiv" style="margin-top: -270px;">
        
            <?php getBrandSelection($conn); ?>                    
        
    </div>

</form>

    <!-- <div class="card container" id="commentdiv2" style="display: none;">
        <div class="row text-right">
            <div class="col">
                <button id="close" onclick="closecommentbtn()"></button>
            </div>
        </div>
        <div style="margin-top: 15px; font-size: 18px;">
            <p>寫下想說的話</p>
            <input type="text" name="storetext" placeholder="">
        </div> -->

    <!-- </div> -->
</html>

<?php 
ob_end_flush();
?>