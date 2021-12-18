<?php
    include_once '../../includes/config.php';
    if(isset($_POST['submitAgentSettings'])){

        $username = $_POST['username'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['agentEmail'];
        $about = $_POST['agentAbout'];
        $tel = $_POST['agentNumber'];

        $query = $con->prepare("UPDATE users SET firstName=:firstName, lastName=:lastName, email=:email, user_tel=:tel, user_about=:about WHERE username=:username");
        $query->bindParam(":firstName", $firstname);
        $query->bindParam(":lastName", $lastname);
        $query->bindParam(":email", $email);
        $query->bindParam(":tel", $tel);
        $query->bindParam(":about", $about);
        $query->bindParam(":username", $username);
        
        if (!$query->execute()) {
            echo 'Something went wrong';
        }else{
            header("Location: ../../user_settings.php");
        }
    }


?>
