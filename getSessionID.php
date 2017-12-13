<?php
	// From the terminal, run to enable:
	// 		$>sudo chown username && sudo chmod 644 getSessionID.php
	session_start();
	$uname = $_SESSION['$uname'];
	$filename = './users/' . $uname . '.xml';
	$userxml = simplexml_load_file($filename) or die("Error: Cannot create object with" . $uname);
    echo $userxml->studentid;
?>