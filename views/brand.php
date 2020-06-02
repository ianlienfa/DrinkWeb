<?php
require_once "/opt/lampp/htdocs/DrinkWeb/include/include.php"; 
if (isset($_COOKIE['BrandID'])){
    echo "$_COOKIE[BrandID]";
    setcookie('BrandID',"");
}else{
    echo "NONE";
}

?>