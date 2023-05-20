<?php
	// We need to use sessions, so you should always start sessions using the below code.
	session_start();
	// If the user is not logged in redirect to the login page...
	if (!isset($_SESSION['loggedin'])) {
		header('Location:login.php');
		exit;
	}
	
	$userType = $_SESSION['userType'];
	if (isset($_SESSION['id'])){
		$userid = $_SESSION['id'];
	}
	else{
		$userid = '';
	}
	
	
?>
<!DOCTYPE html>
<html>	
<head>
<title>Account Settings - Edit Password</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />

 <link rel="stylesheet" href="edit_style.css?version16">
 <style>
/* width */
::-webkit-scrollbar {
  width: 10px;
}

/* Track */
::-webkit-scrollbar-track {
  background: #f1f1f1; 
}
 
/* Handle */
::-webkit-scrollbar-thumb {
  background: #888; 
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
  background: #555; 
}
</style>
</head>

<body>
<?php
include ('inc_db_fyp.php');

include('navbar.php');

if ($userType == '1' or $userType == '2' or $userType == '0') 
{#header, top navbar
	
?>
	
	<h1>Edit Password</h1>
<?php 
	$DisplayForm = True; 

	if (isset($_POST['submit']) and  ($_POST['submit'] == 'Confirm')) {
		$DisplayForm = True; 

		#1st check, check if new password and new confirm password is same
		if ($_POST['newpassword'] != $_POST['confirmnewpassword']){
			echo "<p> Password does not match </p>";
			$DisplayForm = True; 
		}
		else {
			$DisplayForm = False; 
		}
		
		#2nd check, check if old password is correct, if correct, return false
		$user = new User();
		$checkPassword = $user->checkPassword( hash('md5',$_POST['oldpassword']), $userid);
		
		if ($checkPassword) {
			$DisplayForm = False;	
		}
		else {
			$DisplayForm = True;
		}
		
		if ($DisplayForm == False){
			$user -> editPassword( hash('md5',$_POST['newpassword']), $userid);
			header("location:accountsettings.php");
		}
	}
	if ($DisplayForm){
			
		echo"
		<form action = '' method = 'post'>
		<div class = 'reg'>

				<div class = 'fields'>
					<div class = 'text_field'>
							<span>Current Password: </span></br><input type='password' name='oldpassword' required />
					</div>
					<div class = 'text_field'>
							<span>New Password: </span></br><input type='password' name='newpassword' required />
					</div>
					<div class = 'text_field'>
							<span>Confirm New Password: </span></br><input type='password' name='confirmnewpassword' required />
					</div>";
				echo"</br></br>
				<input type='button' value='Cancel' onclick='history.back()'>
				<input type='submit' name = 'submit' value='Confirm'>
				</div>
				
		</div>
		</form>";
	}
}
?>
</body>