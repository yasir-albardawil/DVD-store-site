<?php
session_start();

$MovieID = $_GET['MovieID'];

$Price = $_GET['price'];


if(isset($_SESSION["user"])){
	$c = $_SESSION["count"];
    $_SESSION["buy"][$c] = $MovieID;
	
	$_SESSION["count"] -= 1;
	
     $_SESSION["total"] -= $Price;
	
	header("location: cart.php?item$c");
}
else{
  header("location: register.php");
}

?>