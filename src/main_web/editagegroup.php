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
	
	$userType = $_SESSION['userType'];
?>
<!DOCTYPE html>
<html>	
<head>
<title>User Profile - Edit Age Group</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />

 <link rel="stylesheet" href="edit_style.css?version18">
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
		
		<h1>Edit Age Group</h1>
	<?php 
	#get user info by calling user entity method and display info
	$user = new User();
	$row = $user-> getUserInfo ($userid);

	$showForm = true;

	if (isset($_POST['submit']) and  ($_POST['submit'] == 'Confirm')){
			
		$showForm = false;
		
	}

	if ($showForm){
		echo"
		<form action = '' method = 'post'>
		<div class = 'reg'>

				<div class = 'fields'>
					<div class = 'text_field'>";
							
					if ($userType == '2'){		
					echo"
						<span>Age Group: </span>";
					}
					else if ($userType == '1'){
						echo"
						<span>Target Age Group: </span>";
					}
					echo"
						<select name='ageRange' id='agegroup' class = 'agegroup'>
								<option value='18-24'" .(($row['ageRange'] == '18-24')? 'selected="selected"' : '') . ">18-24</option>
								<option value='25-34'" .(($row['ageRange'] == '25-34')? 'selected="selected"' : '') . ">25-34</option>
								<option value='35-44'" . (($row['ageRange'] == '35-44')? 'selected="selected"' : '') . ">35-44</option>
								<option value='45+'" . (($row['ageRange'] == '45+')? 'selected="selected"' : '') . ">45+</option>
									
						</select></div>";
				
					
				echo"</br></br>
				<input type='button' value='Cancel' onclick='history.back()'>
				<input type='submit' name = 'submit' value='Confirm'>
				</div>
				
		</div>
		</form>";
	}
	else {
		$user->editAgeGroup($_POST['ageRange'], $userid);
		header('location: profile.php');
	}
}
?>
</body>