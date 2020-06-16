<?php
class DBController {
	private $host = "35.229.157.50";
	private $user = "root";
	private $password = "12345678";
	private $database = "DR";
	private $conn;
    function __construct() {
        $this->conn = $this->connectDB();
	}	
	function connectDB() {
		$conn = mysqli_connect($this->host,$this->user,$this->password,$this->database);
		return $conn;
    }
    
    function unconnectDB(){
        $this->conn->close();  
    }
}

function searchBrand($conn, $search_str)
{
    $query = "SELECT BrandID from BRAND where Brandname like '%" . $search_str . "%'";
    $result = $conn->query($query);
    if($result == false)
    {
        echo "DBerror :" . mysqli_error($conn);
    }
    if ($result->num_rows) {
    /* fetch object array */
    $row = $result->fetch_row();
        return $row[0];
    }
    else{
      return 0;
    }
    /* free result set */
    $result->close();
}

function getBrandPics($conn)
{
    $query = "SELECT Brandname, Logoimg, Logomime,BrandID from BRAND";
    // count the numbers of the return rows and decide the pattern
    $result = $conn->query($query);
    if ($result === false){
        echo "<p>" . "DBerror :" . mysqli_error($conn) . "</p>";
    }
    $brand_ct = $result->num_rows;
    $row_ct = ($brand_ct/4) ? ($brand_ct/4 + 1) : ($brand_ct/4);
    // for loop of div
    for($i = 0; $i < $row_ct; $i++)
    {
        echo '<div class="row text-center">';
        for($j = 0; $j < 4; $j++)
        {
            if($row = $result->fetch_row()) {
                // header ("Content-type:".$row[2]);     
                echo '
                <div class="col-md-3">
                <div class="outer">
                    <div class="upper">
                        <a href="brand.php" onclick="setBrand('.$row[3].');">';
                            echo '<img src="data:'.$row[2].';base64,'.base64_encode($row[1]).'"/>';                            
                            echo '
                        </a>
                        <div class="innertext">
                            <p>' .$row[0].'</p> 
                        </div>
                    </div>
                    <div class="lower"></div>
                </div>
                </div>';
            }
        }
        echo "</div>";
    }
    /* free result set */
    $result->close();
}

function login($conn,$account, $password){
    $passwd=md5($password);
    $query = "SELECT UserID from USER where Account='$account' AND Passwd='$passwd'";
    $result = $conn->query($query);
    if ($result === false){
        echo "<p>" . "DBerror :" . mysqli_error($conn) . "</p>";
    }  
    if ($result->num_rows) {
        /* fetch object array */
        $row = $result->fetch_row();
            return $row[0];
    }
    else{
        return 0;
    }
    /* free result set */
    $result->close();

}

function checkUser($conn,$account,$password,$username)
{
    $query="SELECT * from USER";
    $result=$conn->query($query);
    if ($result===false){
        echo "<p>" . "DBerror :" . mysqli_error($conn) . "</p>";
    }
    if ($result->num_rows){
        while ($row=$result->fetch_row()){
            if ($account===$row[3]||$password===$row[4]||$username===$row[5]){
                return 0;
            }
        }
    }
    $result->close();
    return 1;
}

function register($conn,$account, $password,$checkpassword,$username, $imgData, $imgType){
    $passwd=md5($password);
    if ($password===$checkpassword){
        if (checkUser($conn,$account, $passwd,$username)){
            $query="INSERT INTO USER (Img,Mime,Account,Passwd,Username)VALUES('{$imgData}','$imgType','$account','$passwd','$username')";
            if (!$conn->query($query))
            {
                echo "<p>" . "DBerror :" . mysqli_error($conn) . "</p>";
            }else{ 
                echo "<script> Swal.fire({
                    icon: 'success',
                    title: 'Registration is successful!',
                    showConfirmButton: false,
                    timer: 2000
                }).then((result) => {
                        window.location = '../views/login.php'}) 
                </script>";
            }
        }  
    }else{
        echo "<script>Swal.fire({
            title: 'Check Password Again!',
            icon: 'error',
            confirmButtonText: 'OK'
        })
        </script>";
    }
}

function getUser($conn,$userid){
    $query="SELECT Img, Mime, Username from USER where UserID=$userid";
    $result=$conn->query($query);
    if ($result===false){
        echo "<p>" . "DBerror :" . mysqli_error($conn) . "</p>";
    }
    if ($result->num_rows){
        return $result->fetch_row();
    }
    $result->close();
    return 0;
}

