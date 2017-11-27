// GEOLOCATION CODE WAS BASED OFF FROM THE FOLLOWING LINKS: 
//			http://www.w3schools.com/html/html5_geolocation.asp
//			

function getLocation(){// This function is used to get the user location using geolocation API
	var err = document.getElementById("location"); 
	if(navigator.geolocation){ // This condition gets executed if the geolocation API is able to get user's location 
		navigator.geolocation.getCurrentPosition(showPosition, showError);	// in this function call, the function retrieves the exact coordinates of the user's location
}
else{
	err.innerHTML="Location not found or not supported by browser";
}
}

function showPosition(position){

	//DISPLAY ON MAP
	var coord = position.coords.latitude + "," + position.coords.longitude; // This variable gets the location from the getLocation() and stores it as a format 
	var url = "http://maps.googleapis.com/maps/api/staticmap?center="+coord+"&zoom=14&size=400x300&sensor=false";
	document.getElementById("map").innerHTML = "<img src = "+url+" >";
	
}






function showError(error){ // This function is for displaying error message by using pre-defined cases for different situations when an error occurs
	var msg = "Unkown Error, please try again!!";
	switch(error.code){
		case error.PERMISSION_DENIED: // This case is for denied permission, it could happen if the user has the location services turned off
		msg = "Permission denied to access location"
		break;
		case error.POSITION_UNAVAILABLE: // This case can happen if the location is undetectable due to the remoteness of the location
		msg = "Location information is unavailable."
		break;
		case error.TIMEOUT: // This case can happen if it takes too long to retrieve the location
		msg = "Request has timed out."
		break;
		case error.UNKNOWN_ERROR:
		msg = "Unkown error occurred."
		break;
	}
	document.getElementById("location").innerHTML = msg; // If none of the cases happen then this message gets displayed on the screen
}


/*function banffMap(){  // This function follows the same format as the function "liveMap" above. The only difference is that this map is for the individual object's live map

var coord = {lat: 51.4968464, lng: -115.9302448};
var map = new google.maps.Map(document.getElementById('banff'), {zoom: 5, center: coord});
var marker = new google.maps.Marker({position: coord, map: map});

}*/


//LIVE MAP FOR SEARCH RESULTS ITEMS
//FOLLOWED USING GOOGLE MAPS TUTORIAL ON LIVE MAP WITH MARKER
//https://developers.google.com/maps/documentation/javascript/adding-a-google-map
// COORDINATES ACCESSED FROM GOOGLE MAPS WEBSITE

function liveMap(){

	// all the coordinates listed below were obtained through GOOGLE MAPS WEBSITE

	var coord = {lat: 51.4968464, lng: -115.9302448};  // coordinates for the an object
	var coord1 = {lat: 45.718222, lng: -78.859572};	   // coordinates for another object
	var coord2 = {lat: 45, lng: -81.333333};			// coordinates for another object
	var coord3 = {lat: 73.601949, lng: -119.40424};		// coordinates for another object
	var coord4 = {lat: 46.738285, lng: -60.650977};		// coordinates for another object
	var coord5 = {lat: 52.873383, lng: -117.954294};	// coordinates for another object


	var map = new google.maps.Map(document.getElementById('live'), {zoom: 2, center: coord}); // This variable creates a map object using a library created by
																							// GOOGLE and it takes the coordinates, the zoom level and the element 
																							//through which the map will be displayed
	// The 'content' variables below are string variables used to display info window for each marker																						
	var content = 'Banff National Park, ALBERTA';
	var content1 = 'Algonquin National Park, ONTARIO';
	var content2 = 'Bruce Peninsula, ONTARIO';
	var content3 = 'Aulavik National Park, NORTHWEST TERRITORIES';
	var content4 = 'Cape Breton Highlands, NOVA SCOTIA';
	var content5 = 'Jasper National Park, ALBERTA';

	// The info variables below each define an info window for each of the marker with the message from 'contents' variables above
	var info = new google.maps.InfoWindow({content: content, maxWidth: 200});
	var info1 = new google.maps.InfoWindow({content: content1, maxWidth: 200});
	var info2 = new google.maps.InfoWindow({content: content2, maxWidth: 200});
	var info3 = new google.maps.InfoWindow({content: content3, maxWidth: 200});
	var info4 = new google.maps.InfoWindow({content: content4, maxWidth: 200});
	var info5 = new google.maps.InfoWindow({content: content5, maxWidth: 200});																						


	// The variables declared below are all the markers for each of the search result, they all correspond to the "coord" variables declared above in this function
	var marker = new google.maps.Marker({position: coord, map: map});
	var marker1 = new google.maps.Marker({position: coord1, map: map});
	var marker2 = new google.maps.Marker({position: coord2, map: map});
	var marker3 = new google.maps.Marker({position: coord3, map: map});
	var marker4 = new google.maps.Marker({position: coord4, map: map});
	var marker5 = new google.maps.Marker({position: coord5, map: map});

	// Below are function call to the function addListener which displays the infowindow for each marker after user has clicked on it
	marker.addListener('click', function(){info.open(map,marker)});
	marker1.addListener('click', function(){info1.open(map,marker1)});
	marker2.addListener('click', function(){info2.open(map,marker2)});
	marker3.addListener('click', function(){info3.open(map,marker3)});
	marker4.addListener('click', function(){info4.open(map,marker4)});
	marker5.addListener('click', function(){info5.open(map,marker5)});

}


//FORM VALIDATION FOR USER REGISTRATION PAGE
// Dr. Douglas Stebila's lecture slides from Avenue to Learn were heavily used as Reference for the function below

function validate(form){ // This function is used to validate all the forms on the User Registration page
	if (!(/[0-9]/.test(form.username.value) && (/[A-Z]/.test(form.username.value) || /[a-z]/.test(form.username.value)))){  // This condition checks to make sure that the username field has at least a number and a caps or lower case character
		window.alert("username is in incorrect format, please enter at least a number and letter");
		return false;
	}
	if (!(/[A-Z]/.test(form.firstname.value) || /[a-z]/.test(form.firstname.value))){ // This condition checks to make sure the First name includes either a caps or lower case character only
		window.alert("Please enter first name using letters only");
		return false;
	}

	if (!(/[A-Z]/.test(form.lastname.value) || /[a-z]/.test(form.lastname.value))){ // This condition checks to make the last name includes either a caps or lower case character only
		window.alert("Please enter last name using letters only");
		return false;
	}

	if (!(/^[^@]+@[^@]+\.[a-zA-Z]{2,}$/.test(form.email.value))){ // This condition checks for the exact format of an email address like this ---> example@example.com   (Dr. Stebila's lecture slides)
		window.alert("No email entered.");
		return false;
	}

	if (!(/[0-9]/.test(form.password.value) && (/[A-Z]/.test(form.password.value) && /[a-z]/.test(form.password.value)))) { // This condition check for the right format of the password which must include a number, a caps char, and a lower case character
		window.alert("Please include atleast 1 number, 1 caps and 1 lower case character for the password");
		return false;
	}
	
	return true;
	
}