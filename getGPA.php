<?php
	// Student ID is passed to this php file to be used to open the <id>.xml file
	// $q = $_REQUEST["q"];
	session_start();
	$uname = $_SESSION['$uname'];
	$filename = './users/' . $uname . '.xml';
	$userxml = simplexml_load_file($filename) or die("Error: Cannot create object");
	// echo $uname;
	// echo $userxml->name->first. " ";
    echo $userxml->gpa;
?>
