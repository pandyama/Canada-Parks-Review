<!DOCTYPE html>
<?php

session_start();

//ONLY logged in user can access this page.
if(!isset($_SESSION['is_auth'])){ // If no user has logged in, execute the code in this condition
	header('location: sign_in.php'); // Direct user to sign in page.
	exit;
}
else if(isset($_REQUEST['logout']) && $_REQUEST['logout'] == true){ //If user clicks on logout execute code within
	unset($_SESSION['is_auth']); //Unset the is_auth variable back to false
	session_destroy(); //Destroy session so that user is logged out and user info is not saved anywhere.
	header('location: sign_in.php'); //take user back to sign in page 
	exit;
}

$name = "";
$latitude = "";
$longitude = "";

//BELOW IS THE PHP SERVER SIDE VALIDATION FOR Parkname, Latitude, Longitude
if(isset($_POST["parkname"])){ // Check if the object name field is not empty
	$name = trim($_POST["parkname"]); // Retrieve the name string from the field and save the trimmed value in a variable $name
	if(empty($name) or !(preg_match("/[a-zA-Z]/", $name))){//pregmatch function call to define restriction that only Letters allowed for the object name
		echo "Please enter a park name with letters only"; //display a message 
		header('location: submission.php'); //redirect user back to submission page (submission.php)
		exit; 
	}
}

if(isset($_POST["lat"])){ // Check if the latitude field is not empty
	$latitude = trim($_POST["lat"]); //Retrieve the number from the field and save the trimmed value in a variable $latitude
	if(empty($latitude) or !(preg_match("/-?[^0-9]/", $latitude))){//pregmatch function call to define restriction that only numbers either + or - allowed for latitude
		echo "Please enter latitude with numbers only";
		header('location: submission.php'); //redirect user back to submission page
		exit;
	}
}

if(isset($_POST["long"])){ // Check if the longitude field is not empty
	$longitude = trim($_POST["long"]); //Retrieve the number from the field and save the trimmed value in a varaible $longitude
	if(empty($longitude) or !(preg_match("/-?[^0-9]/", $longitude))){//pregmatch function call to defined restriction that only numbers either + or - allowed for longitude
		echo "Please enter longitude with numbers only";
		header('location: submission.php'); //redirect user back to submission page
		exit;
	}
}



?>
<html>
<head>
	<title> Web Applications </title> 
	<meta charset="utf-8" />		


	<link href="Untitled2.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>


<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</head>
<body> 
	<?php 
	include'header.php';
	?>
	<div id="content">
		<p>
			If you have any recommendation of a National Park that you would like us to know about. 
			You can let us know right here by just filling out the information below
			<!--- http://www.pc.gc.ca/eng/pn-np/ab/banff/index.aspx-->
		</p>


	</div>

<form method="POST" action="">

		<style> input: invalid{background-color: black;}
		input: required {border-color: red;border-width: 1px;}

	</style>
	Name of National Park: <br>
	<input id ="suggest" type="text" name="parkname"/><br> <br>

	Description: <br>
	<textarea  id ="suggest2" name="Desc" style="height: 150px; width:250px" /> </textarea> <br> <br> 

	latitude:
	<input id ="suggest3" type="text" name="lat"/><br> <br>

	longitude:
	<input id ="suggest3" type="text" name="long"/><br> <br>

<form method="POST" action="submit.php" enctype="multipart/form-data">
	Upload an Image: <br>
	<p><input id ="suggest4" type="file" name="img"/> </p>
	<p><input type="submit"/></p>
</form>

<form method="POST" action="">

	<input type="submit" name="logout" value="LOGOUT" />

</form>


<div id="footer">
	<p>© Copyright 2016 McMaster University, Hamilton, ON, Canada. All Rights Reserved</P>
</div>


</body>
<?php

if(isset($_POST["submit"])) { //If user clicks the submit button after filling out the HTML form for object submission, execute the code below
	try {
		//New PDO object defined to access the PHPMyadmin database with the appropriate table name, username, password.
		$conn = new PDO('mysql:host=localhost;dbname=mapleleaf','puppies_admin','diary123');
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		//the query below Inserts into the Object table the values retrieved from the fields in the HTML form for object submission
		$sql = "INSERT INTO object (obj_name, lat, lon) VALUES ('".$_POST['parkname']."','".$_POST['lat']."','".$_POST['long']."')";

		if($conn->query($sql)){ // if query is executed successfully display the message within the condition
			echo "<script type='text/javascript'> alert('New Record Inserted Successfully');</script>";
			echo "Connected Successfully. Account created";
		} else {//If query is not executed successfully display the message within the condition
			echo "<script type='text/javascript'> alert('Data not successfully Inserted');</script>";
		}
		$conn = null;
	} catch(PDOException $e) { //Catch statement if you run into error trying to connect to database
		echo "Cannot connect to Database. Error: " .$e->getMessage();
	}
}

?>


</html>