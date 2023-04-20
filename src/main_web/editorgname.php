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
<title>Account Settings - Edit Organization Name</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />

 <link rel="stylesheet" href="edit_style.css?version15">
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
	
	<h1>Edit Organization Name</h1>
<?php 
#get user info by calling user entity method and display info
$user = new User();
$row = $user-> getUserInfo ($userid);

if (isset($_POST['submit']) and  ($_POST['submit'] == 'Confirm')){
		$user = new User ();
		$user->editOrgName($_POST['neworgname'], $userid);
		header('location: accountsettings.php');
}
echo"
<form action = '' method = 'post'>
<div class = 'reg'>

		<div class = 'fields'>";
		/*
			<div class = 'text_field'>
					<span>Current Organization Name: </span></br><input type='text' name='oldorgname' value = '{$row["Organization Name"]}' style = 'background-color:silver' disabled />
			</div>*/
		echo"
			<div class = 'text_field'>
					<span>New Organization Name: </span></br><input type='text' name='neworgname' required  />
			</div>";
		echo"</br></br>
		<input type='button' value='Cancel' onclick='history.back()'>
		<input type='submit' name = 'submit' value='Confirm'>
		</div>
		
</div>
</form>";
}
?>
</body>