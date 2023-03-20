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
	
	$userType = $_SESSION['userType'];
	$pricePlan = $_SESSION['currentplan'];
	$daysRemaining = $_SESSION['daysremaining'];
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="generate-ratings-recs_style.css?version15">
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
	document.getElementById("sidewords4").innerHTML="";
	document.getElementById("sidewords5").innerHTML="";
	generate.style.transform = 'translate(-100px, 0px)';
	generate.style.transition = '0.5s';
	document.getElementById("sidewords1").innerHTML="";
	document.getElementById("sidewords2").innerHTML="";
	document.getElementById("sidewords3").innerHTML="";
	
	

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
	document.getElementById("sidewords4").innerHTML="Generate Ratings / Recommendations (REC's Data)";
	document.getElementById("sidewords5").innerHTML="Results";
	document.getElementById("sidewords1").innerHTML="Add Data Set";
	document.getElementById("sidewords2").innerHTML="Uploaded Data Set";
	document.getElementById("sidewords3").innerHTML="Generate Ratings / Recommendations (Your Data)";
	});
	generate.style.transform = 'translate(0px, 0px)';
	
  }
}

function currentLeftSideBarColor (){
	var id =<?php echo json_encode($id); ?>;
	
	if (id == 'intro'){
		document.getElementById("intro").style.backgroundColor = "#c7dbf0";
	}
	else if (id == 'adddata'){
		document.getElementById("adddata").style.backgroundColor = "#c7dbf0";
	}
	else if (id == 'uploadeddata'){
		document.getElementById("uploadeddata").style.backgroundColor = "#c7dbf0";
	}
	else if (id == 'results'){
		document.getElementById("results").style.backgroundColor = "#c7dbf0";
	}
	else if (id == 'generate-recommend'){
		document.getElementById("generaterecommend").style.backgroundColor = "#c7dbf0";
	}
	else if (id == 'generate-recommend-recs'){
		document.getElementById("generaterecommendrecs").style.backgroundColor = "#c7dbf0";
	}
	else if (window.location.href.indexOf("generate-recommend-recs") != -1){
		document.getElementById("generaterecommendrecs").style.backgroundColor = "#c7dbf0";
	}
	else if (window.location.href.indexOf("generate-recommend") != -1){
		document.getElementById("generaterecommend").style.backgroundColor = "#c7dbf0";
	}
	else if (window.location.href.indexOf("generate-ratings-recs") != -1){
		document.getElementById("generaterecommendrecs").style.backgroundColor = "#c7dbf0";
	}
	else if (window.location.href.indexOf("generate-ratings") != -1){
		document.getElementById("generaterecommend").style.backgroundColor = "#c7dbf0";
	}	
	
}

// Get the link element
const link = document.querySelector('a[href="#bottom"]');

