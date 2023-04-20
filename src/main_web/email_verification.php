<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="email_verification_style.css?version17">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
<title>Email Verification Page</title>
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

/* scrollbar customization*/
::-webkit-scrollbar {
  width: 10px;
}

::-webkit-scrollbar-track {
  background: #f1f1f1; 
}
 
::-webkit-scrollbar-thumb {
  background: #888; 
}

::-webkit-scrollbar-thumb:hover {
  background: #555; 
}

input {
  width: 30px;
  height: 30px;
  font-size: 24px;
  text-align: center;
  margin-right: 0;
  padding: 5px;
  border: 1px solid #ccc;
  border-radius: 5px;
  display: inline-block;
}
</style>
</head>
<body>

<?php
    session_start();
    include('user.php');
	
	

    $verification_code = $_SESSION["vCode"];
	$userType = $_SESSION['userType'];
      
   

    $DisplayForm = TRUE;
	if (isset($_POST['submit'])){
		$code = $_POST['digit1'] . $_POST['digit2'] .  $_POST['digit3'] . $_POST['digit4'] .  $_POST['digit5'] .  $_POST['digit6'];
	    if($verification_code  == $code){
	        $DisplayForm = FALSE;
	    }
	}
	
	if ($DisplayForm){
		// send email
		mail($_SESSION["email"], "Email  Verification", $verification_code);
		//echo $verification_code;
	}
	
	if($DisplayForm){
    ?><div class="wrapper">
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
                     <div class = 'reg'>
					 
						<a href="login.php"><h1 name = 'login' >LOGIN</h1></a>
						<a href="org_register.php"><h1 name = 'register'>SIGN UP</h1 ></a>
						
						<?php 
						if ($userType == '2'){
						?>
							<a href="org_register.php"><h3 name = 'orgregister' style = 'border-bottom:2px solid lavender; color: grey;' 
							onmouseover = 'style = "border-bottom:2px solid lightgreen; color:green;"'
							onmouseout = 'style = "border-bottom:2px solid lavender; color:grey;"' >Organization</h3></a>
							<a href="indiv_register.php"><h3 name = 'indivregister' style = 'border-bottom:2px solid lightgreen;'>Individual</h3></a>
						<?php 
						} 
						else if ($userType == '1')
						{
						?>
							<a href="org_register.php"><h3 name = 'orgregister' style = 'border-bottom:2px solid lightgreen; '>Organization</h3></a>
							<a href="indiv_register.php"><h3 name = 'indivregister' style = 'border-bottom:2px solid lavender; color: grey;' onmouseover = 'style = "border-bottom:2px solid lightgreen; color:green;"'
							onmouseout = 'style = "border-bottom:2px solid lavender; color:grey;"''>Individual</h3></a>
						<?php
						}
						?>
						<img class = "emailimg" src="images/email2.svg" alt="">
						
							
							<form action = "email_verification.php"  method="POST">
								<p style = 'margin-left: 65px; font-size:24px; margin-top: 230px;'><b>Verify Your Email</b></p>
								<p style = 'margin-left: 0px; font-size:16px; margin-top: 10px; text-align:center;'>Please enter in the six digit code which we sent to your email.</p>
								
								<div class = 'text_field' style = 'margin-top:10px;margin-left:65px;'>
									
									
								<input type="text" name="digit1" maxlength="1">
								<input type="text" name="digit2" maxlength="1">
								<input type="text" name="digit3" maxlength="1">
								<input type="text" name="digit4" maxlength="1">
								<input type="text" name="digit5" maxlength="1">
								<input type="text" name="digit6" maxlength="1">
								</div>
								
								
								<input type="hidden" name = "originalCode" value = '<?php  echo $verification_code; ?>' >
								<input type="submit" name="submit" value="Verify">
							</form>
					</div>
                </div>
            </div>
	  </div>
    </div>							
    <?php
	}
	else{
	    $email = $_SESSION['email'];
	    $userType = $_SESSION['userType'];
	    $name = $_SESSION['name'];
	    $password = $_SESSION['password'];
	    $orgName = $_SESSION['orgName'];
	    $orgWeb = $_SESSION['orgWeb'];
	    
	    /*
	    // user type 1 (organization user)
	    if ($userType == 1){
	        $orgName = $_SESSION['orgName'];
	        $orgWeb = $_SESSION['orgWeb'];
	   // user type 2 (individual)
	    }else if ($userType == 2){
	        $orgName ="";
	        $orgWeb = "";
	    }
	    */
	   
	
		if (isset($_SESSION['category1'])){
			$category1 = $_SESSION['category1'];
		}
		else {
			$category1 = '';
		}
		/*
		if (isset($_SESSION['category2'])){
			$category2 = $_SESSION['category2'];
		}
		else {
			$category2 = '';
		}
		
		if (isset($_SESSION['agerange'])){
			$agerange = $_SESSION['agerange'];
		}
		else {
			$agerange = '';
		}
		*/
		
		
		if ($category1 == null){
			$category1 = "";
		}
		
	    #call user entity method to register
	    $user = new User();
	    $status = $user -> registerUser($email, $userType, $name, $password, $orgName, $orgWeb, $category1);
	    if($status == true){
	       
	        if (isset($_SESSION['successStatus'])){
    		echo"<div class='success-box'>
    				<p>{$_SESSION['successStatus']}</p>
    			</div>";
    		
    		unset($_SESSION['successStatus']);
    	    }else{
    	        echo"<p>register failed</p>";
    	    }
    	    $DisplayForm = FALSE;
    	header("refresh:5; url=login.php");

		}else{
	        echo"<p>error registering, please contact administrator. </p>";
	    }
		
	    #display success

    	unset($_POST['submit']);

	    
	}
	
	
?>

</body>
</html>