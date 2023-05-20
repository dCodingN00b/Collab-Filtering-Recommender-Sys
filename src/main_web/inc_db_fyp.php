<?php
$DBName = "fyp";

try {
    $conn = mysqli_connect("localhost", "root", "");
    mysqli_select_db($conn, $DBName);
}
catch (mysqli_sql_exception $e) {
    die("connection error");
}
?>
