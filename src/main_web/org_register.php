<?php session_start(); ?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="orgregister_style.css?version13">
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
	</style>
</head>
<body>
<?php
	include ('inc_db_fyp.php');
	include ('user.php');
	
	$DisplayForm = TRUE;
	$userType = '';
	if (isset($_POST['submit'])){
		if ($_POST['userType'] == 'Organization'){			
			$userType = 1;
			$DisplayForm = False; 
		}else if($_POST['userType'] == 'Individual'){			
			$userType = 2;
			$DisplayForm = False; 
		}
		if ($_POST['password'] != $_POST['cpassword']){
			echo "<p> Password does not match </p>";
			$DisplayForm = True; 
		}else {
			#call method inside user entity class to check if email already in database, return bool
			$user = new User();
			$DisplayForm = $user -> checkEmail($_POST['email']);
		}
		
		#display error if email already taken
		if (isset($_SESSION['successStatus'])){
			echo"<p>{$_SESSION['successStatus']}</p>";
			
			unset($_SESSION['successStatus']);
		}
	}
	
	if ($DisplayForm){
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
						<form action = "org_register.php" method = "POST">
							<div class = 'text_field'>
								<span>Email: </span></span><input type="email" name="email" required />
							</div>
							<div class = 'text_field'>
								<span>Password: </span><input type="password" name="password" required />
							</div>
							<div class = 'text_field'>
								<span>Confirm Password: </span><input type="password" name="cpassword" required />
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
							</div>
							<div class="checkboxes">
								<label><input name="accept" type="checkbox" class="tickbox" value="1" required /><span>   
								I Accept the Terms and Conditions</span> </label>
							</div>
							</br><input type="submit" name = "submit" value="Sign Up">
						</form>
					</div>
                </div>
            </div>
	  </div>
    </div>
<?php
	}
	else{
		$password = $_POST['password'];
		$email = $_POST['email'];
		$name = $_POST['name'];
		$orgName = $_POST['orgname'];
		$orgWeb = $_POST['orgsite'];


		#call user entity method to register
		$user-> registerUser($email, $userType, $name, $password, $orgName, $orgWeb);
		
		#display success
		if (isset($_SESSION['successStatus'])){
			echo"<div class='success-box'>
				
					<p>{$_SESSION['successStatus']}</p>
				</div>";
			
			unset($_SESSION['successStatus']);
		}
		header("refresh:3; url=login.php");
		
		$DisplayForm = False;
		$_POST['userType'] == '';
		unset($_POST['submit']);
	}
?>
<script>
// to close the success box
document.querySelector('.close-button').addEventListener('click', function() {
			document.querySelector('.success-box').style.display = 'none';
		});
</script>
</body>
</html>
