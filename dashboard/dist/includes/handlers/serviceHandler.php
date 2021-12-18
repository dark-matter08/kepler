<?php
    include_once '../../includes/config.php';
    if(isset($_POST['addService'])){
        $servTitle = $_POST['serviceName'];
        $servDesc = $_POST['serviceDescription'];
        $iconfont = $_POST['iconfont'];


        $query = $con->prepare("INSERT INTO services(title, description, iconfont)
	                                VALUES(:title, :description, :iconfont)");

            $query->bindParam(":title", $servTitle);
            $query->bindParam(":description", $servDesc);
            $query->bindParam(":iconfont", $iconfont);

	        if (!$query->execute()) {

            }else{
                header("Location: ../../homepage.php");
            }
    }


?>