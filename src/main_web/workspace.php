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
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="workspace_style.css?version16">
<link rel="stylesheet" href="style.css"> <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>

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
  var results = document.getElementById("results");
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
	if (id == ''){
		workspace.style.transform = 'translate(-100px, 0px)';
		workspace.style.transition = '0.5s';
	}else if(id == 'adddata'){
		adddataset.style.transform = 'translate(-100px, 0px)';
		adddataset.style.transition = '0.5s';
	}else if (id == 'uploadeddata'){
		uploadeddata.style.transform = 'translate(-100px, 0px)';
		uploadeddata.style.transition = '0.5s';
	}else{
		results.style.transform = 'translate(-100px, 0px)';
		results.style.transition = '0.5s';
	}
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
	if (id == ''){
		workspace.style.transform = 'translate(0px, 0px)';
	}else if(id == 'adddata'){
		adddataset.style.transform = 'translate(0px, 0px)';
	}else if (id == 'uploadeddata'){
		uploadeddata.style.transform = 'translate(0px, 0px)';
	}else {
		results.style.transform = 'translate(0px, 0px)';
	}
	
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
					<li><a class="logout" href="accountsettings.php">Account Settings</a></li>
					<li><a class="logout" href="logout.php">Logout</a></li>
				</div>
			</div>        
		</nav>		
</header>


<?php 
# if organization
if ($userType == '1'){ 
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


	if ($id == ''){
		echo"<title>Workspace</title>";
		echo"<div class='workspace-frame'>";
		echo"<div class='workspace' id='workspace' style='margin-left:250px;' >";
		echo"<p name = 'workspace-title' style='text-align: center; font-size:30px'>Welcome to your Workspace!</p>";
		echo"<p name = 'workspace-description' style='text-align: center; font-size:20px'>This is 
		your workspace. Here, you can get add data, check uploaded data, </br>get your recommendations and check the generated results accordingly.</p>";
		echo"<p name = 'workspace-description3' style='text-align: left; font-size:20px'>&#8226; Add Data Set is to add in your own data.</br></br> 
		&#8226; Uploaded data set is where you manage the data.</br></br>&#8226; Generate Ratings / Recommendations is based off
		using either your own</br> data or REC's own data to generate recommendations and ratings based</br> on the user or product.</br></br>";
		echo"&#8226; Results are the records of whichever that you generated.</p></div></div>";
	}
	else if ($id == 'adddata'){
		echo"<title>Add Data</title>";
		echo"<div class='adddata-frame'>";
		echo"<div class = 'adddataset' id ='adddataset' style='margin-left:250px'>";
		echo"<h1 style='text-align: center'>Add Data Set</h1>";
		echo"<p style='text-align: center'>Upload your data here</p></br>";
		echo"<div class = 'adddataform'>";
		echo"<div class='drag-area'>
    <form style='transform: translate(32%, 0%); action='upload.php' method='post' enctype='multipart/form-data'>
			  <input style='background-color:whitesmoke;border:1px solid lightgrey;'type='file' name='fileToUpload' id='fileToUpload'>
			  <input type='submit' value='Upload File' name='submit'>
			</form>
</div>";
	}else if ($id == 'uploadeddata'){
		echo"<title>Uploaded Data</title>";
		echo"<div class='uploadeddata' id='uploadeddata' style='margin-left:250px;' >";
		echo"<h1 style='text-align: center; font-size:30px'>Uploaded Data Set</h1></div>";
	}else if ($id == 'results'){
		echo"<title>Results</title>";
		echo"<div class='results' id='results' style='margin-left:250px;' >";
		echo"<h1 style='text-align: center; font-size:30px'>Results</h1></div>";
	}
}
#if individual
else if ($userType == '2'){
	echo"
	<div id='mySidenav' class='sidenav' style='width: 250px;'>
	<div class='topsidenav'></div>
	 
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


	if ($id == ''){
		echo"<div class='workspace-frame'>";
		echo"<title>Workspace</title>";
		echo"<div class='workspace' id='workspace' style='margin-left:250px;' >";
		echo"<p name = 'workspace-title' style='text-align: center; font-size:30px'>Welcome to your Workspace!</p>";
		echo"<p name = 'workspace-description' style='text-align: center; font-size:20px'>This is 
		your workspace. Here, you can get your recommendations </br>and check the generated results accordingly.</p>";
		echo"<p name = 'workspace-description2' style='text-align: left; font-size:20px'>&#8226; Generate Ratings / Recommendations is based off
		using REC's own data </br> to generate recommendations and ratings based on the user or product.</br></br>";
		echo"&#8226; Results are the records of whichever that you generated.</p></div></div>";
	}
	else if ($id == 'adddata'){
		echo"<title>Add Data</title>";
		echo"<div class = 'adddataset' id ='adddataset' style='margin-left:250px'>";
		echo"<h1 style='text-align: center'>Add Data Set</h1>";
		echo"<p style='text-align: center'>Upload your data here</p></br>";
		echo"<form style='transform: translate(32%, 0%); action='upload.php' method='post' enctype='multipart/form-data'>
			  <input style='background-color:whitesmoke;border:1px solid lightgrey;'type='file' name='fileToUpload' id='fileToUpload'>
			  <input type='submit' value='Upload File' name='submit'>
			</form></div>";
	}else if ($id == 'uploadeddata'){
		echo"<title>Uploaded Data</title>";
		echo"<div class='uploadeddata' id='uploadeddata' style='margin-left:250px;' >";
		echo"<h1 style='text-align: center; font-size:30px'>Uploaded Data Set</h1></div>";
	}else if ($id == 'results'){
		echo"<title>Results</title>";
		echo"<div class='results' id='results' style='margin-left:250px;' >";
		echo"<h1 style='text-align: center; font-size:30px'>Results</h1></div>";
	}
}
?>
   
</body>
</html> 
