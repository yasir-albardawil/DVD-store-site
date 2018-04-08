<?php
session_start();

$MovieID = $_GET['MovieID'];

$Price = $_GET['price'];


if(isset($_SESSION["user"])){
	$c = $_SESSION["count"];
    $_SESSION["buy"][$c] = 0;
	
	$_SESSION["count"] = 0;
	
     $_SESSION["total"] = 0;
	
	header("location: cart.php?empty$c");
}
else{
  header("location: index.php");
}

?>