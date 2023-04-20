<!DOCTYPE html>
<head>
<meta charset="utf-8">
<title>RECS</title>
<link rel="stylesheet" href="main_style.css?version144">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<style>
.main {
	margin-top: -95px;
}

.readmore {
display:none;

}

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

.circle {
	width: 50px;
	height: 50px;
	background-color: lightblue;
	border-radius: 50%;
	position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, 850%);
	animation: moveUpDown 2s ease-in-out infinite;
}
.arrow {
	width: 0;
	height: 0;
	border-left: 10px solid transparent;
	border-right: 10px solid transparent;
	border-top: 20px solid white;
	position: absolute;
	top: 35%;
	left: 50%;
	transform: translateX(-50%);
}
@keyframes moveUpDown {
	0% {top: 65px;}
	50% {top: 75px;}
	100% {top: 65px;}
}

html {
  scroll-behavior: smooth;
}
</style>
</head>
<!--changeHeight only takes place when howitworks page is loaded, changes height based on org or ind-->
<body onload = 'changeHeight()'>
<header id='navbar'>
		
		<nav>
			<ul class="nav-titles">
				<li name = 'recs'><a name = 'recs' href="main.php">RECS</a></li>
				<div class="dropdown">
					<button class="dropbutton" onmouseover = "style='color:mediumseagreen'" onmouseout = "style='color:black'">Product	
					</button>
					<div class="dropdown-content">
					  <a href="main.php?id=features">Features</a>
					  <a href="main.php?id=howitworks">How it works</a>
					  <a href="documentation.php?part=introduction">Documentation</a>
					</div>
				</div>
				<div class="dropdown2">
					<button class="dropbutton2" onmouseover = "style='color:mediumseagreen'" onmouseout = "style='color:black'">Pricing
					</button>
					<div class="dropdown-content2">
						<a href="main.php?id=indpricing">Individual</a>
						<a href="main.php?id=orgpricing">Organization</a>
					</div>
				</div>
				<li name = 'faq' ><a href="main.php?id=faq">FAQ</a></li>
				<li name = 'aboutus' ><a href="main.php?id=aboutus">About Us</a></li>

			</ul>
			</nav>
		
		
		<ul class = "login_info">
			<li><a class="login" href="login.php">Login</a></li>
			<li><a class="sign_up" href="org_register.php">Sign Up</a></li>
		</ul>
		<span class = 'opensidebar' style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776;</span>
	</header>	

	<?php
	#get id/option if it shows up in URL. 
	#used to navigate across different pages
	$id = '';
	$option = '';
	if (isset($_GET['id'])){
		$id = $_GET['id'];
	}
	if (isset($_GET['option'])){
		$option = $_GET['option'];
	}
	
	#if id is blank, display main page
	if ($id == ''){
		echo"
		<div class = 'main' id='main'>
			<div class='side-image'>
				<!-------Image-------->
				<img src='images/test7.jpg' alt=''>
				<div class='ref'><a href='https://www.vecteezy.com/free-vector/helping-others'>Helping Others Vectors by Vecteezy</a></div>
			</div>";
			echo"
				<div class='text'>
					<p>	
					<b>Recommendation System </br>
					for E-commerce Platforms</b></br></br>
						
					RECS offers our clients the ability to predict existing user’s rating</br> 
					and preferences on different items. </br></br>

					RECS provides recommendations on similar or other products that the </br>
					specific user might be interested in based on the data set input by the owner. </br></br>
					</br>
					<a href = 'Login.php'>Login</a>
					<a href = 'org_register.php'>Sign Up Now</a>
					</p>
					
				
				</div>";
				echo"<a href='main.php#bottom'>
					<div class='circle'>
						<div class='arrow'></div>
					</div>
					
				</a>
				<div style='margin-top: 60px;'><p><center>Try out our product here. Sign up not needed!<center></p></div>";
				/*
				<div style = 'transform: translate(0%, 2%);'>
				<a href = 'main.php#bottom' style = 'color: blue; padding-left: 400px; font-size: 30px; text-decoration:underline;'>Click Here</a>
				<span style = 'font-size: 30px;'> to try out our program</span
				
				</div>*/
				echo"
				<div class = 'main2'>
					<h3>A platform that focuses heavily</br> on user experience, no matter if </br>it's organizations or individuals.</h3>
					<img src='images/features2.svg	' alt=''>
					<p>Get a better understanding of what our</br> webpage entails, and get to know</br> what benefits you will get
					using our</br> recommendation engine.</br></br></br><a href = 'main.php?id=features'>Check our features</a></p>
				</div>
				<div class = 'main3'>
					<h3>Fast account creation process,</br> followed by getting your</br> custom recommendations.</h3>
					<img src='images/howitworkmain.svg	' alt=''>
					<p>Straightfoward, follow the instructions and</br> get your recommendations in a heartbeat</br>
					using our recommendation engine.</br></br></br><a href = 'main.php?id=howitworks'>Check how it works</a></p>
					
				</div> 
				 <div id='bottom'  style='transform:translate(0%, 800%);'><br /></div>
				<div class = 'main4'>
				
				";
				 echo'
				
				<h1 class = "heading11" id = "heading11"><center>Choose 1 of your favorite interests</center></h1>
				  <div class="container11 visible">
		<div id="interests" class="visible">
			<div class="row11">
				<div class="box11" onclick="selectInterest(this)">Computers</div>
				<div class="box11" onclick="selectInterest(this)">Electronics</div>
			</div>
			<div class="row11">
				<div class="box11" onclick="selectInterest(this)">Pets</div>
				<div class="box11" onclick="selectInterest(this)">Toys</div>
				<div class="box11" onclick="selectInterest(this)">Video Games</div>
			</div>
			
			<div  style = "transform: translate(80%, 200%);">
				<a id="next-btn" class="hidden" onclick="showResults()">Next</a>
			</div>
		</div>';
		/*
		<div id="age-group" class="hidden" >
			<div class="row11">
				<div class="box11" onclick="selectAgeGroup(this)">18-24</div>
				<div class="box11" onclick="selectAgeGroup(this)">25-34</div>
				<div class="box11" onclick="selectAgeGroup(this)">35-44</div>
				<div class="box11" onclick="selectAgeGroup(this)">45+</div>
			</div>
			<div  style = "transform: translate(80%, 200%);">
				<a id="next-btn-2" class="hidden" onclick="showResults()">Next</a>
			</div>
		</div>';*/
		echo"<div class='hidden' id='generate' >";
			/*echo"<div class = 'generate-title'>";
				echo"<h1 name = 'recommend' style='font-size:30px'>Based on that, Generate Recommendations</h1>";
			echo"</div></br>";*/
			echo"<form action='' method='POST'>";
			
			echo 
			"<div class = 'product' style = 'transform:translate(0%, 220%);'>
				<label for='product'>Product ID: </label>
				<select name = 'product' id='product' >
				  <option value='B086FNYG8X'>Smart speaker with Alexa [B086FNYG8X]</option>
				  <option value='B084YTCWL4'>Logitech G512 RGB Mechanical Gaming Keyboard [B084YTCWL4]</option>
				  <option value='B01MRU5D56'>Champion Men's Classic Jersey T-Shirt [B01MRU5D56]</option>
				  <option value='B07NVZBYBQ	'>Nautica Women's 5-Button 100% Cotton Polo Shirt [B07NVZBYBQ]</option>
				</select>
<div data-html='true' data-tip='The Product ID can be taken from the Product URL in the Amazon Web Store. 

In this instance, we already provided it for you.
' style='display: inline-block;'>
				<div class = 'hint' style='background-color: lightblue; border-radius: 50%; width: 20px; height: 20px; display: flex; justify-content: center; align-items: center;'>
			<span style='font-size: 15px; color: white;'>?</span></div>
				</div>
			</div>";
			echo"<div style = 'margin-top: 80px;'> <span style = 'padding-left: 250px; font-size: 16px;'>How to get <a href = 'http://localhost/fyp/documentation.php?part=howitworks&sub=productid#productid' 
			style = 'text-decoration:underline; color: blue;'>Product ID</a>?</span></div>";
			echo"<div class = 'generatebutton'><input type='submit' name='generate' value='Generate'></div>";
			echo"</form>";
	echo"</div>";
	echo'	
	</div>';
				 
		echo"
		</div>";
	}
	#About Us Page
	else if ($id == 'aboutus'){
		echo"<div class='aboutus' id='aboutus'>";
		echo"</br></br><h2 style='text-align:center'>Our Team</h2></br></br></br></br>";
		echo"<div class='container'>";
			// Team members data
			$team_members = array(
				array(
					"name" => "Loo Joon Wee",
					"position" => "Team Leader",
					"image" => "images/profilepicture.svg"
				),
				array(
					"name" => "Muhamad Amir Akmal",
					"position" => "Team Member",
					"image" => "images/profilepicture2.svg"
				),
				array(
					"name" => "Low Rui Hao",
					"position" => "Team Member",
					"image" => "images/profilepicture.svg"
				),
				array(
					"name" => "Travis Tham",
					"position" => "Team Member",
					"image" => "images/profilepicture2.svg"
				),
				array(
					"name" => "Leonard Wee",
					"position" => "Team Member",
					"image" => "images/profilepicture.svg"
				)
			);

			// Loop through the team members data and create boxes
			foreach ($team_members as $member) {
				echo '<div class="box">';
				echo '<img src="' . $member["image"] . '" alt="' . '' . '">';
				echo '<h3>' . $member["name"] . '</h3>';
				echo '<p>' . $member["position"] . '</p>';
				echo '</div>';
			}	
			echo"</div></br></br>";
		echo"</div>";
	}
	#Product > HowItWorks Page
	else if($id == 'howitworks'){
		echo"
		<div class = 'howitworks-frame' id = 'howitworks-frame'>
			<div class='howitworks' id='howitworks'>
				<h2 style='text-align:center'>How it works?</h2>
				
				<div class='howitworks-content' style='display: flex; justify-content: space-between;'>
					<div class='container1'>
						<img name = 'signup' src='images/signup.svg' alt=''>
						<h3>Sign Up</h3>
						<p>Choose between organization</br>and individual options. Then, fill</br> up the required particulars.</p>
						<img name = 'rightarrow' src='images/arrow3.svg' alt=''>
					</div>
					<div class='container2'>
						<img name = 'signin' src='images/signin.svg' alt=''>
						<h3>Sign In</h3>
						<p>Key in user details. You will</br> then be directed to the home</br> page.</p>
						<img name = 'rightarrow' src='images/arrow3.svg' alt=''>
					</div>
					<div class='container3'>
						<img name = 'interface' src='images/interface2.svg' alt=''>
						
						<h3>Access Workspace</h3>
						<p>Click on the Workspace button.</br> The Workspace is where you</br> manage everything related to</br> generating recommendations.</p>		
										
					</div>
				</div>
				<img name = 'curvedarrow' src='images/curvedarrow.svg' alt=''>		
			</div>";
		if ($option == '' or $option == 'howitworksorg'){
			echo"<a id='bottom'></a>
			<div class = 'howitworks-bottom'>
				<a href='main.php?id=howitworks&option=howitworksorg#bottom'><h2 name = 'howitworks-org' 
				style='text-align:center; border-bottom:2px solid lightgreen;'>Organization</h2></a>
				<a href='main.php?id=howitworks&option=howitworksind#bottom'><h2 style = 'color:grey' name = 'howitworks-indiv' 
				onmouseover='style = \"color:green; border-bottom:2px solid lightgreen;\"' 
				onmouseout='style = \"color:grey;\"' >Individual</h2></a>
			</div>";
			
			echo"
			<div class 'howitworks-org' style='display: flex; justify-content: space-between;'> 
				<div class= 'howitworks-org-1'>
					<img name = 'adddatapage' src='images/adddatapage.svg' alt=''>
					<h3 name = 'adddatapagetext'>Add Data</h3>
					<p name = 'adddatapagetext'>Click on the add data button.</br> Then, upload the CSV file with</br> the proper format.</p>
					<img name = 'rightarrow' src='images/arrow3.svg' alt=''>
				</div>
				<div class= 'howitworks-org-2'>
					<img name = 'uploadeddatapage' src='images/uploadeddatapage2.svg' alt=''>
					<h3 name = 'uploadeddatapagetext'>Uploaded Data</h3>
					<p name = 'uploadeddatapagetext'>Click on the uploaded data</br> button. There, you can manage</br> your uploaded data.</p>
					<img name = 'rightarrow' src='images/arrow3.svg' alt=''>
				</div>
				<div class= 'howitworks-org-3'>
					<img name = 'generatereco' src='images/generate.svg' alt=''>
					<h3 name = 'generaterecotext'>Generate</br> Recommendations</h3>
					<p name = 'generaterecotext'>Click on the Generate</br> Recommendations button</br> (Your Data). 
					There, you can</br> generate recommendations </br>or
					ratings prediction based</br> on your uploaded data.</br></br>
					Alternatively, you can also </br>click on the Generate</br> Recommendations button</br> (RECS's Data). There, 
					you can</br> generate recommendations or
					ratings prediction based on</br> the data we have web crawled. This includes the list of URLs</br>  that you have added. Our database will 
					already have the required data, anything your</br> list have will be an add on.</br> Hence, it is optional. </p>
				</div>
			</div>
			<div class 'howitworks-org' style='display: flex; justify-content: space-between;'> 
				<div class= 'howitworks-org-5'>
					<img name = 'addlist2' src='images/addlist2.svg' alt=''>
					<h3 name = 'addlisttext'>Add List</h3>
					<p name = 'addlisttext'>Click on the add list button.</br> Then, upload the text file with</br> URL links in the proper format. 
					</br>RECS will use the links to crawl </br>the URLs of your choice.</p>
					<img name = 'rightarrow' src='images/arrow3.svg' alt=''>
				</div>
				<div class= 'howitworks-org-6'>
					<img name = 'uploadedlist' src='images/uploadedlist.svg' alt=''>
					<h3 name = 'uploadeddatapagetext'>Uploaded List</h3>
					<p name = 'uploadeddatapagetext'>Click on the uploaded list</br> button. There, you can</br> manage your uploaded text </br>file.</p>
					<img name = 'rightarrow' src='images/arrow3.svg' alt=''>
				</div>
				
			</div>";
			echo"
			<div class= 'howitworks-arrow'><img name = 'curvedarrow3' src='images/curvedarrow.svg' alt=''></div>
			<div class 'howitworks-org-nextline' style='display: flex; justify-content: space-between;'>
				<div class= 'howitworks-org-4'>
					<img name = 'results' src='images/results.svg' alt=''>
					<h3 name = 'resultstext'>Results</h3>
					<p name = 'resultstext'>Click on the Results button.</br> There, you will be able check</br> the logs of your generated</br> results.</p>
				</div>
			</div>";
			
		}
		else if ($option == 'howitworksind'){
			echo"<a id='bottom'></a>
			<div class = 'howitworks-bottom'>
				<a href='main.php?id=howitworks&option=howitworksorg#bottom'><h2 name = 'howitworks-org' 
				style='text-align:center; color:grey;' onmouseover='style = \"color:green; border-bottom:2px solid lightgreen;\"' 
				onmouseout='style = \"color:grey;\"'>Organization</h2></a>
				<a href='main.php?id=howitworks&option=howitworksind#bottom'><h2 name = 'howitworks-indiv' 
				 style='text-align:center; border-bottom:2px solid lightgreen;'>Individual</h2></a>
			</div>";
			
			echo"
			<div class 'howitworks-ind' style='display: flex; justify-content: space-between;'> 
				<div class= 'howitworks-ind-1'>
					<img name = 'addlist' src='images/addlist2.svg' alt=''>
					<h3 name = 'addlisttext'>Add List</h3>
					<p name = 'addlisttext'>Click on the add list button.</br> Then, upload the text file with</br> URL links in the proper format. 
					</br>RECS will use the links to crawl </br>the URLs of your choice.</p>
					<img name = 'rightarrow' src='images/arrow3.svg' alt=''>
				</div>
				<div class= 'howitworks-ind-2'>
					<img name = 'uploadeddatapage' src='images/uploadedlist.svg' alt=''>
					<h3 name = 'uploadeddatapagetext'>Uploaded List</h3>
					<p name = 'uploadeddatapagetext'>Click on the uploaded list</br> button. There, you can</br> manage your uploaded text</br> file.</p>
					<img name = 'rightarrow' src='images/arrow3.svg' alt=''>
				</div>
				<div class= 'howitworks-ind-3'>
					<img name = 'generatereco' src='images/generate.svg' alt=''>
					<h3 name = 'generaterecotext'>Generate</br> Recommendations</h3>
					<p name = 'generaterecotext'>There, you can also click on the</br> Generate Recommendations</br> button (RECS's Data). There, 
					you can generate recommendations or
					ratings prediction based on</br> the data we have web crawled. This includes the list of URLs</br>  that you have added. Our database will 
					already have the required data, anything your list</br>  have will be an add on. Hence, it</br> is optional. </p>
				</div>
			</div>";
			echo"
			<div class= 'howitworks-arrow'><img name = 'curvedarrow2' src='images/curvedarrow.svg' alt=''></div>
			<div class 'howitworks-ind-nextline' style='display: flex; justify-content: space-between;'>
				<div class= 'howitworks-ind-4'>
					<img name = 'results' src='images/results.svg' alt=''>
					<h3 name = 'resultstext'>Results</h3>
					<p name = 'resultstext'>Click on the Results button.</br> There, you will be able check</br> the logs of your generated</br> results.</p>
				</div>
			</div>";
		}
		echo "</div>";
		
	}
	#Product > Features Page
	else if ($id == 'features'){
		echo"
		<div class='features' id='features'>
		<h2 style='text-align:center'>Features</h2>
			<div class = 'features-content' >
			<p name = 'features-intro'>
			Our product offers many features and it is very simple to use.</br></br>	
			We prioritize only the best experience - Our Team</p>
				<div class='feature1'>
					<h3>Catered towards both </br>Individual and Organizations</h3>
					<p>
					&#8226; Organizations are able to add in their own </br> data set. </br></br> &#8226; Individuals can
					still use the recommendation </br>engine with RECS's very own dataset.</p>
					<img src = 'images/bothside.svg'  alt=''>	
				</div>
				<div class='feature2'>
					<img src = 'images/ergo.svg'  alt=''>	
					<h3>Seamless Interface and</br>Easy to Navigate</h3>
					<p>&#8226; Minimalistic Interface that's easy to </br>take in and understand</br></br>
					&#8226; Easy to navigate and beginner-friendly</p>
				</div>
				<div class='feature3'>
					<img src = 'images/security.svg'  alt=''>	
					<h3>Enhanced Efforts on</br> Security</h3>
					<p>&#8226; In order to secure all the confidential</br>data, 2FA security is introduced. Such a</br> system
					will help our clients and customers</br> feel safer.</p>
				</div>
				<div class='bg'>
				</div>
				
			</div>
		</div>";
	}
	#Pricing Page (for org)
	else if ($id == 'orgpricing'){
		echo"<div class='pricing' id='pricing'>
		<h2 style='text-align:center'>Pricing for Organizations</h2>
			<div class='pricing-container'>
				<div class='pricing-box'>
					<img name = 'free' src ='images/tick.svg' alt =''>
					<h2>30 Days Free Trial</h2>
					<p name='intro'>For those who are </br>starting out.</p>
					<p>1GB Uploadable Data</br>100 Recommendation Requests</p>
					<h3>$0 / month</h3>
					
				</div>
				<div class='pricing-box'>
					<img name = 'standard' src ='images/upgrade.svg' alt =''>
					<h2>Standard</h2>
					<p name='intro'>Get more out of the</br> product.</p>
					<p>10GB Uploadable Data</br>1000 Recommendation Requests</p>
					<h3>$14.90 / month</h3>
					
				</div>
				<div class='pricing-box'>
					<img name = 'pro' src ='images/high.svg' alt =''>
					<h2>Pro</h2>
					<p name='intro'>Get the most out of</br> the product.</p>
					<p>50GB Uploadable Data</br>5000 Recommendation Requests</p>
					<h3>$49.90 / month</h3>
					
				</div>
			</div>";
			/*echo"
			<div class='pricing-container-bottom'>
				<div class='pricing-box'>
					<img name = 'custom' src ='images/custom.svg' alt =''>
					<h2>Custom</h2>
					<p name='intro'>Cost depends on how </br>much you use the product.</p>
					<p>Unlimited Uploadable Data</br>Unlimited Recommendation Requests</p>
					<h3>?? / month</h3>
					<button><a href = 'org_register.php'>Start 30 Days Free Trial</a></button>
				</div>
			</div>*/
		echo"</div>";
	}
	#Pricing Page (for ind)
	else if ($id == 'indpricing'){
		echo"<div class='pricing' id='pricing'>
		<h2 style='text-align:center'>Pricing for Individuals</h2>
			<div class='pricing-container'>
				<div class='pricing-box'>
					<img name = 'free' src ='images/tick.svg' alt =''>
					<h2>30 Days Free Trial</h2>
					<p name='intro'>For those who are </br>starting out.</p>
					<p>200 Recommendation Requests</p>
					<h3>$0 / month</h3>
					
				</div>
				<div class='pricing-box'>
					<img name = 'standard' src ='images/upgrade.svg' alt =''>
					<h2>Standard</h2>
					<p name='intro'>Get more out of the</br> product.</p>
					<p>2000 Recommendation Requests</p>
					<h3>$9.90 / month</h3>
					
				</div>
				<div class='pricing-box'>
					<img name = 'pro' src ='images/high.svg' alt =''>
					<h2>Pro</h2>
					<p name='intro'>Get the most out of</br> the product.</p>
					<p>10000 Recommendation Requests</p>
					<h3>$34.90 / month</h3>
					
				</div>
			</div>
			
			<div class='pricing-container-bottom'>";
			/*echo"
				<div class='pricing-box'>
					<img name = 'custom' src ='images/custom.svg' alt =''>
					<h2>Custom</h2>
					<p name='intro'>Cost depends on how </br>much you use the product.</p>
					<p>Unlimited Recommendation Requests</p>
					<h3>?? / month</h3>
					<button><a href = 'indiv_register.php'>Start 30 Days Free Trial</a></button>
				</div>*/
			echo"</div>
		</div>";
	}
	#faq page
	else if ($id == 'faq'){
		echo'<div class="faq" id="faq">
			<div class="temp">	<h2 name ="head" style="text-align:center">Frequently Asked Questions</h2></div>';
			
			#faq -> product
			if ($option == 'product' or $option == ''){
			echo'<a href = "main.php?id=faq&option=product"><h3 name = "faq-type" id = "faq-type-1"
			style = "border-bottom: 2px solid lightgreen">Product</h3></a>';
			echo"<a href = 'main.php?id=faq&option=price'><h3 name = 'faq-type' id = 'faq-type-2'
			onmouseover = 'style = \"border-bottom: 2px solid lightgreen; color: green\"' 
			onmouseout = 'style = \" color:grey;\"'>Price</h3></a>";
			echo'<div class="questions">';
			echo'
				<div class="question" onclick="togglePanel(this)">
					<h2 class="question-title">Is this product only meant for organizations?<i style="float:right" class="fa fa-plus"></i></h2>
					<div class="answer">
						<p>No. There are services catered to individuals as well.</p>
					</div>
				</div>
				<div class="question" onclick="togglePanel(this)">
					<h2 class="question-title">What do I have to do to create an account?<i style="float:right" class="fa fa-plus"></i></h2>
					<div class="answer">
						<p>Click on "Sign Up", then register an account. You can choose between organization and individual. Then follow the instructions that will be stated after a successful creation of account.</p>
					</div>
				</div>
				<div class="question" onclick="togglePanel(this)">
						<h2 class="question-title">As an Organization, what should I do once I have logged in?<i style="float:right" class="fa fa-plus"></i></h2>
					<div class="answer">
						<p>You can click on the "Workspace" button. After that, you can add your own dataset, and check your uploaded data set.
						Thereafter, you can generate recommendations or ratings based on your dataset. Alternatively, you can also choose 
						to use the dataset provided by RECS to generate the recommendations and ratings. Finally, all results can be found in the "Results"
						button in your workspace.</p>
					</div>	
					</div>
				<div class="readmore" id = "readmore">
					<div class="question" onclick="togglePanel(this)">
						<h2 class="question-title">As an Individual, what should I do once I have logged in?<i style="float:right" class="fa fa-plus"></i></h2>
					<div class="answer">
						<p>You can click on the "Workspace" button. After that, you can to use the dataset provided by RECS to generate 
						the recommendations and ratings. Finally, all results can be found in the "Results" button in your workspace.</p>
					</div>	
					</div>
					<div class="question" onclick="togglePanel(this)">
					<h2  class="question-title">What kind of recommendation system does RECS use? <i style="float:right" class="fa fa-plus"></i></h2> 
					<div class="answer">
						<p>Collaborative Filtering.</p>
					</div>
					</div>
					<div class="question" onclick="togglePanel(this)">
					<h2 class="question-title">What is Collaborative Filtering? <i style="float:right" class="fa fa-plus"></i></h2>
					<div class="answer">
						<p>It is a way to find similarities between users and products and then using that data to provide recommendations.</p>
					</div>
					</div>
				</div>
				<div class = "readmorebutton"><button id = "readmorebtn" type="button" onclick = "readMore()">View More</button></div>';
			}
			#faq -> price
			else if ($option == 'price'){
				echo"<a href = 'main.php?id=faq&option=product'><h3 name = 'faq-type' id = 'faq-type-1'
				onmouseover = 'style = \"border-bottom: 2px solid lightgreen; color: green\"' 
				onmouseout = 'style = \"color:grey\"'>Product</h3></a>";
				echo"<a href = 'main.php?id=faq&option=price'><h3 name = 'faq-type' id = 'faq-type-2'
				style = 'border-bottom: 2px solid lightgreen'>Price</h3></a>";
				echo'<div class="questions">';
				echo'
				<div class="question" onclick="togglePanel(this)">
					<h2 class="question-title">How much do your services cost?<i style="float:right" class="fa fa-plus"></i></h2>
					<div class="answer">
						<p>Click on the prices in the navigation tab at the top of the browser. There, you will be able to see the prices plans depending if you are an individual
						or representing an organization. </p>
					</div>
				</div>
				<div class="question" onclick="togglePanel(this)">
					<h2 class="question-title">Does the different price plan affect the performance of the product?<i style="float:right" class="fa fa-plus"></i></h2>
					<div class="answer">
						<p>No, it does not. The only difference is the number of recommendations and uploadable data.</p>
					</div>
				</div>
				<div class="question" onclick="togglePanel(this)">
					<h2 class="question-title">Is there a free plan available?<i style="float:right" class="fa fa-plus"></i></h2>
					<div class="answer">
						<p>There is a 30 Days Free Trial for all who wants to try our product out.</p>
					</div>
				</div>
				<div class="readmore" id = "readmore">
					<div class="question" onclick="togglePanel(this)">
					<h2 class="question-title">How do I upgrade my price plan?<i style="float:right" class="fa fa-plus"></i></h2>
					<div class="answer">
						<p>Once, you are logged in, you can upgrade your plan anytime, and it will be a button on the top right of your page.</p>
					</div>
				</div>	
				</div>
				<div class = "readmorebutton"><button id = "readmorebtn" type="button" onclick = "readMore()">View More</button></div>';
			}
			else if ($option == 'documentation')
			{
				
			}
	echo'</div>
	</div>';
	}
	?>
	
	<!--Bottom part of the page with contacts/links-->
	<div class = 'bottom-page'>
		<div class = 'contactus'>
			<h3>Contact Us<h3>
			<p>contact@recs.com</p></br>
			<p>+65 9a12345b</p>
		</div>
		<div class = 'links'>
			<h3>Links<h3>
			<p><a href = 'main.php?id=features'>Features</a></p></br>
			<p><a href = 'main.php?id=howitworks'>How it works</a></p></br>
			<p><a href = 'main.php?id=orgpricing'>Prices (Organization)</a></p></br>
			<p><a href = 'main.php?id=indpricing'>Prices (Individual)</a></p></br>
			<p><a href = 'main.php?id=aboutus'>About Us</a></p></br>
			<p><a href = 'main.php?id=faq'>FAQ</a></p>
		</div>
		<div class = 'startnow'>
			<h3>Start Now<h3>
			<p><a href = 'Login.php'>Login</a></p></br>
			<p><a href = 'org_register.php'>Sign Up</a></p></br>
		</div>
	</div>
<script>
// When the user scrolls the page, execute myFunction
window.onscroll = function() {myFunction() };

// Get the navbar
var navbar = document.getElementById("navbar");

// Get the offset position of the navbar
var sticky = navbar.offsetTop;

//get the main, features, howitworks, pricing, aboutus and faq
var main = document.getElementById("main");
var features = document.getElementById("features");
var howitworks = document.getElementById("howitworks");
var pricing = document.getElementById("pricing");
var aboutus = document.getElementById("aboutus");
var faq = document.getElementById("faq");

// Add the sticky class to the navbar when you reach its scroll position. Remove "sticky" when you leave the scroll position
//margin is added to prevent snapping
function myFunction() {
	if (window.pageYOffset >= sticky) {
		navbar.classList.add("sticky");
		if (document.URL.includes("features") ) {
			features.style.marginTop = '90px';
		}else if (document.URL.includes("howitworks")){
			howitworks.style.marginTop = '90px';
		}else if (document.URL.includes("pricing")){
			pricing.style.marginTop = '90px';
		}else if (document.URL.includes("aboutus")){
			aboutus.style.marginTop = '90px';
		}else if (document.URL.includes("faq")){
			faq.style.marginTop = '90px';
		}else{
			main.style.marginTop = '0px';
		}	
	} 
	else {
		navbar.classList.remove("sticky");
	}
}

//get all questions
const questions = document.querySelectorAll('.question');

//for each question, add event listener
//such that when clicked, will open, else, close
questions.forEach(question => {
	question.addEventListener('click', () => {
		question.classList.toggle('active');
		const answer = question.querySelector('.answer');
		if (question.classList.contains('active')) {
			answer.style.maxHeight = answer.scrollHeight + 'px';
		} else {
			answer.style.maxHeight = 0;
		}
	});
});

//change from + to 0 when open to close, vice versa
function togglePanel(questions) {
 
  var icon = questions.querySelector('i');
  icon.classList.toggle('fa-plus');
  icon.classList.toggle('fa-minus');
}

//will show the hidden fields of faw when read more is clicked.
function readMore(){
	var btn = document.getElementById("readmorebtn");
	var readmore = document.getElementById("readmore");
	var faq = document.getElementById("faq");
	if (btn.innerHTML == "View More"){		
		readmore.style.display = "block";
		faq.style.height = "1100px";
		btn.innerHTML = "View Less";
	}else if (btn.innerHTML  == "View Less"){
		readmore.style.display = "none";
		faq.style.height = "800px";
		btn.innerHTML = "View More";
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

function changeHeight() {
	var option =<?php echo json_encode($option); ?>;
	var frame = document.getElementById('howitworks-frame');
	if (option !== 'howitworksind'){
		frame.style.height = '2200px';
	}
}

function openNav() {
  document.getElementById("mySidenav").style.width = "250px";
}

function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
}

var selectedInterests = [];
var selectedAgeGroup = [];

function selectInterest(box) {
    let selectedBoxes = document.querySelectorAll(".selected");
    if (selectedBoxes.length < 1 || box.classList.contains("selected")) {
        box.classList.toggle("selected");
      
        selectedBoxes = document.querySelectorAll(".selected");
        if (selectedBoxes.length === 1) {
            document.getElementById("next-btn").classList.remove("hidden");
			  selectedInterests = [];
            selectedBoxes.forEach(box => {
                selectedInterests.push(box.innerHTML);
            });
        } else {
            document.getElementById("next-btn").classList.add("hidden");
        }
    }
}


function showAgeGroup() {
    document.getElementById("interests").classList.add("hidden");
	document.getElementById("heading11").classList.add("hidden");
    setTimeout(() => {
		
		setTimeout(function() { document.getElementById("interests").style.display = "none"; }, 500);
		setTimeout(function() { document.getElementById("age-group").classList.remove("hidden"); }, 500);
        
        let ageGroupBoxes = document.querySelectorAll("#age-group .row11 .box11");
        ageGroupBoxes.forEach(box => {
            box.classList.add("visible");
        });
        document.getElementById("next-btn").classList.add("hidden");
		document.getElementById("heading11").innerHTML = 'Choose your age group';
		document.getElementById("heading11").style.textAlign = "center";
		setTimeout(function() { document.getElementById("heading11").classList.remove("hidden"); }, 500);
		
    }, 1000);
	
		
}

/*"Interests: " + selectedInterests[0] + ", "
	+ selectedInterests[1] + "<br />Age group: " + selectedAgeGroup + */
function showResults(){
	//document.getElementById("age-group").classList.add("hidden");
	document.getElementById("interests").classList.add("hidden");
	document.getElementById("heading11").classList.add("hidden");
	setTimeout(function() { document.getElementById("heading11").style.fontSize = "26px"; }, 1050);
	setTimeout(function() { document.getElementById("heading11").style.textAlign = "center"; }, 1050);
	setTimeout(function() { document.getElementById("heading11").innerHTML = "Choose a product from the list, then click generate.";
 }, 1100);
	setTimeout(function() { document.getElementById("interests").style.display = "none"; }, 1200);
	setTimeout(function() { document.getElementById("heading11").classList.remove("hidden"); }, 2000);
	setTimeout(function() { document.getElementById("generate").classList.remove("hidden"); }, 2000);
}

function selectAgeGroup(box) {
  let selectedBoxes = document.querySelectorAll(".selected-box11");
  if (selectedBoxes.length < 1 || box.classList.contains("selected-box11")) {
    box.classList.toggle("selected-box11");
	
    selectedBoxes = document.querySelectorAll(".selected-box11");
    if (selectedBoxes.length === 1) {
		selectedBoxes.forEach(box => {
                selectedAgeGroup = box.innerHTML;
            });
      document.getElementById("next-btn-2").classList.remove("hidden");
    } else {
      document.getElementById("next-btn-2").classList.add("hidden");
    }
  }
}

</script>
</body>
</html>