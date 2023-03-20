<?php
	// We need to use sessions, so you should always start sessions using the below code.
	session_start();
	// If the user is not logged in redirect to the login page...
	if (!isset($_SESSION['loggedin'])) {
		header('Location:login.php');
		exit;
	}
	
	$userType = $_SESSION['userType'];
	$pricePlan = $_SESSION['currentplan'];
	$daysRemaining = $_SESSION['daysremaining'];
?>

<!DOCTYPE html>
<html>
<head>
<title>Upgrade Plans</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
 <link rel="stylesheet" href="payment_style.css?version20">

</head>
<body>
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
	<h1 style='text-align:center'>Select Payment  Method</h1>
<div class 'payment'>
	<div class = 'paymentmethod' style='transform:translate(-50%, 0%);'>
		<a href=""><h3 name = 'creditcard' id = 'creditcard' style='border-bottom:2px solid lightgreen'>Credit / Debit Card</h3></a>
		<form action = "" method = "POST">
				<div class = 'text_field'>
					<span>Credit Card:</span><input type="text" name="cardnumber" required />
				</div>
				<div class = 'text_field'>
					<span>Name: </span><input type="text" name="name" required />
				</div>
				<div class = 'text_field'>
					<span>Expiration Date: </span><span style = 'padding-left: 75px'>CVV: </span><input type="text" name="expdate" style = 'width: 62%;margin-right: 10px' required />
					<input type="password" name="cvv" style = 'width: 33%;' required />
				</div>
				</br><input type="submit" name = "submit" value="Pay">
			</form>
	</div>
	<div class = 'bill' style='transform:translate(60%, -205%); '>
		<img name = 'pro' src ='images/high.svg' alt =''>
		<h2 name = 'upgradetype'>Pro</h2>
		<p name = 'benefits' >50GB Uploadable Data</br>5000 Recommendation Requests</p>
		<h2 name = 'amounttopay'>Amount to pay:</h2>
		<p name = 'company'>Company: </p>
		<p name ='ordernumber'>Order Number: </p>
		<p name = 'amount'>SGD$49.90</p>	
	</div>
</div>