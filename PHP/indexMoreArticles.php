<?php 
@include_once("./config.inc.php");
@include_once("./functions.inc.php");
@include_once("./utilities/check_reg.php");
header("Content-Type: text/html; charset=utf-8"); 

$link_old = mysqli_connect($DBSERVER, $DBUSER, $DBPASS,'macilove') or die("Can't connect");
$link_new = mysqli_connect($DBSERVER, $DBUSER, $DBPASS,'Macilove') or die("Can't connect");

mysqli_set_charset($link_new, "utf8");	

date_default_timezone_set('Europe/Moscow');

if(!$_POST)
	header("Location: ./");

if($_POST['showMore']==1 && intval($_POST['showMorePage']) && $_POST['showMoreColumn'])	
{

	if(is_numeric($_POST['cat'])){
		$category = mysql_escape_string($_POST['cat']);
		
		if($category==1){
			$filter = "AND (categories=1 OR categories=3)";
		}
		else if($category==2){
			$filter = "AND (categories=2 OR categories=3)";
		}
		else if($category==3){
			$filter = "AND (categories=1 OR categories=2 OR categories=3)";
		}
		else if($category==4){
			$filter = "AND (categories=4 OR categories=6)";
		}
		else if($category==5){
			$filter = "AND (categories=5 OR categories=6)";
		}
		else if($category==6){
			$filter = "AND (categories=4 OR categories=5 OR categories=6)";
		}
		else if($category==11){
			$filter = "AND (categories=10 OR categories=11 OR categories=9)";			
		}
		else if($category==12){
			$filter = "AND (categories=8 OR categories=7)";
		}
		else
			$filter = "AND categories=$category";
	}
		


	$page = $_POST['showMorePage'];
	$limit = ($page - 1) * 16;
	
	$checkForArticlesInDB = mysqli_query($link_new,"SELECT `id` FROM `articles` WHERE `draft`=1 $filter");
	
	$numInNewDB = mysqli_num_rows($checkForArticlesInDB);
//$numInNewDB - 8 - (8 * page)
	
	
	
	if($numInNewDB - $limit>0)//есть в новой базе
	{
		$newBDArticleQuery = mysqli_query($link_new,"SELECT `title`,`categories`,UNIX_TIMESTAMP(`pub_date`),`description`,`url` FROM `articles` WHERE `draft`=1 $filter ORDER BY `id` DESC LIMIT $limit,16");
		
		$max_readMore = 16;
	
		for($n=1; $readMore = mysqli_fetch_array($newBDArticleQuery, MYSQLI_ASSOC); $n++)
		{
		
			$cat = getNewsCategory($readMore['categories']);
			$imgURL = 'http://macilove.com/img/thumbnails/'.$readMore['url'].'-m.jpg';
			
		
			$readMoreArticles .= '<li><div class="title"><div class="toolbar">
						<span class="type"><a href="http://macilove.com/news/'.$cat['cat_url'].'/">'.$cat['cat_title'].'</a></span>
						<span class="sep">|</span>
						<span class="date">'.dateTimeFormatting($readMore['UNIX_TIMESTAMP(`pub_date`)']).'</span>
					</div>
					<h2><a href="http://macilove.com/news/'.$readMore['url'].'/">'.$readMore['title'].'</a></h2>
					<p>'.$readMore['description'].'</p>
				</div><a href="http://macilove.com/news/'.$readMore['url'].'/"><img src="'.$imgURL.'" width="200" height="140" alt=""></a>
			</li>';
			
			$max_readMore--;
		}
		
		mysqli_free_result($newBDArticleQuery);
		
		
		if($max_readMore!=0)
		{
			
			$oldBDArticleQuery = mysqli_query($link_old,"SELECT `title`,UNIX_TIMESTAMP(`pub_date`),`categories`,`description`,`url` FROM `content` WHERE `draft`=1 $filter ORDER BY `id` DESC LIMIT 0,$max_readMore");
		
			for($n=1; $readMoreOld = mysqli_fetch_array($oldBDArticleQuery, MYSQLI_ASSOC); $n++)
			{
			
				$cat = getNewsCategory($readMoreOld['categories']);
	
				$readMoreArticles .= '<li><div class="title"><div class="toolbar">
							<span class="type"><a href="http://macilove.com/news/'.$cat['cat_url'].'/">'.$cat['cat_title'].'</a></span>
							<span class="sep">|</span>
							<span class="date">'.dateTimeFormatting($readMoreOld['UNIX_TIMESTAMP(`pub_date`)']).'</span>
						</div>
						<h2><a href="http://macilove.com/news/'.$readMoreOld['url'].'/">'.$readMoreOld['title'].'</a></h2>
						<p>'.$readMoreOld['description'].'</p>
					</div><a href="http://macilove.com/news/'.$readMoreOld['url'].'/"><img src="http://macilove.com/images/'.$readMoreOld['url'].'-m.jpg" width="200" height="140" alt=""></a>
				</li>';
	
			}
			
			mysqli_free_result($oldBDArticleQuery);
			
		}
		
		
	}
	else // в старой базе 
	{
		if($numInNewDB>=16)
		{
			
			$oldBaseLimit = ($page-1) - ceil($numInNewDB/16);
			
			// part of old articles used when no arts in new base
			$newBaseLimit = 16 - fmod($numInNewDB, 16);
		
		 
			$startLimit = $newBaseLimit + $oldBaseLimit*16;
		
		}	
		else 
			$startLimit = 16-$numInNewDB + ($page - 2) * 16;
		
		
	

		$oldBDArticleQuery = mysqli_query($link_old,"SELECT `title`,UNIX_TIMESTAMP(`pub_date`),`categories`,`description`,`url` FROM `content` WHERE `draft`=1 $filter ORDER BY `id` DESC LIMIT $startLimit,16");
	 
		for($n=1; $readMoreOld = mysqli_fetch_array($oldBDArticleQuery, MYSQLI_ASSOC); $n++)
		{
		
			$cat = getNewsCategory($readMoreOld['categories']);

			$readMoreArticles .= '<li><div class="title"><div class="toolbar">
						<span class="type"><a href="http://macilove.com/news/'.$cat['cat_url'].'/">'.$cat['cat_title'].'</a></span>
						<span class="sep">|</span>
						<span class="date">'.dateTimeFormatting($readMoreOld['UNIX_TIMESTAMP(`pub_date`)']).'</span>
					</div>
					<h2><a href="http://macilove.com/news/'.$readMoreOld['url'].'/">'.$readMoreOld['title'].'</a></h2>
					<p>'.$readMoreOld['description'].'</p>
				</div><a href="http://macilove.com/news/'.$readMoreOld['url'].'/"><img src="http://macilove.com/images/'.$readMoreOld['url'].'-m.jpg" width="200" height="140" alt=""></a>
			</li>';

		}
		
		mysqli_free_result($oldBDArticleQuery);
		

	}
	
	
	echo $readMoreArticles;
	
}
?>
