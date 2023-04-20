<?php
	// We need to use sessions, so you should always start sessions using the below code.
	session_start();
	// If the user is not logged in redirect to the login page...
	if (!isset($_SESSION['loggedin'])) {
		header('Location:login.php');
		exit;
	}
	
	$userType = $_SESSION['userType'];
	$daysRemaining = $_SESSION['daysremaining'];
	$amounttopay = $_SESSION['amounttopay'];

	
	if (isset($_SESSION['id'])){
		$userid = $_SESSION['id'];
	}
	else{
		$userid = '';
	}
?>

<!DOCTYPE html>
<html>
<head>
<title>Summary</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
 <link rel="stylesheet" href="summary_style.css?version36">
<style>
li a[name='upgradeplans'] {
	border-bottom: 2px solid lightgreen !important;
}

.payment-ui {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin: 90px auto;
  max-width: 500px;
  transform: translate(0%, 0%);
}

.payment-ui-words {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin: -20px auto;
  max-width: 565px;
  transform: translate(-1%, -300%);
}

.circle {
  width: 30px;
  height: 30px;
  border-radius: 50%;
  background-color: #ddd;
  display: flex;
  justify-content: center;
  align-items: center;
  font-weight: bold;
  font-size: 16px;
  color: grey;
}

.line {
  height: 2px;
  background-color: #ddd;
  flex: 1;
  margin: 0 10px;
 
}

.active {
  background-color: powderblue;
  color: #fff;
}
</style>
</head>
<body>
	<?php 
	include('navbar.php');
	
	echo'
	
	<div class="payment-ui">
	  <div class="circle">1</div>
	  <div class="line"></div>
	  <div class="circle">2</div>
	  <div class="line"></div>
	  <div class="circle active">3</div>
	</div>
	<div class="payment-ui-words">
	  <div style = "color:grey">Choose Plan</div>
	  
	  <div style = "color:grey">Payment</div>
	 
	  <div style = "margin-left:12px;">Summary</div>
	</div>
	<h1 style="text-align:center; transform:translate(0%, -20%);">Summary</h1>
	';
	//


	?>

	
	
<?php 
$success = true;

if ($success)
{
	echo"	
	<div class = 'payment'>
		<div class = 'bill' style='transform:translate(0%, 0%); height: 470px;'>
			<img name = 'success' src ='images/tick.svg' alt =''>
			<p name = 'paymentstatus' ></br>Payment success</p>
			<p name = 'date' >30 March 2023, 11:59pm</p>
			<ul class = 'paymentinfo' style='transform:translate(-4%, 380%); '>
				<li class = 'paymentinfo-row' >Order Number<b>: 000001</b></li>
				<li class = 'paymentinfo-row' >Amount Paid <b>: {$amounttopay}</b></li>
				<li class = 'paymentinfo-row' >Payment Method<b>: Credit/Debit Card</b></li>
			</ul>
			<div style='transform:translate(30%, 550%);'>
				<button class = 'backtohome'><a href ='home.php'>Back to Home</a></button>
			</div>
		</div>
	</div>
	";
	
	
}
else {
	echo"	
	<div class = 'payment'>
		<div class = 'bill' style='transform:translate(0%, 0%); '>
			<img name = 'success' src ='images/tick.svg' alt =''>
			<p name = 'paymentstatus' ></br>Payment failed</p>
			<p name = 'failmsg' >Your payment has failed to go through due to some unforseen errors. <br/><br/>Please try again.</p>
			<div style='transform:translate(35%, 550%);'>
				<button class = 'tryagain'><a href ='upgradeplans.php'>Try Again</a></button>
			</div>
		</div>
	</div>
	";
}

?>

