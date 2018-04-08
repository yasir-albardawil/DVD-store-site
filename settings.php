<?php
session_start();
include_once 'dbconnect.php';
if(isset($_SESSION['user'])) {
$res=mysql_query("SELECT * FROM users WHERE UserID=".$_SESSION['user']);
$userRow=mysql_fetch_array($res);
} else {$_SESSION['guest'];}

checker();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Settings - <?php echo $userRow['Email']; ?></title>
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
<p id = "num_card" ><?php echo $_SESSION["count"]; ?></p>
<a href="cart.php"><img id = "img_card" src="img/card.png" width="50" height="50" alt=""/></a></div>
</div>

<div id = "checkout">
<a href="checkout.php"><img id = "img_checkout" src="img/btn_yellow_checkout.png" width="130" height="50" alt=""/></a></div>
</div>
<div id="body">
<?php $query = "SELECT Password FROM users WHERE UserID=".$_SESSION['user'];
	$result = mysql_query($query);
	
	while($passRow = mysql_fetch_array($result)){ 
	?>
    	
<form method="post">
<table width="80%" border="1">
  <tbody>
    <tr>
      <td>change password</td>
      <?php echo '<td><input type="password"  name= "inPassword" value="'.$passRow['Password'].'" required/></td>';?>
    </tr>
    
    <tr><td><input type="submit" value ="change" name="password" /></td></tr>
  </tbody>
</table>
<?php }
	$password = md5(mysql_real_escape_string($_POST['inPassword']));
	$password = trim($password);
	$sql = "UPDATE users SET Password = '$password' WHERE UserID='".$_SESSION['user']."'";
	
if($_POST['password'] == true) {
	if(!mysql_query($sql)) {
	echo "error " . mysql_errno(); } else {
		echo "Done!";
	}	
}
?>
</form>


<?php $queryEmail = "SELECT Email FROM users WHERE UserID=".$_SESSION['user'];
	$resultEmail = mysql_query($queryEmail);
	
	while($emailRow = mysql_fetch_array($resultEmail)){ 
	?>
    	
<form method="post">
<table width="80%" border="1">
  <tbody>
    <tr>
      <td>change email</td>
      <?php echo '<td><input type="email"  name="inEmail" value="'.$emailRow['Email'].'" required/></td>';?>
    </tr>
    
    <tr><td><input type="submit" value = "change" name="email"  /></td></tr>
  </tbody>
</table>
<?php }
	$email = mysql_real_escape_string($_POST['inEmail']);
	$email = trim($email);
	$sqlEmail = "UPDATE users SET Email = '$email'  WHERE UserID='".$_SESSION['user']."'";
	
if($_POST['email'] == true) {
	if(!mysql_query($sqlEmail)) {
	echo "error " . mysql_errno(); } else {
		echo "Done!!!";
	}	
}
?>
</form>
</div>	
</div>
</body>
</html>