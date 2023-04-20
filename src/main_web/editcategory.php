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
<title>User Profile - Edit Category</title>
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
		
		<h1>Edit Category</h1>
	<?php 
	#get user info by calling user entity method and display info
	$user = new User();
	$row = $user-> getUserInfo ($userid);

	$showForm = true;

	if (isset($_POST['submit']) and  ($_POST['submit'] == 'Confirm')){
			
			$showForm = false;
			/*
			if ($_POST['interestOne'] == $_POST['interestTwo']) {
					$showForm = true;
					echo"Interest 1 and 2 cannot be the same.";
			}
			else {
				$showForm = false;
			}*/
	}

	if ($showForm){
		echo"
		<form action = '' method = 'post'>
		<div class = 'reg'>

				<div class = 'fields'>
					<div class = 'text_field'>";
					if ($userType == '2'){		
					echo"
						<span>Interest 1: </span>";
					}
					else if ($userType == '1'){
						echo"
						<span>Product Type 1: </span>";
					}
						echo";
						<select name='interestOne' id='interests' class = 'interests'>
								<option value='Computers'" .(($row['categoryOne'] == 'Computers')? 'selected="selected"' : '') . ">Computers</option>
								<option value='Electronics'" .(($row['categoryOne'] == 'Electronics')? 'selected="selected"' : '') . ">Electronics</option>
								<option value='Pets'" . (($row['categoryOne'] == 'Pets')? 'selected="selected"' : '') . ">Pets</option>
								<option value='Toys'" . (($row['categoryOne'] == 'Toys')? 'selected="selected"' : '') . ">Toys</option>
								<option value='Video Games'" . (($row['categoryOne'] == 'Video Games')? 'selected="selected"' : '') . ">Video Games</option>	
						</select></div>";
				
				/*
					echo"<div class = 'text_field'>";
					if ($userType == '2'){		
					echo"
						<span>Interest 2: </span>";
					}
					else if ($userType == '1'){
						echo"
						<span>Product Type 2: </span>";
					}
						echo"
						<select name='interestTwo' id='interests' class = 'interests'>
								<option value='Computers'" .(($row['categoryTwo'] == 'Computers')? 'selected="selected"' : '') . ">Computers</option>
								<option value='Electronics'" .(($row['categoryTwo'] == 'Electronics')? 'selected="selected"' : '') . ">Electronics</option>
								<option value='Pets'" . (($row['categoryTwo'] == 'Pets')? 'selected="selected"' : '') . ">Pets</option>
								<option value='Toys'" . (($row['categoryTwo'] == 'Toys')? 'selected="selected"' : '') . ">Toys</option>
								<option value='Video Games'" . (($row['categoryTwo'] == 'Video Games')? 'selected="selected"' : '') . ">Video Games</option>	
									
						</select></div>";*/
				echo"</br></br>
				<input type='button' value='Cancel' onclick='history.back()'>
				<input type='submit' name = 'submit' value='Confirm'>
				</div>
				
		</div>
		</form>";
	}
	else {
		$user->editInterests($_POST['interestOne'], $userid);
		header('location: profile.php');
	}
}
?>
</body>