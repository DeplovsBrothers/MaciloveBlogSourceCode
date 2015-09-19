<?php
@include_once("./../config.inc.php");
@include_once("./../functions.inc.php");

header("Content-Type: text/html; charset=utf-8"); 

$link = mysql_connect($DBSERVER, $DBUSER, $DBPASS)
or die("Can't connect" );
mysql_select_db($DB, $link) or die ("Can't select DB");


if(!isset($_COOKIE['admmacilove']) AND $_COOKIE['admmacilove'] != 111111){
	header("Location: http://macilove.com");
}



for($k=2000; $k<3000; $k++)
{



$get_files_q = mysql_query("SELECT `id`,`body` FROM `content` ORDER BY `id` LIMIT $k,1");
$content = mysql_fetch_assoc($get_files_q);


		
		$img_jpg_patt = '#http://s3-eu-west-1.amazonaws.com/macilove-images/news/([A-Za-z0-9:\/\.\+\?\.\%\/\@\!\#\&_\-\-]+).jpg#';

		
		$img_jpg_repl = 'http://macilove.com/images/$1.jpg';
		$text = preg_replace($img_jpg_patt, $img_jpg_repl, stripslashes($content['body']));
		
		
	 	$q = mysql_query("UPDATE `content` SET `body`='".mysql_real_escape_string($text)."' WHERE `id`=".$content['id'].""); 
	 	
	 	if($q)
		 	echo 'ok';
	
}
echo 'done';






 ?>