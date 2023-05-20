<?php
	// We need to use sessions, so you should always start sessions using the below code.
	session_start();
	// If the user is not logged in redirect to the login page...
	if (!isset($_SESSION['loggedin'])) {
		header('Location:login.php');
		exit;
	}
	
	$id = '';
	$option = '';
	if (isset($_GET['id'])){
		$id = $_GET['id'];
	}
	
	if (isset($_GET['option'])){
		$option = $_GET['option'];
	}

	$userType = $_SESSION['userType'];
	$userid = $_SESSION['id'];
	
	$resultid = $_SESSION['results'];
	
?>
<!DOCTYPE html>
<html>
<head>
<style>
  table, th, td{
    border-collapse: collapse;
    border: 1px solid black;
	padding: 20px;
  }
  
  input[type="button"] {
  background-color: lightgreen; /* Set background color */
  border: none; /* Remove border */
  color: white; /* Set text color */
  padding: 10px 25px; /* Set padding */
  text-align: center; /* Center text */
  text-decoration: none; /* Remove underline */
  display: inline-block; /* Make element inline */
  font-size: 16px; /* Set font size */
  margin: 20px; /* Set margin */
  cursor: pointer; /* Add cursor pointer */
}

input[type="button"]:hover {
  background-color: #3e8e41; /* Set hover background color */
}

input[type="button"]:active {
  background-color: #3e8e41; /* Set active background color */
  box-shadow: 0 5px #666; /* Add shadow */
  transform: translateY(4px); /* Move button down */
}


/* Tooltip text */
.tooltip .tooltiptext {
  visibility: hidden;
  width: 220px;
  background-color: lightblue;
  color: black
  text-align: center;
  padding: 10px 10px;
  border: 1px solid black;
  border-radius: 6px;
 
  /* Position the tooltip text - see examples below! */
  position: absolute;
  z-index: 1;
  transform: translate(-50%, 0%);
}

/* Show the tooltip text when you mouse over the tooltip container */
.tooltip:hover .tooltiptext {
  visibility: visible;
}

</style>
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Results</title>
<?php 
include('navbar.php');

function capitalizeFirstLetter($string) {
    return ucfirst($string);
}


