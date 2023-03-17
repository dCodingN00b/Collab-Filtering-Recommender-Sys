<?php session_start(); ?>
 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="indivregister_style.css?version5">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <title>Sign Up Page</title>
</head>
<body>
<?php
	include ('inc_db_fyp.php');
	$DisplayForm = TRUE;
	$userType = '';
	if (isset($_POST['submit'])){
		echo "<p> hello! i am here! </p>";
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
		}	
		$stmt = $conn->prepare("SELECT emailAddress FROM users WHERE emailAddress = ?");
		$stmt->bind_param('s', $_POST['email']);
		$stmt->execute();
		$stmt->store_result();
		
		if($stmt->num_rows > 0){
			echo "<p> Email already used </p>";
			$DisplayForm = True;
		}
		
	}
	
	if ($DisplayForm){
		?>
   <div class="wrapper">
        <div class="container main">
            <div class="row">
                <div class="col-md-6 side-image">
                    <!-------Image-------->
                    <img src="images/white.png" alt="">
                    <div class="text">
                        <p><a name='recs' href='default.php'>RECS</a></p>
						<a name = 'ref' href="https://www.vecteezy.com/free-vector/helping-others">Helping Others Vectors by Vecteezy</a>
                    </div>
                </div>
                <div class="col-md-6 right">
                     <div class = 'indreg'>
					 
						<a href="login.php"><h1 name = 'login' >LOGIN</h1></a>
						<a href="org_register.php"><h1 name = 'register'>SIGN UP</h1 ></a>
						<a href="org_register.php"><h3 name = 'orgregister'>Organization</h3></a>
						<a href="indiv_register.php"><h3 name = 'indivregister'>Individual</h3></a>
					
						<form action = "indiv_register.php" method = "POST">
							<div class = 'text_field'>
								<span>Email: </span><input type="email" name="email" required />
							</div>
							<div class = 'text_field'>
								<span>Password: </span><input type="password" name="password" required />
							</div>
							<div class = 'text_field'>
								<span>Confirm Password: </span><input type="password" name="cpassword" required />
							</div>
							<input type="hidden" id="userType" name="userType" value="Individual">
							<div class = 'text_field'>
								<span>Name: </span><input type="text" name="name" required />
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
		$orgName = '';
		$orgWeb = '';
		if (isset($_POST['orgname'])){
			$orgName = $_POST['orgname'];
		}
		if (isset($_POST['orgsite'])){
			$orgWeb = $_POST['orgsite'];
		}

	
		$stmt = $conn->prepare("INSERT INTO `users`(`userType`, `userName`, `password`, `emailAddress`, `Organization Name`, `Organization Website`)
								VALUES (?,?,?,?,?,?)");
		$stmt->bind_param("ssssss", $userType, $name, $password, $email, $orgName, $orgWeb);
		$stmt->execute();
		$stmt->close();
		$userID = mysqli_insert_id($conn);
		echo " <p>your user id is $userID </p>";
		echo "<p> Thank you for signing up! </p>";
		echo "<p> You will be redirected to Login page ...</p>";
		header("refresh:3; url=login.php");
		
		$DisplayForm = False;
		$_POST['userType'] == '';
		unset($_POST['submit']);
	}
?>
</body>
</html>
