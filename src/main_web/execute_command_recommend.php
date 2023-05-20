<?php
session_start();
include('user.php');

function checkProductInCSVFolder($product, $folderPath) {
    $csvFiles = glob($folderPath . '/*.csv');

    foreach ($csvFiles as $csvFile) {
        $handle = fopen($csvFile, 'r');

        while (($row = fgetcsv($handle)) !== false) {
            if (in_array($product, $row)) {
                fclose($handle);
                return true;
            }
        }

        fclose($handle);
    }

    return false;
}
	
if (isset($_POST['command'])) {
    // Get the command from the AJAX request
    $command = $_POST['command'];
	
	
	$user_id = $_POST['userid'];

	
	$productid = $_POST['product'];
	$type = $_POST['type'];
	$results1 = "";
	$results2 = ""; 
	$results3 = ""; 
	$results4 = ""; 
	$results5 = ""; 
	
	
	$user = new User();
$userinfo = $user->getUserInfo($user_id);

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
		$total_recommendations = 5;
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
	
    // Sanitize and validate the command
    // ...
	$newTotal = $userinfo['recoPerMonth'] + 1;
	if ($newTotal > $total_recommendations){

		$output = "
			<div style = 'transform:translate(20%, 0%)'>
				You have exceeded the recommendation limit.
			</div>";
	
	}
	else if ($type == 'uploadeddata')
	{
		$categoryOne = $_POST['categoryOne'];
		$categoryTwo = $_POST['categoryTwo'];
		$categoryThree = $_POST['categoryThree'];
		$categoryFour = $_POST['categoryFour'];
		$categoryFive = $_POST['categoryFive'];
		$categoryCount = $_POST['categoryCount'];
		$command2 = $_POST['command2'];
		$command3 = $_POST['command3'];
		$command4 = $_POST['command4'];
		$command5 = $_POST['command5'];
	
		// Execute the command and store the output in an array
		$out = array();
		$out2 = array();
		$out3 = array();
		$out4 = array();
		$out5 = array();
		
		$csvFolderPath1 = 'C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/data/". $categoryOne;
		$csvFolderPath2 = 'C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/data/". $categoryTwo;
		$csvFolderPath3 = 'C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/data/". $categoryThree;
		$csvFolderPath4 = 'C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/data/". $categoryFour;
		$csvFolderPath5 = 'C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/data/". $categoryFive;
		
		
		if ($categoryCount == 1) {
			if (file_exists('C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/data/". $categoryOne)){
				 $contents = scandir('C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/data/". $categoryOne);
				 if (count($contents) > 2)
				 {
					$count = count($contents);
				 }
				 else{
					 $out[0] = "No file uploaded";
				 }
			}
			else {
				$out[0] = "No file uploaded";
			}
		}
		
		if ($categoryCount == 2) {
			if (file_exists('C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/data/". $categoryOne) or file_exists('C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/data/". $categoryTwo)){
				 $contents = scandir('C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/data/". $categoryOne);
				 $contents2 = scandir('C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/data/". $categoryTwo);
				 $count = count($contents) + count($contents2);
				 if ($count > 2)
				 {
					//continue
				 }
				 else{
					 $out[0] = "No file uploaded";
				 }
			}
			else {
				$out[0] = "No file uploaded";
			}
		}
		
		if ($categoryCount == 3) {
			if (file_exists('C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/data/". $categoryOne) or file_exists('C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/data/". $categoryTwo) or 
			file_exists('C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/data/". $categoryThree)){
				 $contents = scandir('C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/data/". $categoryOne);
				 $contents2 = scandir('C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/data/". $categoryTwo);
				 $contents3 = scandir('C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/data/". $categoryThree);
				 $count = count($contents) + count($contents2) + count($contents3);
				 if ($count > 2)
				 {
					//continue
				 }
				 else{
					 $out[0] = "No file uploaded";
				 }
			}
			else {
				$out[0] = "No file uploaded";
			}
		}
		
		
		if ($categoryCount == 4) {
			if (file_exists('C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/data/". $categoryOne) or file_exists('C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/data/". $categoryTwo) or 
			file_exists('C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/data/". $categoryThree) or file_exists('C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/data/". $categoryFour)){
				 $contents = scandir('C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/data/". $categoryOne);
				 $contents2 = scandir('C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/data/". $categoryTwo);
				 $contents3 = scandir('C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/data/". $categoryThree);
				 $contents4 = scandir('C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/data/". $categoryFour);
				 $count = count($contents) + count($contents2) + count($contents3) + count($contents4);
				 if ($count > 2)
				 {
					//continue
				 }
				 else{
					 $out[0] = "No file uploaded";
				 }
			}
			else {
				$out[0] = "No file uploaded";
			}
		}
		
		
		if ($categoryCount == 5) {
			if (file_exists('C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/data/". $categoryOne) or file_exists('C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/data/". $categoryTwo) or 
			file_exists('C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/data/". $categoryThree) or file_exists('C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/data/". $categoryFour) or 
			file_exists('C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/data/". $categoryFive)){
				 $contents = scandir('C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/data/". $categoryOne);
				 $contents2 = scandir('C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/data/". $categoryTwo);
				 $contents3 = scandir('C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/data/". $categoryThree);
				 $contents4 = scandir('C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/data/". $categoryFour);
				 $contents5 = scandir('C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/data/". $categoryFive);
				 $count = count($contents) + count($contents2) + count($contents3) + count($contents4) + count($contents5);
				 if ($count > 2)
				 {
					//continue
				 }
				 else{
					 $out[0] = "No file uploaded";
				 }
			}
			else {
				$out[0] = "No file uploaded";
			}
		}
		
		
		
		
		if ($count > 2){
			if ($categoryCount == 1) {
					
				if (checkProductInCSVFolder($productid, $csvFolderPath1)){
					//
				}
				else{
					$out[0] = "Product ID does not exist.";
					exit (json_encode(array('data'=>$out,'data2'=>$out2, 'data3'=>$out3, 'data4'=>$out4, 'data5'=>$out5)));
				}
			}
			else if ($categoryCount == 2)
			{
				if (checkProductInCSVFolder($productid, $csvFolderPath1) or checkProductInCSVFolder($productid, $csvFolderPath2)){
					//
				}
				else{
					$out[0] = "Product ID does not exist.";
					exit (json_encode(array('data'=>$out,'data2'=>$out2, 'data3'=>$out3, 'data4'=>$out4, 'data5'=>$out5)));
				}
			}
			else if ($categoryCount == 3)
			{
				if (checkProductInCSVFolder($productid, $csvFolderPath1) or checkProductInCSVFolder($productid, $csvFolderPath2) or checkProductInCSVFolder($productid, $csvFolderPath3)){
					//
				}
				else{
					$out[0] = "Product ID does not exist.";
					exit (json_encode(array('data'=>$out,'data2'=>$out2, 'data3'=>$out3, 'data4'=>$out4, 'data5'=>$out5)));
				}
			}
			else if ($categoryCount == 4)
			{
				if (checkProductInCSVFolder($productid, $csvFolderPath1) or checkProductInCSVFolder($productid, $csvFolderPath2) or checkProductInCSVFolder($productid, $csvFolderPath3) 
					or checkProductInCSVFolder($productid, $csvFolderPath4)){
					//
				}
				else{
					$out[0] = "Product ID does not exist.";
					exit (json_encode(array('data'=>$out,'data2'=>$out2, 'data3'=>$out3, 'data4'=>$out4, 'data5'=>$out5)));
				}
			}
			else if ($categoryCount == 5)
			{
				if (checkProductInCSVFolder($productid, $csvFolderPath1) or checkProductInCSVFolder($productid, $csvFolderPath2) or checkProductInCSVFolder($productid, $csvFolderPath3) 
					or checkProductInCSVFolder($productid, $csvFolderPath4) or checkProductInCSVFolder($productid, $csvFolderPath5)){
					//
				}
				else{
					$out[0] = "Product ID does not exist.";
					exit (json_encode(array('data'=>$out,'data2'=>$out2, 'data3'=>$out3, 'data4'=>$out4, 'data5'=>$out5)));
				}
			}
		}
		
		
		if (file_exists('C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/data/". $categoryOne)){
				 $contents = scandir('C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/data/". $categoryOne);
				 if (count($contents) > 2)
				 {
					$count = count($contents);
				 }
				 else{
					 $out[0] = "No file uploaded";
				 }
			}
			else {
				$out[0] = "No file uploaded";
		}
		
		if (count($contents) > 2)
		{
			
			exec($command, $out, $return);
		
		
			if ($return != 0)
			{
				$out[0] = "Product ID usage incorrect, please try again";
				
			}
			else if (sizeof($out) != 12)
			{
				$out[0] = "There should be at least 5 different products in your dataset. Please try again once you have added them in.";
			}
			else 
			{
				//exec($command0, $output);
				/*$command1 = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/generateImage.py ' . $out[3];
				exec($command1, $out);
				$command2 = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/generateImage.py ' . $out[5];
				exec($command2, $out);
				$command3 = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/generateImage.py ' . $out[7];
				exec($command3, $out);
				$command4 = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/generateImage.py ' . $out[9];
				exec($command4, $out);
				$command5 = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/generateImage.py ' . $out[11];
				exec($command5, $out);*/
				
				$output = implode(" ", $out);
				
				$output = trim($output);
			
			
				$temp1 = strpos($output, ":");
				
				
				$reco1 = substr($output, $temp1 + 4, 10);
				$reco2 = substr($output, $temp1 + 17, 10);
				$reco3 = substr($output, $temp1 + 30, 10);
				$reco4 = substr($output, $temp1 + 43, 10);
				$reco5 = substr($output, $temp1 + 56, 10);
				
				//$user = new User();
				//$user->createResultsFromReco ($productid, $reco1, $reco2, $reco3, $reco4, $reco5, 1, $user_id);
				//$user->updateRecoForMonth ($user_id);
				
				shell_exec('C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/specialcharfilter.py' . ' C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . '/data/'. $categoryOne . '/');		
				$productOneDomainImage = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/getUrlAndImg.py C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/data/". $categoryOne . '/ ' . $out[3];
				exec($productOneDomainImage, $out);
				$productTwoDomainImage = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/getUrlAndImg.py C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/data/". $categoryOne . '/ ' . $out[5];
				exec($productTwoDomainImage, $out);
				$productThreeDomainImage = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/getUrlAndImg.py C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/data/". $categoryOne . '/ ' . $out[7];
				exec($productThreeDomainImage, $out);
				$productFourDomainImage = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/getUrlAndImg.py C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/data/". $categoryOne . '/ ' . $out[9];
				exec($productFourDomainImage, $out);
				$productFiveDomainImage = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/getUrlAndImg.py C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/data/". $categoryOne . '/ ' . $out[11];
				exec($productFiveDomainImage, $out);
				
				/*
				for ($x = 12; $x < 32; $x++){
					$results1 .= ' ' . $out[$x];
				}*/
				
				$outData = $out;
				array_push($outData, $categoryOne);
				$results1 = serialize($outData);
			}
		}
			
			if ($categoryCount > 1){
				
				if (file_exists('C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/data/". $categoryTwo)){
					$contents = scandir('C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/data/". $categoryTwo);
					if (count($contents) > 2)
					{
					
					}
					else{
						$out2[0] = "No file uploaded";
						
					}
				}
				else {
					$out2[0] = "No file uploaded";
					
				}
				
				if (count($contents) > 2)
				{
					exec($command2, $out2, $return);
				
				
				
					if ($return != 0)
					{
						$out2[0] = "Product ID usage incorrect, please try again";
					}
					else if (sizeof($out2) != 12)
					{
						$out2[0] = "There should be at least 5 different products in your dataset. Please try again once you have added them in.";
					}
					else {
					
						$output2 = implode(" ", $out2);
						
						$output2 = trim($output2);
					
					
						$temp2 = strpos($output2, ":");
						
						
						$reco6 = substr($output2, $temp2 + 4, 10);
						$reco7 = substr($output2, $temp2 + 17, 10);
						$reco8 = substr($output2, $temp2 + 30, 10);
						$reco9 = substr($output2, $temp2 + 43, 10);
						$reco10 = substr($output2, $temp2 + 56, 10);
							
						$productOneDomainImage = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/getUrlAndImg.py C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/data/". $categoryTwo . '/ ' . $out2[3];
						exec($productOneDomainImage, $out2);
						$productTwoDomainImage = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/getUrlAndImg.py C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/data/". $categoryTwo . '/ ' . $out2[5];
						exec($productTwoDomainImage, $out2);
						$productThreeDomainImage = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/getUrlAndImg.py C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/data/". $categoryTwo . '/ ' . $out2[7];
						exec($productThreeDomainImage, $out2);
						$productFourDomainImage = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/getUrlAndImg.py C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/data/". $categoryTwo . '/ ' . $out2[9];
						exec($productFourDomainImage, $out2);
						$productFiveDomainImage = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/getUrlAndImg.py C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/data/". $categoryTwo . '/ ' . $out2[11];
						exec($productFiveDomainImage, $out2);
						
						$outData = $out2;
						array_push($outData, $categoryTwo);
						$results2 = serialize($outData);
					}
				}
			}
				
			if ($categoryCount > 2){
				
				if (file_exists('C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/data/". $categoryThree)){
					$contents = scandir('C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/data/". $categoryThree);
					if (count($contents) > 2)
					{
					
					}
					else{
						$out3[0] = "No file uploaded";
					}
				}
				else {
					$out3[0] = "No file uploaded";
					
				}
				
				if (count($contents) > 2)
				{
				
					exec($command3, $out3, $return);
				
					if ($return != 0)
					{
						$out3[0] = "Product ID usage incorrect, please try again";
						
						
					}
					else if (sizeof($out3) != 12)
					{
						$out3[0] = "There should be at least 5 different products in your dataset. Please try again once you have added them in.";
					}
					else{
					
						$output3 = implode(" ", $out3);
						
						$output3 = trim($output3);
					
					
						$temp3 = strpos($output3, ":");
						
						
						$reco11 = substr($output3, $temp3 + 4, 10);
						$reco12 = substr($output3, $temp3 + 17, 10);
						$reco13 = substr($output3, $temp3 + 30, 10);
						$reco14 = substr($output3, $temp3 + 43, 10);
						$reco15 = substr($output3, $temp3 + 56, 10);
						
						$productOneDomainImage = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/getUrlAndImg.py C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/data/". $categoryThree . '/ ' . $out3[3];
						exec($productOneDomainImage, $out3);
						$productTwoDomainImage = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/getUrlAndImg.py C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/data/". $categoryThree . '/ ' . $out3[5];
						exec($productTwoDomainImage, $out3);
						$productThreeDomainImage = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/getUrlAndImg.py C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/data/". $categoryThree . '/ ' . $out3[7];
						exec($productThreeDomainImage, $out3);
						$productFourDomainImage = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/getUrlAndImg.py C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/data/". $categoryThree . '/ ' . $out3[9];
						exec($productFourDomainImage, $out3);
						$productFiveDomainImage = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/getUrlAndImg.py C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/data/". $categoryThree . '/ ' . $out3[11];
						exec($productFiveDomainImage, $out3);
						
						$outData = $out3;
						array_push($outData, $categoryThree);
						$results3 = serialize($outData);
					}
				}

			}
			
			if ($categoryCount > 3){
				
				if (file_exists('C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/data/". $categoryFour)){
					$contents = scandir('C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/data/". $categoryFour);
					if (count($contents) > 2)
					{
					
					}
					else{
						$out4[0] = "No file uploaded";
						
					}
				}
				else {
					$out4[0] = "No file uploaded";
				}
				
				if (count($contents) > 2)
				{
					exec($command4, $out4, $return);
				
					if ($return != 0)
					{
						$out4[0] = "Product ID usage incorrect, please try again";
						exit(json_encode(array('data'=>$out,'data2'=>$out2,'data3'=>$out3,'data4'=>$out4)));
						
					}
					else if (sizeof($out4) != 12)
					{
						$out4[0] = "There should be at least 5 different products in your dataset. Please try again once you have added them in.";
					}
					else
					{
					
						$output4 = implode(" ", $out4);
						
						$output4 = trim($output4);
					
					
						$temp4 = strpos($output4, ":");
						
						
						$reco16 = substr($output4, $temp4 + 4, 10);
						$reco17 = substr($output4, $temp4 + 17, 10);
						$reco18 = substr($output4, $temp4 + 30, 10);
						$reco19 = substr($output4, $temp4 + 43, 10);
						$reco20 = substr($output4, $temp4 + 56, 10);
						
						$productOneDomainImage = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/getUrlAndImg.py C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/data/". $categoryFour . '/ ' . $out4[3];
						exec($productOneDomainImage, $out4);
						$productTwoDomainImage = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/getUrlAndImg.py C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/data/". $categoryFour . '/ ' . $out4[5];
						exec($productTwoDomainImage, $out4);
						$productThreeDomainImage = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/getUrlAndImg.py C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/data/". $categoryFour . '/ ' . $out4[7];
						exec($productThreeDomainImage, $out4);
						$productFourDomainImage = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/getUrlAndImg.py C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/data/". $categoryFour . '/ ' . $out4[9];
						exec($productFourDomainImage, $out4);
						$productFiveDomainImage = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/getUrlAndImg.py C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/data/". $categoryFour . '/ ' . $out4[11];
						exec($productFiveDomainImage, $out4);
						
						$outData = $out4;
						array_push($outData, $categoryFour);
						$results4 = serialize($outData);
						
					}
				}

			}
			
			if ($categoryCount > 4){
				
				if (file_exists('C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/data/". $categoryFive)){
					$contents = scandir('C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/data/". $categoryFive);
					if (count($contents) > 2)
					{
					
					}
					else{
						$out5[0] = "No file uploaded";
						
					}
				}
				else {
					$out5[0] = "No file uploaded";
					
				}
				
				if (count($contents) > 2)
				{
					exec($command5, $out5, $return);
					
					if ($return != 0)
					{
						$out5[0] = "Product ID usage incorrect, please try again";
						exit(json_encode(array('data'=>$out,'data2'=>$out2,'data3'=>$out3,'data4'=>$out4,'data5'=>$out5)));
						
					}
					else if (sizeof($out5) != 12)
					{
						$out5[0] = "There should be at least 5 different products in your dataset. Please try again once you have added them in.";
					}
					else{
					
						$output5 = implode(" ", $out5);
						
						$output5 = trim($output5);
					
					
						$temp5 = strpos($output5, ":");
						
						
						$reco21 = substr($output5, $temp5 + 4, 10);
						$reco22 = substr($output5, $temp5 + 17, 10);
						$reco23 = substr($output5, $temp5 + 30, 10);
						$reco24 = substr($output5, $temp5 + 43, 10);
						$reco25 = substr($output5, $temp5 + 56, 10);
						
						$productOneDomainImage = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/getUrlAndImg.py C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/data/". $categoryFive . '/ ' . $out5[3];
						exec($productOneDomainImage, $out5);
						$productTwoDomainImage = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/getUrlAndImg.py C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/data/". $categoryFive . '/ ' . $out5[5];
						exec($productTwoDomainImage, $out5);
						$productThreeDomainImage = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/getUrlAndImg.py C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/data/". $categoryFive . '/ ' . $out5[7];
						exec($productThreeDomainImage, $out5);
						$productFourDomainImage = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/getUrlAndImg.py C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/data/". $categoryFive . '/ ' . $out5[9];
						exec($productFourDomainImage, $out5);
						$productFiveDomainImage = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/getUrlAndImg.py C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/data/". $categoryFive . '/ ' . $out5[11];
						exec($productFiveDomainImage, $out5);
						
						$outData = $out5;
						array_push($outData, $categoryFive);
						$results5 = serialize($outData);
					}
				}

			}
			
		
			
			$user->createResultsFromReco ($productid, $results1, $results2, $results3, $results4, $results5, 1, $user_id);	
			$user->updateRecoForMonth ($user_id);
			echo json_encode(array('data'=>$out,'data2'=>$out2, 'data3'=>$out3, 'data4'=>$out4, 'data5'=>$out5));
		
		
		
	}
	else if ($type == 'recsdata')
	{
		$categoryOne = $_POST['categoryOne'];
		$categoryTwo = $_POST['categoryTwo'];
		$categoryThree = $_POST['categoryThree'];
		$categoryFour = $_POST['categoryFour'];
		$categoryFive = $_POST['categoryFive'];
		$categoryCount = $_POST['categoryCount'];
		$command2 = $_POST['command2'];
		$command3 = $_POST['command3'];
		$command4 = $_POST['command4'];
		$command5 = $_POST['command5'];
	
		// Execute the command and store the output in an array
		$out = array();
		$out2 = array();
		$out3 = array();
		$out4 = array();
		$out5 = array();
		
		$csvFolderPath1 = 'C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/' . $categoryOne;
		$csvFolderPath2 = 'C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/' . $categoryTwo;
		$csvFolderPath3 = 'C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/' . $categoryThree;
		$csvFolderPath4 = 'C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/' . $categoryFour;
		$csvFolderPath5 = 'C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/' . $categoryFive;
		
		if ($categoryCount == 1) {
			if (file_exists($csvFolderPath1)){
				 $contents = scandir($csvFolderPath1);
				 if (count($contents) > 2)
				 {
					$count = count($contents);
				 }
				 else{
					 $out[0] = "No file uploaded";
				 }
			}
			else {
				$out[0] = "No file uploaded";
			}
		}
		
		if ($categoryCount == 2) {
			if (file_exists($csvFolderPath1) or file_exists($csvFolderPath2)){
				 $contents = scandir($csvFolderPath2) ;
				 $contents2 = scandir($csvFolderPath2);
				 $count = count($contents) + count($contents2);
				 if ($count > 2)
				 {
					//continue
				 }
				 else{
					 $out[0] = "No file uploaded";
				 }
			}
			else {
				$out[0] = "No file uploaded";
			}
		}
		
		if ($categoryCount == 3) {
			if (file_exists($csvFolderPath1) or file_exists($csvFolderPath2) or 
			file_exists($csvFolderPath3)){
				 $contents = scandir($csvFolderPath1);
				 $contents2 = scandir($csvFolderPath2);
				 $contents3 = scandir($csvFolderPath3);
				 $count = count($contents) + count($contents2) + count($contents3);
				 if ($count > 2)
				 {
					//continue
				 }
				 else{
					 $out[0] = "No file uploaded";
				 }
			}
			else {
				$out[0] = "No file uploaded";
			}
		}
		
		
		if ($categoryCount == 4) {
			if (file_exists($csvFolderPath1) or file_exists($csvFolderPath2) or 
			file_exists($csvFolderPath3) or file_exists($csvFolderPath4)){
				 $contents = scandir('C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/data/". $categoryOne);
				 $contents2 = scandir('C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/data/". $categoryTwo);
				 $contents3 = scandir('C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/data/". $categoryThree);
				 $contents4 = scandir('C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/data/". $categoryFour);
				 $count = count($contents) + count($contents2) + count($contents3) + count($contents4);
				 if ($count > 2)
				 {
					//continue
				 }
				 else{
					 $out[0] = "No file uploaded";
				 }
			}
			else {
				$out[0] = "No file uploaded";
			}
		}
		
		
		if ($categoryCount == 5) {
			if (file_exists($csvFolderPath1) or file_exists($csvFolderPath2) or 
			file_exists($csvFolderPath3) or file_exists($csvFolderPath4) or 
			file_exists($csvFolderPath5)){
				 $contents = scandir($csvFolderPath1);
				 $contents2 = scandir($csvFolderPath2);
				 $contents3 = scandir($csvFolderPath3);
				 $contents4 = scandir($csvFolderPath4);
				 $contents5 = scandir($csvFolderPath5);
				 $count = count($contents) + count($contents2) + count($contents3) + count($contents4) + count($contents5);
				 if ($count > 2)
				 {
					//continue
				 }
				 else{
					 $out[0] = "No file uploaded";
				 }
			}
			else {
				$out[0] = "No file uploaded";
			}
		}
		
		
		if ($count > 2){
			if ($categoryCount == 1) {
					
				if (checkProductInCSVFolder($productid, $csvFolderPath1)){
					//
				}
				else{
					$out[0] = "Product ID does not exist.";
					exit (json_encode(array('data'=>$out,'data2'=>$out2, 'data3'=>$out3, 'data4'=>$out4, 'data5'=>$out5)));
				}
			}
			else if ($categoryCount == 2)
			{
				if (checkProductInCSVFolder($productid, $csvFolderPath1) or checkProductInCSVFolder($productid, $csvFolderPath2)){
					//
				}
				else{
					$out[0] = "Product ID does not exist.";
					exit (json_encode(array('data'=>$out,'data2'=>$out2, 'data3'=>$out3, 'data4'=>$out4, 'data5'=>$out5)));
				}
			}
			else if ($categoryCount == 3)
			{
				if (checkProductInCSVFolder($productid, $csvFolderPath1) or checkProductInCSVFolder($productid, $csvFolderPath2) or checkProductInCSVFolder($productid, $csvFolderPath3)){
					//
				}
				else{
					$out[0] = "Product ID does not exist.";
					exit (json_encode(array('data'=>$out,'data2'=>$out2, 'data3'=>$out3, 'data4'=>$out4, 'data5'=>$out5)));
				}
			}
			else if ($categoryCount == 4)
			{
				if (checkProductInCSVFolder($productid, $csvFolderPath1) or checkProductInCSVFolder($productid, $csvFolderPath2) or checkProductInCSVFolder($productid, $csvFolderPath3) 
					or checkProductInCSVFolder($productid, $csvFolderPath4)){
					//
				}
				else{
					$out[0] = "Product ID does not exist.";
					exit (json_encode(array('data'=>$out,'data2'=>$out2, 'data3'=>$out3, 'data4'=>$out4, 'data5'=>$out5)));
				}
			}
			else if ($categoryCount == 5)
			{
				if (checkProductInCSVFolder($productid, $csvFolderPath1) or checkProductInCSVFolder($productid, $csvFolderPath2) or checkProductInCSVFolder($productid, $csvFolderPath3) 
					or checkProductInCSVFolder($productid, $csvFolderPath4) or checkProductInCSVFolder($productid, $csvFolderPath5)){
					//
				}
				else{
					$out[0] = "Product ID does not exist.";
					exit (json_encode(array('data'=>$out,'data2'=>$out2, 'data3'=>$out3, 'data4'=>$out4, 'data5'=>$out5)));
				}
			}
		}
		
		

		if (file_exists($csvFolderPath1)){
			 $contents = scandir($csvFolderPath1);
			 if (count($contents) > 2)
			 {
				$count = count($contents);
			 }
			 else{
				 $out[0] = "No file uploaded";
			 }
		}
		else {
			$out[0] = "No file uploaded";
		}
		
		
		if (count($contents) > 2)
		{
			exec($command, $out, $return);
		
		
		
			if ($return != 0)
			{
				$out[0] = "Product ID usage incorrect, please try again";
			}
			else if (sizeof($out) != 12)
			{
				$out[0] = "There was an error in RECS database, please try again later.";
			}
			else
			{
				//exec($command0, $output);
				/*$command1 = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/generateImage.py ' . $out[3];
				exec($command1, $out);
				$command2 = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/generateImage.py ' . $out[5];
				exec($command2, $out);
				$command3 = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/generateImage.py ' . $out[7];
				exec($command3, $out);
				$command4 = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/generateImage.py ' . $out[9];
				exec($command4, $out);
				$command5 = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/generateImage.py ' . $out[11];
				exec($command5, $out);*/
				
				$output = implode(" ", $out);
				
				$output = trim($output);
			
			
				$temp1 = strpos($output, ":");
				
				
				$reco1 = substr($output, $temp1 + 4, 10);
				$reco2 = substr($output, $temp1 + 17, 10);
				$reco3 = substr($output, $temp1 + 30, 10);
				$reco4 = substr($output, $temp1 + 43, 10);
				$reco5 = substr($output, $temp1 + 56, 10);
				
				//$user = new User();
				//$user->createResultsFromReco ($productid, $reco1, $reco2, $reco3, $reco4, $reco5, 1, $user_id);
				//$user->updateRecoForMonth ($user_id);
				
				$productOneDomainImage = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/getUrlAndImg.py C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/' . $categoryOne . '/ ' . $out[3];
				exec($productOneDomainImage, $out);
				$productTwoDomainImage = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/getUrlAndImg.py C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/' . $categoryOne . '/ ' . $out[5];
				exec($productTwoDomainImage, $out);
				$productThreeDomainImage = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/getUrlAndImg.py C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/' . $categoryOne . '/ ' . $out[7];
				exec($productThreeDomainImage, $out);
				$productFourDomainImage = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/getUrlAndImg.py C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/' . $categoryOne . '/ ' . $out[9];
				exec($productFourDomainImage, $out);
				$productFiveDomainImage = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/getUrlAndImg.py C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/' . $categoryOne . '/ ' . $out[11];
				exec($productFiveDomainImage, $out);
				
				$outData = $out;
				array_push($outData, $categoryOne);
				$results1 = serialize($outData);
				
			}
		}
			if ($categoryCount > 1){
				
				if (file_exists('C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/' . $categoryTwo)){
					 $contents = scandir('C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/' . $categoryTwo);
					 if (count($contents) > 2)
					 {
						
					 }
					 else{
						 $out2[0] = "No file uploaded";
						
					 }
				}
				else {
					$out2[0] = "No file uploaded";
					
				}
				
				if (count($contents) > 2)
				{
					exec($command2, $out2, $return);
				
					if ($return != 0)
					{
						$out2[0] = "Product ID usage incorrect, please try again";
					}
					else if (sizeof($out2) != 12)
					{
						$out2[0] = "There was an error in RECS database, please try again later.";
					}
					else
					{
						$output2 = implode(" ", $out2);
						
						$output2 = trim($output2);
					
					
						$temp2 = strpos($output2, ":");
						
						
						$reco6 = substr($output2, $temp2 + 4, 10);
						$reco7 = substr($output2, $temp2 + 17, 10);
						$reco8 = substr($output2, $temp2 + 30, 10);
						$reco9 = substr($output2, $temp2 + 43, 10);
						$reco10 = substr($output2, $temp2 + 56, 10);
						
						$productOneDomainImage = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/getUrlAndImg.py C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/' . $categoryTwo . '/ ' . $out2[3];
						exec($productOneDomainImage, $out2);
						$productTwoDomainImage = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/getUrlAndImg.py C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/' . $categoryTwo . '/ ' . $out2[5];
						exec($productTwoDomainImage, $out2);
						$productThreeDomainImage = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/getUrlAndImg.py C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/' . $categoryTwo . '/ ' . $out2[7];
						exec($productThreeDomainImage, $out2);
						$productFourDomainImage = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/getUrlAndImg.py C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/' . $categoryTwo . '/ ' . $out2[9];
						exec($productFourDomainImage, $out2);
						$productFiveDomainImage = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/getUrlAndImg.py C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/' . $categoryTwo . '/ ' . $out2[11];
						exec($productFiveDomainImage, $out2);
						
						$outData = $out2;
						array_push($outData, $categoryTwo);
						$results2 = serialize($outData);
					}
				}
			}
			
			if ($categoryCount > 2){
				
				if (file_exists('C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/' . $categoryThree)){
					 $contents = scandir('C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/' . $categoryThree);
					 if (count($contents) > 2)
					 {
						
					 }
					 else{
						 $out3[0] = "No file uploaded";
						
					 }
				}
				else {
					$out3[0] = "No file uploaded";
					
				}
				
				if (count($contents) > 2)
				{
					exec($command3, $out3, $return);
					
					if ($return != 0)
					{
						$out3[0] = "Product ID usage incorrect, please try again";
					}
					else if (sizeof($out3) != 12)
					{
						$out3[0] = "There was an error in RECS database, please try again later.";
					}
					else
					{
						$output3 = implode(" ", $out3);
						
						$output3 = trim($output3);
					
					
						$temp3 = strpos($output3, ":");
						
						
						$reco11 = substr($output3, $temp3 + 4, 10);
						$reco12 = substr($output3, $temp3 + 17, 10);
						$reco13 = substr($output3, $temp3 + 30, 10);
						$reco14 = substr($output3, $temp3 + 43, 10);
						$reco15 = substr($output3, $temp3 + 56, 10);
						
						$productOneDomainImage = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/getUrlAndImg.py C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/' . $categoryThree . '/ ' . $out3[3];
						exec($productOneDomainImage, $out3);
						$productTwoDomainImage = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/getUrlAndImg.py C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/' . $categoryThree . '/ ' . $out3[5];
						exec($productTwoDomainImage, $out3);
						$productThreeDomainImage = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/getUrlAndImg.py C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/' . $categoryThree . '/ ' . $out3[7];
						exec($productThreeDomainImage, $out3);
						$productFourDomainImage = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/getUrlAndImg.py C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/' . $categoryThree . '/ ' . $out3[9];
						exec($productFourDomainImage, $out3);
						$productFiveDomainImage = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/getUrlAndImg.py C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/' . $categoryThree . '/ ' . $out3[11];
						exec($productFiveDomainImage, $out3);
						
						$outData = $out3;
						array_push($outData, $categoryThree);
						$results3 = serialize($outData);
					}
				}

			}
			
			if ($categoryCount > 3){
				
				if (file_exists('C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/' . $categoryFour)){
					 $contents = scandir('C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/' . $categoryFour);
					 if (count($contents) > 2)
					 {
						
					 }
					 else{
						 $out4[0] = "No file uploaded";
						
					 }
				}
				else {
					$out4[0] = "No file uploaded";
					
				}
				
				if (count($contents) > 2)
				{
					exec($command4, $out4, $return);
					
					
					if ($return != 0)
					{
						$out4[0] = "Product ID usage incorrect, please try again";
					}
					else if (sizeof($out4) != 12)
					{
						$out4[0] = "There was an error in RECS database, please try again later.";
					}
					else
					{
					
						$output4 = implode(" ", $out4);
						
						$output4 = trim($output4);
					
					
						$temp4 = strpos($output4, ":");
						
						
						$reco16 = substr($output4, $temp4 + 4, 10);
						$reco17 = substr($output4, $temp4 + 17, 10);
						$reco18 = substr($output4, $temp4 + 30, 10);
						$reco19 = substr($output4, $temp4 + 43, 10);
						$reco20 = substr($output4, $temp4 + 56, 10);
						
						$productOneDomainImage = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/getUrlAndImg.py C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/' . $categoryFour . '/ ' . $out4[3];
						exec($productOneDomainImage, $out4);
						$productTwoDomainImage = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/getUrlAndImg.py C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/' . $categoryFour . '/ ' . $out4[5];
						exec($productTwoDomainImage, $out4);
						$productThreeDomainImage = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/getUrlAndImg.py C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/' . $categoryFour . '/ ' . $out4[7];
						exec($productThreeDomainImage, $out4);
						$productFourDomainImage = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/getUrlAndImg.py C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/' . $categoryFour . '/ ' . $out4[9];
						exec($productFourDomainImage, $out4);
						$productFiveDomainImage = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/getUrlAndImg.py C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/' . $categoryFour . '/ ' . $out4[11];
						exec($productFiveDomainImage, $out4);
						$outData = $out4;
						array_push($outData, $categoryFour);
						$results4 = serialize($outData);
					}
				}

			}
			
			if ($categoryCount > 4){
				
				if (file_exists('C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/' . $categoryFive)){
					 $contents = scandir('C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/' . $categoryFive);
					 if (count($contents) > 2)
					 {
						
					 }
					 else{
						 $out5[0] = "No file uploaded";
						
					 }
				}
				else {
					$out5[0] = "No file uploaded";
					
				}
				
				if (count($contents) > 2)
				{
					exec($command5, $out5, $return);
				
					if ($return != 0)
					{
						$out5[0] = "Product ID usage incorrect, please try again";
					}
					else if (sizeof($out5) != 12)
					{
						$out5[0] = "There was an error in RECS database, please try again later.";
					}
					else
					{
						$output5 = implode(" ", $out5);
						
						$output5 = trim($output5);
					
					
						$temp5 = strpos($output5, ":");
						
						
						$reco21 = substr($output5, $temp5 + 4, 10);
						$reco22 = substr($output5, $temp5 + 17, 10);
						$reco23 = substr($output5, $temp5 + 30, 10);
						$reco24 = substr($output5, $temp5 + 43, 10);
						$reco25 = substr($output5, $temp5 + 56, 10);
						
						$productOneDomainImage = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/getUrlAndImg.py C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/' . $categoryFive . '/ ' . $out5[3];
						exec($productOneDomainImage, $out5);
						$productTwoDomainImage = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/getUrlAndImg.py C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/' . $categoryFive . '/ ' . $out5[5];
						exec($productTwoDomainImage, $out5);
						$productThreeDomainImage = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/getUrlAndImg.py C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/' . $categoryFive . '/ ' . $out5[7];
						exec($productThreeDomainImage, $out5);
						$productFourDomainImage = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/getUrlAndImg.py C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/' . $categoryFive . '/ ' . $out5[9];
						exec($productFourDomainImage, $out5);
						$productFiveDomainImage = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/getUrlAndImg.py C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/' . $categoryFive . '/ ' . $out5[11];
						exec($productFiveDomainImage, $out5);
						$outData = $out5;
						array_push($outData, $categoryFive);
						$results5 = serialize($outData);
					}
				}

			}
			
			
			
			$user->createResultsFromReco ($productid, $results1, $results2, $results3, $results4, $results5, 3, $user_id);	
			$user->updateRecoForMonth ($user_id);
			echo json_encode(array('data'=>$out,'data2'=>$out2, 'data3'=>$out3, 'data4'=>$out4, 'data5'=>$out5));
		

	}
	else if ($type == 'urldata')
	{
		$categoryOne = $_POST['categoryOne'];
		$categoryTwo = $_POST['categoryTwo'];
		$categoryThree = $_POST['categoryThree'];
		$categoryFour = $_POST['categoryFour'];
		$categoryFive = $_POST['categoryFive'];
		$categoryCount = $_POST['categoryCount'];
		$command2 = $_POST['command2'];
		$command3 = $_POST['command3'];
		$command4 = $_POST['command4'];
		$command5 = $_POST['command5'];
	
		// Execute the command and store the output in an array
		$out = array();
		$out2 = array();
		$out3 = array();
		$out4 = array();
		$out5 = array();
		
			
		
		$csvFolderPath1 = 'C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/crawled/". $categoryOne;
		$csvFolderPath2 = 'C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/crawled/". $categoryTwo;
		$csvFolderPath3 = 'C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/crawled/". $categoryThree;
		$csvFolderPath4 = 'C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/crawled/". $categoryFour;
		$csvFolderPath5 = 'C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/crawled/". $categoryFive;
		
		if ($categoryCount == 1) {
			if (file_exists($csvFolderPath1)){
				 $contents = scandir($csvFolderPath1);
				 if (count($contents) > 2)
				 {
					$count = count($contents);
				 }
				 else{
					 $out[0] = "No file uploaded or crawled";
					 exit (json_encode(array('data'=>$out,'data2'=>$out2, 'data3'=>$out3, 'data4'=>$out4, 'data5'=>$out5)));
				
				 }
			}
			else {
				$out[0] = "No file uploaded or crawled";
				exit (json_encode(array('data'=>$out,'data2'=>$out2, 'data3'=>$out3, 'data4'=>$out4, 'data5'=>$out5)));
			}
		}
		
		if ($categoryCount == 2) {
			if (file_exists($csvFolderPath1) or file_exists($csvFolderPath2)){
				 $contents = scandir($csvFolderPath1) ;
				 $contents2 = scandir($csvFolderPath2);
				 $count = count($contents) + count($contents2);
				 if (count($contents) > 2 or count($contents2) > 2)
				 {
					//continue
				 }
				 else{
					 $out[0] = "No file uploaded or crawled";
					 $out2[0] = "No file uploaded or crawled";
					 exit (json_encode(array('data'=>$out,'data2'=>$out2, 'data3'=>$out3, 'data4'=>$out4, 'data5'=>$out5)));
				 }
			}
			else {
				$out[0] = "No file uploaded or crawled";
					$out2[0] = "No file uploaded or crawled";
				exit (json_encode(array('data'=>$out,'data2'=>$out2, 'data3'=>$out3, 'data4'=>$out4, 'data5'=>$out5)));
			}
		}
		
		if ($categoryCount == 3) {
			if (file_exists($csvFolderPath1) or file_exists($csvFolderPath2) or 
			file_exists($csvFolderPath3)){
				 $contents = scandir($csvFolderPath1);
				 $contents2 = scandir($csvFolderPath2);
				 $contents3 = scandir($csvFolderPath3);
				 $count = count($contents) + count($contents2) + count($contents3);
				 if (count($contents) > 2 or count($contents2) > 2 or count($contents3) > 2)
				 {
					//continue
				 }
				 else{
					 $out[0] = "No file uploaded or crawled";
					 $out2[0] = "No file uploaded or crawled";
					 $out3[0] = "No file uploaded or crawled";
					 exit (json_encode(array('data'=>$out,'data2'=>$out2, 'data3'=>$out3, 'data4'=>$out4, 'data5'=>$out5)));
				 }
			}
			else {
				$out[0] = "No file uploaded or crawled";
				$out2[0] = "No file uploaded or crawled";
				$out3[0] = "No file uploaded or crawled";
				exit (json_encode(array('data'=>$out,'data2'=>$out2, 'data3'=>$out3, 'data4'=>$out4, 'data5'=>$out5)));
			}
		}
		
		
		if ($categoryCount == 4) {
			if (file_exists($csvFolderPath1) or file_exists($csvFolderPath2) or 
			file_exists($csvFolderPath3) or file_exists($csvFolderPath4)){
				 $contents = scandir($csvFolderPath1);
				 $contents2 = scandir($csvFolderPath2);
				 $contents3 = scandir($csvFolderPath3);
				 $contents4 = scandir($csvFolderPath4);
				 $count = count($contents) + count($contents2) + count($contents3) + count($contents4);
				 if (count($contents) > 2 or count($contents2) > 2 or count($contents3) > 2 or count($contents4) > 2)
				 {
					//continue
				 }
				 else{
					 $out4[0] = "No file uploaded or crawled";
					 $out[0] = "No file uploaded or crawled";
					$out2[0] = "No file uploaded or crawled";
					$out3[0] = "No file uploaded or crawled";
					exit (json_encode(array('data'=>$out,'data2'=>$out2, 'data3'=>$out3, 'data4'=>$out4, 'data5'=>$out5)));
				 }
			}
			else {
				$out4[0] = "No file uploaded or crawled";
				$out[0] = "No file uploaded or crawled";
				$out2[0] = "No file uploaded or crawled";
				$out3[0] = "No file uploaded or crawled";
				exit (json_encode(array('data'=>$out,'data2'=>$out2, 'data3'=>$out3, 'data4'=>$out4, 'data5'=>$out5)));
			}
		}
		
		
		if ($categoryCount == 5) {
			if (file_exists($csvFolderPath1) or file_exists($csvFolderPath2) or 
			file_exists($csvFolderPath3) or file_exists($csvFolderPath4) or 
			file_exists($csvFolderPath5)){
				 $contents = scandir($csvFolderPath1);
				 $contents2 = scandir($csvFolderPath2);
				 $contents3 = scandir($csvFolderPath3);
				 $contents4 = scandir($csvFolderPath4);
				 $contents5 = scandir($csvFolderPath5);
				 $count = count($contents) + count($contents2) + count($contents3) + count($contents4) + count($contents5);
				 if (count($contents) > 2 or count($contents2) > 2 or count($contents3) > 2 or count($contents4) > 2 or count($contents5) > 2)
				 {
					//continue
				 }
				 else{
					 $out5[0] = "No file uploaded or crawled";
					 $out4[0] = "No file uploaded or crawled";
					$out[0] = "No file uploaded or crawled";
					$out2[0] = "No file uploaded or crawled";
					$out3[0] = "No file uploaded or crawled";
					exit (json_encode(array('data'=>$out,'data2'=>$out2, 'data3'=>$out3, 'data4'=>$out4, 'data5'=>$out5)));
				 }
			}
			else {
				$out5[0] = "No file uploaded or crawled";
				$out4[0] = "No file uploaded or crawled";
				$out[0] = "No file uploaded or crawled";
				$out2[0] = "No file uploaded or crawled";
				$out3[0] = "No file uploaded or crawled";
				exit (json_encode(array('data'=>$out,'data2'=>$out2, 'data3'=>$out3, 'data4'=>$out4, 'data5'=>$out5)));
			}
		}
		
		
		
			if ($categoryCount == 1) {
					
				if (checkProductInCSVFolder($productid, $csvFolderPath1)){
					//
				}
				else{
					$out[0] = "Product ID does not exist.";
					exit (json_encode(array('data'=>$out,'data2'=>$out2, 'data3'=>$out3, 'data4'=>$out4, 'data5'=>$out5)));
				}
			}
			else if ($categoryCount == 2)
			{
				if (checkProductInCSVFolder($productid, $csvFolderPath1) or checkProductInCSVFolder($productid, $csvFolderPath2)){
					//
				}
				else{
					$out[0] = "Product ID does not exist.";
					exit (json_encode(array('data'=>$out,'data2'=>$out2, 'data3'=>$out3, 'data4'=>$out4, 'data5'=>$out5)));
				}
			}
			else if ($categoryCount == 3)
			{
				if (checkProductInCSVFolder($productid, $csvFolderPath1) or checkProductInCSVFolder($productid, $csvFolderPath2) or checkProductInCSVFolder($productid, $csvFolderPath3)){
					//
				}
				else{
					$out[0] = "Product ID does not exist.";
					exit (json_encode(array('data'=>$out,'data2'=>$out2, 'data3'=>$out3, 'data4'=>$out4, 'data5'=>$out5)));
				}
			}
			else if ($categoryCount == 4)
			{
				if (checkProductInCSVFolder($productid, $csvFolderPath1) or checkProductInCSVFolder($productid, $csvFolderPath2) or checkProductInCSVFolder($productid, $csvFolderPath3) 
					or checkProductInCSVFolder($productid, $csvFolderPath4)){
					//
				}
				else{
					$out[0] = "Product ID does not exist.";
					exit (json_encode(array('data'=>$out,'data2'=>$out2, 'data3'=>$out3, 'data4'=>$out4, 'data5'=>$out5)));
				}
			}
			else if ($categoryCount == 5)
			{
				if (checkProductInCSVFolder($productid, $csvFolderPath1) or checkProductInCSVFolder($productid, $csvFolderPath2) or checkProductInCSVFolder($productid, $csvFolderPath3) 
					or checkProductInCSVFolder($productid, $csvFolderPath4) or checkProductInCSVFolder($productid, $csvFolderPath5)){
					//
				}
				else{
					$out[0] = "Product ID does not exist.";
					exit (json_encode(array('data'=>$out,'data2'=>$out2, 'data3'=>$out3, 'data4'=>$out4, 'data5'=>$out5)));
				}
			}
		
		
		

		if (file_exists($csvFolderPath1)){
			 $contents = scandir($csvFolderPath1);
			 if (count($contents) > 2)
			 {
				$count = count($contents);
			 }
			 else{
				 $out[0] = "No file uploaded";
			 }
		}
		else {
			$out[0] = "No file uploaded";
		}
		
		
		if (count($contents) > 2)
		{

		
			exec($command, $out, $return);
			if ($return != 0)
			{
				$out[0] = "Product ID usage incorrect, please try again";
				
				
			}
			else if (sizeof($out) != 12)
			{
				$out[0] = "There should be at least 5 different products in your dataset. Please try again once you have added them in.";
			}
			else
			{
				//exec($command0, $output);
				/*$command1 = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/generateImage.py ' . $out[3];
				exec($command1, $out);
				$command2 = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/generateImage.py ' . $out[5];
				exec($command2, $out);
				$command3 = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/generateImage.py ' . $out[7];
				exec($command3, $out);
				$command4 = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/generateImage.py ' . $out[9];
				exec($command4, $out);
				$command5 = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/generateImage.py ' . $out[11];
				exec($command5, $out);*/
				
				$output = implode(" ", $out);
				

				
				$output = trim($output);
			
			
				$temp1 = strpos($output, ":");
				
				
				$reco1 = substr($output, $temp1 + 4, 10);
				$reco2 = substr($output, $temp1 + 17, 10);
				$reco3 = substr($output, $temp1 + 30, 10);
				$reco4 = substr($output, $temp1 + 43, 10);
				$reco5 = substr($output, $temp1 + 56, 10);
				
				//$user = new User();
				//$user->createResultsFromReco ($productid, $reco1, $reco2, $reco3, $reco4, $reco5, 1, $user_id);
				//$user->updateRecoForMonth ($user_id);
				
					shell_exec('C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/specialcharfilter.py' . ' C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . '/crawled/'. $categoryOne . '/');
					$productOneDomainImage = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/getUrlAndImg.py C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . '/crawled/'. $categoryOne . '/ ' . $out[3];
					exec($productOneDomainImage, $out);
					$productTwoDomainImage = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/getUrlAndImg.py C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/crawled/". $categoryOne . '/ ' . $out[5];
					exec($productTwoDomainImage, $out);
					$productThreeDomainImage = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/getUrlAndImg.py C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/crawled/". $categoryOne . '/ ' . $out[7];
					exec($productThreeDomainImage, $out);
					$productFourDomainImage = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/getUrlAndImg.py C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/crawled/". $categoryOne . '/ ' . $out[9];
					exec($productFourDomainImage, $out);
					$productFiveDomainImage = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/getUrlAndImg.py C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/crawled/". $categoryOne . '/ ' . $out[11];
					exec($productFiveDomainImage, $out);
					$outData = $out;
					array_push($outData, $categoryOne);
					$results1 = serialize($outData);
			}	
		}
			
			if ($categoryCount > 1){
				
				
				if (file_exists('C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/crawled/". $categoryTwo)){
					$contents = scandir('C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/crawled/". $categoryTwo);
					if (count($contents) > 2)
					{
					
					}
					else{
						$out2[0] = "No file uploaded";
					
					}
				}
				else {
					$out2[0] = "No file uploaded";
					
				}
				
				if (count($contents) > 2)
				{
				
				
					exec($command2, $out2, $return);
					
					
					if ($return != 0)
					{
						$out2[0] = "Product ID usage incorrect, please try again";
						
						
					}
					else if (sizeof($out2) != 12)
					{
						$out2[0] = "There should be at least 5 different products in your dataset. Please try again once you have added them in.";
					}
					else 
					{
						$output2 = implode(" ", $out2);
						
						$output2 = trim($output2);
					
					
						$temp2 = strpos($output2, ":");
						
						
						$reco6 = substr($output2, $temp2 + 4, 10);
						$reco7 = substr($output2, $temp2 + 17, 10);
						$reco8 = substr($output2, $temp2 + 30, 10);
						$reco9 = substr($output2, $temp2 + 43, 10);
						$reco10 = substr($output2, $temp2 + 56, 10);
						
						shell_exec('C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/specialcharfilter.py' . ' C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . '/crawled/'. $categoryTwo . '/');

						$productOneDomainImage = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/getUrlAndImg.py C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/crawled/". $categoryTwo . '/ ' . $out2[3];
						exec($productOneDomainImage, $out2);
						$productTwoDomainImage = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/getUrlAndImg.py C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/crawled/". $categoryTwo . '/ ' . $out2[5];
						exec($productTwoDomainImage, $out2);
						$productThreeDomainImage = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/getUrlAndImg.py C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/crawled/". $categoryTwo . '/ ' . $out2[7];
						exec($productThreeDomainImage, $out2);
						$productFourDomainImage = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/getUrlAndImg.py C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/crawled/". $categoryTwo . '/ ' . $out2[9];
						exec($productFourDomainImage, $out2);
						$productFiveDomainImage = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/getUrlAndImg.py C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/crawled/". $categoryTwo . '/ ' . $out2[11];
						exec($productFiveDomainImage, $out2);
						
						$outData = $out2;
						array_push($outData, $categoryTwo);
						$results2 = serialize($outData);
					}
				}
			}
			
			if ($categoryCount > 2){
				
				if (file_exists('C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/crawled/". $categoryThree)){
					$contents = scandir('C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/crawled/". $categoryThree);
					if (count($contents) > 2)
					{
					
					}
					else{
						$out3[0] = "No file uploaded";
					
					}
				}
				else {
					$out3[0] = "No file uploaded";
					
				}
				
				if (count($contents) > 2)
				{
					exec($command3, $out3, $return);
					
					if ($return != 0)
					{
						$out3[0] = "Product ID usage incorrect, please try again";
						
						
					}
					else if (sizeof($out3) != 12)
					{
						$out3[0] = "There should be at least 5 different products in your dataset. Please try again once you have added them in.";
					}
					else 
					{
						$output3 = implode(" ", $out3);
						
						$output3 = trim($output3);
					
					
						$temp3 = strpos($output3, ":");
						
						
						$reco11 = substr($output3, $temp3 + 4, 10);
						$reco12 = substr($output3, $temp3 + 17, 10);
						$reco13 = substr($output3, $temp3 + 30, 10);
						$reco14 = substr($output3, $temp3 + 43, 10);
						$reco15 = substr($output3, $temp3 + 56, 10);
						
						shell_exec('C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/specialcharfilter.py' . ' C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . '/crawled/'. $categoryThree . '/');
						
						$productOneDomainImage = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/getUrlAndImg.py C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/crawled/". $categoryThree . '/ ' . $out3[3];
						exec($productOneDomainImage, $out3);
						$productTwoDomainImage = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/getUrlAndImg.py C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/crawled/". $categoryThree . '/ ' . $out3[5];
						exec($productTwoDomainImage, $out3);
						$productThreeDomainImage = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/getUrlAndImg.py C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/crawled/". $categoryThree . '/ ' . $out3[7];
						exec($productThreeDomainImage, $out3);
						$productFourDomainImage = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/getUrlAndImg.py C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/crawled/". $categoryThree . '/ ' . $out3[9];
						exec($productFourDomainImage, $out3);
						$productFiveDomainImage = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/getUrlAndImg.py C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/crawled/". $categoryThree . '/ ' . $out3[11];
						exec($productFiveDomainImage, $out3);
						
						$outData = $out3;
						array_push($outData, $categoryThree);
						$results3 = serialize($outData);
					}
				}

			}
			
			if ($categoryCount > 3){
				
				if (file_exists('C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/crawled/". $categoryFour)){
					$contents = scandir('C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/crawled/". $categoryFour);
					if (count($contents) > 2)
					{
					
					}
					else{
						$out4[0] = "No file uploaded";
					
					}
				}
				else {
					$out4[0] = "No file uploaded";
				}
				
				if (count($contents) > 2)
				{
					
					exec($command4, $out4, $return);
					
					if ($return != 0)
					{
						$out4[0] = "Product ID usage incorrect, please try again";
						
						
					}
					else if (sizeof($out4) != 12)
					{
						$out4[0] = "There should be at least 5 different products in your dataset. Please try again once you have added them in.";
					}
					else
					{
						$output4 = implode(" ", $out4);
						
						$output4 = trim($output4);
					
					
						$temp4 = strpos($output4, ":");
						
						
						$reco16 = substr($output4, $temp4 + 4, 10);
						$reco17 = substr($output4, $temp4 + 17, 10);
						$reco18 = substr($output4, $temp4 + 30, 10);
						$reco19 = substr($output4, $temp4 + 43, 10);
						$reco20 = substr($output4, $temp4 + 56, 10);

						shell_exec('C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/specialcharfilter.py' . ' C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . '/crawled/'. $categoryFour . '/');
						
						$productOneDomainImage = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/getUrlAndImg.py C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/crawled/". $categoryFour . '/ ' . $out4[3];
						exec($productOneDomainImage, $out4);
						$productTwoDomainImage = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/getUrlAndImg.py C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/crawled/". $categoryFour . '/ ' . $out4[5];
						exec($productTwoDomainImage, $out4);
						$productThreeDomainImage = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/getUrlAndImg.py C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/crawled/". $categoryFour . '/ ' . $out4[7];
						exec($productThreeDomainImage, $out4);
						$productFourDomainImage = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/getUrlAndImg.py C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/crawled/". $categoryFour . '/ ' . $out4[9];
						exec($productFourDomainImage, $out4);
						$productFiveDomainImage = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/getUrlAndImg.py C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/crawled/". $categoryFour . '/ ' . $out4[11];
						exec($productFiveDomainImage, $out4);
						
						$outData = $out4;
						array_push($outData, $categoryFour);
						$results4 = serialize($outData);
					}
				}
			}
			
			if ($categoryCount > 4){
				
				if (file_exists('C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/crawled/". $categoryFive)){
					$contents = scandir('C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/crawled/". $categoryFive);
					if (count($contents) > 2)
					{
					
					}
					else{
						$out5[0] = "No file uploaded";
					
					}
				}
				else {
					$out5[0] = "No file uploaded";
				}
				
				if (count($contents) > 2)
				{
					exec($command5, $out5, $return);
					
					if ($return != 0)
					{
						$out5[0] = "Product ID usage incorrect, please try again";
						
						
					}
					else if (sizeof($out5) != 12)
					{
						$out5[0] = "There should be at least 5 different products in your dataset. Please try again once you have added them in.";
					}
					else
					{
						$output5 = implode(" ", $out5);
						
						$output5 = trim($output5);
					
					
						$temp5 = strpos($output5, ":");
						
						
						$reco21 = substr($output5, $temp5 + 4, 10);
						$reco22 = substr($output5, $temp5 + 17, 10);
						$reco23 = substr($output5, $temp5 + 30, 10);
						$reco24 = substr($output5, $temp5 + 43, 10);
						$reco25 = substr($output5, $temp5 + 56, 10);

						shell_exec('C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/specialcharfilter.py' . ' C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . '/crawled/'. $categoryFive . '/');
						
						$productOneDomainImage = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/getUrlAndImg.py C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/crawled/". $categoryFive . '/ ' . $out5[3];
						exec($productOneDomainImage, $out5);
						$productTwoDomainImage = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/getUrlAndImg.py C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/crawled/". $categoryFive . '/ ' . $out5[5];
						exec($productTwoDomainImage, $out5);
						$productThreeDomainImage = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/getUrlAndImg.py C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/crawled/". $categoryFive . '/ ' . $out5[7];
						exec($productThreeDomainImage, $out5);
						$productFourDomainImage = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/getUrlAndImg.py C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/crawled/". $categoryFive . '/ ' . $out5[9];
						exec($productFourDomainImage, $out5);
						$productFiveDomainImage = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/getUrlAndImg.py C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/crawled/". $categoryFive . '/ ' . $out5[11];
						exec($productFiveDomainImage, $out5);
						
						$outData = $out5;
						array_push($outData, $categoryFive);
						$results5 = serialize($outData);
					}
				}

			}
			
		
			
			$user->createResultsFromReco ($productid, $results1, $results2, $results3, $results4, $results5, 5, $user_id);	
			$user->updateRecoForMonth ($user_id);
			echo json_encode(array('data'=>$out,'data2'=>$out2, 'data3'=>$out3, 'data4'=>$out4, 'data5'=>$out5));
			
		

	}
				
	
} else {
    echo "No command provided.";
}
?>
