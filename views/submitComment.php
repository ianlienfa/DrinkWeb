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
    if(isset($_COOKIE["login"]))
    {
        $UserID = $_COOKIE["login"];
    }

    $commentID = getCommentMax($conn);
    $commentID = $commentID + 1;
    $date=date("Y-m-d");
    $query = "INSERT INTO StoreComment(comment, brandID, StoreID, UserID, StoreText, EnvironRate, ServiceRate,CommentDate) VALUES (" .$commentID. ", " .$BrandID. ", ".$StoreID. ", " .$UserID. ", '" .$StoreText. "', ".$EnvironRate. ", ".$ServiceRate.",'".$date. "')";    
    
    $result = $conn->query($query);
    if ($result === false){
        echo "<p>" . "DBerror :" . mysqli_error($conn) . "</p>";
    }


?>

<script >

    function getCookie(cname) {
        var name = cname + "=";
        var decodedCookie = decodeURIComponent(document.cookie);
        var ca = decodedCookie.split(';');
        for(var i = 0; i <ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') {
            c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
            }
        }
    return "";
    }
    let params=(new URL(document.location)).searchParams;
    let storeId=params.get('StoreID');
    let brandId = getCookie('BrandIdforDB');
    let UserId = 1;
    let CommentID = <?php echo $commentID; ?>;
    if(getCookie('login') != '')
    {
        UserId = getCookie('login');
    }

    document.location.href ="/DrinkWeb/views/DrinkComment.php?" + "BrandID=" +brandId+ "&StoreID=" + storeId + "&UserID=" + UserId + "&CommentID=" + CommentID;
    
</script>