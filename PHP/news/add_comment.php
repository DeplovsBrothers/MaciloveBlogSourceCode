<?php
@include_once('../functions.inc.php');
@include_once('../config.inc.php');

$link = mysql_connect($DBSERVER, $DBUSER, $DBPASS)
or die("Can't connect" );

mysql_select_db($DB, $link) or die ("Can't select DB");


if(!$_POST)
header("Location: ./apple-news/");

if($_POST['text'] AND $_POST['name'] AND $_POST['usid'] AND $_POST['artid']){


$text = mysql_escape_string(trim($_POST['text']));
$name = mysql_escape_string(trim($_POST['name']));
if(is_numeric($_POST['usid']))
$user_id = $_POST['usid'];
else
exit;
if(is_numeric($_POST['artid']))
$article_id = $_POST['artid'];
else
exit;


$patt = "#([^\"\>])http([A-Za-z0-9:\/\.\+\?\.\=\%\/\@\!\,\#\&_-]+)#";
$repl = ' <a href="http$2" target="_blank" rel="nofollow">http$2</a> ';
$text = preg_replace($patt, $repl, $text);


$check_for_user = mysql_query("SELECT * FROM `register` WHERE `id`=".$user_id." AND `name`='".$name."'");
$num_user = mysql_num_rows($check_for_user);
if($num_user == 1){
	$user_arr = mysql_fetch_assoc($check_for_user);
	$confirm = $user_arr['confirm'];
	
	if($confirm==1){
		$insert_new_comment = mysql_query("INSERT INTO `comments` VALUES(null,".$article_id.",".$user_id.",'".$name."','".$text."',null)");
		
		$url_for_reminder = mysql_query("SELECT `url` FROM `content` WHERE `id`=".$article_id);
		
		$reminder_url = mysql_fetch_assoc($url_for_reminder);
	}
	
	
	if($insert_new_comment AND $confirm == 0){
	echo 1;//message about confirm you email to show comment
	exit;}
	else if($insert_new_comment AND $confirm == 1){
	echo 2;// all allright
	call_user_func(userActivityCallback(0,$reminder_url['url'],null,$text));
	exit;}
	else{
	echo 3;//unexpected error
	exit;
	}
	
}
else
exit;
	
	
}
else
header("Location: ./apple-news/");

	









?>