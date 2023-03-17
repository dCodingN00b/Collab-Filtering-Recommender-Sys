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
<link rel="stylesheet" href="workspace_style.css?version5">
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
	if (id == ''){
		workspace.style.transform = 'translate(-100px, 0px)';
		workspace.style.transition = '0.5s';
	}else if(id == 'adddata'){
		adddataset.style.transform = 'translate(-100px, 0px)';
		adddataset.style.transition = '0.5s';
	}else{
		uploadeddata.style.transform = 'translate(-100px, 0px)';
		uploadeddata.style.transition = '0.5s';
	}
	

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
	document.getElementById("sidewords3").innerHTML="Generate Ratings / Recommendations";
	document.getElementById("sidewords4").innerHTML="";
	});
	if (id == ''){
		workspace.style.transform = 'translate(0px, 0px)';
	}else if(id == 'adddata'){
		adddataset.style.transform = 'translate(0px, 0px)';
	}else{
		uploadeddata.style.transform = 'translate(0px, 0px)';
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
  <a href='adddataset.php'>
    <img src='images/add.png' alt='Image 1'>
    <span style='font-size: 18px;'id = 'sidewords1'>Add Data Set</span>
  </a>
  <a href='uploaddataset.php'>
    <img src='images/refresh.png' alt='Image 2'>
    <span style='font-size: 18px;' id = 'sidewords2'>Uploaded Data Set</span>
  </a>
  <a href='generate-recommend.php'>
    <img src='images/star.png' alt='Image 3'>
    <span style='font-size: 18px;' id = 'sidewords3'>Generate Ratings / Recommendations</span>
  </a>
  <a href='#'>
    <span style='font-size: 18px;' id = 'sidewords4'></span>
  </a>
</div>";
echo"
<div id='main' class='main' style='margin-left = 200px;'>
	<span id = 'menuwords'></span>
	<img id = 'menu' src='images/left.png' alt='Image 4' onclick='openNav()'>
</div>";

echo"<div class='workspace' id='workspace' style='margin-left:250px;' >";
echo"<p style='text-align: center; font-size:30px'>Welcome to your Workspace!</p></div>";

echo"<div class = 'adddataset' id ='adddataset' style='margin-left:250px'>";
echo"<h1 style='text-align: center'>Add Data Set</h1>";
echo"<p style='text-align: center'>Upload your data here</p></br>";
echo"<form style='transform: translate(32%, 0%); action='upload.php' method='post' enctype='multipart/form-data'>
	  <input style='background-color:whitesmoke;border:1px solid lightgrey;'type='file' name='fileToUpload' id='fileToUpload'>
	  <input type='submit' value='Upload File' name='submit'>
	</form></div>";


}
?>
   
</body>
</html> 
