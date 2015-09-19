<?php
@include_once("./config.inc.php");
@include_once("./functions.inc.php");
header("Content-type:text/html;charset=utf-8"); 
$link = mysql_connect($DBSERVER, $DBUSER, $DBPASS)
or die("Can't connect" );
mysql_select_db($DB, $link) or die ("Can't select DB");

if(isset($_COOKIE['admmacilove']) AND $_COOKIE['admmacilove'] == 111111){


setcookie('admmacilove', '111111', time() + 3600 * 24 * 30, '/'); 


$get_comments = mysql_query("SELECT *, UNIX_TIMESTAMP(pub_date) 
FROM `comments`");
for($com_cnt = 0; $comment_arr = mysql_fetch_assoc($get_comments); ++$com_cnt){
	
	
	$com_pub_date = $comment_arr['UNIX_TIMESTAMP(`pub_date`)'];

$com_date = strftime( "%e", $com_pub_date);
$com_year = strftime( "%Y" ,$com_pub_date);
$com_month = strftime( "%b" ,$com_pub_date);
switch($com_month){
	case "Jan":
	$com_month = "января";
	break;
	case "Feb":
	$com_month = "февраля";
	break;
	case "Mar":
	$com_month = "марта";
	break;
	case "Apr":
	$com_month = "апреля";
	break;
	case "May":
	$com_month = "мая";
	break;
	case "Jun":
	$com_month = "июня";
	break;
	case "Jul":
	$com_month = "июля";
	break;
	case "Aug":
	$com_month = "августа";
	break;
	case "Sep":
	$com_month = "сентября";
	break;
	case "Oct":
	$com_month = "октября";
	break;
	case "Nov":
	$com_month = "ноября";
	break;
	case "Dec":
	$com_month = "декабря";
	break;
}

$com_published = $com_date.' '.$com_month.', '.$com_year;
	
	$comments .= $comment_arr['name'].' '.$com_published.'<p>'.nl2br($comment_arr['text']).'</p>';

}






}



echo $comments;
?>


