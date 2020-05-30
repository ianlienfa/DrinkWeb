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
    $query = "SELECT Brandname, Logoimg, Logomime from BRAND";
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
                        <a href="brand.php">';
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
    $query = "SELECT UserID from USER where Account='$account' AND Passwd='$password'";
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

?>