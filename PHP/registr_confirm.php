<?php
session_start();
@include_once("./config.inc.php");
@include_once("./functions.inc.php");

header("Content-type:text/html;charset=utf-8"); 
$link = mysql_connect($DBSERVER, $DBUSER, $DBPASS)
or die("Can't connect" );
mysql_select_db($DB, $link) or die ("Can't select DB");

if(isset($_GET['id']) AND isset($_GET['news'])){
$SID = $_GET['id'];
$news = $_GET['news'];
$check = mysql_query("SELECT `id`,`hash`,`email` FROM `register` WHERE `SID`='".$SID."'");
if(mysql_num_rows($check) !== 0)
mysql_query("UPDATE `register` SET `confirm`=1 WHERE `SID`='".$SID."'");
else 
header("Location: ../");

$ff = mysql_fetch_assoc($check);
$id = $ff['id'];

$hash = md5(randStr().$id); 

setcookie('user', $hash, time() + 3600 * 24 * 30, '/'); 
     
// добавляем в нашу базу хэш чтобы сверять по нему кукес с записью и тем самым не использовать 
// почту и пароль как кукес-логин из целей безопасности 
$register_hash = mysql_query("UPDATE `register` SET  `hash` = '".$hash."' WHERE `id` = '".$id."'"); 


mysql_query("INSERT INTO `email_delivery` VALUES(null,'".$ff['email']."','".$SID."')");

header("Location: ./add_ad/");



}
else if(isset($_GET['id'])){
$SID = $_GET['id'];
$check = mysql_query("SELECT `hash`,`email` FROM `register` WHERE `SID`='".$SID."'");
if(mysql_num_rows($check) !== 0)
mysql_query("UPDATE `register` SET `confirm`=1 WHERE `SID`='".$SID."'");
else 
header("Location: ../"); 

$ff = mysql_fetch_assoc($check);
$id = $ff['id'];

$hash = md5(randStr().$id); 

setcookie('user', $hash, time() + 3600 * 24 * 30, '/'); 
     
$register_hash = mysql_query("UPDATE `register` SET  `hash` = '".$hash."' WHERE `id` = '".$id."'"); 


header("Location: ./add_ad/");
}
else
header("Location: ./news/apple-news/");







?>