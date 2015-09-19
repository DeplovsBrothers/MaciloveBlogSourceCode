<?php
@include_once('../functions.inc.php');
@include_once('../config.inc.php');

$link = mysql_connect($DBSERVER, $DBUSER, $DBPASS)
or die("Can't connect" );

mysql_select_db($DB, $link) or die ("Can't select DB");


if(!$_POST)
header("Location: ./apple-news/");

if($_POST['update_value'] AND $_POST['original_html'] AND $_POST['element_id']){
if($_POST['update_value'] == $_POST['original_html']){
	echo $_POST['original_html'];
	exit;
}
else{

$text =  mysql_escape_string(trim($_POST['update_value']));
$old_text = mysql_escape_string(trim($_POST['original_html']));
$parse = explode('_', $_POST['element_id']);
$com_id = $parse[0];
$user_hash = $parse[1];
$art_id = $parse[2];

$patt = "#http([A-Za-z0-9:\/\.\+\?\.\%\/\@\!\#\&_-]+) #";
$repl = '<a href="http$1" target="_blank" rel="nofollow">http$1</a> ';
$text = preg_replace($patt, $repl, $text);


$user_q = mysql_query("SELECT `id` FROM `register` WHERE `hash`='".$user_hash."'");
$num = mysql_num_rows($user_q);
if($num == 1){
$user_id = mysql_fetch_array($user_q);


$upd_q = mysql_query("UPDATE `comments` SET `text`='".$text."' WHERE `id`=".$com_id." AND `article_id`=".$art_id." AND `user_id`=".$user_id[0]."");

$text = str_replace('\n', '<br />', $text);
echo $text;


exit;
}else
exit;
}
}
else if(empty($_POST['update_value']) AND $_POST['original_html'] AND $_POST['element_id'])
{
$parse = explode('_', $_POST['element_id']);
$com_id = $parse[0];
$user_hash = $parse[1];
$art_id = $parse[2];

$user_q = mysql_query("SELECT `id` FROM `register` WHERE `hash`='".$user_hash."'");
$num = mysql_num_rows($user_q);
if($num == 1){
$user_id = mysql_fetch_array($user_q);


$upd_q = mysql_query("DELETE FROM `comments` WHERE `id`=".$com_id." AND `article_id`=".$art_id." AND `user_id`=".$user_id[0]."");

echo 'Ваш коментарий был удален.';
}
else
exit;

}
	
	
	









?>