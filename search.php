<!DOCTYPE html>
<?php 
//The following PHP code is for when the User is searching based on rating.
session_start();//Session is started in order to grab the rating value from drop down menu and also to be able to use it across different files
if(isset($_POST["enter"])){ // Condition: if User selects an option on drop down menu and clicks submit
	$rate = $_POST["Ratings"]; // Variable $rate is set to the option selected from Drop down menu by using $_POST array.
	$_SESSION["star"] = $rate; // Session variable is set to $rate, so that it's accessible across different files
}
?>
<head>
	<!--- Below is the HTML code for header of this page -->
	<title> Web Applications </title> 
	<meta charset="utf-8" />
	
	<script type="text/javascript" src="file.js"></script>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>


<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

	<link href="Untitled2.css" rel="stylesheet" type="text/css" />



</head>
<body> 

	<?php 
	include'header.php';

	echo '

<div class="container">

    <div class="row">
        <div class="col-md-4 col-md-offset-3">
            <form action="results_sample.php" class="search-form" method="POST">
                <div class="form-group has-feedback">
            		<label for="search" class="sr-only">Search</label>
            		<input type="search" class="form-control" name="searchs" id="search" label="a" placeholder="search">
              		<span class="glyphicon glyphicon-search form-control-feedback"></span>
            	</div>
            </form>
        </div>
    </div>

</div>


 <form action = "results_sample.php" method="POST" label="b">
    <select name="Ratings">
		<option value="5 Star">5 Star</option>
		<option value="4 Star">4 Star</option>
		<option value="3 Star">3 Star</option>
		<option value="2 Star">2 Star</option>
		<option value="1 Star">1 Star</option>
	</select>


	<input type="submit" name="enter"> 

	<?php 
		//The following PHP code is for when the user searchs based on rating, it redirects the user to the results page 
		if(isset($_POST["enter"])){ // Condition: If user selects an option from drop down menu and clicks submits
			header(location: results_sample.php); // Header function is used to redirect user to the results page
		}
	?>
 </form> <br> <br>

';

	if(!(isset($_SESSION['is_auth']))){ // This if condition checks whether a user is logged in or not. if no, then it includes a header file which has HTML code for a login button
		include 'header2.php'; //header2.php has the HTML code which displays a login button

	}
	else{
		//Below is HTML code for logging out
		echo '<form method="POST" action="">
		<input type="submit" name="logout" value="LOGOUT" />
			</form>';
	if(isset($_REQUEST['logout']) && $_REQUEST['logout'] == true){ //If user clicks on logout execute code within
		unset($_SESSION['is_auth']);//Unset the is_auth variable back to false
		session_destroy();//Destroy session so that user is logged out and user info is not saved anywhere.
		header('location: search.php');//take user back to home page(search.php) 
		exit;
	}
	}
	?>

<br/>

<!-- <form action="results_sample.php" method="POST"> 
	<input type="search" class="search" name = "searchs" label="a" placeholder="Search by name or place" required />
	<input type="button" class="button" value="Search" />
</form>  -->



	<div id="footer">
		<p>© Copyright 2016 McMaster University, Hamilton, ON, Canada. All Rights Reserved</P>
	</div>
		
</body>

</html>