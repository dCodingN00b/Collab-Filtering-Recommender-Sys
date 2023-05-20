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
	$user_id = $_SESSION['id'];
	

	
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="generate-recommend-recs_style.css?version21">
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

.error {
	text-align: center;
	transform:translate(0%, 0%);
}

.image-grid {
    display: grid;
    grid-template-columns: repeat(5, 0fr);
    grid-gap: 10px;
	justify-content: center;
	align-items: center;
	transform:translate(0%, 0%);
  }
  
  .recoimage {
    display: flex;
    flex-direction: column;
    align-items: center;
  }
  
  .recoimage img {
    width: 30%;
    height: auto;
  }
  
  .recoimage a {
    margin-top: 10px;
    text-align: center;
  }
  
  .recotitle {
	  text-align:center;
	  transform:translate(0%, 0%);
  }
  
 .tooltip {
	 
 }

/* Tooltip text */
.tooltip .tooltiptext {
  visibility: hidden;
  width: 220px;
  background-color: lightblue;
  color: black
  text-align: center;
  padding: 10px 10px;
  border: 1px solid black;
  border-radius: 6px;
 
  /* Position the tooltip text - see examples below! */
  position: absolute;
  z-index: 1;
  transform: translate(-50%, 0%);
}

/* Show the tooltip text when you mouse over the tooltip container */
.tooltip:hover .tooltiptext {
  visibility: visible;
}
</style>
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
	else if (window.location.href.indexOf("generate-recommend-url") != -1){
		document.getElementById("generaterecommendurl").style.backgroundColor = "#c7dbf0";
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


$categoryCount = 1;
$userinfo = $user -> getUserInfo($user_id);
$categoryOne = trim(strtolower($userinfo['categoryOne']));
$categoryOne  = str_replace(' ', '', $categoryOne);

if ($userinfo['categoryTwo'] != ""){
	$categoryCount += 1;
	$categoryTwo = trim(strtolower($userinfo['categoryTwo']));
	$categoryTwo  = str_replace(' ', '', $categoryTwo);
}
else {
	$categoryTwo = '';
}
if ($userinfo['categoryThree'] != ""){
	$categoryCount += 1;
	$categoryThree = trim(strtolower($userinfo['categoryThree']));
	$categoryThree  = str_replace(' ', '', $categoryThree);
}
else {
	$categoryThree = '';
}
if ($userinfo['categoryFour'] != ""){
	$categoryCount += 1;
	$categoryFour = trim(strtolower($userinfo['categoryFour']));
	$categoryFour  = str_replace(' ', '', $categoryFour);
}
else{
	$categoryFour = '';
}
if ($userinfo['categoryFive'] != ""){
	$categoryCount += 1;
	$categoryFive = trim(strtolower($userinfo['categoryFive']));
	$categoryFive = str_replace(' ', '', $categoryFive);
}
else {
	$categoryFive = '';
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
	  <a href='generate-recommend.php' id = 'generaterecommend'>
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
	  <span id='bottom'></span>
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
			echo"<form action='' method='POST' id = 'generaterecommendrecsform'>";
			echo 
			"<div class = 'product' style='transform:translate(0%, 180%); text-align: center;'>
				Product ID: <input type='text' id='product' name='product' value = '{$_POST['product']}' required>
                <div data-html='true' data-tip='The Product ID can be taken from the product URL in the Amazon Web Store.
                ' style='display: inline-block;'>
				<div class = 'hint' style='background-color: lightblue; border-radius: 50%; width: 20px; height: 20px; display: flex; justify-content: center; align-items: center;'>
			<span style='font-size: 15px; color: white;'>?</span></div>
				</div>
			</div>";
			echo"<div style = 'margin-top: 80px; text-align: center'> <span style = 'font-size: 14px; color: #6e6d6d''>How to get <a href = 'documentation.php?part=howitworks&sub=productid#productid' 
			style = 'text-decoration:underline; color: blue;'>Product ID</a>?</span></div>";
			echo"<div class = 'generatebutton'><input type='submit' name='generate' id = 'generatebutton' value='Generate' style=' text-align: center;'></div>";
			echo"</form>";
			echo'
			<div class="loader" id = "loader" style = "margin-top: 120px; margin-left: 310px;" hidden></div>';
			
			echo"
				<div class='recotitle' id = 'result' style ='margin-top: 150px;'></div>
				<br/><br/><br/>
				<div class='recotitle' id = 'result0' ></div>
				<div class='error' id = 'error0' ></div>
				<div class='image-grid' style ='margin-top: 20px;'>
				 
			  <div class='recoimage' id = 'result1'>
				
			   
			  </div>
			  <div class='recoimage' id = 'result2'>
				
			  </div>
			  <div class='recoimage' id = 'result3'>
				
			  </div>
			  <div class='recoimage' id = 'result4'>
				
			  </div>
			  <div class='recoimage' id = 'result5'>
				
			  </div>
			  
			  <br/> <br/> <br/> <br/>
			</div>";
			echo"	
				<div class='recotitle' id = 'result02'></div>
				<div class='error' id = 'error2' ></div>
				<div class='image-grid' style ='margin-top: 20px;'>
				 
			  <div class='recoimage' id = 'result12'>
				
			   
			  </div>
			  <div class='recoimage' id = 'result22'>
				
			  </div>
			  <div class='recoimage' id = 'result32'>
				
			  </div>
			  <div class='recoimage' id = 'result42'>
				
			  </div>
			  <div class='recoimage' id = 'result52'>
				
			  </div>
			  
			  <br/> <br/> <br/> <br/>
			</div>";
			echo"	
				<div class='recotitle' id = 'result03'></div>
				<div class='error' id = 'error3' ></div>
				<div class='image-grid' style ='margin-top: 20px;'>
				 
			  <div class='recoimage' id = 'result13'>
				
			   
			  </div>
			  <div class='recoimage' id = 'result23'>
				
			  </div>
			  <div class='recoimage' id = 'result33'>
				
			  </div>
			  <div class='recoimage' id = 'result43'>
				
			  </div>
			  <div class='recoimage' id = 'result53'>
				
			  </div>
			  
			  <br/> <br/> <br/> <br/>
			</div>";
			echo"	
				<div class='recotitle' id = 'result04'></div>
				<div class='error' id = 'error4' ></div>
				<div class='image-grid' style ='margin-top: 20px;'>
				 
			  <div class='recoimage' id = 'result14'>
				
			   
			  </div>
			  <div class='recoimage' id = 'result24'>
				
			  </div>
			  <div class='recoimage' id = 'result34'>
				
			  </div>
			  <div class='recoimage' id = 'result44'>
				
			  </div>
			  <div class='recoimage' id = 'result54'>
				
			  </div>
			  
			  <br/> <br/> <br/> <br/>
			</div>";
			echo"	
				<div class='recotitle' id = 'result05'></div>
				<div class='error' id = 'error5' ></div>
				<div class='image-grid' style ='margin-top: 20px;'>
				 
			  <div class='recoimage' id = 'result15'>
				
			   
			  </div>
			  <div class='recoimage' id = 'result25'>
				
			  </div>
			  <div class='recoimage' id = 'result35'>
				
			  </div>
			  <div class='recoimage' id = 'result45'>
				
			  </div>
			  <div class='recoimage' id = 'result55'>
				
			  </div>
			  
			  <br/> <br/> <br/> <br/>
			</div>";
			
			if (file_exists("uploads/$user_id/crawled")){
				$directory = "uploads/$user_id/crawled/";
				$filecount = count(glob($directory . "*.csv"));
				
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
			
				

			#detect if generatee button press and if input isn't empty
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
					$out = array();
		
					
					#use different svdd file based on number of categories
					if ($categoryCount == 1 and $fileExists == false){
						exec("C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/svdpp_input_csv.py C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/$categoryOne product $productid 5", $out, $return);
						
					}
					else if ($categoryCount == 2 and $fileExists == false){
						exec("C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/svdpp_inputs_2csv.py C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/$categoryOne C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/$categoryTwo product $productid 5", $out, $return);
						
						
					}
					else if ($categoryCount == 3 and $fileExists == false){
						exec("C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/svdpp_inputs_3csv.py C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/$categoryOne C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/$categoryTwo C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/$categoryThree product $productid 5", $out, $return);
						
						
					}
					else if ($categoryCount == 4 and $fileExists == false){
						exec("C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/svdpp_inputs_4csv.py C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/$categoryOne C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/$categoryTwo C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/$categoryThree C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/$categoryFour product $productid 5", $out, $return);
						
						
					}
					else if ($categoryCount == 5 and $fileExists == false){
						exec("C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/svdpp_inputs_5csv_code.py C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/$categoryOne C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/$categoryTwo C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/$categoryThree C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/$categoryFour C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/$categoryFive product $productid 5", $out, $return);
	
					}
					else if ($categoryCount == 1 and $fileExists == true){
						exec("C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/svdpp_inputs_2csv.py C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/$categoryOne C:/xampp/htdocs/dashboard/FYP/uploads/$user_id/crawled product $productid 5", $out, $return);

					}
					else if ($categoryCount == 2 and $fileExists == true){
						exec("C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/svdpp_inputs_3csv.py C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/$categoryOne C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/$categoryTwo C:/xampp/htdocs/dashboard/FYP/uploads/$user_id/crawled product $productid 5", $out, $return);

					}
					else if ($categoryCount == 3 and $fileExists == true){
						exec("C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/svdpp_inputs_4csv.py C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/$categoryOne C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/$categoryTwo C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/$categoryThree C:/xampp/htdocs/dashboard/FYP/uploads/$user_id/crawled product $productid 5", $out, $return);

					}
					else if ($categoryCount == 4 and $fileExists == true){
						exec("C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/svdpp_inputs_5csv_code.py C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/$categoryOne C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/$categoryTwo C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/$categoryThree C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/$categoryFour C:/xampp/htdocs/dashboard/FYP/uploads/$user_id/crawled product $productid 5", $out, $return);

					}
					else if ($categoryCount == 5 and $fileExists == true){
						exec("C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/svdpp_inputs_6csv.py C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/$categoryOne C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/$categoryTwo C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/$categoryThree C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/$categoryFour C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/$categoryFive C:/xampp/htdocs/dashboard/FYP/uploads/$user_id/crawled product $productid 5", $out, $return);
						
					}
					
					if ($return != 0)
					{
						echo "
						<div style = 'transform:translate(28%, 650%)'>
						Product ID usage incorrect, please try again
						</div>
						";
					}
					else {
						$output = implode(" ", $out);
						echo "
						<div style = 'transform:translate(7%, 650%)'>
							$output
						</div>
						";
						
						unset ($_POST['generate']);
						
						$output = trim($output);
						$temp1 = strpos($output, ":");
						$reco1 = substr($output, $temp1 + 5, 10);
						$reco2 = substr($output, $temp1 + 18, 10);
						$reco3 = substr($output, $temp1 + 31, 10);
						$reco4 = substr($output, $temp1 + 44, 10);
						$reco5 = substr($output, $temp1 + 57, 10);
						
						$user = new User();
						$user->createResultsFromReco ($productid, $reco1, $reco2, $reco3, $reco4, $reco5, 3, $user_id);
						$user->updateRecoForMonth ($user_id);
					}
				
			}
			
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
	  <a href='generate-recommend-recs.php' id = 'generaterecommendrecs'>
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
			echo"<form action='' method='POST' id = 'generaterecommendrecsform2'>";
			echo 
			"<div class = 'product' style='transform:translate(0%, 180%); text-align: center;'>
				Product ID: <input type='text' id='product2' name='product' value = '{$_POST['product']}' required>
                <div data-html='true' data-tip='The Product ID can be taken from the product URL in the Amazon Web Store.
                ' style='display: inline-block;'>
				<div class = 'hint' style='background-color: lightblue; border-radius: 50%; width: 20px; height: 20px; display: flex; justify-content: center; align-items: center;'>
			<span style='font-size: 15px; color: white;'>?</span></div>
				</div>
			</div>";
			echo"<div style = 'margin-top: 80px; text-align: center;'> <span style = 'font-size: 14px; color: #6e6d6d''>How to get <a href = 'documentation.php?part=howitworks&sub=productid#productid' 
			style = 'text-decoration:underline; color: blue;'>Product ID</a>?</span></div>";
			echo"<div class = 'generatebutton'><input type='submit' name='generate' id = 'generatebutton2' value='Generate' style = 'text-align: center;'></div>";
			echo"</form>";
			echo'<div class="loader" id = "loader" style = "margin-top: 120px; margin-left: 310px;" hidden></div>';
			
			echo"
				<div class='recotitle' id = 'result' style ='margin-top: 150px;'></div>
				<br/><br/><br/>
				<div class='recotitle' id = 'result0' ></div>
				<div class='error' id = 'error0' ></div>
				<div class='image-grid' style ='margin-top: 20px;'>
				 
			  <div class='recoimage' id = 'result1'>
				
			   
			  </div>
			  <div class='recoimage' id = 'result2'>
				
			  </div>
			  <div class='recoimage' id = 'result3'>
				
			  </div>
			  <div class='recoimage' id = 'result4'>
				
			  </div>
			  <div class='recoimage' id = 'result5'>
				
			  </div>
			  
			  <br/> <br/> <br/> <br/>
			</div>";
			echo"	
				<div class='recotitle' id = 'result02'></div>
				<div class='error' id = 'error2' ></div>
				<div class='image-grid' style ='margin-top: 20px;'>
				 
			  <div class='recoimage' id = 'result12'>
				
			   
			  </div>
			  <div class='recoimage' id = 'result22'>
				
			  </div>
			  <div class='recoimage' id = 'result32'>
				
			  </div>
			  <div class='recoimage' id = 'result42'>
				
			  </div>
			  <div class='recoimage' id = 'result52'>
				
			  </div>
			  
			  <br/> <br/> <br/> <br/>
			</div>";
			echo"	
				<div class='recotitle' id = 'result03'></div>
				<div class='error' id = 'error3' ></div>
				<div class='image-grid' style ='margin-top: 20px;'>
				 
			  <div class='recoimage' id = 'result13'>
				
			   
			  </div>
			  <div class='recoimage' id = 'result23'>
				
			  </div>
			  <div class='recoimage' id = 'result33'>
				
			  </div>
			  <div class='recoimage' id = 'result43'>
				
			  </div>
			  <div class='recoimage' id = 'result53'>
				
			  </div>
			  
			  <br/> <br/> <br/> <br/>
			</div>";
			echo"	
				<div class='recotitle' id = 'result04'></div>
				<div class='error' id = 'error4' ></div>
				<div class='image-grid' style ='margin-top: 20px;'>
				 
			  <div class='recoimage' id = 'result14'>
				
			   
			  </div>
			  <div class='recoimage' id = 'result24'>
				
			  </div>
			  <div class='recoimage' id = 'result34'>
				
			  </div>
			  <div class='recoimage' id = 'result44'>
				
			  </div>
			  <div class='recoimage' id = 'result54'>
				
			  </div>
			  
			  <br/> <br/> <br/> <br/>
			</div>";
			echo"	
				<div class='recotitle' id = 'result05'></div>
				<div class='error' id = 'error5' ></div>
				<div class='image-grid' style ='margin-top: 20px;'>
				 
			  <div class='recoimage' id = 'result15'>
				
			   
			  </div>
			  <div class='recoimage' id = 'result25'>
				
			  </div>
			  <div class='recoimage' id = 'result35'>
				
			  </div>
			  <div class='recoimage' id = 'result45'>
				
			  </div>
			  <div class='recoimage' id = 'result55'>
				
			  </div>
			  
			  <br/> <br/> <br/> <br/>
			</div>";
			
			
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
			
	echo"</div></div>";
}
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

$(document).ready(function() {
		$("#generaterecommendrecsform").submit(function(event) {
			// Prevent the form from submitting normally
			event.preventDefault();
			
			var userid = <?php echo json_encode($user_id); ?>; 
			var categoryCount = <?php echo json_encode($categoryCount); ?>;
			
			var categoryOne = <?php echo json_encode($categoryOne); ?>; 	
			var categoryTwo = <?php echo json_encode($categoryTwo); ?>; 	
			var categoryThree = <?php echo json_encode($categoryThree); ?>; 	
			var categoryFour = <?php echo json_encode($categoryFour); ?>; 	
			var categoryFive = <?php echo json_encode($categoryFive); ?>; 	
			//console.log(typeof fileExists);
			//console.log(categoryOne);
			//show loading animation and hide button
			$("#loader").show();
			$("#generatebutton").hide();
			// Get the command from the input field
			var product = $("#product").val();
			var type = 'urldata';
				//console.log(fileExists);
//			var command = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/svdpp_input_csv.py C:/xampp/htdocs/dashboard/FYP/uploads/' + userid + '/data product ' + product + ' 5';
			var command = "";
			var command2 = "";
			var command3 = "";
			var command4 = "";
			var command5 = "";
		
			
			if (categoryCount == 1){
					
				command = "C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/svdpp_input_csv.py C:/xampp/htdocs/dashboard/FYP/uploads/" + userid + "/crawled/" + categoryOne + "/ product " + product + " 5";
				
			}
			else if (categoryCount == 2){
				command = "C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/svdpp_input_csv.py C:/xampp/htdocs/dashboard/FYP/uploads/" + userid + "/crawled/" + categoryOne + "/ product " + product + " 5";
				command2 = "C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/svdpp_input_csv.py C:/xampp/htdocs/dashboard/FYP/uploads/" + userid + "/crawled/" + categoryTwo + "/ product " + product + " 5";
			}
			else if (categoryCount == 3){
				command = "C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/svdpp_input_csv.py C:/xampp/htdocs/dashboard/FYP/uploads/" + userid + "/crawled/" + categoryOne + "/ product " + product + " 5";
				command2 = "C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/svdpp_input_csv.py C:/xampp/htdocs/dashboard/FYP/uploads/" + userid + "/crawled/" + categoryTwo + "/ product " + product + " 5";
				command3 = "C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/svdpp_input_csv.py C:/xampp/htdocs/dashboard/FYP/uploads/" + userid + "/crawled/" + categoryThree + "/ product " + product + " 5";
				
			}
			else if (categoryCount == 4){
				command = "C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/svdpp_input_csv.py C:/xampp/htdocs/dashboard/FYP/uploads/" + userid + "/crawled/" + categoryOne + "/ product " + product + " 5";
				command2 = "C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/svdpp_input_csv.py C:/xampp/htdocs/dashboard/FYP/uploads/" + userid + "/crawled/" + categoryTwo + "/ product " + product + " 5";
				command3 = "C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/svdpp_input_csv.py C:/xampp/htdocs/dashboard/FYP/uploads/" + userid + "/crawled/" + categoryThree + "/ product " + product + " 5";
				command4 = "C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/svdpp_input_csv.py C:/xampp/htdocs/dashboard/FYP/uploads/" + userid + "/crawled/" + categoryFour + "/ product " + product + " 5";
				
			}
			else if (categoryCount == 5){
				command = "C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/svdpp_input_csv.py C:/xampp/htdocs/dashboard/FYP/uploads/" + userid + "/crawled/" + categoryOne + "/ product " + product + " 5";
				command2 = "C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/svdpp_input_csv.py C:/xampp/htdocs/dashboard/FYP/uploads/" + userid + "/crawled/" + categoryTwo + "/ product " + product + " 5";
				command3 = "C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/svdpp_input_csv.py C:/xampp/htdocs/dashboard/FYP/uploads/" + userid + "/crawled/" + categoryThree + "/ product " + product + " 5";
				command4 = "C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/svdpp_input_csv.py C:/xampp/htdocs/dashboard/FYP/uploads/" + userid + "/crawled/" + categoryFour + "/ product " + product + " 5";
				command5 = "C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/svdpp_input_csv.py C:/xampp/htdocs/dashboard/FYP/uploads/" + userid + "/crawled/" + categoryFive + "/ product " + product + " 5";
				
			}
			/*else if (categoryCount == 1 && fileExists == true){
				command = "C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/svdpp_inputs_2csv.py C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/" + categoryOne + "/ C:/xampp/htdocs/dashboard/FYP/uploads/" + userid + "/crawled/ product " + product + " 5";

			}
			else if (categoryCount == 2 && fileExists == true){
				command = "C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/svdpp_inputs_3csv.py C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/" + categoryOne + "/ C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/" + categoryTwo + "/ C:/xampp/htdocs/dashboard/FYP/uploads/" + userid + "/crawled/ product " + product + " 5";

			}
			else if (categoryCount == 3 && fileExists == true){
				command = "C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/svdpp_inputs_4csv.py C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/" + categoryOne + "/ C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/" + categoryTwo + "/ C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/" + categoryThree + "/ C:/xampp/htdocs/dashboard/FYP/uploads/" + userid + "/crawled/ product " + product + " 5";

			}
			else if (categoryCount == 4 && fileExists == true){
				command ="C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/svdpp_inputs_5csv_code.py C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/" + categoryOne + "/ C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/" + categoryTwo + "/ C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/" + categoryThree + "/ C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/" + categoryFour + "/ C:/xampp/htdocs/dashboard/FYP/uploads/" + userid + "/crawled/ product " + product +  " 5";

			}
			else if (categoryCount == 5 && fileExists == true){
				command ="C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/svdpp_inputs_6csv.py C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/" + categoryOne + "/ C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/" + categoryTwo + "/ C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/" + categoryThree + "/ C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/" + categoryFour + "/ C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/" + categoryFive + "/ C:/xampp/htdocs/dashboard/FYP/uploads/" + userid + "/crawled/ product " + product + " 5";
				
			}*/

			// Send an AJAX request to the PHP script
			$.ajax({
				url: "execute_command_recommend.php",
				type: "POST",
				data: {command: command, command2: command2, command3: command3, command4: command4, command5: command5, userid: userid, product: product, type: type, categoryOne: categoryOne, categoryTwo: categoryTwo, categoryThree: categoryThree, categoryFour: categoryFour, categoryFive: categoryFive, categoryCount: categoryCount},
				dataType: "json",
				success: function(result) {
					var output = result['data'];
					$("#loader").hide();
					$("#generatebutton").show();
					
					if (output[0].includes("exist"))
					{
						$("#result").html(output[0]);
					}
					else 
					{
					$("#result").html("<h3><u>Recommendations: </u></h3>");
					
					
					//output the results depending on number of categories
					//$("#result").html( "<p style='display: inline-block; vertical-align: middle;'>" + output[1] + "</p><iframe src='" + output[12] + "' style='border:0px #ffffff none; display: inline-block; vertical-align: middle;margin-left: 70px;' scrolling='no' ></iframe>");
					
					
					if (output[0].includes("usage")){
						$("#error0").html(output[0]);
						
					}
					else if (output[0].includes("upload"))
					{
						$("#result0").html("<h3>" + (categoryOne == 'videogames'? 'Video Games': capitalizeFirstLetter(categoryOne)) + ": </h3>");	
						$("#error0").html(output[0]);
					}
					else if (output.length == 32)
					{
						$("#result0").html("<h3>" + (categoryOne == 'videogames'? 'Video Games': capitalizeFirstLetter(categoryOne)) + ": </h3>");						
						$("#result1").html( "<div class='tooltip'><a style = 'text-decoration: underline; color: blue;' href = '" + output[12] + "'>"+ output[14] +"</a><span class='tooltiptext'>" + output[15] + "</span></div><img src='" + output[13] + "' style='width: 150px; height: 150px; margin-top: 10px;'>");
						$("#result2").html( "<div class='tooltip'><a style = 'text-decoration: underline; color: blue; ' href = '" + output[16] + "'>"+ output[18] +"</a><span class='tooltiptext'>" + output[19] + "</span></div><img src='" + output[17] + "' style='width: 150px; height: 150px; margin-top: 10px;'>");
						$("#result3").html( "<div class='tooltip'><a style = 'text-decoration: underline; color: blue; ' href = '" + output[20] + "'>"+ output[22] +"</a><span class='tooltiptext'>" + output[23] + "</span></div><img src='" + output[21] + "' style='width: 150px; height: 150px; margin-top: 10px;'>");
						$("#result4").html( "<div class='tooltip'><a style = 'text-decoration: underline; color: blue; ' href = '" + output[24] + "'>"+ output[26] +"</a><span class='tooltiptext'>" + output[27] + "</span></div><img src='" + output[25] + "' style='width: 150px; height: 150px; margin-top: 10px;'>");
						$("#result5").html( "<div class='tooltip'><a style = 'text-decoration: underline; color: blue; ' href = '" + output[28] + "'>"+ output[30] +"</a><span class='tooltiptext'>" + output[31] + "</span></div><img src='" + output[29] + "' style='width: 150px; height: 150px; margin-top: 10px;'>");
					}
					else {
						$("#result0").html("<h3>" + (categoryOne == 'videogames'? 'Video Games': capitalizeFirstLetter(categoryOne)) + ": </h3>");	
						//$("#result0").html("<h3>" + (categoryOne == 'videogames'? 'Video Games': capitalizeFirstLetter(categoryOne)) + ": </h3>");					
						$("#error0").html("The crawled result of this category does not the meet the requirement. <br/> There should be at least 5 different products. Please crawl more products before trying again." );
					}
					
					if (categoryCount > 1) {
						var output2 = result['data2'];
						
						$("#result02").html("<h3>" + (categoryTwo == 'videogames'? 'Video Games': capitalizeFirstLetter(categoryTwo)) + ": </h3>");
						if (output2[0].includes("usage")){
							$("#error2").html(output2[0]);
						}
						else if (output2[0].includes("upload"))
						{
							$("#error2").html(output2[0]);
						}
						else if (output2.length == 32)
						{
							
							$("#result12").html( "<div class='tooltip'><a style = 'text-decoration: underline; color: blue;' href = '" + output2[12] + "'>"+ output2[14] +"</a><span class='tooltiptext'>" + output2[15] + "</span></div><img src='" + output2[13] + "' style='width: 150px; height: 150px; margin-top: 10px;'>");
							$("#result22").html( "<div class='tooltip'><a style = 'text-decoration: underline; color: blue; ' href = '" + output2[16] + "'>"+ output2[18] +"</a><span class='tooltiptext'>" + output2[19] + "</span></div><img src='" + output2[17] + "' style='width: 150px; height: 150px; margin-top: 10px;'>");
							$("#result32").html( "<div class='tooltip'><a style = 'text-decoration: underline; color: blue; ' href = '" + output2[20] + "'>"+ output2[22] +"</a><span class='tooltiptext'>" + output2[23] + "</span></div><img src='" + output2[21] + "' style='width: 150px; height: 150px; margin-top: 10px;'>");
							$("#result42").html( "<div class='tooltip'><a style = 'text-decoration: underline; color: blue; ' href = '" + output2[24] + "'>"+ output2[26] +"</a><span class='tooltiptext'>" + output2[27] + "</span></div><img src='" + output2[25] + "' style='width: 150px; height: 150px; margin-top: 10px;'>");
							$("#result52").html( "<div class='tooltip'><a style = 'text-decoration: underline; color: blue; ' href = '" + output2[28] + "'>"+ output2[30] +"</a><span class='tooltiptext'>" + output2[31] + "</span></div><img src='" + output2[29] + "' style='width: 150px; height: 150px; margin-top: 10px;'>");
						}
						else {
							//$("#result02").html("<h3>" + (categoryTwo == 'videogames'? 'Video Games': capitalizeFirstLetter(categoryTwo)) + ": </h3>");
							$("#error2").html("The crawled result of this category does not the meet the requirement. <br/> There should be at least 5 different products. Please crawl more products before trying again." );
						}
					}
					
					if (categoryCount > 2) {
						var output3 = result['data3'];
						$("#result03").html("<h3>" + (categoryThree == 'videogames'? 'Video Games': capitalizeFirstLetter(categoryThree)) + ": </h3>");
						
						if (output3[0].includes("usage")){
						$("#error3").html(output3[0]);
						}
						else if (output3[0].includes("upload"))
						{
							$("#error3").html(output3[0]);
						}
						else if (output3.length == 32)
						{
							$("#result03").html("<h3>" + (categoryThree == 'videogames'? 'Video Games': capitalizeFirstLetter(categoryThree)) + ": </h3>");
							$("#result13").html( "<div class='tooltip'><a style = 'text-decoration: underline; color: blue;' href = '" + output3[12] + "'>"+ output3[14] +"</a><span class='tooltiptext'>" + output3[15] + "</span></div><img src='" + output3[13] + "' style='width: 150px; height: 150px; margin-top: 10px;'>");
							$("#result23").html( "<div class='tooltip'><a style = 'text-decoration: underline; color: blue; ' href = '" + output3[16] + "'>"+ output3[18] +"</a><span class='tooltiptext'>" + output3[19] + "</span></div><img src='" + output3[17] + "' style='width: 150px; height: 150px; margin-top: 10px;'>");
							$("#result33").html( "<div class='tooltip'><a style = 'text-decoration: underline; color: blue; ' href = '" + output3[20] + "'>"+ output3[22] +"</a><span class='tooltiptext'>" + output3[23] + "</span></div><img src='" + output3[21] + "' style='width: 150px; height: 150px; margin-top: 10px;'>");
							$("#result43").html( "<div class='tooltip'><a style = 'text-decoration: underline; color: blue; ' href = '" + output3[24] + "'>"+ output3[26] +"</a><span class='tooltiptext'>" + output3[27] + "</span></div><img src='" + output3[25] + "' style='width: 150px; height: 150px; margin-top: 10px;'>");
							$("#result53").html( "<div class='tooltip'><a style = 'text-decoration: underline; color: blue; ' href = '" + output3[28] + "'>"+ output3[30] +"</a><span class='tooltiptext'>" + output3[31] + "</span></div><img src='" + output3[29] + "' style='width: 150px; height: 150px; margin-top: 10px;'>");
						}
						else {
							//$("#result03").html("<h3>" + (categoryThree == 'videogames'? 'Video Games': capitalizeFirstLetter(categoryThree)) + ": </h3>");
							$("#error3").html("The crawled result of this category does not the meet the requirement. <br/> There should be at least 5 different products. Please crawl more products before trying again." );
						}
					}
	
					if (categoryCount > 3) {
						var output4 = result['data4'];
						
						$("#result04").html("<h3>" + (categoryFour == 'videogames'? 'Video Games': capitalizeFirstLetter(categoryFour)) + ": </h3>");
						if (output4[0].includes("usage")){
							$("#error4").html(output4[0]);
						}
						else if (output4[0].includes("upload"))
						{
							$("#error4").html(output4[0]);
						}
						else if (output4.length == 32)
						{
							//$("#result04").html("<h3>" + (categoryFour == 'videogames'? 'Video Games': capitalizeFirstLetter(categoryFour)) + ": </h3>");
							$("#result14").html( "<div class='tooltip'><a style = 'text-decoration: underline; color: blue;' href = '" + output4[12] + "'>"+ output4[14] +"</a><span class='tooltiptext'>" + output4[15] + "</span></div><img src='" + output4[13] + "' style='width: 150px; height: 150px; margin-top: 10px;'>");
							$("#result24").html( "<div class='tooltip'><a style = 'text-decoration: underline; color: blue; ' href = '" + output4[16] + "'>"+ output4[18] +"</a><span class='tooltiptext'>" + output4[19] + "</span></div><img src='" + output4[17] + "' style='width: 150px; height: 150px; margin-top: 10px;'>");
							$("#result34").html( "<div class='tooltip'><a style = 'text-decoration: underline; color: blue; ' href = '" + output4[20] + "'>"+ output4[22] +"</a><span class='tooltiptext'>" + output4[23] + "</span></div><img src='" + output4[21] + "' style='width: 150px; height: 150px; margin-top: 10px;'>");
							$("#result44").html( "<div class='tooltip'><a style = 'text-decoration: underline; color: blue; ' href = '" + output4[24] + "'>"+ output4[26] +"</a><span class='tooltiptext'>" + output4[27] + "</span></div><img src='" + output4[25] + "' style='width: 150px; height: 150px; margin-top: 10px;'>");
							$("#result54").html( "<div class='tooltip'><a style = 'text-decoration: underline; color: blue; ' href = '" + output4[28] + "'>"+ output4[30] +"</a><span class='tooltiptext'>" + output4[31] + "</span></div><img src='" + output4[29] + "' style='width: 150px; height: 150px; margin-top: 10px;'>");
						}
						else {
							
							$("#error4").html("The crawled result of this category does not the meet the requirement. <br/> There should be at least 5 different products. Please crawl more products before trying again." );
						}
					}
						
					if (categoryCount > 4) {
						var output5 = result['data5'];
						
						$("#result05").html("<h3>" + (categoryFive == 'videogames'? 'Video Games': capitalizeFirstLetter(categoryFive)) + ": </h3>");
						//$("#result").html( "<p style='display: inline-block; vertical-align: middle;'>" + output[1] + "</p><iframe src='" + output[12] + "' style='border:0px #ffffff none; display: inline-block; vertical-align: middle;margin-left: 70px;' scrolling='no' ></iframe>");
						if (output5[0].includes("usage")){
							$("#error5").html(output5[0]);
						}
						else if (output5[0].includes("upload"))
						{
							$("#error5").html(output5[0]);
						}
						else if (output5.length == 32)
						{
							
							$("#result15").html( "<div class='tooltip'><a style = 'text-decoration: underline; color: blue;' href = '" + output5[12] + "'>"+ output5[14] +"</a><span class='tooltiptext'>" + output5[15] + "</span></div><img src='" + output5[13] + "' style='width: 150px; height: 150px; margin-top: 10px;'>");
							$("#result25").html( "<div class='tooltip'><a style = 'text-decoration: underline; color: blue; ' href = '" + output5[16] + "'>"+ output5[18] +"</a><span class='tooltiptext'>" + output5[19] + "</span></div><img src='" + output5[17] + "' style='width: 150px; height: 150px; margin-top: 10px;'>");
							$("#result35").html( "<div class='tooltip'><a style = 'text-decoration: underline; color: blue; ' href = '" + output5[20] + "'>"+ output5[22] +"</a><span class='tooltiptext'>" + output5[23] + "</span></div><img src='" + output5[21] + "' style='width: 150px; height: 150px; margin-top: 10px;'>");
							$("#result45").html( "<div class='tooltip'><a style = 'text-decoration: underline; color: blue; ' href = '" + output5[24] + "'>"+ output5[26] +"</a><span class='tooltiptext'>" + output5[27] + "</span></div><img src='" + output5[25] + "' style='width: 150px; height: 150px; margin-top: 10px;'>");
							$("#result55").html( "<div class='tooltip'><a style = 'text-decoration: underline; color: blue; ' href = '" + output5[28] + "'>"+ output5[30] +"</a><span class='tooltiptext'>" + output5[31] + "</span></div><img src='" + output5[29] + "' style='width: 150px; height: 150px; margin-top: 10px;'>");
						}
						else {
							//$("#result05").html("<h3>" + (categoryFive == 'videogames'? 'Video Games': capitalizeFirstLetter(categoryFive)) + ": </h3>");
							$("#error5").html("The crawled result of this category does not the meet the requirement. <br/> There should be at least 5 different products. Please crawl more products before trying again." );
						}
					}
					
					}
					
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
		$("#generaterecommendrecsform2").submit(function(event) {
			// Prevent the form from submitting normally
			event.preventDefault();
			
			var userid = <?php echo json_encode($user_id); ?>; 
			var categoryCount = <?php echo json_encode($categoryCount); ?>;
			var fileExists = <?php echo json_encode($fileExists); ?>;
			var categoryOne = <?php echo json_encode($categoryOne); ?>; 	
			var categoryTwo = <?php echo json_encode($categoryTwo); ?>; 	
			var categoryThree = <?php echo json_encode($categoryThree); ?>; 	
			var categoryFour = <?php echo json_encode($categoryFour); ?>; 	
			var categoryFive = <?php echo json_encode($categoryFive); ?>; 	
			//console.log(typeof fileExists);
			//console.log(categoryOne);
			//show loading animation and hide button
			$("#loader").show();
			$("#generatebutton2").hide();
			// Get the command from the input field
			var product = $("#product2").val();
			var type = 'urldata';
				//console.log(fileExists);
//			var command = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/svdpp_input_csv.py C:/xampp/htdocs/dashboard/FYP/uploads/' + userid + '/data product ' + product + ' 5';
			var command = "";
			var command2 = "";
			var command3 = "";
			var command4 = "";
			var command5 = "";
		
			console.log(categoryCount);
			if (categoryCount == 1){
						
				command = "C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/svdpp_input_csv.py C:/xampp/htdocs/dashboard/FYP/uploads/" + userid + "/crawled/" + categoryOne + "/ product " + product + " 5";
				
			}
			else if (categoryCount == 2){
				command = "C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/svdpp_input_csv.py C:/xampp/htdocs/dashboard/FYP/uploads/" + userid + "/crawled/" + categoryOne + "/ product " + product + " 5";
				command2 = "C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/svdpp_input_csv.py C:/xampp/htdocs/dashboard/FYP/uploads/" + userid + "/crawled/" + categoryTwo + "/ product " + product + " 5";
			}
			else if (categoryCount == 3){
				command = "C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/svdpp_input_csv.py C:/xampp/htdocs/dashboard/FYP/uploads/" + userid + "/crawled/" + categoryOne + "/ product " + product + " 5";
				command2 = "C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/svdpp_input_csv.py C:/xampp/htdocs/dashboard/FYP/uploads/" + userid + "/crawled/" + categoryTwo + "/ product " + product + " 5";
				command3 = "C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/svdpp_input_csv.py C:/xampp/htdocs/dashboard/FYP/uploads/" + userid + "/crawled/" + categoryThree + "/ product " + product + " 5";
				
			}
			else if (categoryCount == 4){
				command = "C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/svdpp_input_csv.py C:/xampp/htdocs/dashboard/FYP/uploads/" + userid + "/crawled/" + categoryOne + "/ product " + product + " 5";
				command2 = "C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/svdpp_input_csv.py C:/xampp/htdocs/dashboard/FYP/uploads/" + userid + "/crawled/" + categoryTwo + "/ product " + product + " 5";
				command3 = "C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/svdpp_input_csv.py C:/xampp/htdocs/dashboard/FYP/uploads/" + userid + "/crawled/" + categoryThree + "/ product " + product + " 5";
				command4 = "C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/svdpp_input_csv.py C:/xampp/htdocs/dashboard/FYP/uploads/" + userid + "/crawled/" + categoryFour + "/ product " + product + " 5";
				
			}
			else if (categoryCount == 5){
				command = "C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/svdpp_input_csv.py C:/xampp/htdocs/dashboard/FYP/uploads/" + userid + "/crawled/" + categoryOne + "/ product " + product + " 5";
				command2 = "C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/svdpp_input_csv.py C:/xampp/htdocs/dashboard/FYP/uploads/" + userid + "/crawled/" + categoryTwo + "/ product " + product + " 5";
				command3 = "C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/svdpp_input_csv.py C:/xampp/htdocs/dashboard/FYP/uploads/" + userid + "/crawled/" + categoryThree + "/ product " + product + " 5";
				command4 = "C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/svdpp_input_csv.py C:/xampp/htdocs/dashboard/FYP/uploads/" + userid + "/crawled/" + categoryFour + "/ product " + product + " 5";
				command5 = "C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/svdpp_input_csv.py C:/xampp/htdocs/dashboard/FYP/uploads/" + userid + "/crawled/" + categoryFive + "/ product " + product + " 5";
				
			}
			/*else if (categoryCount == 1 && fileExists == true){
				command = "C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/svdpp_inputs_2csv.py C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/" + categoryOne + "/ C:/xampp/htdocs/dashboard/FYP/uploads/" + userid + "/crawled/ product " + product + " 5";

			}
			else if (categoryCount == 2 && fileExists == true){
				command = "C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/svdpp_inputs_3csv.py C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/" + categoryOne + "/ C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/" + categoryTwo + "/ C:/xampp/htdocs/dashboard/FYP/uploads/" + userid + "/crawled/ product " + product + " 5";

			}
			else if (categoryCount == 3 && fileExists == true){
				command = "C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/svdpp_inputs_4csv.py C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/" + categoryOne + "/ C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/" + categoryTwo + "/ C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/" + categoryThree + "/ C:/xampp/htdocs/dashboard/FYP/uploads/" + userid + "/crawled/ product " + product + " 5";

			}
			else if (categoryCount == 4 && fileExists == true){
				command ="C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/svdpp_inputs_5csv_code.py C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/" + categoryOne + "/ C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/" + categoryTwo + "/ C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/" + categoryThree + "/ C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/" + categoryFour + "/ C:/xampp/htdocs/dashboard/FYP/uploads/" + userid + "/crawled/ product " + product +  " 5";

			}
			else if (categoryCount == 5 && fileExists == true){
				command ="C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/svdpp_inputs_6csv.py C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/" + categoryOne + "/ C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/" + categoryTwo + "/ C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/" + categoryThree + "/ C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/" + categoryFour + "/ C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/" + categoryFive + "/ C:/xampp/htdocs/dashboard/FYP/uploads/" + userid + "/crawled/ product " + product + " 5";
				
			}*/

			// Send an AJAX request to the PHP script
			$.ajax({
				url: "execute_command_recommend.php",
				type: "POST",
				data: {command: command, command2: command2, command3: command3, command4: command4, command5: command5, userid: userid, product: product, type: type, categoryOne: categoryOne, categoryTwo: categoryTwo, categoryThree: categoryThree, categoryFour: categoryFour, categoryFive: categoryFive, categoryCount: categoryCount},
				dataType: "json",
				success: function(result) {
					var output = result['data'];
					$("#loader").hide();
					$("#generatebutton2").show();
					
					if (output[0].includes("exist"))
					{
						$("#result").html(output[0]);
					}
					else 
					{
					$("#result").html("<h3><u>Recommendations: </u></h3>");
					
					
					//output the results depending on number of categories
					//$("#result").html( "<p style='display: inline-block; vertical-align: middle;'>" + output[1] + "</p><iframe src='" + output[12] + "' style='border:0px #ffffff none; display: inline-block; vertical-align: middle;margin-left: 70px;' scrolling='no' ></iframe>");
					
					
					if (output[0].includes("usage")){
						$("#error0").html(output[0]);
						
					}
					else if (output[0].includes("upload"))
					{
						$("#result0").html("<h3>" + (categoryOne == 'videogames'? 'Video Games': capitalizeFirstLetter(categoryOne)) + ": </h3>");	
						$("#error0").html(output[0]);
					}
					else if (output.length == 32)
					{
						$("#result0").html("<h3>" + (categoryOne == 'videogames'? 'Video Games': capitalizeFirstLetter(categoryOne)) + ": </h3>");						
						$("#result1").html( "<div class='tooltip'><a style = 'text-decoration: underline; color: blue;' href = '" + output[12] + "'>"+ output[14] +"</a><span class='tooltiptext'>" + output[15] + "</span></div><img src='" + output[13] + "' style='width: 150px; height: 150px; margin-top: 10px;'>");
						$("#result2").html( "<div class='tooltip'><a style = 'text-decoration: underline; color: blue; ' href = '" + output[16] + "'>"+ output[18] +"</a><span class='tooltiptext'>" + output[19] + "</span></div><img src='" + output[17] + "' style='width: 150px; height: 150px; margin-top: 10px;'>");
						$("#result3").html( "<div class='tooltip'><a style = 'text-decoration: underline; color: blue; ' href = '" + output[20] + "'>"+ output[22] +"</a><span class='tooltiptext'>" + output[23] + "</span></div><img src='" + output[21] + "' style='width: 150px; height: 150px; margin-top: 10px;'>");
						$("#result4").html( "<div class='tooltip'><a style = 'text-decoration: underline; color: blue; ' href = '" + output[24] + "'>"+ output[26] +"</a><span class='tooltiptext'>" + output[27] + "</span></div><img src='" + output[25] + "' style='width: 150px; height: 150px; margin-top: 10px;'>");
						$("#result5").html( "<div class='tooltip'><a style = 'text-decoration: underline; color: blue; ' href = '" + output[28] + "'>"+ output[30] +"</a><span class='tooltiptext'>" + output[31] + "</span></div><img src='" + output[29] + "' style='width: 150px; height: 150px; margin-top: 10px;'>");
					}
					else {
						$("#result0").html("<h3>" + (categoryOne == 'videogames'? 'Video Games': capitalizeFirstLetter(categoryOne)) + ": </h3>");	
						//$("#result0").html("<h3>" + (categoryOne == 'videogames'? 'Video Games': capitalizeFirstLetter(categoryOne)) + ": </h3>");					
						$("#error0").html("The crawled result of this category does not the meet the requirement. <br/> There should be at least 5 different products. Please crawl more products before trying again." );
					}
					
					if (categoryCount > 1) {
						var output2 = result['data2'];
						
						$("#result02").html("<h3>" + (categoryTwo == 'videogames'? 'Video Games': capitalizeFirstLetter(categoryTwo)) + ": </h3>");
						if (output2[0].includes("usage")){
							$("#error2").html(output2[0]);
						}
						else if (output2[0].includes("upload"))
						{
							$("#error2").html(output2[0]);
						}
						else if (output2.length == 32)
						{
							
							$("#result12").html( "<div class='tooltip'><a style = 'text-decoration: underline; color: blue;' href = '" + output2[12] + "'>"+ output2[14] +"</a><span class='tooltiptext'>" + output2[15] + "</span></div><img src='" + output2[13] + "' style='width: 150px; height: 150px; margin-top: 10px;'>");
							$("#result22").html( "<div class='tooltip'><a style = 'text-decoration: underline; color: blue; ' href = '" + output2[16] + "'>"+ output2[18] +"</a><span class='tooltiptext'>" + output2[19] + "</span></div><img src='" + output2[17] + "' style='width: 150px; height: 150px; margin-top: 10px;'>");
							$("#result32").html( "<div class='tooltip'><a style = 'text-decoration: underline; color: blue; ' href = '" + output2[20] + "'>"+ output2[22] +"</a><span class='tooltiptext'>" + output2[23] + "</span></div><img src='" + output2[21] + "' style='width: 150px; height: 150px; margin-top: 10px;'>");
							$("#result42").html( "<div class='tooltip'><a style = 'text-decoration: underline; color: blue; ' href = '" + output2[24] + "'>"+ output2[26] +"</a><span class='tooltiptext'>" + output2[27] + "</span></div><img src='" + output2[25] + "' style='width: 150px; height: 150px; margin-top: 10px;'>");
							$("#result52").html( "<div class='tooltip'><a style = 'text-decoration: underline; color: blue; ' href = '" + output2[28] + "'>"+ output2[30] +"</a><span class='tooltiptext'>" + output2[31] + "</span></div><img src='" + output2[29] + "' style='width: 150px; height: 150px; margin-top: 10px;'>");
						}
						else {
							//$("#result02").html("<h3>" + (categoryTwo == 'videogames'? 'Video Games': capitalizeFirstLetter(categoryTwo)) + ": </h3>");
							$("#error2").html("The crawled result of this category does not the meet the requirement. <br/> There should be at least 5 different products. Please crawl more products before trying again." );
						}
					}
					
					if (categoryCount > 2) {
						var output3 = result['data3'];
						$("#result03").html("<h3>" + (categoryThree == 'videogames'? 'Video Games': capitalizeFirstLetter(categoryThree)) + ": </h3>");
						
						if (output3[0].includes("usage")){
						$("#error3").html(output3[0]);
						}
						else if (output3[0].includes("upload"))
						{
							$("#error3").html(output3[0]);
						}
						else if (output3.length == 32)
						{
							$("#result03").html("<h3>" + (categoryThree == 'videogames'? 'Video Games': capitalizeFirstLetter(categoryThree)) + ": </h3>");
							$("#result13").html( "<div class='tooltip'><a style = 'text-decoration: underline; color: blue;' href = '" + output3[12] + "'>"+ output3[14] +"</a><span class='tooltiptext'>" + output3[15] + "</span></div><img src='" + output3[13] + "' style='width: 150px; height: 150px; margin-top: 10px;'>");
							$("#result23").html( "<div class='tooltip'><a style = 'text-decoration: underline; color: blue; ' href = '" + output3[16] + "'>"+ output3[18] +"</a><span class='tooltiptext'>" + output3[19] + "</span></div><img src='" + output3[17] + "' style='width: 150px; height: 150px; margin-top: 10px;'>");
							$("#result33").html( "<div class='tooltip'><a style = 'text-decoration: underline; color: blue; ' href = '" + output3[20] + "'>"+ output3[22] +"</a><span class='tooltiptext'>" + output3[23] + "</span></div><img src='" + output3[21] + "' style='width: 150px; height: 150px; margin-top: 10px;'>");
							$("#result43").html( "<div class='tooltip'><a style = 'text-decoration: underline; color: blue; ' href = '" + output3[24] + "'>"+ output3[26] +"</a><span class='tooltiptext'>" + output3[27] + "</span></div><img src='" + output3[25] + "' style='width: 150px; height: 150px; margin-top: 10px;'>");
							$("#result53").html( "<div class='tooltip'><a style = 'text-decoration: underline; color: blue; ' href = '" + output3[28] + "'>"+ output3[30] +"</a><span class='tooltiptext'>" + output3[31] + "</span></div><img src='" + output3[29] + "' style='width: 150px; height: 150px; margin-top: 10px;'>");
						}
						else {
							//$("#result03").html("<h3>" + (categoryThree == 'videogames'? 'Video Games': capitalizeFirstLetter(categoryThree)) + ": </h3>");
							$("#error3").html("The crawled result of this category does not the meet the requirement. <br/> There should be at least 5 different products. Please crawl more products before trying again." );
						}
					}
	
					if (categoryCount > 3) {
						var output4 = result['data4'];
						
						$("#result04").html("<h3>" + (categoryFour == 'videogames'? 'Video Games': capitalizeFirstLetter(categoryFour)) + ": </h3>");
						if (output4[0].includes("usage")){
							$("#error4").html(output4[0]);
						}
						else if (output4[0].includes("upload"))
						{
							$("#error4").html(output4[0]);
						}
						else if (output4.length == 32)
						{
							//$("#result04").html("<h3>" + (categoryFour == 'videogames'? 'Video Games': capitalizeFirstLetter(categoryFour)) + ": </h3>");
							$("#result14").html( "<div class='tooltip'><a style = 'text-decoration: underline; color: blue;' href = '" + output4[12] + "'>"+ output4[14] +"</a><span class='tooltiptext'>" + output4[15] + "</span></div><img src='" + output4[13] + "' style='width: 150px; height: 150px; margin-top: 10px;'>");
							$("#result24").html( "<div class='tooltip'><a style = 'text-decoration: underline; color: blue; ' href = '" + output4[16] + "'>"+ output4[18] +"</a><span class='tooltiptext'>" + output4[19] + "</span></div><img src='" + output4[17] + "' style='width: 150px; height: 150px; margin-top: 10px;'>");
							$("#result34").html( "<div class='tooltip'><a style = 'text-decoration: underline; color: blue; ' href = '" + output4[20] + "'>"+ output4[22] +"</a><span class='tooltiptext'>" + output4[23] + "</span></div><img src='" + output4[21] + "' style='width: 150px; height: 150px; margin-top: 10px;'>");
							$("#result44").html( "<div class='tooltip'><a style = 'text-decoration: underline; color: blue; ' href = '" + output4[24] + "'>"+ output4[26] +"</a><span class='tooltiptext'>" + output4[27] + "</span></div><img src='" + output4[25] + "' style='width: 150px; height: 150px; margin-top: 10px;'>");
							$("#result54").html( "<div class='tooltip'><a style = 'text-decoration: underline; color: blue; ' href = '" + output4[28] + "'>"+ output4[30] +"</a><span class='tooltiptext'>" + output4[31] + "</span></div><img src='" + output4[29] + "' style='width: 150px; height: 150px; margin-top: 10px;'>");
						}
						else {
							
							$("#error4").html("The crawled result of this category does not the meet the requirement. <br/> There should be at least 5 different products. Please crawl more products before trying again." );
						}
					}
						
					if (categoryCount > 4) {
						var output5 = result['data5'];
						
						$("#result05").html("<h3>" + (categoryFive == 'videogames'? 'Video Games': capitalizeFirstLetter(categoryFive)) + ": </h3>");
						//$("#result").html( "<p style='display: inline-block; vertical-align: middle;'>" + output[1] + "</p><iframe src='" + output[12] + "' style='border:0px #ffffff none; display: inline-block; vertical-align: middle;margin-left: 70px;' scrolling='no' ></iframe>");
						if (output5[0].includes("usage")){
							$("#error5").html(output5[0]);
						}
						else if (output5[0].includes("upload"))
						{
							$("#error5").html(output5[0]);
						}
						else if (output5.length == 32)
						{
							
							$("#result15").html( "<div class='tooltip'><a style = 'text-decoration: underline; color: blue;' href = '" + output5[12] + "'>"+ output5[14] +"</a><span class='tooltiptext'>" + output5[15] + "</span></div><img src='" + output5[13] + "' style='width: 150px; height: 150px; margin-top: 10px;'>");
							$("#result25").html( "<div class='tooltip'><a style = 'text-decoration: underline; color: blue; ' href = '" + output5[16] + "'>"+ output5[18] +"</a><span class='tooltiptext'>" + output5[19] + "</span></div><img src='" + output5[17] + "' style='width: 150px; height: 150px; margin-top: 10px;'>");
							$("#result35").html( "<div class='tooltip'><a style = 'text-decoration: underline; color: blue; ' href = '" + output5[20] + "'>"+ output5[22] +"</a><span class='tooltiptext'>" + output5[23] + "</span></div><img src='" + output5[21] + "' style='width: 150px; height: 150px; margin-top: 10px;'>");
							$("#result45").html( "<div class='tooltip'><a style = 'text-decoration: underline; color: blue; ' href = '" + output5[24] + "'>"+ output5[26] +"</a><span class='tooltiptext'>" + output5[27] + "</span></div><img src='" + output5[25] + "' style='width: 150px; height: 150px; margin-top: 10px;'>");
							$("#result55").html( "<div class='tooltip'><a style = 'text-decoration: underline; color: blue; ' href = '" + output5[28] + "'>"+ output5[30] +"</a><span class='tooltiptext'>" + output5[31] + "</span></div><img src='" + output5[29] + "' style='width: 150px; height: 150px; margin-top: 10px;'>");
						}
						else {
							//$("#result05").html("<h3>" + (categoryFive == 'videogames'? 'Video Games': capitalizeFirstLetter(categoryFive)) + ": </h3>");
							$("#error5").html("The crawled result of this category does not the meet the requirement. <br/> There should be at least 5 different products. Please crawl more products before trying again." );
						}
					}
					
					}
				},
				error: function(xhr, status, error) {
					$("#loader").hide();
					$("#generatebutton2").show();
					// Display an error message
					alert("Error: " + error);
				}
			});
		});
	});
		
</script>
</body>