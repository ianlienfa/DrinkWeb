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
    $query="SELECT ROUND(AVG(Rate),1) from STORE where BrandID=$brandid";
    $result=$conn->query($query);
    if ($result === false){
        echo "<p>" . "DBerror :" . mysqli_error($conn) . "</p>";
    }
    if ($result->num_rows){
        $row=$result->fetch_row();
        $rate=(int)$row[0]*10;
        echo '<style>@keyframes whole {
            0% {width:0%; }
            100% {width:'.$rate.'%; }
        }</style>';
        echo '<div class="right col-md-6 offset-md-3">
        <li>
            <h4><i class="fas fa-check-circle"> 評價</i>'.$row[0].'</h4><span class="bar"><span class="whole" style="width:'.$rate.'%;animation: whole 2s;"></span></span>
        </li>
        </div>';
    }
    $result->close();
}

function getBrandComment($conn, $BrandID)
{
    $query = "select Username, StoreText, Storename from COMMENT C, STORE S, USER U where C.BrandID = S.BrandID and C.StoreID = S.ID and C.USERID = U.USERID and C.BrandID = ".$BrandID;
    // count the numbers of the return rows and decide the pattern
    $result = $conn->query($query);
    if ($result === false){
        echo "<p>" . "DBerror :" . mysqli_error($conn) . "</p>";
    }
    
    echo "<br><br>";

    /* fetch object array */
    while ($row = $result->fetch_row()) {
        echo '<div class = "row offset-3">
            <p>'.$row[0].' :   '.$row[1].'   -------------------於'.$row[2].'</p>
            </div>
            ';
    }
    /* free result set */
    $result->close();
}


?>