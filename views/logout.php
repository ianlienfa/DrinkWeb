<?php 
setcookie('login','',time()+3600);
header("Location: /DrinkWeb/control/login_status.php");
?>