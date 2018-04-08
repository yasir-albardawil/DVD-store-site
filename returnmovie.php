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
<title>Return movie - <?php echo $userRow['Email']; ?></title>
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
</div>
<div id="body">
<table width="200" border="1">
  <tbody>
   
  <?php 
  $Copies = $_GET['Copies'] + 1;
  if(isset($_GET['RentID'])) {mysql_query("DELETE FROM rent WHERE RentID='$_GET[RentID]'"); } 
  if(isset($_GET['MovieID'])) {mysql_query("UPDATE movies SET Copies = $Copies WHERE MovieID='$_GET[MovieID]'"); } 
  ?>

  <?php
$result = mysql_query(" SELECT * FROM rent r join movies m on r.MovieID = m.MovieID WHERE UserID =".$_SESSION['user']);
//one by one
while($row = mysql_fetch_array($result)){ 
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
			default: echo "Uncategorized";
		}?></td>
      <td><?php echo $row['Year'];?></td>
      <td><?php echo $row["Price"] . " SAR"; ?></td>
      <td><?php echo "Deadline<br>" .  date('Y-m-d H:i:s',$row["Time"]); ?></td>
      <td><?php $image = $row["Image"];
		echo '<img src="' . $image . '" width="230" height="345" alt="">' . "<br>"; ?></td>
      <td>
      <a href="returnmovie.php?RentID=<?php echo $row["RentID"]; ?>&MovieID=<?php echo $row["MovieID"]; ?>&Copies=<?php echo $row["Copies"]; ?>">Return the movie</a>
    </tr> 
    <?php } ?>
  </tbody>
</table>
</div>
</div>
</body>
</html>