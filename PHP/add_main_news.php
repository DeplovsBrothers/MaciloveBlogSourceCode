<?php
@include_once("./config.inc.php");
@include_once("./functions.inc.php");
header("Content-type:text/html;charset=utf-8"); 
$link = mysql_connect($DBSERVER, $DBUSER, $DBPASS)
or die("Can't connect" );
mysql_select_db($DB, $link) or die ("Can't select DB");

if(isset($_COOKIE['admmacilove']) AND $_COOKIE['admmacilove'] == 111111){


setcookie('admmacilove', '111111', time() + 3600 * 24 * 30, '/'); 


if($_POST['ok']){
$url = explode('/',$_POST['url']);
$url = $url[4];
$ff = mysql_query("INSERT INTO `main_news` VALUES(null,'".$url."')");	
$idd = mysql_insert_id();
$del = mysql_query("DELETE FROM `main_news` WHERE `id`=".($idd-4));		
}

}
else
header("Location: ./news/apple-news/");

?>
<body>
<form method="post" action="">
<input type="text" name="url">
<input type="submit" name="ok">
</form>
</body>