function resetpasswd($conn,$userid,$oldpassword, $newpassword, $checknewpassword){
    $oldpasswd=md5($oldpassword);
    $query="SELECT Passwd from USER where UserID=$userid";
    $result=$conn->query($query);
    if ($result===false){
        echo "<p>" . "DBerror :" . mysqli_error($conn) . "</p>";
    }
    if ($result->num_rows){
        $row=$result->fetch_row();
        if ($row[0]===$oldpasswd){
            if ($newpassword===$checknewpassword){
                $newpasswd=md5($newpassword);
                $query="UPDATE USER SET Passwd='$newpasswd' WHERE UserID=$userid";
                if ($conn->query($query)){
                    echo "<script> Swal.fire({
                        icon: 'success',
                        title: 'Reset successfully!',
                        showConfirmButton: false,
                        timer: 2000
                    }).then((result) => {
                            window.location = '../views/home.php'}) 
                    </script>";    
                }else{
                    echo "<p>" . "DBerror :" . mysqli_error($conn) . "</p>";                    
                }

            }else{
                echo "<script>Swal.fire({
                    title: 'Check New Password Again!',
                    icon: 'error',
                    confirmButtonText: 'OK'
                })
                </script>";
            }
        }else{
            echo "<script>Swal.fire({
                title: 'Old Password is Wrong!',
                icon: 'error',
                confirmButtonText: 'OK'
            })
            </script>";
        }
    }
    $result->close();
}

function getBrandInfo($conn, $brandid){
    $query="SELECT * from BRAND where BrandID='$brandid'";
    $result=$conn->query($query);
    if ($result === false){
        echo "<p>" . "DBerror :" . mysqli_error($conn) . "</p>";
    }
    if ($result->num_rows){
        $row=$result->fetch_row();
        echo '<div class="left col-md-3 text-center">
        <img src="data:'.$row[3].';base64,'.base64_encode($row[2]).'" alt="" style="height: 200px; width: 200px; border-radius: 50%;">
        <br><span style="font-size: 50px;"><strong>'.$row[1].'</strong></span><button id="menubtn" onclick="menubtn();"></button>
        </div><div class="card" id="menuimg" style="z-index: 1;width: fit-content; height: fit-content; display:none; position: absolute; left: 50%; top: 50%; margin-left: -400px; margin-top: -200px;  background-color: transparent; border:none;">
        <img src="data:'.$row[5].';base64,'.base64_encode($row[4]).'" style="height: auto; width: 700px;"><button id="close" onclick="closebtn()"></button>
        </div>';
    }
    $result->close();

    $sumrate=calculateRate($conn,1,$brandid,0);
    $rate=ROUND((float)$sumrate/6,1);
    $ratebar=$rate*20;
    echo '<style>@keyframes whole {
        0% {width:0%; }
        100% {width:'.$ratebar.'%; }
    }</style>';
    echo '<div class="right col-md-6 offset-md-3">
    <li>
        <h4><i class="fas fa-check-circle"> 評價</i>'.$rate.' / 5</h4><span class="bar"><span class="whole" style="width:'.$ratebar.'%;animation: whole 2s;"></span></span>
    </li>
    </div>';
}

function getBrandComment($conn, $BrandID)
{
    $query = "Select U.Username, StoreText, Storename, C.EnvironRate, C.ServiceRate, CommentDate, U.Img, U.Mime from StoreComment C, STORE S, USER U where C.BrandID = S.BrandID and C.StoreID = S.ID and C.USERID = U.USERID and C.BrandID = ".$BrandID;
    // count the numbers of the return rows and decide the pattern
    $result = $conn->query($query);
    if ($result === false){
        echo "<p>" . "DBerror :" . mysqli_error($conn) . "</p>";
    }
    /* fetch object array */
    while ($row = $result->fetch_row()) {
        echo '<div class="row justify-content-center" id="commdiv">';
        echo '<div class="col-md-2 text-center" id="user">';
        if ($row[6]!=null&&$row[7]!=null){
            echo '<img id="profile" style="margin-top: 20px;" src="data:'.$row[7].';base64,'.base64_encode($row[6]).'"/>';
        }else{
            echo '<img id="profile" style="margin-top: 20px;" src="picture/profile.png"/>';            
        }
        echo '<p><b>'.$row[0].'</b></p>
        <p>'.$row[5].'</p>
        </div>';
        echo '<div class="commentcontent col-md-5"><div class="location">
                <img src="picture/pin.png" style="margin-top: 15px;"/>
                <span style="margin-left: 5px;">'.$row[2].'</span>
            </div>';
        printRate($row[3],"環境");
        printRate($row[4],"服務");
        echo '<p id="storetext" style="margin-top: 10px;">'.$row[1].'</p>
        </div>
        </div>';
    }
    /* free result set */
    $result->close();
}

