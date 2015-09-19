<?php 
session_start();
@include_once("./config.inc.php");
@include_once("./functions.inc.php");

header("Content-type:text/html;charset=utf-8"); 
$link = mysql_connect($DBSERVER, $DBUSER, $DBPASS)
or die("Can't connect" );
mysql_select_db($DB, $link) or die ("Can't select DB");


if(isset($_COOKIE['admmacilove']) AND $_COOKIE['admmacilove'] == 111111){
setcookie('admmacilove', '111111', time() + 3600 * 24 * 30, '/'); 


if($_POST['add']){

$name = mysql_escape_string(trim($_POST['name']));
$url = mysql_escape_string(trim($_POST['url']));
$image = mysql_escape_string(trim($_POST['image']));
$was = mysql_escape_string(trim($_POST['was']));
$now = mysql_escape_string(trim($_POST['now']));
$ipad = $_POST['ipad'];

mysql_query("INSERT INTO `daily_deals` VALUES(0,'".$name."','".$url."','".$image."','".$was."','".$now."',".$ipad.")");
echo "ok";



}
else{
?>


<html>
<body>
<form acton="" method="post">
name: &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<input name="name" type="text">&nbsp&nbsp&nbspcategory:<select name="ipad">
      <option selected="selected" value="0">Игры для iPhone</option>
      <option value="1">Игры для iPad</option>
      <option value="2">Для iPhone и iPad</option></select>

<br /> 
url:  &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<input name="url" type="text"><br />
image: &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<input name="image" type="text"><br />
price was: &nbsp<input name="was" type="text"><br />
price now: <input name="now" type="text"><br />
<input name="add" type="submit">
</form>
</body>
</html>

<?php
}
}
else
header("Location: ../news/");





?>