<?php
	include("user.php");
	session_start();
	if(isset($_POST['email'])){
		$user = new User();
		if($user->checkLogin($_POST['email'], $_POST['password'])){
			$userinfo = $user->getInfo($_POST['email']);
			$_SESSION['loggedin'] = TRUE;
			$_SESSION['email'] = $userinfo['emailAddress'];
			$_SESSION['id'] = $userinfo['userID'];
			$_SESSION['userType'] = $userinfo['userType'];
			$_SESSION['name'] = $userinfo['name'];
			$_SESSION['dateTimeOfCreation'] = $userinfo['dateTimeOfCreation'];
			$_SESSION['pricePlan'] = $userinfo['pricePlan'];
			header('Location: home.php');
		}
		else {
			// Incorrect password
			$error = 'Incorrect Email and/or Password';
			$_SESSION["error"] = $error;
			header('Location: login.php');
		}
		
	}

?>