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
<title>Home - <?php echo $userRow['Email']; ?></title>
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
<a href="cart.php"><img id = "img_card" src="img/card.png" width="50" height="50" alt="" /></a></div>
</div>

<div id = "checkout">
<a href="checkout.php"><img id = "img_checkout" src="img/btn_yellow_checkout.png" width="130" height="50" alt=""/></a></div>
</div>
<div id="body">
<form method="GET" action="index.php" >
 Type  of Movies : 
<select name="genre">
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
	<form method="GET" action="index.php" >

 Year of Movies : 
<select name="year">
  <option value="">ALL</option>
  <option value='2016'>2016</option>
  <option value='2015'>2015</option>
  <option value='2014'>2014</option>
  <option value='2013'>2013</option>
  <option value='2012'>2012</option>
  <option value='2011'>2011</option>
  <option value='2010'>2010</option>
  <option value='2009'>2009</option>
  <option value="2008">2008</option>
  <option value="2007">2007</option>
  <option value="2006">2006</option>
  <option value="2005">2005</option>
  <option value="2004">2004</option>
  <option value="2003">2003</option>
  <option value="2002">2002</option>
  <option value="2001">2001</option>
  <option value="2000">2000</option>
  </select><br />
  
   The price of Movies : 
<select name="price">
  <option value="">ALL</option>
  <option value='3'>3</option>
  <option value='6'>6</option>
  <option value='9'>9</option>
  </select>
<input type="submit" class="button" value="Search" />
 </form>
</div>
<div id="body">
<table width="200" border="1">
  <tbody>
  <?php
$tableName="countries";
$targetpage = "index.php";
$limit = 4;

$query = "SELECT COUNT(*) as num FROM movies";
$total_pages = mysql_fetch_array(mysql_query($query));
$total_pages = $total_pages[num];

$stages = 3;
$page = mysql_escape_string($_GET['page']);
if($page){
$start = ($page - 1) * $limit;
}else{
$start = 0;
}

// Get page data
$query1 = "SELECT * FROM movies LIMIT $start, $limit";
$result = mysql_query($query1);

// Initial page num setup
if ($page == 0){$page = 1;}
$prev = $page - 1;
$next = $page + 1;
$lastpage = ceil($total_pages/$limit);
$LastPagem1 = $lastpage - 1;

$paginate = '';
if($lastpage > 1)
{

$paginate .= "<div class='paginate'>";
// Previous
if ($page > 1){
$paginate.= "<a href='$targetpage?page=$prev'>previous</a>";
}else{
$paginate.= "<span class='disabled'>previous</span>"; }

// Pages
if ($lastpage < 7 + ($stages * 2)) // Not enough pages to breaking it up
{
for ($counter = 1; $counter <= $lastpage; $counter++)
{
if ($counter == $page){
$paginate.= "<span class='current'>$counter</span>";
}else{
$paginate.= "<a href='$targetpage?page=$counter'>$counter</a>";}
}
}
elseif($lastpage > 5 + ($stages * 2)) // Enough pages to hide a few?
{
// Beginning only hide later pages
if($page < 1 + ($stages * 2))
{
for ($counter = 1; $counter < 4 + ($stages * 2); $counter++)
{
if ($counter == $page){
$paginate.= "<span class='current'>$counter</span>";
}else{
$paginate.= "<a href='$targetpage?page=$counter'>$counter</a>";}
}
$paginate.= "...";
$paginate.= "<a href='$targetpage?page=$LastPagem1'>$LastPagem1</a>";
$paginate.= "<a href='$targetpage?page=$lastpage'>$lastpage</a>";
}
// Middle hide some front and some back
elseif($lastpage - ($stages * 2) > $page && $page > ($stages * 2))
{
$paginate.= "<a href='$targetpage?page=1'>1</a>";
$paginate.= "<a href='$targetpage?page=2'>2</a>";
$paginate.= "...";
for ($counter = $page - $stages; $counter <= $page + $stages; $counter++)
{
if ($counter == $page){
$paginate.= "<span class='current'>$counter</span>";
}else{
$paginate.= "<a href='$targetpage?page=$counter'>$counter</a>";}
}
$paginate.= "...";
$paginate.= "<a href='$targetpage?page=$LastPagem1'>$LastPagem1</a>";
$paginate.= "<a href='$targetpage?page=$lastpage'>$lastpage</a>";
}
// End only hide early pages
else
{
$paginate.= "<a href='$targetpage?page=1'>1</a>";
$paginate.= "<a href='$targetpage?page=2'>2</a>";
$paginate.= "...";
for ($counter = $lastpage - (2 + ($stages * 2)); $counter <= $lastpage; $counter++)
{
if ($counter == $page){
$paginate.= "<span class='current'>$counter</span>";
}else{
$paginate.= "<a href='$targetpage?page=$counter'>$counter</a>";}
}
}
}

// Next
if ($page < $counter - 1){
$paginate.= "<a href='$targetpage?page=$next'>next</a>";
}else{
$paginate.= "<span class='disabled'>next</span>";
}

$paginate.= "</div>";

}
//echo $total_pages.' Results';
// pagination


if(empty($_GET["genre"]) && empty($_GET["year"]) && empty($_GET['price'])){$result = mysql_query("SELECT * FROM movies  LIMIT $start, $limit");} 
else{ $result = mysql_query("SELECT * FROM movies  WHERE Category='".$_GET["genre"]."' or Year='".$_GET["year"]."' or Price='".$_GET["price"]."'");}
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
      <td><?php if($row["Copies"]>0){echo $row["Copies"] . " Copies";} else {echo $row["Copies"] . " Copy";}?></td>
      <td><?php $image = $row["Image"];
		echo '<img src="' . $image . '" width="230" height="345" alt="" title="'.$row['Description'].'">' . "<br>"; ?></td>
      <td>
      <?php if(isset($userRow["Privileges"]) && $userRow['Privileges'] != "3") {
	  if($row["Copies"]>0){ ?> 
      <a href="additem.php?MovieID=<?php echo $row["MovieID"]; ?>&price=<?php echo $row["Price"]; ?>">Add to cart</a>
      <?php }else {echo "Not available now"; }?>
      </td>
    </tr> 
    <?php } } ?>
  </tbody>
</table>
<?php echo $paginate;?>
</div>	
</div>
</body>
</html>