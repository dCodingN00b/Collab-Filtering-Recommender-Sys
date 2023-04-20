<?php
	// We need to use sessions, so you should always start sessions using the below code.
	 if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
	
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
<link rel="stylesheet" href="generate-recommend_style.css?version44">
<style>
#menu {
	position: fixed;
	margin-left: 180px;
	margin-top: 3px;
	z-index: 1;
}

li a[name='workspace'] {
	border-bottom: 2px solid lightgreen !important;
}

</style>
<script>
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
	else if (id == 'addlist'){
		document.getElementById("addlist").style.backgroundColor = "#c7dbf0";
	}
	else if (id == 'uploadedlist'){
		document.getElementById("uploadedlist").style.backgroundColor = "#c7dbf0";
	}
}


</script>
</head>
<body onload = 'currentLeftSideBarColor ()'>

<?php 
include('navbar.php');
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
		<span style='font-size: 16px; font-weight:500;'id = 'sidewords5'>Add List of URLs</span>
	  </a>
	  <a href='workspace.php?id=uploadedlist#bottom' id = 'uploadedlist'>
		<img src='images/uploadeddata.svg' alt='Image 2'>
		<span style='font-size: 16px; font-weight:500;' id = 'sidewords6'>Uploaded List of URLs</span>
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
	  </br></br></br>
	</div>";
	/*==
	echo"
	<div id='main' class='main' style='margin-left = 200px;'>
		<span id = 'menuwords'></span>
		<img id = 'menu' src='images/left.png' alt='Image 4' onclick='openNav()'>
	</div>";*/

echo"<div class= 'generate-frame' style = 'margin-top: 35px;'>";
	echo"<div class='generate' id='generate' style='margin-left:435px;' >";
		echo"<div class = 'generate-title'>";
			echo"<a href ='generate-recommend.php'> <h1 name = 'recommend' style='font-size:30px'> Recommendations</h1></a>";
			echo"<a href = 'generate-ratings.php'><h1 name = 'ratings' style='font-size:30px'>Ratings Prediction</h1></a>";
		echo"</div></br>";
		echo"<div class = 'generateform'>";
			echo"<form action='' method='POST'>";
			
			echo 
			"<div class = 'product'>
				Product ID: <input type='text' id='product' name='product'>
<div data-html='true' data-tip='The Product ID can be taken from the second column of your uploaded CSV file. 

Alternatively, you can also pull the Product ID from the product URL in the Amazon Web Store.
' style='display: inline-block;'>
				<div class = 'hint' style='background-color: lightblue; border-radius: 50%; width: 20px; height: 20px; display: flex; justify-content: center; align-items: center;'>
			<span style='font-size: 15px; color: white;'>?</span></div>
				</div>
			</div>";

			echo"<div style = 'margin-top: 80px;'> <span style = 'padding-left: 450px; font-size: 14px; color: #6e6d6d''>How to get <a href = 'http://localhost/fyp/documentation.php?part=howitworks&sub=productid#productid' 
			style = 'text-decoration:underline; color: blue;'>Product ID</a>?</span></div>";
			echo"<div class ='generatebutton'> <input type='submit' name='generate' value='Generate'></div>";
			echo"</form>";
		echo"</div>";
	echo"</div>";
echo"</div>";
?>