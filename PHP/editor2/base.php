<?php 
@include_once("./../config.inc.php");
	
header("Content-Type: text/html; charset=utf-8"); 

$link = mysqli_connect($DBSERVER, $DBUSER, $DBPASS) or die("Can't connect");
$DB = 'Macilove';

mysqli_select_db($link,$DB) or die("Can't select DB");;
mysqli_set_charset($link, "utf8");

//mysql_query("SET NAMES UTF8"); // для русского текста в базе

$new_cat = 0;
$title = 'title';
$url = 'test1';
$cut = 'cut';
$description = 'desc';
$source = 'source';

$body = 'тест тест test';

$rows = mysqli_query($link,"INSERT INTO `articles` VALUES(null,".$new_cat.",'".$title."','".$body."', null,'".$url."','".$cut."',0,'".$description."','".$source."')");


$cont_id = mysqli_insert_id($link);
//echo $cont_id;

	
	
mysqli_free_result($rows);
	
	
	
$content = mysqli_query($link, "SELECT * FROM `articles` ORDER BY `id` DESC");

$row = mysqli_fetch_assoc($content);


echo($row['body']);
	
	
	
	
	
?>