<?php
$DBName = "u963254639_FYP";

try {
    $conn = mysqli_connect("localhost", "u963254639_FYPuser", "Fyp123456!");
    mysqli_select_db($conn, $DBName);
}
catch (mysqli_sql_exception $e) {
    die("connection error");
}
?>
