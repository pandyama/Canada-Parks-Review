<!DOCTYPE html>

<?php
	session_start(); // Session started at the beginning of the page

	if(isset($_REQUEST['logout']) && $_REQUEST['logout'] == true){ //If user clicks on logout execute code within
		unset($_SESSION['is_auth']);//Unset the is_auth variable back to false
		session_destroy();//Destroy session so that user is logged out and user info is not saved anywhere.
		header('location: search.php');//take user back to home page(search.php) 
		exit;
	}
	$surname ="";
	$uname = "";
	if(isset($_POST["lname"])){ // Check if the name field is not empty
	$surname = trim($_POST["lname"]); // Retrieve the name string from the field and save the trimmed value in a variable $name
	if(empty($surname)){ //or //!(preg_match("/^[a-zA-Z]*$/", $surname))){//pregmatch function call to define restriction that only Letters allowed for the name
		echo "Please enter a name or check the Format!!"; // echo an error message
		exit;
	}
}

if(isset($_POST["Desc"])){ // check if the username field is not empty
	$uname = trim($_POST["Desc"]);// retrieve the string from the field and save the trimmed value in a variable $uname
	if(empty($uname)){ //or (!(preg_match("/^[a-zA-Z]*$/", $uname)) && !(preg_match("/[^0-9]/", $uname)))){ //Check if its empty
		echo "Please enter a Description!!"; // Echo an error message
		exit;
	}
}

?>

<html lang="en">
<head>
	<meta charset="utf-8" />
	<title> Web Applications </title> 
	<link href="Untitled2.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="file.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>


<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

	<?php 
		//$id = $_GET['id'];
		include'header.php';//include this header file which has the code for Title and Menu which is consistent across all the pages
		include'header4.php'; // include this header file which has the code for Title of the object that this page refers to		
	?>

		<div>
			<center> <img src="bp.jpg" alt="Mountain View" style="width:400px;height:400px;"></img>
			</center>
			<!--- SOURCE: http://www.publicdomainpictures.net/pictures/170000/velka/canadian-rockies-moraine-lake.jpg -->
		</div>

		<div id="content">
			<p>
				In the fall of 1883, three Canadian Pacific Railway construction workers stumbled across a cave 
				containing hot springs on the eastern slopes of Alberta's Rocky Mountains. 
				From that humble beginning was born Banff National Park, 
				Canada's first national park and the world's third. Spanning 6,641 square kilometres (2,564 square miles) 
				of valleys, mountains, glaciers, forests, meadows and rivers, Banff National Park is one of the world's premier destination spots.
				<!--- SOURCE: http://www.pc.gc.ca/eng/pn-np/ab/banff/index.aspx-->
			</p>
		</div>

		<?php 
			$id = $_GET["id"]; // calling GET variable to retrieve the id set in the results page of the object and save it in a variable 
			include 'header3.php';// This header file includes a function  
			connect();// this is the function defined in the header3.php file which has all the code for database connection and executing query to display reviews for the object

		?>

		<script>

		function banMap(){  // This function follows the same format as the function "liveMap" above. The only difference is that this map is for the individual object's live map
		var latitude = <?php echo $_SESSION["f2"];?>;
		var longitude = <?php echo $_SESSION["f3"];?>;

		var coord = {lat: latitude, lng: longitude};
		var map = new google.maps.Map(document.getElementById('banff'), {zoom: 5, center: coord});
		var marker = new google.maps.Marker({position: coord, map: map});

	}
</script>

<div id = "banff"></div>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCIYhAtVJq55YyCmiqJqmmAhtpy_XakuY4&callback=banMap">	
</script>


</div>
<form method="POST" action="">

	<style> input: invalid{
		background-color: black;
	}
	input: required {
		border-color: red;
		border-width: 1px;
	}

</style>

<br><br>

<form method="POST" action="">
	Username:<br>
	<input id ="suggest3" class="form-control" type="text" name="lname"/><br> <br>	

	Review: <br>
	<textarea  id ="suggest2" class="form-control" name="Desc" style="height: 150px; width:250px" /> </textarea> <br> <br> 

	Rating:
	<input id ="suggest3" class="form-control" type="text" name="rate"/>
	<input type="submit" value="submit" name="submit"/>
</form>
<br> <br>
<form method="POST" action="">
	<input type="submit" name="logout" value="LOGOUT" />
</form>

<div id="footer">
	<p> © Copyright 2016 McMaster University, Hamilton, ON, Canada. All Rights Reserved</P>
	</div>

	<?php 
	//THE FOLLOWING PHP CODE IS TO SUBMITT A REVIEW AND ADD TO DATABASE

		$id = $_GET["id"]; // calling GET variable to retrieve the id set in the results page of the object and save it in a variable 
		if((isset($_POST['lname']) && isset($_POST['Desc']) && isset($_POST['rate']))){ // Check if user has clicked submit or not in order to submit the review
			try {
				//New PDO object defined to access the PHPMyadmin database with the appropriate table name, username, password.
				$conn = new PDO('mysql:host=localhost;dbname=mapleleaf','puppies_admin','diary123');
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				//Below is the query to insert the submitted review in the HTML form into the table REVIEW on the database
				//$_POST variable called to retrieve the values from the field inserted by the user
				$sql = "INSERT INTO review (objectid, user, comment, rating) VALUES ('".$id."','".$_POST["lname"]."','".$_POST["Desc"]."','".$_POST["rate"]."')";

				if($conn->query($sql)){// If query was executed successfully then display messages below
					echo "<script type='text/javascript'> alert('New Record Inserted Successfully');</script>";
					echo "Connected Successfully. Review Submitted";
				} else {//If not executed successfully display message below
					echo "<script type='text/javascript'> alert('Data not successfully Inserted');</script>";
				}
				$conn = null;
			} catch(PDOException $e) {//If unable to connect to database go to the catch statement
				echo "Unable to connect to database Error: " .$e->getMessage();//Display error
			}
		}
?>
</body>
</html>