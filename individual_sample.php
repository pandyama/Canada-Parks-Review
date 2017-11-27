<!DOCTYPE html>
<?php  
session_start();
//First thing to check on the results page is whether there is a user logged in or not
/*if(isset($_SESSION['is_auth'])){//If user is logged in direct them to individual_rev.php which is the file where users are allowed to submit reviews for objects
	$id = $_GET["id"];
	header('location: individual_rev.php'); //redirect user to a results page which allows them to submit reviews
	exit;
} */
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
	include'header.php'; //include this header file which has the code for Title and Menu which is consistent across all the pages
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
		include 'header3.php'; // This header file includes a function  
		connect();// this is the function defined in the header3.php file which has all the code for database connection and executing query to display reviews for the object

		?>

		<script>

		function banMap(){  // This function displays a live map with a marker
		var latitude = <?php echo $_SESSION["f2"];?>;
		var longitude = <?php echo $_SESSION["f3"];?>;

		var coord = {lat: latitude, lng: longitude};
		var map = new google.maps.Map(document.getElementById('banff'), {zoom: 5, center: coord});
		var marker = new google.maps.Marker({position: coord, map: map});

		}
		</script>
		<br><br>
		<div id = "banff"></div> 
		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCIYhAtVJq55YyCmiqJqmmAhtpy_XakuY4&callback=banMap">	
		</script>

		<div id="footer">
			<p> © Copyright 2016 McMaster University, Hamilton, ON, Canada. All Rights Reserved</P>
		</div>
</body>
</html>