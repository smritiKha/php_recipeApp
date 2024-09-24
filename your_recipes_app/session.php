<?php
	// start session
	ob_start();
	session_start();
	
	// set time for session timeout
	$currentTime = time() + 25200;
	$expired = 86400;
	
	// if session not set go to login page
	if (!isset($_SESSION['user'])){
		header("location:index.php");
		exit();
	}
	
	// if current time is more than session timeout back to login page
	if ($currentTime > $_SESSION['timeout']) {
		session_destroy();
		header("location:index.php");
		exit();
	}
	
	// destroy previous session timeout and create new one
	unset($_SESSION['timeout']);
	$_SESSION['timeout'] = $currentTime + $expired;

?>