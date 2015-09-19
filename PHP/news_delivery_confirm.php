<?php
session_start();
@include_once("./config.inc.php");
@include_once("./functions.inc.php");

header("Content-type:text/html;charset=utf-8"); 
$link = mysql_connect($DBSERVER, $DBUSER, $DBPASS)
or die("Can't connect" );
mysql_select_db($DB, $link) or die ("Can't select DB");

if(isset($_GET['id']) AND isset($_GET['del']) AND isset($_GET['email'])){
$user = $_GET['id'];
$email = $_GET['email'];
mysql_query("DELETE FROM `email_delivery` WHERE `email`='".$email."' AND `user`='".$user."'");
$_SESSION['err'] = 4;
header("Location: ./message/");
}
else if(isset($_GET['id']) AND isset($_COOKIE['user']) AND isset($_GET['email'])){
$id = $_GET['id'];
$user = $_COOKIE['user'];
$email = $_GET['email'];
if($id = $user){
$check = mysql_query("SELECT `id` FROM `email_delivery` WHERE `email`='".$email."'");
if(mysql_num_rows($check) == 0)
mysql_query("INSERT INTO `email_delivery` VALUES(null,'".$email."','".$user."')");
}
$_SESSION['err'] = 3;
header("Location: ./message/");
 
}
else
header("Location: ./news/apple-news/");







?>