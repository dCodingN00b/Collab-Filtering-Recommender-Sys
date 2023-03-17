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
	
	$userType = $_SESSION['userType'];
	if (isset($_GET['id'])){
		$id = $_GET['id'];
	}
	
	if (isset($_GET['sort'])){
		$sort = $_GET['sort'];
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
<title>Manage Accounts</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" href="manageaccounts_style.css?version17">
<style>
	.success-box {
		background-color: whitesmoke;
		color: white;
		padding: 20px;
		left: 0;
		width: 100%;
		z-index: -9999;
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
</style>
</head>
<!-- change of button (all, admin, org, ind) based on current url-->
<body onload = 'changeCurrentBtnColor();'>
<?php
include ('inc_db_fyp.php');

if ($userType == '0') #admin
{#header, top navbar
?>
	<header>
		 <nav>
			<ul class="nav-titles">
				<li name = 'recs'><a name = 'recs' href="home.php">RECS</a></li>     
				<li><a name = 'adminmanage' href="manageaccounts.php">Manage Accounts</a></li>					
				<li><a name = 'admincreate' href="createaccount.php?id=orgcreateacc">Create Account</a></li>
			  </ul>
			<div class="dropdown">
				<button class="profile"><?=$_SESSION['name'][0]?></button>
				<div class="profile-content">
					<a class="logout" href="accountsettings.php">Account Settings</a></li>
					<a class="logout" href="logout.php">Logout</a></li>
				</div>
			  </div>        
		</nav>		
	</header>
	
	<?php
	if (isset($_SESSION['successStatus'])){
	echo"<div class='success-box'>
		<span class='close-button'>&times;</span>
			<p>{$_SESSION['successStatus']}</p>
		</div>";
	
	unset($_SESSION['successStatus']);
	}
	?>
	<h1>Manage Accounts</h1>
<?php 
#Set the number of results per page
$results_per_page = 10;

#Get the current page number
if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}

#Calculate the starting point for the results
$starting_limit = ($page - 1) * $results_per_page;

#get the total count of (search) results
if ($searchItem == ''){
	if ($sort == 'all' or $sort == ''){
		$sql = "SELECT COUNT(*) as total FROM users";
		$stmt = $conn->prepare($sql);
	}
	else if ($sort == 'admin'){
		$sql = "SELECT COUNT(*) as total FROM users WHERE userType = ?";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param("s", $user);
		$user = '0';
	}
	else if ($sort == 'org'){
		$sql = "SELECT COUNT(*) as total FROM users WHERE userType = ?";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param("s", $user);
		$user = '1';
	}
	else if ($sort == 'ind'){
		$sql = "SELECT COUNT(*) as total FROM users WHERE userType = ?";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param("s", $user);
		$user = '2';
	}
}
else if ($searchItem !== ''){
	if ($sort == 'all' or $sort == ''){
		$sql = "SELECT COUNT(*) as total FROM users WHERE (userID like ? OR CONCAT_WS(
		userType,'', userName,'', emailAddress, '', `Organization Name`, '',`Organization Website`) like ?)";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param("ss", $search, $search1);		
		$search = '%' . $searchItem . '%';
		$search1 = '%' . $searchItem . '%';
	}
	else if ($sort == 'admin'){
		$sql = "SELECT COUNT(*) as total FROM users WHERE userType = ? AND (userID like ? OR CONCAT_WS(
		'admin','', userName,'', emailAddress, '', `Organization Name`, '',`Organization Website`) like ?)";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param("sss", $user, $search, $search1);
		$user = '0';
		$search = '%' . $searchItem . '%';
		$search1 = '%' . $searchItem . '%';
	}
	else if ($sort == 'org'){
		$sql = "SELECT COUNT(*) as total FROM users WHERE userType = ? AND (userID like ? OR CONCAT_WS('',
		'org','', userName,'', emailAddress, '', `Organization Name`, '',`Organization Website`) like ?)";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param("sss", $user, $search, $search1);
		$user = '1';
		$search = '%' . $searchItem . '%';
		$search1 = '%' . $searchItem . '%';
	}
	else if ($sort == 'ind'){
		$sql = "SELECT COUNT(*) as total FROM users WHERE userType = ? AND (userID like ?  OR CONCAT_WS(
		'ind','', userName,'', emailAddress, '', `Organization Name`, '',`Organization Website`) like ?)";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param("sss", $user, $search, $search1);
		$user = '2';
		$search = '%' . $searchItem . '%';
		$search1 = '%' . $searchItem . '%';
	}
}

