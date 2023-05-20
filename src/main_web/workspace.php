<?php
	// We need to use sessions, so you should always start sessions using the below code.
	session_start();
	// If the user is not logged in redirect to the login page...
	if (!isset($_SESSION['loggedin'])) {
		header('Location:login.php');
		exit;
	}
	
	$id = '';
	$sort = '';
	$search = '';
	$option = '';
	if (isset($_GET['id'])){
		$id = $_GET['id'];
	}
	if (isset($_GET['sort'])){
		$sort = $_GET['sort'];
	}
	if (isset($_GET['search'])){
		$search = $_GET['search'];
	}

	if (isset($_GET['option'])){
		$option = $_GET['option'];
	}

	$userType = $_SESSION['userType'];
	$userid = $_SESSION['id'];
	
	if (isset($_POST['submit']) and $_POST['submit'] == 'Results') {
			$_SESSION['results'] = $_POST['result'];
			header('location:results.php');
		}
		
	if (isset($_POST['submit']) and isset($_POST['search-input'])){
		$searchItem = $_POST['search-input'];
	}
	else{
		$_POST['search-input'] = '';
		$searchItem = '';
	}
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="workspace_style.css?version58">
<link rel="stylesheet" href="style.css"> <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
<title>Workspace</title>
<style>
#menu {
	position: fixed;
	margin-left: 180px;
	margin-top: 3px;
	z-index: 1;
}

li a[name='workspace'] {
	border-bottom: 2px solid lightgreen !important;
}
form[name = 'adddataform'] {
			background-color: #fff;
			padding: 20px;
			border-radius: 5px;
			box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.2);
			max-width: 500px;
			margin: 0 auto;
			text-align: center;
		}

		::file-selector-button {
		  display: none;
		  
		}
		input[type=file] {
			
		}
		
		label {
			display: inline-block;
			text-decoration: underline;
			color: blue;
		}
		
		label:hover {
			cursor: pointer;
		}
		.filename {
			font-size: 14px;
			color: #777;
		}
		.submit-btn {
			margin-top: 20px;
			background-color: #5cb85c;
			color: #fff;
			border: none;
			padding: 10px 20px;
			border-radius: 5px;
			cursor: pointer;
			font-size: 16px;
			transition: background-color 0.3s ease;
		}
		.submit-btn:hover {
			background-color: #4cae4c;
		}
		.dropzone {
			border: 2px dashed #ccc;
			padding: 20px;
			text-align: center;
			cursor: pointer;
		}
		.dropzone:hover {
			background-color: #f4f4f4;
		}
		
		.dropzone.dragover {
			background-color: silver;
			
		}
		
		.loader {
		  border: 15px solid #f3f3f3; /* Light grey */
		  border-top: 15px solid #3498db; /* Blue */
		  border-radius: 50%;
		  width: 30px;
		  height: 30px;
		  animation: spin 2s linear infinite;
		 
		}


		@keyframes spin {
		  0% { transform: rotate(0deg); }
		  100% { transform: rotate(360deg); }
		  
	
		}
		
		#searchInput {
		  background-image: url('images/searchgrey.svg'); /* Add a search icon to input */
		  background-size: 20px 20px;
			background-position: 10px 12px; 
			background-repeat: no-repeat; 
		  width: 700px; 
		  font-size: 16px; 
		  padding: 12px 20px 12px 40px; 
		  border: 1px solid #ddd; 
		  margin-bottom: 12px; 
		  margin-left: 250px;
		 
		}
		
		
		
.note {
  position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  background-color: aliceblue;
  text-align: center;
  color: black;
  padding: 10px;
  border: 1px solid lightblue;
  width: 500px;
 
  font-size: 16px;
}
</style>
<script>
/*
function changeResultButtonColor(){
		var sort =<?php echo json_encode($sort); ?>;
		
		if ($sort == "recoOwn"){
			document.getElementById('recoOwn').style.backgroundColor = "blue";
		}
}*/

function currentLeftSideBarColor (){
	var id =<?php echo json_encode($id); ?>;
	
	if (id == 'instructions'){
		document.getElementById("instructions").style.backgroundColor = "#c7dbf0";
	}
	else if (id == 'adddata'){
		document.getElementById("adddata").style.backgroundColor = "#c7dbf0";
	}
	else if (id == 'uploadeddata'){
		document.getElementById("uploadeddata").style.backgroundColor = "#c7dbf0";
	}
	else if (id == 'results'){
		document.getElementById("results").style.backgroundColor = "#c7dbf0";
	}
	else if (id == 'generate-recommend'){
		document.getElementById("generaterecommend").style.backgroundColor = "#c7dbf0";
	}
	else if (id == 'generate-recommend-recs'){
		document.getElementById("generaterecommendrecs").style.backgroundColor = "#c7dbf0";
	}
	else if (window.location.href.indexOf("generate-recommend-recs") != -1){
		document.getElementById("generaterecommendrecs").style.backgroundColor = "#c7dbf0";
	}
	else if (window.location.href.indexOf("generate-recommend") != -1){
		document.getElementById("generaterecommend").style.backgroundColor = "#c7dbf0";
	}
	else if (window.location.href.indexOf("generate-ratings-recs") != -1){
		document.getElementById("generaterecommendrecs").style.backgroundColor = "#c7dbf0";
	}
	else if (window.location.href.indexOf("generate-ratings") != -1){
		document.getElementById("generaterecommend").style.backgroundColor = "#c7dbf0";
	}
	else if (id == 'addlist'){
		document.getElementById("addlist").style.backgroundColor = "#c7dbf0";
	}
	else if (id == 'uploadedlist'){
		document.getElementById("uploadedlist").style.backgroundColor = "#c7dbf0";
	}
else if (id == 'discover' || id == ''){
		document.getElementById("discover").style.backgroundColor = "#c7dbf0";
	}
}
// Get the link element
const link = document.querySelector('a[href="#bottom"]');

// Add a click event listener to the link
link.addEventListener('click', (event) => {
	// Prevent the default link behavior
	event.preventDefault();

	// Get the anchor element
	const anchor = document.querySelector('#bottom');
	
	sleep(100).then(() => {
		// Scroll to the anchor element
		anchor.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'start' });
	});
	
	return false;
});


var dropzone = document.getElementById('dropzone');
dropzone.ondragover = function() {
	this.className = 'dropzone dragover';
	return false;
}
dropzone.ondragleave = function() {
	this.className = 'dropzone';
	return false;
}
dropzone.ondrop = function(e) {
	e.preventDefault();
	this.className = 'dropzone';
	document.getElementById('file-upload').files = e.dataTransfer.files;
	
}
/*
// change color of button based on url ($sort = $_GET['sort'])
var sort =<?php echo json_encode($sort); ?>;
var all = document.getElementById("all");
var admin = document.getElementById("admin");
var org = document.getElementById("org");
var ind = document.getElementById("ind");
function changeCurrentBtnColor () {
	if (sort == 'ratingOwn'){
		document.getElementById('ratingOwn').style.backgroundColor = "blue";
	}
	else if (sort == 'recoOwn'){
		admin.style.backgroundColor = 'blue';
	}
	else if (sort == 'ratingRecs'){
		org.style.backgroundColor = 'blue';
	}
	else if (sort == 'recoRecs'){
		ind.style.backgroundColor = 'blue';
	}
}*/

function sortTableData(n) {
  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
  table = document.getElementById("uploadeddatatable");
  switching = true;
  // Set the sorting direction to ascending:
  dir = "asc";
  /* Make a loop that will continue until
  no switching has been done: */
  while (switching) {
    // Start by saying: no switching is done:
    switching = false;
    rows = table.rows;
    /* Loop through all table rows (except the
    first, which contains table headers): */
    for (i = 1; i < (rows.length - 1); i++) {
      // Start by saying there should be no switching:
      shouldSwitch = false;
      /* Get the two elements you want to compare,
      one from current row and one from the next: */
      x = rows[i].getElementsByTagName("TD")[n];
      y = rows[i + 1].getElementsByTagName("TD")[n];
	  
      /* Check if the two rows should switch place,
      based on the direction, asc or desc: */

      if (dir == "asc") {
        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
			//reset the other headers to default symbol
			if (n == 0){
				table.getElementsByTagName("i")[1].className = 'fas fa-sort';
				table.getElementsByTagName("i")[2].className = 'fas fa-sort';
			}else if (n == 1){
				table.getElementsByTagName("i")[0].className = 'fas fa-sort';
				table.getElementsByTagName("i")[2].className = 'fas fa-sort';
			}
			else if (n == 2){
				table.getElementsByTagName("i")[0].className = 'fas fa-sort';
				table.getElementsByTagName("i")[1].className = 'fas fa-sort';
			}
		  table.getElementsByTagName("i")[n].className = 'fas fa-caret-up';
		   // If so, mark as a switch and break the loop:
          shouldSwitch = true;
          break;
        }
      } else if (dir == "desc") {
        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
			//reset the other headers to default symbol
			if (n == 0){
				table.getElementsByTagName("i")[1].className = 'fas fa-sort';
				table.getElementsByTagName("i")[2].className = 'fas fa-sort';
			}else if (n == 1){
				table.getElementsByTagName("i")[0].className = 'fas fa-sort';
				table.getElementsByTagName("i")[2].className = 'fas fa-sort';
			}
			else if (n == 2){
				table.getElementsByTagName("i")[0].className = 'fas fa-sort';
				table.getElementsByTagName("i")[1].className = 'fas fa-sort';
			}
			  table.getElementsByTagName("i")[n].className = 'fas fa-caret-down';
          // If so, mark as a switch and break the loop:
          shouldSwitch = true;
          break;
        }
      }
    }
    if (shouldSwitch) {
      /* If a switch has been marked, make the switch
      and mark that a switch has been done: */
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
      // Each time a switch is done, increase this count by 1:
      switchcount ++;
    } else {
      /* If no switching has been done AND the direction is "asc",
      set the direction to "desc" and run the while loop again. */
      if (switchcount == 0 && dir == "asc") {
        dir = "desc";
        switching = true;
      }
    }
  }
}

