<?php 
@include_once("./config.inc.php");
@include_once("./functions.inc.php");
header("Content-type:text/html;charset=utf-8"); 
$link = mysql_connect($DBSERVER, $DBUSER, $DBPASS)
or die("Can't connect" );
mysql_select_db($DB, $link) or die ("Can't select DB");
//mysql_query("SET NAMES utf8");

if(isset($_COOKIE['admmacilove']) AND $_COOKIE['admmacilove'] == 111111){


setcookie('admmacilove', '111111', time() + 3600 * 24 * 30, '/'); 


if($_POST['ok']){
$cat = $_POST['categories'];
$url = trim($_POST['url']);
$title = trim($_POST['title']);
$year = trim($_POST['year']);

mysql_query("INSERT INTO `video` VALUES(null,$cat, '".$title."', '".$url."', $year)");

echo 'ok';


}


}
else
header("Location: ../news/");

?>
<style>
input{
	width: 300px;
	height: 30px;
	font-size: 13px;
	margin: 5px 0;
}	
</style>
<form method="post" action="">
<select name="categories">
      <option selected="selected" value="0">iPad</option>
      <option value="1">iPhone</option>
      <option value="2">iPod</option>
      <option value="3">iMac</option>
      <option value="4">Macbook</option>
      <option value="5">OS X</option>
      <option value="6">На русском языке</option>
      <option value="7">Другое</option>
</select>
<br />
<input type="text" name="url" placeholder="url" autocomplete="off">
<br />
<input type="text" name="title" placeholder="title"  autocomplete="off">  
<br />
<input type="text" name="year" placeholder="year"  autocomplete="off"> 
<br />
<input type="submit" name="ok" value="ok"  autocomplete="off">
</form>












