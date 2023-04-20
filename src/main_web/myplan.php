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
	
	$userType = $_SESSION['userType'];
	$name = $_SESSION['name'];
	$freeTrialExpiryDate = $_SESSION['freeTrialExpiryDate'];
	
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
		else {
			$pricePlan = 'None';
		}
	}
	
	if (isset($_GET['tab'])){
		$tab = $_GET['tab'];
	}else {
		$tab = '';
	}
?>

<!DOCTYPE html>
<html>
<head>
<title>Profile Information</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
 <link rel="stylesheet" href="myplan_style.css?version17">
<style>
li a[name='currentplans'] {
	border-bottom: 2px solid lightgreen !important;
}


/* Style the progress bar itself */
.progress-bar {
  height: 20px;
  color:black;
  text-align: center;
  background-color: powderblue;
 
  transition: width 0.6s ease;
 
}

.filtering{
	width: 450px;
	margin: 0 auto;
	height: 40px;
	transform:translate(0%,90%);
	margin-top: 40px;
}

.filtering h3 {
	color: black;
	text-align: center;
	padding: 14px 0px;
	font-size: 20px;
	border-bottom: 2px solid lavender;
	width: 140px;
    display: inline-block;
	transform: translate(50%, 0%);
}

.filtering h3[name = 'quota']{
	color: black;
	text-align: center;
	padding: 14px 0px;
	font-size: 20px;
	border-bottom: 2px solid lavender;
	width: 140px;
    display: inline-block;
	transform: translate(61%, 0%);
}

.filtering h3[name = 'billing'] {
	color: black;
	text-align: center;
	padding: 14px 0px;
	font-size: 20px;
	border-bottom: 2px solid lavender;
	width: 120px;
    display: inline-block;
	transform: translate(63%, 0%);
}

</style>
</head>
<body>
<?php 
include('navbar.php');


#get all transactions records of current user
$user = new User();
$result = $user->getAllTransactions($userid);

#calculate membership duration
$membership = $user->calculateMemberDuration ($userid);
$membership = substr($membership, 0, 2);
$month = floor($membership / 30);
$day = $membership - (30 * $month);

$planinfo = $user->getLatestTransactionInfo($userid);
		
		
echo"<div style = 'height: 1000px;'>";
/*
echo"<div class = 'filterButton' style='transform:translate(0%, 120%);'>
		<a href = 'profile.php?tab=quota'><button id = 'quota'>Quota</button></a>
		<a href = 'profile.php?tab=billing'><button id = 'billing'>Billing</button></a>		
	</div>";*/