function printRate($rate,$ratename){
    echo '<div id="star"><span style="font-size: 18px;">'.$ratename.'</span>';
    for ($i=0;$i<$rate;$i++){
        echo '<i class="fas fa-star" id="bluestar"></i>';
    }
    for ($j=0; $j<5-$rate;$j++){
        echo '<i class="fas fa-star" id="greystar"></i>';
    }
    echo '</div>';
}

function calculateRate($conn,$flag,$brandid,$storeid){
    if ($flag==1){
        $query='SELECT AVG(EnvironRate), AVG(ServiceRate) from StoreComment where BrandID='.$brandid;
    }else{
        $query='SELECT AVG(EnvironRate), AVG(ServiceRate) from StoreComment where BrandID='.$brandid.' and StoreID='.$storeid;   
    }
    //$query="SELECT ROUND(AVG(WholeRate),1) from STORE where BrandID=$brandid";
    $result=$conn->query($query);
    if ($result === false){
        echo "<p>" . "DBerror :" . mysqli_error($conn) . "</p>";
    }
    while ($row=$result->fetch_row()){
        $sumrate=$row[0]+$row[1];
    }
    $result->close();
    if ($flag==1){
        $query='SELECT AVG(DrinkRate), AVG(IngredRate),AVG(SweetRate), AVG(PriceRate) from DrinkComment where BrandID='.$brandid;       
    }
    else{
        $query='SELECT AVG(DrinkRate), AVG(IngredRate),AVG(SweetRate), AVG(PriceRate) from DrinkComment where BrandID='.$brandid.' AND StoreID='.$storeid ;
    }
    $result=$conn->query($query);
    if ($result === false){
        echo "<p>" . "DBerror :" . mysqli_error($conn) . "</p>";
    }
    while ($row=$result->fetch_row()){
        $sumrate+=$row[0]+$row[1]+$row[2]+$row[3];
    }
    $result->close();
    return $sumrate;
}

function getDrinkComment($conn,$BrandID){
    $query="SELECT U.Username,U.Img, U.Mime, DrinkName, DrinkText, C.DrinkRate, C.IngredRate, C.SweetRate, C.PriceRate, DrinkImg, DrinkImgMime, Storename,CommentDate from DrinkComment C, STORE S, USER U where C.BrandID=S.BrandID and C.StoreID=S.ID and C.USERID=U.USERID and C.BrandID=".$BrandID;
    $result = $conn->query($query);
    if ($result === false){
        echo "<p>" . "DBerror :" . mysqli_error($conn) . "</p>";
    }
    /* fetch object array */
    while ($row = $result->fetch_row()) {
        echo '<div class="row justify-content-center" id="commdiv">';
        echo '<div class="col-md-2 text-center" id="user">';
        if ($row[1]!=null&&$row[2]!=null){
            echo '<img id="profile" style="margin-top: 60px;" src="data:'.$row[2].';base64,'.base64_encode($row[1]).'"/>';
        }else{
            echo '<img id="profile" style="margin-top: 60px;" src="picture/profile.png"/>';            
        }
        echo '<p><b>'.$row[0].'</b></p>
        <p>'.$row[12].'</p>
        </div><div class="commentcontent col-md-5"><div class="row"><div class="col-md-7">';
        echo '<div class="location">
                <img src="picture/pin.png" style="margin-top: 15px;"/>
                <span style="margin-left: 5px;">'.$row[11].'</span>
            </div>
            <p id="storetext" style="font-size: 25px;"><b>'.$row[3].'</b></p>';
            printRate($row[5],"飲料");
            printRate($row[6],"配料");
            printRate($row[7],"甜度");
            printRate($row[8],"價格");
        echo '<p id="storetext" style="margin-top: 10px;">'.$row[4].'</p>
        </div><div class="col-md-5 align-self-center">';
        if ($row[9]!=null&&$row[10]!=null){
            echo '<img src="data:'.$row[10].';base64,'.base64_encode($row[9]).'"style="height: 150px; width: fit-content; object-fit: contain; background-color: transparent;"/></div></div></div></div>';
        }else{
            echo '<img src="picture/bubble-tea.png" style="height: 130px; width: 130px; object-fit: cover;"/></div></div></div></div>';
        }

    }
}

