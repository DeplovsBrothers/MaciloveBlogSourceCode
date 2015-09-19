<?php
session_start();
@include_once('../functions.inc.php');
@include_once('../config.inc.php');

$link = mysql_connect($DBSERVER, $DBUSER, $DBPASS)
or die("Can't connect" );

mysql_select_db($DB, $link) or die ("Can't select DB");

if(!$_POST)
header("Location: ./apple-news/");




if($_POST['usid'] AND $_POST['artid']){

if(is_numeric($_POST['usid']))
$user_id = $_POST['usid'];
else
exit;
if(is_numeric($_POST['v']))
$value = $_POST['v'];
else
exit;
if(is_numeric($_POST['artid']))
$article_id = $_POST['artid'];
else
exit;

$hash = $_COOKIE['user'];
$check_user = mysql_query("SELECT * FROM `register` WHERE `id`=".$user_id." AND `hash`='".$hash."'");
$num = mysql_num_rows($check_user);
if($num ==1){
if($value == 1)
mysql_query("INSERT INTO `comm_notif` VALUES(null,".$article_id.",".$user_id.")");
else if($value == 0)
mysql_query("DELETE FROM `comm_notif` WHERE `article_id`=".$article_id." AND `user_id`=".$user_id."");

echo 1;
}
else
echo 2;
exit;


}
echo 2;
exit;



?>