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
            mail($_POST["email"], "Email  Verification", $verification_code);
			//echo $verification_code;
             $sql = "INSERT INTO otp (code) VALUES('$verification_code')";
             mysqli_query($conn, $sql);
             $success = 1;
        }
    }
    if(isset($_POST["verifyCode"])){
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
    if(isset($_POST["updatePass"])) {
        if($_POST['Password']  ==  $_POST["Password2"]){
			$user = new User();	
            $user -> updatePassword($_POST['Password'], $_POST['email']);
			  #display success
			if (isset($_SESSION['successStatus'])){
				echo"<div class='success-box'>
						<p>{$_SESSION['successStatus']}</p>
					</div>";
				
				unset($_SESSION['successStatus']);
			}
			header("refresh:2; url=login.php");
        }else{
            echo"<p> Password missmatch </p>";
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
		
		
		<input type="hidden" name = "email" value = "<?php  echo $_POST['email']; ?>" >
		<input type="submit" name="verifyCode" value="Verify" style = 'margin-top: 30px;'>
	</form>
	<?php
        }elseif($success == 2){
    ?>
        <form action = "forgetPassword.php" method = "POST">
            <div class = 'text_field'>
			    <span>Password: </span><input type="password" name="Password"required />
		    </div>
		    <div class = 'text_field'>
			    <span>Re-enter password: </span><input type="password" name="Password2"required />
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
		</div>
		<input type="submit" name = "verifyEmail" value="Verify">
	</form>
	<?php
    	}
	?>
</body>
</html>