function getStorelist($conn,$brandid){
    echo '<div class="container">
    <div class="row">';
    $query='SELECT Storename,City, District,ID,Storeimg, Storemime from STORE where BrandID='.$brandid;
    $result=$conn->query($query);
    if ($result === false){
        echo "<p>" . "DBerror :" . mysqli_error($conn) . "</p>";
    }
    while ($row = $result->fetch_row()) {
        $sumrate=calculateRate($conn,2,$brandid,$row[3]);
        $rate=ROUND((float)$sumrate/6,1);
        echo '<div class="col-md-4">
                    <div class="outer">
                        <p class="branchp">'.$row[1].$row[2].'</p>
                        <p class="branchp">'.$rate.'</p><br>
                        <a id="branchtitle" href="branch.php" onclick="setStore('.$row[3].')">'.$row[0].'</a>              
                    </div>
                </div>';

    }
    echo '</div></div>';
}

function getStoreComment($conn,$brandid, $storeid){
    $query = "Select U.Username, StoreText, Storename, C.EnvironRate, C.ServiceRate, CommentDate, U.Img, U.Mime from StoreComment C, STORE S, USER U where C.BrandID = S.BrandID and C.StoreID = S.ID and C.USERID = U.USERID and C.BrandID = ".$brandid.' and C.StoreID='.$storeid;
    // count the numbers of the return rows and decide the pattern
    $result = $conn->query($query);
    if ($result === false){
        echo "<p>" . "DBerror :" . mysqli_error($conn) . "</p>";
    }
    /* fetch object array */
    while ($row = $result->fetch_row()) {
        echo '<div class="row justify-content-center" id="commdiv">';
        echo '<div class="col-md-2 text-center" id="user">';
        if ($row[6]!=null&&$row[7]!=null){
            echo '<img id="profile" style="margin-top: 20px;" src="data:'.$row[7].';base64,'.base64_encode($row[6]).'"/>';
        }else{
            echo '<img id="profile" style="margin-top: 20px;" src="picture/profile.png"/>';            
        }
        echo '<p><b>'.$row[0].'</b></p>
        <p>'.$row[5].'</p>
        </div>';
        echo '<div class="commentcontent col-md-5"><div class="location">
                <img src="picture/pin.png" style="margin-top: 15px;"/>
                <span style="margin-left: 5px;">'.$row[2].'</span>
            </div>';
        printRate($row[3],"環境");
        printRate($row[4],"服務");
        echo '<p id="storetext" style="margin-top: 10px;">'.$row[1].'</p>
        </div>
        </div>';
    }
    /* free result set */
    $result->close();
}

function getStoreDrinkComment($conn, $brandid, $storeid){
    $query="SELECT U.Username,U.Img, U.Mime, DrinkName, DrinkText, C.DrinkRate, C.IngredRate, C.SweetRate, C.PriceRate, DrinkImg, DrinkImgMime, Storename,CommentDate from DrinkComment C, STORE S, USER U where C.BrandID=S.BrandID and C.StoreID=S.ID and C.USERID=U.USERID and C.BrandID=".$brandid.' and C.StoreID='.$storeid;
    $result = $conn->query($query);
    if ($result === false){
        echo "<p>" . "DBerror :" . mysqli_error($conn) . "</p>";
    }
    /* fetch object array */
    while ($row = $result->fetch_row()) {
        echo '<div class="row justify-content-center" id="commdiv">';
        echo '<div class="col-md-2 text-center" id="user">';
        if ($row[1]!=null&&$row[2]!=null){
            echo '<img id="profile" style="margin-top: 60px;" src="data:'.$row[2].';base64,'.base64_encode($row[1]).'"/>';
        }else{
            echo '<img id="profile" style="margin-top: 60px;" src="picture/profile.png"/>';            
        }
        echo '<p><b>'.$row[0].'</b></p>
        <p>'.$row[12].'</p>
        </div><div class="commentcontent col-md-5"><div class="row"><div class="col-md-7">';
        echo '<div class="location">
                <img src="picture/pin.png" style="margin-top: 15px;"/>
                <span style="margin-left: 5px;">'.$row[11].'</span>
            </div>
            <p id="storetext" style="font-size: 25px;"><b>'.$row[3].'</b></p>';
            printRate($row[5],"飲料");
            printRate($row[6],"配料");
            printRate($row[7],"甜度");
            printRate($row[8],"價格");
        echo '<p id="storetext" style="margin-top: 10px;">'.$row[4].'</p>
        </div><div class="col-md-5 align-self-center">';
        if ($row[9]!=null&&$row[10]!=null){
            echo '<img src="data:'.$row[10].';base64,'.base64_encode($row[9]).'"style="height: 150px; width: fit-content; object-fit: contain; background-color: transparent;"/></div></div></div></div>';
        }else{
            echo '<img src="picture/bubble-tea.png" style="height: 130px; width: 130px; object-fit: cover;"/></div></div></div></div>';
        }

    }

}

