<?php
	// We need to use sessions, so you should always start sessions using the below code.
	session_start();
	// If the user is not logged in redirect to the login page...
	if (!isset($_SESSION['loggedin'])) {
		header('Location:login.php');
		exit;
	}
	$id = '';
	$userType = $_SESSION['userType'];
	if (isset($_GET['id'])){
		$id = $_GET['id'];
	}
	
	
?>

<!DOCTYPE html>
<html>
<head>

<title>Create Account</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
 <link rel="stylesheet" href="createaccount_style.css?version16">
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
	transform:translate(0%, -30%);
}

/* width */
::-webkit-scrollbar {
  width: 15px;
}

/* Track */
::-webkit-scrollbar-track {
  background: #f1f1f1; 
}
 
/* Handle */
::-webkit-scrollbar-thumb {
  background: #888; 
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
  background: #555; 
}

li a [name = 'admincreate']{
	border-bottom: 2px solid lightgreen !important;
}
</style>
</head>
<body>
<?php 
include ('inc_db_fyp.php');
include ('user.php');
if ($userType == '0') #admin
{
?>
	<header>
		 <nav>
			<ul class="nav-titles">
				<li name = 'recs'><a name = 'recs' href="home.php">RECS</a></li>     
			   <li style='margin-left: auto;'><a name = 'adminmanage' href="manageaccounts.php" style = 'margin-right: 60px;'>Manage Accounts</a>
				<a name = 'admincreate' href="createaccount.php?id=orgcreateacc" style = 'margin-right: 60px; border-bottom: 2px solid lightgreen;'>Create Account</a></li>
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
	#display success
	if (isset($_SESSION['successStatus'])){
		echo"<div class='success-box'>
			<span class='close-button'>&times;</span>
				<p>{$_SESSION['successStatus']}</p>
			</div>";
		
		unset($_SESSION['successStatus']);
	}
	?>
	<h1>Create Account</h1>
<?php if ($id == 'orgcreateacc' or $id == '') 
{
	$DisplayForm = TRUE;
$userType = '';
if (isset($_POST['submit'])){
	if ($_POST['userType'] == 'Organization'){			
		$userType = 1;
		$DisplayForm = False; 
	}else if($_POST['userType'] == 'Individual'){			
		$userType = 2;
		$DisplayForm = False; 
	}
	if ($_POST['password'] != $_POST['cpassword']){
		echo "<p> Password does not match </p>";
		$DisplayForm = True; 
	}	
	else {
		#call method inside user entity class to check if email already in database, return bool
		$user = new User();
		$DisplayForm = $user -> checkEmail($_POST['email']);
	}
	
	if (!isset($_POST['categories']))
	{
		echo "<p> You must select at least 1 category</p>";
		$DisplayForm = True; 
	}
}
	if ($DisplayForm){ ?>
	 <div class = 'reg'>
		<a href="createaccount.php?id=orgcreateacc"><h3 name = 'orgregister' id = 'orgregister' style='border-bottom:2px solid lightgreen'>Organization</h3></a>
		<a href="createaccount.php?id=indcreateacc"><h3 name = 'indivregister' id = 'indivregister' style='color:grey;'
		onmouseover="style = 'color:green; border-bottom:2px solid lightgreen;'" onmouseout="style = 'color:grey;'" >Individual</h3></a>
		<a href="createaccount.php?id=admincreateacc"><h3 name = 'adminregister' id = 'adminregister' style='color:grey;'
		onmouseover="style = 'color:green; border-bottom:2px solid lightgreen;'" onmouseout="style = 'color:grey;'" >Admin</h3></a>
		<form action = "" method = "POST" id = 'myForm'>
			<div class = 'text_field'>
				<span>Email:</span><input type="email" name="email" required />
			</div>
			<div class = 'text_field'>
				<span>Password: </span><input type="password" name="password" required />
			</div>
			<div class = 'text_field'>
				<span>Confirm Password: </span><input type="password" name="cpassword" required />
			</div>
			<input type="hidden" id="userType" name="userType" value="Organization">
			<div class = 'text_field'>
				<span>Name: </span><input type="text" name="name" required />
			</div>
			<div class = 'text_field'>
				<span>Organization Name: </span><input type="text" name="orgname" required />
			</div>
			<div class = 'text_field'>
				<span>Organization Website: </span><input type="text" name="orgsite" required />
			</div><!--
			<div class="checkboxes">
				<label><input name="accept" type="checkbox" class="tickbox" value="1"required /><span>   
				I Accept the Terms and Conditions</span> </label>
			</div>-->
			<div style ='transform:translate(3%, 0%)'>
			<span>Categories: </span></div>
			<div style = 'width: 800px; transform:translate(1%, 20%);'>
			
			  <label ><input type="checkbox" name="categories[]" value="Electronics"> Electronics</label>
			  <label><input type="checkbox" name="categories[]" value="Video Games"> Video Games</label>
			  <label><input type="checkbox" name="categories[]" value="Pets">   Pets</label> <br>
			  <label><input type="checkbox" name="categories[]" value="Computers"> Computers</label>
			  
			  <label><input type="checkbox" name="categories[]" value="Toys"> Toys</label><br>
			  
			</div>
			<br>

			</br><input type="submit" name = "submit" value="Create">
		</form>
	</div>
<?php 
	}
	else{
		$password =  hash('md5',$_POST['password']);
		$email = $_POST['email'];
		$name = $_POST['name'];
		$orgName = $_POST['orgname'];
		$orgWeb = $_POST['orgsite'];
		
		$categories = $_POST['categories'];
		if (isset($categories[0])){
			$category1 = $categories[0];
		}
		else {
			$category1 = '';
		}
		
		if (isset($categories[1])){
			$category2 = $categories[1];
		}
		else {
			$category2 = '';
		}
		
		if (isset($categories[2])){
			$category3 = $categories[2];
		}
		else {
			$category3 = '';
		}
		
		if (isset($categories[3])){
			$category4 = $categories[3];
		}
		else {
			$category4 = '';
		}
		
		if (isset($categories[4])){
			$category5 = $categories[4];
		}
		else {
			$category5 = '';
		}

		#call user entity method too createaccount
		$user-> createAccount($email, $userType, $name, $password, $orgName, $orgWeb, $category1, $category2, $category3, $category4, $category5);
		
		
		$DisplayForm = False;
		$_POST['userType'] == '';
		unset($_POST['submit']);
		header("location: createaccount.php?id=orgcreateacc");
	}
}else if ($id == 'indcreateacc') {	
$DisplayForm = TRUE;
$userType = '';
if (isset($_POST['submit'])){
	if ($_POST['userType'] == 'Organization'){			
		$userType = 1;
		$DisplayForm = False; 
	}else if($_POST['userType'] == 'Individual'){			
		$userType = 2;
		$DisplayForm = False; 
	}
	if ($_POST['password'] != $_POST['cpassword']){
		echo "<p> Password does not match </p>";
		$DisplayForm = True; 
	}else {
		#call method inside user entity class to check if email already in database, return bool
		$user = new User();
		$DisplayForm = $user -> checkEmail($_POST['email']);
	}
	
	if (!isset($_POST['categories']))
	{
		echo "<p> You must select at least 1 category</p>";
		$DisplayForm = True; 
	}
}
	if ($DisplayForm){
?>

	<div class = 'reg'>
		<a href="createaccount.php?id=orgcreateacc"><h3 name = 'orgregister' id = 'orgregister' style='color:grey;'
		onmouseover="style = 'color:green; border-bottom:2px solid lightgreen;'" onmouseout="style = 'color:grey;'">Organization</h3></a>
		<a href="createaccount.php?id=indcreateacc"><h3 name = 'indivregister' id = 'indivregister' style='border-bottom:2px solid lightgreen'>Individual</h3></a>
		<a href="createaccount.php?id=admincreateacc"><h3 name = 'adminregister' id = 'adminregister' style='color:grey;'
		onmouseover="style = 'color:green; border-bottom:2px solid lightgreen;'" onmouseout="style = 'color:grey;'" >Admin</h3></a>
		<form action = "" method = "POST">
			<div class = 'text_field'>
				<span>Email: </span></span><input type="email" name="email" required />
			</div>
			<div class = 'text_field'>
				<span>Password: </span><input type="password" name="password" required />
			</div>
			<div class = 'text_field'>
				<span>Confirm Password: </span><input type="password" name="cpassword" required />
			</div>
			<input type="hidden" id="userType" name="userType" value="Individual">
			<div class = 'text_field'>
				<span>Name: </span><input type="text" name="name" required />
			</div>
			<!--<div class="checkboxes">
				<label><input name="accept" type="checkbox" class="tickbox" value="1" required /><span>   
				I Accept the Terms and Conditions</span> </label>
			</div>-->
			<div style ='transform:translate(3%, 0%)'>
			<span>Categories: </span></div>
			<div style = 'width: 800px; transform:translate(1%, 20%);'>
			
			  <label ><input type="checkbox" name="categories[]" value="Electronics"> Electronics</label>
			  <label><input type="checkbox" name="categories[]" value="Video Games"> Video Games</label>
			  <label><input type="checkbox" name="categories[]" value="Pets">   Pets</label> <br>
			  <label><input type="checkbox" name="categories[]" value="Computers"> Computers</label>
			  
			  <label><input type="checkbox" name="categories[]" value="Toys"> Toys</label><br>
			  
			</div>
			<br>
			</br><input type="submit" name = "submit" value="Create">
		</form>
	</div>
<?php 
}
else{
		$password =  hash('md5',$_POST['password']);
		$email = $_POST['email'];
		$name = $_POST['name'];
		$orgName = '';
		$orgWeb = '';
		if (isset($_POST['orgname'])){
			$orgName = $_POST['orgname'];
		}
		if (isset($_POST['orgsite'])){
			$orgWeb = $_POST['orgsite'];
		}
		
		$categories = $_POST['categories'];
		if (isset($categories[0])){
			$category1 = $categories[0];
		}
		else {
			$category1 = '';
		}
		
		if (isset($categories[1])){
			$category2 = $categories[1];
		}
		else {
			$category2 = '';
		}
		
		if (isset($categories[2])){
			$category3 = $categories[2];
		}
		else {
			$category3 = '';
		}
		
		if (isset($categories[3])){
			$category4 = $categories[3];
		}
		else {
			$category4 = '';
		}
		
		if (isset($categories[4])){
			$category5 = $categories[4];
		}
		else {
			$category5 = '';
		}

		#call user entity method too createaccount
		$user-> createAccount($email, $userType, $name, $password, $orgName, $orgWeb, $category1, $category2, $category3, $category4, $category5);
		
		$DisplayForm = False;
		$_POST['userType'] == '';
		unset($_POST['submit']);
		header("location: createaccount.php?id=indcreateacc");
	}
}
else if ($id == 'admincreateacc') {	
$DisplayForm = TRUE;
$userType = '';
if (isset($_POST['submit'])){
	if ($_POST['userType'] == 'Organization'){			
		$userType = 1;
		$DisplayForm = False; 
	}else if($_POST['userType'] == 'Individual'){			
		$userType = 2;
		$DisplayForm = False; 
	}else if ($_POST['userType'] == 'Admin'){
		$userType = 0;
		$DisplayForm = False; 
	}
	if ($_POST['password'] != $_POST['cpassword']){
		echo "<p> Password does not match </p>";
		$DisplayForm = True; 
	}else {
		#call method inside user entity class to check if email already in database, return bool
		$user = new User();	
		$DisplayForm = $user -> checkEmail($_POST['email']);
	}
	
	if (!isset($_POST['categories']))
	{
		echo "<p> You must select at least 1 category</p>";
		$DisplayForm = True; 
	}
	
}
	if ($DisplayForm){
?>

	<div class = 'reg'>
		<a href="createaccount.php?id=orgcreateacc"><h3 name = 'orgregister' id = 'orgregister' style='color:grey;'
		onmouseover="style = 'color:green; border-bottom:2px solid lightgreen;'" onmouseout="style = 'color:grey;'">Organization</h3></a>
		<a href="createaccount.php?id=indcreateacc"><h3 name = 'indivregister' id = 'indivregister' style='color:grey;'
		onmouseover="style = 'color:green; border-bottom:2px solid lightgreen;'" onmouseout="style = 'color:grey;'">Individual</h3></a>
		<a href="createaccount.php?id=admincreateacc"><h3 name = 'adminregister' id = 'adminregister' 
		style='border-bottom:2px solid lightgreen;'>Admin</h3></a>
		<form action = "" method = "POST">
			<div class = 'text_field'>
				<span>Email: </span></span><input type="email" name="email" required />
			</div>
			<div class = 'text_field'>
				<span>Password: </span><input type="password" name="password" required />
			</div>
			<div class = 'text_field'>
				<span>Confirm Password: </span><input type="password" name="cpassword" required />
			</div>
			<input type="hidden" id="userType" name="userType" value="Admin">
			<div class = 'text_field'>
				<span>Name: </span><input type="text" name="name" required />
			</div>
			<!--
			<div class="checkboxes">
				<label><input name="accept" type="checkbox" class="tickbox" value="1" required /><span>   
				I Accept the Terms and Conditions</span> </label>
			</div>-->
			<div style ='transform:translate(3%, 0%)'>
			<span>Categories: </span></div>
			<div style = 'width: 800px; transform:translate(1%, 20%);'>
			
			  <label ><input type="checkbox" name="categories[]" value="Electronics"> Electronics</label>
			  <label><input type="checkbox" name="categories[]" value="Video Games"> Video Games</label>
			  <label><input type="checkbox" name="categories[]" value="Pets">   Pets</label> <br>
			  <label><input type="checkbox" name="categories[]" value="Computers"> Computers</label>
			  
			  <label><input type="checkbox" name="categories[]" value="Toys"> Toys</label><br>
			  
			</div>
			<br>
			</br><input type="submit" name = "submit" value="Create">
		</form>
	</div>
<?php 
}
else{
		$password =  hash('md5',$_POST['password']);
		$email = $_POST['email'];
		$name = $_POST['name'];
		$orgName = '';
		$orgWeb = '';
		if (isset($_POST['orgname'])){
			$orgName = $_POST['orgname'];
		}
		if (isset($_POST['orgsite'])){
			$orgWeb = $_POST['orgsite'];
		}
	$categories = $_POST['categories'];
		if (isset($categories[0])){
			$category1 = $categories[0];
		}
		else {
			$category1 = '';
		}
		
		if (isset($categories[1])){
			$category2 = $categories[1];
		}
		else {
			$category2 = '';
		}
		
		if (isset($categories[2])){
			$category3 = $categories[2];
		}
		else {
			$category3 = '';
		}
		
		if (isset($categories[3])){
			$category4 = $categories[3];
		}
		else {
			$category4 = '';
		}
		
		if (isset($categories[4])){
			$category5 = $categories[4];
		}
		else {
			$category5 = '';
		}

		#call user entity method too createaccount
		$user-> createAccount($email, $userType, $name, $password, $orgName, $orgWeb, $category1, $category2, $category3, $category4, $category5);
		
		$DisplayForm = False;
		$_POST['userType'] == '';
		unset($_POST['submit']);
		header("location: createaccount.php?id=admincreateacc");
	}
}
}
?>
<script>
// to close the success box
document.querySelector('.close-button').addEventListener('click', function() {
			document.querySelector('.success-box').style.display = 'none';
		});
		

</script>
</body>
</html>