function searchTableData() {
  // Declare variables
  var input, filter, table, tr, td, i, txtValue, td1, td2, txtValue1, txtValue2, combinedTxt;
  input = document.getElementById("searchInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("uploadeddatatable");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0]; 
	td1 = tr[i].getElementsByTagName("td")[1]; 
	td2 = tr[i].getElementsByTagName("td")[2]; 
	if (td) {
		txtValue = td.textContent || td.innerText;
		txtValue1 = td1.textContent || td1.innerText;
		txtValue2 = td2.textContent || td2.innerText;
		combinedTxt = txtValue + txtValue1 + txtValue2;
      if (combinedTxt.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}


function sortTableList(n) {
  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
  table = document.getElementById("uploadedlisttable");
  switching = true;
  // Set the sorting direction to ascending:
  dir = "asc";
  /* Make a loop that will continue until
  no switching has been done: */
  while (switching) {
    // Start by saying: no switching is done:
    switching = false;
    rows = table.rows;
    /* Loop through all table rows (except the
    first, which contains table headers): */
    for (i = 1; i < (rows.length - 1); i++) {
      // Start by saying there should be no switching:
      shouldSwitch = false;
      /* Get the two elements you want to compare,
      one from current row and one from the next: */
      x = rows[i].getElementsByTagName("TD")[n];
      y = rows[i + 1].getElementsByTagName("TD")[n];
	  
      /* Check if the two rows should switch place,
      based on the direction, asc or desc: */

      if (dir == "asc") {
        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
			//reset the other headers to default symbol
			if (n == 0){
				table.getElementsByTagName("i")[1].className = 'fas fa-sort';
				table.getElementsByTagName("i")[2].className = 'fas fa-sort';
			}else if (n == 1){
				table.getElementsByTagName("i")[0].className = 'fas fa-sort';
				table.getElementsByTagName("i")[2].className = 'fas fa-sort';
			}
			else if (n == 2){
				table.getElementsByTagName("i")[0].className = 'fas fa-sort';
				table.getElementsByTagName("i")[1].className = 'fas fa-sort';
			}
		  table.getElementsByTagName("i")[n].className = 'fas fa-caret-up';
		   // If so, mark as a switch and break the loop:
          shouldSwitch = true;
          break;
        }
      } else if (dir == "desc") {
        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
			//reset the other headers to default symbol
			if (n == 0){
				table.getElementsByTagName("i")[1].className = 'fas fa-sort';
				table.getElementsByTagName("i")[2].className = 'fas fa-sort';
			}else if (n == 1){
				table.getElementsByTagName("i")[0].className = 'fas fa-sort';
				table.getElementsByTagName("i")[2].className = 'fas fa-sort';
			}
			else if (n == 2){
				table.getElementsByTagName("i")[0].className = 'fas fa-sort';
				table.getElementsByTagName("i")[1].className = 'fas fa-sort';
			}
			  table.getElementsByTagName("i")[n].className = 'fas fa-caret-down';
          // If so, mark as a switch and break the loop:
          shouldSwitch = true;
          break;
        }
      }
    }
    if (shouldSwitch) {
      /* If a switch has been marked, make the switch
      and mark that a switch has been done: */
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
      // Each time a switch is done, increase this count by 1:
      switchcount ++;
    } else {
      /* If no switching has been done AND the direction is "asc",
      set the direction to "desc" and run the while loop again. */
      if (switchcount == 0 && dir == "asc") {
        dir = "desc";
        switching = true;
      }
    }
  }
}

function searchTableList() {
  // Declare variables
  var input, filter, table, tr, td, i, txtValue, td1, td2, txtValue1, txtValue2, combinedTxt;
  input = document.getElementById("searchInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("uploadedlisttable");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0]; 
	td1 = tr[i].getElementsByTagName("td")[1]; 
	td2 = tr[i].getElementsByTagName("td")[2]; 
	if (td) {
		txtValue = td.textContent || td.innerText;
		txtValue1 = td1.textContent || td1.innerText;
		txtValue2 = td2.textContent || td2.innerText;
		combinedTxt = txtValue + txtValue1 + txtValue2;
      if (combinedTxt.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}


function sortTableResult(n) {
  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
  table = document.getElementById("resulttable");
  switching = true;
  // Set the sorting direction to ascending:
  dir = "asc";
  /* Make a loop that will continue until
  no switching has been done: */
  while (switching) {
    // Start by saying: no switching is done:
    switching = false;
    rows = table.rows;
    /* Loop through all table rows (except the
    first, which contains table headers): */
    for (i = 1; i < (rows.length - 1); i++) {
      // Start by saying there should be no switching:
      shouldSwitch = false;
      /* Get the two elements you want to compare,
      one from current row and one from the next: */
      x = rows[i].getElementsByTagName("TD")[n];
      y = rows[i + 1].getElementsByTagName("TD")[n];
	  
      /* Check if the two rows should switch place,
      based on the direction, asc or desc: */

      if (dir == "asc") {
        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
			//reset the other headers to default symbol
			if (n == 0){
				table.getElementsByTagName("i")[1].className = 'fas fa-sort';
				table.getElementsByTagName("i")[2].className = 'fas fa-sort';
			}else if (n == 1){
				table.getElementsByTagName("i")[0].className = 'fas fa-sort';
				table.getElementsByTagName("i")[2].className = 'fas fa-sort';
			}
			else if (n == 2){
				table.getElementsByTagName("i")[0].className = 'fas fa-sort';
				table.getElementsByTagName("i")[1].className = 'fas fa-sort';
			}
		  table.getElementsByTagName("i")[n].className = 'fas fa-caret-up';
		   // If so, mark as a switch and break the loop:
          shouldSwitch = true;
          break;
        }
      } else if (dir == "desc") {
        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
			//reset the other headers to default symbol
			if (n == 0){
				table.getElementsByTagName("i")[1].className = 'fas fa-sort';
				table.getElementsByTagName("i")[2].className = 'fas fa-sort';
			}else if (n == 1){
				table.getElementsByTagName("i")[0].className = 'fas fa-sort';
				table.getElementsByTagName("i")[2].className = 'fas fa-sort';
			}
			else if (n == 2){
				table.getElementsByTagName("i")[0].className = 'fas fa-sort';
				table.getElementsByTagName("i")[1].className = 'fas fa-sort';
			}
			  table.getElementsByTagName("i")[n].className = 'fas fa-caret-down';
          // If so, mark as a switch and break the loop:
          shouldSwitch = true;
          break;
        }
      }
    }
    if (shouldSwitch) {
      /* If a switch has been marked, make the switch
      and mark that a switch has been done: */
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
      // Each time a switch is done, increase this count by 1:
      switchcount ++;
    } else {
      /* If no switching has been done AND the direction is "asc",
      set the direction to "desc" and run the while loop again. */
      if (switchcount == 0 && dir == "asc") {
        dir = "desc";
        switching = true;
      }
    }
  }
}

function searchTableResult() {
  // Declare variables
  var input, filter, table, tr, td, i, txtValue, td1, td2, txtValue1, txtValue2, combinedTxt;
  input = document.getElementById("searchInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("resulttable");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0]; 
	td1 = tr[i].getElementsByTagName("td")[1]; 
	td2 = tr[i].getElementsByTagName("td")[2]; 
	if (td) {
		txtValue = td.textContent || td.innerText;
		txtValue1 = td1.textContent || td1.innerText;
		txtValue2 = td2.textContent || td2.innerText;
		combinedTxt = txtValue + txtValue1 + txtValue2;
      if (combinedTxt.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}

// Get the select element
var select = document.getElementById("filterSelect");

// Set the selected option based on the current URL parameter
var currentSort = new URLSearchParams(window.location.search).get("sort");
if (currentSort) {
    var option = select.querySelector("option[value='" + currentSort + "']");
    if (option) {
        option.selected = true;
    }
}

// Attach an event listener to the select element
select.addEventListener("change", function() {
    // Get the selected value
    var selectedValue = select.value;

    // Redirect to the selected URL with the selected value as the sort parameter
    window.location.href = "workspace.php?id=results&sort=" + selectedValue;
});

</script>
<script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
</head>
<body onload = 'currentLeftSideBarColor ();'>


<?php 
include('navbar.php');
include ('inc_db_fyp.php');
# if organization
if ($userType == '1'){ 
	echo"
	<div id='mySidenav' class='sidenav' style='width: 250px; height: 100%; position:fixed;margin-top: 5px;' >
	<div class='topsidenav'></div>
	<p style='font-size: 20px; padding-left: 15px; padding-top: 20px; padding-bottom: 10px; background-color:whitesmoke; 'id = 'sidewords2'>Getting Started</p>
	  <a href='workspace.php?id=discover' id = 'discover'>
		<img src='images/view.svg' alt='Image 1'>
		<span style='font-size: 16px; font-weight:500;' id = 'sidewords1' >Discover</span>
	  </a>
	  <a href='workspace.php?id=instructions' id = 'instructions'>
		<img src='images/rocket.svg' alt='Image 1'>
		<span style='font-size: 16px; font-weight:500;' id = 'sidewords1' >Instructions</span>
	  </a>
	
		<p style='font-size: 20px; padding-left: 15px; padding-top: 20px; padding-bottom: 10px;'id = 'sidewords2'>Your Data</p>
	  <a href='workspace.php?id=adddata' id=adddata>
		<img src='images/adddata.svg' alt='Image 1'>
		<span style='font-size: 16px; font-weight:500;'id = 'sidewords2'>Add Data Set</span>
	  </a>
	  <a href='workspace.php?id=uploadeddata' id = 'uploadeddata'> 
		<img src='images/uploadeddata.svg' alt='Image 2'>
		<span style='font-size: 16px; font-weight:500;' id = 'sidewords3'>Uploaded Data Set</span>
	  </a>
	     <span id='bottom'></span>
	  <a href='generate-recommend.php#bottom' id = 'generaterecommend'>
		<img src='images/yourdata.svg' alt='Image 3'>
		<span style='font-size: 16px; font-weight:500;' id = 'sidewords4'>Generate Ratings / Recommendations (Your Data)</span>
	  </a>
	  <p style='font-size: 20px; padding-left: 15px; padding-top: 20px; padding-bottom: 10px;'id = 'sidewords2'>Our Data</p>";
	  echo"
	  <a href='workspace.php?id=addlist#bottom' id = 'addlist'>
		<img src='images/adddata.svg' alt='Image 1'>
		<span style='font-size: 16px; font-weight:500;'id = 'sidewords5'>Add List of URLs</span>
	  </a>
	  <a href='workspace.php?id=uploadedlist#bottom' id = 'uploadedlist'>
		<img src='images/uploadeddata.svg' alt='Image 2'>
		<span style='font-size: 16px; font-weight:500;' id = 'sidewords6'>Uploaded List of URLs</span>
	  </a>";
	  echo"
	    <a href='generate-recommend-url.php#bottom' id = 'generaterecommendurl'>
	  <img src='images/urllist.svg' alt='Image 3'>
		<span style='font-size: 16px; font-weight:500;' id = 'sidewords8'>Generate Ratings / Recommendations (Uploaded URL)</span>
	  </a>
	  <a href='generate-recommend-recs.php#bottom' id = 'generaterecommendrecs'>
	  <img src='images/recsdata3.svg' alt='Image 3'>
		<span style='font-size: 16px; font-weight:500;' id = 'sidewords7'>Generate Ratings / Recommendations (RECS' Data)</span>
	  </a>
	 
	  <p style='font-size: 20px; padding-left: 15px; padding-top: 20px; padding-bottom: 10px;'id = 'sidewords2'>History</p>
	  <a href='workspace.php?id=results#bottom' id = 'results'>
	  <img src='images/history2.svg' alt='Image 3'>
		<span style='font-size: 16px; font-weight:500;' id = 'sidewords8'>Results</span>
	  </a>
	
	  </br></br>
	  </br> </br></br>
	  </br>
	</div>";
	/*==
	echo"
	<div id='main' class='main' style='margin-left = 200px;'>
		<span id = 'menuwords'></span>
		<img id = 'menu' src='images/left.png' alt='Image 4' onclick='openNav()'>
	</div>";*/

	echo"<div style =  ''>";
	
	if ($id == 'instructions'){
		echo"<title>Workspace</title>";
		echo"<div class='workspace-frame' style = 'margin-top: 35px; '>";
		echo"<div class='workspace' id='workspace' style='margin-left:250px;' >";
		echo"<p name = 'workspace-title' style='text-align: center; font-size:30px'>Instructions</p>";
		echo"<p name = 'workspace-description' style='text-align: center; font-size:20px'>This is 
		your workspace. Here, you can get add data, check uploaded data, </br>get your recommendations and check the generated results accordingly.
		<br />For more in-depth explanation, you can visit <a href = 'documentation.php?part=howitworks' style = 'color: blue;'>documentation</a> or 
		<a style = 'color: blue;' href = 'main.php?id=howitworks'>how it works</a>.</p>";
		
		echo"<p name = 'workspace-description3' style='text-align: left; font-size:20px; transform:translate(-50%, 45%);'>
		&#8226; Add Data Set is to add in your own data.</br></br> 
		&#8226; Uploaded data set is where you manage the data.</br></br>
		&#8226; Generate Ratings / Recommendations (Your Data) is based off
		using either</br> your own data to generate recommendations and ratings</br> based on the user or product.</br></br>
		&#8226; Add List of URLs is to add in your own list of URL for us to web crawl.</br></br> 
		&#8226; Uploaded List of URLs is where you manage your list.</br></br> 
		&#8226; Generate Ratings / Recommendations (Our Data) is based off
		using either</br> your own data or REC's own web-crawled data to generate recommendations</br> and ratings based on the user or product.
		</br></br>";
		
		echo"&#8226; Results are the records of whichever that you generated.</br></br></br></br></p></div></div>";
	}
	else if ($id == 'discover' or $id == ''){
		echo"<p  style='text-align: center; font-size:34px; margin-left: 200px;margin-top: 50px;''>Discover</p>";
		echo'
		<div style = "height: 800px;">
		
		<div class="button-container" style = "display:flex; justify-content: center;margin-left: 242px; margin-top: 40px;">
		<p style = "color:black; margin-right: 670px;padding-down: 200px; font-size: 22px;">Your Data</p>
		<p> &nbsp </p>
  <div class="row">

    <a href="workspace.php?id=adddata"><button >Add Data Set</button></a>
    <a href="workspace.php?id=uploadeddata"><button>Uploaded Set</button></a>
    <a href="generate-recommend.php#bottom"><button>Generate Recommendations (Your data)</button></a>
	<a href="generate-ratings.php#bottom"><button>Generate Ratings <br/>(Your data)</button></a>
  </div>
  <br/>
   <p style = "color:black; margin-right: 670px;padding-down: 200px; font-size: 22px;">Our Data</p>
		<p> &nbsp </p>
  <div class="row">

    <a href="workspace.php?id=addlist#bottom"><button>Add List of Urls</button>
    <a href="workspace.php?id=uploadedlist#bottom"><button >Uploaded List</button>
    <a href="generate-recommend-url.php#bottom"><button>Generate Recommendations (URL Data)</button>
	<a href="generate-ratings-url.php#bottom"><button>Generate Ratings <br/>(URL Data)</button></a>
  </div>
  <div class="row" style = "transform:translate(-50%, 0%)">
    <a href="generate-recommend-recs.php#bottom"><button>Generate Recommendations (RECS Data)</button>
	<a href="generate-ratings-recs.php#bottom"><button>Generate Ratings (RECS Data)</button></a>
  </div>
</div>';

		echo"
		<div style = 'display:flex; justify-content: center; padding-bottom: 50px'>
		<div class = 'recentsearches' style='margin-left: 250px; border: 1px solid black;position: absolute; margin-top: 50px; width: 800px;'>
		
		<div class = 'recentsearchesheader'><h1 style='transform:translate(-1%, -20%);'> 
		<img src='images/search.svg' alt='Image 1' class = 'searchimg'>  Recent Searches<a href = 'workspace.php?id=results#bottom' style = 'margin-left: 300px;color: blue;'>See All Results</a></div>
		<table border='1'>
		<tr>
			<th><strong>Generated Time</strong></th>
			<th><strong>Generated Type</strong</th>
			<th><strong>User ID (If Any)</strong</th>
			<th><strong>Product ID</strong</th>
		</tr>";
		$user = new User ();
		$results = $user->getRecentSearches($userid);
		$count = 0;
		while($row = mysqli_fetch_array($results) and $count < 3){
			echo"
	<tr style='text-align:center;'>
		<th >". substr($row['generatedTime'], 0, 19) ."</th>
		<th>";
		
		if ($row['generatedType'] == 1){
			echo "Recommendations (Your Data)";
		} 
		else if ($row['generatedType'] == 2) {
			echo "Ratings Prediction (Your Data)";
		}
		else if ($row['generatedType'] == 3) {
			echo "Recommendations (RECS' Data)";
		}
		else if ($row['generatedType'] == 4) {
			echo "Ratings Prediction (RECS' Data)";
		}
		else if ($row['generatedType'] == 5) {
			echo "Recommendations (URL Data)";
		}
		else if ($row['generatedType'] == 6) {
			echo "Ratings Prediction (URL Data)";
		}
		
		echo"</th>
		<th>". $row['userID'] ."</th>
		<th>".  $row['productID'] ."</th>

		</tr></div></div>";
		$count += 1;
		}
		
	}
	else if ($id == 'adddata'){
		echo"<title>Add Data</title>";
		echo"<div class='adddata-frame'>";
		echo"<div class = 'adddataset' id ='adddataset' style='margin-left:250px'>";
		echo"<h1 style='text-align: center'>Add Data Set</h1>";
		echo"<div class = 'adddataform' style = 'margin-left: 150px;transform: translate(-57%, -5%);'>";
		echo "<div class = 'note' style='background-color: aliceblue; text-align: left;font-size: 12px;color: black; padding: 10px; border: 1px solid lightblue; 
		width: 500px;transform:translate(-50%,-210%);'>Note: <br/>
		1) <span style = 'font-weight: 500;'>Each .csv file should include the category in its filename. The categories allowed are electronics, computers, pets, toys or videogames in lowercase. </span><br/>
		2) <span style = 'font-weight: 500'>Only one category is allowed per file.</span><br/> 
		3) <span style = 'font-weight: 500'>Only Amazon.com.au domain is allowed.</span><br/>
		4) <span style = 'font-weight: 500;'>File format has to followed strictly. This means it should include userID, prodID, rating, domain, image_urls and prodname.</span><br/>
		5) <span style = 'font-weight: 500;'>An <a href = 'documentation.php?part=howitworks&sub=organization#adddata' style = 'text-decoration:underline; color:blue;'>example</a> of what it should look like.</span></div>";
		echo"<br/><br/><br/><br/><br/><br/><br/><br/>";
		//echo"<div style = 'transform:translate(-29%, 880%);'>Example: </div>";
		//echo"<img src = 'images/csvexample3.png' style = 'width:800px; transform:translate(-18%, 65%);'>";
			include('adddataform.php');
		echo"<br/><br/><br/><br/><br/></div>";
		echo'
</div>';
	}else if ($id == 'uploadeddata'){
		echo"<title>Uploaded Data</title>";
		echo"<div class='uploadeddata-frame' style = 'height: 700px;'>";
		echo"<div class='uploadeddata' id='uploadeddata' style='margin-left:250px;' >";
		
		echo"<h1 style='text-align: center; font-size:30px'>Uploaded Data Set</h1></div>";
	/*	echo"<div class = 'filterButton' style = 'transform: translate(0%, -30%);'>
		<a href = 'workspace.php?id=uploadeddata&uploadeddatasort=dat'><button id = 'all'>All</button></a>
		<a href = 'workspace.php?id=results&sort=ratingOwn'><button id = 'ratingOwn'>Ratings Prediction (Your Data)</button></a>
		<a href = 'workspace.php?id=results&sort=recoOwn'><button id = 'recoOwn'>Recommendations (Your Data)</button></a>
		<a href = 'workspace.php?id=results&sort=ratingRecs'><button id = 'ratingRecs'>Ratings Prediction (RECS' data)</button></a>
		<a href = 'workspace.php?id=results&sort=recoRecs'><button id = 'recoRecs'>Recommendations (RECS' data)</button></a>
		
		</div>";*/
		echo"
			
		<div style = 'display:flex; justify-content: center; padding-bottom: 50px'>
		<input type='text' id='searchInput' onkeyup='searchTableData()' placeholder='Search for..'>
		<div class = 'uploadedfile' style='margin-left: 250px; border: 1px solid black;position: absolute; margin-top: 60px;;'>
		
		<div class = 'uploadedfileheader'><h1 style='transform:translate(-1%, -20%);'> 
		
		<img src='images/file.svg' alt='Image 1' class = 'searchimg'>    Files</div>
		
	
		<table border='1' id = 'uploadeddatatable'>
		<tr>
		<th onclick='sortTableData(0)' style = 'cursor: pointer;'><Strong>File Name <i class='fas fa-sort'><Strong></th>
		<th onclick='sortTableData(1)' style = 'cursor: pointer;'><Strong>File Size <i class='fas fa-sort'><Strong></th>
		<th onclick='sortTableData(2)' style = 'cursor: pointer;'><Strong>Date Uploaded <i class='fas fa-sort'><Strong></th>
		<th><Strong>Option<Strong></th>
		</tr>";
			
	
			if (isset($_POST['deletebutton'])) {
	
				$delete_file = $_POST['delete'];
				$file_path = "uploads/$userid/data/$delete_file";
				
				if (file_exists($file_path))
				{
					unlink($file_path);
				}
				else 
				{
					//echo "<p>File $delete_file could not be deleted.</p>";
				}
				
				
				unset($_POST['deletebutton']);
				unset($_POST['delete']);
			}
			
		/*	
		if (isset($_GET['uploadedDataSort'])){
			$uploadedDataSort = $_GET['uploadedDataSort'];
		}else{
			$uploadedDataSort = '';
		}*/
		
	
	
	$directories = array("electronics", "toys", "computers", "videogames", "pets");
	


	
	if (file_exists ("uploads/$userid/data/")){
		
		$per_page = 4;
	
		$handle = opendir("uploads/$userid/data/");
		if ($handle) {
		  $files = array();
		  foreach ($directories as $directory) {
			$path = "uploads/" . $userid . "/data/" . $directory;
			if (is_dir($path)) {
				$dir_files = scandir($path);
				foreach ($dir_files as $file) {
					if ($file != "." && $file != "..") {
						$full_path = $path . "/" . $file;
						if (is_file($full_path)) {
							$files[] = $full_path;
						}
					}
				}
			}
		}
		
		
		  closedir($handle);

		  $total_rows = count($files);
		
		  $total_pages = ceil($total_rows / $per_page);

		  // Calculate the start and end index for the current page
		  $page = isset($_GET['page']) ? $_GET['page'] : 1;
		  $start = ($page - 1) * $per_page;
		  $end = $start + $per_page - 1;
		  if ($end >= $total_rows) {
			$end = $total_rows - 1;
		  }	
		   foreach ($directories as $directory){
			if ($handle = opendir("uploads/$userid/data/" . $directory . "/")) {

				while ((false !== ($entry = readdir($handle))) and $start <= $end){

					if ($entry != "." && $entry != "..") {
						
						$filename = $entry;
						

						$fileinfo = stat("uploads/$userid/data/$directory/" . $filename);
						
						echo"
						<tr style='text-align:center;'>
						 <td>" . basename($filename). "</td>
					<td>";
					if (($fileinfo['size']/1024) < 0.1 ) {
						echo "0.1";
					} 
					else{
						echo number_format($fileinfo['size']/1024, 1);
					}
					
					echo" KB</td>
					<td>". date("F d Y H:i:s", $fileinfo['mtime']) ."</td>
					"; 
						
					echo"
					<td><form method='post' action = ''>
							<input type='hidden' name='delete' value='" . $directory . "/" . basename($filename) . "'>
							<input type='submit' name = 'deletebutton' value = 'Delete' onclick='return confirm(\"Are you sure you want to delete this file?\");' style = 'width: 80px; height: 30px;'>
						</form>
					</td>

						</tr>";
					$start = $start + 1;
				}
			}
		
	

			closedir($handle);
	}
		   }
	
		}
	echo '<div class="pagination" style = "transform:translate(43%, 1600%)">';
	if ($total_pages >= 1){
	echo"Page " . $page . " of " .  $total_pages . " ";
	}
	else {
		echo"Page " . $page . " of " .  "1" . " ";
	}
  if ($page > 1) {
    echo '<a href="?id=uploadeddata&page=' . ($page - 1) . '">&lt; </a>';
  }

  if ($page < $total_pages) {
    echo '<a href="?id=uploadeddata&page=' . ($page + 1) . '"> &gt;</a>';
  }
  echo '</div>';
}
			
			echo"</div></div>";
		
	}else if ($id == 'results'){
echo"<div style = 'height: 700px;'>";
		

	
		#Set the number of results per page
		$results_per_page = 4;

		#Get the current page number
		if (isset($_GET['page'])) {
			$page = $_GET['page'];
		} else {
			$page = 1;
		}

		#Calculate the starting point for the results
		$starting_limit = ($page - 1) * $results_per_page;

		#get the total number of row in the query
		if ($searchItem == ''){
			if ($sort == '' or $sort == 'all'){
				$sql = "SELECT COUNT(*) as total FROM results where user_id = ?";
				$stmt = $conn->prepare($sql);
				$stmt->bind_param("s", $userid);
			}
			else if ($sort == 'ratingOwn'){
				$sql = "SELECT COUNT(*) as total FROM results WHERE user_id = ? and generatedType = ?";
				$stmt = $conn->prepare($sql);
				$type = "2";
				$stmt->bind_param("ss", $userid,$type);
			}
			else if ($sort == 'recoOwn'){
				$sql = "SELECT COUNT(*) as total FROM results WHERE user_id = ? and generatedType = 1";
				$stmt = $conn->prepare($sql);
				$stmt->bind_param("s", $userid);
			}
			else if ($sort == 'ratingRecs'){
				$sql = "SELECT COUNT(*) as total FROM results WHERE user_id = ? and generatedType = 4";
				$stmt = $conn->prepare($sql);
				$stmt->bind_param("s", $userid);
			}
			else if ($sort == 'recoRecs'){
				$sql = "SELECT COUNT(*) as total FROM results WHERE user_id = ? and generatedType = 3";
				$stmt = $conn->prepare($sql);
				$stmt->bind_param("s", $userid);
			}
			else if ($sort == 'ratingURL'){
				$sql = "SELECT COUNT(*) as total FROM results WHERE user_id = ? and generatedType = 6";
				$stmt = $conn->prepare($sql);
				$stmt->bind_param("s", $userid);
			}
			else if ($sort == 'recoURL'){
				$sql = "SELECT COUNT(*) as total FROM results WHERE user_id = ? and generatedType = 5";
				$stmt = $conn->prepare($sql);
				$stmt->bind_param("s", $userid);
			}
		}
		else{
			if ($sort =='' or $sort == 'all'){
				$sql = "SELECT COUNT(*) as total FROM results WHERE user_id = ? AND (resultID like ? OR generatedTime like ? ) LIMIT $starting_limit, $results_per_page";
				$stmt = $conn->prepare($sql);	
				$search = '%' . $searchItem . '%';
				$stmt->bind_param("sss", $userid, $search, $search);
			}
			else if ($sort == 'ratingOwn'){
				$sql = "SELECT COUNT(*) as total FROM results WHERE user_id = ? AND generatedType = 2 AND (resultID like ? OR generatedTime like ? ) LIMIT $starting_limit, $results_per_page";
				$stmt = $conn->prepare($sql);
				$search = '%' . $searchItem . '%';
				$stmt->bind_param("sss", $userid, $search, $search);
			}
			else if ($sort == 'recoOwn'){
				$sql = "SELECT COUNT(*) as total FROM results WHERE user_id = ? AND generatedType = 1 AND (resultID like ? OR generatedTime like ? ) LIMIT $starting_limit, $results_per_page";
				$stmt = $conn->prepare($sql);
				$search = '%' . $searchItem . '%';
				$stmt->bind_param("sss", $userid, $search, $search);
			}
			else if ($sort == 'ratingRecs'){
				$sql = "SELECT COUNT(*) as total FROM results WHERE user_id = ? AND generatedType = 4 AND (resultID like ? OR generatedTime like ? ) LIMIT $starting_limit, $results_per_page";
				$stmt = $conn->prepare($sql);
				$search = '%' . $searchItem . '%';
				$stmt->bind_param("sss", $userid, $search, $search);
			}
			else if ($sort == 'recoRecs'){
				$sql = "SELECT COUNT(*) as total FROM results WHERE user_id = ? AND generatedType = 3 AND (resultID like ? OR generatedTime like ? ) LIMIT $starting_limit, $results_per_page";
				$stmt = $conn->prepare($sql);
				$search = '%' . $searchItem . '%';
				$stmt->bind_param("sss", $userid, $search, $search);
			}
			else if ($sort == 'ratingURL'){
				$sql = "SELECT COUNT(*) as total FROM results WHERE user_id = ? AND generatedType = 6 AND (resultID like ? OR generatedTime like ? ) LIMIT $starting_limit, $results_per_page";
				$stmt = $conn->prepare($sql);
				$search = '%' . $searchItem . '%';
				$stmt->bind_param("sss", $userid, $search, $search);
			}
			else if ($sort == 'recoURL'){
				$sql = "SELECT COUNT(*) as total FROM results WHERE user_id = ? AND generatedType = 5 AND (resultID like ? OR generatedTime like ? ) LIMIT $starting_limit, $results_per_page";
				$stmt = $conn->prepare($sql);
				$search = '%' . $searchItem . '%';
				$stmt->bind_param("sss", $userid, $search, $search);
			}
			}
		
		/*
		else if($searchItem !== ""){
			$searchItem = "2";
			$sql = "SELECT COUNT(*) as total FROM results where user_id = ? AND generatedType = ? ";
			
			$stmt = $conn->prepare($sql);
			$stmt->bind_param("ss", $userid,$searchItem);

		}
		*/
		$stmt->execute();			
		$result = $stmt->get_result();
		$row = mysqli_fetch_array($result);
		$total_results = $row['total'];
		//$stmt->close();
		
		#Calculate the total number of pages
		$total_pages = ceil($total_results / $results_per_page);
		echo"<title>Results</title>";
		echo"<div class='results' id='results' style='margin-left:250px;' >";
		echo"<h1 style='text-align: center; font-size:30px'>Results</h1></div>";
		
		echo"<form action = 'workspace.php?id=results&sort=$sort&search=$searchItem' method ='post' name = 'searchform' >
		<input type='text' id='searchInput' class = 'resultssearchtable' onkeyup='searchTableResult()' placeholder='Search for..' style = 'width: 400px; margin-right: 400px;'>
	  <div class='search-container' style = 'transform:translate(30%, -50%);'>";
	 
		//<input type='text' id='search-input' name = 'search-input' placeholder='Search...' style='display:inline-block;' value = {$_POST["search-input"]} >
		//<button type='submit' name = 'submit' id='search-button' style='display:inline-block;'>Search</button>
	 echo" </div>
	</form>";
		
		echo'<div style = "display:flex; justify-content: center;"> ';
		
		echo'<div class="filterButton">
    <label for="filterSelect" class = "filterLabel">Sort by: </label>';
	?>
    <select id="filterSelect" onchange="location = this.value;">
    <option value="workspace.php?id=results&sort=all" <?php if ($sort == 'all' or $sort == '') {echo 'selected';}?>>All</option>
    <option value="workspace.php?id=results&sort=ratingOwn" <?php if ($sort == 'ratingOwn') {echo 'selected';}?>>Ratings Prediction (Your Data)</option>
    <option value="workspace.php?id=results&sort=recoOwn" <?php if ($sort == 'recoOwn') {echo 'selected';}?>>Recommendations (Your Data)</option>
    <option value="workspace.php?id=results&sort=ratingRecs" <?php if ($sort == 'ratingRecs') {echo 'selected';}?>>Ratings Prediction (RECS' data)</option>
    <option value="workspace.php?id=results&sort=recoRecs" <?php if ($sort == 'recoRecs') {echo 'selected';}?>>Recommendations (RECS' data)</option>
    <option value="workspace.php?id=results&sort=ratingURL" <?php if ($sort == 'ratingURL') {echo 'selected';}?>>Ratings Prediction (URL data)</option>
    <option value="workspace.php?id=results&sort=recoURL" <?php if ($sort == 'recoURL') {echo 'selected';}?>>Recommendations (URL data)</option>
	</select>
<?php
echo '</div>
';
		//declare for order of sort
		$direction = 'ASC'; //default sorting
		
		if ($searchItem == ''){
			if ($sort == '' or $sort == 'all'){
				$sql = "SELECT * FROM results where user_id = ? LIMIT $starting_limit, $results_per_page";
				$stmt = $conn->prepare($sql);
				$stmt->bind_param("s", $userid);
			}
			else if ($sort == 'ratingOwn'){
				$sql = "SELECT * FROM results WHERE user_id = ? and generatedType = 2 LIMIT $starting_limit, $results_per_page";
				$stmt = $conn->prepare($sql);
				$stmt->bind_param("s", $userid);
			}
			else if ($sort == 'recoOwn'){
				$sql = "SELECT * FROM results WHERE user_id = ? and generatedType = 1 LIMIT $starting_limit, $results_per_page";
				$stmt = $conn->prepare($sql);
				$stmt->bind_param("s", $userid);
			}
			else if ($sort == 'ratingRecs'){
				$sql = "SELECT * FROM results WHERE user_id = ? and generatedType = 4 LIMIT  $starting_limit, $results_per_page";
				$stmt = $conn->prepare($sql);
				$stmt->bind_param("s", $userid);
			}
			else if ($sort == 'recoRecs'){
				$sql = "SELECT * FROM results WHERE user_id = ? and generatedType = 3 LIMIT $starting_limit, $results_per_page";
				$stmt = $conn->prepare($sql);
				$stmt->bind_param("s", $userid);
			}
			else if ($sort == 'ratingURL'){
				$sql = "SELECT * FROM results WHERE user_id = ? and generatedType = 6 LIMIT  $starting_limit, $results_per_page";
				$stmt = $conn->prepare($sql);
				$stmt->bind_param("s", $userid);
			}
			else if ($sort == 'recoURL'){
				$sql = "SELECT * FROM results WHERE user_id = ? and generatedType = 5 LIMIT $starting_limit, $results_per_page";
				$stmt = $conn->prepare($sql);
				$stmt->bind_param("s", $userid);
			}					
		}
		else{
			if ($sort =='' or $sort == 'all'){
				$sql = "SELECT * FROM results WHERE user_id = ? AND (resultID like ? OR generatedTime like ? ) LIMIT $starting_limit, $results_per_page";
				$stmt = $conn->prepare($sql);	
				$search = '%' . $searchItem . '%';
				$stmt->bind_param("sss", $userid, $search, $search);
			}
			else if ($sort == 'ratingOwn'){
				$sql = "SELECT * FROM results WHERE user_id = ? AND generatedType = 2 AND (resultID like ? OR generatedTime like ? ) LIMIT $starting_limit, $results_per_page";
				$stmt = $conn->prepare($sql);
				$search = '%' . $searchItem . '%';
				$stmt->bind_param("sss", $userid, $search, $search);
			}
			else if ($sort == 'recoOwn'){
				$sql = "SELECT * FROM results WHERE user_id = ? AND generatedType = 1 AND (resultID like ? OR generatedTime like ? ) LIMIT $starting_limit, $results_per_page";
				$stmt = $conn->prepare($sql);
				$search = '%' . $searchItem . '%';
				$stmt->bind_param("sss", $userid, $search, $search);
			}
			else if ($sort == 'ratingRecs'){
				$sql = "SELECT * FROM results WHERE user_id = ? AND generatedType = 4 AND (resultID like ? OR generatedTime like ? ) LIMIT $starting_limit, $results_per_page";
				$stmt = $conn->prepare($sql);
				$search = '%' . $searchItem . '%';
				$stmt->bind_param("sss", $userid, $search, $search);
			}
			else if ($sort == 'recoRecs'){
				$sql = "SELECT * FROM results WHERE user_id = ? AND generatedType = 3 AND (resultID like ? OR generatedTime like ? ) LIMIT $starting_limit, $results_per_page";
				$stmt = $conn->prepare($sql);
				$search = '%' . $searchItem . '%';
				$stmt->bind_param("sss", $userid, $search, $search);
			}
			else if ($sort == 'ratingURL'){
				$sql = "SELECT * FROM results WHERE user_id = ? AND generatedType = 6 AND (resultID like ? OR generatedTime like ? ) LIMIT $starting_limit, $results_per_page";
				$stmt = $conn->prepare($sql);
				$search = '%' . $searchItem . '%';
				$stmt->bind_param("sss", $userid, $search, $search);
			}
			else if ($sort == 'recoURL'){
				$sql = "SELECT * FROM results WHERE user_id = ? AND generatedType = 5 AND (resultID like ? OR generatedTime like ? ) LIMIT $starting_limit, $results_per_page";
				$stmt = $conn->prepare($sql);
				$search = '%' . $searchItem . '%';
				$stmt->bind_param("sss", $userid, $search, $search);
			}
			
			
		}
		$stmt->execute();	
		$results = $stmt->get_result();
		//$stmt->close();	
		
		
		
		//$user = new User();
		//$results = $user -> getResults($userid);
		
		echo'
		</div>';
		echo"
		<div style = 'display:flex; justify-content: center; padding-bottom: 50px'>
		<div class = 'resultpage' style='margin-left: 250px; border: 1px solid black;position: absolute; margin-top: 10px;width: 800px;'>
		
		
		<table border='1' id = 'resulttable'>
		<tr>
		<th onclick='sortTableResult(0)'><Strong>Result ID <Strong> <i class='fas fa-sort'></th>
		<th onclick='sortTableResult(1)'><Strong>Data Generated<Strong> <i class='fas fa-sort'></th>
		<th onclick='sortTableResult(2)'><Strong>Generated Type<Strong> <i class='fas fa-sort'></th>
		<th><Strong>Option<Strong></th>
		</tr>";
		while($row = mysqli_fetch_assoc($results)){
			echo"
	<tr style='text-align:center;'>
		<td>" . $row['resultID'] . " </td>
		<td >" . substr($row['generatedTime'], 0, 19) . "</td>
		<td>"; 
		
		if ($row['generatedType'] == 1){
			echo "Recommendations (Your Data)";
		} 
		else if ($row['generatedType'] == 2) {
			echo "Ratings Prediction (Your Data)";
		}
		else if ($row['generatedType'] == 3) {
			echo "Recommendations (RECS' Data)";
		}
		else if ($row['generatedType'] == 4) {
			echo "Ratings Prediction (RECS' Data)";
		}
		else if ($row['generatedType'] == 5) {
			echo "Recommendations (URL Data)";
		}
		else if ($row['generatedType'] == 6) {
			echo "Ratings Prediction (URL Data)";
		}
		
		
		echo"</td>
		
		
		<td><form method = 'post'>
		<input type = 'text' name = 'result' value = {$row['resultID']} hidden>
		<input type = 'submit' name = 'submit' value = 'Results' style = 'padding:5px'></form></td>
	</tr></div></div>";
		}
		#Display the page links
echo "<div class='pagenumber' style = 'transform:translate(45%, 1550%);'>";
if ($total_pages >= 1){
	echo"Page " . $page . " of " .  $total_pages . " ";
}
else {
	echo"Page " . $page . " of " .  "1" . " ";
}
if ($page > 1) {
	if ($sort == ''){
		echo "<a href='?id=results&page=" . ($page - 1) . "#bottom'>&lt;</a>";
	}
	else if ($sort == 'all'){
		echo "<a href='?id=results&sort=all&search=$searchItem&page=" . ($page - 1) . "'>&lt;</a>";
	}
	else if ($sort == 'ratingOwn'){
		echo "<a href='?id=results&sort=ratingOwn&search=$searchItem&page=" . ($page - 1) . "'>&lt;</a>";
	}
	else if ($sort == 'recoOwn'){
		echo "<a href='?id=results&sort=recoOwn&search=$searchItem&page=" . ($page - 1) . "'>&lt;</a>";
	}
	else if ($sort == 'ratingRecs'){
		echo "<a href='?id=results&sort=ratingRecs&search=$searchItem&page=" . ($page - 1) . "'>&lt;</a>";
	}
	else if ($sort == 'recoRecs'){
		echo "<a href='?id=results&sort=recoRecs&search=$searchItem&page=" . ($page - 1) . "'>&lt;</a>";
	}
	else if ($sort == 'ratingURL'){
		echo "<a href='?id=results&sort=ratingURL&search=$searchItem&page=" . ($page - 1) . "'>&lt;</a>";
	}
	else if ($sort == 'recoURL'){
		echo "<a href='?id=results&sort=recoURL&search=$searchItem&page=" . ($page - 1) . "'>&lt;</a>";
	}
}
if ($page < $total_pages) {
	if ($sort == ''){
		echo "<a href='?id=results&page=" . ($page + 1) . "#bottom'>&gt;</a>";
	}
	else if ($sort == 'all'){
		echo "<a href='?id=results&sort=all&search=$searchItem&page=" . ($page + 1) . "'>&gt;</a>";
	}
	else if ($sort == 'ratingOwn'){
		echo "<a href='?id=results&sort=ratingOwn&search=$searchItem&page=" . ($page + 1) . "'>&gt;</a>";
	}
	else if ($sort == 'recoOwn'){
		echo "<a href='?id=results&sort=recoOwn&search=$searchItem&page=" . ($page + 1) . "'>&gt;</a>";
	}
	else if ($sort == 'ratingRecs'){
		echo "<a href='?id=results&sort=ratingRecs&search=$searchItem&page=" . ($page + 1) . "'>&gt;</a>";
	}
	else if ($sort == 'recoRecs'){
		echo "<a href='?id=results&sort=recoRecs&search=$searchItem&page=" . ($page + 1) . "'>&gt;</a>";
	}
	else if ($sort == 'ratingURL'){
		echo "<a href='?id=results&sort=ratingURL&search=$searchItem&page=" . ($page + 1) . "'>&gt;</a>";
	}
	else if ($sort == 'recoURL'){
		echo "<a href='?id=results&sort=recoURL&search=$searchItem&page=" . ($page + 1) . "'>&gt;</a>";
	}
	
}
echo"</div>";
		
	}else if ($id == 'addlist'){
		echo"<title>Add List</title>";
		echo"<div class='adddata-frame'>";
		echo"<div class = 'adddataset' id ='adddataset' style='margin-left:250px'>";
		echo"<h1 style='text-align: center'>Add List</h1>";
		echo"<div class = 'adddataform' style = 'margin-left: 150px;transform: translate(-65%, -5%);'>";
				echo "<div class = 'note' style='background-color: aliceblue; text-align: left;font-size: 12px;color: black; 
				padding: 10px; border: 1px solid lightblue; width: 500px;transform:translate(-50%,-250%);'>Note:<br/> 
				1) <span style = 'font-weight: 500;'>Each .txt file should be of only one category.</span><br/> 
				2) <span style = 'font-weight: 500;'>Only Amazon.com.au links are allowed.</span><br/> 
				3) <span style = 'font-weight: 500;'>The first line of each file should be the name of the category in lowercase [electronics, computers, pets, toys, videogames].</span><br/>
				4) <span style = 'font-weight: 500;'>An <a href = 'documentation.php?part=howitworks&sub=organization#addlist' style = 'text-decoration:underline; color:blue;'>example</a> of what it should look like.</span></div>";

		echo"<br/><br/><br/><br/><br/><br/><br/>";
			include('addlistform.php');
		echo"<br/><br/><br/><br/><br/></div>";
		echo'</div>';
	}else if ($id == 'uploadedlist'){


		echo"<title>Uploaded List</title>";
		echo"<div class='uploadedlist-frame' style = 'height: 700px;'>";
		echo"<div class='uploadedlist' id='uploadedlist' style='margin-left:250px; ' >";
		echo"<h1 style='text-align: center; font-size:30px'>Uploaded List</h1></div>";
		
		echo"
		<div style = 'display:flex; justify-content: center; padding-bottom: 50px'>
		<input type='text' id='searchInput' onkeyup='searchTableList()' placeholder='Search for..'>
		<div class = 'uploadedfile' style='margin-left: 250px; border: 1px solid black;position: absolute; margin-top: 60px;'>
		
		<div class = 'uploadedfileheader'><h1 style='transform:translate(-1%, -20%);'> 
		<img src='images/file.svg' alt='Image 1' class = 'searchimg'>    Files</div>
		<table border='1' id = 'uploadedlisttable'>
		<tr>
		<th onclick='sortTableList(0)'  style = 'cursor: pointer;'><Strong>File Name<Strong> <i class='fas fa-sort'></th>
		<th onclick='sortTableList(1)'  style = 'cursor: pointer;'><Strong>File Size<Strong> <i class='fas fa-sort'></th>
		<th onclick='sortTableList(2)'  style = 'cursor: pointer;'><Strong>Date Uploaded<Strong> <i class='fas fa-sort'></th>
		
		<th onclick='sortTableList(3)' style = 'cursor: pointer;'><Strong>Crawl Status<Strong> <i class='fas fa-sort'></th>
		<th><Strong>Option<Strong></th>
		</tr>";
			
	
			if (isset($_POST['deletebutton'])) {
	
			$delete_file = $_POST['delete'];
			$delete_file2 = $_POST['delete2'];
			$file_category = $_POST['filecategory'];
			$file_path = "uploads/$userid/list/$delete_file";
			$file_path2 = "uploads/$userid/crawled/$file_category/$delete_file2" . ".csv";
			
			if (file_exists($file_path2)){
				unlink($file_path2);
			}
			
			if (file_exists($file_path))
			{
				unlink($file_path);
			}
			else 
			{
				//echo "<p>File $delete_file could not be deleted.</p>";
			}
			
			
			unset($_POST['deletebutton']);
			unset($_POST['delete']);
			
			
		}
		/*
		if (isset($_POST['crawlbutton'])){
			$cmd = 'cd C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders && C:/Users/Administrator/AppData/Local/Programs/Python/Python311/Scripts/scrapy crawl amazon_scraping_txt -a txt="C:/xampp/htdocs/dashboard/FYP/uploads/'. $userid .'/list/'. $_POST['crawlfull'] . '" -o ../../../uploads/'. $userid .'/crawled/' . $_POST['crawlwithoutextend'] . '.csv';
			shell_exec($cmd);
			
			unset($_POST['crawlbutton']);
			echo $_POST['crawlfull0'];
		}*/
		$total_pages = 0;
		$page = 1;
		
		if (file_exists ("uploads/$userid/list/")){
			
			$per_page = 4;
	
			$handle = opendir("uploads/$userid/list/");
			if ($handle) {
			  $files = array();
			  while (($file = readdir($handle)) !== false) {
				if ($file != '.' && $file != '..') {
				  $files[] = $file;
				}
			  }
			  closedir($handle);

			  $total_rows = count($files);
			  $total_pages = ceil($total_rows / $per_page);

			  // Calculate the start and end index for the current page
			  $page = isset($_GET['page']) ? $_GET['page'] : 1;
			  $start = ($page - 1) * $per_page;
			  $end = $start + $per_page - 1;
			  if ($end >= $total_rows) {
				$end = $total_rows - 1;
			  }	
			}
		if ($handle = opendir("uploads/$userid/list/")) {
			$i = 0;
			while (false !== ($entry = readdir($handle))) {

				if ($entry != "." && $entry != "..") {
					
					
					$filename = $entry;
					$file_path = "uploads/$userid/list/" . $filename;
					$fileinfo = stat($file_path);
					
					echo"
					<tr style='text-align:center;'>
					 <td>" . basename($filename). "</td>
				<td>"; 
				if (($fileinfo['size']/1024) < 0.1 ) {
					echo "0.1";
				} 
				else{
					echo number_format($fileinfo['size']/1024, 1);
				}
				echo" KB</td>
				<td>". date("F d Y H:i:s", $fileinfo['mtime']) ."</td>
				<td>"; 
					$filenamewithoutextension = basename($filename, ".txt");
					echo "<form method='post' action = '' class = 'crawlform' id = 'crawlform$i'>";
					echo" <div id='result' class = 'result$i' name='result'></div>";
					echo"<div class='loader' id = 'loader$i' style = 'margin-left: 45px;' hidden></div>";
					//get the first line(category) of chosen txt file
					$getFirstLine = fopen($file_path, "r");

					if ($getFirstLine) {
						$filecategory = trim(fgets($getFirstLine));
						fclose($getFirstLine);
					}

					if (file_exists ("C:/xampp/htdocs/dashboard/FYP/uploads/$userid/crawled/$filecategory/$filenamewithoutextension" . ".csv")) {
						echo 'Crawled';
					}
					else {
						echo"
		
						
                        <input type='hidden' name='crawlfull$i' class = 'crawlfull$i' value='" . basename($filename) . "'>
						 <input type='hidden' name='crawlwithoutextend' class = 'crawlwithoutextend$i' value='" . basename($filename, ".txt") . "'>
						
                        <input type='submit' name = 'crawlbutton' class = 'crawlbutton$i' id = 'crawlbutton$i' value = 'Crawl' style = 'width: 80px; height: 30px;'>
						";
						
					}
					
					echo "</form>";
				echo"</td>
				<td><form method='post' action = ''>
                        <input type='hidden' name='delete' value='" . basename($filename) . "'>
						<input type='hidden' name='delete2' value='" . basename($filename, ".txt") . "'>
						<input type='hidden' name ='filecategory' value = '". $filecategory ."'>
                        <input type='submit' name = 'deletebutton' value = 'Delete' onclick='return confirm(\"Are you sure you want to delete this file?\");' style = 'width: 80px; height: 30px;'>
                    </form>
				</td>

					</tr>";
				$i = $i + 1;
				
			}
		}

			closedir($handle);
	}
	
		}
			echo '<div class="pagination" style = "transform:translate(43%, 1600%)">';
			if ($total_pages >= 1){
				echo"Page " . $page . " of " .  $total_pages . " ";
			}
			else {
				echo"Page " . $page . " of " .  "1" . " ";
			}
			if ($page > 1) {
			echo '<a href="?id=uploadeddata&page=' . ($page - 1) . '">&lt; </a>';
			}

			if ($page < $total_pages) {
			echo '<a href="?id=uploadeddata&page=' . ($page + 1) . '"> &gt;</a>';
			}
			echo '</div>';
			echo"</div></div>";
	}
}
#if individual
else if ($userType == '2'){
	echo"
	<div id='mySidenav' class='sidenav' style='width: 250px; height: 100%;'>
	<div class='topsidenav'></div>
	<p style='font-size: 20px; padding-left: 15px; padding-top: 20px; padding-bottom: 10px; background-color:whitesmoke; 'id = 'sidewords2'>Getting Started</p>
	  <a href='workspace.php?id=discover' id = 'discover'>
		<img src='images/view.svg' alt='Image 1'>
		<span style='font-size: 16px; font-weight:500;' id = 'sidewords1' >Discover</span>
	  </a>
	  <a href='workspace.php?id=instructions' id = 'instructions'>
		<img src='images/rocket.svg' alt='Image 1'>
		<span style='font-size: 16px; font-weight:500;' id = 'sidewords1' >Instructions</span>
	  </a>
	  <p style='font-size: 20px; padding-left: 15px; padding-top: 20px; padding-bottom: 10px;'id = 'sidewords2'>Our Data</p>";
	  
	  echo"
	  <a href='workspace.php?id=addlist' id = 'addlist'>
		<img src='images/adddata.svg' alt='Image 1'>
		<span style='font-size: 16px; font-weight:500;'id = 'sidewords5'>Add List of URLs</span>
	  </a>
	  <a href='workspace.php?id=uploadedlist' id = 'uploadedlist'>
		<img src='images/uploadeddata.svg' alt='Image 2'>
		<span style='font-size: 16px; font-weight:500;' id = 'sidewords6'>Uploaded List of URLs</span>
	  </a>";
	  echo"
	    <a href='generate-recommend-url.php#bottom' id = 'generaterecommendurl'>
	  <img src='images/urllist.svg' alt='Image 3'>
		<span style='font-size: 16px; font-weight:500;' id = 'sidewords8'>Generate Ratings / Recommendations (Uploaded URL)</span>
	  </a>
	  <a href='generate-recommend-recs.php#bottom' id = 'generaterecommendrecs'>
	  <img src='images/recsdata3.svg' alt='Image 3'>
		<span style='font-size: 16px; font-weight:500;' id = 'sidewords7'>Generate Ratings / Recommendations (RECS' Data)</span>
	  </a>
	  <p style='font-size: 20px; padding-left: 15px; padding-top: 20px; padding-bottom: 10px;'id = 'sidewords2'>History</p>
	  <a href='workspace.php?id=results#bottom' id = 'results'>
	  <img src='images/history2.svg' alt='Image 3'>
		<span style='font-size: 16px; font-weight:500;' id = 'sidewords8'>Results</span>
	  </a>
	  <span id='bottom'></span>
	  </br></br></br>
	   </br></br></br>
	</div>";
	/*==
	echo"
	<div id='main' class='main' style='margin-left = 200px;'>
		<span id = 'menuwords'></span>
		<img id = 'menu' src='images/left.png' alt='Image 4' onclick='openNav()'>
	</div>";*/


	if ($id == 'instructions'){
		echo"<title>Workspace</title>";
		echo"<div class='workspace-frame' style = 'margin-top: 35px; '>";
		echo"<div class='workspace' id='workspace' style='margin-left:250px;' >";
		echo"<p name = 'workspace-title' style='text-align: center; font-size:30px'>Instructions</p>";
		echo"<p name = 'workspace-description' style='text-align: center; font-size:20px'>This is 
		your workspace. Here, you can get add data, check uploaded data, </br>get your recommendations and check the generated results accordingly.
		<br />For more in-depth explanation, you can visit <a href = 'documentation.php?part=howitworks' style = 'color: blue;'>documentation</a> or 
		<a style = 'color: blue;' href = 'main.php?id=howitworks'>how it works</a>.</p>";
		
		echo"<p name = 'workspace-description3' style='text-align: left; font-size:20px; transform:translate(-50%, 75%);'>
		
		&#8226; Add List of URLs is to add in your own list of URL for us to web crawl.</br></br> 
		&#8226; Uploaded List of URLs is where you manage your list.</br></br> 
		&#8226; Generate Ratings / Recommendations (Our Data) is based off
		using either</br> your own data or REC's own web-crawled data to generate recommendations</br> and ratings based on the user or product.
		</br></br>";
		
		echo"&#8226; Results are the records of whichever that you generated.</br></br></br></br></p></div></div>";
	}
	else if ($id == 'discover' or $id == ''){
		echo"<p  style='text-align: center; font-size:34px; margin-left: 200px;margin-top: 50px;''>Discover</p>";
		echo'
		<div style = "height: 800px;">
		
		<div class="button-container" style = "display:flex; justify-content: center;margin-left: 242px; margin-top: 40px;">
		
 
  <br/>
   <p style = "color:black; margin-right: 600px;padding-down: 200px; font-size: 22px;">Our Data</p>
		<p> &nbsp </p>
  <div class="row">

    <a href="workspace.php?id=addlist#bottom"><button>Add List of Urls</button>
    <a href="workspace.php?id=uploadedlist#bottom"><button >Uploaded List</button>
     <a href="generate-recommend-url.php#bottom"><button>Generate Recommendations (URL Data)</button>
	<a href="generate-ratings-url.php#bottom"><button>Generate Ratings <br/>(URL Data)</button></a>
  </div>
  <div class="row" style = "transform:translate(-50%, 0%)">
    <a href="generate-recommend-recs.php#bottom"><button>Generate Recommendations (RECS Data)</button>
	<a href="generate-ratings-recs.php#bottom"><button>Generate Ratings (RECS Data)</button></a>

  </div>
</div>';

		echo"
		<div style = 'display:flex; justify-content: center; padding-bottom: 50px'>
		<div class = 'recentsearches' style='margin-left: 250px; border: 1px solid black;position: absolute; margin-top: 50px; width: 800px;'>
		
		<div class = 'recentsearchesheader'><h1 style='transform:translate(-1%, -20%);'> 
		<img src='images/search.svg' alt='Image 1' class = 'searchimg'>  Recent Searches<a href = 'workspace.php?id=results#bottom' style = 'margin-left: 300px;color: blue;'>See All Results</a></div>
		<table border='1'>
		<tr>
			<th><strong>Generated Time</strong></th>
			<th><strong>Generated Type</strong</th>
			<th><strong>User ID (If Any)</strong</th>
			<th><strong>Product ID</strong</th>
		</tr>";
		$user = new User ();
		$results = $user->getRecentSearches($userid);
		$count = 0;
		while($row = mysqli_fetch_array($results) and $count < 3){
			echo"
	<tr style='text-align:center;'>
		<th >". substr($row['generatedTime'], 0, 19) ."</th>
		<th>";
		
		if ($row['generatedType'] == 1){
			echo "Recommendations (Your Data)";
		} 
		else if ($row['generatedType'] == 2) {
			echo "Ratings Prediction (Your Data)";
		}
		else if ($row['generatedType'] == 3) {
			echo "Recommendations (RECS' Data)";
		}
		else if ($row['generatedType'] == 4) {
			echo "Ratings Prediction (RECS' Data)";
		}
		else if ($row['generatedType'] == 5) {
			echo "Recommendations (URL Data)";
		}
		else if ($row['generatedType'] == 6) {
			echo "Ratings Prediction (URL Data)";
		}
		
		echo"</th>
		<th>". $row['userID'] ."</th>
		<th>".  $row['productID'] ."</th>

		</tr></div></div>";
		$count += 1;
		}
		
	}
	else if ($id == 'results'){
		echo"<div style = 'height: 700px;'>";
		

	
		#Set the number of results per page
		$results_per_page = 4;

		#Get the current page number
		if (isset($_GET['page'])) {
			$page = $_GET['page'];
		} else {
			$page = 1;
		}

		#Calculate the starting point for the results
		$starting_limit = ($page - 1) * $results_per_page;

		#get the total number of row in the query
		if ($searchItem == ''){
			if ($sort == '' or $sort == 'all'){
				$sql = "SELECT COUNT(*) as total FROM results where user_id = ?";
				$stmt = $conn->prepare($sql);
				$stmt->bind_param("s", $userid);
			}
			else if ($sort == 'ratingRecs'){
				$sql = "SELECT COUNT(*) as total FROM results WHERE user_id = ? and generatedType = 4";
				$stmt = $conn->prepare($sql);
				$stmt->bind_param("s", $userid);
			}
			else if ($sort == 'recoRecs'){
				$sql = "SELECT COUNT(*) as total FROM results WHERE user_id = ? and generatedType = 3";
				$stmt = $conn->prepare($sql);
				$stmt->bind_param("s", $userid);
			}
			else if ($sort == 'ratingURL'){
				$sql = "SELECT COUNT(*) as total FROM results WHERE user_id = ? and generatedType = 6";
				$stmt = $conn->prepare($sql);
				$stmt->bind_param("s", $userid);
			}
			else if ($sort == 'recoURL'){
				$sql = "SELECT COUNT(*) as total FROM results WHERE user_id = ? and generatedType = 5";
				$stmt = $conn->prepare($sql);
				$stmt->bind_param("s", $userid);
			}
		}
		else{
			if ($sort =='' or $sort == 'all'){
				$sql = "SELECT COUNT(*) as total FROM results WHERE user_id = ? AND (resultID like ? OR generatedTime like ? ) LIMIT $starting_limit, $results_per_page";
				$stmt = $conn->prepare($sql);	
				$search = '%' . $searchItem . '%';
				$stmt->bind_param("sss", $userid, $search, $search);
			}
			else if ($sort == 'ratingRecs'){
				$sql = "SELECT COUNT(*) as total FROM results WHERE user_id = ? AND generatedType = 4 AND (resultID like ? OR generatedTime like ? ) LIMIT $starting_limit, $results_per_page";
				$stmt = $conn->prepare($sql);
				$search = '%' . $searchItem . '%';
				$stmt->bind_param("sss", $userid, $search, $search);
			}
			else if ($sort == 'recoRecs'){
				$sql = "SELECT COUNT(*) as total FROM results WHERE user_id = ? AND generatedType = 3 AND (resultID like ? OR generatedTime like ? ) LIMIT $starting_limit, $results_per_page";
				$stmt = $conn->prepare($sql);
				$search = '%' . $searchItem . '%';
				$stmt->bind_param("sss", $userid, $search, $search);
			}
			else if ($sort == 'ratingURL'){
				$sql = "SELECT COUNT(*) as total FROM results WHERE user_id = ? AND generatedType = 4 AND (resultID like ? OR generatedTime like ? ) LIMIT $starting_limit, $results_per_page";
				$stmt = $conn->prepare($sql);
				$search = '%' . $searchItem . '%';
				$stmt->bind_param("sss", $userid, $search, $search);
			}
			else if ($sort == 'recoURL'){
				$sql = "SELECT COUNT(*) as total FROM results WHERE user_id = ? AND generatedType = 3 AND (resultID like ? OR generatedTime like ? ) LIMIT $starting_limit, $results_per_page";
				$stmt = $conn->prepare($sql);
				$search = '%' . $searchItem . '%';
				$stmt->bind_param("sss", $userid, $search, $search);
			}
			}
		
		/*
		else if($searchItem !== ""){
			$searchItem = "2";
			$sql = "SELECT COUNT(*) as total FROM results where user_id = ? AND generatedType = ? ";
			
			$stmt = $conn->prepare($sql);
			$stmt->bind_param("ss", $userid,$searchItem);

		}
		*/
		$stmt->execute();			
		$result = $stmt->get_result();
		$row = mysqli_fetch_array($result);
		$total_results = $row['total'];
		//$stmt->close();
		
		#Calculate the total number of pages
		$total_pages = ceil($total_results / $results_per_page);
		echo"<title>Results</title>";
		echo"<div class='results' id='results' style='margin-left:250px;' >";
		echo"<h1 style='text-align: center; font-size:30px'>Results</h1></div>";
		
		echo"<form action = 'workspace.php?id=results&sort=$sort&search=$searchItem' method ='post' name = 'searchform' >
		<input type='text' id='searchInput' onkeyup='searchTableResult()' placeholder='Search for..' style = 'width: 400px; margin-right: 400px;'>
	  <div class='search-container' style = 'transform:translate(30%, -50%);'>";
	 
		//<input type='text' id='search-input' name = 'search-input' placeholder='Search...' style='display:inline-block;' value = {$_POST["search-input"]} >
		//<button type='submit' name = 'submit' id='search-button' style='display:inline-block;'>Search</button>
	 echo" </div>
	</form>";
		
		echo'<div style = "display:flex; justify-content: center;"> ';
		
		echo'<div class="filterButton">
    <label for="filterSelect" class = "filterLabel">Sort by: </label>';
	?>
    <select id="filterSelect" onchange="location = this.value;">
    <option value="workspace.php?id=results&sort=all" <?php if ($sort == 'all' or $sort == '') {echo 'selected';}?>>All</option>
    <option value="workspace.php?id=results&sort=ratingRecs" <?php if ($sort == 'ratingRecs') {echo 'selected';}?>>Ratings Prediction (RECS' data)</option>
    <option value="workspace.php?id=results&sort=recoRecs" <?php if ($sort == 'recoRecs') {echo 'selected';}?>>Recommendations (RECS' data)</option>
    <option value="workspace.php?id=results&sort=ratingURL" <?php if ($sort == 'ratingURL') {echo 'selected';}?>>Ratings Prediction (URL data)</option>
    <option value="workspace.php?id=results&sort=recoURL" <?php if ($sort == 'recoURL') {echo 'selected';}?>>Recommendations (URL data)</option>
	</select>
<?php
echo '</div>';
		//declare for order of sort
		$direction = 'ASC'; //default sorting
		
		if ($searchItem == ''){
			if ($sort == '' or $sort == 'all'){
				$sql = "SELECT * FROM results where user_id = ? LIMIT $starting_limit, $results_per_page";
				$stmt = $conn->prepare($sql);
				$stmt->bind_param("s", $userid);
			}
			else if ($sort == 'ratingRecs'){
				$sql = "SELECT * FROM results WHERE user_id = ? and generatedType = 4 LIMIT  $starting_limit, $results_per_page";
				$stmt = $conn->prepare($sql);
				$stmt->bind_param("s", $userid);
			}
			else if ($sort == 'recoRecs'){
				$sql = "SELECT * FROM results WHERE user_id = ? and generatedType = 3 LIMIT $starting_limit, $results_per_page";
				$stmt = $conn->prepare($sql);
				$stmt->bind_param("s", $userid);
			}
			else if ($sort == 'ratingURL'){
				$sql = "SELECT * FROM results WHERE user_id = ? and generatedType = 6 LIMIT  $starting_limit, $results_per_page";
				$stmt = $conn->prepare($sql);
				$stmt->bind_param("s", $userid);
			}
			else if ($sort == 'recoURL'){
				$sql = "SELECT * FROM results WHERE user_id = ? and generatedType = 5 LIMIT $starting_limit, $results_per_page";
				$stmt = $conn->prepare($sql);
				$stmt->bind_param("s", $userid);
			}	
		}
		else{
			if ($sort =='' or $sort == 'all'){
				$sql = "SELECT * FROM results WHERE user_id = ? AND (resultID like ? OR generatedTime like ? ) LIMIT $starting_limit, $results_per_page";
				$stmt = $conn->prepare($sql);	
				$search = '%' . $searchItem . '%';
				$stmt->bind_param("sss", $userid, $search, $search);
			}
			else if ($sort == 'ratingRecs'){
				$sql = "SELECT * FROM results WHERE user_id = ? AND generatedType = 4 AND (resultID like ? OR generatedTime like ? ) LIMIT $starting_limit, $results_per_page";
				$stmt = $conn->prepare($sql);
				$search = '%' . $searchItem . '%';
				$stmt->bind_param("sss", $userid, $search, $search);
			}
			else if ($sort == 'recoRecs'){
				$sql = "SELECT * FROM results WHERE user_id = ? AND generatedType = 3 AND (resultID like ? OR generatedTime like ? ) LIMIT $starting_limit, $results_per_page";
				$stmt = $conn->prepare($sql);
				$search = '%' . $searchItem . '%';
				$stmt->bind_param("sss", $userid, $search, $search);
			}
			else if ($sort == 'ratingRecs'){
				$sql = "SELECT * FROM results WHERE user_id = ? AND generatedType = 6 AND (resultID like ? OR generatedTime like ? ) LIMIT $starting_limit, $results_per_page";
				$stmt = $conn->prepare($sql);
				$search = '%' . $searchItem . '%';
				$stmt->bind_param("sss", $userid, $search, $search);
			}
			else if ($sort == 'recoRecs'){
				$sql = "SELECT * FROM results WHERE user_id = ? AND generatedType = 5 AND (resultID like ? OR generatedTime like ? ) LIMIT $starting_limit, $results_per_page";
				$stmt = $conn->prepare($sql);
				$search = '%' . $searchItem . '%';
				$stmt->bind_param("sss", $userid, $search, $search);
			}				
			
		}
		$stmt->execute();	
		$results = $stmt->get_result();
		//$stmt->close();	
		
		
		
		//$user = new User();
		//$results = $user -> getResults($userid);
		
		echo'
		</div>';
		echo"
		<div style = 'display:flex; justify-content: center; padding-bottom: 50px'>
		<div class = 'resultpage' style='margin-left: 250px; border: 1px solid black;position: absolute; margin-top: 10px;width: 800px;'>
		
		
		<table border='1' id = 'resulttable'>
		<tr>
		<th onclick='sortTableResult(0)'><Strong>Result ID <Strong> <i class='fas fa-sort'></th>
		<th onclick='sortTableResult(1)'><Strong>Data Generated<Strong> <i class='fas fa-sort'></th>
		<th onclick='sortTableResult(2)'><Strong>Generated Type<Strong> <i class='fas fa-sort'></th>
		<th><Strong>Option<Strong></th>
		</tr>";
		while($row = mysqli_fetch_assoc($results)){
			echo"
	<tr style='text-align:center;'>
		<td>" . $row['resultID'] . " </td>
		<td >" . substr($row['generatedTime'], 0, 19) . "</td>
		<td>"; 
		
		if ($row['generatedType'] == 3) {
			echo "Recommendations (RECS' Data)";
		}
		else if ($row['generatedType'] == 4) {
			echo "Ratings Prediction (RECS' Data)";
		}
		else if ($row['generatedType'] == 5) {
			echo "Recommendations (URL Data)";
		}
		else if ($row['generatedType'] == 6) {
			echo "Ratings Prediction (URL Data)";
		}
		
		
		echo"</td>
		
		
		<td><form method = 'post'>
		<input type = 'text' name = 'result' value = {$row['resultID']} hidden>
		<input type = 'submit' name = 'submit' value = 'Results' style = 'padding:5px'></form></td>
	</tr></div></div>";
		}
		#Display the page links
echo "<div class='pagenumber' style = 'transform:translate(45%, 1550%);'>";
if ($total_pages >= 1){
	echo"Page " . $page . " of " .  $total_pages . " ";
}
else {
	echo"Page " . $page . " of " .  "1" . " ";
}
if ($page > 1) {
	if ($sort == ''){
		echo "<a href='?id=results&page=" . ($page - 1) . "#bottom'>&lt;</a>";
	}
	else if ($sort == 'all'){
		echo "<a href='?id=results&sort=all&search=$searchItem&page=" . ($page - 1) . "'>&lt;</a>";
	}
	else if ($sort == 'ratingOwn'){
		echo "<a href='?id=results&sort=ratingOwn&search=$searchItem&page=" . ($page - 1) . "'>&lt;</a>";
	}
	else if ($sort == 'recoOwn'){
		echo "<a href='?id=results&sort=recoOwn&search=$searchItem&page=" . ($page - 1) . "'>&lt;</a>";
	}
	else if ($sort == 'ratingRecs'){
		echo "<a href='?id=results&sort=ratingRecs&search=$searchItem&page=" . ($page - 1) . "'>&lt;</a>";
	}
	else if ($sort == 'recoRecs'){
		echo "<a href='?id=results&sort=recoRecs&search=$searchItem&page=" . ($page - 1) . "'>&lt;</a>";
	}
	else if ($sort == 'recoURL'){
		echo "<a href='?id=results&sort=recoURL&search=$searchItem&page=" . ($page - 1) . "'>&lt;</a>";
	}
	else if ($sort == 'ratingURL'){
		echo "<a href='?id=results&sort=ratingURL&search=$searchItem&page=" . ($page - 1) . "'>&lt;</a>";
	}
}
if ($page < $total_pages) {
	if ($sort == ''){
		echo "<a href='?id=results&page=" . ($page + 1) . "#bottom'>&gt;</a>";
	}
	else if ($sort == 'all'){
		echo "<a href='?id=results&sort=all&search=$searchItem&page=" . ($page + 1) . "'>&gt;</a>";
	}
	else if ($sort == 'ratingOwn'){
		echo "<a href='?id=results&sort=ratingOwn&search=$searchItem&page=" . ($page + 1) . "'>&gt;</a>";
	}
	else if ($sort == 'recoOwn'){
		echo "<a href='?id=results&sort=recoOwn&search=$searchItem&page=" . ($page + 1) . "'>&gt;</a>";
	}
	else if ($sort == 'ratingRecs'){
		echo "<a href='?id=results&sort=ratingRecs&search=$searchItem&page=" . ($page + 1) . "'>&gt;</a>";
	}
	else if ($sort == 'recoRecs'){
		echo "<a href='?id=results&sort=recoRecs&search=$searchItem&page=" . ($page + 1) . "'>&gt;</a>";
	}
	else if ($sort == 'ratingURL'){
		echo "<a href='?id=results&sort=ratingRecs&search=$searchItem&page=" . ($page + 1) . "'>&gt;</a>";
	}
	else if ($sort == 'recoURL'){
		echo "<a href='?id=results&sort=recoRecs&search=$searchItem&page=" . ($page + 1) . "'>&gt;</a>";
	}
}
echo"</div>";
		
	}else if ($id == 'addlist'){
		echo"<title>Add List</title>";
		echo"<div class = 'addlist' id ='adddataset' style='margin-left:250px'>";
		echo"<h1 style='text-align: center'>Add List of URLs</h1>";
		echo"<div class = 'addlistform' style = 'margin-left: 155px;transform: translate(-8%, -5%);'>";
		echo "<div class = 'note' style='background-color: aliceblue; text-align: left;font-size: 12px;color: black; 
				padding: 10px; border: 1px solid lightblue; width: 500px;transform:translate(-50%,-250%);'>Note:<br/> 
				1) <span style = 'font-weight: 500;'>Each .txt file should be of only one category.</span><br/> 
				2) <span style = 'font-weight: 500;'>Only Amazon.com.au links are allowed.</span><br/> 
				3) <span style = 'font-weight: 500;'>The first line of each file should be the name of the category in lowercase [electronics, computers, pets, toys, videogames].</span><br/>
				4) <span style = 'font-weight: 500;'>An <a href = 'documentation.php?part=howitworks&sub=individual#addlistind' style = 'text-decoration:underline; color:blue;'>example</a> of what it should look like.</span></div>";

		echo"<br/><br/><br/><br/><br/><br/><br/>";
			include('addlistform.php');
		echo"<br/><br/><br/><br/><br/></div>";
	} else if ($id == 'uploadedlist'){
		echo"<title>Uploaded List</title>";
		echo"<div class='uploadedlist-frame' style = 'height: 700px;'>";
		echo"<div class='uploadedlist' id='uploadedlist' style='margin-left:250px; ' >";
		echo"<h1 style='text-align: center; font-size:30px'>Uploaded List</h1></div>";
		
		echo"
		<div style = 'display:flex; justify-content: center; padding-bottom: 50px'>
		<input type='text' id='searchInput' onkeyup='searchTableList()' placeholder='Search for..'>
		<div class = 'uploadedfile' style='margin-left: 250px; border: 1px solid black;position: absolute; margin-top: 60px;'>
		
		<div class = 'uploadedfileheader'><h1 style='transform:translate(-1%, -20%);'> 
		<img src='images/file.svg' alt='Image 1' class = 'searchimg'>    Files</div>
		<table border='1' id = 'uploadedlisttable'>
		<tr>
		<th onclick='sortTableList(0)'  style = 'cursor: pointer;'><Strong>File Name<Strong> <i class='fas fa-sort'></th>
		<th onclick='sortTableList(1)'  style = 'cursor: pointer;'><Strong>File Size<Strong> <i class='fas fa-sort'></th>
		<th onclick='sortTableList(2)'  style = 'cursor: pointer;'><Strong>Date Uploaded<Strong> <i class='fas fa-sort'></th>
		
		<th onclick='sortTableList(3)' style = 'cursor: pointer;'><Strong>Crawl Status<Strong> <i class='fas fa-sort'></th>
		<th><Strong>Option<Strong></th>
		</tr>";
			
	
			if (isset($_POST['deletebutton'])) {
	
			$delete_file = $_POST['delete'];
			$delete_file2 = $_POST['delete2'];
			$file_category = $_POST['filecategory'];
			$file_path = "uploads/$userid/list/$delete_file";
			$file_path2 = "uploads/$userid/crawled/$file_category/$delete_file2" . ".csv";
			
			if (file_exists($file_path2)){
				unlink($file_path2);
			}
			
			if (file_exists($file_path))
			{
				unlink($file_path);
			}
			else 
			{
				//echo "<p>File $delete_file could not be deleted.</p>";
			}
			
			
			unset($_POST['deletebutton']);
			unset($_POST['delete']);
			
		}
		/*
		if (isset($_POST['crawlbutton'])){
			$cmd = 'cd C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders && C:/Users/Administrator/AppData/Local/Programs/Python/Python311/Scripts/scrapy crawl amazon_scraping_txt -a txt="C:/xampp/htdocs/dashboard/FYP/uploads/'. $userid .'/list/'. $_POST['crawlfull'] . '" -o ../../../uploads/'. $userid .'/crawled/' . $_POST['crawlwithoutextend'] . '.csv';
			shell_exec($cmd);
			
			unset($_POST['crawlbutton']);
			echo $_POST['crawlfull0'];
		}*/
		$total_pages = 0;
		$page = 1;
		
		if (file_exists ("uploads/$userid/list/")){
			
			$per_page = 4;
	
			$handle = opendir("uploads/$userid/list/");
			if ($handle) {
			  $files = array();
			  while (($file = readdir($handle)) !== false) {
				if ($file != '.' && $file != '..') {
				  $files[] = $file;
				}
			  }
			  closedir($handle);

			  $total_rows = count($files);
			  $total_pages = ceil($total_rows / $per_page);

			  // Calculate the start and end index for the current page
			  $page = isset($_GET['page']) ? $_GET['page'] : 1;
			  $start = ($page - 1) * $per_page;
			  $end = $start + $per_page - 1;
			  if ($end >= $total_rows) {
				$end = $total_rows - 1;
			  }	
			}
		if ($handle = opendir("uploads/$userid/list/")) {
			$i = 0;
			while (false !== ($entry = readdir($handle))) {

				if ($entry != "." && $entry != "..") {
					
					
					$filename = $entry;
					$file_path = "uploads/$userid/list/" . $filename;
					$fileinfo = stat($file_path);
					
					echo"
					<tr style='text-align:center;'>
					 <td>" . basename($filename). "</td>
				<td>";
				if (($fileinfo['size']/1024) < 0.1 ) {
					echo "0.1";
				} 
				else{
					echo number_format($fileinfo['size']/1024, 1);
				}
				echo" KB</td>
				<td>". date("F d Y H:i:s", $fileinfo['mtime']) ."</td>
				<td>"; 
					$filenamewithoutextension = basename($filename, ".txt");
					echo "<form method='post' action = '' class = 'crawlform' id = 'crawlform$i'>";
					echo" <div id='result' class = 'result$i' name='result'></div>";
					echo"<div class='loader' id = 'loader$i' style = 'margin-left: 45px;' hidden></div>";
					//get the first line(category) of chosen txt file
					$getFirstLine = fopen($file_path, "r");

					if ($getFirstLine) {
						$filecategory = trim(fgets($getFirstLine));
						fclose($getFirstLine);
					}

					if (file_exists ("C:/xampp/htdocs/dashboard/FYP/uploads/$userid/crawled/$filecategory/$filenamewithoutextension" . ".csv")) {
						echo 'Crawled';
					}
					else {
						echo"
		
						
                        <input type='hidden' name='crawlfull$i' class = 'crawlfull$i' value='" . basename($filename) . "'>
						 <input type='hidden' name='crawlwithoutextend' class = 'crawlwithoutextend$i' value='" . basename($filename, ".txt") . "'>
						
                        <input type='submit' name = 'crawlbutton' class = 'crawlbutton$i' id = 'crawlbutton$i' value = 'Crawl' style = 'width: 80px; height: 30px;'>
						";
						
					}
					
					echo "</form>";
				echo"</td>
				<td><form method='post' action = ''>
                        <input type='hidden' name='delete' value='" . basename($filename) . "'>
						<input type='hidden' name='delete2' value='" . basename($filename, ".txt") . "'>
						<input type='hidden' name ='filecategory' value = '". $filecategory ."'>
                        <input type='submit' name = 'deletebutton' value = 'Delete' onclick='return confirm(\"Are you sure you want to delete this file?\");' style = 'width: 80px; height: 30px;'>
                    </form>
				</td>

					</tr>";
				$i = $i + 1;
				
			}
		}

			closedir($handle);
	}
	
		}
			echo '<div class="pagination" style = "transform:translate(43%, 1600%)">';
			if ($total_pages >= 1){
				echo"Page " . $page . " of " .  $total_pages . " ";
			}
			else {
				echo"Page " . $page . " of " .  "1" . " ";
			}
			if ($page > 1) {
			echo '<a href="?id=uploadeddata&page=' . ($page - 1) . '">&lt; </a>';
			}

			if ($page < $total_pages) {
			echo '<a href="?id=uploadeddata&page=' . ($page + 1) . '"> &gt;</a>';
			}
			echo '</div>';
			echo"</div></div>";
	}
}
?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>


