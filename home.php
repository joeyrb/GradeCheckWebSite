<?php
	// Load the XML file and read the first name, last name, and student ID
	// $q = $_REQUEST["q"];
	session_start();
	$uname = $_SESSION['$uname'];
	$filename = './users/' . $uname . '.xml';
	$userxml = simplexml_load_file($filename) or die("Error: Cannot create object");
	// echo $uname;
	// echo $userxml->name->first . " " . $userxml->name->last;
    echo $userxml->studentid;

	// $xml=simplexml_load_file("newstudent.xml") or die("Error: Cannot create object");
	// $xml=simplexml_load_file("./users/7110007.xml") or die("Error: Cannot create object");
	// echo $xml->name->first . " ";
	// echo $xml->name->last . "<br>";
	// echo $xml->studentid . "<br>";
	// $fname = $xml->name->first;
  	// $lname = $xml->name->last;
  	// $ID = $xml->studentid;
	// $stuInfo = array("$fname", "$lname", "$ID");
	// $a = array('INFO' => array("$fname", "$lname", "$ID"));

	// $a = array('INFO' => $stuInfo);

	// // Loop through the array and get all of the course info on the prefix and number
	// $arrCSC = array();
	// foreach ($xml->courses->subject->children() as $courses) {
	// 	// // Both of these are used to build the table of prefix and number
	// 	if($courses->prefix != "" && $courses->number != "") {
	// 		// echo $courses->prefix . " ";
	// 		// echo $courses->number . "<br>";	
	// 		// $prefix = $courses->prefix;
	// 		$number = $courses->number;
	// 		// array_push($a, "$prefix");
	// 		// array_push($a, "$number");
	// 		array_push($arrCSC, $number);
	// 	}
		
	// }
	// echo $q;
	// echo json_encode($stuInfo);
	//$b = array('CSC' => $arrCSC );
	// array_push($a, $b);
	//echo json_encode($a);
	// echo "<br> <br>";

	// $arrMATH = array();
	// foreach ($xml->courses->subject[1]->children() as $courses) {
	// 	if($courses->prefix != "" && $courses->number != "") {
	// 		echo $courses->prefix . " ";
	// 		echo $courses->number . "<br>";	
	// 	}
	// }

	// $arrPHYS = array();
	// foreach ($xml->courses->subject[2]->children() as $courses) {
	// 	if($courses->prefix != "" && $courses->number != "") {
	// 		echo $courses->prefix . " ";
	// 		echo $courses->number . "<br>";	
	// 	}
	// }

	// $arrENGL = array();
	// foreach ($xml->courses->subject[3]->children() as $courses) {
	// 	if($courses->prefix != "" && $courses->number != "") {
	// 		echo $courses->prefix . " ";
	// 		echo $courses->number . "<br>";	
	// 	}
	// }

  // // Load the XML file or quit with error message
  // $xml=simplexml_load_file("newstudent.xml") or die("Error: Cannot create object");
  // $fname = $xml->name->first;
  // $lname = $xml->name->last;
  // $ID = $xml->studentid;

  // // if the request from the client is equal to the xml first name then display the 
  // // student ID
  // $q = $_REQUEST["q"];
  // if ($q == $fname) {
  //   echo $ID;
  // } else {
  //   echo "No match";
  // }
?>
