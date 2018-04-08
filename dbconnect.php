<?php
error_reporting( E_ALL & ~E_DEPRECATED & ~E_NOTICE );
if(!mysql_connect("localhost","root","")){
	die('Oops connection problem ! --> '.mysql_error());
}
if(!mysql_select_db("dvd_store")){
	die('Oops database selection problem ! --> '.mysql_error());
}


function logfile($msg){
	if(isset($_SESSION['user'])) {
	$res=mysql_query("SELECT * FROM users WHERE UserID=".$_SESSION['user']);
	$userRow=mysql_fetch_array($res);
	}
	$file = fopen("logfile.php","r");
	$s = fread($file,filesize("logfile.php"));
	fclose($file);
	$da = date('l jS \of F Y h:i:s A');
	$file = fopen("logfile.php","w+");
	fwrite($file,$s. $userRow['Username']."  ".$msg." $da <br>");
	fclose($file);
}

function checker(){
	if(isset($_SESSION['user'])) {
		$res=mysql_query("SELECT * FROM rent WHERE userID=".$_SESSION['user']);
	    $rentRow=mysql_fetch_array($res);
		$start = time();
		$end =  $rentRow['Time'];
	
		if(!empty($end)){ 
		if($start>$end){
		mysql_query("UPDATE users SET Privileges='3' WHERE UserID='$_SESSION[user]'");
			} 
		}
		
	}
	
}

?>