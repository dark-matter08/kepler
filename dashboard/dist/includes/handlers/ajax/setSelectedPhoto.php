<?php
require_once("../../../includes/config.php");

if(isset($_POST['photoId'])){

  if(isset($_POST['propId'])){
    $photoId = $_POST['photoId'];
    $propId = $_POST['propId'];

    $query = $con->prepare("UPDATE propertyphoto SET selected = 0 WHERE propId=:propId");
    $query->bindParam(":propId", $propId);

    $query->execute();

    $query = $con->prepare("UPDATE propertyphoto SET selected = 1 WHERE id = :photoId");
    $query->bindParam(":photoId", $photoId);

    $query->execute();
  }else{
   echo "prop id was not passed setSelectedPhoto.php file";
  }
} else{
  echo "photo id was not passed setSelectedPhoto.php file";
}
?>
