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

function checkSubstringInCSVFolder($user, $folderPath) {
    $csvFiles = glob($folderPath . '/*.csv');
    
    foreach ($csvFiles as $csvFile) {
        $lines = file($csvFile, FILE_IGNORE_NEW_LINES);
        
        foreach ($lines as $line) {
            if (strpos($line, $user) !== false) {
                return true;
            }
        }
    }
    
    return false;
}
/*
function getDomainFromProductId($folderPath, $productId) {
    $files = glob($folderPath . '/*.csv');
    foreach ($files as $file) {
        $csvFile = fopen($file, 'r');
        if ($csvFile) {
            while (($row = fgetcsv($csvFile)) !== false) {
                if ($row[1] == $productId) { // Check if product ID matches
                    fclose($csvFile);
                    return $row[3]; // Return the domain from the same row
                }
            }
            fclose($csvFile);
        }
    }
    return null; // Return null if product ID is not found in any CSV file
}

function getDomainFromUserId($folderPath, $userId) {
    $files = glob($folderPath . '/*.csv');
    foreach ($files as $file) {
        $csvFile = fopen($file, 'r');
        if ($csvFile) {
            while (($row = fgetcsv($csvFile)) !== false) {
                if (strpos($row[0], $userId) !== false) { // Check if user ID matches
                    fclose($csvFile);
                    return $row[3] . $row[0]; // Return the domain from the same row
                }
            }
            fclose($csvFile);
        }
    }
    return null; // Return null if product ID is not found in any CSV file
}
*/	
if (isset($_POST['command'])) {
    // Get the command from the AJAX request
    $command = $_POST['command'];
	$user_id = $_POST['userid'];
	$productid = $_POST['product'];
	$userid = $_POST['user'];
	$type = $_POST['type'];
	
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
			<p><center>
				You have exceeded the recommendation limit.
			</center></p>
			";
	
	}
	else if ($type == 'uploadeddata')
	{
		
		
		$categories = array('electronics', 'toys', 'pets', 'computers', 'videogames');
		$anyFileExists = false;
		foreach ($categories as $category) {
			$path = 'C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/data/" . $category . "/";
			if (file_exists($path)) {
				$contents = scandir($path);
				if (count($contents) > 2) {
					$anyFileExists = true;
					break;
				}
			}
		}
		if ($anyFileExists) {
			// At least one file exists in one of the folders, do something
		} else {
			$output = "<p><center>
								No file uploaded
							</center></p>";
							
			exit($output);
		}

		
		if ($anyFileExists){
			// Execute the command and store the output in an array
			$out = array();
			
			$csvFolderPath1 = 'C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/data/computers";
			$csvFolderPath2 = 'C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/data/pets";
			$csvFolderPath3 = 'C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/data/videogames";
			$csvFolderPath4 = 'C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/data/electronics";
			$csvFolderPath5 = 'C:/xampp/htdocs/dashboard/FYP/uploads/' . $user_id . "/data/toys";
			
			if (checkProductInCSVFolder($productid, $csvFolderPath1) or checkProductInCSVFolder($productid, $csvFolderPath2) or checkProductInCSVFolder($productid, $csvFolderPath3) 
				or checkProductInCSVFolder($productid, $csvFolderPath4) or checkProductInCSVFolder($productid, $csvFolderPath5)){
				//
			}
			else{
				$output = "<p><center>Product ID does not exist.</center></p>";
				exit ($output);
			}
			
			if ((checkSubstringInCSVFolder($userid, $csvFolderPath1) or checkSubstringInCSVFolder($userid, $csvFolderPath2) or checkSubstringInCSVFolder($userid, $csvFolderPath3) 
				or checkSubstringInCSVFolder($userid, $csvFolderPath4) or checkSubstringInCSVFolder($userid, $csvFolderPath5)) and (strlen($userid) > 13)){
				//
			}
			else{
				$output = "<p><center>User ID does not exist.</center></p>";
				exit ($output);
			}
			
			exec($command, $out, $return);
			
			if ($return != 0) //if error
			{
		
				$output = "<p><center>
				Product ID or User ID usage incorrect, please try again
				</center></p>
				";
				
				exit($output);
			}
			else
			{
				
				$output = implode(" ", $out);
				
				$output = trim($output);
			
				$temp = strpos($output, ".");
			
				$temp2 = strrpos($output, ":");
				$rating = substr($output, $temp2 + 2, 2);
				$rating = trim($rating);
				$user = new User();
				
				
				
				$user->createResultsFromRating ($userid, $productid, $rating, 2, $user_id);
				$user->updateRecoForMonth ($user_id);
				
				$output = "<div style = 'transform:translate(0%, -550%);'>
					<p><center>"

						. substr($output, 0, $temp + 5) . 
					"</center></p></br>" . 
					"<p><center>"

						 . substr($output, $temp + 5) . 
					"</center></p></div>";
					
			}
			// Send the output back to the client
			
		}
		else{
			$output = "<p><center>
								No file uploaded
							</center></p>";
				
		}
	}
	else if ($type == 'recsdata')
	{
		$out = array();
		
		$csvFolderPath1 = 'C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/computers';
		$csvFolderPath2 = 'C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/toys';
		$csvFolderPath3 = 'C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/pets';
		$csvFolderPath4 = 'C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/electronics';
		$csvFolderPath5 = 'C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/videogames';
		
		if (checkProductInCSVFolder($productid, $csvFolderPath1) or checkProductInCSVFolder($productid, $csvFolderPath2) or checkProductInCSVFolder($productid, $csvFolderPath3) 
			or checkProductInCSVFolder($productid, $csvFolderPath4) or checkProductInCSVFolder($productid, $csvFolderPath5)){
			//
		}
		else{
			$output = "<p><center>Product ID does not exist.</center></p>";
			exit ($output);
		}
		
		if ((checkSubstringInCSVFolder($userid, $csvFolderPath1) or checkSubstringInCSVFolder($userid, $csvFolderPath2) or checkSubstringInCSVFolder($userid, $csvFolderPath3) 
			or checkSubstringInCSVFolder($userid, $csvFolderPath4) or checkSubstringInCSVFolder($userid, $csvFolderPath5)) and (strlen($userid) > 13)){
			//
		}
		else{
			$output = "<p><center>User ID does not exist.</center></p>";
			exit ($output);
		}
	
		exec($command, $out, $return);
		
		if ($return != 0)
		{
	
			$output = "<p><center>
			Product ID or User ID usage incorrect, please try again
			</center><p>
			";
			
			exit($output);
		}
		else
		{
			
			
			$output = implode(" ", $out);
			
			$output = trim($output);
		
			$temp = strpos($output, ".");
		
			$temp2 = strrpos($output, ":");
			$rating = substr($output, $temp2 + 2, 2);
			$rating = trim($rating);
			$user = new User();
				
			$user->createResultsFromRating ($userid, $productid, $rating, 4, $user_id);
		
			$user->updateRecoForMonth ($user_id);
			
			$output = "<div style = 'transform:translate(0%, -550%);'>
				<p><center>"

					. substr($output, 0, $temp + 5) .
				"</center></p><br/>" . 
				"<p><center>"

					 . substr($output, $temp + 5) . 
				"</center></p></div>";
		}
	}
	else if ($type == 'urldata')
	{
		$out = array();
		
		$csvFolderPath1 = "C:/xampp/htdocs/dashboard/FYP/uploads/" . $user_id . "/crawled/computers";
		$csvFolderPath2 = "C:/xampp/htdocs/dashboard/FYP/uploads/" . $user_id . "/crawled/pets";
		$csvFolderPath3 = "C:/xampp/htdocs/dashboard/FYP/uploads/" . $user_id . "/crawled/toys";
		$csvFolderPath4 = "C:/xampp/htdocs/dashboard/FYP/uploads/" . $user_id . "/crawled/videogames";
		$csvFolderPath5 = "C:/xampp/htdocs/dashboard/FYP/uploads/" . $user_id . "/crawled/electronics";
		
		if (checkProductInCSVFolder($productid, $csvFolderPath1) or checkProductInCSVFolder($productid, $csvFolderPath2) or checkProductInCSVFolder($productid, $csvFolderPath3) 
			or checkProductInCSVFolder($productid, $csvFolderPath4) or checkProductInCSVFolder($productid, $csvFolderPath5)){
			//
		}
		else{
			$output = "<p><center>Product ID does not exist.</center></p>";
			exit ($output);
		}
		
		if ((checkSubstringInCSVFolder($userid, $csvFolderPath1) or checkSubstringInCSVFolder($userid, $csvFolderPath2) or checkSubstringInCSVFolder($userid, $csvFolderPath3) 
			or checkSubstringInCSVFolder($userid, $csvFolderPath4) or checkSubstringInCSVFolder($userid, $csvFolderPath5)) and (strlen($userid) > 13)){
			//
		}
		else{
			$output = "<p><center>User ID does not exist.</center></p>";
			exit ($output);
		}
		
		exec($command, $out, $return);
		
		if ($return != 0)
		{
	
			$output = "<p><center>
			Product ID or User ID usage incorrect, please try again
			</center><p>
			";
			
			exit($output);
		}
		else
		{
			
			
			$output = implode(" ", $out);
			
			$output = trim($output);
		
			$temp = strpos($output, ".");
		
			$temp2 = strrpos($output, ":");
			$rating = substr($output, $temp2 + 2, 2);
			$rating = trim($rating);
			$user = new User();
			/*
			$allFiles = array($csvFolderPath1, $csvFolderPath2, $csvFolderPath3, $csvFolderPath4, $csvFolderPath5);
			foreach ($allFiles as $aFile)
			{
				if (getDomainFromProductId($aFile, $productid) != false){
					$domainProduct = getDomainFromProductId($aFile, $productid);
				}
				
				if (getDomainFromUserId($aFile, $userid) != false){
					$domainUser = getDomainFromUserId($aFile, $userid);
				}
			}
			*/
			$user->createResultsFromRating ($userid, $productid, $rating, 6, $user_id);
			
			$user->updateRecoForMonth ($user_id);
			
			$output = "<div style = 'transform:translate(0%, -550%);'>
				<p><center>"

					. substr($output, 0, $temp + 5) .
				"</center></p><br/>" . 
				"<p><center>"

					 . substr($output, $temp + 5) . 
				"</center></p></div>";
		}
	}
	
    echo $output;
} else {
    echo "No command provided.";
}
?>
