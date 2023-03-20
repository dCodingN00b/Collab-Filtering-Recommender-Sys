<?php
include ('inc_db_fyp.php');

#User entity class
class User {
	//variables
	private $userid;
	private $password;
	private $name;
	private $email;
	private $userType;
	private $orgName;
	private $orgSite;
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
	
	function getOrgSite(){
		return $this -> orgSite;
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
	
	function setOrgSite($orgSite){
		$this->orgSite = $orgSite;
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
	//Get User information 
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
	
	//Create user
	public function registerUser($email, $userType, $name, $password, $orgName, $orgSite){
		//Forming database connection
		include("inc_db_fyp.php");
		
		//Adding User
		//Prepare statement
		$statement = $conn->prepare("INSERT INTO users (userType, name, password, emailAddress, `Organization Name`, `Organization Website`) VALUES (?, ?, ?, ?, ?, ?)");
		
		//Bind parameters
		$statement->bind_param("ssssss", $userType, $name, $password, $email, $orgName, $orgSite);
		
		//Execute
		$statement->execute();
		$_SESSION['successStatus'] = "Account Successfully Created.";
		//Close connections
		$statement->close();
		$conn->close();
		//----------------------------------------------------------------------------------
	}
	
	
	//methods
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
	
	function editUser ($emailAddress, $password, $name, $userType, $orgName, $orgSite, $userid) {
		//Forming database connection
		include("inc_db_fyp.php");
		
		$sql = "UPDATE users 
			SET emailAddress = ?, password = ?, name = ?, userType = ?,`Organization Name` = ?, `Organization Website` = ?
			WHERE userID = ?";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param('sssssss', $emailAddress, $password, $name, $userType, $orgName, $orgSite, $userid);
		
		try{
		if ($stmt->execute()){
			$_SESSION['successStatus'] = "User Information Successfully Updated.";
			
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
	
	function createAccount ($emailAddress, $password, $name, $userType, $orgName, $orgSite)
	{
		//Forming database connection
		include("inc_db_fyp.php");
		
		$stmt = $conn->prepare("INSERT INTO `users`(`userType`, `name`, `password`, `emailAddress`, `Organization Name`, `Organization Website`)
								VALUES (?,?,?,?,?,?)");
		$stmt->bind_param("ssssss", $userType, $name, $password, $emailAddress, $orgName, $orgSite);
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
}
?>