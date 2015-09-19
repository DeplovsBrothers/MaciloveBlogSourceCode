<?php 
@include_once('../functions.inc.php');
@include_once('../config.inc.php');
@include_once("./check_reg.php");

$link = mysql_connect($DBSERVER, $DBUSER, $DBPASS)
or die("Can't connect" );

mysql_select_db($DB, $link) or die ("Can't select DB");


if(!$_POST)
	header("Location: ./");
	

	
if($_POST['showMore']==1 && intval($_POST['showMorePage']) && intval($_POST['showMoreColumn']))	
{	
	
	$limit = ($_POST['showMorePage']-1)*16;
	
	//$articles 

	$last_articles_query = mysql_query("
	SELECT c.id, c.categories, c.title, UNIX_TIMESTAMP(c.pub_date), c.url, c.cut, count(com.id)
	FROM `content` AS `c`
	LEFT JOIN `comments` AS `com` ON c.id = com.article_id
	LEFT JOIN `register` AS `r` ON com.user_id = r.id
	WHERE c.draft=1
	GROUP BY c.id
	ORDER BY c.id
	DESC LIMIT $limit,12
	");
	
	$column_number = 1;
	

	
for ($count = 1; $news = mysql_fetch_assoc($last_articles_query); ++$count){
	
		if($column_number>3)
		{
			$column_number = 1;
		}
	
		
		$category = getNewsCategory($news['categories']);
			
		$onAir[$column_number] .= '<div class="three-column"><div class="img"><a href="http://macilove.com/news/'.$news['url'].'/#comments-box-wrapper" class="comment-count">'.$news['count(com.id)'].'</a><a href="http://macilove.com/news/'.$news['url'].'/"><img src="http://macilove.com/images/'.$news['url'].'.jpg" alt="'.stripslashes($news['title']).'" width="302" height="157"></a></div><div class="title"><a href="http://macilove.com/news/'.$news['url'].'/">'.stripslashes($news['title']).'</a></div><div class="subtitle">'.stripslashes($news['cut']).'</div><div class="toolbar"><span class="date">'.strftime( "%e.%m.%Y", $news['UNIX_TIMESTAMP(c.pub_date)']).' <span class="sep">—</span></span> <span class="type"><a href="http://macilove.com/news/'.$category['cat_url'].'/">'.$category['cat_title'].'</a></span></div></div>';
		
		
		$column_number++;
	
	
	}




	echo json_encode($onAir);
	exit;
	
}
else
	header("Location: ./");



exit;	
?>