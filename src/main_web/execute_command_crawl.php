<?php
if (isset($_POST['userid'])) {
    // Get the command from the AJAX request
	$userid = $_POST['userid'];
	$fullfilename = $_POST['fullfilename'];
	$filenamewithoutextension = $_POST['filenamewithoutextension'];
	
	$filename = 'C:/xampp/htdocs/dashboard/FYP/uploads/' . $userid . '/list/' . $fullfilename;
	$valid_categories = array('electronics', 'computers', 'toys', 'pets', 'videogames');
	$line_number = 0;
	$validFile = true;
	
	
	$categoryfolder1 = "C:/xampp/htdocs/dashboard/FYP/uploads/" . $userid . "/crawled/electronics/";
	$categoryfolder2 = "C:/xampp/htdocs/dashboard/FYP/uploads/" . $userid . "/crawled/toys/";
	$categoryfolder3 = "C:/xampp/htdocs/dashboard/FYP/uploads/" . $userid . "/crawled/pets/";
	$categoryfolder4 = "C:/xampp/htdocs/dashboard/FYP/uploads/" . $userid . "/crawled/computers/";
	$categoryfolder5 = "C:/xampp/htdocs/dashboard/FYP/uploads/" . $userid . "/crawled/videogames/";
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

	// Open the file for reading
	$handle = fopen($filename, 'r');

	// Read the file line by line
	while (($line = fgets($handle)) !== false) {
		// Increment the line number
		$line_number++;

		// Trim any whitespace from the line
		$line = trim($line);

		// If this is the first line, set the category and continue
		if ($line_number === 1) {
			$category = $line;
			if (!in_array($category, $valid_categories)) {
			  echo 'Invalid category on line ' . $line_number . ': ' . $category . "\n";
			  $validFile = false;
			  break;
			}
			continue;
		}

		// Check that the string is a valid URL that does not return 404
		$url = $line;
		$headers = @get_headers($url);
		if (!$headers || strpos($headers[0], '404') !== false) {
			echo 'Invalid URL on line ' . $line_number . ': ' . $url . "\n";
			$validFile = false;
			continue;
		}

		// The line is valid!
		//echo 'Valid line: ' . $line . "\n";
	}

		// Close the file
		fclose($handle);

	
	if ($validFile == true){
		//command = 'cd C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders && C:/Users/Administrator/AppData/Local/Programs/Python/Python311/Scripts/scrapy crawl amazon_scraping_txt -a txt="C:/xampp/htdocs/dashboard/FYP/uploads/' + $userid + '/list/' + $fullfilename + '" -o ../../../uploads/' + $userid + '/crawled/' + $filenamewithoutextension + '.csv';
		$fileoutput = 'C:/xampp/htdocs/dashboard/FYP/uploads/' . $userid . '/crawled/' . $category;
		if (!is_dir($fileoutput)) {
		  mkdir($fileoutput, 0777, true);
		}
		//C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/txtcrawler.py C:/xampp/htdocs/dashboard/FYP/uploads/153/list/links4.txt ../../uploaded/143/crawled/electronics/links4.csv
		$crawlcommand = 'cd C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders && C:/Users/Administrator/AppData/Local/Programs/Python/Python311/Scripts/scrapy crawl amazon_scraping_txt -a txt=C:/xampp/htdocs/dashboard/FYP/uploads/' . $userid . '/list/' . $fullfilename . ' -o ../../../uploads/' . $userid . '/crawled/' . $category . '/' . $filenamewithoutextension . '.csv';
		$out = array();
		exec($crawlcommand, $out, $return);
		
		//check that shell command ran successfully
		if ($return != 0){
			echo "Crawling failed to take place. Please try again.";
		}
		else {
			//check file isnt empty
			if (filesize($fileoutput . "/" . $filenamewithoutextension . ".csv") > 0) {
				echo "Crawled";
			}
			else {
				unlink($fileoutput . "/" . $filenamewithoutextension . ".csv");
				echo "There was an issue when crawling, please try again.";
				
			}
		}
		
		//echo $crawlcommand;
	}

	//$product = $_POST['product'];

    // Sanitize and validate the command
    // ...

    // Execute the command and store the output in an array
    //exec($command, $output);
	//$command0 = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/generateImage.py ' . $product;
	//exec($command0, $output);
//	$command1 = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/generateImage.py ' . $output[3];
//	exec($command1, $output);
//	$command2 = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/generateImage.py ' . $output[5];
//	exec($command2, $output);
//	$command3 = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/generateImage.py ' . $output[7];
//exec($command3, $output);
//	$command4 = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/generateImage.py ' . $output[9];
//	exec($command4, $output);
//	$command5 = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/generateImage.py ' . $output[11];
	//exec($command5, $output);

	
    // Send the output back to the client
   //echo json_encode($output);
} else {
    echo "No command provided.";
}
?>