$(document).ready(function() {
	$('.crawlform').each(function(index) {
		$(this).submit(function(event) {
			// Prevent the form from submitting normally
			event.preventDefault();
			console.log(index);
			//show loading animation and hide button
			$("#loader" + index).show();
			$(".crawlbutton" + index).hide();
			var userid = <?php echo json_encode($userid); ?>; 			
			// Get the command from the input field
			var fullfilename = $(".crawlfull" + index).val();
			var filenamewithoutextension = $(".crawlwithoutextend" + index).val();

			//var command = 'cd C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders && C:/Users/Administrator/AppData/Local/Programs/Python/Python311/Scripts/scrapy crawl amazon_scraping_txt -a txt="C:/xampp/htdocs/dashboard/FYP/uploads/' + userid + '/list/' + fullfilename + '" -o ../../../uploads/' + userid + '/crawled/' + filenamewithoutextension + '.csv';
	

			// Send an AJAX request to the PHP script
			$.ajax({
				url: "execute_command_crawl.php",
				type: "POST",
				data: {userid: userid, fullfilename: fullfilename, filenamewithoutextension: filenamewithoutextension},
				dataType: "text",
				success: function(output) {
					
					$("#loader" + index).hide();
					// Display the output in the result area
					//$(".result" + index).html(output);
					alert(output);
					location.reload();
					$(".crawlbutton" + index).show();
				},
				error: function(xhr, status, error) {
					
					$("#loader" + index).hide();
					// Display an error message
					alert("Error: " + error);
				}
			});
		});
	});
});
/*	
	$(document).ready(function() {
		$(".crawlform1").submit(function(event) {
			// Prevent the form from submitting normally
			event.preventDefault();
		
			//show loading animation and hide button
			$("#loader1").show();
			$(".crawlbutton1").hide();
			var userid = <?php echo json_encode($userid); ?>; 			
			// Get the command from the input field
			var fullfilename = $(".crawlfull1").val();
			var filenamewithoutextension = $(".crawlwithoutextend1").val();

			var command = 'cd C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders && C:/Users/Administrator/AppData/Local/Programs/Python/Python311/Scripts/scrapy crawl amazon_scraping_txt -a txt="C:/xampp/htdocs/dashboard/FYP/uploads/' + userid + '/list/' + fullfilename + '" -o ../../../uploads/' + userid + '/crawled/' + filenamewithoutextension + '.csv';


			// Send an AJAX request to the PHP script
			$.ajax({
				url: "execute_command_crawl.php",
				type: "POST",
				data: {command: command},
				dataType: "json",
				success: function(output) {
					
					$("#loader1").hide();
					// Display the output in the result area
					$(".result1").html("Crawled");
				},
				error: function(xhr, status, error) {
					
					$("#loader1").hide();
					// Display an error message
					alert("Error: " + error);
				}
			});
		});
	});
	$(document).ready(function() {
		$(".crawlform2").submit(function(event) {
			// Prevent the form from submitting normally
			event.preventDefault();
		
			//show loading animation and hide button
			$("#loader2").show();
			$(".crawlbutton2").hide();
			var userid = <?php echo json_encode($userid); ?>; 			
			// Get the command from the input field
			var fullfilename = $(".crawlfull2").val();
			var filenamewithoutextension = $(".crawlwithoutextend2").val();

			var command = 'cd C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders && C:/Users/Administrator/AppData/Local/Programs/Python/Python311/Scripts/scrapy crawl amazon_scraping_txt -a txt="C:/xampp/htdocs/dashboard/FYP/uploads/' + userid + '/list/' + fullfilename + '" -o ../../../uploads/' + userid + '/crawled/' + filenamewithoutextension + '.csv';


			// Send an AJAX request to the PHP script
			$.ajax({
				url: "execute_command_crawl.php",
				type: "POST",
				data: {command: command},
				dataType: "json",
				success: function(output) {
					
					$("#loader2").hide();
					// Display the output in the result area
					$(".result2").html("Crawled");
				},
				error: function(xhr, status, error) {
					
					$("#loader2").hide();
					// Display an error message
					alert("Error: " + error);
				}
			});
		});
	});
	$(document).ready(function() {
		$(".crawlform3").submit(function(event) {
			// Prevent the form from submitting normally
			event.preventDefault();
		
			//show loading animation and hide button
			$("#loader3").show();
			$(".crawlbutton3").hide();
			var userid = <?php echo json_encode($userid); ?>; 			
			// Get the command from the input field
			var fullfilename = $(".crawlfull3").val();
			var filenamewithoutextension = $(".crawlwithoutextend3").val();

			var command = 'cd C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders && C:/Users/Administrator/AppData/Local/Programs/Python/Python311/Scripts/scrapy crawl amazon_scraping_txt -a txt="C:/xampp/htdocs/dashboard/FYP/uploads/' + userid + '/list/' + fullfilename + '" -o ../../../uploads/' + userid + '/crawled/' + filenamewithoutextension + '.csv';


			// Send an AJAX request to the PHP script
			$.ajax({
				url: "execute_command_crawl.php",
				type: "POST",
				data: {command: command},
				dataType: "json",
				success: function(output) {
					
					$("#loader3").hide();
					// Display the output in the result area
					$(".result3").html("Crawled");
				},
				error: function(xhr, status, error) {
					
					$("#loader3").hide();
					// Display an error message
					alert("Error: " + error);
				}
			});
		});
	});
	$(document).ready(function() {
		$(".crawlform4").submit(function(event) {
			// Prevent the form from submitting normally
			event.preventDefault();
		
			//show loading animation and hide button
			$("#loader4").show();
			$(".crawlbutton4").hide();
			var userid = <?php echo json_encode($userid); ?>; 			
			// Get the command from the input field
			var fullfilename = $(".crawlfull4").val();
			var filenamewithoutextension = $(".crawlwithoutextend4").val();

			var command = 'cd C:/xampp/htdocs/dashboard/FYP/neuralcrawling/neuralcrawling/spiders && C:/Users/Administrator/AppData/Local/Programs/Python/Python311/Scripts/scrapy crawl amazon_scraping_txt -a txt="C:/xampp/htdocs/dashboard/FYP/uploads/' + userid + '/list/' + fullfilename + '" -o ../../../uploads/' + userid + '/crawled/' + filenamewithoutextension + '.csv';


			// Send an AJAX request to the PHP script
			$.ajax({
				url: "execute_command_crawl.php",
				type: "POST",
				data: {command: command},
				dataType: "json",
				success: function(output) {
					
					$("#loader4").hide();
					// Display the output in the result area
					$(".result4").html("Crawled");
				},
				error: function(xhr, status, error) {
					
					$("#loader4").hide();
					// Display an error message
					alert("Error: " + error);
				}
			});
		});
	});*/
</script>   
</body>
</html> 