if ($tab == 'billing'){
	
	echo" <div class = 'filtering'>
<a href='myplan.php?tab=quota'><h3 name = 'quota' id = 'quota' style='color:grey;'
onmouseover='style = \"color:green; border-bottom:2px solid lightgreen;\"' onmouseout='style = \"color:grey;\"'>Quota</h3></a>
		<a href='myplan.php?tab=billing'><h3 name = 'billing' id = 'billing' style='border-bottom:2px solid lightgreen'
		 >Billing</h3></a></div>";
	
	echo"<div class = 'title' style='transform:translate(0%, 25%);'>
		<img class = 'billingimg' src = 'images/billing.svg' alt = ''>
		<h1 style='text-align: left;'>Billing<h1>
		</div>";
	
	echo"<div class = 'box' style='transform:translate(0%, 10%);'>
		<div class = 'currentplanheader'><h1 style='transform:translate(0%, -20%);'>Current Plan<h1></div>";
		
	echo"
		<ul class ='currentplan' style='transform:translate(2%, 20%); font-size: 18px;text-align: left;'>
			<li class = 'currentplaninfo' >Price Plan<b>: $pricePlan</b></li>";
			if ($pricePlan == 'Standard' or $pricePlan == 'Pro'){
	echo"
			<li class = 'currentplaninfo' >Amount<b>: SGD {$planinfo['amountPaid']} / month</b></li>
			<li class = 'currentplaninfo' >Next Billing Date<b>: {$planinfo['expiryDate']}</b></li>
			<li class = 'currentplaninfo' >Membered for<b>: $month Month $day Days</center></b></li>";
			}
			else if ($pricePlan == 'Free Trial'){
	echo"	
			<li class = 'currentplaninfo' >End Date<b>: $freeTrialExpiryDate</b></li>
			";			
			}
	echo"
		</ul>
	 </div>";
	 
	 echo"
	 <div class = 'billingtable' style='transform:translate(0%, 20%);'>
	 <div class = 'billingheader'><h1 style='transform:translate(0%, -20%);'>Transactions<h1></div>
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
		echo '<td>' .sprintf('%010d', $row['transactionID']) . '</td>';
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
			$is_expired = '<span style = "color:red;">Expired</span>';
		} else {
			// the expiry date is after the current date and time
			$is_expired = '<span style = "color:green;">Active</span>';
		}
		echo '<td>' . $is_expired . '</td></tr>';
	}

}
else if ($tab == 'quota' or $tab == ''){
	echo" <div class = 'filtering'>
<a href='myplan.php?tab=quota'><h3 name = 'quota' id = 'quota' style='border-bottom:2px solid lightgreen'>Quota</h3></a>
		<a href='myplan.php?tab=billing'><h3 name = 'billing' id = 'billing' style='color:grey;'
		onmouseover='style = \"color:green; border-bottom:2px solid lightgreen;\"' onmouseout='style = \"color:grey;\"' >Billing</h3></a></div>";
	echo"<div class = 'title' style='transform:translate(0%, 25%);'>
		<img class = 'quotaimg' src = 'images/quota.svg' alt = ''>
		<h1 style='text-align: left;'>Quota<h1>
		</div>";
	echo"<div class = 'box' style='transform:translate(0%, 10%);'>
		<div class = 'usageheader'><h1 style='transform:translate(0%, -20%);'>Monthly Usage<h1></div>";

// Set the total number of recommendations
$total_recommendations = 100;

// Get the current number of recommendations
$current_recommendations = 80;

// Calculate the percentage of recommendations completed
$percent_complete = ($current_recommendations / $total_recommendations) * 100;

// Round the percentage to the nearest whole number
$percent_complete = round($percent_complete);

// Determine the width of the progress bar
$progress_width = $percent_complete . '%';

// Output the progress bar
echo '<div class="progress" style="transform:translate(0%, 40%); width: 95%;margin: 0 auto;">';
echo '<h3>Recommendations: ' .  $current_recommendations . ' / ' . $total_recommendations . '</h3>';
echo '<div style = "width: 100%; background-color: whitesmoke; border: 0.1px solid black; transform:translate(0%, 20%);">';
echo '<div class="progress-bar" role="progressbar" style="width: ' . $progress_width . ';" aria-valuenow="' . $percent_complete . '" aria-valuemin="0" aria-valuemax="100">' . $percent_complete . '%</div>';
echo '</div></br>';



// Set the total number of recommendations
$total_data = 2 * 1024;

// Get the current number of recommendations
$current_data = 202;

// Calculate the percentage of recommendations completed
$percent_complete_data = ($current_data / $total_data) * 100;

// Round the percentage to the nearest whole number
$percent_complete_data = round($percent_complete_data);

// Determine the width of the progress bar
$progress_width_data = $percent_complete_data . '%';

// Output the progress bar
echo '<div class="progress" style="transform:translate(0%, 40%);margin: 0 auto;">';
echo '<h3>Uploaded Data: ' .  $current_data . ' / ' . $total_data . ' MB</h3>';
echo '<div style = "width: 100%; background-color: whitesmoke; border: 0.1px solid black; transform:translate(0%, 20%);">';
echo '<div class="progress-bar" role="progressbar" style="width: ' . $progress_width_data . ';" aria-valuenow="' . $percent_complete_data . '" aria-valuemin="0" aria-valuemax="100">' . $percent_complete_data . '% </div>';
echo '</div>';



echo '</div>';
	echo" </div>";
}
echo"</div>";
?>
</body>