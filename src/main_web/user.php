<?php
//include ('inc_db_fyp.php');
date_default_timezone_set('Asia/Singapore');

#User entity class
class User {
	//variables
	private $userid;
	private $password;
	private $name;
	private $email;
	private $userType;
	private $orgName;
	private $orgWeb;
	private $pricePlan;
	private $accountStatus;
	private $dateTime;
	 
	//Accessor mothods
	function getUserID(){
		return $this -> userid;
	}
	
	function getName(){
		return $this -> name;
	}

	function getEmail(){
		return $this -> email;
	}
	
	function getUserType(){
		return $this -> userType;
	}
	
	function getOrgName(){
		return $this -> orgName;
	}
	
	function getorgWeb(){
		return $this -> orgWeb;
	}
	
	function getPricePlan(){
		return $this -> pricePlan;
	}
	
	function getAccountStatus(){
		return $this -> accountStatus;
	}
	
	function getDateTime(){
		return $this -> dateTime;
	}
	
	//Mutator methods	
	function setName($name){
		$this->name = $name;
	}
	
	function setEmail($email){
		$this->email = $email;
	}
	
	function setPassword($password){
		$this->password = $password;
	}
	
	function setOrgName($orgName){
		$this->orgName = $orgName;
	}
	
	function setorgWeb($orgWeb){
		$this->orgWeb = $orgWeb;
	}


	//Validate Login
	public function checkLogin($email, $password){
		include("inc_db_fyp.php");
		
		//Prepare statement
		$statement = $conn->prepare("SELECT * FROM users WHERE emailAddress = ? and password = ?");
		
		//Bind parameters
		$statement->bind_param("ss", $email, $password);
		
		//Execute
		$statement->execute();
		
		//Get result
		$result = $statement->get_result();
		
		//Close connections
		$statement->close();
		$conn->close();
		
		//Check if exist
		if($result->num_rows == 1){		
			return true;
		}else{
			return false;
		}
	}
	
	//authenticate get user information to store in session 
	public function getInfo($email){
		//Forming database connection
		include("inc_db_fyp.php");
		
		//Prepare statement
		$statement = $conn->prepare("SELECT * FROM users WHERE emailAddress = ?");
		
		//Bind parameters
		$statement->bind_param("s", $email);
		
		//Execute
		$statement->execute();
		
		//Get result
		$result = $statement->get_result();
		
		//Close connections
		$statement->close();
		$conn->close();
		
		//Fetch the result into associative array
		$info = $result->fetch_assoc();
		
		return $info;
	}
	
	//admin get user info to view user info to manage, delete, or edit
	function getUserInfo ($userid) {
		//Forming database connection
		include("inc_db_fyp.php");
		
		$sql = "SELECT * FROM users WHERE userID = ?";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param("s", $userid);
		$stmt->execute();
		$result = $stmt->get_result();
		$row = mysqli_fetch_array($result);
		$stmt->close();
		$conn->close();
		return $row;
	}
	
	//register user
	public function registerUser($email, $userType, $name, $password, $orgName, $orgWeb, $category1){
		//Forming database connection
		include("inc_db_fyp.php");
		 
		//Adding User
		//Prepare statement
		$statement = $conn->prepare("INSERT INTO users (userType, name, password, emailAddress, `Organization Name`, `Organization Website`, categoryOne) VALUES (?, ?, ?, ?, ?, ?, ?)");
		
		//Bind parameters
		$statement->bind_param("sssssss", $userType, $name, $password, $email, $orgName, $orgWeb, $category1);
	     

		if ($statement->execute()){
			$_SESSION['successStatus'] = "Account Successfully Created.";
			return true;
		}
		else{
			 return false;
		}

	
		//Close connections
		$statement->close();
		$conn->close();
		//----------------------------------------------------------------------------------
	}
	
	
	//admin delete account
	function deleteUser ($userid){
		//Forming database connection
		include("inc_db_fyp.php");
		
		$sql = 'DELETE FROM users
			WHERE userID = ?';
		$stmt = $conn->prepare($sql);
		$stmt->bind_param('s', $userid);
		try{
			if ($stmt->execute()){
				$_SESSION['successStatus'] = "User Information Successfully Deleted.";
			}
			else{
				  throw new Exception("error");
			}
		}
		catch (Exception $e) {
			$_SESSION['successStatus'] = $e->getMessage();
		}
		
		$conn->close();
	}
	
