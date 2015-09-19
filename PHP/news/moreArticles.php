<?php 
@include_once("./../config.inc.php");
@include_once("./../functions.inc.php");
@include_once("./../utilities/check_reg.php");
header("Content-Type: text/html; charset=utf-8"); 

$link_old = mysqli_connect($DBSERVER, $DBUSER, $DBPASS,'macilove') or die("Can't connect");
$link_new = mysqli_connect($DBSERVER, $DBUSER, $DBPASS,'Macilove') or die("Can't connect");

mysqli_set_charset($link_new, "utf8");	

date_default_timezone_set('Europe/Moscow');

if(!$_POST)
	header("Location: ./");

if($_POST['showMore']==1 && intval($_POST['showMorePage']) && intval($_POST['showMoreColumn']))	
{

	$page = $_POST['showMorePage'];
	
	$limit = ($page - 1) * 8 + 2;
	
	
	
	
	$checkForArticlesInDB = mysqli_query($link_new,"SELECT `id` FROM `articles` WHERE `draft`=1");
	
	$numInNewDB = mysqli_num_rows($checkForArticlesInDB);
//$numInNewDB - 8 - (8 * page)
	
	$bigArticle = 8;
	
	if($numInNewDB - $limit>0)//есть в новой базе
	{
		$newBDArticleQuery = mysqli_query($link_new,"SELECT `title`,`categories`,UNIX_TIMESTAMP(`pub_date`),`description`,`url` FROM `articles` WHERE `draft`=1 ORDER BY `id` DESC LIMIT $limit,8");
		
		
		$max_readMore = 8;
	
		for($n=1; $readMore = mysqli_fetch_array($newBDArticleQuery, MYSQLI_ASSOC); $n++)
		{
		
			$cat = getNewsCategory($readMore['categories']);
			$imgURL = 'http://macilove.com/img/thumbnails/'.$readMore['url'].'-m.jpg';
			
			$bigArticle--;
		if($bigArticle==0){
			$readMoreArticles .= '<li>
			<a href="http://macilove.com/news/'.$readMore['url'].'/" class="big">
				<img src="http://macilove.com/img/original/'.$readMore['url'].'.jpg">
				<h2>'.$readMore['title'].'</h2>
				<p>'.$readMore['description'].'
				</p>
				<div class="toolb">'.dateTimeFormatting($readMore['UNIX_TIMESTAMP(`pub_date`)']).'</div>
			</a>
			</li>';
			
			
			$bigArticle = 8;
		}
		else {
		
				$readMoreArticles .= '<li><div class="title"><div class="toolbar">
							<span class="type"><a href="http://macilove.com/news/'.$cat['cat_url'].'/">'.$cat['cat_title'].'</a></span>
							<span class="sep">|</span>
							<span class="date">'.dateTimeFormatting($readMore['UNIX_TIMESTAMP(`pub_date`)']).'</span>
						</div>
						<h2><a href="http://macilove.com/news/'.$readMore['url'].'/">'.$readMore['title'].'</a></h2>
						<p>'.$readMore['description'].'</p>
					</div><a href="http://macilove.com/news/'.$readMore['url'].'/"><img src="'.$imgURL.'" width="200" height="140" alt=""></a>
				</li>';
			}
			$max_readMore--;
		}
		
		mysqli_free_result($newBDArticleQuery);
		
		
		if($max_readMore!=0)
		{
			
			$oldBDArticleQuery = mysqli_query($link_old,"SELECT `title`,UNIX_TIMESTAMP(`pub_date`),`categories`,`description`,`url` FROM `content` WHERE `draft`=1 ORDER BY `id` DESC LIMIT 0,$max_readMore");
		
			for($n=1; $readMoreOld = mysqli_fetch_array($oldBDArticleQuery, MYSQLI_ASSOC); $n++)
			{
			
				$cat = getNewsCategory($readMoreOld['categories']);
				
				$bigArticle--;
				if($bigArticle==0){
					$readMoreArticles .= '<li>
					<a href="http://macilove.com/news/'.$readMoreOld['url'].'/" class="big">
						<img src="http://macilove.com/images/'.$readMoreOld['url'].'.jpg">
						<h2>'.$readMoreOld['title'].'</h2>
						<p>'.$readMoreOld['description'].'
						</p>
						<div class="toolb">'.dateTimeFormatting($readMoreOld['UNIX_TIMESTAMP(`pub_date`)']).'</div>
					</a>
					</li>';
					
					
					$bigArticle = 8;
				}
				else {
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
			}
			
			mysqli_free_result($oldBDArticleQuery);
			
		}
		
		
	}
	else // в старой базе 
	{
		if($numInNewDB>=8)
		{
			
			$oldBaseLimit = ($page-1) - ceil($numInNewDB/8);
			
			// part of old articles used when no arts in new base
			$newBaseLimit = 8 - fmod($numInNewDB, 8);
		
		 
			$startLimit = $newBaseLimit + $oldBaseLimit*8;
		
		}	
		else 
			$startLimit = 8-$numInNewDB + ($page - 2) * 8;
		
		
		$startLimit +=2;

		$oldBDArticleQuery = mysqli_query($link_old,"SELECT `title`,UNIX_TIMESTAMP(`pub_date`),`categories`,`description`,`url` FROM `content` WHERE `draft`=1 ORDER BY `id` DESC LIMIT $startLimit,8");
	 
		for($n=1; $readMoreOld = mysqli_fetch_array($oldBDArticleQuery, MYSQLI_ASSOC); $n++)
		{
		
			$cat = getNewsCategory($readMoreOld['categories']);

			$bigArticle--;
			if($bigArticle==0){
				$readMoreArticles .= '<li>
				<a href="http://macilove.com/news/'.$readMoreOld['url'].'/" class="big">
					<img src="http://macilove.com/images/'.$readMoreOld['url'].'.jpg">
					<h2>'.$readMoreOld['title'].'</h2>
					<p>'.$readMoreOld['description'].'
					</p>
					<div class="toolb">'.dateTimeFormatting($readMoreOld['UNIX_TIMESTAMP(`pub_date`)']).'</div>
				</a>
				</li>';
				
				
				$bigArticle = 8;
			}
			else {
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
		}
		
		mysqli_free_result($oldBDArticleQuery);
		

	}
	
	
	echo $readMoreArticles;
	
}
?>
