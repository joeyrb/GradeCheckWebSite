<!DOCTYPE html>
<html>
<head></head>

<body>
<?php
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		
		//get all the inputs 	
		$firstname = $_POST["firstname"];
		$lastname = $_POST["lastname"];
		$sid = $_POST["studentid"];
		$target = "users/".$sid.".xml"; 
		/*$text = "<student>
					<name>
						<first>$firstname</first>
						<last>$lastname</last>
					</name>
					<sid>$sid</sid>
				</student>";
				*/
		//checks if user exist
		if(file_exists($target)) {
			echo "User already exist please <a href='CS_checklist.html'>Log In</a>";
		}else{
			//copy the newstudent.xml file to create a new student
			$file = "newstudent.xml";
			$newfile = $target;
			
			// if 'users' directory doesn't exist
		    if (!file_exists('./users/')) {
                if (!mkdir('./users/', 0777)) { // Create users directory
                    // print_r(error_get_last());
                    die("Unable to create users folder");
                }
            }
			
			if(!copy($file,$newfile))
			{
				echo "<p align='center'>Could not create new user! Redirecting in a couple seconds...</p>";
				header("Refresh: 3; url=CS_checklist.html");
				
			}else{
				chmod($newfile, 0644);
				//update the new file with the current given information
				$student = simplexml_load_file($newfile);
				
				//update nodes
				$student->name->first = $firstname;
				$student->name->last = $lastname;
				$student->studentid = $sid;
				
				//save the updated document
				$student->asXML($newfile);
				
				echo "<p align='center'>Successfully registered! Redirecting in a couple seconds...</p>";
				header("Refresh: 3; url=CS_checklist.html");
			}
			//if not open a new file
			//$file = fopen($target,"w");
			//write basic information to file
			/*if($file){
				fwrite($file,$text);
				fclose($file);
				//redirect to login page
				echo "<p align='center'>Successfully registered! Redirecting in a couple seconds...</p>";
				header("Refresh: 3; url=index.php");
				exit;
			}*/
		}
	}
		
?>
</body>
</html>
