<?php
include_once('dbconnect.php');
session_start();

if(isset($_GET['logout'])){
		
	session_destroy();
	logfile(" Log Out  ");
	unset($_SESSION['price']);
	header("Location: index.php");
}
?>