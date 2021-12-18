<?php
	$response = array(
		'status' => 0,
		'message' => 'Form submission failed, please try again.',
		'id' => ''
	);

	print_r($_POST);
		# code...

		$uploadOk = 1;
	    $imageName = $_FILES['file']['name'];
	    $errorMessage = "";

	    if($imageName != ""){
	      $targetDir = "../../../assets/img/";
	      $imageName = $targetDir . basename($imageName);
	      $imageFileType = pathinfo($imageName, PATHINFO_EXTENSION);

	      if($_FILES['file']['size'] > 20918272){
	        $response['message'] = "Sorry  your file is too large";
	        $uploadOk = 0;
	      }

	      if((strtolower($imageFileType != "png"))){
	       $response['message'] = "logo file type should be png";
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
	        $directory = "assets/img/" . $fileName;
            $selected = 0;
            $setctionName = 'logoPath';


	        $query = $con->prepare("UPDATE randomvalues SET value=:imgPath WHERE name=:logoPath");
			$query->bindParam(":imgPath", $directory);
            $query->bindParam(":logoPath", $setctionName);

	        if (!$query->execute()) {
	        	$response['message'] =  "Something went wrong while inserting into the database";
	        } else {

	        	$queryPhotos = $con->prepare("SELECT value FROM randomvalues WHERE name='logoPath'");
          	    $queryPhotos->execute();

          	while ($row = $queryPhotos->fetch(PDO::FETCH_ASSOC)){
          		$imgPath = $row['value'];
          	}

            $response['status'] = 1;
          	$response['message'] = $directory;

	        }

	    } else {
		}
		
		
	// Return response
	echo json_encode($response);
	// echo $response;


?>
