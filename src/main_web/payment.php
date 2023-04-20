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
	$userType = $_SESSION['userType'];
	
	
	if (isset($_GET['upgrade'])){
		$upgradeplan = $_GET['upgrade'];
	}else {
		$upgradeplan = '';
	}
?>

<!DOCTYPE html>
<html>
<head>
<title>Payment</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
 <link rel="stylesheet" href="payment_style.css?version23">
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
  <div class="circle active">2</div>
  <div class="line"></div>
  <div class="circle">3</div>
</div>
<div class="payment-ui-words">
  <div style = "color:grey">Choose Plan</div>
  
  <div >Payment</div>
 
  <div style = "margin-left:12px;color:grey;">Summary</div>
</div>
<h1 style="text-align:center; transform:translate(0%, -20%);">Select Payment Method</h1>
';
//
$valid = true;
if (isset($_POST['submit']) and ($_POST['submit'] == 'Pay') and $valid){
	//validation
	$_SESSION['amounttopay'] = $_POST['amounttopay'];
	
	if ($userType == '1' and $upgradeplan == 'standard'){
		$pricePlan = 'o1';
	}
	else if ($userType == '1' and $upgradeplan == 'pro'){
		$pricePlan = 'o2';
	}
	else if ($userType == '2' and $upgradeplan == 'standard'){
		$pricePlan = 'i1';
	}
	else if ($userType == '2' and $upgradeplan == 'pro'){
		$pricePlan = 'i2';
	}
	
	$user = new User();
	$user->createTransaction($userid, $pricePlan, $_POST['amounttopay']);
	$userinfo = $user->getLatestTransactionInfo ($userid);
	$user->upgradePlans ($pricePlan, $userid, $userinfo['startDate'], $userinfo['expiryDate']);
	
	$_SESSION['pricePlan'] = $pricePlan;
	header('location:summary.php');
}
?>
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
				<?php 
				if ($userType == '1')
				{	
					if ($upgradeplan == 'pro'){
						echo '<input type="text" name="amounttopay" value = "$49.90" hidden />';
					}
					else if ($upgradeplan == 'standard'){
						echo '<input type="text" name="amounttopay" value = "$14.90" hidden />';
					}
				}
				else if ($userType == '2'){
					if ($upgradeplan == 'pro'){
						echo '<input type="text" name="amounttopay" value = "$34.90" hidden />';
					}
					else if ($upgradeplan == 'standard'){
						echo '<input type="text" name="amounttopay" value = "$9.90" hidden />';
					}
				}
				?>
				</br><input type="submit" name = "submit" value="Pay">
			</form>
	</div>
<?php 

if ($userType == '1')
{
	if ($upgradeplan == 'pro'){
		echo"
		<div class = 'bill' style='transform:translate(60%, -205%); '>
			<img name = 'pro' src ='images/high.svg' alt =''>
			<h2 name = 'upgradetype'>Pro</h2>
			<p name = 'benefits' >50GB Uploadable Data</br>5000 Recommendation Requests</p>
			<h2 name = 'amounttopay'>Amount to pay:</h2>
			<p name = 'company'>Company: RECS</p>
			<p name ='ordernumber'>Order Number: 000001</p>
			<p name = 'amount'>SGD$49.90</p>	
		</div>
		";
	}
	else if ($upgradeplan == 'standard')
	{
		echo"
		<div class = 'bill' style='transform:translate(60%, -205%); '>
			<img name = 'standard' src ='images/upgrade.svg' alt =''>
			<h2 name = 'upgradetype2'>Standard</h2>
			<p name = 'benefits' >10GB Uploadable Data</br>1000 Recommendation Requests</p>
			<h2 name = 'amounttopay'>Amount to pay:</h2>
			<p name = 'company'>Company: RECS</p>
			<p name ='ordernumber'>Order Number: 000001</p>
			<p name = 'amount'>SGD$14.90</p>	
		</div>
		";
	}
}
else if ($userType == '2') 
{
	if ($upgradeplan == 'pro')
	{
		echo"
		<div class = 'bill' style='transform:translate(60%, -205%); '>
			<img name = 'pro' src ='images/high.svg' alt =''>
			<h2 name = 'upgradetype'>Pro</h2>
			<p name = 'benefits' ></br>10000 Recommendation Requests</p>
			<h2 name = 'amounttopay'>Amount to pay:</h2>
			<p name = 'company'>Company: RECS</p>
			<p name ='ordernumber'>Order Number: 000001</p>
			<p name = 'amount'>SGD$34.90</p>	
		</div>
		";
	}
	else if ($upgradeplan == 'standard')
	{
		echo"
		<div class = 'bill' style='transform:translate(60%, -205%); '>
			<img name = 'standard' src ='images/upgrade.svg' alt =''>
			<h2 name = 'upgradetype2'>Standard</h2>
			<p name = 'benefits' ></br>2000 Recommendation Requests</p>
			<h2 name = 'amounttopay'>Amount to pay:</h2>
			<p name = 'company'>Company: RECS</p>
			<p name ='ordernumber'>Order Number: 000001</p>
			<p name = 'amount'>SGD$9.90</p>	
		</div>
		";
	}
}
?>
</div>