	//admin edit account
	function editUser ($email, $password, $name, $userType, $orgName, $orgWeb, $userid) {
		//Forming database connection
		include("inc_db_fyp.php");
		
		$sql = "UPDATE users 
			SET emailAddress = ?, password = ?, name = ?, userType = ?,`Organization Name` = ?, `Organization Website` = ?
			WHERE userID = ?";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param('sssssss', $email, $password, $name, $userType, $orgName, $orgWeb, $userid);
		
	
		if ($stmt->execute()){
			$_SESSION['successStatus'] = "User Information Successfully Updated.";
			return true;
		}
		else{
			return false;
		}
	
		$conn->close();
	}
	
	//admin manage account
	function manageUser ($pricePlan, $accountStatus, $userid){
		//Forming database connection
		include("inc_db_fyp.php");
		
		$sql = "UPDATE users 
			SET pricePlan = ?, accountStatus = ?
			WHERE userID = ?";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param('sss', $pricePlan, $accountStatus, $userid);
		try{
			if ($stmt->execute()){
				$_SESSION['successStatus'] = "User Information Successfully Updated.";
				header("Location: manageaccounts.php");
			}
			else{
				  throw new Exception("error");
			}
		}
		catch (Exception $e) {
			$_SESSION['successStatus'] = $e->getMessage();
		}
		
		$conn->close();
	}
	
