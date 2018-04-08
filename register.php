<?php
session_start();
if(isset($_SESSION['user'])!=""){
	header("Location: index.php");
}
include_once 'dbconnect.php';

if(isset($_POST['btn-signup'])){
	$uname = mysql_real_escape_string($_POST['uname']);
	$email = mysql_real_escape_string($_POST['email']);
	$upass = md5(mysql_real_escape_string($_POST['pass']));
	$genre = mysql_real_escape_string($_POST['genre']);
	
	$uname = trim($uname);
	$email = trim($email);
	$upass = trim($upass);
	$genre = trim($genre);

	
	// email exist or not
	$query = "SELECT Email FROM users WHERE Email='$email'";
	$result = mysql_query($query);
	
	$count = mysql_num_rows($result); // if email not found then register
	
	if($count == 0){
		
		if(mysql_query("INSERT INTO users(Username,Email,Password, privileges, Genre) VALUES('$uname','$email','$upass',1, '$genre')")){
			?>
			<script>alert('Successfully registered');</script>
            <?php
			header("Location: login.php");
			?>
			<?php
			
		}
		else{
			?>
			<script>alert('Error while registering you...');</script>
			<?php
		}		
	}
	else{
			?>
			<script>alert('Eorry Email ID already taken ...');</script>
			<?php
	}
	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login</title>
<link rel="stylesheet" href="CSS/style.css" type="text/css" />
<link rel="icon" href="img/bag.png">

</head>
<body>
<center>
<div id="login-form">
<form method="post">
<table align="center" width="30%" border="0">
<tr>
<td><input type="text" name="uname" placeholder="User Name" required /></td>
</tr>
<tr>
<td><input type="email" name="email" placeholder="Your Email" required /></td>
</tr>
<tr>
<td><input type="password" name="pass" placeholder="Your Password" required /></td>
</tr>
<tr>
<td>
<select name="genre" requited >
  <option value="">ALL</option>
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
</tr>
<tr>
<td><button type="submit" name="btn-signup">Sign Me Up</button></td>
</tr>
<tr>
<td><a href="login.php">Sign In Here</a></td>
</tr>
</table>
</form>
</div>
</center>
</body>
</html>