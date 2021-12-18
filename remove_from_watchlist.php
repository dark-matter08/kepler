<?php
// error_reporting(0);
session_start();
$code = $_GET["code"];
if (!empty($_SESSION["watchlist"])) {
    foreach($_SESSION['watchlist'] as $arrayId=>$value){
    //   print_r($_SESSION['watchlist'][$arrayId]['code']);
    //   print_r($arrayId);
      if($arrayId == $code){
        unset($_SESSION['watchlist'][$code]);
      }
    }
}
header("Location: watchlist.php");
// header("location: shop.php");
?>
