<?php
	// We need to use sessions, so you should always start sessions using the below code.
	 if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
	
	// If the user is not logged in redirect to the login page...
	if (!isset($_SESSION['loggedin'])) {
		header('Location:login.php');
		exit;
	}
	
	include('user.php');
	
	$id = '';
	$option = '';
	if (isset($_GET['id'])){
		$id = $_GET['id'];
	}
	
	if (isset($_GET['option'])){
		$option = $_GET['option'];
	}
	
	if (isset($_SESSION['id'])){
		$userid = $_SESSION['id'];
	}
	else{
		$userid = '';
	}
	
	$userType = $_SESSION['userType'];
	
	#check price plan for display in navbar
	if (isset($_SESSION['pricePlan'])){
		if ($_SESSION['pricePlan'] == '0'){
			$pricePlan = 'Free Trial';
		}
		else if ($_SESSION['pricePlan'] == 'i1'){
			$pricePlan = 'Standard';
		}
		else if ($_SESSION['pricePlan'] == 'i2'){
			$pricePlan = 'Pro';
		}
		else if ($_SESSION['pricePlan'] == 'o1'){
			$pricePlan = 'Standard';
		}
		else if ($_SESSION['pricePlan'] == 'o2'){
			$pricePlan = 'Pro';
		}
		else{
			$pricePlan = 'None';
		}
	}
	$user = new User();
	$userinfo = $user->getUserInfo($userid);
	
	if ($_SESSION['pricePlan'] == '0'){
		#time now - time of creation
		$creationDate = strtotime($userinfo['dateTimeOfCreation']);
		$timeLeft = strtotime($userinfo['freeTrialExpiryDate']) - time();;
		$daysRemaining  = floor($timeLeft  / 86400);

		
		$_SESSION['currentplan'] = $pricePlan;
		$_SESSION['daysremaining'] = $daysRemaining;
		$planinfo = '';
	}
	else if(($_SESSION['pricePlan'] == 'o1') or ($_SESSION['pricePlan'] == 'o2') or ($_SESSION['pricePlan'] == 'i1') or ($_SESSION['pricePlan'] == 'i2')){
		
		$endDate = strtotime($userinfo['expiryDate']);
		$daysRemaining = floor( ($endDate - time()) / 86400);	
	}
	else {
		
	}

	
?>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="navbar_style.css?version27">
<link rel="stylesheet" href="style.css"> <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
<style>
/* width */
::-webkit-scrollbar {
  width: 15px;
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

body {
	overflow-y : auto;
}
</style>
</head>
<body>
<?php 
if ($userType == '1' or $userType =='2')
{
?>
	<header>
			 <nav>
				<ul class="nav-titles">
					<li name = 'recs'><a name = 'recs' href="home.php">RECS</a></li>      
					<li><a name = 'workspace' href='workspace.php'>Workspace</a></li>
					<li style='margin-left: auto; transform: translate(-15%, 0%);'><a name = 'upgradeplans' href="upgradeplans.php" style = 'transform: translate(-55%, 0%);'>Upgrade Plan</a><a name = 'currentplans' href="myplan.php" >
					<?php 
					if ($pricePlan != 'None'){
						echo $pricePlan, ' Plan [', $daysRemaining, ' Days Left]';
					}
					else {
						echo "Current Plan: " . $pricePlan;
					}
					?>
					</a></li>
				</ul>
					
				<div class="dropdown">
					<button class="profile"><?=$_SESSION['name'][0]?></button>
					<div class="profile-content" style = "transform: translate(-5%, 42%);">
						<li><a class="logout" href="accountsettings.php">Account Settings</a></li>
						<li><a class="logout" href="profile.php">User Profile</a></li>
						<li><a class="logout" href="logout.php">Logout</a></li>
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
			   <li style='margin-left: auto;'><a name = 'adminmanage' href='manageaccounts.php' style = 'margin-right: 60px;'>
			   Manage Accounts</a><a name = 'admincreate' href="createaccount.php?id=orgcreateacc" style = 'margin-right: 60px;'>Create Account</a></li>
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
</body>