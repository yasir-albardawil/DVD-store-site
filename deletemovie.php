<?php
session_start();
include_once 'dbconnect.php';

if(isset($_SESSION['user'])) {
$res=mysql_query("SELECT * FROM users WHERE UserID=".$_SESSION['user']);
$userRow=mysql_fetch_array($res);
} else {$_SESSION['gusset'];}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Delete movie - <?php echo $userRow['Email']; ?></title>
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

<div id="menu">
<ul>
  <li><a href="cpanel.php">Home</a></li>
  <li><a href="addmovie.php">Add movie</a></li>
  <li><a href="update.php">Update movie</a></li>
  <li><a href="deletemovie.php">Delete movie</a></li>
</ul>
</div>
</div>
</div>
</div>
<div id="body">  
  <?php 
  $query = "SELECT * from movies";
	$result=mysql_query($query);?>
	<table width="200" border="1">
  <tbody>
    <tr>
	<td><?php echo "<form action='' method ='GET'><select
	name='MovieID'>";
	if($query){
		while($row = mysql_fetch_array($result)){
		echo "<option value = $row[MovieID]> $row[Name]</option>";
		} ?>
		<?php echo "</select> <input type='submit' /></form>";?></td>
	<?php } else {
		echo "No query!!";
	} 
	
	if(isset($_GET['MovieID'])) {
		$MovieID = $_GET['MovieID'];
		$query = "DELETE FROM movies WHERE MovieID = '$MovieID'";
		
		if(!mysql_query($query)){
			echo "Not Deleted!!";
		} else {
			echo "Deleted";
		}
	}
   ?>
    </tr>
   </tbody>
</table>
</div>

</body>
</html>