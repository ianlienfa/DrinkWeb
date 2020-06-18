<?php
ob_start();
require_once "/opt/lampp/htdocs/DrinkWeb/include/include.php"; 
require_once dirname(__FILE__)."/store_nav.php";
require_once dirname(__FILE__)."/gotop.php";
require_once "/opt/lampp/htdocs/DrinkWeb/control/db_check.php";
$db = new DBController();
$conn = $db->connectDB();

if (isset($_GET['action'])){
    deletecomm($conn, $_COOKIE['CommentID'],1,2);
}

if (isset($_GET['action2'])){
    deletecomm($conn, $_COOKIE['CommentID'],2,2);
}
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
    <link rel="stylesheet" href="css/trashstyle.css">
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

    function setStore($id){
        document.cookie="StoreID="+$id;
    }

    function sendToggle1()
    {
        //let params=(new URL(document.location)).searchParams;
        //let name=params.get('myonoffswitch');
        //document.cookie="switch="+name;
        document.getElementById("formcheckbox").submit(); 
    }

    function sendToggle2()
    {
        //let params=(new URL(document.location)).searchParams;
        //let name=params.get('myonoffswitch2');
        //document.cookie="switch2="+name;
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
                    document.location.href ="/DrinkWeb/views/brand.php?action=ok";
                    window.location = '../views/brand.php?action=ok';
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
                    document.location.href ="/DrinkWeb/views/brand.php?action2=ok";
                    window.location = '../views/brand.php?action2=ok';
                }  
            })   
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
                
        </div>
    </div>

<div id='info'>
        <div class='container'>
            <form method="get" action='./brand.php' id="formcheckbox" enctype="multipart/form-data">
                    <div class="onoffswitch">
                        <input type="checkbox" name="myonoffswitch" class="onoffswitch-checkbox" id="myonoffswitch" onchange="sendToggle1()" tabindex="0" <?php if (isset($_GET['myonoffswitch'])&&$_GET['myonoffswitch']==='on'){echo "checked";}?>>
                        <label class="onoffswitch-label" for="myonoffswitch">
                            <span class="onoffswitch-inner"></span>
                            <span class="onoffswitch-switch"></span>
                        </label>
                    </div>
                <?php 
                if (isset($_GET['myonoffswitch']) && $_GET['myonoffswitch'] === "on"){
                    echo '<div class="onoffswitch2">
                        <input type="checkbox" name="myonoffswitch2" class="onoffswitch2-checkbox" id="myonoffswitch2" tabindex="0" onchange="sendToggle2()"';
                        if (isset($_GET["myonoffswitch2"])&&$_GET["myonoffswitch2"]==="on"){
                            echo "checked";
                        }
                        echo '><label class="onoffswitch2-label" for="myonoffswitch2">
                            <span class="onoffswitch2-inner"></span>
                            <span class="onoffswitch2-switch"></span>
                        </label>
                    </div>';
                }
                ?>
            </form>
                <?php
                    if (isset($_GET['myonoffswitch']) && $_GET['myonoffswitch'] === "on"){
                        if (isset($_GET['myonoffswitch2'])&& $_GET['myonoffswitch2'] === "on") {
                            getBrandComment($conn,$_COOKIE['BrandID']);
                        }else{
                            getDrinkComment($conn,$_COOKIE['BrandID']);
                        }
                    }else{
                        getStorelist($conn,$_COOKIE['BrandID']);
                    }
                ?>  
        </div>    
</div>
</body>
<?php 
    $db->unconnectDB();
    unset($db);
?>
</html>

<?php 
ob_end_flush();
?>