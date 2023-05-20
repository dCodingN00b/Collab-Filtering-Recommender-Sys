<?php
	// We need to use sessions, so you should always start sessions using the below code.
	session_start();
	// If the user is not logged in redirect to the login page...
	if (!isset($_SESSION['loggedin'])) {
		header('Location:login.php');
		exit;
	}
	
	$userType = $_SESSION['userType'];
	if (isset($_GET['userid'])){
		$userid = $_GET['userid'];
	}
	else{
		$userid = '';
	}
?>
<!DOCTYPE html>
<html>	
<head>
<title>Manage User</title>
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <link rel="stylesheet" href="manageuser_style.css?version18">
<script>
document.addEventListener('DOMContentLoaded', () => {
    $('.alert').alert()
  })
</script>
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
</style>
</head>
<!-- change of button (all, admin, org, ind) based on current url-->
<body>
<?php
include ('inc_db_fyp.php');
include ('user.php');

if ($userType == '0') #admin
{
	#get user info by calling user entity method and display info
	$user = new User();
	$row = $user-> getUserInfo ($userid);
	$membership = $user->calculateMemberDuration ($userid);
	$membership = substr($membership, 0, 2);
	$month = floor($membership / 30);
	$day = $membership - (30 * $month);

#header, top navbar
?>
	<header>
		 <nav>
			<ul class="nav-titles">
				<li name = 'recs'><a name = 'recs' href="home.php">RECS</a></li>     
			    <li style='margin-left: auto;'><a name = 'adminmanage' href="manageaccounts.php" style = 'margin-right: 60px; border-bottom: 2px solid lightgreen;'>Manage Accounts</a>
				<a name = 'admincreate' href="createaccount.php?id=orgcreateacc" style = 'margin-right: 60px;'>Create Account</a></li>
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
	<h1>Manage User</h1>
	
<?php 
		//display membership duration (not just current one)
		echo"<div style = 'transform:translate(0%, -210%)'><p style ='font-size:20px; font-weight: 500;;'><center>Membered for: $month Month $day Days</center></p></div>";
		
		//show current plan, days remaining
		if ($row['pricePlan'] != '0' and $row['pricePlan'] != 'None')
		{
			$daysLeft = floor((strtotime($row['expiryDate']) - time()) / 86400);
			echo"<div style = 'transform:translate(0%, -210%)'><p style ='font-size:20px; font-weight: 500;;'><center>Current Plan: $daysLeft Days Left</center></p></div>";
		}
		else if ($row['pricePlan'] == '0')
		{
			$daysLeft = floor((strtotime($row['freeTrialExpiryDate']) - time()) / 86400);
			echo"<div style = 'transform:translate(0%, -210%)'><p style ='font-size:20px; font-weight: 500;;'><center>Free Trial: $daysLeft Days Left</center></p></div>";
		}
		



#check is update button is clicked and update user info accordingly
if (isset($_POST['submit']) and ($_POST['submit'] == 'Confirm')){
	$pricePlan = $_POST['priceplan'];
	$accountStatus= $_POST['accstatus'];
	
	#call user entity method
	$user-> manageUser ($pricePlan, $accountStatus, $userid);
	header("Location: manageaccounts.php");
	
	if ($pricePlan == 'i1'){
		$amountToPay = "$9.90";
	}
	else if ($pricePlan == 'i1'){
		$amountToPay = "$9.90";
	}
	else if($pricePlan == 'o1'){
		$amountToPay = "$14.90";
	}
	else if ($pricePlan == 'o2'){
		$amountToPay = "$49.90";
	}
	
	if ($pricePlan != 'None' and $pricePlan != '0'){
		$user->createTransaction($userid, $pricePlan, '$0');
		$userinfo = $user->getLatestTransactionInfo ($userid);
		$user->upgradePlans ($pricePlan, $userid, $userinfo['startDate'], $userinfo['expiryDate']);
	}
}



echo"
<div class = 'frame'>
<div class = 'reg'>
<form action = '' method = 'POST'>

		<div class = 'text_field'>
			<span>User ID:</span><input type='text' name='userid' value = '{$row["userID"]}' style = 'color:grey; background-color:whitesmoke' readonly />
		</div>
		<div class = 'text_field'>
			<span>Email:</span><input type='email' name='email' value = '{$row["emailAddress"]}' style = 'color:grey; background-color:whitesmoke' readonly />
		</div>
		<div class = 'text_field'>
			<span>Name: </span><input type='text' name='name' value = '{$row["name"]}' style = 'color:grey; background-color:whitesmoke' readonly />
		</div>
		<div class = 'text_field'>
			<span>User Type: </span><input type='text' name='userType'" . (($row["userType"] == '1')? 'value = "Organization"' :
				(($row["userType"] == '2')? 'value = "Individual"' : 'value = "Admin"')) . "style = 'color:grey; background-color:whitesmoke' readonly />
		</div>
	";
		$dateTime = substr($row["dateTimeOfCreation"], 0, 19);
		if ($row['userType'] == '1' or $row['userType'] == '2'){ 
			echo"
		
			<div class = 'text_field'>
				<span>Date Joined: </span><input type='text' name='name' value = '$dateTime ' style = 'color:grey; background-color:whitesmoke' readonly />
			</div>
			<div class = 'text_field'>
				<span>Current Price Plan: </span>
				<select name='priceplan' id='priceplan' class = 'priceplan'>";
				
				if ($row['userType'] == '2'){
					echo"
						<option value='none'" .(($row['pricePlan'] == 'None')? 'selected="selected"' : '') . ">None</option>
						<option value='0'" .(($row['pricePlan'] == '0')? 'selected="selected"' : '') . ">Free Trial</option>
						<option value='i1'" . (($row['pricePlan'] == 'i1')? 'selected="selected"' : '') . ">Individual - Standard</option>
						<option value='i2'" . (($row['pricePlan'] == 'i2')? 'selected="selected"' : '') . ">Individual - Pro</option>";
						#<option value='i3'" . (($row['pricePlan'] == 'i3')? 'selected="selected"' : '') . ">Individual - Custom</option>";
				}
				else{
					echo"
					<option value='none'" .(($row['pricePlan'] == 'none')? 'selected="selected"' : '') . ">None</option>
					<option value='0'" .(($row['pricePlan'] == '0')? 'selected="selected"' : '') . ">Free Trial</option>
						<option value='o1'" . (($row['pricePlan'] == 'o1')? 'selected="selected"' : '') . ">Organization - Standard</option>
						<option value='o2'" . (($row['pricePlan'] == 'o2')? 'selected="selected"' : '') . ">Organization - Pro</option>";
						#<option value='o3'" . (($row['pricePlan'] == 'o3')? 'selected="selected"' : '') . ">Organization - Custom</option>";
				}
				echo"
				</select>
			</div>";
		}
		echo"
			<div class = 'text_field'>
				<span>Account Status: </span>
				<select name='accstatus' id='accstatus' class = 'accstatus'>
				  <option value='Available'" .(($row['accountStatus'] == 'Available')? 'selected="selected"' : '') . ">Available</option>
				  <option value='Suspended'" . (($row['accountStatus'] == 'Suspended')? 'selected="selected"' : '') . ">Suspended</option>
				</select>
			</div>

		

		</br>
		<input type='button' value='Cancel' onclick='history.back()'>
		<input type='submit' name = 'submit' value='Confirm'>
</form>
</div></div>";
}



?>

</body>