// Add a click event listener to the link
link.addEventListener('click', (event) => {
	// Prevent the default link behavior
	event.preventDefault();

	// Get the anchor element
	const anchor = document.querySelector('#bottom');

	// Scroll to the anchor element
	anchor.scrollIntoView({ behavior: 'smooth' });
});
</script>
</head>
<body onload = 'currentLeftSideBarColor ()'>
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
<?php 
if ($userType == '1'){
	echo"
	<div id='mySidenav' class='sidenav' style='width: 250px; height: 530px;'>
	<div class='topsidenav'></div>
	<p style='font-size: 20px; padding-left: 15px; padding-top: 20px; padding-bottom: 10px; background-color:whitesmoke; 'id = 'sidewords2'>Getting Started</p>
	  <a href='workspace.php?id=intro' id = 'intro'>
		<img src='images/rocket.svg' alt='Image 1'>
		<span style='font-size: 16px; font-weight:500;' id = 'sidewords1' >Introduction</span>
	  </a>
		<p style='font-size: 20px; padding-left: 15px; padding-top: 20px; padding-bottom: 10px;'id = 'sidewords2'>Your Data</p>
	  <a href='workspace.php?id=adddata' id=adddata>
		<img src='images/adddata.svg' alt='Image 1'>
		<span style='font-size: 16px; font-weight:500;'id = 'sidewords2'>Add Data Set</span>
	  </a>
	  <a href='workspace.php?id=uploadeddata' id = 'uploadeddata'> 
		<img src='images/uploadeddata.svg' alt='Image 2'>
		<span style='font-size: 16px; font-weight:500;' id = 'sidewords3'>Uploaded Data Set</span>
	  </a>
	  <a href='generate-recommend.php#bottom' id = 'generaterecommend'>
		<img src='images/yourdata.svg' alt='Image 3'>
		<span style='font-size: 16px; font-weight:500;' id = 'sidewords4'>Generate Ratings / Recommendations (Your Data)</span>
	  </a>
	  <p style='font-size: 20px; padding-left: 15px; padding-top: 20px; padding-bottom: 10px;'id = 'sidewords2'>Our Data</p>";
	  echo"
	  <a href='workspace.php?id=addlist#bottom' id = 'addlist'>
		<img src='images/adddata.svg' alt='Image 1'>
		<span style='font-size: 16px; font-weight:500;'id = 'sidewords5'>Add List</span>
	  </a>
	  <a href='workspace.php?id=uploadedlist#bottom' id = 'uploadedlist'>
		<img src='images/uploadeddata.svg' alt='Image 2'>
		<span style='font-size: 16px; font-weight:500;' id = 'sidewords6'>Uploaded List</span>
	  </a>";
	  echo"
	  <a href='generate-recommend-recs.php#bottom' id = 'generaterecommendrecs'>
	  <img src='images/recsdata3.svg' alt='Image 3'>
		<span style='font-size: 16px; font-weight:500;' id = 'sidewords7'>Generate Ratings / Recommendations (REC's Data)</span>
	  </a>
	  <p style='font-size: 20px; padding-left: 15px; padding-top: 20px; padding-bottom: 10px;'id = 'sidewords2'>History</p>
	  <a href='workspace.php?id=results#bottom' id = 'results'>
	  <img src='images/history2.svg' alt='Image 3'>
		<span style='font-size: 16px; font-weight:500;' id = 'sidewords8'>Results</span>
	  </a>
	   <span id='bottom'></span>
	  </br></br></br>
	</div>";
	/*==
	echo"
	<div id='main' class='main' style='margin-left = 200px;'>
		<span id = 'menuwords'></span>
		<img id = 'menu' src='images/left.png' alt='Image 4' onclick='openNav()'>
	</div>";*/

	echo"<div class= 'generate-frame' style= 'margin-top: 35px;'>";
	echo"<div class='generate' id='generate' style='margin-left:435px;' >";
	echo"<div class = 'generate-title'>";
	echo"<a href ='generate-recommend-recs.php#bottom'> <h1 name = 'recommend' style='font-size:30px'> Recommendations</h1></a>";
	echo"<a href = 'generate-ratings-recs.php#bottom'><h1 name = 'ratings' style='font-size:30px'>Ratings Prediction</h1></a>";
	echo"</div></br>";
	echo"<form action='' method='POST'>";
echo"<div class = 'user'>";
echo"User ID:  <input type='text' name = 'user' >";
echo"<div class = 'tooltip1' data-html='true' data-tip='The User ID can be taken from the User Profile URL in the Amazon Web Store.' style='display: inline-block;'>
	<div class = 'hint' style='background-color: lightblue; border-radius: 50%; width: 20px; height: 20px; display: flex; justify-content: center; align-items: center; transform: translate(20%, 00%);'>
		<span style='font-size: 15px; color: white;'>?</span></div>
</div>";
echo"</div>";
echo "<div class = 'product' >
Product ID: <input type='text' id='product' name='product'>
<div class = 'tooltip2' data-html='true' data-tip='The Product ID can be taken from the Product URL in the Amazon Web Store. ' style='display: inline-block;'>
	<div class = 'hint' style='background-color: lightblue; border-radius: 50%; width: 20px; height: 20px; display: flex; justify-content: center; align-items: center; transform: translate(0%, 00%);'>
		<span style='font-size: 15px; color: white;'>?</span></div>
	</div>
</div>";
	echo"<p style='transform: translate(37%, 400%)'><input type='submit' name='generate' value='Generate'></p>";
	echo"</form>";
	echo"</div></div>";
}
else if ($userType == '2'){
	echo"
	<div id='mySidenav' class='sidenav' style='width: 250px; height: 530px;'>
	<div class='topsidenav'></div>
	<p style='font-size: 20px; padding-left: 15px; padding-top: 20px; padding-bottom: 10px; background-color:whitesmoke; 'id = 'sidewords2'>Getting Started</p>
	  <a href='workspace.php?id=intro' id = 'intro'>
		<img src='images/rocket.svg' alt='Image 1'>
		<span style='font-size: 16px; font-weight:500;' id = 'sidewords1' >Introduction</span>
	  </a>
	  <p style='font-size: 20px; padding-left: 15px; padding-top: 20px; padding-bottom: 10px;'id = 'sidewords2'>Our Data</p>";
	   
	  echo"
	  <a href='workspace.php?id=addlist'>
		<img src='images/adddata.svg' alt='Image 1'>
		<span style='font-size: 16px; font-weight:500;'id = 'sidewords5'>Add List</span>
	  </a>
	  <a href='workspace.php?id=uploadedlist'>
		<img src='images/uploadeddata.svg' alt='Image 2'>
		<span style='font-size: 16px; font-weight:500;' id = 'sidewords6'>Uploaded List</span>
	  </a>";
	  echo"
	  <a href='generate-recommend-recs.php#bottom' id = 'generaterecommendrecs'>
	  <img src='images/recsdata3.svg' alt='Image 3'>
		<span style='font-size: 16px; font-weight:500;' id = 'sidewords7'>Generate Ratings / Recommendations (REC's Data)</span>
	  </a>
	  <p style='font-size: 20px; padding-left: 15px; padding-top: 20px; padding-bottom: 10px;'id = 'sidewords2'>History</p>
	  <a href='workspace.php?id=results#bottom' id = 'results'>
	  <img src='images/history2.svg' alt='Image 3'>
		<span style='font-size: 16px; font-weight:500;' id = 'sidewords8'>Results</span>
	  </a>
	  <span id='bottom'></span>
	  </br></br></br>
	</div>";
	/*==
	echo"
	<div id='main' class='main' style='margin-left = 200px;'>
		<span id = 'menuwords'></span>
		<img id = 'menu' src='images/left.png' alt='Image 4' onclick='openNav()'>
	</div>";*/

	echo"<div class= 'generate-frame' style= 'margin-top: 35px;'>";
	echo"<div class='generate' id='generate' style='margin-left:435px;' >";
	echo"<div class = 'generate-title'>";
	echo"<a href ='generate-recommend-recs.php#bottom'> <h1 name = 'recommend' style='font-size:30px'> Recommendations</h1></a>";
	echo"<a href = 'generate-ratings-recs.php#bottom'><h1 name = 'ratings' style='font-size:30px'>Ratings Prediction</h1></a>";
	echo"</div></br>";
	echo"<form action='' method='POST'>";
	echo"<div class = 'user'>";
echo"User ID:  <input type='text' name = 'user' >";
echo"<div class = 'tooltip1' data-html='true' data-tip='The User ID can be taken from the User Profile URL in the Amazon Web Store.' style='display: inline-block;'>
	<div class = 'hint' style='background-color: lightblue; border-radius: 50%; width: 20px; height: 20px; display: flex; justify-content: center; align-items: center; transform: translate(20%, 00%);'>
		<span style='font-size: 15px; color: white;'>?</span></div>
</div>";
echo"</div>";
echo "<div class = 'product' >
Product ID: <input type='text' id='product' name='product'>
<div class = 'tooltip2' data-html='true' data-tip='The Product ID can be taken from the Product URL in the Amazon Web Store.' style='display: inline-block;'>
	<div class = 'hint' style='background-color: lightblue; border-radius: 50%; width: 20px; height: 20px; display: flex; justify-content: center; align-items: center; transform: translate(0%, 00%);'>
		<span style='font-size: 15px; color: white;'>?</span></div>
	</div>
</div>";
	echo"<p style='transform: translate(37%, 400%)'><input type='submit' name='generate' value='Generate'></p>";
	echo"</form>";
	echo"</div></div>";
}
?>