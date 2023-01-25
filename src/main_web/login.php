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
			Username: <input type="text" name="username" />
			<label>Username</label>
		</div>
		<div class = 'text_field'>
			Password: <input type="password" name="password" required />
			<label>Password</label>
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

