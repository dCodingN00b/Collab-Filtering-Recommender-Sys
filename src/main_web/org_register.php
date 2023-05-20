<?php session_start(); ?>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="orgregister_style.css?version15">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
<title>Sign Up Page</title>
<style>
.success-box {
	background-color: whitesmoke;
	color: white;
	padding: 20px;
	left: 0;
	width: 100%;
	z-index: -9999;
	vertical-align: middle;
}

.success-box .close-button {
	color: black;
	float: right;
	font-size: 30px;
	font-weight: bold;
	cursor: pointer;
	transform:translate(0%, -20%);
}

.success-box p {
	transform:translate(0%, 20%);
}
	

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
	include ('inc_db_fyp.php');
	include ('user.php');
	
	$DisplayForm = TRUE;
	$userType = '';
	unset($_SESSION['emailError']);
	unset($_SESSION['error']);
	unset($_SESSION['passError']);
	if (isset($_POST['submit']) and ($_POST['submit'] == 'Continue')){
		if ($_POST['userType'] == 'Organization'){			
			$userType = 1;
			$_SESSION['userType'] = $userType;
			$DisplayForm = False; 
		}else if($_POST['userType'] == 'Individual'){			
			$userType = 2;
			$_SESSION['userType'] = $userType;
			$DisplayForm = False; 
		}
		if ($_POST['password'] != $_POST['cpassword']){
			$_SESSION["passError"] = "Password does not match";
			$DisplayForm = True; 
		}else {
			#call method inside user entity class to check if email already in database, return bool
			unset($_SESSION['error']);
			$user = new User();
			$DisplayForm = $user -> checkEmail($_POST['email']);
			
			if ($DisplayForm)
			{
				$_SESSION['emailError'] = "Email already used.";
			}
		}
		
		
	}else if (isset($_POST['submit']) and ($_POST['submit'] == 'Sign Up')){
		$DisplayForm = False;
	}
	
	if ($DisplayForm){
		?>
   <div class="wrapper">
        <div class="container main">
            <div class="row">
                <div class="col-md-6 side-image">
                    <!-------Image-------->
                    
                    <div class="text">
                       <p><a name='recs' href='main.php'>RECS</a></p>
						<a name = 'ref' href="https://www.vecteezy.com/free-vector/helping-others">Helping Others Vectors by Vecteezy</a>
                    </div>
                </div>
                <div class="col-md-6 right">
                     <div class = 'orgreg'>
						
						<a href="login.php"><h1 name = 'login' >LOGIN</h1></a>
						<a href="org_register.php"><h1 name = 'register'>SIGN UP</h1 ></a>
						<a href="org_register.php"><h3 name = 'orgregister'>Organization</h3></a>
						<a href="indiv_register.php"><h3 name = 'indivregister'>Individual</h3></a>
						<form action = "org_register.php" method = "POST">
							<div class = 'text_field'>
								<span>Email: </span></span><input type="email" name="email" required />
								<?php
									if(isset($_SESSION['emailError'])){
										$error = $_SESSION["emailError"];
										echo "<span style='color:red'>$error</span>";
									}
								?>
							</div>
							<div class = 'text_field'>
								<span>
									Password:
									<div data-html='true' data-tip ='Min 8 characters
																	At least 1 Uppercase
																	At least 1 Lowercase
																	At least 1 Number
																	At least 1 Symbol' style='display: inline-block;'>
										<div class = 'hint' style='background-color: lightblue; border-radius: 50%; width: 20px; height: 20px; display: flex; justify-content: center; align-items: center;'>
											<span style='font-size: 15px; color: white;'>?</span>
										</div>
								</div>
								</span>
								<input type="password" name="password" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*_=+-]).{8,}$" required />							
							</div>
							<div class = 'text_field'>
								<span>Confirm Password: </span><input type="password" name="cpassword"  required />
								<?php
								if(isset($_SESSION["passError"])){
									$error = $_SESSION["passError"];
									echo "<span style='color:red'>$error</span>";
								}
								?>
							</div>
							<input type="hidden" id="userType" name="userType" value="Organization">
							<div class = 'text_field'>
								<span>Name: </span><input type="text" name="name" required />
							</div>
							<div class = 'text_field'>
								<span>Organization Name: </span><input type="text" name="orgname" required />
							</div>
							<div class = 'text_field'>
								<span>Organization Website: </span><input type="text" name="orgsite" required />
								<?php
								if(isset($_SESSION["error"])){
									$error = $_SESSION["error"];
									echo "<span style='color:red'>$error</span>";
								}
								?>
							</div>
							<!--
							<div class="checkboxes">
								<label><input name="accept" type="checkbox" class="tickbox" value="1" required /><span>   
								I Accept the Terms and Conditions</span> </label>
							</div> -->
							</br><input type="submit" name = "submit" value="Continue">
						</form>
					</div>
                </div>
            </div>
	  </div>
    </div>
