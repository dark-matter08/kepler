<?php
    include_once '../../../includes/config.php';
	$response = array(
    'status' => 0,
    'message' => 'Failed to Upload data Please try again'
	);
	// print_r($_POST);
	if (isset($_POST['propId'])) {
    $propId = $_POST['propId'];
    $city = $_POST['city'];
    $street = $_POST['street'];
    $neighb = $_POST['neighb'];
    $status = $_POST['status'];
    $price = $_POST['price'];
    $rent_income = $_POST['rent_income'];
    $oldPrice = $_POST['oldPrice'];
    $rooms = $_POST['rooms'];
    $area = $_POST['area'];
    $floor = $_POST['floor'];
    $floor_in_build = $_POST['floor_in_build'];
    $balcony = $_POST['balcony'];
    $parking = $_POST['parking'];
    $elevator = $_POST['elevator'];
    $storeroom = $_POST['storeroom'];
    $air_condition = $_POST['air_condition'];
    $security_room = $_POST['security_room'];
    $lawyer = $_POST['lawyer'];
    $renovation = $_POST['renovation'];
    $brokerage = $_POST['brokerage'];
    $tax = $_POST['tax'];
    $appraiser = $_POST['appraiser'];
    $built_year = $_POST['built_year'];
    $property_description = $_POST['property_description'];
    $renovation_status = $_POST['renovation_status'];
    $rent_status = $_POST['rent_status'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $agentEmail = $_POST['agentEmail'];
    $agentNumber = $_POST['agentNumber'];
    $annReturns = (($rent_income * 12)/$price)*100;

    $proceed_query = 1;

    if($floor_in_build > $floor){
      $proceed_query = 0;
    }


		$query = $con->prepare("UPDATE property SET propDescription=:propDescription, propPrice=:propPrice, propLocation=:propLocation, annualReturns=:annualReturns, status=:status, rent_income = :rentIncome, old_price = :oldPrice, propCondition =:renovation_status, rent_status =:rent_status, year_built = :year_built WHERE id=:propId");

    $query->bindParam(":propDescription", $property_description);
    $query->bindParam(":propPrice", $price);
    $query->bindParam(":propLocation", $city);
    $query->bindParam(":annualReturns", $annReturns);
    $query->bindParam(":status", $status);
    $query->bindParam(":rentIncome", $rent_income);
    $query->bindParam(":oldPrice", $oldPrice);
    $query->bindParam(":renovation_status", $renovation_status);
  	$query->bindParam(":rent_status", $rent_status);
		$query->bindParam(":year_built", $year_built);
		$query->bindParam(":propId", $propId);

		$query2 = $con->prepare("UPDATE descfeatures SET area= :area, bedrooms= :bedrooms, number_of_building_floors= :floors, floor_in_building= :floor_in_build WHERE propertyId=:propId");

		$query2->bindParam(":area", $area);
  	$query2->bindParam(":bedrooms", $rooms);
  	$query2->bindParam(":floors", $floor);
  	$query2->bindParam(":floor_in_build", $floor_in_build);
		$query2->bindParam(":propId", $propId);

		$query3 = $con->prepare("UPDATE propertycity SET cityName=:cityName, street=:street, neighbourhood=:neighbourhood WHERE propertyId=:propId");

		$query3->bindParam(":cityName", $city);
  	$query3->bindParam(":street", $street);
  	$query3->bindParam(":neighbourhood", $neighb);
		$query3->bindParam(":propId", $propId);

		$query4 = $con->prepare("UPDATE propertyextraexpenses SET lawyer =:lawyer, renovation =:renovation, brokerage_fee =:brokerage, tax =:tax, appraiser =:appraiser WHERE propertyId =:propId");

		$query4->bindParam(":lawyer", $lawyer);
  	$query4->bindParam(":renovation", $renovation);
  	$query4->bindParam(":brokerage", $brokerage);
  	$query4->bindParam(":tax", $tax);
  	$query4->bindParam(":appraiser", $appraiser);
		$query4->bindParam(":propId", $propId);

    $query5 = $con->prepare("UPDATE propertyamenities SET balcony =:balcony, parking =:parking, elevator =:elevator, storeroom =:storeroom, ac =:ac, secroom = :secroom WHERE propertyId =:propId");

		$query5->bindParam(":balcony", $balcony);
  	$query5->bindParam(":parking", $parking);
  	$query5->bindParam(":elevator", $elevator);
  	$query5->bindParam(":storeroom", $storeroom);
    $query5->bindParam(":ac", $air_condition);
  	$query5->bindParam(":secroom", $security_room);
		$query5->bindParam(":propId", $propId);

    $query6 = $con->prepare("UPDATE propertyseller SET first_name =:first_name, last_name =:last_name, email =:email, telephone =:telephone WHERE propertyId =:propId");

		$query6->bindParam(":first_name", $firstname);
  	$query6->bindParam(":last_name", $lastname);
    $query6->bindParam(":email", $agentEmail);
  	$query6->bindParam(":telephone", $agentNumber);
    $query6->bindParam(":propId", $propId);

    if($proceed_query){
      if ($query->execute()
      && $query2->execute()
      && $query3->execute()
      && $query4->execute()
      && $query5->execute()
      && $query6->execute()  ) {
        $response['status'] = 1;
        $response['message'] = 'Property has been successfully updated';

      } else {
        $response['status'] = 0;
        $response['message'] = 'Something went wrong, please try again later';
      }
    }else{
      $response['status'] = 0;
      $response['message'] = 'The floor of the appartment cannot the greater than the number of floors in the appartment';
    }
	}

	// Return response
	echo json_encode($response);



?>
