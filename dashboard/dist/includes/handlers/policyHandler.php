<?php
    include_once '../../includes/config.php';
    if(isset($_POST['addAbout'])){
        $aboutText = $_POST['aboutText'];
        $setctionName = 'privacy_policy';

        $query = $con->prepare("UPDATE homepage SET value=:aboutText WHERE sectionName=:sectionName");

            $query->bindParam(":aboutText", $aboutText);
            $query->bindParam(":sectionName", $setctionName);

	        if (!$query->execute()) {

            }else{
                header("Location: ../../policypage.php");
            }
    }


?>