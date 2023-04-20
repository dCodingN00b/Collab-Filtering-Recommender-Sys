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
<title>Account Settings</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />

 <link rel="stylesheet" href="accountsettings_style.css?version18">
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

.success-box {
	background-color: whitesmoke;
	color: white;
	padding: 20px;
	left: 0;
	width: 100%;
	z-index: -9999;
	vertical-align: middle;
}

.success-box .close-button {
	color: black;
	float: right;
	font-size: 30px;
	font-weight: bold;
	cursor: pointer;
	transform:translate(0%, -30%);
}
</style>
</head>

<body>
<?php
include ('inc_db_fyp.php');

include('navbar.php');

if ($userType == '1' or $userType == '2' or $userType == '0') 
{#header, top navbar

#display success
if (isset($_SESSION['successStatus'])){
	echo"<div class='success-box'>
		<span class='close-button'>&times;</span>
			<p>{$_SESSION['successStatus']}</p>
		</div>";
	
	unset($_SESSION['successStatus']);
}

?>
	
	<h1>Account Settings</h1>
<?php 
#get user info by calling user entity method and display info
$user = new User();
$row = $user-> getUserInfo ($userid);


echo"
<div class = 'reg'>
		<div class = 'fields-left'>
			<div class = 'text_field'>
				<span>Email:</span></br><input type='email' name='email' value = '{$row["emailAddress"]}' style = 'color:grey; background-color:whitesmoke' disabled/>
			</div>";
			echo"
			<div class = 'text_field'>";
				if ($row["userType"] == '1'){
					echo"<span>User Type: </span></br><input type='text' name='userType' value = 'Organization' style = 'color:grey; background-color:whitesmoke' disabled />";
				}
				else if ($row["userType"] == '2'){
					echo"<span>User Type: </span></br><input type='text' name='userType' value = 'Individual' style = 'color:grey; background-color:whitesmoke'  disabled />";
				}else {
					echo"<span>User Type: </span></br><input type='text' name='userType' value = 'Admin' style = 'color:grey; background-color:whitesmoke'  disabled />";
				}
				
			
				echo"
			</div>";
			echo"

			<div class = 'text_field'>
				<span>Name: </span></br><input type='text' name='name' value = '{$row["name"]}' disabled /><a href = 'editname.php'><button name = 'change' >Edit</button></a>
			</div>";
			echo"
			<div class = 'text_field'>
				<span>Password: </span></br><input type='password' name='password' value = '{$row["password"]}' disabled /><a href = 'editpassword.php'><button name = 'change' >Edit</button></a>
			</div>";
			if ($userType == '1'){
				echo"
				<div class = 'text_field'>
					<span>Organization Name: </span></br><input type='text' id = 'orgname' name='orgname' value = '{$row["Organization Name"]}'  disabled /><a href = 'editorgname.php'><button name = 'change' >Edit</button></a>
				</div>";
			}

			
			
			if ($userType == '1'){
			echo"
				<div class = 'text_field'>
					<span>Organization Website: </span></br><input type='text' id = 'orgsite' name='orgsite' value = '{$row["Organization Website"]}'  disabled /><a href = 'editorgsite.php''><button name = 'change' >Edit</button></a>
				</div>";
			}
			echo"
		</div>
</div>";
}
?>
<script>
// to close the success box
document.querySelector('.close-button').addEventListener('click', function() {
			document.querySelector('.success-box').style.display = 'none';
		});
</script>
</body>