echo"<div class='results' id='results' style  = 'transform:translate(0%, -10%);'>";
echo"<div style = 'transform:translate(2%, 500%);'><input type='button' value='< Back' onclick='history.back()' style = 'padding: 10px 25px;'></div>";
		echo"<h1 style='text-align: center; font-size:30px'>Results</h1></div>";
		
		
		
		echo'<div style = "display:flex; justify-content: center; margin-left:270px; "> ';
		
		
		
		$user = new User();
		$results = $user -> getSpecificResult ($resultid);
		
		echo'
		</div>';
		echo"
		<div style = 'display:flex; justify-content: center; height: 1000px;'>
		<div class = 'resultpage' style='position: absolute; width: 500px;'>
		";
		
		$row = mysqli_fetch_array($results);
		if ($row['generatedType'] == 2 or $row['generatedType'] == 4 or $row['generatedType'] == 6){
			echo"
			<table border='1' style='transform:translate(-13%, 0%);'>
				<tr>
				<th><Strong>Result ID<Strong></th>
				<th><Strong>User ID<Strong></th>
				<th><Strong>Product ID<Strong></th>
				<th><Strong>Rating<Strong></th>
			</tr>";
			
			$producturl = "https://www.amazon.com.au/dp/" . $row['productID'];
			$userurl = "https://www.amazon.com/gp/profile/amzn1.account." . $row['userID'];
			echo"
			<tr style='text-align:center;'>
				<th>" . $row['resultID'] . "</th>
				<th style = 'font-weight: 500'><a href = '" . $userurl. "' style = 'text-decoration: underline; color: blue;'>" .$row['userID'] . "</a></th>
				<th style = 'font-weight: 500'><a href = '" . $producturl. "' style = 'text-decoration: underline; color: blue;'>" .$row['productID'] . "</a></th>
				<th>".$row['rating'] . "</th>
				
				
			</tr></table>";
			
		}
		else if ($row['generatedType'] == 3 or $row['generatedType'] == 5 or $row['generatedType'] == 1){
			echo"
			<table border='0' style = 'transform:translate(6%, 0%);'>";
		
			$producturl = "https://www.amazon.com.au/dp/" . $row['productID'];
			echo"
			<tr style='text-align:center;'>
				<th><Strong>Result ID<Strong></th>
				<th style = 'font-weight: 500'>" . $row['resultID'] . "</th>
			</tr>
			<tr>
				<th><Strong>Product ID<Strong></th>
				<th style = 'font-weight: 500'><a href = '" . $producturl. "' style = 'text-decoration: underline; color: blue;'>" .$row['productID'] . "</a></th>
			</tr>
			<tr>";
			
			if ($row['similarProductOne'] != "")
			{
				//$arr = preg_split('/\s+/', $row['similarProductOne'], -1, PREG_SPLIT_NO_EMPTY);
				
				$arr = unserialize($row['similarProductOne']);
				//print_R($arr);
					
				echo"
				<th><Strong>". ($arr[0] == 'videogames'? 'Video Games': capitalizeFirstLetter($arr[32]))."<Strong></th>
				<th style = 'font-weight: 500'>";
				
			
				$z = 12;
				
				for ($x = 0; $x < 5; $x++){	
					
					echo"<div class='tooltip'><a style = 'text-decoration: underline; color: blue;' href = '" . $arr[$z] . "'>". $arr[$z + 2] ."</a><span class='tooltiptext'>" . $arr[$z + 3] . "</span></div>";
					$z = $z + 4;
				}
				echo "</th>
			</tr>
			";
			}
			if ($row['similarProductTwo'] != "")
			{
				$arr = unserialize($row['similarProductTwo']);
				//print_R($arr);
					
				echo"
				<th><Strong>". ($arr[0] == 'videogames'? 'Video Games': capitalizeFirstLetter($arr[32]))."<Strong></th>
				<th style = 'font-weight: 500'>";
				
			
				$z = 12;
				
				for ($x = 0; $x < 5; $x++){	
					
					echo"<div class='tooltip'><a style = 'text-decoration: underline; color: blue;' href = '" . $arr[$z] . "'>". $arr[$z + 2] ."</a><span class='tooltiptext'>" . $arr[$z + 3] . "</span></div>";
					$z = $z + 4;
				}
				echo "</th>
			</tr>";
			}
			if ($row['similarProductThree'] != "")
			{
			echo"
			<tr>";
				$arr = unserialize($row['similarProductThree']);
				//print_R($arr);
					
				echo"
				<th><Strong>". ($arr[0] == 'videogames'? 'Video Games': capitalizeFirstLetter($arr[32]))."<Strong></th>
				<th style = 'font-weight: 500'>";
				
			
				$z = 12;
				
				for ($x = 0; $x < 5; $x++){	
					
					echo"<div class='tooltip'><a style = 'text-decoration: underline; color: blue;' href = '" . $arr[$z] . "'>". $arr[$z + 2] ."</a><span class='tooltiptext'>" . $arr[$z + 3] . "</span></div>";
					$z = $z + 4;
				}
				echo "</th>
			</tr>";
			}
			if ($row['similarProductFour'] != "")
			{
				echo"
			<tr>";
				$arr = unserialize($row['similarProductFour']);
				//print_R($arr);
					
				echo"
				<th><Strong>". ($arr[0] == 'videogames'? 'Video Games': capitalizeFirstLetter($arr[32]))."<Strong></th>
				<th style = 'font-weight: 500'>";
				
			
				$z = 12;
				
				for ($x = 0; $x < 5; $x++){	
					
					echo"<div class='tooltip'><a style = 'text-decoration: underline; color: blue;' href = '" . $arr[$z] . "'>". $arr[$z + 2] ."</a><span class='tooltiptext'>" . $arr[$z + 3] . "</span></div>";
					$z = $z + 4;
				}
				echo "</th>
			</tr>";
			}
			if ($row['similarProductFive'] != "")
			{
				echo"
				<tr>";
					$arr = unserialize($row['similarProductFive']);
				//print_R($arr);
					
				echo"
				<th><Strong>". ($arr[0] == 'videogames'? 'Video Games': capitalizeFirstLetter($arr[32]))."<Strong></th>
				<th style = 'font-weight: 500'>";
				
			
				$z = 12;
				
				for ($x = 0; $x < 5; $x++){	
					
					echo"<div class='tooltip'><a style = 'text-decoration: underline; color: blue;' href = '" . $arr[$z] . "'>". $arr[$z + 2] ."</a><span class='tooltiptext'>" . $arr[$z + 3] . "</span></div>";
					$z = $z + 4;
				}
					echo "</th>
				</tr>";
			}	
			echo"
			</table";
				
		
		}
	
		

	echo"</div></div>";
	
	
?>