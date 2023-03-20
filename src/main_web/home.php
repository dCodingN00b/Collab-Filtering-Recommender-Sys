<?php
	// We need to use sessions, so you should always start sessions using the below code.
	session_start();
	// If the user is not logged in redirect to the login page...
	if (!isset($_SESSION['loggedin'])) {
		header('Location:login.php');
		exit;
	}
	
	$userType = $_SESSION['userType'];
	
	if (isset($_SESSION['pricePlan'])){
		if ($_SESSION['pricePlan'] == '0'){
			$pricePlan = 'Free Trial';
		}
		else if ($_SESSION['pricePlan'] == 'i1'){
			$pricePlan = 'Individual - Standard';
		}
		else if ($_SESSION['pricePlan'] == 'i2'){
			$pricePlan = 'Individual - Pro';
		}
		else if ($_SESSION['pricePlan'] == 'o1'){
			$pricePlan = 'Organization - Standard';
		}
		else if ($_SESSION['pricePlan'] == 'o2'){
			$pricePlan = 'Organization - Pro';
		}
	}
	
	#time now - time of creation
	$date = strtotime($_SESSION['dateTimeOfCreation']);
	$timePassed = time() - $date;
	$daysPassed = $timePassed  / 86400;
	$daysRemaining = floor(30.0 - $daysPassed);
	
	$_SESSION['currentplan'] = $pricePlan;
	$_SESSION['daysremaining'] = $daysRemaining;
?>

<!DOCTYPE html>
<html>
<head>
<title>Home</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
 <link rel="stylesheet" href="home_style.css?version19">

</head>
<body>
<?php 
if ($userType == '1') #org (client)
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
					<button class="profile"><?php echo $_SESSION['name'][0]?></button>
					<div class="profile-content">
						<a class="logout" href="accountsettings.php">Account Settings</a></li>
						<a class="logout" href="logout.php">Logout</a></li>
					</div>
				  </div>        
			</nav>		
	</header>
	<div class="landscape-container">
		<div class="welcome-box">
		  <h1 class = 'welcome' >Welcome back, <?=$_SESSION['name']?> (Org)!</h1>
		  <img src="images/welcome.svg" alt="Landscape image">
		</div>
		<div class = "content-container">
			<div class="activity-box">
			  <h1 class = 'activity' >Let's start now! Head towards</br> your workshop!</h1>
			  <button><a href ='workspace.php'>Workspace</a></button>
			</div>
			<div class="doc-box">
			  <h1 class = 'doc' >Want to understand</br> RECS better?</h1>
			  <button><a href ='main.php?id=howitworks'>How It Works</a></button>
			</div>
		</div>
	<div>
<?php 
}else if ($userType == '2') #indiv (customer)
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
						<li><a class="logout" href="accountsettings.php">Account Settings</a></li>
						<li><a class="logout" href="logout.php">Logout</a></li>
					</div>
				  </div>        
			</nav>		
	</header>
	<div class="landscape-container">
		<div class="welcome-box">
		  <h1 class = 'welcome' >Welcome back, <?=$_SESSION['name']?> (Individual)!</h1>
		  <img src="images/welcome.svg" alt="Landscape image">
		</div>
		<div class = "content-container">
			<div class="activity-box">
			  <h1 class = 'activity' >Let's start now! Head towards</br> your workshop!</h1>
			  <button><a href ='workspace.php'>Workspace</a></button>
			</div>
			<div class="doc-box">
			  <h1 class = 'doc' >Want to understand</br> RECS better?</h1>
			  <button><a href ='default.php?id=howitworks'>How It Works</a></button>
			</div>
		</div>
	<div>
		
<?php 
}else if ($userType == '0') #(admin)
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
	<div class="landscape-container" style='transform:translate(0%, -18%)'>
		<div class="welcome-box">
		  <h1 class = 'welcome' >Welcome back, <?=$_SESSION['name']?> (Admin)!</h1>
		  <img src="images/welcome.svg" alt="Landscape image">
		</div>
	<div>
<?php
}
?>
</body>
</html>
