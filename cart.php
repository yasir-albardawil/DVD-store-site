<?php
session_start();
include_once 'dbconnect.php';

if(isset($_SESSION['user'])) {
$res=mysql_query("SELECT * FROM users WHERE UserID=".$_SESSION['user']);
$userRow=mysql_fetch_array($res);
} else {$_SESSION['gusset'];}?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cart - <?php echo $userRow['Email']; ?></title>
<link rel="stylesheet" href="CSS/style.css" type="text/css" />
<link rel="icon" href="img/bag.png">
</head>
<body>
<div id="header">
	<div id="left">
    <a id = "text"  href="index.php"><label>DVD Store</label></a>
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
		&nbsp;<a href="logout.php?logout">Sign Out</a>
		<?php }?>
	<!--------------------------------------------------->     
        </div>
    </div>
</div>

<div id = "card">
<p id = "num_card" ><?php echo $_SESSION["count"]; ?></p>
<a href="cart.php"><img id = "img_card" src="img/card.png" width="50" height="50" alt=""/></a></div>
</div>

<div id = "checkout">
<a href="checkout.php"><img id = "img_checkout" src="img/btn_yellow_checkout.png" width="130" height="50" alt=""/></a></div>
</div>
<div id="body">
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
      <td><?php if($row["Copies"]>0){echo $row["Copies"] . " Copies";} else {echo $row["Copies"] . " Copy";} ?></td>
      <td><?php $image = $row["Image"];
		echo '<img src="' . $image . '" width="230" height="345" alt="">' . "<br>"; ?></td>
      <td>
      <?php if($row["Copies"]>0){ ?> 
      <a href="removeitem.php?MovieID=<?php echo $row["MovieID"]; ?>&price=<?php echo $row["Price"]; ?>">Remove Item </a>
      <?php }?>
      </td>
      
    </tr>
    <?php } ?>
    <?php $i++;} ?>
    <?php if($_SESSION['count']){?>
    Your shopping cart - <?php echo $_SESSION['count']?> item/items<br />
    Subtotal: <?php 
	if($_SESSION['total']>0 && $_SESSION['total']!=0)
	echo $_SESSION['total'] . " SAR" . "<br>"?>
    <a href="emptycart.php" id="empty_cart">Empty cart </a>
    <?php }}?>
    
  </tbody>
</table>
</div>
</div>
</body>
</html>