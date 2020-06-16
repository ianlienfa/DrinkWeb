<?php
    require_once "/opt/lampp/htdocs/DrinkWeb/include/include.php";
    require_once "/opt/lampp/htdocs/DrinkWeb/control/db_check.php";
    $db = new DBController();
    $conn = $db->connectDB();

    $BrandID = $_COOKIE["BrandIdforDB"];
    $StoreID = $_GET["StoreID"];
    $EnvironRate = $_GET["range1"];
    $ServiceRate = $_GET["range2"];
    $StoreText = $_GET["storetext"];
    // $UserID = $_COOKIE["login"];
    $UserID = 1;
    

    $commentID = getCommentMax($conn);
    $commentID = $commentID + 1;
    $query = "INSERT INTO StoreComment(comment, brandID, StoreID, UserID, StoreText, EnvironRate, ServiceRate) VALUES (" .$commentID. ", " .$BrandID. ", ".$StoreID. ", " .$UserID. ", '" .$StoreText. "', ".$EnvironRate. ", ".$ServiceRate. ")";    
    
    $result = $conn->query($query);
    if ($result === false){
        echo "<p>" . "DBerror :" . mysqli_error($conn) . "</p>";
    }


?>

<script >
    
    document.location.href ="/DrinkWeb/views/home.php";
    
</script>