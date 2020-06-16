<?php
require_once "/opt/lampp/htdocs/DrinkWeb/include/include.php"; 
require_once dirname(__FILE__)."/store_nav.php";
require_once dirname(__FILE__)."/gotop.php";
require_once "/opt/lampp/htdocs/DrinkWeb/control/db_check.php";
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC:wght@300;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/brand.css">
    <title>珍吸生命，人人有擇</title>
    <script src="https://kit.fontawesome.com/e40da61bd8.js" crossorigin="anonymous"></script>

<script>
    function menubtn() {
        var menuBtn = document.getElementById('menubtn');
        var menuimg = document.getElementById('menuimg');
        if (menuimg.style.display === 'none') {
            $('#menuimg').fadeIn();
            menuimg.style.display = 'inline-block';
        }
    }
    function closebtn() {
        var closeBtn = document.getElementById('close');
        var menuimg = document.getElementById('menuimg');
        $('#menuimg').fadeOut();
    }

</script>

</head>
<body>
    <div id='info'>
        <div class='jumbotron' style = 'height: 100%; background-image:url("picture/d.jpeg"); background-size: cover; -webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;'>
                    <?php 
                        $db = new DBController();
                        $conn = $db->connectDB();
                        getBrandInfo($conn,$_COOKIE['BrandID']);
                    ?>
                <form method="post" action='brand.php' id="formcheckbox" enctype="multipart/form-data">
                    <div class="onoffswitch">
                        <input type="checkbox" name="myonoffswitch" class="onoffswitch-checkbox" id="myonoffswitch" onchange="switchchange()" tabindex="0" checked>
                        <label class="onoffswitch-label" for="myonoffswitch">
                            <span class="onoffswitch-inner"></span>
                            <span class="onoffswitch-switch"></span>
                        </label>
                    </div>
                </form>
        </div>
    </div>

<div id='info'>
        <div class='container'>
                <div class="onoffswitch2">
                    <input type="checkbox" name="myonoffswitch2" class="onoffswitch2-checkbox" id="myonoffswitch2" tabindex="0" checked>
                    <label class="onoffswitch2-label" for="myonoffswitch2">
                        <span class="onoffswitch2-inner"></span>
                        <span class="onoffswitch2-switch"></span>
                    </label>
                </div>
                <?php
                    if (empty($_POST["myonoffswitch"]) ) {
                        getBrandComment($conn,$_COOKIE['BrandID']);
                    }else{
                    }
                    $db->unconnectDB();
                    unset($db);
                ?>  
        </div>    
</div>
</body>
</html>