$stmt->execute();
$result = $stmt->get_result();
$row = mysqli_fetch_array($result);
$total_results = $row['total'];

#Calculate the total number of pages
$total_pages = ceil($total_results / $results_per_page);

#search bar
echo"
<form action = '' method ='post'>
  <div class='search-container'>
    <input type='text' id='search-input' name = 'search-input' placeholder='Search...' value = '{$_POST["search-input"]}'>
    <button type='submit' name = 'submit' id='search-button'>Search</button>
  </div>
</form>";

#table header row
echo"
<div class = 'filterButton' >
	<a href = 'manageaccounts.php?sort=all'><button id = 'all'>All</button></a>
	<a href = 'manageaccounts.php?sort=admin'><button id = 'admin'>Admin</button></a>
	<a href = 'manageaccounts.php?sort=org'><button id = 'org'>Organization</button></a>
	<a href = 'manageaccounts.php?sort=ind'><button id = 'ind'>Individual</button></a>
</div>
<table border='1'>
	<tr style='text-align:center;'>
	 <th ><strong>User ID</strong></th>
<th><strong>User Type</strong></th>
<th><strong>Name</strong></th>
<th><strong>Email</strong></th>
<th><strong>Org Name</strong></th>
<th><strong>Org Website</strong></th>
<th><strong>Options</strong></th>
	</tr>";	

#display (search) results
if ($searchItem == ''){		
	if ($sort == 'all' or $sort == ''){
		$sql = "SELECT * FROM users LIMIT $starting_limit, $results_per_page";
		$stmt = $conn->prepare($sql);
	}
	else if ($sort == 'admin'){
		$sql = "SELECT * FROM users WHERE usertype = ? LIMIT $starting_limit, $results_per_page";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param("s", $user);
		$user = '0';
		
	}
	else if ($sort == 'org'){
		$sql = "SELECT * FROM users WHERE usertype = ? LIMIT $starting_limit, $results_per_page";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param("s", $user);
		$user = '1';
	}
	else if ($sort == 'ind'){
		$sql = "SELECT * FROM users WHERE usertype = ? LIMIT $starting_limit, $results_per_page";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param("s", $user);
		$user = '2';
	}
}
else{
	if ($sort == 'all' or $sort == ''){
		$sql = "SELECT * FROM users WHERE (userID like ? OR CONCAT_WS(userID, userName,'', 
		emailAddress, '', `Organization Name`, '',`Organization Website`) = ?)
		LIMIT $starting_limit, $results_per_page";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param("ss", $search, $search1);
		$search = '%' . $searchItem . '%';
		$search1 = '%' . $searchItem . '%';
		
	}
	else if ($sort == 'admin'){
		$sql = "SELECT * FROM users WHERE userType = ? AND (userID like ? OR CONCAT_WS(
		'admin','', userName,'', emailAddress, '', `Organization Name`, '',`Organization Website`) like ?)
		LIMIT $starting_limit, $results_per_page";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param("sss", $user, $search, $search1);
		$user = '0';
		$search = '%' . $searchItem . '%';
		$search1 = '%' . $searchItem . '%';
		
	}
	else if ($sort == 'org'){
		$sql = "SELECT * FROM users  WHERE userType = ? AND (userID like ? OR CONCAT_WS(
		'org','', userName,'', emailAddress, '', `Organization Name`, '',`Organization Website`) like ?)
		LIMIT $starting_limit, $results_per_page";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param("sss", $user, $search, $search1);
		$user = '1';
		$search = '%' . $searchItem . '%';
		$search1 = '%' . $searchItem . '%';
	}
	else if ($sort == 'ind'){
		$sql = "SELECT * FROM users  WHERE userType = ? AND (userID like ? OR CONCAT_WS(userID, '',
		'ind','', userName,'', emailAddress, '', `Organization Name`, '',`Organization Website`) like ?)
		LIMIT $starting_limit, $results_per_page";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param("sss", $user, $search, $search1);
		$user = '2';
		$search = '%' . $searchItem . '%';	
		$search1 = '%' . $searchItem . '%';
	}
}

