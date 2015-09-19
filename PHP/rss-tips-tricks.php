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

$query_new = mysqli_query($link_new, "SELECT `title`, UNIX_TIMESTAMP(`pub_date`), `url`, `cut` FROM `articles` WHERE `draft`=1 ORDER BY `id` DESC LIMIT 0,50");

  
$limit = 0;
    
while($result = mysqli_fetch_array($query_new, MYSQLI_ASSOC)){
$title = htmlspecialchars($result['title']);
$date = strftime( "%a, %d %b %Y %T +0400" , $result['UNIX_TIMESTAMP(`pub_date`)']);

$url = htmlentities($result['url']);
$cut = $result['cut'];


$cut = htmlspecialchars('<a href="http://macilove.com/news/'.$url.'/"><img src="http://macilove.com/images/'.$url.'-m.jpg"></a><br />'.$cut);




echo '<item>
        <title>'.$title.'</title>
       <description>'.$cut.'</description>
       <link>http://macilove.com/news/'.$url.'/</link>
       <pubDate>'.$date.'</pubDate>
       <guid>http://macilove.com/news/'.$url.'/</guid>
    </item>';


$limit++;
}
mysqli_free_result($query_new);

$limit = 50 - $limit;
$query = mysqli_query($link_old,"SELECT `type`, `title`, UNIX_TIMESTAMP(`pub_date`), `url`, `cut`  FROM `content` WHERE `draft`=1 ORDER BY `id` DESC LIMIT 0,$limit");

while($result = mysqli_fetch_array($query, MYSQLI_ASSOC)){
$title = htmlspecialchars($result['title']);
$date = strftime( "%a, %d %b %Y %T +0400" , $result['UNIX_TIMESTAMP(`pub_date`)']);

$url = htmlentities($result['url']);
$cut = $result['cut'];


$cut = htmlspecialchars('<a href="http://macilove.com/news/'.$url.'/"><img src="http://macilove.com/images/'.$url.'-m.jpg"></a><br />'.$cut);




echo '<item>
        <title>'.$title.'</title>
       <description>'.$cut.'</description>
       <link>http://macilove.com/news/'.$url.'/</link>
       <pubDate>'.$date.'</pubDate>
       <guid>http://macilove.com/news/'.$url.'/</guid>
    </item>';


$limit++;
}
mysqli_free_result($query);





echo '</channel>
</rss>';

?>






