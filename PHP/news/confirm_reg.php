<?php
session_start();
@include_once("../config.inc.php");
@include_once("../functions.inc.php");

$link = mysql_connect($DBSERVER, $DBUSER, $DBPASS)
or die("Can't connect" );
mysql_select_db($DB, $link) or die ("Can't select DB");

if(!$_POST)
header("Location: ./apple-news/");


if($_POST['id'] AND $_POST['code']){
$id = mysql_escape_string($_POST['id']);
$code = mysql_escape_string(trim($_POST['code']));

$check = mysql_query("SELECT `SID` FROM `register` WHERE `id`='".$id."'");
$row = mysql_num_rows($check);
if($row !== 0){
$arr = mysql_fetch_assoc($check);
if($code == substr($arr['SID'],0,10)){

mysql_query("UPDATE `register` SET `confirm`=1 WHERE `id`='".$id."'");
}
else{
echo 2;
exit;
}
}
else{ 
echo 2;
exit;
}


$hash = md5(randStr().$id); 

setcookie('user', $hash, time() + 3600 * 24 * 30, '/'); 
     
$register_hash = mysql_query("UPDATE `register` SET  `hash` = '".$hash."' WHERE `id` = '".$id."'"); 
mysql_query("INSERT INTO `users` VALUES(null, '".$hash."', null)"); 


echo 1;
exit;
}
else{
echo 2;
exit;
}





?>