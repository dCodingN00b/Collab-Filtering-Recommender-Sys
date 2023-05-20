<html lang="en">
<head>
<meta charset="UTF-8">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="login_style.css?version14">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">

<title>Forget Password</title>
<style>
.success-box {
	background-color: whitesmoke;
	color: white;
	padding: 20px;
	left: 0;
	width: 100%;
	z-index: 9999;
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
    include("inc_db_fyp.php");
    include("user.php");
    $success = 0;
    
    if(isset($_POST["verifyEmail"])) {
        $user = new User();
        if($user->checkEmail($_POST['email'])){
			$verification_code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);
			
			$_SESSION["vCode"] = $verification_code;
			//mail($_POST["email"], "Email  Verification", $verification_code);
			//echo  $verification_code ;
			$email = $_POST["email"];
			 
			require_once('C:/Users/Administrator/vendor/autoload.php');

			$credentials = SendinBlue\Client\Configuration::getDefaultConfiguration()->setApiKey('api-key', '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');
			$apiInstance = new SendinBlue\Client\Api\TransactionalEmailsApi(new GuzzleHttp\Client(),$credentials);

			$sendSmtpEmail = new \SendinBlue\Client\Model\SendSmtpEmail([
				 'subject' => 'Email Verification',
				 'sender' => ['name' => 'RECS', 'email' => 'fyprecs@gmail.com'],
				 //'replyTo' => ['name' => 'Sendinblue', 'email' => 'contact@sendinblue.com'],
				 'to' => [[ 'name' => "user", 'email' =>"$email"]],
				 'htmlContent' => "<html><body><h1>$verification_code</h1></body></html>",
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
        }else{
			$_SESSION['error'] = "Email address not found";
		}
    }
    if(isset($_POST["verifyCode"])){
        $code = $_POST['digit1'] . $_POST['digit2'] .  $_POST['digit3'] . $_POST['digit4'] .  $_POST['digit5'] .  $_POST['digit6'];
		/*
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
		*/
		if ($code == $_POST['vCode']){
			$success = 2;
		}else{
            $_SESSION["error"] = "verification failed";
            $success = 1;
        }
    }
    if(isset($_POST["updatePass"])) {
        if($_POST['Password']  ==  $_POST["Password2"]){
			$user = new User();	
            $user -> updatePassword(hash('md5',$_POST['Password']), $_POST['email']);
			  #display success
			if (isset($_SESSION['successStatus'])){
				echo"<div class='success-box'>
						<p>{$_SESSION['successStatus']}</p>
					</div>";
				
				unset($_SESSION['successStatus']);
			}
			header("refresh:2; url=login.php");
        }else{
			$_SESSION["error"] = "Password missmatch";
			$success = 2;
        }
    }
    
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
                     <div class = 'login'>
					 <a href="login.php"><h1 name = 'login'>LOGIN</h1></a>
					        	<a href="org_register.php"><h1 name = 'register'>SIGN UP</h1></a>
    <?php
        if($success == 1){
        // enter otp html
    ?>
	<img class = 'emailimg' src="images/email2.svg" alt="">
    <form action = "forgetPassword.php" method = "POST">
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
		<?php
			if(isset($_SESSION["error"])){
				$error = $_SESSION["error"];
				echo "<span style='color:red; margin-left:65px;'>$error</span>";
			}
		?>
		
		
		<input type="hidden" name = "email" value = "<?php  echo $_POST['email']; ?>" >
		<input type="hidden" name = "vCode" value = "<?php echo $verification_code; ?>" >
		<input type="submit" name="verifyCode" value="Verify" style = 'margin-top: 30px;'>
	</form>
	<?php
        }elseif($success == 2){
    ?>
        <form action = "forgetPassword.php" method = "POST">
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
					<input type="password" name="Password" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*_=+-]).{8,}$" required />
		    </div>
		    <div class = 'text_field'>
			    <span>Re-enter password: </span><input type="password" name="Password2"required />
					<?php
						if(isset($_SESSION["error"])){
							$error = $_SESSION["error"];
							echo "<span style='color:red'>$error</span>";
						}
					?>
		    </div>
		    <input type="hidden" name = "email" value = "<?php  echo $_POST['email']; ?>" >
		    <input type="submit" name = "updatePass" value="update">
		 </form>
	<?php
        }else{
    ?>
    <form action = "forgetPassword.php" method = "POST">
		<div class = 'text_field'>
			<span>Email: </span><input type="text" name="email"required />
			<?php
				if(isset($_SESSION["error"])){
					$error = $_SESSION["error"];
					echo "<span style='color:red'>$error</span>";
				}
			?>
		</div>
		<input type="submit" name = "verifyEmail" value="Verify">
	</form>
	<?php
    	}
	?>
</body>
</html>