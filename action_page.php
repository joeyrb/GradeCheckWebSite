<?php
    session_start();

	//when the submit button is pressed
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		$cookie_name = "username";
		$uname = $_POST['uname'];
    	$cookie_value = $uname;
		setcookie($cookie_name, $cookie_value);
		$_SESSION['$uname'] = $uname;
		
		//check if there is an existing user
		$target = "users/".$uname.".xml";
		if(file_exists($target)){
			echo "File already exist";
			header("Location: home.html");
			/* Make sure that code below does not get executed when we redirect. */
			exit;
		}else{
			echo "User doesn't exist, please <a href='signup.html'>Sign Up</a>";
		}
	}
	
	/*
	Function: test_input
	by: W3 Schools @w3schools.com
	Description:
		Strips a string of the extra spaces and \
		also transforms the data into an html
		special char string
	*/
	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
		
?>
