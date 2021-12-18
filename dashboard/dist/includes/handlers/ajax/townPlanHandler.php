<?php
$response = array(
    'status' => 0,
    'message' => 'Form submission failed, please try again.'
);

// print_r($_POST);
	if (isset($_POST['propId'])) {
		# code...
		$propId = $_POST['propId'];
		$uploadOk = 1;
	    $imageName = $_FILES['file']['name'];
	    $errorMessage = "";

	    if($imageName != ""){
		  $targetDir = "../../../uploads/townPlan/";
		  $imageName = basename($imageName);
	      $imageFileType = pathinfo($imageName, PATHINFO_EXTENSION);
		  $fileName = $propId . "_town_plan_" . $imageName;
		  $imageName = $targetDir . $fileName;
		  $imageName = str_replace(" ", "_", $imageName);

	    //   $imageName = $targetDir . basename($imageName);
	    //   $imageFileType = pathinfo($imageName, PATHINFO_EXTENSION);

	      if($_FILES['file']['size'] > 2097152){
	        $response['message'] = "Sorry  your file is too large, Max ile Size is 2MB";
	        $uploadOk = 0;
	      }

	      if((strtolower($imageFileType != "jpeg")) && (strtolower($imageFileType != "png")) && (strtolower($imageFileType != "jpg")) && (strtolower($imageFileType != "pdf"))  && (strtolower($imageFileType != "doc")) && (strtolower($imageFileType != "docx")) && (strtolower($imageFileType != "txt"))){
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

	        $fileSize = $_FILES['file']['size'] /1024 /1024;
            $fileInfo = $_FILES['file']['name'];
			$fileInfo = $propId . basename($fileInfo);
			$targetDir = "uploads/townPlan/";
			$fileName = str_replace(" ", "_", $fileName);
	        $directory = $targetDir . $fileName;
	        $selected = 0;


	        $query = $con->prepare("INSERT INTO propertytownplan(propId, fileName, filePath, size)
	                                VALUES(:propId, :fileName, :filePath, :size)");

	        $query->bindParam(":propId", $propId);
	        $query->bindParam(":fileName", $fileInfo);
			$query->bindParam(":filePath", $directory);
			$query->bindParam(":size", $fileSize);

	        if (!$query->execute()) {
	        	$response['message'] =  "Something went wrong while inserting into the database";
	        } else {
	        	
	        	$response['status'] = 1;
				$response['message'] = "Successfully uploaded town plan document";

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
