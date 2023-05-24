<?php 
    session_start();
	//unset($_SESSION["error"]);
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
	
    unset($_SESSION["error"]);
	unset($_SESSION["emailError"]);
	unset($_SESSION["passError"]);
	

	
    
    if(isset($_POST["login"])) {
        $user = new User();
        if($user->checkLogin($_POST['email'],  hash('md5',$_POST['password']))){
			$verification_code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);			
			$_SESSION["vCode"] = $verification_code;
			$email = $_POST["email"];
			
			require_once('C:/Users/Administrator/vendor/autoload.php');
			
			$message = "Dear User,<br/><br/>";
			$message .= "We have detected an attempt to sign in to your account using Two-Factor Authentication (2FA). To ensure the security of your account, please complete the verification process by entering the following 6-digit verification code:<br/><br/>";
			$message .= "Verification Code: <b>" . $verification_code . "</b><br/><br/>";
			$message .= "If you did not initiate this sign-in attempt or believe this email was sent to you in error, please contact our support team immediately at fyprecs.service@gmail.com.<br/><br/>";
			$message .= "Thank you for using our services!<br/><br/>";
			$message .= "Best regards,<br/>";
			$message .= "The RECS Development Team";

			//put in the api-key that you have generated
			//the api-key can't be placed in github for security reasons (Brevo/SendInBlue's policy)
			$credentials = SendinBlue\Client\Configuration::getDefaultConfiguration()->setApiKey('api-key', '');
			$apiInstance = new SendinBlue\Client\Api\TransactionalEmailsApi(new GuzzleHttp\Client(),$credentials);

			$sendSmtpEmail = new \SendinBlue\Client\Model\SendSmtpEmail([
				 'subject' => 'Two-Factor Authentication (2FA) Verification Required',
				 'sender' => ['name' => 'RECS', 'email' => 'fyprecs@gmail.com'],
				 //'replyTo' => ['name' => 'Sendinblue', 'email' => 'contact@sendinblue.com'],
				 'to' => [[ 'name' => "user", 'email' =>"$email"]],
				 'htmlContent' => "<html><body>". $message ."</body></html>",
				 'params' => ['bodyMessage' => 'made just for you!']
			]);
			
			try {
			$result = $apiInstance->sendTransacEmail($sendSmtpEmail);
			//print_r($result);
			} catch (Exception $e) {
				echo $e->getMessage(),PHP_EOL;
			}
			
			//echo $verification_code;
		
             $success = 1;
        }	
		else{
			$user = new User();
			if($user->checkEmail($_POST['email']) != TRUE){
				$_SESSION["emailError"] = "Email doesn't exist";
			}
			else{
				$_SESSION["passError"] = "Incorrect password";
			}
			//$_SESSION["error"]  =  "Invalid login details";
			
		}
    }
    if(isset($_POST["verify"])){
        $code = $_POST['digit1'] . $_POST['digit2'] .  $_POST['digit3'] . $_POST['digit4'] .  $_POST['digit5'] .  $_POST['digit6'];
       
		if (isset($_SESSION["vCode"])){
			$verification_code = $_SESSION["vCode"];
		}
	
        if ($verification_code == $code){
			$success = 2;
		}
		else {
            $_SESSION["error"] = "Verification failed";
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
							    <p style = 'margin-left: 60px; font-size:24px; margin-top: 230px;'><b>Verify that it's you</b></p>
							    <p style = 'margin-left: 0px; font-size:16px; margin-top: 10px; text-align:center;'>Please enter in the six digit code which we sent to your email.</p>
								
								<div class = 'text_field_verification' style = 'margin-top:10px;margin-left:65px;'>
									
									
									<input type="text" name="digit1" maxlength="1">
									<input type="text" name="digit2" maxlength="1">
									<input type="text" name="digit3" maxlength="1">
									<input type="text" name="digit4" maxlength="1">
									<input type="text" name="digit5" maxlength="1">
									<input type="text" name="digit6" maxlength="1">
									<?php
									if(isset($_SESSION["error"])){
									$error = $_SESSION["error"];
									echo "<span style='color:red'>$error</span>";
									}
									?>
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
									$_SESSION['accountStatus'] = $userinfo['accountStatus'];
                        			
									if ($userinfo['accountStatus'] == 'Suspended'){
										header('Location: accountsuspended.php');
										exit();
									}
                        			header('Location: home.php');
						        }else{
						    ?>
				
						<a href="login.php"><h1 name = 'login'>LOGIN</h1></a>
						<a href="org_register.php"><h1 name = 'register'>SIGN UP</h1></a>
					
						<form action = "login.php" method = "POST">
							<div class = 'text_field'>
								<span>Email: </span><input type="email" name="email"required />
								<?php
									if(isset($_SESSION["emailError"])){
									$error = $_SESSION["emailError"];
									echo "<span style='color:red'>$error</span>";
									}
									?>
							</div>
							<div class = 'text_field'>
								<span>Password: </span><input type="password" name="password" required />
								<?php
								if(isset($_SESSION["passError"])){
									$error = $_SESSION["passError"];
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


