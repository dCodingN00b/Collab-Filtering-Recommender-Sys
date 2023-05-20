<?php session_start();

$part = '';
if (isset($_GET['part'])){
	$part = $_GET['part'];
}

$sub = '';
if (isset($_GET['sub'])){
	$sub = $_GET['sub'];
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Documentation</title>
	<link rel="stylesheet" type="text/css" href="doc_style.css?version24">
	<script>


function currentLeftSideBarColor (){
	var part =<?php echo json_encode($part); ?>;
	var useridsubcategory = document.getElementById("userid-subcategories");
	var productidsubcategory = document.getElementById("productid-subcategories");
	
	if (part == 'introduction'){
		document.getElementById("introduction").style.backgroundColor = "lightgreen";
		 document.getElementById("introduction").style.fontWeight = "600";
	}
	else if (part == 'howitworks'){
		document.getElementById("howitworks").style.backgroundColor = "lightgreen";
		var subcategories = document.getElementById("howitworks-subcategories");
		var orgsubcategory = document.getElementById("organization-subcategories");
		var indsubcategory = document.getElementById("individual-subcategories");
		
		document.getElementById("howitworks").style.fontWeight = "600";
		  if (subcategories.style.display === "none") {
			subcategories.style.display = "block";
		  }
		  
		  //check if url contains organization
		  if (window.location.href.indexOf("organization") > -1) {
			 // document.getElementById("side-organization").style.backgroundColor = "#c7dbf0";
			  
			  document.getElementById("side-organization").style.fontWeight = "600";
			  orgsubcategory.style.display = "block";
			  
				if (window.location.href.indexOf("adddata") > -1){	 
				  document.getElementById("side-org-adddata").style.fontWeight = "600";		
				}
				else if (window.location.href.indexOf("uploadeddata") > -1){
				  document.getElementById("side-org-uploadeddata").style.fontWeight = "600";		
				}
				else if (window.location.href.indexOf("generaterecommendations") > -1){
				  document.getElementById("side-org-generaterecommendations").style.fontWeight = "600";		
				}	
				else if (window.location.href.indexOf("generateratingsprediction") > -1){
				  document.getElementById("side-org-generateratingsprediction").style.fontWeight = "600";		
				}
				else if (window.location.href.indexOf("addlist") > -1){
				  document.getElementById("side-org-addlist").style.fontWeight = "600";		
				}	
				else if (window.location.href.indexOf("uploadedlist") > -1){
				  document.getElementById("side-org-uploadedlist").style.fontWeight = "600";		
				}	
				else if (window.location.href.indexOf("generaterecsrecommendations") > -1){
				  document.getElementById("side-org-generaterecsrecommendations").style.fontWeight = "600";		
				}	
				else if (window.location.href.indexOf("generaterecsratingsprediction") > -1){
				  document.getElementById("side-org-generaterecsratingsprediction").style.fontWeight = "600";		
				}	
				else if (window.location.href.indexOf("generateurlrecommendations") > -1){
				  document.getElementById("side-org-generateurlrecommendations").style.fontWeight = "600";		
				}	
				else if (window.location.href.indexOf("generateurlratingsprediction") > -1){
				  document.getElementById("side-org-generateurlratingsprediction").style.fontWeight = "600";		
				}	
				else if (window.location.href.indexOf("results") > -1){
				  document.getElementById("side-org-results").style.fontWeight = "600";		
				}	

			}
			else if (window.location.href.indexOf("individual")  > -1) {
				document.getElementById("side-individual").style.fontWeight = "600";
				indsubcategory .style.display = "block";
				
				if (window.location.href.indexOf("addlist") > -1){
				  document.getElementById("side-ind-addlist").style.fontWeight = "600";		
				}	
				else if (window.location.href.indexOf("uploadedlist") > -1){
				  document.getElementById("side-ind-uploadedlist").style.fontWeight = "600";		
				}	
				else if (window.location.href.indexOf("generaterecsrecommendations") > -1){
				  document.getElementById("side-ind-generaterecsrecommendations").style.fontWeight = "600";		
				}	
				else if (window.location.href.indexOf("generaterecsratingsprediction") > -1){
				  document.getElementById("side-ind-generaterecsratingsprediction").style.fontWeight = "600";		
				}	
				else if (window.location.href.indexOf("generateurlrecommendations") > -1){
				  document.getElementById("side-ind-generateurlrecommendations").style.fontWeight = "600";		
				}	
				else if (window.location.href.indexOf("generateurlratingsprediction") > -1){
				  document.getElementById("side-ind-generateurlratingsprediction").style.fontWeight = "600";		
				}	
				else if (window.location.href.indexOf("results") > -1){
				  document.getElementById("side-ind-results").style.fontWeight = "600";		
				}	
			}
			else if (window.location.href.indexOf("userid") > -1){
				document.getElementById("side-userid").style.fontWeight = "600";
				useridsubcategory.style.display = "block";
			
				if (window.location.href.indexOf("otheruserprofiles") > -1){
					document.getElementById("side-userid-otheruserprofiles").style.fontWeight = "600";		
				}
				else if (window.location.href.indexOf("ownuserprofile") > -1){
					document.getElementById("side-userid-ownuserprofile").style.fontWeight = "600";		
				}	
			}
			else if (window.location.href.indexOf("productid")  > -1){
				document.getElementById("side-productid").style.fontWeight = "600";
				productidsubcategory.style.display = "block";
			
			
				if (window.location.href.indexOf("url") > -1){
					document.getElementById("side-productid-url").style.fontWeight = "600";		
				}
				else if (window.location.href.indexOf("productpage") > -1){
					document.getElementById("side-productid-productpage").style.fontWeight = "600";		
				}	
			}
		  
		  
	}
	else if (part == 'priceplan'){
		document.getElementById("priceplan").style.backgroundColor = "lightgreen";
		document.getElementById("priceplan").style.fontWeight = "600";
		useridsubcategory.style.display = "block";
	}
	
	
	

}

// get the hash from the current URL
const hash = window.location.hash;

// if there's a hash in the URL
if (hash) {
  // select the element with the corresponding ID
  const targetElement = document.querySelector(hash);
  
  // if the element is found
  if (targetElement) {
    // calculate the offset to adjust for the height of any fixed elements
    const offset = 100; // change this value to adjust the offset
    const targetPosition = targetElement.offsetTop - offset;

    // scroll to the target position
    window.scrollTo({
      top: targetPosition,
      behavior: 'smooth'
    });
  }
}
	</script>
	<style>
/* width */
::-webkit-scrollbar {
  width: 15px;
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

<body onload = 'currentLeftSideBarColor()'>
	<header id='navbar'>
		
		<nav>
			<ul class="nav-titles">
				<li name = 'recs'><a name = 'recs' href="main.php">RECS</a></li>
			</ul>
			</nav>

		<ul class = "redirect">
			<li><a class="backtomain" href="main.php"> Back to main page</a></li>
		</ul>
	</header>	

	<div class="wrapper">
	
  <div class="sidebar" style = 'margin-top: 85px'>
    <ul>
			<li style ='padding: 15px; padding-left: 25px; color: silver; font-weight: 600; font-size: 18px;'><a href = 'documentation.php?part=introduction' id = 'doctitle'>RECS Documentation</a></li>
			<br/>
			<li><a href="documentation.php?part=introduction" id = 'introduction' style = 'font-weight: normal;font-size: 18px'>Introduction</a></li>
			<li><a href="documentation.php?part=howitworks" id = 'howitworks' style = 'font-weight: normal;font-size: 18px'>How it works</a>
			<ul id="howitworks-subcategories" style="display: none;">
				<li style = 'padding-left: 10px;'><a href="documentation.php?part=howitworks&sub=organization#organization" id = 'side-organization' 
				onclick = "window.location.hash = '#organization'; window.location.reload(); " style = 'font-weight: normal;'>Organization</a>
					<ul id="organization-subcategories" style="display: none;">
						<li style = 'padding-left: 10px;'><a href="#adddata" onclick = "window.location.hash = '#adddata';
						window.location.reload();" style = 'font-weight: normal; font-size: 14px;' id = 'side-org-adddata' >Add Data</a></li>
						<li style = 'padding-left: 10px;'><a href="#uploadeddata" onclick = "window.location.hash = '#uploadeddata';
						window.location.reload();" style = 'font-weight: normal;font-size: 14px;' id = 'side-org-uploadeddata'>Uploaded Data</a></li>
						<li style = 'padding-left: 10px;'><a href="#generaterecommendations" onclick = "window.location.hash = '#generaterecommendations';
						window.location.reload();" style = 'font-weight: normal;font-size: 14px;' 
						id = 'side-org-generaterecommendations' >Recommendations (Your Data)</a></li>
						<li style = 'padding-left: 10px;'><a href="#generateratingsprediction" onclick = "window.location.hash = '#generateratingsprediction';
						window.location.reload();" style = 'font-weight: normal;font-size: 14px;' 
						id = 'side-org-generateratingsprediction' >Ratings (Your Data)</a></li>
						<li style = 'padding-left: 10px;'><a href="#addlist" onclick = "window.location.hash = '#addlist';
						window.location.reload();" style = 'font-weight: normal;font-size: 14px;' 
						id = 'side-org-addlist' >Add List of URLs</a></li>
						<li style = 'padding-left: 10px;'><a href="#uploadedlist" onclick = "window.location.hash = '#uploadedlist';
						window.location.reload();" style = 'font-weight: normal;font-size: 14px;' 
						id = 'side-org-uploadedlist' >Uploaded List of URLs</a></li>
						<li style = 'padding-left: 10px;'><a href="#generateurlrecommendations" onclick = "window.location.hash = '#generateurlrecommendations';
						window.location.reload();" style = 'font-weight: normal;font-size: 14px;' 
						id = 'side-org-generateurlrecommendations' >Recommendations (URL Data)</a></li>
						<li style = 'padding-left: 10px;'><a href="#generateurlratingsprediction" onclick = "window.location.hash = '#generateurlratingsprediction';
						window.location.reload();" style = 'font-weight: normal;font-size: 14px;' 
						id = 'side-org-generateurlratingsprediction' >Ratings (URL Data)</a></li>
						<li style = 'padding-left: 10px;'><a href="#generaterecsrecommendations" onclick = "window.location.hash = '#generaterecsrecommendations';
						window.location.reload();" style = 'font-weight: normal;font-size: 14px;' 
						id = 'side-org-generaterecsrecommendations' >Recommendations (RECS Data)</a></li>
						<li style = 'padding-left: 10px;'><a href="#generaterecsratingsprediction" onclick = "window.location.hash = '#generaterecsratingsprediction';
						window.location.reload();" style = 'font-weight: normal;font-size: 14px;' 
						id = 'side-org-generaterecsratingsprediction' >Ratings (RECS Data)</a></li>
						<li style = 'padding-left: 10px;'><a href="#resultsorg" onclick = "window.location.hash = '#resultsorg';
						window.location.reload();" style = 'font-weight: normal;font-size: 14px;' 
						id = 'side-org-results' >Results</a></li>
				  </ul>
			  </li>
				<li style = 'padding-left: 10px;'><a href="documentation.php?part=howitworks&sub=individual#individual" id = 'side-individual' style = 'font-weight: normal;'>Individual</a>
					<ul id="individual-subcategories"  style="display: none;">
						<li style = 'padding-left: 10px;'><a href="#addlistind" onclick = "window.location.hash = '#addlistind';
						window.location.reload();" style = 'font-weight: normal;font-size: 14px;' 
						id = 'side-ind-addlist' >Add List of URLs</a></li>
						<li style = 'padding-left: 10px;'><a href="#uploadedlistind" onclick = "window.location.hash = '#uploadedlistind';
						window.location.reload();" style = 'font-weight: normal;font-size: 14px;' 
						id = 'side-ind-uploadedlist' >Uploaded List of URLs</a></li>
						<li style = 'padding-left: 10px;'><a href="#generateurlrecommendationsind" onclick = "window.location.hash = '#generateurlrecommendationsind';
						window.location.reload();" style = 'font-weight: normal;font-size: 14px;' 
						id = 'side-ind-generateurlrecommendations' >Recommendations (URL Data)</a></li>
						<li style = 'padding-left: 10px;'><a href="#generateurlratingspredictionind" onclick = "window.location.hash = '#generateurlratingspredictionind';
						window.location.reload();" style = 'font-weight: normal;font-size: 14px;' 
						id = 'side-ind-generateurlratingsprediction' >Ratings (URL Data)</a></li>
						<li style = 'padding-left: 10px;'><a href="#generaterecsrecommendationsind" onclick = "window.location.hash = '#generaterecsrecommendationsind';
						window.location.reload();" style = 'font-weight: normal;font-size: 14px;' 
						id = 'side-ind-generaterecsrecommendations' >Recommendations (RECS Data)</a></li>
						<li style = 'padding-left: 10px;'><a href="#generaterecsratingspredictionind" onclick = "window.location.hash = '#generaterecsratingspredictionind';
						window.location.reload();" style = 'font-weight: normal;font-size: 14px;' 
						id = 'side-ind-generaterecsratingsprediction' >Ratings (RECS Data)</a></li>
						<li style = 'padding-left: 10px;'><a href="#resultsind" onclick = "window.location.hash = '#resultsind';
						window.location.reload();" style = 'font-weight: normal;font-size: 14px;' 
						id = 'side-ind-results' >Results</a></li>
					</ul>
				</li>
					 <li style = 'padding-left: 10px;'><a href="documentation.php?part=howitworks&sub=userid#userid" style = 'font-weight: normal;' id = 'side-userid'>Getting User ID</a>
					<ul id="userid-subcategories" style="display: none;">
						<li style = 'padding-left: 10px;'><a href="#otheruserprofiles" onclick = "window.location.hash = '#otheruserprofiles';
							window.location.reload();" style = 'font-weight: normal;font-size: 14px;' 
							id = 'side-userid-otheruserprofiles' >Other User Profiles</a></li>
						<li style = 'padding-left: 10px;'><a href="#ownuserprofile" onclick = "window.location.hash = '#ownuserprofile';
							window.location.reload();" style = 'font-weight: normal;font-size: 14px;' 
							id = 'side-userid-ownuserprofile' >Own User Profile</a></li>
					</ul>
					</li>
					<li style = 'padding-left: 10px;'><a href="documentation.php?part=howitworks&sub=productid#productid" style = 'font-weight: normal;' id = 'side-productid' >Getting Product ID</a>
					<ul id="productid-subcategories" style="display: none;">
						<li style = 'padding-left: 10px;'><a href="#url" onclick = "window.location.hash = '#url';
							window.location.reload();" style = 'font-weight: normal;font-size: 14px;' 
							id = 'side-productid-url' >URL</a></li>
						<li style = 'padding-left: 10px;'><a href="#productpage" onclick = "window.location.hash = '#productpage';
							window.location.reload();" style = 'font-weight: normal;font-size: 14px;' 
							id = 'side-productid-productpage' >Product Page</a></li>
					</ul>
					</li>
			  </ul>
			 
			  <li><a href="documentation.php?part=priceplan" style = 'font-weight: normal;font-size: 18px' id = 'priceplan'>Price Plans</a></li>
			  
			<br/><br/>
			<br/><br/>
			<br/><br/>
			<br/><br/>
		</ul>
  </div>

  <div class="content" >
	<?php 
	if ($part == 'introduction') {
	?>
	<br /><br />
    <h1 id='introduction' style = 'font-size: 46px;'>Introduction</h1>
	<!--<img src = 'images/main2.png' alt = '' style = 'width: 710px;'>-->
			<p>RECS is a website-based product where it offers our clients the ability to predict existing user’s rating and preferences on
			different items as well as providing recommendations on similar or other products that the specific user might be interested in 
			based on the data set input by the owner. </br></br>
			
			Organizations can add new products to the recommender system that they have not added before 
			into their e-commerce site to generate a predicted rating for the products and make more informed decisions based on the result of the 
			predictions returned. </br></br>While for our individuals, the system allows them to predict and get recommendations of similar items on a single item 
			from the data we web crawl in other websites. </p>
			<br /><br />

			
			<br /><br />
			<br /><br />
	
	
	<br /><br />
		<br /><br />
	<!--
	<div class = 'main' style='display: flex; justify-content: center; align-items: center; position:relative; '>
	  <img src='images/main.png' alt='' class='mainimg'>
	</div>-->
	  </div>
	<?php 
	}
	else if ($part == 'howitworks'){
		
		
		
	?>
		<br /><br />
		<h1 id='howitworks' style = 'font-size: 46px;'>How it works</h1>
		<p>
		There are two types of users, organizations and inviduals. The main difference between organization and individual is that organization has
		the additional option of uploading their own data, and generating recommendations and rating predictions from the uploaded data. Otherwise,
		they both very similar.
		</p>
		<br />
		<img src = 'images/compareindorg3.png' alt = '' style = 'width: 710px;'>
		<br /><br />
		<br /><br />
		<h1 id='organization' style = 'font-size: 34px;padding-top: 150px; margin-top: -100px;' >Organization</h1>
		<p>
		
		Organizations can add in their own data, and generate recommendations or ratings prediction based on their uploaded data.
		</br></br>Whatever that Individuals can do, Organizations will have the same capability as well. </br></br>This means that, alternatively,
		Organizations will also have the option to use RECS very own web-crawled data set. They will have the optional choice to add in their own list
		of URLs for us to web crawl and add in to our existing data set. Generated results will include the new URLs that user has added in.
		</p>
	
		<br /><br />
		<br /><br />
		<h2 id='adddata'>Add Data</h2>
		<p>
			Once login, access the workspace. There, you can add in data in CSV format.
			<br/> <br />
			Format of the files should be in userID, prodID, rating, domain, image_urls and prodname. 

		</p>
		<br />
		<img src = 'images/csvformat2.png' alt = '' style = 'width: 700px;'>
		<p>
		Each file should only be one type of category. 
		Additionally, file name should include the category that it represents.
		</p>
		<br/>
		<img src = 'images/filename.png' alt = '' style = 'width: 200px;'>
		
		<br /><br />
		<br /><br />
		<h2 id='uploadeddata'>Uploaded Data</h2>
		<p>
			Once file has been uploaded, you will be able view in the uploaded data tab. Here is where you manage
			the uploaded files, and you can choose to update or delete the files.
		</p>
		<br/>
		<img src = 'images/uploadeddata3.png' alt = '' style = 'width: 700px;'>
		<br /><br />
		<br /><br />
		<h2 id='generaterecommendations'>Generate Recommendations (Your Data)</h2>
		<p>
			For generating of recommendations based on your data, just type in the product ID and click the generate button. 
			The generated results will consist of recommendations that is most similar to the product that you typed in. 
			Once generated, results will be shown right below the generate button. The results will be stored under the
			results tab.	
		</p>
		<img src = 'images/generaterecommendationsorg.png' alt = '' style = 'width: 710px;'>
		
		<br /><br />
		<br /><br />
		<h2 id = 'generateratingsprediction'>Generate Ratings Prediction (Your Data)</h2>
		<p>
			For generating of ratings predictions based on your data, just type in the user ID and product ID and click the generate button. 
			The generated results will use our prediction model to predict what rating a selected user will most likely give 
			the selected product. Once generated, results will be shown right below the generate button. The results will be stored under the
			results tab.
			
		</p>
		<img src = 'images/generatepredictionsorg.png' alt = '' style = 'width: 710px;'>
		<br /><br />
		<br /><br />
		<h2 id = 'addlist'>Add List of URLs</h2>
		<p>
			User have the choice to add in their list of URLs for us to web crawl and generate recommendations based on what they add in.
			Here, only .txt files are allowed. 	
		</p>
		<p>
		Take note that the file has a format to follow. The first line has to be the category, and every new line after that has to be the URLs.
		User should add in at least 10 different products to ensure that there will be no error. 
		</p>
		<br/>
		<img src = 'images/linksexample.png' alt = '' style = 'width: 310px;'>
		<br /><br />
		<br /><br />
		<h2 id = 'uploadedlist'>Uploaded List of URLs</h2>
		<p>
			Here, user can view their uploaded list. They can crawl their files from here.
		</p>
		<br/>
		<img src = 'images/uploadedlist.png' alt = '' style = 'width: 710px;'>
		<br /><br />
		<br /><br />
		<h2 id = 'generateurlrecommendations'>Generate Recommendations (URL Data)</h2>
		<p>
			For generating of recommendations based on URL data, just type in the product ID and click the generate button. 
			The generated results will consist of recommendations that is most similar to the product that you typed in. 
			Once generated, results will be shown right below the generate button. The results will be stored under the
			results tab. 	<br /><br />
			URL data is used to generate recommendations via the data that was web crawled through user's uploaded list of URLs.
			
		</p>
		<img src = 'images/generateurl.png' alt = '' style = 'width: 710px;'>
		<br /><br />
		<br /><br />
		<h2 id = 'generateurlratingsprediction'>Generate Ratings Prediction (URL Data)</h2>
		<p>
			For generating of ratings prediction based on URL data, just type in the product ID and click the generate button. 
			The generated results will use our prediction model to predict what rating a selected user will most likely give 
			the selected product. Once generated, results will be shown right below the generate button. The results will be stored under the
			results tab.<br /><br />
			URL data is used to generate the prediction of ratings via the data that was web crawled through user's uploaded list of URLs.
			
		</p>
		<img src = 'images/generateurl2.png' alt = '' style = 'width: 710px;'>
		<br /><br />
		<br /><br />
		<h2 id = 'generaterecsrecommendations'>Generate Recommendations (RECS Data)</h2>
		<p>
			For generating of recommendations based on RECS data, just type in the product ID and click the generate button. 
			The generated results will consist of recommendations that is most similar to the product that you typed in. 
			Once generated, results will be shown right below the generate button. The results will be stored under the
			results tab. 	<br /><br />
			RECS data is used to generate recommendations which uses RECS very own data that we have stored in our database.
			
		</p>
		<img src = 'images/generaterecs1.png' alt = '' style = 'width: 710px;'>
		<br /><br />
		<br /><br />
		<h2 id = 'generaterecsratingsprediction'>Generate Ratings Prediction (RECS Data)</h2>
		<p>
			For generating of ratings predictions based on RECS data, just type in the user ID and product ID and click the generate button. 
			The generated results will use our prediction model to predict what rating a selected user will most likely give 
			the selected product. Once generated, results will be shown right below the generate button. The results will be stored under the
			results tab.<br /><br />
			RECS data is used to generate ratings prediction which uses RECS very own data that we have stored in our database.		
		</p>
		<img src = 'images/generaterecs2.png' alt = '' style = 'width: 710px;'>
		<br /><br />
		<br /><br />
		<h2 id = 'resultsorg'>Results</h2>
		<p>
			This is where all the past generated results will be located. User will be able to search for any particular
			recommendation or ratings predictions they have done in the past.
		</p>
		<br /><br />
		<br /><br />
		<br /><br />
		<br /><br />
		<?php 
	
		?>
			<h1 id='individual' style = 'font-size: 34px;padding-top: 150px; margin-top: -100px;'>Individual</h1>
			<p>
			Individuals can add in their own list of URLs for us to web crawl. However, this is optional and only if you want us to exclusively crawl
			the custom URLs that you specify. If not, the user can just straightaway generate recommendations and ratings predictions 
			based on the data we have collected through web crawling. If a list of URLs have been uploaded, then whatever that this data will include
			the new data that we web crawl based on the URLs the user has uploaded.
			</p>
			<br /><br />
			<br /><br />
			<h2 id = 'addlistind'>Add List of URLs</h2>
		<p>
			User have the choice to add in their list of URLs for us to web crawl and generate recommendations based on what they add in.
			Here, only .txt files are allowed. 	
		</p>
		<p>
		Take note that the file has a format to follow. The first line has to be the category, and every new line after that has to be the URLs.
		User should add in at least 10 different products to ensure that there will be no error. 
		</p>
		<br/>
		<img src = 'images/linksexample.png' alt = '' style = 'width: 310px;'>
		<br /><br />
			<br /><br />
			<h2 id = 'uploadedlist'>Uploaded List of URLs</h2>
		<p>
			Here, user can view their uploaded list. They can crawl their files from here.
		</p>
		<br/>
		<img src = 'images/uploadedlist.png' alt = '' style = 'width: 710px;'>
		<br /><br />
		<br /><br />
			<h2 id = 'generateurlrecommendationsind'>Generate Recommendations (URL Data)</h2>
		<p>
			For generating of recommendations based on URL data, just type in the product ID and click the generate button. 
			The generated results will consist of recommendations that is most similar to the product that you typed in. 
			Once generated, results will be shown right below the generate button. The results will be stored under the
			results tab. 	<br /><br />
			URL data is used to generate recommendations via the data that was web crawled through user's uploaded list of URLs.
			
		</p>
		<img src = 'images/generateurl.png' alt = '' style = 'width: 710px;'>
		<br /><br />
		<br /><br />
		<h2 id = 'generateurlratingspredictionind'>Generate Ratings Prediction (URL Data)</h2>
		<p>
			For generating of ratings prediction based on URL data, just type in the product ID and click the generate button. 
			The generated results will use our prediction model to predict what rating a selected user will most likely give 
			the selected product. Once generated, results will be shown right below the generate button. The results will be stored under the
			results tab.<br /><br />
			URL data is used to generate the prediction of ratings via the data that was web crawled through user's uploaded list of URLs.
			
		</p>
		<img src = 'images/generateurl2.png' alt = '' style = 'width: 710px;'>
		<br /><br />
		<br /><br />
			<h2 id = 'generaterecsrecommendationsind'>Generate Recommendations (RECS Data)</h2>
			<p>
				For generating of recommendations based on RECS data, just type in the product ID and click the generate button. 
				The generated results will consist of recommendations that is most similar to the product that you typed in. 
				Once generated, results will be shown right below the generate button. The results will be stored under the
				results tab. 	<br /><br />
				RECS data which is used to generate recommendations is collected via web crawling, and it will include 
				the URLs that you uploaded for us to customly web crawl.
				
			</p>
			<img src = 'images/generaterecommendations.png' alt = '' style = 'width: 710px;'>
			<br /><br />
			<br /><br />
			<h2 id = 'generaterecsratingspredictionind'>Generate Ratings Prediction (RECS Data)</h2>
			<p>
				For generating of ratings predictions based on RECS data, just type in the user ID and product ID and click the generate button. 
				The generated results will use our prediction model to predict what rating a selected user will most likely give 
				the selected product. Once generated, results will be shown right below the generate button. The results will be stored under the
				results tab.<br /><br />
				RECS data which is used to generate the prediction of ratings is collected via web crawling, and it will include 
				the URLs that you uploaded for us to customly web crawl.		
			</p>
			<img src = 'images/generatepredictions3.png' alt = '' style = 'width: 710px;'>
			<br /><br />
			<br /><br />
			<h2 id = 'resultsind'>Results</h2>
			<p>
				This is where all the past generated results will be located. User will be able to search for any particular
				recommendation or ratings predictions they have done in the past.
			</p>
			
			<br /><br />
			<br /><br />
			<br /><br />
			<br /><br />
		<?php 
		
		?>
			<h1 id = 'userid' style = 'font-size: 34px;padding-top: 150px; margin-top: -100px;'>How to get User ID?</h1>
			<p>
				There's two ways to get User ID. One is to go to reviews and find other's user profiles from there.
				Another is to go to your profile. 
			</p>
			<br /><br />

			<h2 id = 'otheruserprofiles'>Other User Profiles</h2>
			<p>
			First of all, go to any product page. Then scroll to the bottom and find the part where one can view all reviews of said product.
			From there, one would see reviews and their authors. If one clicks on the profile image, they will be directed to the person's profile.
			</p>
			<br />
			<img src='images/otherprofile4.png' alt='' style='width: 710px;'>
			<br /><br />
			<p>
			Once clicked, this is the page they will see. And in the URL, one will be able to get the User ID of the user profile they chose.
			</p>
			<br />
			<img src='images/userid2.png' alt='' style='width:710px;'>
			<br /><br />
			<br /><br />
			<h2 id = 'ownuserprofile'>Own User Profile</h2>
			<p>
			Firstly, just on the button as shown below, which is '(your name) Amazon.com'.
			</p>
			<br />
			<img src='images/ownprofile6.png' alt='' style='width: 710px;'>
			<br />
			<p>
			Once clicked, this is the page they will see. And from here, click on 'Your Profile'.
			</p>
			<br />
			<img src='images/ownprofile5.png' alt='' style='width: 710px;'>
			<p>	
			Once that is done, you will be directed to your profile. Here, one will be able to get the User ID of their own profile.
			</p>
			<img src='images/userid.png' alt='' style='width: 710px;'>
			<br /><br />
				<br /><br />
				<br /><br />
				<br /><br />
		<?php 
	?>
			<h1 id = 'productid' style = 'font-size: 34px;padding-top: 150px; margin-top: -100px;'>How to get Product ID?</h1>
			<p>
			Product ID is more straightforward compared to User ID.
			One would just need to go to any product page and they will be able to grab the product ID easily.
			There is two ways to get it, one is through the URL and one is through the product information.
			</p>
		
			<br /><br />
			<h2 id = 'url'>Through the URL</h2>
			<p>This method is easy. One just has to click on any product and enter the product page. Once there,
			one will be able to grab the Product ID from the URL.</p>
			<img src='images/productid2.png' alt='' style='width: 710px;'>
			<br /><br />
			<br /><br />
			<h2 id = 'productpage'>Through the Product Page</h2>
			<p>Another way is to scroll down the product page until you reach the product information. Here, one will be able to grab the 
			Product ID right beside the 'ASIN'.</p>
			<img src='images/productid3.png' alt='' style='width: 710px;'>
			<br /><br />
			<br /><br />
			<br /><br />
			<br /><br />
			<br /><br />
		<?php
		
	}
	else if ($part == 'priceplan')
	{
	?>
		<br /><br />
		
		<h1 id = 'priceplan' style = 'font-size: 46px;'>Price Plans</h1>
		<p>
		We have two different user price plans, one for organization and one for individuals. 
		For each organization and individual, there exists the Standard and Pro Plan. There will also be a 30 Days Free Trial for every new user.
		</p>
		<p>
		To upgrade your plan, one can just do so from the home page, and click on the upgrade button on the top right.
		</p>
		<br /><br />
		<br /><br />
		<h1 id = '30dayfreetrial' style = 'font-size: 34px;'>30 Days Free Trial</h2>
		<p>
		Every new user will get a 30 days free trial, where they will have limited quota in terms of what they can do.
		</p>
		<p>
		<b>Individual</b> - 50 Recommendations, 20 URL Links to crawl.
		<br /><br />
		<b>Organizations</b> - 50 Recommendations, 20 URL Links to crawl, 15MB Uploadable Data
		</p>
		
		<img src='images/org1.png' alt='' style='width: 365px; transform:translate(0%, 2%);'>
		<img src='images/ind0.png' alt='' style='width: 365px;'>
		<br /><br />
		<br /><br />
		<h1 id = 'standardplan' style = 'font-size: 34px;'>Standard Plan</h2>
		<p>
		Standard Plan is when want to get more out of the product.
		</p>
		<p>
		<b>Individual</b> - 500 Recommendations, 50 URL Links to crawl
		<br /><br />
		<b>Organizations</b> - 300 Recommendations, 40 URL Links to crawl, 250MB Uploadable Data
		</p>
			<img src='images/org2.png' alt='' style='width: 365px;;'>
		<img src='images/ind1.png' alt='' style='width: 365px;'>
		<br /><br />
		<br /><br />
		
		<h1 id = 'standardplan' style = 'font-size: 34px;'>Pro Plan</h2>
		<p>
		Pro Plan is when want to get the most out of the product.
		</p>
		<p>
		<b>Individual</b> - 2500 Recommendations, 250 URL Links to crawl
		<br /><br />
		<b>Organizations</b> - 1500 Recommendations, 200 URL Links to crawl, 1250MB Uploadable Data
		</p>
			<img src='images/org3.png' alt='' style='width: 365px; transform:translate(0%, 3%);'>
		<img src='images/ind2.png' alt='' style='width: 365px;;'>
		<br /><br />
		<br /><br />
	<?php 
	}
	?>
	</div>
</html>