$stmt->execute();
$result = $stmt->get_result();

#diplay rest of the rows based on (search) results
while($row = mysqli_fetch_array($result)){
	echo '<tr>';
    echo '<td>' . $row['userID'] . '</td>';
	if ($row['userType'] == '1'){
		echo '<td> Org </td>';
	}else if ($row['userType'] == '2'){
		echo '<td>Ind </td>';	
	}else{
			echo '<td> Admin </td>';
	}
	echo '<td>' . $row['userName'] . '</td>';  
    echo '<td>' . $row['emailAddress'] . '</td>';
    echo '<td>' . $row['Organization Name'] . '</td>';
	echo '<td>' . $row['Organization Website'] . '</td>';
	echo '<td><button class="edit-button">
    <div class="edit-icon" style="transform: rotate(90deg);">&#9998;</div>
    <div class="edit-options">';
        echo'<a href="edituser.php?userid=' . $row["userID"] . '">Edit</a>';
        echo'<a href="manageuser.php?userid=' . $row["userID"] . '">Manage</a>';
        echo'<a href="deleteuser.php?userid=' . $row["userID"] . '">Delete</a>';
   echo'
   </div>
</button>
</td>';
    echo '</tr>';
}
echo "</table>";

#Display the page links
echo "<div class='pagenumber'>";
echo"Page " . $page . " of " .  $total_pages . " ";
if ($page > 1) {
	if ($sort == ''){
		echo "<a href='?page=" . ($page - 1) . "'>&lt;</a>";
	}
	else if ($sort == 'all'){
		echo "<a href='?sort=all&page=" . ($page - 1) . "'>&lt;</a>";
	}
	else if ($sort == 'admin'){
		echo "<a href='?sort=admin&page=" . ($page - 1) . "'>&lt;</a>";
	}
	else if ($sort == 'org'){
		echo "<a href='?sort=org&page=" . ($page - 1) . "'>&lt;</a>";
	}
	else if ($sort == 'ind'){
		echo "<a href='?sort=ind&page=" . ($page - 1) . "'>&lt;</a>";
	}
}
if ($page < $total_pages) {
	if ($sort == ''){
		echo "<a href='?page=" . ($page + 1) . "'>&gt;</a>";
	}
	else if ($sort == 'all'){
		echo "<a href='?sort=all&page=" . ($page + 1) . "'>&gt;</a>";
	}
	else if ($sort == 'admin'){
		echo "<a href='?sort=admin&page=" . ($page + 1) . "'>&gt;</a>";
	}
	else if ($sort == 'org'){
		echo "<a href='?sort=org&page=" . ($page + 1) . "'>&gt;</a>";
	}
	else if ($sort == 'ind'){
		echo "<a href='?sort=ind&page=" . ($page + 1) . "'>&gt;</a>";
	}
}
echo "</div>";
} ?>

<script>
//display the drop down list when over over pencil button
const editButtons = document.querySelectorAll('.edit-button');
	
editButtons.forEach(function(editButton) {
    const editOptions = editButton.querySelector('.edit-options');
    editButton.addEventListener('mouseover', function() {
        editOptions.style.display = 'block';
    });

    editButton.addEventListener('mouseout', function() {
        editOptions.style.display = 'none';
    });
});

// change color of button based on url ($sort = $_GET['sort'])
var sort =<?php echo json_encode($sort); ?>;
var all = document.getElementById("all");
var admin = document.getElementById("admin");
var org = document.getElementById("org");
var ind = document.getElementById("ind");
function changeCurrentBtnColor () {
	if (sort == 'all'){
		all.style.backgroundColor = "#c7c7c7";
	}
	else if (sort == 'admin'){
		admin.style.backgroundColor = '#dedede';
	}
	else if (sort == 'org'){
		org.style.backgroundColor = '#dedede';
	}
	else if (sort == 'ind'){
		ind.style.backgroundColor = '#dedede';
	}
}

// to close the success box
document.querySelector('.close-button').addEventListener('click', function() {
			document.querySelector('.success-box').style.display = 'none';
		});
</script>
</body>
<html>
