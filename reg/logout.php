<?php
session_start(); 

session_destroy();
	// $_SESSION['username'] = null;
	$_SESSION['auth'] = null;

header('Location: index.php'); 
die(); 
?>