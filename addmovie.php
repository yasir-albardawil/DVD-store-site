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
<title>Add movie - <?php echo $userRow['Email']; ?></title>
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
            &nbsp;<a  href="cpanel.php"> Cpanel</a>
			&nbsp;<a  href="logfile.php"> Log File </a>
		<?php } ?>

		<?php if(empty($_SESSION["user"]))  {?> 
			&nbsp;<a  href="login.php"> Sign In </a>
			&nbsp;<a  href="register.php"> Sign Up </a>
		<?php } else {?>
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
	<td>
	<input type="hidden" name="movieid" placeholder="Movie ID" />
	</td>
	<td>
	Name:<input type="text" name="name" placeholder="Name" required />
	</td>
	<td>
	Price:<br><select name="price" required >
	<option value="">--------------------</option>
    <option value="3">3 SAR</option>
    <option value="6">6 SAR</option>
    <option value="9">9 SAR</option>
	</select>
	</td>
	<td>
	Copies:<input type="number" name="copies" placeholder="Copies" required />
	</td>
	<tr>
	<td>
	Category:<br>
    <select name="category" required>
		<option value="">--------------------</option>
  		<option value="1">Action</option>
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
    <td>Year: <input type="number" name="year" placeholder="Year"  /></td>
	<td>
	Description:<br><textarea rows="4" cols="50" name="description" placeholder="Description of the movie" required > </textarea>
	</td>
	<td>
	<input type="file" name="image" required />
	</td>
	<td>
	<input type="submit" name="sent" value="Send" class="button" />
	</td>
	</tr>
	</form>		
    <?php
	$Name = $_POST['name'];
	$Catergory = $_POST['category'];
	$Description = $_POST['description'];
	$Price = $_POST['price'];
	$Copies = $_POST['copies'];
	$year = $_POST['year'];
	$Image = "img/" . $_POST['image'];
	
		$sql = "INSERT INTO movies (MovieID, Name, Category, Description, Price, Copies, Year, Image) VALUES 			(null,'$Name',$Catergory,'$Description',$Price,$Copies, $year, '$Image')";
		
		
	if($_POST['sent'] == true) {
	if(!mysql_query($sql)) {
	echo "error " . mysql_errno(); } else {
		echo "Done!";
	}	
	}
	?>
 
</div>
</body>
</html>