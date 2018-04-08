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
<title>Update movie - <?php echo $userRow['Email']; ?></title>
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
    <table>
	<form action="" method="post">
	<tr>
	<td><?php echo 'Movie ID: <input type="hidden" name="movieid" value="'.$_POST['movieid'].'" required>';?></td>
	<?php 
	$query = "SELECT * from movies where movieID = $_POST[movieid]";
	$result=mysql_query($query);
	$rowMovie = mysql_fetch_array($result);
	echo '<td>Name:<input type="text" value="'.$rowMovie['Name'].'" name="name" placeholder="Name" required/></td>';?>
	</td>
	<td>
	Price</br><select name="price" required>
    <option value="">--------------------</option>
    <?php if($rowMovie['Price'] == 3) {?>
    <option selected value="3">3 SAR</option>
    <option value="6">6 SAR</option>
    <option value="9">9 SAR</option>';
     <?php }?>
    <?php if($rowMovie['Price'] == 6) {?>
    <option value="3">3 SAR</option>
    <option selected value="6">6 SAR</option>
    <option value="9">9 SAR</option>'
 <?php }?>
    <?php if($rowMovie['Price'] == 9) {?>
    <option value="3">3 SAR</option>
    <option value="6">6 SAR</option>';
    <option selected value="9">9 SAR</option> <?php }?>
    </select>
	</td>
	<td>
	<?php echo 'Copies:<input type="number" value="'.$rowMovie['Copies'].'" name="copies" placeholder="Copies" required />';?>
	</td>
	<tr>
	<td>
	Category:<br><select name="category" required>
	<option value="">--------------------</option>
	<?php if($rowMovie['Category'] == 1){?>
    <option selected value="1">Action</option>
	<?php } ?>
    <option value="2">Comedy</option>
    <option value="3">Drama</option>
    <option value="4">Horror</option>
	<option value="5">Crime</option>
	<option value="6">Animation</option>
	<option value="7">Family</option>
	<option value="8">War</option>
	<option value="9">Documentary</option>
	<option value="10">Sport</option>
	</select>
	</td>
    <td>
    <?php echo 'Year:<input type="number" value="'.$rowMovie['Year'].'" name="year" placeholder="Year"  required/>';?>
	<td>
	<?php echo 'Description:<br><textarea rows="4" cols="50"  name="description" placeholder="Description of the movie" required> '.$rowMovie['Description'].' </textarea>';?>
	</td>
	<td>
	<input type="file" name="image"  />
	</td>
	<td>
	<?php echo '<input type="submit" name="update" value="Update" class="button" />';?>
	</td>
	</tr>
	</form>		
    <?php
	$movieID = $_POST['movieid'];
	$Name = $_POST['name'];
	$Catergory = $_POST['category'];
	$Description = $_POST['description'];
	$Price = $_POST['price'];
	$Copies = $_POST['copies'];
	$year = $_POST['year'];
	$Image = "img/" . $_POST['image'];
	
	
	$sql = "UPDATE `movies` SET  `Name` = '$Name',Category = '$Catergory', `Description` = '$Description', `Price` = '$Price', `Copies` = '$Copies', `Year` = '$year', `Image` = '$Image' WHERE `movies`.`MovieID` = $movieID;";
		
		
	if($_POST['update'] == true) {
	if(!mysql_query($sql)) {
	echo "error " . mysql_errno(); } else {
		echo "Updated!";
	}	
	}
	
	?>
 
</div>
</body>
</html>