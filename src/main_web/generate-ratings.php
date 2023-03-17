<?php
	// We need to use sessions, so you should always start sessions using the below code.
	session_start();
	// If the user is not logged in redirect to the login page...
	if (!isset($_SESSION['loggedin'])) {
		header('Location:login.php');
		exit;
	}
	
	$id = '';
	$option = '';
	if (isset($_GET['id'])){
		$id = $_GET['id'];
	}
	
	if (isset($_GET['option'])){
		$option = $_GET['option'];
	}
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="generate-ratings_style.css?version9">
<style>
#menu {
	position: fixed;
	margin-left: 180px;
	margin-top: 3px;
	z-index: 1;
}
</style>
<script>
function sleep (time) {
  return new Promise((resolve) => setTimeout(resolve, time));
}

function openNav() {
  var sidenav = document.getElementById("mySidenav");
  var main = document.getElementById("main");
  var menu = document.getElementById("menu");
  var menuwords = document.getElementById("menuwords");
  var adddataset = document.getElementById("adddataset");
  var workspace = document.getElementById("workspace");
  var uploadeddata = document.getElementById("uploadeddata");
  var generate = document.getElementById('generate');
  var id =<?php echo json_encode($id); ?>;
  if (sidenav.style.width === "250px") {
    sidenav.style.width = "50px";
	main.style.marginLeft = "0px";
	menu.style.marginLeft = "0px";
	menuwords.innerHTML = "";
	menu.style.transition = "all 0.5s";
	menu.src = "images/menu.png";
	document.getElementById("sidewords1").innerHTML="";
	document.getElementById("sidewords2").innerHTML="";
	document.getElementById("sidewords3").innerHTML="";
	document.getElementById("sidewords4").innerHTML="";
	document.getElementById("sidewords5").innerHTML="";
	generate.style.transform = 'translate(-100px, 0px)';
	generate.style.transition = '0.5s';
	

  } else {
    sidenav.style.width = "250px";
	menuwords.innerHTML = "RECS";
    main.style.marginLeft = "180px";
	menuwords.innerHTML = " ";
	menuwords.style.fontSize = 'x-large';
	menu.src = "images/left.png";
	menu.style.marginLeft = "0px";
	menu.style.transition = "0.5s";
	sleep(100).then(() => {
    // Do something after the sleep!
	document.getElementById("sidewords1").innerHTML="Add Data Set";
	document.getElementById("sidewords2").innerHTML="Uploaded Data Set";
	document.getElementById("sidewords3").innerHTML="Generate Ratings / Recommendations (Your Data)";
	document.getElementById("sidewords4").innerHTML="Generate Ratings / Recommendations (REC's Data)";
	document.getElementById("sidewords5").innerHTML="Results";
	});
	generate.style.transform = 'translate(0px, 0px)';
	
  }
}


</script>
</head>
<body>
<header>
		 <nav>
			<ul class="nav-titles">
				<li name = 'recs'><a name = 'recs' href="home.php">RECS</a></li>      
				<li><a href="workspace.php">Workspace</a></li>
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
echo"
<div id='mySidenav' class='sidenav' style='width: 250px;'>
<div class='topsidenav'></div>
  <a href='workspace.php?id=adddata'>
    <img src='images/adddata.svg' alt='Image 1'>
    <span style='font-size: 18px;'id = 'sidewords1'>Add Data Set</span>
  </a>
  <a href='workspace.php?id=uploadeddata'>
    <img src='images/uploadeddata.svg' alt='Image 2'>
    <span style='font-size: 18px;' id = 'sidewords2'>Uploaded Data Set</span>
  </a>
  <a href='generate-recommend.php'>
    <img src='images/yourdata.svg' alt='Image 3'>
    <span style='font-size: 18px;' id = 'sidewords3'>Generate Ratings / Recommendations (Your Data)</span>
  </a>
  <a href='generate-recommend-recs.php'>
  <img src='images/recsdata3.svg' alt='Image 3'>
    <span style='font-size: 18px;' id = 'sidewords4'>Generate Ratings / Recommendations (REC's Data)</span>
  </a>
  <a href='workspace.php?id=results'>
  <img src='images/history2.svg' alt='Image 3'>
    <span style='font-size: 18px;' id = 'sidewords5'>Results</span>
  </a>
</div>";
echo"
<div id='main' class='main' style='margin-left = 200px;'>
	<span id = 'menuwords'></span>
	<img id = 'menu' src='images/left.png' alt='Image 4' onclick='openNav()'>
</div>";

echo"<div class= 'generate-frame'>";
echo"<div class='generate' id='generate' style='margin-left:435px;' >";
echo"<div class = 'generate-title'>";
echo"<a href ='generate-recommend.php'> <h1 name = 'recommend' style='font-size:30px'> Recommendations</h1></a>";
echo"<a href = 'generate-ratings.php'><h1 name = 'ratings' style='font-size:30px'>Ratings Prediction</h1></a>";
echo"</div></br>";
echo"<form action='' method='POST'>";
echo"<p style='transform: translate(125%, 200%);display: inline-block;'>User:  <input type='text' name = 'user' ></p>";
echo"<p style='transform: translate(150%, 200%);display: inline-block;'>Product:  <input type='text' name = 'product' ></p>";
echo"<p style='transform: translate(37%, 400%)'><input type='submit' name='generate' value='Generate'></p>";
echo"</form>";
echo"</div></div>";
?>