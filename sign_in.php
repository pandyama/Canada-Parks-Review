<!DOCTYPE html>
<?php 
session_start();
	//LOGIN MECHANISM GOES AT THE TOP ABOVE THE LOGIN FORM SUBMISSION
try {
	//New PDO object defined to access the PHPMyadmin database with the appropriate table name, username, password.
	$conn = new PDO('mysql:host=localhost;dbname=mapleleaf','puppies_admin','diary123');
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	if(isset($_POST["username"]) && isset($_POST["password"])){ // This condition is to check to make sure both username and password fields are entered
		$err = '';// Declare a string variable with empty string;
		$username = trim($_POST['username']);//Trim the value from username field and store it in a variable
		$password = trim($_POST['password']);//Trim the value from password field and store it in a variable
		if($username == ''){//If no username is entered display the error message
			$err = 'You must enter your Username'; //Set the variable to the message
			echo $err;//Echo the message
		}
		if($password == ''){ // If no password is entered display the error message
			$err = 'You must enter your password';//Set the variable to the message
			echo $err;//Echo the message
		}
		if($err == ''){ // IF the $err variable is empty that means username and password fields have been entered
			//The query below retrieves the id, firstname, username, password and salt from the USERS table where username is equal to the username from HTML Form Field
			$sql = $conn->prepare("SELECT id, firstname, lastname, username, password, salt FROM users WHERE username = '$username'");
			$sql->bindParam(':username',$username);//bind param, binds the parameters to the SQL query
			$sql->execute();// After a prepare statement, the $sql variable must be executed which executes the Query from above. Binds the values to parameters and database executes the statement.
			$result = $sql->fetch(PDO::FETCH_ASSOC); //FEtch the associated array from the executed query $sql
			$salt1 = $result['salt']; //Save the salt value from the associated array into a variable
			$count = $sql->rowCount();//Call the row count function to count how many rows did the query return
			$token = hash('sha256', $salt1.$password); //Call hash function to hash the password with salt in the same manner it was hashed when user Registers in Registration.php
			
			if(($token == $result['password'])){ // If the ^^$token from above matches the password in the database, execute code within
				$_SESSION['is_auth'] = true; // Set a session variable to true, which will be used throughout other pages to identify whether a user is logged in or not
				$_SESSION['username'] = $result['username'];  //Set a session variable to username
				$_SESSION['firstname'] = $result['firstname'];//Set a session variable to firstname of user
				$_SESSION['lastname'] = $result['lastname'];//Set a session variable to lastname of user
				header('location:search.php');//After logging in, direct user to search.php which is the home page 
				exit;
			}
			else{ //If password does not match display error message below
				$err = 'Usename and password not found';
				echo $err;
			}
		}	
	}
	}
	catch(PDOException $e) { //Catch statement if unable to connect to database
			echo 'ERROR: '.$e->getMessage();
		}
?>

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
			<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
				<input type="text" class="form-control" name="username" placeholder="Username" />
				<input type="password"  class="form-control" name="password" placeholder="Password" /> 
				<input type="submit" name="login" value="LOGIN" /> <br> <br>
			</form>
			<form>
				<p class="message"> Not Registered? <a href="Registration.php">REGISTER</a></p>
			</form>
			<br />
			
			<div id="footer">
				<p>© Copyright 2016 McMaster University, Hamilton, ON, Canada. All Rights Reserved</P>
				</div>
			</body>
			</html>