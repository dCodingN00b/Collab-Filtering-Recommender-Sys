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
<title>Upgrade Plans</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
 <link rel="stylesheet" href="upgradeplans_style.css?version18">
<style>
/* width */
::-webkit-scrollbar {
  width: 10px;
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

//
echo'

<div class="payment-ui">
  <div class="circle active">1</div>
  <div class="line"></div>
  <div class="circle">2</div>
  <div class="line"></div>
  <div class="circle">3</div>
</div>
<div class="payment-ui-words">
  <div >Choose Plan</div>
  
  <div style = "color:grey">Payment</div>
 
  <div style = "margin-left:12px;color:grey;">Summary</div>
</div>
<h1 style="text-align:center;transform:translate(0%, -10%);">Upgrade Plans</h1>
';
if ($userType == '1'){
	echo"
	<div class='pricing' id='pricing'>
		<div class='pricing-container'>
			<div class='pricing-box'>
				<img name = 'standard' src ='images/upgrade.svg' alt =''>
				<h2>Standard</h2>
				<p name='intro'>Get more out of the</br> product.</p>
				<p>300 Recommendation Requests</p>
					<p>250MB Uploadable Data</p>
					<p>40 URL Links</p>
				<h3>$14.90 / month</h3>
				<button><a href = 'payment.php?upgrade=standard'>Upgrade to Standard</a></button>
			</div>
			<div class='pricing-box'>
				<img name = 'pro' src ='images/high.svg' alt =''>
				<h2>Pro</h2>
				<p name='intro'>Get the most out of</br> the product.</p>
				<p>1500 Recommendation Requests</p>
					<p>1250MB Uploadable Data</p>
					<p>200 URL Links</p>
				<h3>$49.90 / month</h3>
				<button><a href = 'payment.php?upgrade=pro'>Upgrade to Pro</a></button>
			</div>";
			/*
			<div class='pricing-box'>
				<img name = 'custom' src ='images/custom.svg' alt =''>
				<h2>Custom</h2>
				<p name='intro'>Cost depends on how </br>much you use the product.</p>
				<p>Unlimited Uploadable Data</br>Unlimited Recommendation Requests</p>
				<h3>?? / month</h3>
				<button><a href = ''>Upgrade to Custom</a></button>
			</div>*/
		echo"</div>
	</div>";
}else if ($userType == '2'){
echo"
	<div class='pricing' id='pricing'>
		<div class='pricing-container'>
			<div class='pricing-box'>
					<img name = 'standard' src ='images/upgrade.svg' alt =''>
					<h2>Standard</h2>
					<p name='intro'>Get more out of the</br> product.</p>
					<p>500 Recommendation Requests</p>
					<p>50 URL Links</p>
					<h3>$9.90 / month</h3>
					<button><a href = 'payment.php?upgrade=standard'>Upgrade to Standard</a></button>
			</div>
			<div class='pricing-box'>
				<img name = 'pro' src ='images/high.svg' alt =''>
				<h2>Pro</h2>
				<p name='intro'>Get the most out of</br> the product.</p>
				<p>2500 Recommendation Requests</p>
					<p>250 URL Links</p>
				<h3>$34.90 / month</h3>
				<button><a href = 'payment.php?upgrade=pro'>Upgrade to Pro</a></button>
			</div>";
			/*
			<div class='pricing-box'>
				<img name = 'custom' src ='images/custom.svg' alt =''>
				<h2>Custom</h2>
				<p name='intro'>Cost depends on how </br>much you use the product.</p>
				<p>Unlimited Recommendation Requests</p>
				<h3>?? / month</h3>
				<button><a href = 'indiv_register.php'>Upgrade to Custom</a></button>
			</div>*/
		echo"
		</div>
	</div>";
}
?>
</body>
</html>