	//admin create account
	function createAccount ($email, $password, $name, $userType, $orgName, $orgWeb)
	{
		//Forming database connection
		include("inc_db_fyp.php");
		
		$stmt = $conn->prepare("INSERT INTO `users`(`userType`, `name`, `password`, `emailAddress`, `Organization Name`, `Organization Website`)
								VALUES (?,?,?,?,?,?)");
		$stmt->bind_param("ssssss", $userType, $name, $password, $email, $orgName, $orgWeb);
		$stmt->execute();
		$stmt->close();
		$_SESSION['successStatus'] = "Account Successfully Created.";
		$conn->close();
	}
	
	//Check if email exist
	public function checkEmail($email){
		//Forming database connection
		include("inc_db_fyp.php");
		
		//Prepare statement
		$statement = $conn->prepare("SELECT * FROM users WHERE emailAddress = ?");
		
		//Bind parameters
		$statement->bind_param("s", $email);
		
		//Execute
		$statement->execute();
		
		//Get result
		$result = $statement->get_result();
		
		//Close connections
		$statement->close();
		$conn->close();
		
		if($result->num_rows > 0){
			$_SESSION['successStatus'] = "Email already used.";
			return true;
		}else{
			return false;
		}
	}
	
	#edit name (account settings)
	public function editName ($name, $userid) {
		//Forming database connection
		include("inc_db_fyp.php");
		
		//Prepare statement
		$statement = $conn->prepare("UPDATE users SET name = ? WHERE userID = ?");
		
		//Bind parameters
		$statement->bind_param("ss", $name, $userid);
		
		//Execute
		try{
			if ($statement->execute()){
				$_SESSION['successStatus'] = "User Information Successfully Updated.";
			}
			else{
				  throw new Exception("error");
			}
		}
		catch (Exception $e) {
			$_SESSION['successStatus'] = $e->getMessage();
		}
		
		//Close connections
		$statement->close();
		$conn->close();
	}
	
	#edit password (account settings)
	public function editPassword ($password, $userid) {
		//Forming database connection
		include("inc_db_fyp.php");
		
		//Prepare statement
		$statement = $conn->prepare("UPDATE users SET password = ? WHERE userID = ?");
		
		//Bind parameters
		$statement->bind_param("ss", $password, $userid);
		
		//Execute
		try{
			if ($statement->execute()){
				$_SESSION['successStatus'] = "User Information Successfully Updated.";
			}
			else{
				  throw new Exception("error");
			}
		}
		catch (Exception $e) {
			$_SESSION['successStatus'] = $e->getMessage();
		}
		
		//Close connections
		$statement->close();
		$conn->close();
	}
	
	#update password (forget password)
	public function updatePassword ($password, $emailAddress) {
		//Forming database connection
		include("inc_db_fyp.php");
		
		//Prepare statement
		$statement = $conn->prepare("UPDATE users SET password = ? WHERE emailAddress = ?");
		
		//Bind parameters
		$statement->bind_param("ss", $password, $emailAddress);
		
		//Execute
		try{
			if ($statement->execute()){
				$_SESSION['successStatus'] = "User Information Successfully Updated.";
			}
			else{
				  throw new Exception("error");
			}
		}
		catch (Exception $e) {
			$_SESSION['successStatus'] = $e->getMessage();
		}
		
		//Close connections
		$statement->close();
		$conn->close();
	}
	
	#edit org name (account settings)
	public function editOrgName ($orgname, $userid) {
		//Forming database connection
		include("inc_db_fyp.php");
		
		//Prepare statement
		$statement = $conn->prepare("UPDATE users SET `Organization Name` = ? WHERE userID = ?");
		
		//Bind parameters
		$statement->bind_param("ss", $orgname, $userid);
		
		//Execute
		try{
			if ($statement->execute()){
				$_SESSION['successStatus'] = "User Information Successfully Updated.";
			}
			else{
				  throw new Exception("error");
			}
		}
		catch (Exception $e) {
			$_SESSION['successStatus'] = $e->getMessage();
		}
		
		//Close connections
		$statement->close();
		$conn->close();
	}
	
	#edit org website (account settings)
	public function editOrgSite ($orgsite, $userid) {
		//Forming database connection
		include("inc_db_fyp.php");
		
		//Prepare statement
		$statement = $conn->prepare("UPDATE users SET `Organization Website` = ? WHERE userID = ?");
		
		//Bind parameters
		$statement->bind_param("ss", $orgsite, $userid);
		
		//Execute
		try{
			if ($statement->execute()){
				$_SESSION['successStatus'] = "User Information Successfully Updated.";
			}
			else{
				  throw new Exception("error");
			}
		}
		catch (Exception $e) {
			$_SESSION['successStatus'] = $e->getMessage();
		}
		
		//Close connections
		$statement->close();
		$conn->close();
	}
	
	#check if old password is correct (account settings)
	public function checkPassword ($password, $userid){
		//Forming database connection
		include("inc_db_fyp.php");
		
		//Prepare statement
		$statement = $conn->prepare("SELECT * FROM users WHERE password = ? AND userID = ?");
		
		//Bind parameters
		$statement->bind_param("ss", $password, $userid);
		
		//Execute
		$statement->execute();
		
		//Get result
		$result = $statement->get_result();
		
		//Close connections
		$statement->close();
		$conn->close();
		
		if($result->num_rows > 0){
			return true;
		}else{
			echo "Wrong Password";
			return false;
		}
	}
	
	
	#upgrade user plan
	public function upgradePlans ($pricePlan, $userid, $startDate, $endDate){
		//Forming database connection
		include("inc_db_fyp.php");
		
		//Prepare statement
		$statement = $conn->prepare("UPDATE users SET pricePlan = ?, startDate = ?, expiryDate = ? WHERE userID = ?");
		
		//Bind parameters
		$statement->bind_param("ssss", $pricePlan,  $startDate, $endDate, $userid);
		
		//Execute
		$statement->execute();
		
		//Close connections
		$statement->close();
		$conn->close();
	}
	
	#create transaction log 
	public function createTransaction ($userid, $pricePlan, $amountPaid){
		//Forming database connection
		include("inc_db_fyp.php");
		
		$stmt = $conn->prepare("INSERT INTO `transactions`(`userID`, `pricePlan`, `amountPaid`)
								VALUES (?,?,?)");
		$stmt->bind_param("sss", $userid, $pricePlan, $amountPaid);
		$stmt->execute();
		$stmt->close();
		$conn->close();
	}
	
	#get the latest transaction
	public function getLatestTransactionInfo ($userid) {
		//Forming database connection
		include("inc_db_fyp.php");
		
		//Prepare statement
		$statement = $conn->prepare("SELECT * FROM transactions WHERE userID = ? ORDER BY transactionID DESC LIMIT 1");
		
		//Bind parameters
		$statement->bind_param("s", $userid);
		
		//Execute
		$statement->execute();
		
		//Get result
		$result = $statement->get_result();
		
		//Close connections
		$statement->close();
		$conn->close();
		
		//Fetch the result into associative array
		$info = $result->fetch_assoc();
		
		return $info;
	}
	
	#calculate time user has been a member for
	public function calculateMemberDuration ($userid) {
		//Forming database connection
		include("inc_db_fyp.php");
		
		//Prepare statement
		$statement = $conn->prepare("SELECT * FROM transactions WHERE userID = ? ORDER BY transactionID");
		
		//Bind parameters
		//Bind parameters
		$statement->bind_param("s", $userid);
		
		//Execute
		$statement->execute();
		
		//Get result
		$result = $statement->get_result();
		
		$totalDays = 0;
		
		while($row = mysqli_fetch_array($result)) {
			if (strtotime($row['expiryDate']) <= time())
			{
				$days = strtotime($row['expiryDate']) - strtotime($row['startDate']);
				$totalDays += $days;
				
			}
			else if (strtotime($row['expiryDate']) > time()) {
				$days = time() - strtotime($row['startDate']);
				$totalDays += $days;
			}
		}
		
		$totalDays = $totalDays / 86400;
		
		return $totalDays;
	}
	
	#get all transacations from said user
	public function getAllTransactions($userid) {
		//Forming database connection
		include("inc_db_fyp.php");
		
		//Prepare statement
		$statement = $conn->prepare("SELECT * FROM transactions WHERE userID = ? ORDER BY transactionID DESC");
		
		//Bind parameters
		$statement->bind_param("s", $userid);
		
		//Execute
		$statement->execute();
		
		//Get result
		$result = $statement->get_result();
		
		return $result;
	}
	
	//edit interests
	public function editInterests($interestOne, $userid){
		//Forming database connection
		include("inc_db_fyp.php");
		
		//Prepare statement
		$statement = $conn->prepare("UPDATE users SET categoryOne = ? WHERE userID = ?");
		
		//Bind parameters
		$statement->bind_param("ss", $interestOne, $userid);
		
		
		try{
			if ($statement->execute()){
				$_SESSION['successStatus'] = "User Information Successfully Updated.";
			}
			else{
				  throw new Exception("error");
			}
		}
		catch (Exception $e) {
			$_SESSION['successStatus'] = $e->getMessage();
		}
		
		//Close connections
		$statement->close();
		$conn->close();
	}
	
	//edit age group
	public function editAgeGroup($ageRange, $userid){
		//Forming database connection
		include("inc_db_fyp.php");
		
		//Prepare statement
		$statement = $conn->prepare("UPDATE users SET ageRange = ? WHERE userID = ?");
		
		//Bind parameters
		$statement->bind_param("ss", $ageRange, $userid);
		
		
		try{
			if ($statement->execute()){
				$_SESSION['successStatus'] = "User Information Successfully Updated.";
			}
			else{
				  throw new Exception("error");
			}
		}
		catch (Exception $e) {
			$_SESSION['successStatus'] = $e->getMessage();
		}
		
		//Close connections
		$statement->close();
		$conn->close();
	}
	
	public function checkAndUpdateFreeTrial ($email){
		//Forming database connection
		include("inc_db_fyp.php");
		
		//Prepare statement
		$statement = $conn->prepare("SELECT * FROM users WHERE emailAddress = ?");
		
		//Bind parameters
		$statement->bind_param("s", $email);
		
		//Execute
		$statement->execute();
		
		//Get result
		$result = $statement->get_result();
	
		//Fetch the result into associative array
		$info = $result->fetch_assoc();

		if (strtotime($info['freeTrialExpiryDate']) < time()){
			//Prepare statement

			$statement = $conn->prepare("UPDATE users SET pricePlan = ? WHERE emailAddress = ?");
			//Bind parameters
			$priceplan = 'None';
			$statement->bind_param("ss", $priceplan, $email);
			$statement->execute();
		}
		
		
		//Close connections
		$statement->close();
		$conn->close();
	}
}
?>