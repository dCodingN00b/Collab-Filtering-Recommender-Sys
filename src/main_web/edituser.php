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
<title>Edit User</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />

 <link rel="stylesheet" href="edituser_style.css?version7">
</head>
<!-- change of button (all, admin, org, ind) based on current url-->
<body onload = 'checkOrg();'>
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
	<h1>Edit User</h1>
<?php 
#check is update button is clicked and update user info accordingly
if (isset($_POST['submit']) and ($_POST['submit'] == 'Update')){
	$sql = "UPDATE users 
			SET emailAddress = ?, password = ?, userName = ?, userType = ?,`Organization Name` = ?, `Organization Website` = ?
			WHERE userID = ?";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param('sssssss', $emailAddress, $password, $name, $userType, $orgName, $orgSite, $user);
	
	$emailAddress = $_POST['email'];
	$password = $_POST['password'];
	$name = $_POST['name'];
	$userType = $_POST['userType'];
	if (isset($_POST['orgname'])){
		$orgName = $_POST['orgname'];
	}else{
		$orgName = '';
	}

	if (isset ($_POST['orgsite'])){
		$orgSite = $_POST['orgsite'];
	}else{
		$orgSite = '';
	}
	
	$user = $userid;
	try{
		if ($stmt->execute()){
			$_SESSION['successStatus'] = "User Information Successfully Updated.";
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

#retrieve user info
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
			<span>User ID:</span><input type='text' name='userid' value = '{$row["userID"]}' style = 'color:grey; background-color:whitesmoke' readonly />
		</div>
		<div class = 'text_field'>
			<span>Email:</span><input type='email' name='email' value = '{$row["emailAddress"]}' />
		</div>
		<div class = 'text_field'>
			<span>Password: </span><input type='password' name='password' value = '{$row["password"]}' required />
		</div>
		<div class = 'text_field'>
			<span>Confirm Password: </span><input type='password' name='cpassword' value = '{$row["password"]}' required />
		</div>
		<div class = 'text_field'>
			<span>Name: </span><input type='text' name='name' value = '{$row["userName"]}' required />
		</div>
		<div class = 'text_field'>
			<span>User Type: </span>
			<select name='userType' id='userType' class = 'userType' onchange = 'checkOrg();'>
			  <option value='0'" .(($row['userType'] == '0')? 'selected="selected"' : '') . ">Admin</option>
			  <option value='2'" . (($row['userType'] == '2')? 'selected="selected"' : '') . ">Individual</option>
			  <option value='1'" . (($row['userType'] == '1')? 'selected="selected"' : '') . ">Organization</option>
			</select>
		</div>
		<div class = 'text_field'>
			<span>Organization Name: </span><input type='text' id = 'orgname' name='orgname' value = '{$row["Organization Name"]}' required />
		</div>
		<div class = 'text_field'>
			<span>Organization Website: </span><input type='text' id = 'orgsite' name='orgsite' value = '{$row["Organization Website"]}' required />
		</div>
	

		<input type='button' value='Cancel' onclick='history.go(-1)'>
		<input type='submit' name = 'submit' value='Update'>
	</form>
</div>";
}
?>
<script type="text/javascript">
function checkOrg() {
	/*if usertype is org, remove disabled attribute, else, add disabled attribute*/
	if (document.getElementById("userType").value == "1") {
		document.getElementById("orgname").removeAttribute("disabled");
		document.getElementById("orgsite").removeAttribute("disabled");
		document.getElementById("orgsite").style.backgroundColor = 'AliceBlue';
		document.getElementById("orgname").style.backgroundColor = 'AliceBlue';
		
	} else { 
		document.getElementById("orgname").setAttribute("disabled", true);
		document.getElementById("orgname").style.backgroundColor = '#dedede';
		document.getElementById("orgsite").setAttribute("disabled", true);
		document.getElementById("orgsite").style.backgroundColor = '#dedede';
	}
}
</script>
</body>