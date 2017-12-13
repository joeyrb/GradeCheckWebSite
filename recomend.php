<!--
	Author: Peter Yamaguchi
	Class: CSC 468 GUI
	Description: This spits out recomendations for classes that may or mat not 
	be offered. It gives you the class name, decription, number, when the 
	class is offered, and if it is an active class. 
-->

<!DOCTYPE html>

<html>
	<head>
		<link rel="stylesheet" href="recomend.css">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://www.w3schools.com/w3css/3/w3.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<script src="script.js"></script>
		<script src="initHome.js"></script>
		<script src="studentInfo.js"></script>
		<script src="cookieControl.js"></script>
	</head>
	
	<body onload="initHome()">

	
	
	<!-- Top Nav Bar -->
		<div class="w3-bar w3-xlarge w3-center" style="background-color: #011C4F; color: #C1A868;">
		 <!-- <button class="w3-bar-item w3-button" id="hamburger" onclick="w3_open();">&#9776;</button> -->
		  <a href="#" class="w3-bar-item w3-button w3-right">User: <i id="doc_User" class="w3-large"></i></a>
		  <a href="./flowchart.html" class="w3-bar-item w3-button w3-right">Flow Chart</a>
		  <a href="./recomend.php" class="w3-bar-item w3-button w3-right">Recommended Courses</a>
		  <a href="./home.html" class="w3-bar-item w3-button w3-right">Home</a>
		</div>
		<br>
	
		<?php 
			
			
			session_start();
	
			class Course{
				public $isactive = "yes";
				public $prefix= "";
				public $number= "";
				public $name= "";
				public $credits = 0;
				public $offered= "";
				public $description= "";
				public $prereq= "";
				public $coreq= "";
				public $notes= "";
				public $isGood = false;
				public $isElective = false;
			}
			
			//open and read in the student xml file
			
			$takenClasses = readStudentFile();

			//got a 1d array of taken classes contaning Course object
			
			$flowList = getFlowChart();
			//the flowchart is in a 2d array seperated by each semester
	
			//get a list of all the electives
			$electives = getElectives();
	
			//so i got all the electives in a 1d array
			
			//go through taken array find the recomended classes that
			//the student can taken
			$recList = array();
			
			//go through the taken array
			$arr = array();
			
			
			foreach($takenClasses as $subject){
				$temp = key($takenClasses);
				$temp2 = explode(" ",$temp);
				
				//if it CSC course, eg Freshman, Softemore, ...
				if($temp2[0] == "CSC"){
					//if it is an elective
					if($temp2[1] == "Electives"){
						//cleans out the taken electives
						foreach($subject as $course){
							//remove the taken electives from the electives array
							$key = array_search((string)$course, $electives["CSC"]);
							unset($electives["CSC"], $key);
						}
					}else{
						foreach($subject as $course){
							if(isInFlowChart((string)$course)){
								$arr = getReqs((string)$course);
						
								//then put the post reqs into an recList array in the CSC Required array
								if(!empty($arr['postreq'])){
									foreach($arr['postreq'] as $class){
										$recList['CSC Required'][] = $class;
									}
								}
							}
						}
					}
				}
			}
			
		
			
			//find how many classes the person has taken
			//get the number of classes that they completed
			//depending on that number filter out the electives that they can take
			//after the list is made check if the student can take those classes
				//using the prereq 
				//yes they are eligible
					//then add it to the recList
				//no then don't add to recList
			//get # of classes taken
			
			$uname = $_SESSION['$uname'];
		
			$file = "users/".$uname.".xml";
			$student= simplexml_load_file($file) or die("could not open users file");
			$numClassesTaken = $student->completed + $student->inprogress;
			
			//if the student hasn't taken all csc electives 
			if(count($takenClasses['CSC Electives'] < 4)){
				//go through all the electives and suggest all possible electives
				//suggest all electives over 300
				if(checkTakenClass($takenClasses['CSC Sophomore'],"CSC 300")){
					foreach($electives['CSC'] as $class){
						$temp = explode(" ", $class);
						if($temp[1] > 300){
							//get the reqs
							//check if the student can take the class
							$reqArr = getReqs((string)$class);
							if(!empty($reqArr['prereq'])){
								//check if the person can take the class
								foreach($reqArr['prereq'] as $req){
									if(!in_array($req,$takenClasses['CSC Electives'])){
										$recList["CSC Electives"][] = $class;
									}
								}
							}
							
						}
					}	
				}else{
					//suggest elective classes if the person hasnt taken csc 300
					foreach($electives['CSC'] as $class){
						$temp = explode(" ", $class);
						if($temp[1] < 300 && $temp[1] >= 200){
							$recList["CSC Electives"][] = $class;
						}
							
					}
				}
			}
			$recList['CSC Electives'] = array_unique($recList['CSC Electives']);
			//get the current date
			//find out what the months are and the year
			//go through and filter out all the electives that are not offered
			//during the next semester
			$today = getdate();
		
			
			if(count($takenClasses['CSC Freshman']) == 0 &&
			count($takenClasses['CSC Sophomore']) == 0 &&
			count($takenClasses['CSC Junio']) == 0 &&
			count($takenClasses['CSC Senior']) == 0){
				$recList["CSC Required"][] = "CSC 150";
				$recList["CSC Required"][] = "CSC 110";
			}
			
			//go through the required array and see if each class is elegible to be
			//taken
			//this is after getting all the post req classes that are
			//avaliable	
			//filter out the already taken suggested required classes
			//check if you already took that class
			foreach($recList['CSC Required'] as $class){
				if(checkTakenClass($takenClasses,$class)){
					
					//remove the taken class from the recList
					$temp = array_search((string)$class,$recList['CSC Required']);
					unset($recList['CSC Required'][$temp]);
				}
			}
			

			//not take out the classes form the recList that the student 
			//is not eleigable to take
			foreach($recList['CSC Required'] as $class){
				$reqs = getReqs((string)$class);
				$isGood = true;
				
				//if it has prerteqs check the prereqs to see is the student is good
				if(!empty($reqs['prereq'])){
					foreach($reqs['prereq'] as $req){
	
						//if any prereqs are not taken then you can't take that class
						if(!checkTakenClass($takenClasses,(string)$req)){
							$isGood = false;
				
						}
					}
					//if the student did not complete all the prereqs then remove
					//the class from the suggested list
					if(!$isGood){
						$temp = array_search((string)$class,$recList['CSC Required']);
						unset($recList['CSC Required'][$temp]);
					}
				}
			}
			
			//filter out the the unwanted classes or duplicates
			$recList['CSC Required'] = array_diff($recList['CSC Required'], $electives["CSC"]);
		
			$recList['CSC Required'] = array_unique($recList['CSC Required']);
			

			
			//other classes such as english and math are in this array
			foreach($recList['CSC Required'] as $class){
				$temp = explode(" ",(string)$class);
	
				if($temp[0] == "MATH"){
					$recList['Math'][] = $class;
				}
				if( $temp[0] == "ENGL"){
					$recList['English'][] = $class;
				}
			}
			$recList["CSC Required"] = array_diff($recList["CSC Required"],$recList["Math"]);
			$recList["CSC Required"] = array_diff($recList["CSC Required"],$recList["English"]);

			
			//same for the electives
	
				//if it is an MATH class
					//yes
						//go through the electives array and see if the person took it	
							//yes 
								//remove class from the electives array
							//no 
								//nothing
					//no	
						//check the flow chart to see if the person has took the class
							//yes 
								//find the post reqs from the prereqs.xml file
								//add that classes to the recomended list
							//no 
								//check the prereqs and see if the student qualifies
									//yes
										//add that class to the list
									//no 
										//don't add that to the list
											
			foreach($takenClasses["Math"] as $subject){
				$temp = key($subject);
				$temp2 = explode(" ",$temp);
				if($temp2[1] == "Electives"){
					//cleans out the taken electives
					foreach($subject as $course){
						//remove the taken electives from the electives array
						$key = array_search((string)$course, $electives["MATH"]);
						unset($electives["MATH"], $key);
					}
				}else{
					foreach($subject as $course){
						if(isInFlowChart((string)$course)){
							$arr = getReqs((string)$course);
							//then put the post reqs into an recList array in the CSC Required array
							
							$recList['Math'][] = $course;
						}
					}
				}
			}
	
			//go through the math classes and see if the person hasn't taken a math elective
			//then check to see if the student is qualifies to do so
			//only check higher level math electives such as > 400
			
			foreach($student->courses as $subject ){
				if((string)$subject->subname == "Math"){
					foreach($subject as $course){
						if((string)$course->name == "MATH Elective"){
							//check if there is a grade
							if($course->grade == NULL){
								//suggest math elective 
								foreach($electives['MATH'] as $class){
									$temp = explode(" ", $class);
									if($temp[1] >= 400){
										$recList['Math'][] = $class;
									}
								}
							}
						}
					}
				}
			}
			
			//if there is not math classes in the taken array
			if(count($takenClasses['Math']) == 0){
				$recList["Math"][] = "MATH 123";
			}
			
			//go through the math array and see if the person has taken the
			//class already
			$recList["Math"] = array_diff($recList["Math"],$takenClasses['Math']);
				//is it a science class
					//check the size of the Science class array in taken
					//if the array is less than 3 and PHYS 211 hasn't been taken 
						//yes 
							//suggest PHYS 211
					//if the array size is < 3 and that PHYS 211 is taken
						//yes
							//suggest a Science class
				if(count($takenClasses['Science']) < 3 && !checkTakenClass($takenClasses,"PHYS 211")){
					$recList['Science'][] = "PHYS 211";
				}else if(count($takenClasses['Science']) < 3 && checkTakenClass($takenClasses,"PHYS 211")){
					$recList['Science'][] = "Natural Science Course";
				}
							
				//is it a gen ed class
					//yes
						//check the size of the Gen Ed Array in taken
						//if it is smaller than size 5 
							//yes 
								//add a ART/HUM/SS to the req list
				if(count($takenClasses['Gen Ed']) < 5){
					$recList['Gen Ed'][] = "Art/Humanities/Social Science Course";
				}
				if(count($takenClasses['English']) == 0){
					$recList['English'][] = "ENGL 101";
				}
				//is it a free class
					//yes
						//check the size
						//if smaller than 2 than two and (if # of gen eds are >= 5 and if # of CSC electives are >=4
							///sugest a free elective 
				if(count($takenClasses['Free Electives'] < 2 &&
					count($takenClasses['Gen Ed']) >= 6 && 
					count($takenClasses['CSC Electives']) >= 4 )){
						$recList['Free Electives'][] = "Free Elective Course";
					}
				
			//take out all the classesfrom rec list 
			
			
			
	//print the courses to the page	
	printCourses($recList);
			
			
	/*============================================================================
		Functions
	============================================================================*/
	/* 
		Name: readStudentFile
		reads in the student's xml file and returns a array of Course objects of
		taken classes
		returns - array of Course Objects with all info assigned
	*/
	function readStudentFile(){
		
		$uname = $_SESSION['$uname'];
		$taken = array();
	
		$file = "users/".$uname.".xml";
		$student = simplexml_load_file($file) or die("could not open user s file");
		
		foreach($student->courses as $courses){
			foreach($courses->children() as $subject){
				$taken["$subject->subname"] = array();
				foreach($subject->course as $course){
					
					$grade = $course->grade;
					$status = $course->status;
					
					//check if the person has taken it
					if($grade == 'A' || $grade == 'B' || $grade == 'C' || $grade == 'D' || $grade == "inprog" || $grade == 'EX' ){
						$className = $course->name;
						$taken["$subject->subname"][] = $className;
						
					}
				}
			}
		}
		return $taken;
	}
	
	
	/**********************************************************************
		Name: readInClassInfo
		params:
			$class - a string of the class to look for eg CSC 150
	*********************************************************************/
	function readInClassInfo($className){
		$file = "courses.xml";
		$courses = simplexml_load_file($file) or die("could not courses open file");
		$temp = explode(" ",$className);
		
	
		foreach($courses as $course){
			//foreach($course as $class){
			//check  if its the same subject
				if($course->prefix == $temp[0] && $course->number == $temp[1]){
					
					//check if it is the same class name
					$tempCourse = new Course();
					//get all the information 
					$tempCourse->isactive = (string)$course->attributes()->isactive;
					
					$tempCourse->prefix = $course->prefix;
					$tempCourse->number = $course->number;
					$tempCourse->name = $course->name;
					$tempCourse->credits = $course->credits;
					$tempCourse->offered = $course->offered;
					$tempCourse->description= $course->description;
					$tempCourse->prereq = $course->prereq;
					$tempCourse->coreq = $course->coreq;
					$tempCourse->notes = $course->notes;
				
					return $tempCourse;
				}
			//}
			
		}
		return NULL;
	}
	
	/*****************************************************************
		getElectives
			finds all the electives that are in the courses.xml file
	******************************************************************/
	function getElectives(){
		$file = "courses.xml";
		$courses = simplexml_load_file($file) or die("could not courses open file");
		$electives = array();
		
		foreach($courses->children() as $course){
			
			//checks if the course is active
			//if($course['isactive'] == "yes"){
				$class = $course->prefix." ".$course->number;
				
				if(!isInFlowChart($class)){
					if($course->prefix == "CSC"){
						$electives["CSC"][] = $class;
					}else if($course->prefix == "MATH"){
						$electives["MATH"][] = $class;
					}
					
				}
			//}
		}
		
		return $electives;
	}
	
	/*
		isInFlowChart
		checks if a class is in the flow chart or a required scified class
	*/
	function isInFlowChart($class){	
		$file = "flowchart.xml";
		$flowchart = simplexml_load_file($file) or die("could flow not open file");
		
		foreach($flowchart->semester as $semester){
			foreach($semester->course as $course){
				if($class == $course){
			
					return true;
				}
			}
		}
		
		return false;
	}
	

	/*
		getFlowChart
			reads in the flowchart xml file and returns a 2d array
			of each semster classes
	*/
	function getFlowChart(){
		$file = "flowchart.xml";
		$flowchart = simplexml_load_file($file) or die("could not open flow file");
		$flowList = array();
		
		foreach($flowchart->semester as $semester){
			$flowList["$semester->number"] = array();
			foreach($semester->course as $course){
				$flowList["$semester->number"][] = $course;
			}
		}
		return $flowList;
	}
	
	/*
		checkTakenClass
		checks if the student took a class
	*/
	function checkTakenClass($takenList, $class){
		foreach($takenList as $subject){
			foreach($subject as $course){
				if((string)$class == (string)$course){
					return true;
				}
			}
		}
		return false;
	}
	
	/*
		reads in all the pre,co,and post reqs for a class 
		returns an array of all the prereq
	*/
	function getReqs($class){
		$xml = simplexml_load_file("prereqs.xml");
		
	
		$arr = array();
		
		foreach($xml as $subject){
			foreach($subject->course as $course){
		
				
				$name = $course->name;
				if($class == $name ){
					//get the pre reqs
					foreach($course->prereq as $pre){
						$arr["prereq"] = array();
						foreach($pre->children() as $c){
							
							$arr["prereq"][] = $c;
						}
					}
					//get the post reqs
					foreach($course->postreq as $post){
						$arr["postreq"] = array();
						foreach($post->children() as $c){
							
							$arr["postreq"][] = $c;
						}
					}
					//get the co reqs
					foreach($course->coreq as $co){
						$arr["coreq"] = array();
						foreach($co->children() as $c){
						
							$arr["coreq"][] = $c;
						}
					}
				}
			
			}
		}
		//var_dump($arr);
		return $arr;
	}
		class OfferedStatus{
			private $isSpring = false;
			private $isFall = false;
			private $isEven = false;
			private $isOdd = false;
			
			
		}
	
		function checkOffered($class){
			
			$file = "courses.xml";
			$courses = simplexml_load_file($file) or die("could not open course file");
			foreach($courses as $course){
				$temp = $course->offered;
				$temp = explode(", ",$off);
				$offered = new OfferedStatus();
				
				//for each offering
				foreach($temp as $word){
					//check if it is offered in the fall
					if(strtolower($word) == "spring"){
						$offered->isSpring = true;
					}
					if(strtolower($word) == "fall"){
						$offered->isFall = true;
					}
					if(strtolower($word) == "odd"){
						$offered->isEven = true;
					}
					if(strtolower($word) == "even"){
						$offered->isOdd = true;
					}
				}
				
			}
		}

	/*
		printClasses
		print the classes to the screen as different tables
	*/
	function printCourses($classList){
		//go through the classList and for each subject print
		//out all the classes that can be taken

		//print out the header of the page
		echo "<h1 align='center'>Course Recomendations</h1>";
		//go through each recList subject 
		
		foreach($classList as $subject=>$arr){
			
			//get the name of the key
			$subName = (string)$subject;
			//var_dump($arr);
			//print out the table header info
			echo "<table width='100%'>
					<h2 align='center'>$subName</h2>
					<tr>
						<th>Course Number</th>
						<th>Course Name</th>
    					<th>Description</th>
    					<th>Credits</th>
    					<th>Offered</th>
    					<th>Available</th>
  					</tr>";
			//go through each class
			foreach($arr as $course){
				
				//go through the list and get the info of the class
				//output only the classes that have info
				//if they don't have info then just output the name with
				
				$classInfo = readInClassInfo((string)$course);
				//var_dump($classInfo);
				if($classInfo != NULL){
					//class info is in the description 
					//$class info returns a Course object with filled out 
					//info
					$number = (string)$classInfo->prefix.' '.$classInfo->number;
					$name = (string)$classInfo->name;
					$descript = $classInfo->description;
					$credits = $classInfo->credits;
					$offered = $classInfo->offered;
					$isActive = $classInfo->isactive;
					echo "<tr>
							<td width='10%' align='center'>$number</td>
							<td width='15%' align='center'>$name</td>
							<td width='45%' align='left'>$descript</td>
							<td width='10%' align='center'>$credits</td>";
							
					if($offered == ""){
						echo "<td width='10%' align='center'>Every Fall and Spring</td>";
					}else{
						echo "<td width='10%' align='center'>$offered</td>";
					}
					if((string)$isActive == "yes"){
						echo "<td width='10%' align='center'>yes</td>";
					}else{
						echo "<td width='10%' align='center'>no</td>";
					}			  			
		  				echo"</tr>";
				}else{//the class isn't in the description
					echo "<tr>
							<td width='25%' colspan='2' align='center' align='center'>$course</td>
							<td width='45%' align='center'>N/A</td>
							<td width='10%' align='center'>3-4</td>";
						echo "<td width='10%' align='center'>Every Fall and Spring</td>";
						echo "<td width='10%' align='center'>yes</td>";
		  				echo "</tr>";
				}
			}
			echo "</table>";
			echo "<br>";
		}
		
	}
?>
	</body>
</html>
