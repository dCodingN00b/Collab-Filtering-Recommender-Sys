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
 <link rel="stylesheet" href="deleteuser_style.css?version7">
</head>
<!-- change of button (all, admin, org, ind) based on current url-->
<body>
<?php
include ('inc_db_fyp.php');
if ($userType == '0') #admin
{#header, top navbar
?>
	<header>
		 <nav>
			<ul class="nav-titles">
				<li name = 'recs'><a name = 'recs' href="home.php">RECS</a></li>     
				<li><a name = 'adminmanage' href="manageaccounts.php">Manage Accounts</a></li>					
				<li><a name = 'admincreate' href="createaccount.php?id=orgcreateacc">Create Account</a></li>
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
#check is update button is clicked and update user info accordingly
if (isset($_POST['submit']) and ($_POST['submit'] == 'Delete')){
	$sql = "DELETE FROM users
			WHERE userID = ?";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param('s', $user);
	$user = $userid;
	try{
		if ($stmt->execute()){
			$_SESSION['successStatus'] = "User Information Successfully Deleted.";
			header("Location: manageaccounts.php");
		}
		else{
			  throw new Exception("error");
		}
	}
	catch (Exception $e) {
		echo $e->getMessage();
	}
}

$sql = "SELECT * FROM users WHERE userID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user);
$user = $userid;
$stmt->execute();
$result = $stmt->get_result();
$row = mysqli_fetch_array($result);

echo"
<div class = 'reg'>
<form action = '' method = 'POST'>
		<div class = 'text_field'>
			<span>User ID:</span><input type='text' name='userid' value = '{$row["userID"]}' style = 'color:grey; background-color:whitesmoke' readonly readonly />
		</div>
		<div class = 'text_field'>
			<span>Email:</span><input type='email' name='email' value = '{$row["emailAddress"]}' style = 'color:grey; background-color:whitesmoke' readonly readonly />
		</div>
		<div class = 'text_field'>
			<span>Name: </span><input type='text' name='name' value = '{$row["userName"]}' style = 'color:grey; background-color:whitesmoke' readonly readonly  />
		</div>
		<div class = 'text_field'>
			<span>Organization Name: </span><input type='text' name='orgname' value = '{$row["Organization Name"]}' style = 'color:grey; background-color:whitesmoke' readonly readonly  />
		</div>
		<div class = 'text_field'>
			<span>Organization Website: </span><input type='text' name='orgsite' value = '{$row["Organization Website"]}' style = 'color:grey; background-color:whitesmoke' readonly readonly  />
		</div>
	
		<input type='button' value='Cancel' onclick='history.go(-1)'>
		<input type='submit' name = 'submit' value='Delete'>
	</form>
</div>";
}



?>
</body>s