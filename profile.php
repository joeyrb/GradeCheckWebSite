<!DOCTPYE html>

<html>
	<head>
	</head>
	
	<body>
		<?php
			$session_start();
			if($_SERVER["REQUEST_METHOD"] == "POST") {
				$firstname = $_POST["firstname"];
				$lastname = $_POST["lastname"];
				$uname = $_SESSION['$uname'];
				$file = "/users/".$uname.".xml";
				$student = simplexml_load_file($file) or die("User does not exist");
				
				$student->name->firstname = $firstname;
				$lastname->name->firstname = $lastname;
				
				$student->asXML($newfile);
				
				echo "<p align='center'>Successfully updated profile Information! Redirecting in a couple seconds...</p>";
				header("Refresh: 3; url=profile.html");	
			}
		?>
	</body>
</html>