<!DOCTYPE html>
<html>
<head>
<title>Add 'users' record</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
</head>
<body>
<?php
$TableName = "users";
include("inc_db_fyp.php");

try {
	$sql = "INSERT INTO $TableName " . "(userName, password) VALUES " . "('Tom' , 'Pass123')";
	$sql2 = "INSERT INTO $TableName " . "(userName, password) VALUES " . "('Tan' , 'Pass123')";
	$sql3 = "INSERT INTO $TableName " . "(userName, password) VALUES " . "('Sam' , 'Pass123')";
	$sql4 = "INSERT INTO $TableName " . "(userName, password) VALUES " . "('Lee' , 'Pass123')";
	mysqli_query($conn, $sql);
	mysqli_query($conn, $sql2);
	mysqli_query($conn, $sql3);
	mysqli_query($conn, $sql4);
	echo " <p> Success </p>";
}
catch (mysqli_sql_exception $e) {
     echo "<p>Error " . mysqli_errno($conn). ": " . mysqli_error($conn) . "</p>";
}

mysqli_close($conn);
?>
</body>
</html>
