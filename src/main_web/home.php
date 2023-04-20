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
 <link rel="stylesheet" href="home_style.css?version25">
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
<body>
<?php 


/*
if (!isset($_SESSION['visited'])) {
  // User is visiting for the first time, prompt for interests and age
  ?>
  <div id="overlay" style="position:fixed;top:0;left:0;width:100%;height:100%;background-color:rgba(0,0,0,0.5);z-index:9999;"></div>
  <form method="POST" style="position:absolute;top:50%;left:50%;transform: translate(-50%, -50%);border: 2px solid black;border-radius: 10px;padding:50px 20px;z-index:10000;background-color: aliceblue;">
    <label for="interests">What are your interests?</label><br>
    <input type="text" id="interests" name="interests" required><br><br>

    <label for="age">What is your age?</label><br>
    <input type="number" id="age" name="age" required ><br><br>
	
    <input type="submit" value="Submit" onclick="document.getElementById('overlay').style.pointerEvents = 'auto';">
  </form>
  <?php

  // Set session flag to indicate that the user has visited before
	//$_SESSION['visited'] = true;
}
*/


if ($userType == '1') #org (client)
{
	include('navbar.php');
?>
	<div class="landscape-container">
		<div class="welcome-box">
		  <h1 class = 'welcome' >Welcome back, <?=$_SESSION['name']?> (Org)!</h1>
		  <img src="images/welcome.svg" alt="Landscape image">
		</div>
		<div class = "content-container">
			<div class="activity-box">
			  <h1 class = 'activity' >Let's start now! Head towards</br> your workspace!</h1>
			  <button><a href ='workspace.php'>Workspace</a></button>
			</div>
			<div class="doc-box">
			  <h1 class = 'doc' >Want to understand</br> RECS better?</h1>
			  <div>
			  <button style= 'transform:translate(-13%, 0%);'><a href ='main.php?id=howitworks'>How It Works</a></button>
			  <button><a href ='http://localhost/fyp/documentation.php?part=introduction'>Documentation</a></button></div>
			</div>
		</div>
	<div>
<?php 
}else if ($userType == '2') #indiv (customer)
{ 
	include('navbar.php');
?>
	
	<div class="landscape-container">
		<div class="welcome-box">
		  <h1 class = 'welcome' >Welcome back, <?=$_SESSION['name']?> (Individual)!</h1>
		  <img src="images/welcome.svg" alt="Landscape image">
		</div>
		<div class = "content-container">
			<div class="activity-box">
			  <h1 class = 'activity' >Let's start now! Head towards</br> your workspace!</h1>
			  <button><a href ='workspace.php'>Workspace</a></button>
			</div>
			<div class="doc-box">
			  <h1 class = 'doc' >Want to understand</br> RECS better?</h1>
			  <div>
			  <button style= 'transform:translate(-13%, 0%);'><a href ='main.php?id=howitworks'>How It Works</a></button>
			  <button><a href ='http://localhost/fyp/documentation.php?part=introduction'>Documentation</a></button></div>
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
                    <li style='margin-left: auto;'><a name = 'adminmanage' href="manageaccounts.php" style = 'margin-right: 60px;'>Manage Accounts</a>
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
