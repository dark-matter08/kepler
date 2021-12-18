<?php

//functions
function santizeFormPassword($inputText){
	$inputText = strip_tags($inputText);
	return $inputText;
}
function santizeFormUsername($inputText){
	$inputText = strip_tags($inputText);
	$inputText = str_replace(" ", "", $inputText);
	return $inputText;
}
function santizeFormString($inputText){
	$inputText = strip_tags($inputText);
	$inputText = str_replace(" ", "", $inputText);
	$inputText = uCfirst(strtolower($inputText));
	return $inputText;
}


//register
if(isset($_POST['registerButton'])){

	$username = santizeFormUsername($_POST['username']);
	$firstName = santizeFormString($_POST['firstName']);
	$lastName = santizeFormString($_POST['lastName']);
	$email = santizeFormUsername($_POST['email']);
	$email2 = santizeFormUsername($_POST['email2']);
	$password = santizeFormPassword($_POST['password']);
	$password2 = santizeFormPassword($_POST['password2']);

	$wasSuccessful = $account->register($username, $firstName, $lastName, $email, $email2, $password, $password2);

	if($wasSuccessful == true){
		$_SESSION['userLoggedIn'] = $username;
		header("Location: index.php");
	}
}


//login
if(isset($_POST['loginButton'])){
	//echo "login button was pressed";
	$username = santizeFormUsername($_POST['loginUsername']);
	$password = santizeFormPassword($_POST['loginPassword']);

	$result = $account->login($username, $password);
	if($result == true){
		$_SESSION['userLoggedIn'] = $username;
		header("Location: index.php");
	}
}
?>
