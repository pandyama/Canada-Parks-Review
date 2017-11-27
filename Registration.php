<!DOCTYPE html>
<?php
session_start();
$name = "";
$surname = "";
$uname = "";
$pass = "";
$email = "";

//BELOW IS THE PHP SERVER SIDE VALIDATION FOR Firstname, Lastname, Username, Email, Password on the REGISTRATION Page
if(isset($_POST["firstname"])){// Check if the name field is not empty
	$name = trim($_POST["firstname"]);// Retrieve the name string from the field and save the trimmed value in a variable $name
	if(empty($name) or !(preg_match("/^[a-zA-Z]*$/", $name))){ //pregmatch function call to define restriction that only Letters allowed for the name
		echo "Please enter a first name or check the format"; //echo an error message
		exit;
	}
}

if(isset($_POST["lastname"])){ // Check if the name field is not empty
	$surname = trim($_POST["lastname"]); // Retrieve the name string from the field and save the trimmed value in a variable $name
	if(empty($surname) or !(preg_match("/^[a-zA-Z]*$/", $surname))){//pregmatch function call to define restriction that only Letters allowed for the name
		echo "Please enter a Last name or check the Format!!"; // echo an error message
		exit;
	}
}

if(isset($_POST["username"])){ // check if the username field is not empty
	$uname = trim($_POST["username"]);// retrieve the string from the field and save the trimmed value in a variable $uname
	if(empty($uname) or (!(preg_match("/^[a-zA-Z]*$/", $uname)) && !(preg_match("/[^0-9]/", $uname)))){ //Check if its empty
		echo "Please enter a user name!!"; // Echo an error message
		exit;
	}
}

if(isset($_POST["email"])){ // Check if the email is not empty
	$email = trim($_POST["email"]); //Retrieve the string from the field and save the trimmed value in a variable $email
	if(empty($email) or !filter_var($email, FILTER_VALIDATE_EMAIL)){ // validate email by calling a filter variable pre-defined in PHP libraries
		echo "Please enter an email address or check the format!!";//echo user if the field is empty
		exit;
	}
}

if(isset($_POST["password"])){ //check if the password is entered or not
	$pass = trim($_POST["password"]);
	if(empty($pass)){ //Check to make sure password has either letters or numbers
		echo "Please enter a password!!";
		exit;
	}

}

if(isset($_POST["submit"])) {
	try {
		//New PDO object defined to access the PHPMyadmin database with the appropriate table name, username, password.
		$conn = new PDO('mysql:host=localhost;dbname=mapleleaf','puppies_admin','*****');
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$salt1 = random_bytes(20); // Generates a ranom 20 bytes long character
		$password = $_POST['password'];//Save the password entered in the password field into a variable
		$token = hash('sha256', $salt1.$password); // Hash the password using the sha256 function and concatenating it with the random salt

		// Query below inserts into the users table the Firstname, lastname, username, password, email and salt
		$sql = "INSERT INTO users (firstname, lastname, username, password, email, salt) VALUES ('".$_POST['firstname']."','".$_POST['lastname']."','".$_POST['username']."','".$token."','".$_POST['email']."','".$salt1."')";

		if($conn->query($sql)){//If query was executed successfully Display a success message from below
			echo "<script type='text/javascript'> alert('New Record Inserted Successfully');</script>";
			echo "Connected Successfully. Account created";
		} else {
			echo "<script type='text/javascript'> alert('Data not successfully Inserted');</script>";
		}
		$conn = null;
	} catch(PDOException $e) { //Catch statement if unable to connect to database 
		echo "User not created. Error: " .$e->getMessage();
	}
}
?>

<html lang="en">
<head>

	<title> Web Applications </title> 
	<meta charset="utf-8" />		
	<link href="Untitled2.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="file.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>


<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</head>
<body>
	<?php 
	include'header.php';
	?>
	<div id="register">

		<style>
			input:invalid{
				background-color: #ffcccc;
			}
			input: required{
				border-color: red;
				border-width: 1px;
			}
			
		</style> 
		
		<form method = "POST" action="">


			<label class="fname"> First Name  <br> </label> 
			<input class="form-control" name="firstname" type = "text" placeholder="" /> <br> 
			
			<label class="lname"> Last Name <br> </label>
			<input class="form-control" name="lastname" type="text" placeholder=""/>  <br> 

			<label class="ename"> E-Mail <br></label>
			<input class="form-control" name="email" type="text" placeholder=""/> <br> 

			<label class="password"> Username <br></label>
			<input class="form-control" name="username" type="text" placeholder=""/> <br> 

			<label class="password"> Password <br></label>
			<input class="form-control" name="password" type="password" placeholder=""/> <br> 

			<input type="submit" name="submit"  value="SUBMIT" />

		</form> 

	</div>

	<div id="footer">
		<p>© Copyright 2016 McMaster University, Hamilton, ON, Canada. All Rights Reserved</P>
		</div>

	</body>
	</html>
