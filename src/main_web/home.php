<?php
	// We need to use sessions, so you should always start sessions using the below code.
	session_start();
	// If the user is not logged in redirect to the login page...
	if (!isset($_SESSION['loggedin'])) {
		header('Location:login.php');
		exit;
	}
?>

<!DOCTYPE html>
<html>
<head>
<title>Login</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
 <link rel="stylesheet" href="home_style.css">

</head>
<body>
	<header>
			<p>Upload Databases</p>
            <nav>
                <ul class="nav-titles">
                    <li><a href="#"></a></li>
					<li><a href="#"></a></li>
					<li><a href="#"></a></li>
					<li><a href="#"></a></li>
					<li><a href="logout.php">Logout</a></li>
					<div class="dropdown">
						<button class="profile"><?=$_SESSION['name'][0]?></button>
						<div class="profile-content">
						  <a class="logout" href="logout.php">Logout</a></li>
						</div>
					  </div>
					</div>
                </ul>
			</nav>
			
		</header>
		
		<h1>Welcome back, <?=$_SESSION['name']?>!</h1>
</body>
</html>
