<?php
session_start();
include('navbar.php');

$userid = $_SESSION['id'];
$user = new User();

if ($_SESSION['pricePlan'] == '0'){
	// Set the total number of recommendations
	$total_recommendations = 50;
	$total_url = 20;
	
	//find start and end date
	$startDate = $userinfo['dateTimeOfCreation'];
	$endDate = $userinfo['freeTrialExpiryDate'];
	
	// Set the total number of recommendations
	$total_data = 15;
}
else if ($_SESSION['pricePlan'] == 'i1'){
	// Set the total number of recommendations
	$total_recommendations = 500;
	$total_url = 50;
	$startDate = $userinfo['startDate'];
	$endDate = $userinfo['expiryDate'];
}
else if ($_SESSION['pricePlan'] == 'i2'){
	// Set the total number of recommendations
	$total_recommendations = 2500;
	$total_url = 250;
	$startDate = $userinfo['startDate'];
	$endDate = $userinfo['expiryDate'];
	
}
else if ($_SESSION['pricePlan'] == 'o1'){
	// Set the total number of recommendations
	$total_recommendations = 300;
	$total_url = 40;
	$startDate = $userinfo['startDate'];
	$endDate = $userinfo['expiryDate'];
	
	// Set the total number of recommendations
	$total_data = 1 * 50;
}
else if ($_SESSION['pricePlan'] == 'o2'){
	// Set the total number of recommendations
	$total_recommendations = 1500;
	$total_url = 200;
	$startDate = $userinfo['startDate'];
	$endDate = $userinfo['expiryDate'];
	// Set the total number of recommendations
	$total_data = 5 * 250;
}
else {
	// Set the total number of recommendations
	$total_recommendations = 0;
	$total_data = 0;
	$total_url = 0;
}

$total_data *= 1024 * 1024;

echo"<title>Upload Data</title>";

echo'<div style="text-align:center; margin-top: 60px;">';
if (!file_exists("uploads/$userid/data")) {
    mkdir("uploads/$userid/data", 0777, true);
}


$categoryfolder1 = "C:/xampp/htdocs/dashboard/FYP/uploads/" . $userid . "/data/electronics/";
$categoryfolder2 = "C:/xampp/htdocs/dashboard/FYP/uploads/" . $userid . "/data/toys/";
$categoryfolder3 = "C:/xampp/htdocs/dashboard/FYP/uploads/" . $userid . "/data/pets/";
$categoryfolder4 = "C:/xampp/htdocs/dashboard/FYP/uploads/" . $userid . "/data/computers/";
$categoryfolder5 = "C:/xampp/htdocs/dashboard/FYP/uploads/" . $userid . "/data/videogames/";
// Check if folders exist, create them if they don't
if (!is_dir($categoryfolder1)) {
  mkdir($categoryfolder1, 0777, true);
}
if (!is_dir($categoryfolder2)) {
  mkdir($categoryfolder2, 0777, true);
}
if (!is_dir($categoryfolder3)) {
  mkdir($categoryfolder3, 0777, true);
}
if (!is_dir($categoryfolder4)) {
  mkdir($categoryfolder4, 0777, true);
}
if (!is_dir($categoryfolder5)) {
  mkdir($categoryfolder5, 0777, true);
}


$categories = array("electronics", "toys", "pets", "videogames", "computers");
$chosencategory = "";

foreach ($categories as $category) {
    if (strpos(basename($_FILES["file-upload"]["name"]), $category) !== false) {
        $chosencategory = $category;
        break;
    }
}

$target_dir = "uploads/$userid/data/$chosencategory/";
$target_file = $target_dir . basename($_FILES["file-upload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

echo "<div style='text-align: center;'>";

//check if filename format is correct
if(strpos(basename($_FILES["file-upload"]["name"]), "electronics") === false 
    && strpos(basename($_FILES["file-upload"]["name"]), "toys") === false 
    && strpos(basename($_FILES["file-upload"]["name"]), "pets") === false 
    && strpos(basename($_FILES["file-upload"]["name"]), "videogames") === false 
    && strpos(basename($_FILES["file-upload"]["name"]), "computers") === false) {
		echo"<img src = 'images/uploaderror2.svg' style = 'width: 150px;'><br/><br/>";
        echo "<p>The filename does not contain any of the 5 categories.</p>";
		 $uploadOk = 0;
}
	// Check if file already exists
else if (file_exists($target_file)) {
	echo"<img src = 'images/uploaderror2.svg' style = 'width: 150px;'><br/><br/>";
  echo "<p>The file already exists.</p>";
  $uploadOk = 0;
}
// Check file size
else if ($_FILES["file-upload"]["size"] > 1000000) {
	echo"<img src = 'images/uploaderror2.svg' style = 'width: 150px;'><br/><br/>";
  echo "<p>Your file is too large.</p>";
  $uploadOk = 0;
}
// Allow certain file formats
else if($imageFileType != "csv" ) {
	echo"<img src = 'images/uploaderror2.svg' style = 'width: 150px;'><br/><br/>";
  echo "<p>Only CSV files are allowed.</p>";
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "<p>Sorry, your file was not uploaded.<br/> Directing back to add data page...</p>";
  header("refresh:2; url=workspace.php?id=adddata");
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["file-upload"]["tmp_name"], $target_file)) {
	  
	$file= "C:/xampp/htdocs/dashboard/FYP/uploads/$userid/data/" . basename($_FILES['file-upload']['name']);
	$userinfo = $user->getUserInfo($userid);
	$newTotal = $_FILES["file-upload"]["size"] + $userinfo['uploadSizePerMonth'];
	if ($newTotal > $total_data){
		echo"<img src = 'images/uploaderror2.svg' style = 'width: 150px;'><br/><br/>";
		echo"<p>You will exceed the data upload limit. Hence, the file has failed to upload. </p>";
		unlink($file);
		header('refresh:2; url=workspace.php?id=uploadeddata');
		exit();
	}
	 
	$user -> updateSizeForMonth ($_FILES["file-upload"]["size"], $userid);
	
	echo"<img src = 'images/uploadsuccess2.svg' style = 'width: 150px;'><br/><br/>";
    echo "<p>The file ". htmlspecialchars( basename( $_FILES["file-upload"]["name"])). " has been uploaded.";
	
	echo"<br/> Directing to uploaded data page...</p>";
	header("refresh:2; url=workspace.php?id=uploadeddata");
  } else {
    echo "<p>Sorry, there was an error uploading your file.</p>";
  }
}
echo '</div></div>';
?>