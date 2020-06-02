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
}
?>