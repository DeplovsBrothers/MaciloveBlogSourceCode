<?php
session_start();
@include_once('../functions.inc.php');
@include_once('../config.inc.php');

$link = mysql_connect($DBSERVER, $DBUSER, $DBPASS)
or die("Can't connect" );

mysql_select_db($DB, $link) or die ("Can't select DB");

if(!$_POST)
header("Location: ./apple-news/");



if($_POST['em'] AND $_POST['pass']){
$email = mysql_escape_string(strtolower(trim($_POST['em'])));
$pass = mysql_escape_string(trim($_POST['pass']));
if(checkmail($email) == -1){
	echo 1;//not an email
	exit;
}
$check_email = mysql_query("SELECT * FROM `register` WHERE `email`='".$email."' AND `password`='".md5($pass.salt)."' AND `confirm`=1");
if(mysql_num_rows($check_email) !== 1){
echo 2;//not in base
exit;
}
else{
$user = mysql_fetch_assoc($check_email);	

setcookie('user', $user['hash'], time() + 3600 * 24 * 30 , '/');
mysql_query("INSERT INTO `users` VALUES(null, '".$user['hash']."', null)"); 
$_SESSION['SID'] = $user['SID'];

if (isset($_SERVER["REMOTE_ADDR"])){
$ip = $_SERVER["REMOTE_ADDR"];
mysql_query("UPDATE `register` SET `ip`='".$ip."' WHERE `SID`=".$user['id']."");

}
echo 'id='.$user['id'].'&name='.$user['name'];	

}


exit;
}
else if($_POST['id'] AND $_POST['name']){
$id = mysql_escape_string($_POST['id']);
$name = mysql_escape_string($_POST['name']);
	
	$check_for_reg = mysql_query("SELECT * FROM `register` WHERE `id`=".$id." AND `name`='".$name."'");
$num_check_reg = mysql_num_rows($check_for_reg);
if($num_check_reg == 1){
  $hash = md5(randStr().randomChars()); 
  setcookie('user', $hash, time() + 3600 * 24 * 30, '/');    
  session_destroy();
echo 1;
exit;
  
}
exit;

	
	
}
else
header("Location: ./apple-news/");


?>