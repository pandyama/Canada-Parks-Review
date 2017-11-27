<!DOCTYPE html>
<?php 
session_start();
if(isset($_POST["enter"])){ // Condition: if User selects an option on drop down menu and clicks submit
	$rate = $_POST["Ratings"]; // Variable $rate is set to the option selected from Drop down menu by using $_POST array.
	$_SESSION["star"] = $rate; // Session variable is set to $rate, so that it's accessible across different files
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
	
	<?php  // Following is a php code which calls a header file which inlcudes things like Menu and Title which is same across all the pages
	include'header.php';
	if(!(isset($_SESSION['is_auth']))){
		include 'header2.php';
	}
	else{
		echo '<form method="POST" action="">

		<input type="submit" name="logout" value="LOGOUT" />

	</form>';
	if(isset($_REQUEST['logout']) && $_REQUEST['logout'] == true){
		unset($_SESSION['is_auth']);
		session_destroy();
		header('location: search.php');
		exit;
	}
}
?>

<div id="search2">
	<form action="search.php">
		<button class = "btn btn-primary" label="a" onclick="search.php"> BACK TO HOME 
		</button>

	</form> 

</div>

	<?php // BELOW IS THE PHP CODE WHICH IS USED TO DISPLAY SEARCH RESULTS BASED ON RATING OR SEARCH STRING
	//If Condition: $_POST array is used to check if the Search bar is entered with a string in "search.php" file 
	if(isset($_POST['searchs'])){ // Condition: If the "searchs" field is set in the "search.php" file with some string then go and execute code within this condition.

	try {
			//New PDO object defined to access the PHPMyadmin database with the appropriate table name, username, password.
		$conn = new PDO('mysql:host=localhost;dbname=mapleleaf','puppies_admin','diary123');
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			$name = $_POST['searchs']; // $name variable is set to the String that searched by the user in "search.php" file which is the home page 

			//$sql variable below is used to Prepare a query for the PDO object declared at start of the TRY statement
			// The query grabs all the columns from the OBJECT table where the name of the object is $name (which is the name the user searched) 
			//SQL statement template is created and sent to database
			$sql = $conn->prepare("SELECT * FROM object where obj_name = '$name' ");
			$sql->execute(); // After a prepare statement, the $sql variable must be executed which executes the Query from above. Binds the values to parameters and database executes the statement.
			$f1 = $sql->fetch(PDO::FETCH_ASSOC); // Fetches a row from result associated with the PDO objets. Returns an Associated Array

			$f2 = floatval($f1['lat']); // The latitude value from the query is stored in the variable and its converted to a Float 
			$f3 = floatval($f1['lon']); // The Longitude value from the query is stored in the variable and its also converted to a Float
			$_SESSION["f2"] = $f2; // Session variable created to store the Latitude
			$_SESSION["f3"] = $f3; // Session varaible created to store the Longitude

			$count = $sql->rowCount(); // $count variable declared which retrieves the number of rows resulted from the QUERY.

			if($count==0){ // The following condition is to check whether the number of rows resulted in 0 
				echo "No Results Found"; // If no rows were found then Echo a message.
			}
			if($count>0){ // The following conditions is if the number of rows is greater than 0
				// Start echoing results as a table in HTML format
				echo "<br> <br> <table id=first class=table table-inverse>
				<tr>
					<th colspan=2>RESULTS</th> 
				</tr>";
				$i = 0; // Counter variable used to loop through all the search results found from the Query
				while($i < $count){
					// The object name is retrieved by calling the $f1 variable which is the Associated array 
					// Query string is used to save the object id from $f1["id"] in a variable called "id"
					// After search result and iframe object is used to show the result on a map with a marker/
					// The latitude and longitude are used from the variables $f2 and $f3 declared after the FETCH statement
					if(!isset($_SESSION['is_auth'])){ // This if condition is to check if any user is already logged in or not. 

						//Echo results as Table and the link to the individual page taking to the page where a public user can see individual page
						//Iframe is used to show map for each individual object
						echo '<tr> 
						<td><a href = "individual_sample.php?id=',$f1["id"],'">'.$f1["obj_name"].'</a></td>
						<td> <iframe src ="https://www.google.com/maps/embed/v1/view?key=AIzaSyB54LXwvqqieRBHBK7USr6xhHXLmeF1FwI&center='.$f2.','.$f3.'&zoom=4" height="140" allowfullscreen>
						</iframe> </td>
					</tr>';
				}
				else { // Echo results as Table and the link to the individual page where a logged in user can submit a Review
					// The latitude and longitudes are obtained the same way as above
					echo '<tr>
					<td><a href = "individual_rev.php?id=',$f1["id"],'">'.$f1["obj_name"].'</a></td>
					<td> <iframe src ="https://www.google.com/maps/embed/v1/view?key=AIzaSyB54LXwvqqieRBHBK7USr6xhHXLmeF1FwI&center='.$f2.','.$f3.'&zoom=4" height="140" allowfullscreen>
					</iframe> </td>
				</tr>';
			} 
			$i++;
		
	}
		echo "</table>";
	}
	} // Catch statement for error with connecting to database
	catch(PDOException $e) {
		echo "User not created. Error: " .$e->getMessage();
	}

}

//The else condition below executes the code if a user submits a rating to search based on
else{

	try {
		//New PDO object defined to access the PHPMyadmin database with the appropriate table name, username, password.
		$conn = new PDO('mysql:host=localhost;dbname=mapleleaf','puppies_admin','diary123');
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$rates = $_SESSION["star"]; // $rate variable is set to the Rating selected by user in "search.php" file. It is saved in a SESSION variable

		//Below is a query to obtain Object ID from Review Table where the rating is equal to the rating that user selected
		$sql = $conn->prepare("SELECT DISTINCT objectid FROM review where rating = '$rates' ");
		$sql->execute(); // After a prepare statement, the $sql variable must be executed which executes the Query from above. Binds the values to parameters and database executes the statement.
		$f1 = $sql->fetch(PDO::FETCH_ASSOC);// Fetches a row from result associated with the PDO objets. Returns an Associated Array

		$count = $sql->rowCount();// $count variable declared which retrieves the number of rows resulted from the QUERY.

		if($count==0){// The following condition is to check whether the number of rows resulted in 0 
			echo "No Results Found"; // If no rows were found then Echo a message.
		}
		if($count>0){// The following conditions is if the number of rows is greater than 0
				// Start echoing results as a table in HTML format
			echo "<table id=first>
			<tr id=one>
				<th colspan=2>RESULTS</th>
			</tr>";
			$i = 0;
			while($i < $count){
				// The object name is retrieved by calling the $f1 variable which is the Associated array 
				// Query string is used to save the object id from $f1["id"] in a variable called "id"
				// After search result and iframe object is used to show the result on a map with a marker/
				// The latitude and longitude are used from the variables $f2 and $f3 declared after the FETCH statement
				$f4 = $f1["objectid"]; // Variable $f4 is set equal to the object id from the query executed from the variable "$sql"

				//The query below is retrieve all the information from the object table based on the object id from the variable $f4 above
				$sql1 = $conn->prepare("SELECT DISTINCT * FROM object where id = '$f4'");
				$sql1->execute();
				$f5 = $sql1->fetch(PDO::FETCH_ASSOC);

				$f2 = floatval($f5['lat']);// The latitude value from the query is stored in the variable and its converted to a Float 
				$f3 = floatval($f5['lon']);// The longitude value from the query is stored in the variable and its converted to a Float 
				$_SESSION["f2"] = $f2; // Session variable created to store the Latitude
				$_SESSION["f3"] = $f3; // Session variable created to store the Longitude
				if(!isset($_SESSION['is_auth'])){
				echo '<tr = two>
				<td><a href = "individual_sample.php?id=',$f5["id"],'">'.$f5["obj_name"].'</a></td>
				<td> <iframe src ="https://www.google.com/maps/embed/v1/view?key=AIzaSyB54LXwvqqieRBHBK7USr6xhHXLmeF1FwI&center='.$f2.','.$f3.'&zoom=3" height="140" allowfullscreen>
				</iframe> </td>
			</tr>';
		}
		else{
			echo '<tr = two>
				<td><a href = "individual_rev.php?id=',$f5["id"],'">'.$f5["obj_name"].'</a></td>
				<td> <iframe src ="https://www.google.com/maps/embed/v1/view?key=AIzaSyB54LXwvqqieRBHBK7USr6xhHXLmeF1FwI&center='.$f2.','.$f3.'&zoom=3" height="140" allowfullscreen>
				</iframe> </td>
			</tr>';
		}
			$i++;
			$f1 = $sql->fetch(PDO::FETCH_ASSOC); // Fetch statement called again on the First query $sql to retrieve the next associated array
			$f5 = $sql1->fetch(PDO::FETCH_ASSOC); // Fetch statement called again on the Second query $sql1 to retrieve the next associated array
		}
		echo "</table>";
	}
}
// Catch statement for error with connecting to database
catch(PDOException $e) {
	echo "User not created. Error: " .$e->getMessage();
}

}
?>

<script>

function banffMap(){  // This function follows the same format as the function "liveMap" above. The only difference is that this map is for the individual object's live map
var latitude = <?php echo $f2;?>;
var longitude = <?php echo $f3;?>;

var coord = {lat: latitude, lng: longitude};
var map = new google.maps.Map(document.getElementById('banff'), {zoom: 5, center: coord});
var marker = new google.maps.Marker({position: coord, map: map});

}
</script>

<br> <br> <br>

<div id = "banff"></div>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAwj1g0AnNELooj8g_S4Dd7eRMk6w-mk-4&callback=banffMap">	
</script>



<div id="footer">
	<p>© Copyright 2016 McMaster University, Hamilton, ON, Canada. All Rights Reserved</P>
	</div>
	
</body>


</html>