<?php
	// We need to use sessions, so you should always start sessions using the below code.
	session_start();
	// If the user is not logged in redirect to the login page...
	if (!isset($_SESSION['loggedin'])) {
		header('Location:login.php');
		exit;
	}
	
	$userType = $_SESSION['userType'];
?>

<!DOCTYPE html>
<html>
<head>
<title>Home</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
 <link rel="stylesheet" href="upgradeplans_style.css?version13">

</head>
<body>
	<header>
			 <nav>
                <ul class="nav-titles">
					<li name = 'recs'><a name = 'recs' href="home.php">RECS</a></li>      
                    <li><a name = 'workspace' href="workspace.php">Workspace</a></li>
					<li><a name = 'upgradeplans' href="upgradeplans.php">Upgrade Plan</a></li>	
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
if ($userType == '1'){
	echo"<h1 style='text-align:center'>Upgrade Plans</h1>
	<div class='pricing' id='pricing'>
		<div class='pricing-container'>
			<div class='pricing-box'>
				<img name = 'standard' src ='images/upgrade.svg' alt =''>
				<h2>Standard</h2>
				<p name='intro'>Get more out of the</br> product.</p>
				<p>10GB Uploadable Data</br>1000 Recommendation Requests</p>
				<h3>$14.90 / month</h3>
				<button><a href = 'org_register.php'>Upgrade to Standard</a></button>
			</div>
			<div class='pricing-box'>
				<img name = 'pro' src ='images/high.svg' alt =''>
				<h2>Pro</h2>
				<p name='intro'>Get the most out of</br> the product.</p>
				<p>50GB Uploadable Data</br>5000 Recommendation Requests</p>
				<h3>$49.90 / month</h3>
				<button><a href = 'org_register.php'>Upgrade to Pro</a></button>
			</div>
			<div class='pricing-box'>
				<img name = 'custom' src ='images/custom.svg' alt =''>
				<h2>Custom</h2>
				<p name='intro'>Cost depends on how </br>much you use the product.</p>
				<p>Unlimited Uploadable Data</br>Unlimited Recommendation Requests</p>
				<h3>?? / month</h3>
				<button><a href = ''>Upgrade to Custom</a></button>
			</div>
		</div>
	</div>";
}else if ($userType == '2'){
echo"<h1 style='text-align:center'>Upgrade Plans</h1>
	<div class='pricing' id='pricing'>
		<div class='pricing-container'>
			<div class='pricing-box'>
					<img name = 'standard' src ='images/upgrade.svg' alt =''>
					<h2>Standard</h2>
					<p name='intro'>Get more out of the</br> product.</p>
					<p>2000 Recommendation Requests</p>
					<h3>$1.99 / month</h3>
					<button><a href = 'indiv_register.php'>Upgrade to Standard</a></button>
			</div>
			<div class='pricing-box'>
				<img name = 'pro' src ='images/high.svg' alt =''>
				<h2>Pro</h2>
				<p name='intro'>Get the most out of</br> the product.</p>
				<p>10000 Recommendation Requests</p>
				<h3>$4.99 / month</h3>
				<button><a href = 'indiv_register.php'>Upgrade to Pro</a></button>
			</div>
			<div class='pricing-box'>
				<img name = 'custom' src ='images/custom.svg' alt =''>
				<h2>Custom</h2>
				<p name='intro'>Cost depends on how </br>much you use the product.</p>
				<p>Unlimited Recommendation Requests</p>
				<h3>?? / month</h3>
				<button><a href = 'indiv_register.php'>Upgrade to Custom</a></button>
			</div>
		</div>
	</div>";
}
?>
</body>
</html>