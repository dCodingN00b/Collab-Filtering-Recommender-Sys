<?php
//start the session
	session_start();
	//connecting to DB
	include("inc_db_fyp.php");
	
	
	// Now we check if the data from the login form was submitted, isset() will check if the data exists.
	if ( !isset($_POST['username'], $_POST['password']) ) {
		// Could not get the data that should have been sent.
		$error = 'Please fill both the username and password fields!';
		$_SESSION["error"] = $error;
		exit('');
	}
	
	// Prepare our SQL, preparing the SQL statement will prevent SQL injection.
	if ($stmt = $conn->prepare('SELECT userID, password FROM users WHERE userName = ?')) {
		// Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
		$stmt->bind_param('s', $_POST['username']);
		$stmt->execute();
		// Store the result so we can check if the account exists in the database.
		$stmt->store_result();

		if ($stmt->num_rows > 0) {
		$stmt->bind_result($userID, $password);
		$stmt->fetch();
		// Account exists, now we verify the password.
		// Note: remember to use password_hash in your registration file to store the hashed passwords.
		if ($_POST['password'] === $password) {
			// Verification success! User has logged-in!
			// Create sessions, so we know the user is logged in, they basically act like cookies but remember the data on the server.
			session_regenerate_id();
			$_SESSION['loggedin'] = TRUE;
			$_SESSION['name'] = $_POST['username'];
			$_SESSION['id'] = $userID;
			header('Location: home.php');
		} else {
			// Incorrect password
			$error = 'Incorrect Username and/or Password';
			$_SESSION["error"] = $error;
			header('Location: login.php');
		}
		} else {
			// Incorrect username
			$error = 'Incorrect Username and/or Password';
			$_SESSION["error"] = $error;
			header('Location: login.php');
		}

		//close connection
		$stmt->close();
		
	}

?>