<?php
    require_once "/opt/lampp/htdocs/DrinkWeb/include/include.php";
    require_once "/opt/lampp/htdocs/DrinkWeb/control/db_check.php";
    date_default_timezone_set("Asia/Taipei");
    $db = new DBController();
    $conn = $db->connectDB();

    $BrandID = $_GET["BrandID"];
    $StoreID = $_GET["StoreID"];
    $UserID = $_GET["UserID"];
    $CommentID = $_GET["CommentID"]; 
    $DrinkName = $_GET["DrinkName"];
    $DrinkText = $_GET["DrinkText"];
    $IngredRate = $_GET["IngredRate"];
    $SweetRate = $_GET["SweetRate"];
    $PriceRate = $_GET["PriceRate"];
    $DrinkRate = $_GET["DrinkRate"];
    $date=date("Y-m-d");


    $query = "INSERT INTO DrinkComment(CommentID, brandID, StoreID, UserID, DrinkName, DrinkText, DrinkRate, IngredRate, SweetRate, PriceRate,CommentDate) VALUES ("
    .$CommentID. ", " .$BrandID. ", ".$StoreID. ", " .$UserID. ", '" .$DrinkName. "', '".$DrinkText. "', ".$DrinkRate.", ".$IngredRate.", ".$SweetRate.", ".$PriceRate.",'".$date. "')";    
    // echo $query;
    $result = $conn->query($query);
    if ($result === false){
        echo "<p>" . "DBerror :" . mysqli_error($conn) . "</p>";
    }
?>

<script>
    document.location.href ="/DrinkWeb/views/home.php";
</script>