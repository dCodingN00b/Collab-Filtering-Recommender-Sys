<!DOCTYPE html>
<html>
<head>
<title>Create 'users' Table</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
</head>
<body>
<?php
$TableName = "users";
include("inc_db_fyp.php");

try {
	$SQLstring = "SHOW TABLES LIKE '$TableName'";
	$QueryResult = mysqli_query($conn, $SQLstring);
	if (mysqli_num_rows($QueryResult) == 0) {
		$SQLstring = "CREATE TABLE users (userID SMALLINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
						userName VARCHAR(80), password CHAR(100))";
		$QueryResult = mysqli_query($conn, $SQLstring);
        echo "<p>Successfully created the " . "users table.</p>";
	}
	else
		echo "<p>The users table already exists.</p>";
}
catch (mysqli_sql_exception $e) {
    echo "<p>Unable to execute the query.</p>" . "<p>Error code " . mysqli_errno($conn) . ": " . mysqli_error($conn) . "</p>";
}

mysqli_close($conn);
?>
</body>
</html>
