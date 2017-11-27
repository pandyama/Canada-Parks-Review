<?php  
	//New PDO object defined to access the PHPMyadmin database with the appropriate table name, username, password.
	$conn = new PDO("mysql:host=localhost;dbname=mapleleaf","puppies_admin","diary123");
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$id = $_GET["id"];// calling GET variable to retrieve the id set in the results page of the object and save it in a variable 
	//Query below is used to retrieve object name from OBJECT table where object id is equal to the id retrieved from the results page
	$sql = $conn->prepare("SELECT DISTINCT obj_name FROM object where id = '$id' ");
	// After a prepare statement, the $sql variable must be executed which executes the Query from above. Binds the values to parameters and database executes the statement.
	$sql->execute();
	$f1 = $sql->fetch(PDO::FETCH_ASSOC); // Fetches the associated array from the query executed  above

	//Below is the HTML code to display the Title of the individual object selected
	echo"<div class='title'>
	<h1><center>".$f1["obj_name"].
		"</center></h1>
	</div>";

?>