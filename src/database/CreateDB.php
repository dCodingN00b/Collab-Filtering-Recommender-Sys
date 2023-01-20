<!DOCTYPE html>
<html>
<head>
<title>Create DATABASE</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
</head>
<body>
<?php
$servername = "localhost";
$username = "root";
$password = "";

// Create connection
try {
    $conn = mysqli_connect($servername, $username, $password);
}
catch (mysqli_sql_exception $e) {
    die("Connection failed: " . mysqli_connect_error());
}

// Create database
$sql = "CREATE DATABASE FYP";
try {
    mysqli_query($conn, $sql);
    echo "Database created successfully";
}
catch (mysqli_sql_exception $e) {
    die ("Error creating database: " . mysqli_errno($conn). " - " . mysqli_error($conn));
}
mysqli_close($conn);
?>
</body>
</html>
