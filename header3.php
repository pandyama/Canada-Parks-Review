<?php 
		function connect(){ //This function deals with database conncetion and query execution for individual object page reviews
			$id = $_GET["id"]; // using GET variable we retrieve the id of the object selected from results page in result_sample.php
		try {
			//New PDO object defined to access the PHPMyadmin database with the appropriate table name, username, password.
			$conn = new PDO('mysql:host=localhost;dbname=mapleleaf','puppies_admin','diary123');
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			//$name = $_SESSION["find"]; 
			//The query below retrieves user, review and rating from the REVIEW table where the object id is equal to the $id from the GET variable
			$sqlid = $conn->prepare("SELECT DISTINCT user, comment, rating FROM review where objectid = $id");
			$sqlid->execute(); // After a prepare statement, the $sql variable must be executed which executes the Query from above. Binds the values to parameters and database executes the statement.
			$f1 = $sqlid->fetch(PDO::FETCH_ASSOC); // Fetches a row from result associated with the PDO objets. Returns an Associated Array
			$count = $sqlid->rowCount(); // $count variable declared which retrieves the number of rows resulted from the QUERY.

			if($count==0){ // The following condition is to check whether the number of rows resulted in 0 
				echo "No Results Found"; // If no rows were found then Echo a message.
			}
			if($count>0){// The following conditions is if the number of rows is greater than 0
				// Start echoing reviews as a table in HTML format
				echo "<table id=first class=table table-inverse>
				<tr id=one>
					<th colspan=3>REVIEWS</th>
				</tr>";
				$i = 0;
				while($i < $count){
					//using $f1 variable which holds the array of results from the query.
					//Display user, comment and rating from $f1 array
					echo '<tr = two>
					<td>'.$f1["user"].'</td>
					<td>'.$f1["comment"].'</td>
					<td>'.$f1["rating"].'</td>
				</tr>';
				$i++;
				$f1 = $sqlid->fetch(PDO::FETCH_ASSOC); // call fetch statement again in order to fetch the next associated array from the query
				//or else the result would repeat the same rows multiple times.
			}
			echo "</table>";
		}
	}
	catch(PDOException $e) {//Catch statement if unable to connect to database
		echo "Unable to connect to database. Error: " .$e->getMessage();
	}
}

?>