<?php
    ob_start();
    require_once "/opt/lampp/htdocs/DrinkWeb/include/include.php";
    require_once "/opt/lampp/htdocs/DrinkWeb/control/db_check.php";
    require_once dirname(__FILE__)."/store_nav.php";
    $db = new DBController();
    $conn = $db->connectDB();

    //$CommentID = $_GET["CommentID"]; 

    date_default_timezone_set("Asia/Taipei");

    // $commentID = getCommentMax($conn);
    // $commentID = $commentID + 1;
    // $query = "INSERT INTO StoreComment(comment, brandID, StoreID, UserID, StoreText, EnvironRate, ServiceRate) VALUES (" .$commentID. ", " .$BrandID. ", ".$StoreID. ", " .$UserID. ", '" .$StoreText. "', ".$EnvironRate. ", ".$ServiceRate. ")";    
    
    // $result = $conn->query($query);
    // if ($result === false){
    //     echo "<p>" . "DBerror :" . mysqli_error($conn) . "</p>";
    // }
    if (isset($_POST['submitbtn'])){
        if (isset($_POST['DrinkName'])&&isset($_POST['DrinkRate'])&&isset($_POST['IngredRate'])&&isset($_POST['SweetRate'])&&isset($_POST['PriceRate'])&&isset($_POST['DrinkText'])){
            $imgData=null;
            $imageProperties=null;
            if (count($_FILES)){
                if (is_uploaded_file($_FILES['r_img']['tmp_name'])) {
                    $imgData = addslashes(file_get_contents($_FILES['r_img']['tmp_name']));
                    $imageProperties = getimageSize($_FILES['r_img']['tmp_name']);
                }
            }
            $BrandID=$_COOKIE['DrinkBrandID'];
            $StoreID=$_COOKIE['DrinkStoreID'];
            $UserID=$_COOKIE['DrinkUserID'];
            $date=date("Y-m-d");
            $query = "INSERT INTO DrinkComment(brandID, StoreID, UserID, DrinkName, DrinkText, DrinkRate, IngredRate, SweetRate, PriceRate,CommentDate,DrinkImg, DrinkImgMime) VALUES
            ($BrandID,$StoreID,$UserID,'$_POST[DrinkName]','$_POST[DrinkText]',$_POST[DrinkRate],$_POST[IngredRate],$_POST[SweetRate],$_POST[PriceRate],'$date','$imgData','$imageProperties[mime]')";    
            // echo $query;
            $result = $conn->query($query);
            if ($result === false){
                echo "<p>" . "DBerror :" . mysqli_error($conn) . "</p>";
            }else{
                echo "<script> Swal.fire({
                    icon: 'success',
                    title: '留言成功',
                    showConfirmButton: false,
                    timer: 2000
                }).then((result) => {
                        window.location = '../views/home.php'}) 
                </script>";
            }
        }
    }


?>

<link rel="stylesheet" href="css/comment.css">
<link rel="stylesheet" href="css/register_style.css">
<link rel="stylesheet" href="//at.alicdn.com/t/font_1356455_c5d3d3ohlbq.css">
<link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<div class="card container" id="commentdiv" style="height: 800px; margin-top: -270px; margin-bottom: 20px;">
    <div class="row align-items-center" style="height: 100%; margin-top: 10px;">
        <div class="col text-center">
            <h2 style="margin-top: 20px;"><b>對手搖飲評價吧！</b></h2>
            <form id = "DrinkFrom" method="post" action="DrinkComment.php" style="text-align:center; margin-top: 10px;" enctype="multipart/form-data">
                <div class="inputdiv"><h6>手搖飲品項</h6>
                    <input id="DrinkName" style="width: 200px; text-align: center;" type="text" name="DrinkName" autocomplete="off">
                </div>
                <div class="inputdiv">
                    <div class="crop">
                        <img id="img" style="height: 100px; width: 100px;"/>
                    </div>
                    <br>
                    <div id="image" type="button" onmouseover="this.style.backgroundColor='white'; this.style.color='black';" onmouseout="this.style.backgroundColor='black'; this.style.color='white';">新增飲料相片
                    <input id="r_img" class="inputFile" type="file" name="r_img" onchange="showon(this.files)">
                    </div>
                    <br>
                </div>                
                <div class="inputdiv">
                    <label>飲料</label>
                    <input id="DrinkRate" type="range" name = "DrinkRate" class="slider" min="0" max="5" >
                </div>
                <div class="inputdiv">
                    <label>配料</label>
                    <input id="IngredRate" type="range" name = "IngredRate" class="slider" min="0" max="5" >
                </div>
                <div class="inputdiv">
                    <label>甜度</label>
                    <input id="SweetRate" type="range" name = "SweetRate" class="slider" min="0" max="5" >
                </div>
                <div class="inputdiv">
                    <label>價格</label>
                    <input id="PriceRate" type="range" name = "PriceRate" class="slider" min="0" max="5" >
                </div>
                <div class="inputdiv"><h6>對這杯手搖飲我想說...</h6>
                    <input id="DrinkText" type="text" name="DrinkText" autocomplete="off">
                </div>
                <div class="inputdiv">
                    <input id="submitbtn" type="submit" name="submitbtn"  value="Submit" onmouseover="this.style.backgroundColor='white'; this.style.color='black';" onmouseout="this.style.backgroundColor='black'; this.style.color='white';">
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    function showon(f) {
        var str = "";
        for (var i = 0; i < f.length; i++) {
            var reader = new FileReader();
            reader.readAsDataURL(f[i]);
            reader.onload = function (e) {
                str = "<img style=\"object-position: center; height: 100px; width: auto; \" id='img' src='" + e.target.result + "'/>";
                $("#img")[0].outerHTML = str;
            }
        }        
    }
/*function Drinksubmit()
{
    let StoreID= <?php echo $StoreID; ?>;
    let BrandID = <?php echo $BrandID; ?>;
    let UserID = <?php echo $UserID; ?>;

    let url = "/DrinkWeb/views/submitDrinkComment.php?" + "BrandID=" +BrandID+ "&StoreID=" + StoreID + "&UserID=" + UserID;
    
    console.log(url);
    document.location.href = url;
}*/
</script>

<?php 
ob_end_flush();
?>
