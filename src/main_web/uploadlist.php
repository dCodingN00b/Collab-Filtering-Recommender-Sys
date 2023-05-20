<?php
session_start();
include('navbar.php');

echo"<title>Upload List</title>";

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
	$total_data = 1 * 250;
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


echo'<div style="text-align:center; margin-top: 60px;">';
if (!file_exists("uploads/$userid/list")) {
    mkdir("uploads/$userid/list", 0777, true);
}
if (!file_exists("uploads/$userid/crawled")) {
    mkdir("uploads/$userid/crawled", 0777, true);
}
$target_dir = "uploads/$userid/list/";
$target_file = $target_dir . basename($_FILES["file-upload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

echo "<div style='text-align: center;'>";

// Check if file already exists
if (file_exists($target_file)) {
	echo"<img src = 'images/uploaderror2.svg' style = 'width: 150px;'><br/><br/>";
  echo "<p>Sorry, file already exists.</p>";
  $uploadOk = 0;
}
// Check file size
else if ($_FILES["file-upload"]["size"] > 1000000) {
	echo"<img src = 'images/uploaderror2.svg' style = 'width: 150px;'><br/><br/>";
  echo "<p>Your file is too large.</p>";
  $uploadOk = 0;
}
// Allow certain file formats
else if($imageFileType != "txt" ) {
	echo"<img src = 'images/uploaderror2.svg' style = 'width: 150px;'><br/><br/>";
  echo "<p>Only TXT files are allowed.</p>";
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "<p>Sorry, your file was not uploaded.<br/> Directing back to add list page...</p>";
  header("refresh:2; url=workspace.php?id=addlist");
// if everything is ok, try to upload file
} 
else {
  if (move_uploaded_file($_FILES["file-upload"]["tmp_name"], $target_file)) 
  {
	$filenamefull = basename($_FILES["file-upload"]["name"]);
	$filenamewithoutextension = basename($_FILES['file-upload']['name'], '.txt');
	
	$file= "C:/xampp/htdocs/dashboard/FYP/uploads/$userid/list/" . basename($_FILES['file-upload']['name']);
	$f = fopen($file, 'rb');
    $lines = 0; $buffer = '';

    while (!feof($f)) {
        $buffer = fread($f, 8192);
        $lines += substr_count($buffer, "\n");
    }

    fclose($f);

    if (strlen($buffer) > 0 && $buffer[-1] != "\n") {
        ++$lines;
    }
	
	$userinfo = $user->getUserInfo($userid);
	
	$newTotal = $lines + $userinfo['urlsPerMonth'];
	if ($newTotal > $total_url){
		echo"<img src = 'images/uploaderror2.svg' style = 'width: 150px;'><br/><br/>";
		echo"<p>You will exceed the urls upload limit. Hence, the file has failed to upload. </p>";
		unlink($file);
		header('refresh:2; url=workspace.php?id=uploadedlist#bottom');
		exit();
	}
	
	//echo $lines;
	$user -> updateUrlsForMonth ($lines, $userid);
	$user -> updateSizeForMonth ($_FILES["file-upload"]["size"], $userid);
	
	echo"<img src = 'images/uploadsuccess2.svg' style = 'width: 150px;'><br/><br/>";
    echo "<p>The file ". htmlspecialchars( basename( $_FILES["file-upload"]["name"])). " has been uploaded.";
	echo"<br/> Directing to uploaded list page...</p>";
	/*
	$command = 'cd C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders && C:/Users/Administrator/AppData/Local/Programs/Python/Python311/Scripts/scrapy crawl amazon_scraping_txt -a txt="C:/xampp/htdocs/dashboard/FYP/uploads/'. $userid .'/list/'. $filenamefull . '" -o ../../../uploads/'. $userid .'/crawled/' . $filenamewithoutextension . '.csv';
	$output = popen($command, "w");
	pclose($output);*/

	//cd C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders && scrapy crawl amazon_scraping_txt -a txt="C:\xampp/htdocs\dashboard\FYP\uploads\132\list\links2.txt" -o ..\..\..\uploads\132\crawled\links2.csv
	//$output = shell_exec("C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/test.py");
	//echo $output;
	header('refresh:2; url=workspace.php?id=uploadedlist#bottom');
	  } else {
		  echo"<img src = 'images/uploaderror2.svg' style = 'width: 150px;'><br/><br/>";
		echo "<p>Sorry, there was an error uploading your file.</p>";
	  }
}

echo'</div></div>';
?>