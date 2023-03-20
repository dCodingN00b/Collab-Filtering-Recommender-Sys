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
	
	$pricePlan = $_SESSION['currentplan'];
	$daysRemaining = $_SESSION['daysremaining'];
?>
<!DOCTYPE html>
<html>	
<head>
<title>Account Settings</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />

 <link rel="stylesheet" href="accountsettings_style.css?version13">
</head>

<body>
<?php
include ('inc_db_fyp.php');
include ('user.php');

if ($userType == '1' or $userType == '2' or $userType == '0') 
{#header, top navbar
	if ($userType == '1' or $userType == '2')
	{
?>
		<header>
				 <nav>
				<ul class="nav-titles">
					<li name = 'recs'><a name = 'recs' href="home.php">RECS</a></li>      
					<li><a name = 'workspace' href="workspace.php">Workspace</a></li>
					<li style='margin-left: auto; transform: translate(-15%, 0%);'><a name = 'upgradeplans' href="upgradeplans.php" style = 'transform: translate(-55%, 0%);'>Upgrade Plan</a><a name = 'currentplans' href="#" >
					Current Plan: <?php echo $pricePlan, ' [', $daysRemaining, ' Days Left]' ?></a></li>
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
	<?php 
	}
	else if ($userType == '0')
	{
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
	<?php 
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
			</div>
			<div class = 'text_field'>
				<span>Password: </span></br><input type='password' name='password' value = '{$row["password"]}' disabled /><button name = 'change' >Edit</button>
			</div>";
			if ($userType == '1'){
				echo"
				<div class = 'text_field'>
					<span>Organization Name: </span></br><input type='text' id = 'orgname' name='orgname' value = '{$row["Organization Name"]}'  disabled /><button name = 'change' >Edit</button>
				</div>";
			}
		echo"
		</div>
		<div class = 'fields-right'>
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
			</div>
			<div class = 'text_field'>
				<span>Name: </span></br><input type='text' name='name' value = '{$row["name"]}' disabled /><button name = 'change' >Edit</button>
			</div>";
			if ($userType == '1'){
			echo"
				<div class = 'text_field'>
					<span>Organization Website: </span></br><input type='text' id = 'orgsite' name='orgsite' value = '{$row["Organization Website"]}'  disabled /><button name = 'change' >Edit</button>
				</div>";
			}
			echo"
		</div>
</div>";
}
?>
</body>