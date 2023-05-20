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
<title>User Profile</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />

 <link rel="stylesheet" href="profile_style.css?version19">
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
	
<h1>User Profile</h1>
<?php 
#get user info by calling user entity method and display info
$user = new User();
$row = $user-> getUserInfo ($userid);

$categoryCount = 1;


if ($userinfo['categoryTwo'] != ""){
	$categoryCount += 1;
}
if ($userinfo['categoryThree'] != ""){
	$categoryCount += 1;
}
if ($userinfo['categoryFour'] != ""){
	$categoryCount += 1;
}
if ($userinfo['categoryFive'] != ""){
	$categoryCount += 1;
}

$categories = '';
if ($categoryCount == 1){
	$categories = $row["categoryOne"];
}
else if ($categoryCount == 2) {
	$categories = $row["categoryOne"] . ", " . $row["categoryTwo"];
}
else if ($categoryCount == 3) {
	$categories = $row["categoryOne"] . ", " . $row["categoryTwo"] . ", " . $row["categoryThree"];
}
else if ($categoryCount == 4) {
	$categories = $row["categoryOne"] . ", " . $row["categoryTwo"] . ", " . $row["categoryThree"] . ", " . $row["categoryFour"];
}
else if ($categoryCount == 5) {
	$categories = $row["categoryOne"] . ", " . $row["categoryTwo"] . ", " . $row["categoryThree"] . ", " . $row["categoryFour"] . ", " . $row["categoryFive"];
}




	if ($userType == '2')
	{
	echo"
		<div class = 'reg'>
			<div class = 'fields-left'>
				<div class = 'text_field'>
					<span>Interests:</span></br><input type='text' name='interestOne' value = '$categories'  disabled/><a href = 'editcategory.php'><button name = 'change' >Edit</button></a>
				</div>
				";
				
				
				/*
				<div class = 'text_field'>
					<span>Age Group: </span></br><input type='text' name='ageRange' value = '{$row["ageRange"]}' disabled /><a href = 'editagegroup.php'><button name = 'change' >Edit</button></a>
				</div>";*/
			echo"
			</div
	</div>";
	}
	else if ($userType == '1') {
		
		echo"
		<div class = 'reg'>
		<div class = 'fields-left'>
				<div class = 'text_field'>
					<span>Types of product sold:</span></br><input type='text' name='interestOne' value = '$categories'  disabled/><a href = 'editcategory.php'><button name = 'change' >Edit</button></a>
				</div>";
				/*
				<div class = 'text_field'>
					<span>Target Age Group: </span></br><input type='text' name='ageRange' value = '{$row["ageRange"]}' disabled /><a href = 'editagegroup.php'><button name = 'change' >Edit</button></a>
				</div></div>*/
	}
}
?>
<script>
// to close the success box
document.querySelector('.close-button').addEventListener('click', function() {
			document.querySelector('.success-box').style.display = 'none';
		});
</script>
</body>