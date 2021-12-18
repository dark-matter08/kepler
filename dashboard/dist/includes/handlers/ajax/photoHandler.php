<?php
$response = array(
    'status' => 0,
    'message' => 'Form submission failed, please try again.',
    'id' => ''
);

// print_r($_POST);
	if (isset($_POST['propId'])) {
		# code...
		$propId = $_POST['propId'];
		$uploadOk = 1;
	    $imageName = $_FILES['file']['name'];
	    $errorMessage = "";

	    if($imageName != ""){
	      $targetDir = "../../../uploads/propertyPhotos/";
	      $imageName = $targetDir . basename($imageName);
	      $imageFileType = pathinfo($imageName, PATHINFO_EXTENSION);

	      if($_FILES['file']['size'] > 15728640){
	        $response['message'] = "Sorry  your file is too large, Max ile Size is 2MB";
	        $uploadOk = 0;
	      }

	      if((strtolower($imageFileType != "jpeg")) && (strtolower($imageFileType != "png")) && (strtolower($imageFileType != "jpg"))){
	       $response['message'] = "Sorry choose a file with the correct file type";
	        $uploadOk = 0;
	      }
	      if($uploadOk){
	        if(move_uploaded_file($_FILES['file']['tmp_name'], $imageName)){

	          //image uploaded okay
	        } else {
	          //image did not upload
	          $response['message'] = 'Unable to upload this file, it might be corrupted. Select another file';
	          $uploadOk = 0;
	        }

	      }else {

	      }
	    }
	    if($uploadOk){

	        // Include the database config file
	        include_once '../../../includes/config.php';

	        // insert funnction here
	        $fileName = $_FILES['file']['name'];
	        $fileName = basename($fileName);
	        $directory = "uploads/propertyPhotos/" . $fileName;
	        $selected = 0;


	        $query = $con->prepare("INSERT INTO propertyphoto(propId, imgPath, selected)
	                                VALUES(:propId, :imgPath, :selected)");

	        $query->bindParam(":imgPath", $directory);
	        $query->bindParam(":propId", $propId);
	        $query->bindParam(":selected", $selected);

	        if (!$query->execute()) {
	        	$response['message'] =  "Something went wrong while inserting into the database";
	        } else {
	        	$photoId =  $con->lastInsertId();

	        	$queryPhotos = $con->prepare("SELECT imgPath FROM propertyphoto WHERE id = $photoId");
          	$queryPhotos->execute();

          	while ($row = $queryPhotos->fetch(PDO::FETCH_ASSOC)){
          		$imgPath = $row['imgPath'];
          	}

	        	$response['status'] = 1;
          	$response['message'] = $imgPath;
            $response['id'] = $photoId;

	        }

	    } else {
	    }
	} else{
		$response['message'] = "property Id is not set";
	}

	// Return response
	echo json_encode($response);
	// echo $response;


?>
