<?php
	// We need to use sessions, so you should always start sessions using the below code.
	session_start();
	// If the user is not logged in redirect to the login page...
	if (!isset($_SESSION['loggedin'])) {
		header('Location:login.php');
		exit;
	}
	
	$userType = $_SESSION['userType'];
	if (isset($_GET['userid'])){
		$userid = $_GET['userid'];
	}
	else{
		$userid = '';
	}
?>
<!DOCTYPE html>
<html>	
<head>
<title>Delete User</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
 <link rel="stylesheet" href="deleteuser_style.css?version8">
</head>
<!-- change of button (all, admin, org, ind) based on current url-->
<body>
<?php
include ('inc_db_fyp.php');
include ('user.php');
if ($userType == '0') #admin
{#header, top navbar
?>
	<header>
		 <nav>
			<ul class="nav-titles">
				<li name = 'recs'><a name = 'recs' href="home.php">RECS</a></li>     
			    <li style='margin-left: auto;'><a name = 'adminmanage' href="manageaccounts.php" style = 'padding-right: 60px;'>Manage Accounts</a>
				<a name = 'admincreate' href="createaccount.php?id=orgcreateacc" style = 'padding-right: 60px;'>Create Account</a></li>
			  </ul>
			<div class="dropdown">
				<button class="profile"><?=$_SESSION['name'][0]?></button>
				<div class="profile-content">
					<a class="logout" href="accountsettings.php">Account Settings</a></li>
					<a class="logout" href="logout.php">Logout</a></li>
				</div>
			  </div>        
		</nav>		
	</header>
	<h1>Delete User</h1>
<?php 

#get user info by calling user entity method and display info
$user = new User();
$row = $user-> getUserInfo ($userid);


#check is update button is clicked and update user info accordingly
if (isset($_POST['submit']) and ($_POST['submit'] == 'Delete')){
	
	#call user entity method
	$user-> deleteUser($userid);
	header("Location: manageaccounts.php");
}



echo"
<div class = 'reg'>
<form action = '' method = 'POST'>
		<div class = 'text_field'>
			<span>User ID:</span><input type='text' name='userid' value = '{$row["userID"]}' style = 'color:grey; background-color:whitesmoke' readonly />
		</div>
		<div class = 'text_field'>
			<span>Email:</span><input type='email' name='email' value = '{$row["emailAddress"]}' style = 'color:grey; background-color:whitesmoke' readonly />
		</div>
		<div class = 'text_field'>
			<span>Name: </span><input type='text' name='name' value = '{$row["name"]}' style = 'color:grey; background-color:whitesmoke' readonly  />
		</div>
		<div class = 'text_field'>
			<span>Organization Name: </span><input type='text' name='orgname' value = '{$row["Organization Name"]}' style = 'color:grey; background-color:whitesmoke' readonly  />
		</div>
		<div class = 'text_field'>
			<span>Organization Website: </span><input type='text' name='orgsite' value = '{$row["Organization Website"]}' style = 'color:grey; background-color:whitesmoke' readonly  />
		</div>
	
		<input type='button' value='Cancel' onclick='history.go(-1)'>
		<input type='submit' name = 'submit' value='Delete'>
	</form>
</div>";
}



?>
</body>s