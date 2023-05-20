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
	
	if (!isset($_POST['product'])){
		$_POST['product'] = '';
	}
	
	if (!isset($_POST['user'])){
		$_POST['user'] = '';
	}
	
	$user_id = $_SESSION['id'];
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="generate-ratings-recs_style.css?version23">
<title>Workspace</title>
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

.loader {
  border: 15px solid #f3f3f3; /* Light grey */
  border-top: 15px solid #3498db; /* Blue */
  border-radius: 50%;
  width: 40px;
  height: 40px;
  animation: spin 2s linear infinite;
 
}

.loader2 {
  border: 15px solid #f3f3f3; /* Light grey */
  border-top: 15px solid #3498db; /* Blue */
  border-radius: 50%;
  width: 40px;
  height: 40px;
  animation: spin 2s linear infinite;
 
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
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
	else if (window.location.href.indexOf("generate-recommend-url") != -1){
		document.getElementById("generaterecommendurl").style.backgroundColor = "#c7dbf0";
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
	else if (window.location.href.indexOf("generate-ratings-url") != -1){
		document.getElementById("generaterecommendurl").style.backgroundColor = "#c7dbf0";
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

<?php 
include('navbar.php');
if ($_SESSION['pricePlan'] == '0'){
	// Set the total number of recommendations
	$total_recommendations = 50;
	$total_url = 20;
	
	//find start and end date
	$startDate = $userinfo['dateTimeOfCreation'];
	$endDate = $userinfo['freeTrialExpiryDate'];
	
	// Set the total number of recommendations
	$total_data = 15;
	}
	else if ($_SESSION['pricePlan'] == 'i1'){
		// Set the total number of recommendations
		$total_recommendations = 500;
		$total_url = 50;
		$startDate = $userinfo['startDate'];
		$endDate = $userinfo['expiryDate'];
	}
	else if ($_SESSION['pricePlan'] == 'i2'){
		// Set the total number of recommendations
		$total_recommendations = 2500;
		$total_url = 250;
		$startDate = $userinfo['startDate'];
		$endDate = $userinfo['expiryDate'];
		
	}
	else if ($_SESSION['pricePlan'] == 'o1'){
		// Set the total number of recommendations
		$total_recommendations = 300;
		$total_url = 40;
		$startDate = $userinfo['startDate'];
		$endDate = $userinfo['expiryDate'];
		
		// Set the total number of recommendations
		$total_data = 1 * 250;
	}
	else if ($_SESSION['pricePlan'] == 'o2'){
		// Set the total number of recommendations
		$total_recommendations = 1500;
		$total_url = 200;
		$startDate = $userinfo['startDate'];
		$endDate = $userinfo['expiryDate'];
		// Set the total number of recommendations
		$total_data = 5 * 250;
	}
	else {
		// Set the total number of recommendations
		$total_recommendations = 0;
		$total_data = 0;
		$total_url = 0;
	}

if ($userType == '1'){
	echo"
	<div id='mySidenav' class='sidenav' style='width: 250px; height: 100%;'>
	<div class='topsidenav'></div>
	<p style='font-size: 20px; padding-left: 15px; padding-top: 20px; padding-bottom: 10px; background-color:whitesmoke; 'id = 'sidewords2'>Getting Started</p>
	  <a href='workspace.php?id=discover' id = 'discover'>
		<img src='images/view.svg' alt='Image 1'>
		<span style='font-size: 16px; font-weight:500;' id = 'sidewords1' >Discover</span>
	  </a>
	  <a href='workspace.php?id=instructions' id = 'instructions'>
		<img src='images/rocket.svg' alt='Image 1'>
		<span style='font-size: 16px; font-weight:500;' id = 'sidewords1' >Instructions</span>
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
	   <a href='generate-recommend-url.php#bottom' id = 'generaterecommendurl'>
	  <img src='images/urllist.svg' alt='Image 3'>
		<span style='font-size: 16px; font-weight:500;' id = 'sidewords8'>Generate Ratings / Recommendations (Uploaded URL)</span>
	  </a>
	  <a href='generate-recommend-recs.php#bottom' id = 'generaterecommendrecs'>
	  <img src='images/recsdata3.svg' alt='Image 3'>
		<span style='font-size: 16px; font-weight:500;' id = 'sidewords7'>Generate Ratings / Recommendations (RECS' Data)</span>
	  </a>
	  <p style='font-size: 20px; padding-left: 15px; padding-top: 20px; padding-bottom: 10px;'id = 'sidewords2'>History</p>
	  <a href='workspace.php?id=results#bottom' id = 'results'>
	  <img src='images/history2.svg' alt='Image 3'>
		<span style='font-size: 16px; font-weight:500;' id = 'sidewords8'>Results</span>
	  </a>
	   <span id='bottom'></span>
	  </br></br></br>
	  </br></br></br>
	</div>";
	/*==
	echo"
	<div id='main' class='main' style='margin-left = 200px;'>
		<span id = 'menuwords'></span>
		<img id = 'menu' src='images/left.png' alt='Image 4' onclick='openNav()'>
	</div>";*/
echo "<div style='display: flex; justify-content: center;'>";	
	echo"<div class= 'generate-frame' style= 'margin-top: 35px;'>";
	echo"<div class='generate' id='generate' style='margin-left:250px;' >";
	echo"<div class = 'generate-title'>";
	echo"<a href ='generate-recommend-url.php#bottom'> <h1 name = 'recommend' style='font-size:30px'> Recommendations</h1></a>";
	echo"<a href = 'generate-ratings-url.php#bottom'><h1 name = 'ratings' style='font-size:30px'>Ratings Prediction</h1></a>";
	echo"</div></br>";
	echo"<form action='' method='POST' id = 'generateratingrecsform'>";
echo"<div class = 'container'>";
echo"<div class = 'user' style='transform:translate(0%, 180%); text-align: center;'>";
echo"User ID:  <input type='text' name = 'user' id = 'user' value = '{$_POST['user']}' required>";
echo"<div class = 'tooltip1' data-html='true' data-tip='The User ID can be taken from the User Profile URL in the Amazon Web Store.' style='display: inline-block;'>
	<div class = 'hint' style='background-color: lightblue; border-radius: 50%; width: 20px; height: 20px; display: flex; justify-content: center; align-items: center; transform: translate(20%, 00%);'>
		<span style='font-size: 15px; color: white;'>?</span></div>
</div>";
echo"</div>";
echo "<div class = 'product' style='transform:translate(10%, 180%); text-align: center;'>
Product ID: <input type='text' id='product' name='product' value = '{$_POST['product']}' required>
<div class = 'tooltip2' data-html='true' data-tip='The Product ID can be taken from your uploaded TXT file.' style='display: inline-block;'>
	<div class = 'hint' style='background-color: lightblue; border-radius: 50%; width: 20px; height: 20px; display: flex; justify-content: center; align-items: center; transform: translate(0%, 00%);'>
		<span style='font-size: 15px; color: white;'>?</span></div>
	</div>
</div></div>";
echo"<div style = 'margin-top: 80px;text-align: center;'> <span style = 'font-size: 14px; color: #6e6d6d''>How to get <a href = 'documentation.php?part=howitworks&sub=userid#userid' 
			style = 'text-decoration:underline; color: blue;'>User ID</a> and <a href = 'documentation.php?part=howitworks&sub=productid#productid' 
			style = 'text-decoration:underline; color: blue;'>Product ID</a> ?</span></div>";
	echo"<div class = 'generatebutton'><input type='submit' name='generate' id = 'generatebutton' value='Generate'></div>";
	echo"</form>";
	echo'<div id="result" class = "result" name="result" style = "transform:translate(0%, 800%);"></div>
			<div class="loader" id = "loader" style = "margin-top: 120px; margin-left: 310px;" hidden></div>';
			
	if (file_exists("uploads/$user_id/crawled")){
			$directory = "uploads/$user_id/crawled/";
			$filecount = count(glob($directory . "*"));
		}
		else {
			$filecount = 0;
		}
		
		if ($filecount > 0 ){
			$fileExists = true;
		}
		else{
			$fileExists = false;
		}  
	/*if(isset($_POST['generate'])){
		
			$newTotal = $userinfo['recoPerMonth'] + 1;
			if ($newTotal > $total_recommendations){
				echo "
					<div style = 'transform:translate(7%, 650%)'>
						You have exceeded the recommendation limit.
					</div>
					";
				exit();
			}
					
			$productid = $_POST['product'];
			$userid = $_POST['user'];
			//$output = file_get_contents("http://3.25.54.194/dashboard/fyp/test.py");
			//$output = file_get_contents("http://3.25.54.194/dashboard/fyp/svdpp_csv_videogames_reco.py");
			
			if (file_exists("uploads/$user_id/crawled")){
				$directory = "uploads/$user_id/crawled/";
				$filecount = count(glob($directory . "*"));
			}
			else {
				$filecount = 0;
			}
			
			if ($filecount > 0 ){
				$fileExists = true;
			}
			else{
				$fileExists = false;
			}  
			
			
			$out = array();
			
			if ($fileExists == false){
			
				exec("C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/svdpp_inputs_5csv_code.py C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/computers C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/electronics C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/toys C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/videogames C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/pets product $productid user $userid", $out, $return);
			
			}
			else {
				
				exec("C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/svdpp_inputs_6csv.py C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/computers C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/electronics C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/toys C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/videogames C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/pets C:/xampp/htdocs/dashboard/FYP/uploads/$user_id/crawled product $productid user $userid", $out, $return);
				
			}
			
			if ($return != 0)
			{
				echo "
				<div style = 'transform:translate(25%, 650%)'>
				Product ID or User ID usage incorrect, please try again
				</div>
				";
			}
			else {
				$output = implode(" ", $out);
			
				$output = trim($output);
				$temp = strpos($output, ".");
				
				
				echo "
				<div style = 'transform:translate(25%, 550%)'>"

					. substr($output, 0, $temp + 5) . "<br/>" .
				"</div>
				";
				
				echo "
				<div style = 'transform:translate(15%, 570%)'>"

					. substr($output, $temp + 5) . 
				"</div>
				";
				
				
				unset ($_POST['generate']);
				$temp2 = strrpos($output, ":");
				$rating = substr($output, $temp2 + 2, 2);
				$rating = trim($rating);
				$user = new User();
				$user->createResultsFromRating ($userid, $productid, $rating, 4, $user_id);
				$user->updateRecoForMonth ($user_id);
			}
	
	}*/

	echo"</div></div>";
}
else if ($userType == '2'){
	echo"
	<div id='mySidenav' class='sidenav' style='width: 250px; height: 100%;'>
	<div class='topsidenav'></div>
	<p style='font-size: 20px; padding-left: 15px; padding-top: 20px; padding-bottom: 10px; background-color:whitesmoke; 'id = 'sidewords2'>Getting Started</p>
	  <a href='workspace.php?id=discover' id = 'discover'>
		<img src='images/view.svg' alt='Image 1'>
		<span style='font-size: 16px; font-weight:500;' id = 'sidewords1' >Discover</span>
	  </a>
	  <a href='workspace.php?id=instructions' id = 'instructions'>
		<img src='images/rocket.svg' alt='Image 1'>
		<span style='font-size: 16px; font-weight:500;' id = 'sidewords1' >Instructions</span>
	  </a>
	  <p style='font-size: 20px; padding-left: 15px; padding-top: 20px; padding-bottom: 10px;'id = 'sidewords2'>Our Data</p>";
	   
	  echo"
	  <a href='workspace.php?id=addlist'>
		<img src='images/adddata.svg' alt='Image 1'>
		<span style='font-size: 16px; font-weight:500;'id = 'sidewords5'>Add List of URLs</span>
	  </a>
	  <a href='workspace.php?id=uploadedlist'>
		<img src='images/uploadeddata.svg' alt='Image 2'>
		<span style='font-size: 16px; font-weight:500;' id = 'sidewords6'>Uploaded List of URLs</span>
	  </a>";
	  echo"
	   <a href='generate-recommend-url.php#bottom' id = 'generaterecommendurl'>
	  <img src='images/urllist.svg' alt='Image 3'>
		<span style='font-size: 16px; font-weight:500;' id = 'sidewords8'>Generate Ratings / Recommendations (Uploaded URL)</span>
	  </a>
	  <a href='generate-recommend-recs.php#bottom' id = 'generaterecommendrecs'>
	  <img src='images/recsdata3.svg' alt='Image 3'>
		<span style='font-size: 16px; font-weight:500;' id = 'sidewords7'>Generate Ratings / Recommendations (RECS' Data)</span>
	  </a>
	  <p style='font-size: 20px; padding-left: 15px; padding-top: 20px; padding-bottom: 10px;'id = 'sidewords2'>History</p>
	  <a href='workspace.php?id=results#bottom' id = 'results'>
	  <img src='images/history2.svg' alt='Image 3'>
		<span style='font-size: 16px; font-weight:500;' id = 'sidewords8'>Results</span>
	  </a>
	  <span id='bottom'></span>
	  </br></br></br>
	   </br></br></br>
	</div>";
	/*==
	echo"
	<div id='main' class='main' style='margin-left = 200px;'>
		<span id = 'menuwords'></span>
		<img id = 'menu' src='images/left.png' alt='Image 4' onclick='openNav()'>
	</div>";*/
echo "<div style='display: flex; justify-content: center;'>";
	echo"<div class= 'generate-frame' style= 'margin-top: 35px;'>";
	echo"<div class='generate' id='generate' style='margin-left:250px;' >";
	echo"<div class = 'generate-title'>";
	echo"<a href ='generate-recommend-url.php#bottom'> <h1 name = 'recommend' style='font-size:30px'> Recommendations</h1></a>";
	echo"<a href = 'generate-ratings-url.php#bottom'><h1 name = 'ratings' style='font-size:30px'>Ratings Prediction</h1></a>";
	echo"</div></br>";
	echo"<form action='' method='POST' id = 'generateratingrecsform2'>";
echo"<div class = 'container'>";
	echo"<div class = 'user' style='transform:translate(0%, 180%); text-align: center;'>";
echo"User ID:  <input type='text' name = 'user' id = 'user2' value = '{$_POST['user']}' required>";
echo"<div class = 'tooltip1' data-html='true' data-tip='The User ID can be taken from the User Profile URL in the Amazon Web Store.' style='display: inline-block;'>
	
	<div class = 'hint' style='background-color: lightblue; border-radius: 50%; width: 20px; height: 20px; display: flex; justify-content: center; align-items: center; transform: translate(20%, 00%);'>
		<span style='font-size: 15px; color: white;'>?</span></div>
</div>";
echo"</div>";
echo "<div class = 'product' style='transform:translate(10%, 180%); text-align: center;'>
Product ID: <input type='text' id='product2' name='product' value = '{$_POST['product']}' required>
<div class = 'tooltip2' data-html='true' data-tip='The Product ID can be taken from the Product URL in the Amazon Web Store.' style='display: inline-block;'>
	<div class = 'hint' style='background-color: lightblue; border-radius: 50%; width: 20px; height: 20px; display: flex; justify-content: center; align-items: center; transform: translate(0%, 00%);'>
		<span style='font-size: 15px; color: white;'>?</span></div>
	</div>
</div></div>";
	echo"<div style = 'margin-top: 80px;text-align: center;' > <span style = 'font-size: 14px; color: #6e6d6d''>How to get <a href = 'documentation.php?part=howitworks&sub=userid#userid' 
			style = 'text-decoration:underline; color: blue;'>User ID</a> and <a href = 'documentation.php?part=howitworks&sub=productid#productid' 
			style = 'text-decoration:underline; color: blue;'>Product ID</a> ?</span></div>";
	echo"<div class = 'generatebutton' style = 'text-align: center;'><input type='submit' name='generate' id = 'generatebutton2' value='Generate'></div>";
	echo"</form>";
	echo'<div id="resultv2" class = "result" name="result" style = "transform:translate(0%, 800%);"></div>
			<div class="loader" id = "loader2" style = "margin-top: 120px; margin-left: 310px;" hidden></div>';
	
	if (file_exists("uploads/$user_id/crawled")){
		$directory = "uploads/$user_id/crawled/";
		$filecount = count(glob($directory . "*"));
	}
	else {
		$filecount = 0;
	}
	
	if ($filecount > 0 ){
		$fileExists = true;
	}
	else{
		$fileExists = false;
	}  
			
	/*
	if(isset($_POST['generate'])){
	
			$newTotal = $userinfo['recoPerMonth'] + 1;
			if ($newTotal > $total_recommendations){
				echo "
					<div style = 'transform:translate(7%, 650%)'>
						You have exceeded the recommendation limit.
					</div>
					";
				exit();
			}
			$productid = $_POST['product'];
			$userid = $_POST['user'];
			//$output = file_get_contents("http://3.25.54.194/dashboard/fyp/test.py");
			//$output = file_get_contents("http://3.25.54.194/dashboard/fyp/svdpp_csv_videogames_reco.py");
			if (file_exists("uploads/$user_id/crawled")){
				$directory = "uploads/$user_id/crawled/";
				$filecount = count(glob($directory . "*"));
			}
			else {
				$filecount = 0;
			}
			
			if ($filecount > 0 ){
				$fileExists = true;
			}
			else{
				$fileExists = false;
			}  
			
			$out = array();
			
			if ($fileExists == false){
			
				exec("C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/svdpp_inputs_5csv_code.py C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/computers C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/electronics C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/toys C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/videogames C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/pets product $productid user $userid", $out, $return);
			
			}
			else {
				
				exec("C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/svdpp_inputs_6csv.py C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/computers C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/electronics C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/toys C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/videogames C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/pets C:/xampp/htdocs/dashboard/FYP/uploads/$user_id/crawled product $productid user $userid", $out, $return);
				
			}
			
			if ($return != 0)
			{
				echo "
				<div style = 'transform:translate(25%, 650%)'>
				Product ID or User ID usage incorrect, please try again
				</div>
				";
			}
			else {
				$output = implode(" ", $out);
			
				$output = trim($output);
				$temp = strpos($output, ".");
				
				
				echo "
				<div style = 'transform:translate(25%, 550%)'>"

					. substr($output, 0, $temp + 5) . "<br/>" .
				"</div>
				";
				
				echo "
				<div style = 'transform:translate(15%, 570%)'>"

					. substr($output, $temp + 5) . 
				"</div>
				";
				
				
				unset ($_POST['generate']);
				$temp2 = strrpos($output, ":");
				$rating = substr($output, $temp2 + 2, 2);
				$rating = trim($rating);
				$user = new User();
				$user->createResultsFromRating ($userid, $productid, $rating, 4, $user_id);
				$user->updateRecoForMonth ($user_id);
			}
		
	}*/
	
	echo"</div></div>";
}
?>
 <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
	$("#generateratingrecsform").submit(function(event) {
		// Prevent the form from submitting normally
		event.preventDefault();
		
		var fileExists = <?php echo json_encode($fileExists); ?>;
		var userid = <?php echo json_encode($user_id); ?>; 			
		//show loading animation and hide button
		$("#loader").show();
		$("#generatebutton").hide();
		// Get the command from the input field
		var product = $("#product").val();
		var user = $("#user").val();
		
		var command = '';
		var type = 'urldata';
		
		
			command = "C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/svdpp_inputs_5csv.py C:/xampp/htdocs/dashboard/FYP/uploads/" + userid + "/crawled/computers/ C:/xampp/htdocs/dashboard/FYP/uploads/" + userid + "/crawled/electronics C:/xampp/htdocs/dashboard/FYP/uploads/" + userid + "/crawled/toys C:/xampp/htdocs/dashboard/FYP/uploads/" + userid + "/crawled/videogames C:/xampp/htdocs/dashboard/FYP/uploads/" + userid + "/crawled/pets product " + product + " user " + user;
		/*if (fileExists == false){
		}
		else {
			
			command = "C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/svdpp_inputs_6csv.py C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/computers C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/electronics C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/toys C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/videogames C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/pets C:/xampp/htdocs/dashboard/FYP/uploads/" + userid + "/crawled/ product " + product + " user " + user;
			
		}*/

		// Send an AJAX request to the PHP script
		$.ajax({
			url: "execute_command_rating.php",
			type: "POST",
			data: {command: command, userid: userid, product: product, user: user, type: type},
			dataType: "text",
			success: function(output) {
				$("#loader").hide();
				$("#generatebutton").show();
				// Display the output in the result area
				$("#result").html(output);
			},
			error: function(xhr, status, error) {
				$("#loader").hide();
				$("#generatebutton").show();
				// Display an error message
				alert("Error: " + error);
			}
		});
	});
});

$(document).ready(function() {
	$("#generateratingrecsform2").submit(function(event) {
		// Prevent the form from submitting normally
		event.preventDefault();
		
		var fileExists = <?php echo json_encode($fileExists); ?>;
		var userid = <?php echo json_encode($user_id); ?>; 			
		//show loading animation and hide button
		$("#loader2").show();
		$("#generatebutton2").hide();
		// Get the command from the input field
		var product = $("#product2").val();
		var user = $("#user2").val();
		
		var command = '';
		var type = 'urldata';
		
		
			command = "C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/svdpp_inputs_5csv.py C:/xampp/htdocs/dashboard/FYP/uploads/" + userid + "/crawled/computers/ C:/xampp/htdocs/dashboard/FYP/uploads/" + userid + "/crawled/electronics C:/xampp/htdocs/dashboard/FYP/uploads/" + userid + "/crawled/toys C:/xampp/htdocs/dashboard/FYP/uploads/" + userid + "/crawled/videogames C:/xampp/htdocs/dashboard/FYP/uploads/" + userid + "/crawled/pets product " + product + " user " + user;
		/*if (fileExists == false){
		}
		else {
			
			command = "C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/svdpp_inputs_6csv.py C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/computers C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/electronics C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/toys C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/videogames C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/pets C:/xampp/htdocs/dashboard/FYP/uploads/" + userid + "/crawled/ product " + product + " user " + user;
			
		}*/

		// Send an AJAX request to the PHP script
		$.ajax({
			url: "execute_command_rating.php",
			type: "POST",
			data: {command: command, userid: userid, product: product, user: user, type: type},
			dataType: "text",
			success: function(output) {
				$("#loader2").hide();
				$("#generatebutton2").show();
				// Display the output in the result area
				$("#resultv2").html(output);
			},
			error: function(xhr, status, error) {
				$("#loader2").hide();
				$("#generatebutton2").show();
				// Display an error message
				alert("Error: " + error);
			}
		});
	});
});

</script>
</body>