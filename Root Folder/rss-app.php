<?php 
header("Content-type: text/xml;charset=utf-8"); 
date_default_timezone_set("Europe/Moscow");

echo '<?xml version="1.0" encoding="UTF-8" ?>';

@include_once("./config.inc.php");


$link_old = mysqli_connect($DBSERVER, $DBUSER, $DBPASS,'macilove') or die("Can't connect");
$link_new = mysqli_connect($DBSERVER, $DBUSER, $DBPASS,'Macilove') or die("Can't connect");

mysqli_set_charset($link_new, "utf8");	




echo '
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
<channel>
<atom:link href="http://macilove.com/rss/" rel="self" type="application/rss+xml" />

<title>Macilove</title>
<description>Новости из мира Apple, обзор iPhone игр и программ</description>
<link>http://www.macilove.com/</link>
<category>news</category>';


$query_new = mysqli_query($link_new, "SELECT `title`, UNIX_TIMESTAMP(`pub_date`), `categories` , `url`,`body`, `description` FROM `articles` WHERE `draft`=1 ORDER BY `id` DESC LIMIT 50");



$limit = 0;
    
while($result = mysqli_fetch_array($query_new, MYSQLI_ASSOC)){
$title = htmlspecialchars($result['title']);
$category = $result['categories'];
$date = strftime("%e.%m.%g", $result['UNIX_TIMESTAMP(`pub_date`)']);

$url = htmlentities($result['url']);
$description = htmlspecialchars($result['description']);

$body = $result['body'];


switch($category){
			case 0:
			$title_for_badge = 'Новости Apple';
			break;
			case 13:
			$title_for_badge = 'Обзор аксессуаров';
			break;
			
			case 1:
			$title_for_badge = 'Игры для iPhone';
			break;
			case 2:
			$title_for_badge = 'Игры для iPad';
			break;
			case 3:
			if($category==1){
			$title_for_badge = 'Игры для iPhone';
			}
			else if($category==2){
			$title_for_badge = 'Игры для iPad';}
			else
			{
			$title_for_badge = 'Игры для iPhone и iPad';
			}
			break;
			case 4:
			$title_for_badge = 'Приложения для iPhone';
			break;
			case 5:
			$title_for_badge = 'Приложения для iPad';
			break;
			case 6:
			if($category==4){
			$title_for_badge = 'Приложения для iPhone';
			}
			else if($category==5)
			{
			$title_for_badge = 'Приложения для iPad';}
			else
			{
			$title_for_badge = 'Приложения для iPhone и iPad';			
			}
			break;
			case 7:
			$title_for_badge = 'Приложения для Mac OS X';
			break;
			case 8:
			$title_for_badge = 'Игры для Mac OS X';
			break;
			case 9:
			$title_for_badge = 'Трюки и секреты iPhone и iPad';
			break;
			case 10:
			$title_for_badge = 'Трюки и секреты Mac OS X';
			break;
}	


/*
echo '<item>
       <title>'.$title.'</title>
       <description>'.$description.'</description>
       <link>http://macilove.com/news/'.$url.'/</link>     
       <pubDate>'.$date.'</pubDate>
       <guid>http://macilove.com/news/'.$url.'/</guid>
    </item>';
*/


echo '<item><title>'.$title.'</title><description>'.$title_for_badge.'</description><link>http://macilove.com/news/'.$url.'/</link><image>http://macilove.com/img/original/'.$url.'.jpg</image><enclosure>'.htmlspecialchars($body).'</enclosure><pubDate>'.$date.'</pubDate><guid>http://macilove.com/news/'.$url.'/</guid></item>';




$limit++;
}
mysqli_free_result($query_new);

$limit = 50 - $limit;
$query = mysqli_query($link_old,"SELECT `type`, `title`, UNIX_TIMESTAMP(`pub_date`),`body`, `categories`, `url`, `cut`  FROM `content` WHERE `draft`=1 ORDER BY `id` DESC LIMIT 0,$limit");

while($result = mysqli_fetch_array($query, MYSQLI_ASSOC)){
$title = htmlspecialchars($result['title']);


$date = strftime( "%e.%m.%g" , $result['UNIX_TIMESTAMP(`pub_date`)']);
$category = $result['categories'];
$url = htmlentities($result['url']);
$cut = $result['cut'];

$body = $result['body'];

switch($category){
			case 0:
			$title_for_badge = 'Новости Apple';
			break;
			case 13:
			$title_for_badge = 'Обзор аксессуаров';
			break;
			
			case 1:
			$title_for_badge = 'Игры для iPhone';
			break;
			case 2:
			$title_for_badge = 'Игры для iPad';
			break;
			case 3:
			if($category==1){
			$title_for_badge = 'Игры для iPhone';
			}
			else if($category==2){
			$title_for_badge = 'Игры для iPad';}
			else
			{
			$title_for_badge = 'Игры для iPhone и iPad';
			}
			break;
			case 4:
			$title_for_badge = 'Приложения для iPhone';
			break;
			case 5:
			$title_for_badge = 'Приложения для iPad';
			break;
			case 6:
			if($category==4){
			$title_for_badge = 'Приложения для iPhone';
			}
			else if($category==5)
			{
			$title_for_badge = 'Приложения для iPad';}
			else
			{
			$title_for_badge = 'Приложения для iPhone и iPad';			
			}
			break;
			case 7:
			$title_for_badge = 'Приложения для Mac OS X';
			break;
			case 8:
			$title_for_badge = 'Игры для Mac OS X';
			break;
			case 9:
			$title_for_badge = 'Трюки и секреты iPhone и iPad';
			break;
			case 10:
			$title_for_badge = 'Трюки и секреты Mac OS X';
			break;
}	


	
	

//    

   

echo '<item><title>'.$title.'</title><description>'.$title_for_badge.'</description><link>http://macilove.com/news/'.$url.'/</link><image>http://macilove.com/images/'.$url.'.jpg</image><enclosure>'.htmlspecialchars($body).'</enclosure><pubDate>'.$date.'</pubDate><guid>http://macilove.com/news/'.$url.'/</guid></item>';



$limit++;
}
mysqli_free_result($query);






echo '</channel>
</rss>';


?>