<?php
	}
	else{
		if (isset($_POST['password'])){
			$password = hash('md5',$_POST['password']);
			//$password = $_POST['password'];
			$_SESSION['password'] = $password;
		}
		
		
		if (isset($_POST['email'])){
			$email = $_POST['email'];
			$_SESSION['email'] = $email;
		}
		
		if (isset($_POST['name'])){
			$name = $_POST['name'];
			$_SESSION['name'] = $name;
		}
		

		if (isset($_POST['orgname'])){
			$orgName = $_POST['orgname'];
			$_SESSION['orgName'] = $orgName;
		}
		
		if (isset($_POST['orgsite'])){
			$orgWeb = $_POST['orgsite'];
			$_SESSION['orgWeb'] = $orgWeb;
		}

		if (isset($_SESSION['password'])){
			$password = $_SESSION['password'];
		} 
		if (isset($_SESSION['name'])){
			$name = $_SESSION['name'];
		} 
		if (isset($_SESSION['email'])){
			$email = $_SESSION['email'];
		} 
		if (isset($_SESSION['userType'])){
			$userType = $_SESSION['userType'];
		} 
		if (isset($_SESSION['orgName'])){
			$orgName = $_SESSION['orgName'];
		} 
		if (isset($_SESSION['orgWeb'])){
			$orgWeb = $_SESSION['orgWeb'];
		} 

	
		if (isset($_POST['submit']) and ($_POST['submit'] == 'Sign Up'))
		{
			$_SESSION['category1'] = $_POST['category1'];
			$_SESSION['category2'] = $_POST['category2'];
			$_SESSION['category3'] = $_POST['category3'];
			$_SESSION['category4'] = $_POST['category4'];
			$_SESSION['category5'] = $_POST['category5'];
			//$_SESSION['agerange'] = $_POST['agerange'];
			$verification_code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);
			$_SESSION['vCode'] = $verification_code;		
			header("Location: email_verification.php");
		}
?>
		<div class="wrapper">
        <div class="container main">
            <div class="row">
                <div class="col-md-6 side-image">
                    <!-------Image-------->
                 
                    <div class="text">
                        <p><a name='recs' href='default.php'>RECS</a></p>
						<a name = 'ref' href="https://www.vecteezy.com/free-vector/helping-others">Helping Others Vectors by Vecteezy</a>
                    </div>
                </div>
                <div class="col-md-6 right">
                     <div class = 'orgreg'>
					 
						<a href="login.php"><h1 name = 'login' >LOGIN</h1></a>
						<a href="org_register.php"><h1 name = 'register'>SIGN UP</h1 ></a>
						<a href="org_register.php"><h3 name = 'orgregister'>Organization</h3></a>
						<a href="indiv_register.php"><h3 name = 'indivregister'>Individual</h3></a>
					
						<form action = "org_register.php" id = "org_register" name = "org_register" method = "POST">
							<input type="hidden" id="userType" name="userType" value="Individual">
					<div style = 'transform: translate(0%, 80%);'><h2 class = "heading11" id = "heading11" style = 'font-size: 20px;  text-align:center; font-weight: 600;'>Choose the type(s) of product<br/> you are selling</h2></div>
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

			<!--<div  style = "transform: translate(80%, 200%);">
				<a id="next-btn" class="hidden" onclick="showAgeGroup()">Next</a>
			</div>
		</div>
		<div id="age-group" class="hidden" >
			<div class="row11">
				
				<div class="box11" onclick="selectAgeGroup(this)">18-24</div>
				<div class="box11" onclick="selectAgeGroup(this)">25-34</div>
			</div>
			<div class="row11">
				
				<div class="box11" onclick="selectAgeGroup(this)">35-44</div>
				<div class="box11" onclick="selectAgeGroup(this)">45+</div>
			</div>
			</div>-->
							<!--
							<div class="checkboxes">
								<label><input name="accept" type="checkbox" class="tickbox" value="1" required /><span>   
								I Accept the Terms and Conditions</span> </label>
							</div>-->	
							<input type="hidden" name="category1" id="category1" value="">
							<input type="hidden" name="category2" id="category2" value="">
							<input type="hidden" name="category3" id="category3" value="">
							<input type="hidden" name="category4" id="category4" value="">
							<input type="hidden" name="category5" id="category5" value="">
							<input type="hidden" name="agerange" id="agerange" value="">
							</br><input type="submit" name = "submit" id = "next-btn-2" class="hidden" value="Sign Up" style = 'width: 70%; transform: translate(23%, 0%);'>
						</form>
					</div>
                </div>
            </div>
	  </div>
    </div>
<?php 
}
?>
<script>
// to close the success box
document.querySelector('.close-button').addEventListener('click', function() {
			document.querySelector('.success-box').style.display = 'none';
		});

var selectedInterests = [];
var selectedAgeGroup = '';

function selectInterest(box) {
    let selectedBoxes = document.querySelectorAll(".selected");
    if (selectedBoxes.length < 5 || box.classList.contains("selected")) {
        box.classList.toggle("selected");
      
        selectedBoxes = document.querySelectorAll(".selected");
        if (selectedBoxes.length >= 1) {
            document.getElementById("next-btn-2").classList.remove("hidden");
			  selectedInterests = [];
            selectedBoxes.forEach(box => {
                selectedInterests.push(box.innerHTML);
            });
        } else {
            document.getElementById("next-btn-2").classList.add("hidden");
        }
    }
	
	
	 document.org_register.category1.value = selectedInterests[0];
	 if (selectedInterests[1] !== undefined){
		 document.org_register.category2.value = selectedInterests[1];
	 }
	 
	 if (selectedInterests[2] !== undefined){
		document.org_register.category3.value = selectedInterests[2];
	 }
	 
	 if (selectedInterests[3] !== undefined){
		document.org_register.category4.value = selectedInterests[3];
	 }
	 
	  if (selectedInterests[4] !== undefined){
	 document.org_register.category5.value = selectedInterests[4];
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
		document.getElementById("heading11").style.transform =  "translate(0%, 40%)";
		document.getElementById("heading11").innerHTML = 'Choose your target age group';	
		setTimeout(function() { document.getElementById("heading11").classList.remove("hidden"); }, 500);
		
    }, 1000);
	
		
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
  
  document.org_register.agerange.value = selectedAgeGroup;
}

</script>
</body>
</html>