function getStoreInfo($conn, $brandid, $storeid){
    echo '<div class="row">';
    $query='SELECT Brandname from BRAND where BrandID='.$brandid;
    $result=$conn->query($query);
    if ($result === false){
        echo "<p>" . "DBerror :" . mysqli_error($conn) . "</p>";
    }
    if ($row=$result->fetch_row()){
        $brandname=$row[0];
    }
    $query='SELECT * from STORE where BrandID='.$brandid.' and ID='.$storeid;
    $result=$conn->query($query);
    if ($result === false){
        echo "<p>" . "DBerror :" . mysqli_error($conn) . "</p>";
    }
    if ($result->num_rows){
        $row=$result->fetch_row();
        echo '<div class="left col-md-4 text-center">
        <img src="data:'.$row[8].';base64,'.base64_encode($row[7]).'" alt="" style="height: 200px; width: 200px; border-radius: 50%; margin-top: 50px;">
        <br><p style="font-size: 50px; line-height: 60px;"><strong>'.$brandname.'</strong></p><p style="font-size: 50px; line-height: 60px;"><strong>'.$row[2].'</strong></p>
        <div class="wrap"><img src="picture/733585.svg"/><p>'.$row[3].'</p></div>
        <div class="wrap"><img src="picture/address.png"/><p>'.$row[4].$row[5].$row[6].'</p></div>
        </div>';
    }
    $result->close();
    $rate=array(0,0,0,0,0,0);
    $ratebar=array(0,0,0,0,0,0);
    $ratename=array("飲料","配料","甜度","價格","環境","服務");
    $rateengname=array("drink","ingred","sweet","price","environ","service");
    $rateimg=array("fas fa-tint","fas fa-utensil-spoon","fas fa-cubes","fas fa-dollar-sign","fas fa-hand-sparkles","fas fa-user-friends");

    $query='SELECT AVG(DrinkRate),AVG(IngredRate),AVG(SweetRate),AVG(PriceRate) from DrinkComment where brandID='.$brandid.' and StoreID='.$storeid;
    $result=$conn->query($query);
    if ($result === false){
        echo "<p>" . "DBerror :" . mysqli_error($conn) . "</p>";
    }
    echo '<div class="right col-md-6">';
    if ($row=$result->fetch_row()){
        for ($i=0;$i<4;$i++){
            $rate[$i]=$row[$i];
            $ratebar[$i]=$rate[$i]*20;
            echo '<style>@keyframes '.$rateengname[$i].' {
                0% {width:0%; }
                100% {width:'.$ratebar[$i].'%; }
            }</style>';
            echo '
                <li>
                <h4><i class="'.$rateimg[$i].'">'.$ratename[$i].'</i>'.$rate[$i].' / 5</h4><span class="bar"><span class="'.$rateengname[$i].'" style="width:'.$ratebar[$i].'%;animation: '.$rateengname[$i].' 2s;"></span></span>
            </li>';
        }
    }
    $result->close();
    $query='SELECT AVG(EnvironRate),AVG(ServiceRate) from StoreComment where brandID='.$brandid.' and StoreID='.$storeid;
    $result=$conn->query($query);
    if ($result === false){
        echo "<p>" . "DBerror :" . mysqli_error($conn) . "</p>";
    }
    if ($row=$result->fetch_row()){
        for ($i=4;$i<6;$i++){
            $rate[$i]=$row[$i-4];
            $ratebar[$i]=$rate[$i]*20;
            echo '<style>@keyframes '.$rateengname[$i].' {
                0% {width:0%; }
                100% {width:'.$ratebar[$i].'%; }
            }</style>';
            echo '
                <li>
                <h4><i class="'.$rateimg[$i].'">'.$ratename[$i].'</i>'.$rate[$i].' / 5</h4><span class="bar"><span class="'.$rateengname[$i].'" style="width:'.$ratebar[$i].'%;animation: '.$rateengname[$i].' 2s;"></span></span>
            </li>';
        }
    }
    $result->close();
    $sumrate=calculateRate($conn,2,$brandid, $storeid);
    $wholerate=round((float)$sumrate/6,1);
    $wholeratebar=$wholerate*20;
    echo '<style>@keyframes whole {
        0% {width:0%; }
        100% {width:'.$wholeratebar.'%; }
    }</style>';
    echo '
        <li>
        <h4><i class="fas fa-check-circle">整體</i>'.$wholerate.' / 5</h4><span class="bar"><span class="whole" style="width:'.$wholeratebar.'%;animation: whole 2s;"></span></span>
    </li>';
    echo '</div></div>';

}
?>