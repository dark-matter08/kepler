<?php
  ob_start();
  session_start();
  date_default_timezone_set("Africa/Douala");

  try {
    $con = new PDO("mysql:dbname=kepler;host=localhost", "root", "");
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
  } catch (PDOException $e) {
    echo "Connection Failed: " .$e->getMessage();
  }

  $_SESSION['watchlist'] = isset($_SESSION['watchlist']) ? $_SESSION['watchlist'] : array();



 ?>
