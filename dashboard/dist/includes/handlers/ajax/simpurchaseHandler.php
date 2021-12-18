<?php
  include_once '../../../includes/config.php';
  $response = array(
  'status' => 0,
  'message' => 'Failed to Upload data Please try again'
  );
  // print_r($_POST);

  if(isset($_POST['propertyId'])){
      $address = $_POST['address'];
      $rooms = $_POST['rooms'];
      $price = $_POST['price'];
      $date = $_POST['date_prop'];
      $building_year = $_POST['build_year'];
      $propId = $_POST['propertyId'];


      $query = $con->prepare("INSERT INTO similarpurchases(address, rooms, price, date, building_year, propertyId)
                                VALUES(:address, :rooms, :price, :date, :building_year, :propId)");

          $query->bindParam(":address", $address);
          $query->bindParam(":rooms", $rooms);
          $query->bindParam(":price", $price);
          $query->bindParam(":date", $date);
          $query->bindParam(":building_year", $building_year);
          $query->bindParam(":propId", $propId);

        if ($query->execute()) {
          $response['status'] = 1;
          $response['message'] = 'Property similar purchases has been successfully added';

        } else {
          $response['status'] = 0;
          $response['message'] = 'Something went wrong, please try again later';
        }
  }

  // Return response
	echo json_encode($response);
?>
