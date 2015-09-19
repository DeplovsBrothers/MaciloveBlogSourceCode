<?php 
header("Content-type: text/xml;charset=utf-8"); 
echo '<?xml version="1.0" encoding="UTF-8" ?>';

@include_once("./config.inc.php");

$link = mysql_connect($DBSERVER, $DBUSER, $DBPASS)
or die("Can't connect" );

mysql_select_db($DB, $link) or die ("Can't select DB");
echo '
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
<channel>
<atom:link href="http://macilove.com/rss.php" rel="self" type="application/rss+xml" />

<title>Macilove</title>
<description>Новости из мира Apple, обзор iPhone игр и программ</description>
<link>http://www.macilove.com/</link>
<category>news</category>';

       

$query = mysql_query("SELECT `type`, `title`, UNIX_TIMESTAMP(`pub_date`), `url`, `cut`  FROM `content` WHERE `draft`=1 ORDER BY `id` DESC LIMIT 0,50");

while($result = mysql_fetch_assoc($query)){
$title = htmlspecialchars($result['title']);
$date = strftime( "%a, %d %b %Y %T %Z" , $result['UNIX_TIMESTAMP(`pub_date`)']);
$url = htmlentities($result['url']);
$cut = $result['cut'];
$type = $result['type']; 
switch($type){
	case 0:{
	$type = 'news';
	break;}
	case 1:{
	$type = 'articles';
	break;}
	default:{
	$type = 'news';
	break;}
}


$cut = htmlspecialchars($cut);




echo '<item>
        <title>'.$title.'</title>
       <link>http://macilove.com/'.$type.'/'.$url.'/</link>
       <pubDate>'.$date.'</pubDate>
       <guid>http://macilove.com/'.$type.'/'.$url.'/</guid>
    </item>';



}

echo '</channel>
</rss>';

?>






