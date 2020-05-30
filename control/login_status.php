<?php
  $time = $_SERVER['REQUEST_TIME'];
  $timeout_duration = 1800;  // 設定30分鐘為timeout
  if (!isset($_COOKIE['login']) || ($time - $_COOKIE['LAST_ACTIVITY']) > $timeout_duration) {
    header("Location: /DrinkWeb/views/login.php");
  }
?>