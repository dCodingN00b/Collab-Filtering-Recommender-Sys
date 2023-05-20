<?php
if (isset($_POST['command'])) {
    // Get the command from the AJAX request
    $command = $_POST['command'];
	$category = $_POST['category'];
	//$product = $_POST['product'];

    // Sanitize and validate the command
    // ...
	$out = array();

    // Execute the command and store the output in an array
    exec($command, $out);
	
	//$command0 = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/generateImage.py ' . $product;
	//exec($command0, $output);
	$productOneDomainImage = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/getUrlAndImg.py C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/' . $category. '/ ' . $out[3];
	exec($productOneDomainImage, $out);
	//$productOneName = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/getName.py ' . $out[3];	
	//exec($productOneName, $out);
	
	$productTwoDomainImage = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/getUrlAndImg.py C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/' . $category. '/ ' . $out[5];
	exec($productTwoDomainImage, $out);
	//$productTwoName = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/getName.py ' . $out[5];	
	//exec($productTwoName, $out);
	
	$productThreeDomainImage = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/getUrlAndImg.py C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/' . $category. '/ ' . $out[7];
	exec($productThreeDomainImage, $out);
	//$productThreeName = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/getName.py ' . $out[7] . ' ' . $out[18];	
	//exec($productThreeName, $out);
	
	$productFourDomainImage = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/getUrlAndImg.py C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/' . $category. '/ ' . $out[9];
	exec($productFourDomainImage, $out);
	//$productFourName = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/getName.py ' . $out[9] . ' ' . $out[21];	
	//exec($productFourName, $out);
	
	$productFiveDomainImage = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/getUrlAndImg.py C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders/' . $category. '/ ' . $out[11];
	exec($productFiveDomainImage, $out);
	//$productFiveName = 'C:/Users/Administrator/AppData/Local/Programs/Python/Python311/python C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/getName.py ' . $out[11] . ' ' . $out[24];	
	//exec($productFiveName, $out);

	//$output = implode(" ", $out);
    // Send the output back to the client
    echo json_encode($out);
} else {
    echo "No command provided.";
}
?>
