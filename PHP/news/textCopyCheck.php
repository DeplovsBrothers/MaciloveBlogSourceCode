<?php 
@include_once('../functions.inc.php');
@include_once('../config.inc.php');

$link = mysql_connect($DBSERVER, $DBUSER, $DBPASS)
or die("Can't connect" );

mysql_select_db($DB, $link) or die ("Can't select DB");

if(!$_POST)
header("Location: ./apple-news/");




if($_POST['art_id'] AND $_POST['user_h'] AND $_POST['ip']){

if(is_numeric($_POST['art_id']))
$article_id = $_POST['art_id'];

$user_hash = mysql_escape_string($_POST['user_h']);
$ip = mysql_escape_string($_POST['ip']);
	
	
	$checkUserForPreviousCopyQuery = mysql_query("SELECT * FROM `checkThief` WHERE `user_hash` ='".$user_hash."'");
	$checkUserForPreviousCopyNum = mysql_num_rows($checkUserForPreviousCopyQuery);
	
	if($checkUserForPreviousCopyNum==1)
	{
		$user_info = mysql_fetch_assoc($checkUserForPreviousCopyQuery);

		
		mysql_query("UPDATE `checkThief` SET `copies`=".($user_info['copies']+1).", `ip`='".$ip."' WHERE `id`=".$user_info['id']);
	
	
	$user_id = $user_info['id']; 		
}
else
 {
	 mysql_query("INSERT INTO `checkThief` VALUES(null,'".$user_hash."','".$ip."',1,1)");
	$user_id = mysql_insert_id(); 
 }
	
	
	
	mysql_query("INSERT INTO `copiedArticles` VALUES(null, ".$article_id.",".$user_id." ,null)");
}	
?>