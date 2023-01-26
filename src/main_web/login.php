<?php session_start() ?>
<!DOCTYPE html>
<html>
<head>
<title>Login</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
 <link rel="stylesheet" href="Login_Style.css">
</head>
<body>
<div class = 'login'>
	<h1>Login</h1>
	<form action = "authenticate.php" method = "POST">
		<div class = 'text_field'>
			<p>Username: </p><input type="text" name="username"required />
		</div>
		<div class = 'text_field'>
			<p>Password: </p><input type="password" name="password" required />
			<?php
			if(isset($_SESSION["error"])){
				$error = $_SESSION["error"];
				echo "<span>$error</span>";
			}
			?> 
		</div>
		<div class="pass">Forgot Password?</div>
        <input type="submit" value="Sign In">
        <div class="signup_link">
          New to Web Page? <a href="#">Sign Up</a>
        </div>
	</form>
</div>
</body>
</html>

<?php
    unset($_SESSION["error"]);
?>

