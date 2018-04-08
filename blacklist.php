<?php
session_start();
include_once 'dbconnect.php';

$res=mysql_query("SELECT * FROM users WHERE UserID=".$_SESSION['user']);
$userRow=mysql_fetch_array($res);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Blacklist - <?php echo $userRow['Email']; ?></title>
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
            
        <?php if(isset($_GET['unblock'])) {mysql_query("UPDATE users SET Privileges='1' WHERE UserID='$_GET[unblock]'"); 
		logfile(" UnBlocked a user"); } 

if(isset($_GET['block'])) {mysql_query("UPDATE users SET Privileges='3' WHERE UserID='$_GET[block]'"); } logfile(" Blocked a user");  ?>
		
		<?php if(empty($_SESSION["user"])) { ?>
			&nbsp;<a  href="index.php"> Login </a>
			&nbsp;<a  href="register.php"> Sign up </a>
		<?php } else {?>
        &nbsp;<a  href="returnmovie.php"> Return movies </a>
        &nbsp;<a  href="settings.php"> Settings </a>
		&nbsp;<a href="logout.php?logout">Sign Out</a>
		
		<?php } ?> 		
	<!--------------------------------------------------->   
        </div>
    </div>
</div>
</div>
<div id="body">
<table width="200" border="1">
    <?php $result = mysql_query("SELECT * FROM users");
	while($row = mysql_fetch_assoc($result)){ ?>
  <tbody>
	<tr>
    	<td><?php echo $row['Username']?></td>
        <td><?php 
		if($row["Privileges"]==3){ ?><a href="blacklist.php?unblock=<?php echo $row["UserID"]; ?>">Unblock</a> <?php
		 } else if($row["Privileges"]==1){ ?> <a href="blacklist.php?block=<?php echo $row["UserID"]; ?>">Block</a> 
		<?php } else {echo "Admin";} } } else {
		header("Location: home.php");
		}?>
		</td>
    </tr>
  </tbody>
</table>
</div>
</div>
</body>
</html>