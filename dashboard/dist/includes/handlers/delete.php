<?php
include("../../includes/config.php");

if(isset($_GET['for']) && (isset($_GET['propId']) || isset($_GET['servId']) || isset($_GET['blogId']) || isset($_GET['agentsId']) || isset($_GET['photoId']) || isset($_GET['simpurchId']))){
  $propId = (isset($_GET['propId'])) ? $_GET['propId'] : "";
  $servId = (isset($_GET['servId'])) ? $_GET['servId'] : "";
  $blogId = (isset($_GET['blogId'])) ? $_GET['blogId'] : "";
  $agentsId = (isset($_GET['agentsId'])) ? $_GET['agentsId'] : "";
  $photoId = (isset($_GET['photoId'])) ? $_GET['photoId'] : "";
  $townplanId = (isset($_GET['townplanId'])) ? $_GET['townplanId'] : "";
  $simpurchId = (isset($_GET['simpurchId'])) ? $_GET['simpurchId'] : "";


  $for = $_GET['for'];

  if ($for == ""){
    header("Location: ../../index.php");
  }
  if ($for == 'property') {
    deleteProperty($propId, $con);
  }
  if ($for == 'service') {
    // code...
    echo $servId;
    echo "dddd";
    deleteService($con, $servId);
  }
  if ($for == 'townplan') {
    // code...
    echo "<br>";
    echo $propId;
    echo "<br>";
    echo $townplanId;
    echo "<br>";
    deleteTownPlan($propId, $con, $townplanId);
  }
  if ($for == 'similarpurchase') {
    deleteSimPurchase($propId, $con, $simpurchId);
  }
  if ($for == 'photo') {
    deletePhoto($propId, $con, $photoId);
  }

}


function deleteProperty($propId, $con){
  $photoId = 0;
  $townplanId = 0;

  $query = "DELETE FROM property WHERE id=:propId";
  $deleteProp = $con->prepare($query);
  $deleteProp->bindParam(":propId", $propId);

  $query2 = "DELETE FROM propertycity WHERE propertyId=:propId";
  $deleteCity = $con->prepare($query2);
  $deleteCity->bindParam(":propId", $propId);

  if ($deleteProp->execute() && $deleteCity->execute()) {
    // code...
    deletePhoto($propId, $con, $photoId);
    deleteTownPlan($propId, $con, $townplanId);
    deleteSimPurchase($propId, $con, $simpurchId);
    header("Location: ../../property.php");

  }
}
function deleteService($con, $servId){

    $query = "DELETE FROM services WHERE id=:servId";
    $deleteServ = $con->prepare($query);
    $deleteServ->bindParam(":servId", $servId);
    $deleteServ->execute();

    // unlink
    removeFromServer($filePath);
    // reload
    header("Location: ../../homepage.php");

}
function deletePhoto($propId, $con, $photoId){
  if ($photoId) {
    // query file pathinfo
    $filePathQuery = "SELECT imgPath FROM propertyphoto WHERE id=:photoId";
    $file = $con->prepare($filePathQuery);
    $file->bindParam(":photoId", $photoId);
    $file->execute();

    $row = $file->fetch(PDO::FETCH_ASSOC);
    $filePath = $row['imgPath'];

    $query = "DELETE FROM propertyphoto WHERE id=:photoId";
    $deletePhoto = $con->prepare($query);
    $deletePhoto->bindParam(":photoId", $photoId);
    $deletePhoto->execute();
    // unlink
    // removeFromServer($filePath);

    // reload
    header("Location: ../../propertyEdit.php?id=$propId&type=edit&deleted=1");
  } else{
    // unlink
    $filePathQuery = "SELECT imgPath FROM propertyphoto WHERE propId=:propId";
    $file = $con->prepare($filePathQuery);
    $file->bindParam(":propId", $propId);
    $file->execute();

    while($row = $file->fetch(PDO::FETCH_ASSOC)){
      $filePath = $row['imgPath'];
      // removeFromServer($filePath);
    }

    $query = "DELETE FROM propertyphoto WHERE propId=:propId";
    $deleteDraw = $con->prepare($query);
    $deleteDraw->bindParam(":propId", $propId);
    $deleteDraw->execute();
  }
}
function deleteTownPlan($propId, $con, $townplanId){
  if ($townplanId) {
    // query file pathinfo
    $filePathQuery = "SELECT filePath FROM propertytownplan WHERE id=:townplanId";
    $file = $con->prepare($filePathQuery);
    $file->bindParam(":townplanId", $townplanId);
    $file->execute();

    $row = $file->fetch(PDO::FETCH_ASSOC);
    $filePath = $row['filePath'];

    $query = "DELETE FROM propertytownplan WHERE id=:townplanId";
    $deletePhoto = $con->prepare($query);
    $deletePhoto->bindParam(":townplanId", $townplanId);
    $deletePhoto->execute();
    // unlink
    removeFromServer($filePath);

    // reload
    header("Location: ../../propertyEdit.php?id=$propId&type=edit&deleted=1");
  } else{
    // unlink
    $filePathQuery = "SELECT filePath FROM propertytownplan WHERE propId=:propId";
    $file = $con->prepare($filePathQuery);
    $file->bindParam(":propId", $propId);
    $file->execute();

    while($row = $file->fetch(PDO::FETCH_ASSOC)){
      $filePath = $row['filePath'];
      removeFromServer($filePath);
    }

    $query = "DELETE FROM propertytownplan WHERE propId=:propId";
    $deleteDraw = $con->prepare($query);
    $deleteDraw->bindParam(":propId", $propId);
    $deleteDraw->execute();
  }
}
function deleteSimPurchase($propId, $con, $simpurchId){
  if ($simpurchId) {

    $query = "DELETE FROM similarpurchases WHERE id=:townplanId";
    $deletePhoto = $con->prepare($query);
    $deletePhoto->bindParam(":townplanId", $simpurchId);
    $deletePhoto->execute();

    // reload
    header("Location: ../../propertyEdit.php?id=$propId&type=edit&deleted=1");
  } else{

    $query = "DELETE FROM similarpurchases WHERE propId=:propId";
    $deleteDraw = $con->prepare($query);
    $deleteDraw->bindParam(":propId", $propId);
    $deleteDraw->execute();
  }
}
function removeFromServer($filePath){
  echo "<br>";
  echo $filePath;
  unlink("../".$filePath);
}

?>
