<?php 
    session_start();
	// If the user is not logged in redirect to the login page...
	if (isset($_SESSION['loggedin'])) {
		header('Location:home.php');
		exit();
	}

?>
 <!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="login_style.css?version14">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
<title>Login Page</title>
<style>
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
    include("inc_db_fyp.php");
    include("user.php");
    $success = 0;
    
    if(isset($_POST["login"])) {
        $user = new User();
        if($user->checkLogin($_POST['email'], $_POST['password'])){
             $verification_code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);
             mail($_POST["email"], "Email  Verification", $verification_code);
			 //echo  $verification_code ;
             $sql = "INSERT INTO otp (code) VALUES('$verification_code')";
             mysqli_query($conn, $sql);
             $success = 1;
        }
    }
    if(isset($_POST["verify"])){
        $code = $_POST['digit1'] . $_POST['digit2'] .  $_POST['digit3'] . $_POST['digit4'] .  $_POST['digit5'] .  $_POST['digit6'];
        $sqlGetCode = "SELECT * FROM otp WHERE code = $code";
        $result = mysqli_query($conn, $sqlGetCode);
        $count = mysqli_num_rows($result);
       
        if($count > 0){
            $sqlDel = "DELETE FROM otp where code = $code";
            mysqli_query($conn, $sqlDel);
           
            $success = 2;
           
        }else{
            $_SESSION["error"] = "verification failed";
            $success = 1;
        }
    }
    ?>
   <div class="wrapper">
        <div class="container main">
            <div class="row">
                <div class="col-md-6 side-image">
                    <!-------Image-------->
                    <img src="images/white.png" alt="">
                    <div class="text">
                        <p><a name='recs' href='main.php'>RECS</a></p>
						<a name = 'ref' href="https://www.vecteezy.com/free-vector/helping-others">Helping Others Vectors by Vecteezy</a>
                    </div>
                </div>
                <div class="col-md-6 right">
                     <div class = 'login'>
					
						    <?php
						        
						        if($success == 1){
						            // enter otp html
						    ?>
							<img class = 'emailimg' src="images/email2.svg" alt="">
						    
							<a href="login.php"><h1 name = 'login'>LOGIN</h1></a>
					        	<a href="org_register.php"><h1 name = 'register'>SIGN UP</h1></a>
								<form action = "login.php" method = "POST">
							    <p style = 'margin-left: 65px; font-size:24px; margin-top: 230px;'><b>Verify Your Email</b></p>
							    <p style = 'margin-left: 0px; font-size:16px; margin-top: 10px; text-align:center;'>Please enter in the six digit code which we sent to your email.</p>
								
								<div class = 'text_field_verification' style = 'margin-top:10px;margin-left:65px;'>
									
									
									<input type="text" name="digit1" maxlength="1">
									<input type="text" name="digit2" maxlength="1">
									<input type="text" name="digit3" maxlength="1">
									<input type="text" name="digit4" maxlength="1">
									<input type="text" name="digit5" maxlength="1">
									<input type="text" name="digit6" maxlength="1">
								</div>
								
								
								<input type="hidden" name = "email" value = "<?php  echo $_POST['email']; ?>" >
								<input type="submit" name="verify" value="Verify" style = 'margin-top: 30px;'>
							</form>
						    <?php
						        }elseif($success == 2){
						            // success and redirect to home page
						            $user = new User();
									$user-> checkAndUpdateFreeTrial($_POST['email']);
						            $userinfo = $user->getInfo($_POST['email']);
	                            	$_SESSION['loggedin'] = TRUE;
		                        	$_SESSION['email'] = $userinfo['emailAddress'];
		                        	$_SESSION['id'] = $userinfo['userID'];
                        			$_SESSION['userType'] = $userinfo['userType'];
                        			$_SESSION['name'] = $userinfo['name'];
                        			$_SESSION['dateTimeOfCreation'] = $userinfo['dateTimeOfCreation'];
									$_SESSION['freeTrialExpiryDate'] = $userinfo['freeTrialExpiryDate'];
                        			$_SESSION['pricePlan'] = $userinfo['pricePlan'];
			
                        			print_r($_SESSION);
                        			header('Location: home.php');
						        }else{
						    ?>
				
						<a href="login.php"><h1 name = 'login'>LOGIN</h1></a>
						<a href="org_register.php"><h1 name = 'register'>SIGN UP</h1></a>
					
						<form action = "login.php" method = "POST">
							<div class = 'text_field'>
								<span>Email: </span><input type="text" name="email"required />
							</div>
							<div class = 'text_field'>
								<span>Password: </span><input type="password" name="password" required />
								<?php
								if(isset($_SESSION["error"])){
									$error = $_SESSION["error"];
									echo "<span style='color:red'>$error</span>";
								}
								?> 
							</div>
							<div class="pass">
								<a href="forgetPassword.php">Forgot Password?</a>
							</div>
							<input type="submit" name = "login" value="Sign In" >
						</form>
					</div>
                </div>
							<?php
						        }
						      ?>
					</div>
				</div>
            </div>
		</div>
     </div>
</body>
</html>

<?php
    unset($_SESSION["error"]);
?>
