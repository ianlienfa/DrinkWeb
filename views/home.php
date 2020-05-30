<?php
require_once "/opt/lampp/htdocs/DrinkWeb/control/db_check.php";
require_once "/opt/lampp/htdocs/DrinkWeb/include/include.php";
require_once dirname(__FILE__)."/nav.php";
$db = new DBController();
$conn = $db->connectDB();
if (isset($_POST['search'])&&isset($_POST['search_btn'])){
    $id=searchBrand($conn,$_POST['search']);
    if ($id!=0){
        setcookie('BrandID',$id);
        header("Location: ../views/brand.php"); //將網址改為登入成功後要導向的頁面
    }else{
        echo "<script>Swal.fire({
            title: '查無此店家',
            icon: 'error',
            confirmButtonText: 'OK'
        })
        </script>";
    }
}
?>
<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!--標籤名字-->
        <title>珍吸生命，人人有擇</title>
    </head>

    <body>   
        <!--大塊說明列-->
        <section id='intro'>
            <div class='jumbotron'>
                <div class='container'>
                    <div class="col-md-12">
                        <h1>「珍吸生命，人人有擇」</h1>
                        <p class='lead'>全台唯一，手搖專屬評論網站</p>
                        <a class='btn' href="#">現在就留下第一則評論</a>
                    </div>
                </div>
            </div>
        </section>
        <!--內文介紹-->
        <section id='list' style="padding-top: 50px;">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h3>店家一覽 </h3>
                    </div>
                </div>
                <div class="row" style="margin-bottom: 50px;">
                    <div class="col-md-12 text-center" style="text-align:center;">
                        <form method="post" action='home.php' style="margin: auto; text-align:center;" id="searchform">
                            <input type="text" placeholder="Search Brand" id="forminput" name="search" autocomplete="off">
                            <button class="btn my-2 my-sm-0" type="submit" name="search_btn" id="searchbtn"><img src="picture/Search.png" style="box-shadow: transparent 0px 0px 0px 0px; height: 20px;width: 20px;"/></button>
                        </form>
                    </div>
                </div>
            <?php 
                getBrandPics($conn);
            ?>
            </div>
        </section>
    </body>
</html>