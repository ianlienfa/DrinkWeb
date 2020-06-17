<?php
    require_once "/opt/lampp/htdocs/DrinkWeb/include/include.php";
    require_once "/opt/lampp/htdocs/DrinkWeb/control/db_check.php";
    $db = new DBController();
    $conn = $db->connectDB();

    $BrandID = $_GET["BrandID"];
    $StoreID = $_GET["StoreID"];
    $UserID = $_GET["UserID"];
    $CommentID = $_GET["CommentID"]; 

    // $commentID = getCommentMax($conn);
    // $commentID = $commentID + 1;
    // $query = "INSERT INTO StoreComment(comment, brandID, StoreID, UserID, StoreText, EnvironRate, ServiceRate) VALUES (" .$commentID. ", " .$BrandID. ", ".$StoreID. ", " .$UserID. ", '" .$StoreText. "', ".$EnvironRate. ", ".$ServiceRate. ")";    
    
    // $result = $conn->query($query);
    // if ($result === false){
    //     echo "<p>" . "DBerror :" . mysqli_error($conn) . "</p>";
    // }


?>

<link rel="stylesheet" href="css/comment.css">
<link rel="stylesheet" href="//at.alicdn.com/t/font_1356455_c5d3d3ohlbq.css">
<link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<div class="container">
    <div class="row align-items-center" style="height: 100%; margin-top: 10px;">
        <div class="col text-center">
            <h1>Drink Comment</h1>
            <form id = "DrinkFrom" action="submitDrinkComment.php" style="text-align:center; margin-top: 10px;" enctype="multipart/form-data">
                <div class="inputdiv">
                    <!-- <div class="crop">
                        <img id="img" style="height: 60px; width: 60px;"/>
                    </div> -->
                    <!-- </label> -->
                    <!-- <br> -->
                    <div id="image" type="button" onmouseover="this.style.backgroundColor='white'; this.style.color='black';" onmouseout="this.style.backgroundColor='black'; this.style.color='white';">Choose Image
                    <input id="r_img" class="inputFile" type="file" name="r_img" onchange="show(this.files)">
                    </div>
                    <br>
                </div>
                <div class="inputdiv"><h6>DrinkName</h6>
                    <input id="DrinkName" type="text" name="DrinkName" autocomplete="off">
                </div>
                <div class="inputdiv"><h6>DrinkText</h6>
                    <input id="DrinkText" type="text" name="DrinkText" autocomplete="off">
                </div>
                
                <div >
                    <label>DrinkRate</label>
                    <input id="DrinkRate" type="range" name = "DrinkRate" class="custom-range" min="0" max="5" >
                </div>
                <div>
                    <label>IngredRate</label>
                    <input id="IngredRate" type="range" name = "IngredRate" class="custom-range" min="0" max="5" >
                </div>
                <div>
                    <label>SweetRate</label>
                    <input id="SweetRate" type="range" name = "SweetRate" class="custom-range" min="0" max="5" >
                </div>
                <div>
                    <label>PriceRate</label>
                    <input id="PriceRate" type="range" name = "PriceRate" class="custom-range" min="0" max="5" >
                </div>
                <div class="inputdiv">
                    <input id="submitbtn" type="button" name="submitbtn"  value="Submit" onmouseover="this.style.backgroundColor='white'; this.style.color='black';" onmouseout="this.style.backgroundColor='black'; this.style.color='white';" onclick = "Drinksubmit();">
                </div>
            </form>
        </div>
    </div>
</div>


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
function Drinksubmit()
{
    let StoreID= <?php echo $StoreID; ?>;
    let BrandID = <?php echo $BrandID; ?>;
    let UserID = <?php echo $UserID; ?>;
    let CommentID = <?php echo $CommentID; ?>;
    let DrinkName = document.getElementById('DrinkName').value;
    let DrinkText = document.getElementById('DrinkText').value;
    let IngredRate = document.getElementById('IngredRate').value;
    let SweetRate = document.getElementById('SweetRate').value;
    let PriceRate = document.getElementById('PriceRate').value;
    let DrinkRate = document.getElementById('DrinkRate').value;

    let url = "/DrinkWeb/views/submitDrinkComment.php?" + "BrandID=" +BrandID+ "&StoreID=" + StoreID + "&UserID=" + UserID + "&CommentID=" + CommentID
    + "&DrinkName=" + DrinkName + "&DrinkText=" + DrinkText + "&IngredRate=" + IngredRate + "&SweetRate=" + SweetRate + "&PriceRate=" + PriceRate + "&DrinkRate=" + DrinkRate;
    
    console.log(url);
    document.location.href = url;
}
</script>
