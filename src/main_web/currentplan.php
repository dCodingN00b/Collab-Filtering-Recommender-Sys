<?php
	// We need to use sessions, so you should always start sessions using the below code.
	session_start();
	// If the user is not logged in redirect to the login page...
	if (!isset($_SESSION['loggedin'])) {
		header('Location:login.php');
		exit;
	}
	
	if (isset($_SESSION['id'])){
		$userid = $_SESSION['id'];
	}
	else{
		$userid = '';
	}

	if (isset($_GET['upgrade'])){
		$upgradeplan = $_GET['upgrade'];
	}else {
		$upgradeplan = '';
	}
	
	$name = $_SESSION['name'];
	
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
	}
?>

<!DOCTYPE html>
<html>
<head>
<title>Current Plan</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
 <link rel="stylesheet" href="currentplan_style.css?version4">
<style>
li a[name='currentplans'] {
	border-bottom: 2px solid lightgreen !important;
}


</style>
</head>
<body>
<?php 
include('navbar.php');


$result = $user->getAllTransactions($userid);

echo"<div class = 'filterButton' >
	<a href = 'currentplan.php?sort=admin'><button id = 'admin'>Quota</button></a>
	<a href = 'manageaccounts.php?sort=org'><button id = 'org'>Current Plan</button></a>
	<a href = 'manageaccounts.php?sort=ind'><button id = 'ind'>Billing</button></a>
</div>";

echo"<div class = 'box' style='transform:translate(0%, 50%);'>
		<h1 class = 'currentplanheader'>Current Plan<h1>
		<div class ='nextbillingdate' style='transform:translate(5%, -20%); font-size: 24px;text-align: left;'>
			<p style = 'font-weight: 500;'>Price Plan: $pricePlan</p>
			<p style = 'font-weight: 500;'>Next Billing Date: {$planinfo['expiryDate']}</p>
			<p style = 'font-weight: 500;'>Amount Paid: SGD{$planinfo['amountPaid']} / month</p>
		</div>
	 </div>";
	echo"
	 <div class = 'box' style='transform:translate(0%, 100%);'>
		<table border='1'>
	<tr style='text-align:center;'>
	 <th ><strong>Transaction ID</strong></th>
<th><strong>Start Date</strong></th>
<th><strong>Expiry Date</strong></th>
<th><strong>Price Plan</strong></th>
<th><strong>Amount Paid</strong></th>
<th><strong>Status</strong></th>
	</tr>
	 </div>";
	 
	while($row = mysqli_fetch_assoc(($result))){
		echo '<tr>';
		echo '<td>' . $row['transactionID'] . '</td>';
		echo '<td>' . substr($row['startDate'], 0, 19) . '</td>';
		echo '<td>' . substr($row['expiryDate'], 0, 19) . '</td>';
		if ($row['pricePlan'] == '0'){
			$pricePlan = 'Free Trial';
		}
		else if ($row['pricePlan'] == 'i1'){
			$pricePlan = 'Standard';
		}
		else if ($row['pricePlan'] == 'i2'){
			$pricePlan = 'Pro';
		}
		else if ($row['pricePlan'] == 'o1'){
			$pricePlan = 'Standard';
		}
		else if ($row['pricePlan'] == 'o2'){
			$pricePlan = 'Pro';
		}
		else {
			$pricePlan = 'None';
		}
		echo '<td>' . $pricePlan . '</td>';
		echo '<td>SGD ' . substr($row['amountPaid'], 0, 19) . '</td>';
		
		if (strtotime($row['expiryDate']) < time()) {
			// the expiry date is before the current date and time
			$is_expired = 'Expired';
		} else {
			// the expiry date is after the current date and time
			$is_expired = 'In Progress';
		}
		echo '<td>' . $is_expired . '</td></tr>';
	}
?>