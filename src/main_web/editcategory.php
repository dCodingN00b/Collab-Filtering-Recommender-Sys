<?php
	// We need to use sessions, so you should always start sessions using the below code.
	session_start();
	include ('inc_db_fyp.php');

include('navbar.php');

	// If the user is not logged in redirect to the login page...
	if (!isset($_SESSION['loggedin'])) {
		header('Location:login.php');
		exit;
	}
	
	$userType = $_SESSION['userType'];
	if (isset($_SESSION['id'])){
		$userid = $_SESSION['id'];
	}
	else{
		$userid = '';
	}
	
	$userType = $_SESSION['userType'];
	
	if (isset($_POST['submit']) and  ($_POST['submit'] == 'Confirm')){

			$user = new User();
			$user-> updateCategories ($userid, $_POST['category1'], $_POST['category2'], $_POST['category3'], $_POST['category4'], $_POST['category5']);
			
			header('location: profile.php');

	}
?>
<!DOCTYPE html>
<html>	
<head>
<title>User Profile - Edit Category</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />

 <link rel="stylesheet" href="edit_style.css?version19">
<style>
.success-box {
	background-color: whitesmoke;
	color: white;
	padding: 20px;
	left: 0;
	width: 100%;
	z-index: 9999;
	vertical-align: middle;
}

.success-box .close-button {
	color: black;
	float: right;
	font-size: 30px;
	font-weight: bold;
	cursor: pointer;
	transform:translate(0%, -20%);
}

.success-box p {
	transform:translate(0%, 20%);
}

/* scrollbar customization*/
::-webkit-scrollbar {
  width: 10px;
}

::-webkit-scrollbar-track {
  background: #f1f1f1; 
}
 
::-webkit-scrollbar-thumb {
  background: #888; 
}

::-webkit-scrollbar-thumb:hover {
  background: #555; 
}
</style>
<script>
// to close the success box
document.querySelector('.close-button').addEventListener('click', function() {
			document.querySelector('.success-box').style.display = 'none';
		});

var selectedInterests = [];
var selectedAgeGroup = '';

function selectInterest(box) {

    let selectedBoxes = document.querySelectorAll(".selected");
    if (selectedBoxes.length < 5 || box.classList.contains("selected")) {
        box.classList.toggle("selected");
      
        selectedBoxes = document.querySelectorAll(".selected");
        if (selectedBoxes.length >= 1) {
            document.getElementById("next-btn-2").classList.remove("hidden");
			  selectedInterests = [];
            selectedBoxes.forEach(box => {
                selectedInterests.push(box.innerHTML);
            });
        } else {
            document.getElementById("next-btn-2").classList.add("hidden");
        }
    }
			
	 document.editcategory.category1.value = selectedInterests[0];
	  if (selectedInterests[1] !== undefined){
		document.editcategory.category2.value = selectedInterests[1];
	  }
	  
	   if (selectedInterests[2] !== undefined){
			document.editcategory.category3.value = selectedInterests[2];
	   }
	   
	    if (selectedInterests[3] !== undefined){
			document.editcategory.category4.value = selectedInterests[3];
		}
		
		 if (selectedInterests[4] !== undefined){
			document.editcategory.category5.value = selectedInterests[4];
		 }
}


function showAgeGroup() {
    document.getElementById("interests").classList.add("hidden");
	document.getElementById("heading11").classList.add("hidden");
    setTimeout(() => {
		
		setTimeout(function() { document.getElementById("interests").style.display = "none"; }, 500);
		setTimeout(function() { document.getElementById("age-group").classList.remove("hidden"); }, 500);
        
        let ageGroupBoxes = document.querySelectorAll("#age-group .row11 .box11");
        ageGroupBoxes.forEach(box => {
            box.classList.add("visible");
        });
        document.getElementById("next-btn").classList.add("hidden");
		document.getElementById("heading11").innerHTML = 'Choose your age group';	
		setTimeout(function() { document.getElementById("heading11").classList.remove("hidden"); }, 500);
		
    }, 1000);
	
		
}

function selectAgeGroup(box) {
  let selectedBoxes = document.querySelectorAll(".selected-box11");
  if (selectedBoxes.length < 1 || box.classList.contains("selected-box11")) {
    box.classList.toggle("selected-box11");
	
    selectedBoxes = document.querySelectorAll(".selected-box11");
    if (selectedBoxes.length === 1) {
		selectedBoxes.forEach(box => {
                selectedAgeGroup = box.innerHTML;
            });
      document.getElementById("next-btn-2").classList.remove("hidden");
    } else {
      document.getElementById("next-btn-2").classList.add("hidden");
    }
  }
  
  document.indiv_register.agerange.value = selectedAgeGroup;
}

</script>
</head>

<body>
<?php




if ($userType == '1' or $userType == '2' or $userType == '0')
{#header, top navbar
	
	?>
		
		<h1>Edit Category</h1>
	<?php 
	#get user info by calling user entity method and display info
	$user = new User();
	$row = $user-> getUserInfo ($userid);



	
?>	


		<form action = '' method = 'post' name = 'editcategory' id = 'editcategory'>
		<div class = 'reg' >
		
				 <div class="container11 visible" style = 'transform:translate(0%, -20%);'>
				<div id="interests" class="visible">
			<div class="row11">
				<div class="box11" onclick="selectInterest(this)">Computers</div>
				<div class="box11" onclick="selectInterest(this)">Electronics</div>

			</div>
			<div class="row11">
				<div class="box11" onclick="selectInterest(this)">Pets</div>
				<div class="box11" onclick="selectInterest(this)">Toys</div>
				<div class="box11" onclick="selectInterest(this)">Video Games</div>

			</div>
			
				<input type="hidden" name="category1" id="category1" value="">
				<input type="hidden" name="category2" id="category2" value="">
				<input type="hidden" name="category3" id="category3" value="">
				<input type="hidden" name="category4" id="category4" value="">
				<input type="hidden" name="category5" id="category5" value="">
			
				<input type='button' value='Cancel' onclick='history.back()' style = 'transform:translate(10%, 20%);'>
				</br><input type="submit" name = "submit" id = "next-btn-2" class="hidden" value="Confirm" style = 'width: 40%; transform: translate(140%,-80%);'>
			</form>
				
				
				</div>
				
		</div>
		</form>
<?php 

}
?>
</body>