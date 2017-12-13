<!--
	Author: Peter Yamaguchi
	Description:
		This file updates the student's xml file, also updates the classes
		in progress, completed, and the gpa.
-->

		<?php
			if($_SERVER["REQUEST_METHOD"] == "POST") {
				
	
				//get the data that needs to be updated
				$data = $_POST['data'];
				//echo "<br> data $data";
				
				//open file of the student to edit information
				$uname = $_SESSION['$uname'];
				$file = "users/".$uname.".xml";
			
				$student = simplexml_load_file($file) or die("Can't find user $uname");
			
				//get the course infomation
				$courses = $student->courses;
				
				$parsedData = parseData($data);
				
				$completed = 0;
				$inprogress = 0;
				$totalgpa = 0.0;
				$totalCredits  = 0;
				$gpa = 0;
				$j = 0;
				$doneCredits = 0;
				//
				//go through each of the passed in data, or classes from the
				//list
				for($i = 0; $i < count($parsedData); $i++){
					$temp = explode("=",$parsedData[$i]);
					
					
					if((string)$temp[1] != "NA"){
						//$completed
						switch((string)$temp[1]){
							case "A":
								$gpa = 4.0;
								break;
							case "B":
								$gpa = 3.0;
								break;
							case "C":
								$gpa = 2.0;
								break;
							case "D":
								$gpa = 1.0;
								break;
							case "F":
								$gpa = 0.0;
								break;
							case "EX":
								break;
						}
						
					}
						//go through the course and check if the temp[0] == $course->name
					foreach($courses->subject as $subject){
						foreach($subject->course as $course){
						//check if you don
							if((string)$temp[0] == (string)$course->name){
								//check if the grade has changed
								//$totalCredits += (int)$course->credits;
								//special case if the class is an NA so change
								//it to an empty string
							
								if((string)$temp[1] == "NA"){
									$temp[1] = "";
								}
								if((string)$temp[1] != (string)$course->grade){
									$course->grade = $temp[1];
								}
								if((string)$temp[1] == "inprog"){
									$inprogress+= $course->credits;
								}
								if((string)$temp[1] == "A" || (string)$temp[1] == "B" 
								|| (string)$temp[1] == "C" || (string)$temp[1] == "D"){
									$doneCredits += $course->credits;
								}
							}
							if((string)$temp[1] == "A" || (string)$temp[1] == "B" 
							|| (string)$temp[1] == "C" || (string)$temp[1] == "D" 
							|| (string)$temp[1] == "F" ){
								$totalgpa += $gpa*(int)$course->credits;
								$totalCredits += $course->credits;
								
							}
							
				
						}
					}
					
				}
				//$total = $total + $completed;
				
				$student->gpa = $totalgpa/$totalCredits;
				$student->completed = $doneCredits;
				$student->inprogress = $inprogress;
		
				$student->asXML($file);

			}
		
			function parseData($data){
				//parse the data array
					$class = explode(",",(string)$data);
					$i = 0;
					var_dump($class);
					return $class;
			}
			
			function readInClassInfo($className){
				$file = "courses.xml";
				$courses = simplexml_load_file($file) or die("could not courses open file");
				$temp = explode(" ",$className);
	
					//var_dump($className);
					foreach($courses as $course){
						//foreach($course as $class){
						//check  if its the same subject
							if($course->prefix == $temp[0] && $course->number == $temp[1]){
								//echo "<br>$course->prefix and  $course->number and $course->name";
								//check if it is the same class name
								$tempCourse = new Course();
								//get all the information 
								$tempCourse->isactive = (string)$course->attributes()->isactive;
								echo (string)$course->attributes()->isactive;
								$tempCourse->prefix = $course->prefix;
								$tempCourse->number = $course->number;
								$tempCourse->name = $course->name;
								$tempCourse->credits = $course->credits;
								$tempCourse->offered = $course->offered;
								$tempCourse->description= $course->description;
								$tempCourse->prereq = $course->prereq;
								$tempCourse->coreq = $course->coreq;
								$tempCourse->notes = $course->notes;
								//echo "<br>$tempCourse->prefix and  $tempCourse->number";
								return $tempCourse;
							}
		
				}
			return NULL;
		}
	
			?>

