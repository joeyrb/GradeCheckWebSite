<?php
	
	session_start();
	$uname = $_SESSION['$uname'];
	$filename = './users/' . $uname . '.xml';
	$userxml = simplexml_load_file($filename) or die("Error: Cannot create object");
    
	foreach ($userxml->courses->children() as $courses) {
		echo $courses->subject->name . " ";
	}
	echo $userxml->courses->subject->course->name;
?>