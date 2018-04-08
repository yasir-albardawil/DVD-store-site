<?php
session_start();
$conn= include_once 'dbconnect.php';
if(empty($_SESSION['buy']) && $_SESSION['count'] == 0){
	header("Location: index.php");
}
if(!isset($_SESSION['user'])){
	header("Location: index.php");
}
$res=mysql_query("SELECT * FROM users WHERE UserID=".$_SESSION['user']);
$userRow=mysql_fetch_array($res);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Thank you for your order - <?php echo $userRow['Email']; ?></title>
<link rel="stylesheet" href="CSS/style.css" type="text/css" />
<link rel="icon" href="img/bag.png">
</head>
<body>
<div id="header">
	<div id="left">
    <a id="text"  href="index.php"><label>DVD Store</label></a>
    </div>
    <div id="right">
    	<div id="content">
        	<?php if(isset($_SESSION["user"]) && $_SESSION["user"]!="") {
			echo "Hi " . $userRow['Username'];} ?> 
        <?php if( isset($_SESSION["user"]) && $userRow["Privileges"]=="0" ){?>
            &nbsp;<a  href="blacklist.php"> Users privlages</a>
			&nbsp;<a  href="logfile.php"> Log File </a>
        	&nbsp;<a  href="cpanel.php"> Cpanel</a>
		<?php } ?>

		<?php if(empty($_SESSION["user"]))  {?> 
			&nbsp;<a  href="login.php"> Sign in </a>
			&nbsp;<a  href="register.php"> Sign up </a>
		<?php } else {?>
        &nbsp;<a  href="returnmovie.php"> Return movies </a>
        &nbsp;<a  href="settings.php"> Settings </a>
		&nbsp;<a href="logout.php?logout">Sign Out</a>
		<?php }?>
	<!--------------------------------------------------->   
        </div>
    </div>
</div>

<div id = "card">
<p id = "num_card" >0</p>
<a href="checkout.php"><img id = "img_card" src="img/card.png" width="50" height="50" alt=""/></a>
 </div>
</div>
<div id="body">

<button class="button" onclick="printFunction()">Print Invoice</button>
<h3><br />
  Thank you for your order Mr. <?php  echo $userRow['Username'] . " " ?></h3>
Congratulations! Your order has been placed.<br />
You will receive your order confirmation shortly.<br />
<script>
function printFunction() {
    window.print();
}
</script>
<table width="200" border="1">
  <tbody>
  <?php 
	if(isset($_SESSION["user"])){
		$i = 0;
		while($i < $_SESSION["count"]){
			 $id = $_SESSION["buy"][$i]; 
			$select = mysql_query("SELECT * FROM movies WHERE MovieID = ".$id."");
			while($row = mysql_fetch_array($select)) {
	?> 
    <tr>
      <td><?php echo "#" . $row["MovieID"]; ?></td>
      <td><?php echo $row["Name"]; ?></td>
      <td><?php switch ($row["Category"]){
			case 1: echo "Action";
			break;
			case 2: echo "Comedy";
			break;
			case 3: echo "Drama";
			break;
			case 4: echo "Horror";
			break;
			case 5: echo "Crime";
			break;
			case 6: echo "Animation";
			break;
			case 7: echo "Family";
			break;
			case 8: echo "War";
			break;
			case 9: echo "Documentary";
			break;
			case 10: echo "Sport";
			break;
			default: echo "Uncategorized";;
		} ?></td>
      <td><?php echo $row["Price"] . " SAR"; ?></td>
      <td><?php echo "Date<br />" . date('Y-m-d H:i:s');?></td>
      <td><?php $image = $row["Image"];
		echo '<img src="' . $image . '" width="230" height="345" alt="">' . "<br>"; ?></td>    
    
    <?php } ?>
    <?php $i++;} } ?>   
    </tr>
    <tr>
    <td colspan="3">Total: </td>
    <td colspan="3"><?php if($_SESSION["total"]>15){
		echo $_SESSION["total"]." SAR";
	} else {
		$total = $_SESSION["total"] +3;
		echo $total." SAR";
		
	}?> </td>
    <tr>
    <td colspan="6"><?php 
	 if($_SESSION["total"]>15){
	echo" Free Shipping";
	$_SESSION["total"]=0;
	}else{
		echo"Note :cost shipping 3 SR"; logfile(" rented a movie "); 
		$_SESSION["total"]=0;
	  } 
	?></td>
    <tr>
    </tr>
  </tbody>
</table>

<?php
$userID = $_SESSION["user"];
if(isset($_SESSION["user"])){
	$i = 0;
	$res=mysql_query("SELECT * FROM rent WHERE Invoice = (SELECT MAX(Invoice) FROM rent) LIMIT 1");
	$rentRow=mysql_fetch_array($res);
	$invoice = ++$rentRow['Invoice'];
	$time = time()+345600;
	while($i<$_SESSION["count"]){ 
	  $movieID = $_SESSION["buy"][$i];
	  mysql_query("UPDATE movies SET Copies=(Copies-1) WHERE MovieID=".$movieID."");
	  mysql_query("INSERT INTO rent (RentID, UserID, MovieID, Time,  Invoice) VALUES ('null',$userID,$movieID, '$time', '$invoice')");  
	  $i++;
	}
 
  $_SESSION["count"] = 0;
  $buy = array();
  $_SESSION["buy"] = $buy;

}else{
  header("location: index.php");
}
?>
</div>
</div>
</body>
</html>