<?php session_start() ?>
 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login_style.css?version9">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <title>Login Page</title>
</head>
<body>
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
                     <div class = 'login'>
					 
						<a href="login.php"><h1 name = 'login'>LOGIN</h1></a>
						<a href="org_register.php"><h1 name = 'register'>SIGN UP</h1></a>
					
						<form action = "authenticate.php" method = "POST">
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
							<div class="pass">Forgot Password?</div>
							<input type="submit" value="Sign In">
						</form>
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
