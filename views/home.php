<?php
ob_start();
require_once "/opt/lampp/htdocs/DrinkWeb/control/db_check.php";
require_once "/opt/lampp/htdocs/DrinkWeb/include/include.php";
require_once dirname(__FILE__)."/gotop.php";
$db = new DBController();
$conn = $db->connectDB();
require_once dirname(__FILE__)."/nav.php";

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

if (isset($_GET['action'])){
    deletecomm($conn, $_COOKIE['CommentID'],1,1);
}

if (isset($_GET['action2'])){
    deletecomm($conn, $_COOKIE['CommentID'],2,1);
}

?>
<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="css/checkboxstyle.css">
        <link rel="stylesheet" href="css/trashstyle.css">
        <!--標籤名字-->
        <title>珍吸生命，人人有擇</title>
        <script>
        $(function() {
            $('a[href*="#"]:not([href="#"])').click(function() {
                if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
                    var target = $(this.hash);
                    //target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                    target = $('[name=' + this.hash.slice(1) + ']');
                    if (target.length) {
                        $('html, body').animate({
                            scrollTop: target.offset().top
                        }, 1000);
                        return false;
                    }
                }

            });
        });
        function setBrand($id){
            document.cookie="BrandID="+$id;
        }

        function sendToggle2()
        {
            document.getElementById("formcheckbox").submit();

        }

        function delcomm($id){
            document.cookie="CommentID="+$id;
            Swal.fire({
                title: '確定刪除這則留言？',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Delete'
            }).then((result) => {
                if (result.value) {
                    document.location.href ="/DrinkWeb/views/home.php?action=ok";
                    window.location = '../views/home.php?action=ok';
                }  
            })   
        }

        function delstorecomm($id){
            document.cookie="CommentID="+$id;
            Swal.fire({
                title: '確定刪除這則留言？',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Delete'
            }).then((result) => {
                if (result.value) {
                    document.location.href ="/DrinkWeb/views/home.php?action2=ok";
                    window.location = '../views/home.php?action2=ok';
                }  
            })   
        }

    </script>
        
    </head>
    <body>   
        <!--大塊說明列-->
        <section id='intro' name='intro'>
            <div class='jumbotron'>
                <div class='container'>
                    <div class="col-md-12">
                        <h1 style="text-align: start;">「珍吸生命，人人有擇」</h1>
                        <p class='lead' style="margin-top: 20px;">全台唯一，手搖專屬評論網站</p>
                        <a class='btn' href="comment.php" style="margin-top: 20px;">現在就留下第一則評論</a>
                    </div>
                </div>
            </div>
        </section>
        <!--內文介紹-->
        <section id='list' name='list' style="padding-top: 50px;">
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
        <div id='info' name='info' style="padding-top: 60px;">
        <div class='container'>
            <div class="row">
                    <div class="col-md-12 text-center">
                        <h3>留言一覽</h3>
                    </div>
            </div>
            <form method="get" action='./home.php' id="formcheckbox" enctype="multipart/form-data">
                <div class="onoffswitch2">
                        <input type="checkbox" name="myonoffswitch2" class="onoffswitch2-checkbox" id="myonoffswitch2" tabindex="0" onchange="sendToggle2()" <?php
                        if (isset($_GET["myonoffswitch2"])&&$_GET["myonoffswitch2"]==="on"){
                            echo "checked";
                        }?>
                        ><label class="onoffswitch2-label" for="myonoffswitch2">
                            <span class="onoffswitch2-inner"></span>
                            <span class="onoffswitch2-switch"></span>
                        </label>
                </div>
            </form> 
                <?php
                        if (isset($_GET['myonoffswitch2'])&& $_GET['myonoffswitch2'] === "on") {
                            getAllComment($conn);
                        }else{
                            getAllDrinkComment($conn);
                        }
                ?> 
        </div>    
</div>
</body>
</html>
<?php 
ob_end_flush();
?>