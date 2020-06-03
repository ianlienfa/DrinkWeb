<?php
require_once "/opt/lampp/htdocs/DrinkWeb/include/include.php"; 
require_once dirname(__FILE__)."/store_nav.php";
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
    <link rel="stylesheet" href="css/store.css">
    <title>日出茶太 | 珍吸生命</title>
    <script src="https://kit.fontawesome.com/e40da61bd8.js" crossorigin="anonymous"></script>

</head>
  <body>
    <section id='info'>
        <div class='jumbotron'>
            <div class='container'>
                <div class="row">
                    <?php 
                        $db = new DBController();
                        $conn = $db->connectDB();
                        getBrandInfo($conn,$_COOKIE['BrandID']);
                    ?>
                </div>
            </div>
        </div>
    </section>

    <section id='info'>
        <div class='container'>
            <div>
                <?php
                    getBrandComment($conn,$_COOKIE['BrandID']);
                    $db->unconnectDB();
                    unset($db);
                ?>               
            </div>
        </div>    
    </section>
  </body>
</html>