<?php 
session_start();
@include_once("../config.inc.php");
@include_once("../functions.inc.php");
@include_once("../utilities/check_reg.php");


header("Content-type:text/html;charset=utf-8"); 
$link = mysql_connect($DBSERVER, $DBUSER, $DBPASS)
or header("Location: ./");
mysql_select_db($DB, $link) or die ("Can't select DB");



$user = $_COOKIE['user'];

checkUser($user);

//category

if(!empty($_GET['categories']))
{

switch($_GET['categories']){
			case "apple-news":{
			$category = 0;
			$active[0] = 'id="active"';
			$title = "Новости Apple для настоящих фанатов";
			$category_with_selection = '<div id="articles-filter">
	<a href="http://macilove.com/news/apple-news/" id="active">Новости Apple</a>
	<a href="http://macilove.com/news/apple-accessories-reviews/">Обзор аксессуаров</a>
</div>';

			}
			break;
			
			case "apple-accessories-reviews":{
			$category = 13;
			$active[0] = 'id="active"';
			$title = "Обзор аксессуаров";
			$category_with_selection = '<div id="articles-filter">
	<a href="http://macilove.com/news/apple-news/">Новости Apple</a>
	<a href="http://macilove.com/news/apple-accessories-reviews/" id="active">Обзор аксессуаров</a>
</div>';
			
			}
			break;
			
			case "games-for-iphone":{
			$category = 1;
			$active[1] = 'id="active"';
			$title = "Игры для iPhone";
			$category_with_selection = '<div id="articles-filter">
	<a href="http://macilove.com/news/games-for-iphone/" id="active">Игры для iPhone</a>
	<a href="http://macilove.com/news/games-for-ipad/">Игры для iPad</a>
</div>';

			}
			break;
			case "games-for-ipad":{
			$category = 2;
			$active[1] = 'id="active"';
			$title = "Игры для iPad";
			$category_with_selection = '<div id="articles-filter">
	<a href="http://macilove.com/news/games-for-iphone/">Игры для iPhone</a>
	<a href="http://macilove.com/news/games-for-ipad/" id="active">Игры для iPad</a>
</div>';
			
			}
			break;
			case "games-for-ios":{
			$category = 3;
			$active[1] = 'id="active"';
			$title = "Игры для iOS";
			$category_with_selection = '<div id="articles-filter">
	<a href="http://macilove.com/news/games-for-iphone/">Игры для iPhone</a>
	<a href="http://macilove.com/news/games-for-ipad/">Игры для iPad</a>
</div>';

			}
			break;
			case "apps-for-iphone":{
			$category = 4;
			$active[2] = 'id="active"';
			$title = "Приложения для iPhone";
			$category_with_selection = '<div id="articles-filter">
	<a href="http://macilove.com/news/apps-for-iphone/" id="active">Приложения для iPhone</a>
	<a href="http://macilove.com/news/apps-for-ipad/">Приложения для iPad</a>
</div>';

			}
			break;
			case "apps-for-ipad":{
			$category = 5;
			$active[2] = 'id="active"';
			$title = "Приложения для iPad";
			$category_with_selection = '<div id="articles-filter">
	<a href="http://macilove.com/news/apps-for-iphone/">Приложения для iPhone</a>
	<a href="http://macilove.com/news/apps-for-ipad/" id="active">Приложения для iPad</a>
</div>';

			}
			break;
			case "apps-for-ios":{
			$category = 6;
			$active[2] = 'id="active"';
			$title = "Приложения для iOS";
			$category_with_selection = '<div id="articles-filter">
	<a href="http://macilove.com/news/apps-for-iphone/">Приложения для iPhone</a>
	<a href="http://macilove.com/news/apps-for-ipad/">Приложения для iPad</a>
</div>';

			}
			break;
				case "apps-for-mac-os-x":{
			$category = 7;
			$active[3] = 'id="active"';
			$title = "Приложения для Mac OS X";
			$category_with_selection = '<div id="articles-filter">
	<a href="http://macilove.com/news/apps-for-mac-os-x/" id="active">Приложения для Mac OS X</a>
	<a href="http://macilove.com/news/games-for-mac-os-x/">Игры для Mac OS X</a>
</div>';
		
			}
			break;
			case "games-for-mac-os-x":{
			$category = 8;
			$active[3] = 'id="active"';
			$title = "Игры для Mac OS X";
			$category_with_selection = '<div id="articles-filter">
	<a href="http://macilove.com/news/apps-for-mac-os-x/">Приложения для Mac OS X</a>
	<a href="http://macilove.com/news/games-for-mac-os-x/" id="active">Игры для Mac OS X</a>
</div>';

			}
			
			break;
			case "apps-and-games-for-mac-os-x":{
			$category = 12;
			$active[3] = 'id="active"';
			$title = "Приложения и игры для Mac OS X";
			$category_with_selection = '<div id="articles-filter">
	<a href="http://macilove.com/news/apps-for-mac-os-x/">Приложения для Mac OS X</a>
	<a href="http://macilove.com/news/games-for-mac-os-x/">Игры для Mac OS X</a>
</div>';

			}
			
			break;
			case "secrets-iphone-ipad":{
			$category = 9;
			$active[4] = 'id="active"';
			$title = "Трюки и секреты iPhone и iPad";
			$category_with_selection = '<div id="articles-filter">
	<a href="http://macilove.com/news/secrets-mac-os-x/">Трюки и секреты Mac OS X</a>
	<a href="http://macilove.com/news/secrets-iphone-ipad/" id="active">Трюки и секреты iPhone и iPad</a>
</div>';

			}
			break;
			
			case "secrets-mac-os-x":{
			$category = 10;
			$active[4] = 'id="active"';
			$title = "Трюки и секреты Mac OS X";
			$category_with_selection = '<div id="articles-filter">
	<a href="http://macilove.com/news/secrets-mac-os-x/" id="active">Трюки и секреты Mac OS X</a>
	<a href="http://macilove.com/news/secrets-iphone-ipad/">Трюки и секреты iPhone и iPad</a>
</div>';
	
			}
			break;
			case "tricks-and-secrets-mac-os-x-ios":{
			$category = 11;
			$active[4] = 'id="active"';
			$title = "Трюки и секреты Mac OS X и iOS";
			$category_with_selection = '<div id="articles-filter">
	<a href="http://macilove.com/news/secrets-mac-os-x/">Трюки и секреты Mac OS X</a>
	<a href="http://macilove.com/news/secrets-iphone-ipad/">Трюки и секреты iPhone и iPad</a>
</div>';

			}
			break;
			default:{
			$category = 0;
			$active[0] = 'id="active"';
			$title = "Новости Apple для настоящих фанатов";
			$category_with_selection = '<div id="articles-filter">
	<a href="http://macilove.com/news/apple-news/" id="active">Новости Apple</a>
	<a href="http://macilove.com/news/apple-accessories-reviews/">Обзор аксессуаров</a>
</div>';		
			}
			break;
}


$pageCat = $_GET['categories']."/";


	
	

if($category==1){
	$filter = "AND (c.categories=1 OR c.categories=3)";
}
else if($category==2){
	$filter = "AND (c.categories=2 OR c.categories=3)";
}
else if($category==3){
	$filter = "AND (c.categories=1 OR c.categories=2 OR c.categories=3)";
}
else if($category==4){
	$filter = "AND (c.categories=4 OR c.categories=6)";
}
else if($category==5){
	$filter = "AND (c.categories=5 OR c.categories=6)";
}
else if($category==6){
	$filter = "AND (c.categories=4 OR c.categories=5 OR c.categories=6)";
}
else if($category==11){
	$filter = "AND (c.categories=10 OR c.categories=11 OR c.categories=9)";
}
else if($category==12){
	$filter = "AND (c.categories=8 OR c.categories=7)";
}
else
	$filter = "AND c.categories=$category";

}
else{
$no_cat = true;
}


//mobile	
if((strstr($_SERVER['HTTP_USER_AGENT'],'iPhone') || strstr($_SERVER['HTTP_USER_AGENT'],'iPod') || strstr($_SERVER['HTTP_USER_AGENT'],'Android')) && $_COOKIE['version']!=1)
if($no_cat)
header("Location: http://macilove.com/mobile/");
else
header("Location: http://macilove.com/mobile/".$_GET['categories']."/");
else if((strstr($_SERVER['HTTP_USER_AGENT'],'iPhone') || strstr($_SERVER['HTTP_USER_AGENT'],'iPod') || strstr($_SERVER['HTTP_USER_AGENT'],'Android')) && $_COOKIE['version']==1)
{
$mobile_version = '<li class="sep">&middot;</li>
		<li><a href="http://macilove.com/mobile/main_version.php">Мобильная версия</a></li>';
}


//page number
if(isset($_GET['page']) AND $_GET['page']>1)
{
	$page = $_GET['page'];
}	
else if(isset($category))
{
	$page = 1;
}
else if($no_cat)
	header("Location: http://macilove.com/");

		
$page_query = mysql_query("SELECT `id` FROM `content` AS `c` WHERE `draft`=1 $filter");
$coll = mysql_num_rows($page_query);
$max_page = ceil(($coll-11)/16);

//11 + ($page-1)*16



if($page<=2)
{


	$startPages[$page] = 'id="active"';
		$pages ='<li><a href="http://macilove.com/news/'.$pageCat.'page/1/" '.$startPages[1].'>1</a></li>
			<li><a href="http://macilove.com/news/'.$pageCat.'page/2/" '.$startPages[2].'>2</a></li>
			<li><a href="http://macilove.com/news/'.$pageCat.'page/3/">3</a></li>
			<li><a href="http://macilove.com/news/'.$pageCat.'page/4/">4</a></li>
			<li><a href="http://macilove.com/news/'.$pageCat.'page/5/">5</a></li>';	


}	
else if($page>$max_page-2)
{
	$startPages[$page] = 'id="active"';
	
	$pages ='<li><a href="http://macilove.com/news/'.$pageCat.'page/'.($max_page-4).'/">'.($max_page-4).'</a></li>
			<li><a href="http://macilove.com/news/'.$pageCat.'page/'.($max_page-3).'/">'.($max_page-3).'</a></li>
			<li><a href="http://macilove.com/news/'.$pageCat.'page/'.($max_page-2).'/">'.($max_page-2).'</a></li>
			<li><a href="http://macilove.com/news/'.$pageCat.'page/'.($max_page-1).'/" '.$startPages[$max_page-1].'>'.($max_page-1).'</a></li>
			<li><a href="http://macilove.com/news/'.$pageCat.'page/'.$max_page.'/" '.$startPages[$max_page].'>'.$max_page.'</a></li>';	

	if($page == $max_page)
	{
		$close_next_page= 'style="display:none"';	
	}

}
else
{
	$pages ='<li><a href="http://macilove.com/news/'.$pageCat.'page/'.($page-2).'/">'.($page-2).'</a></li>
			<li><a href="http://macilove.com/news/'.$pageCat.'page/'.($page-1).'/">'.($page-1).'</a></li>
			<li><a href="http://macilove.com/news/'.$pageCat.'page/'.$page.'/" id="active">'.$page.'</a></li>
			<li><a href="http://macilove.com/news/'.$pageCat.'page/'.($page+1).'/">'.($page+1).'</a></li>
			<li><a href="http://macilove.com/news/'.$pageCat.'page/'.($page+2).'/">'.($page+2).'</a></li>';	

}
		
		

$limit = ($page-1)*16;

//$articles 

$last_articles_query = mysql_query("
SELECT c.id, c.categories, c.title, UNIX_TIMESTAMP(c.pub_date), c.url, c.cut, count(com.id)
FROM `content` AS `c`
LEFT JOIN `comments` AS `com` ON c.id = com.article_id
LEFT JOIN `register` AS `r` ON com.user_id = r.id
WHERE c.draft=1
$filter
GROUP BY c.id
ORDER BY c.id
DESC LIMIT $limit,16
");

$column_number = 1;

for ($count = 1; $news = mysql_fetch_assoc($last_articles_query); ++$count){

	if($column_number>3)
	{
		$column_number = 1;
	}

	if($count==3)
		$column_number = 1;
	
	
	if($count==4)
	{
		$onAir[$column_number] .= '<div id="candy-index-ya-square">
		<!--banner code goes here-->
		</div>';
		$column_number++;
	}
	
	$category = getNewsCategory($news['categories']);
		
	$onAir[$column_number] .= '<div class="three-column"><div class="img"><a href="http://macilove.com/news/'.$news['url'].'/#comments" class="comment-count">'.$news['count(com.id)'].'</a><a href="http://macilove.com/news/'.$news['url'].'/"><img src="http://macilove.com/images/'.$news['url'].'.jpg" alt="'.stripslashes($news['title']).'" width="302" height="157"></a></div><div class="title"><a href="http://macilove.com/news/'.$news['url'].'/">'.stripslashes($news['title']).'</a></div><div class="subtitle">'.stripslashes($news['cut']).'</div><div class="toolbar"><span class="date">'.strftime( "%e.%m.%Y", $news['UNIX_TIMESTAMP(c.pub_date)']).' <span class="sep">—</span></span> <span class="type"><a href="http://macilove.com/news/'.$category['cat_url'].'/">'.$category['cat_title'].'</a></span></div></div>';
	
	
	$column_number++;


}


//forum block

$forum_questions_query = mysql_query("
SELECT q.type, q.title, q.id, count(a.id), UNIX_TIMESTAMP(q.pub_date), r.name
FROM `questions` AS `q`
LEFT JOIN `answers` AS `a` ON q.id = a.question_id
LEFT JOIN `register` AS `r` ON q.user_id = r.id
GROUP BY q.id
ORDER BY id DESC 
LIMIT 8");


for($forum_count=1; $forum = mysql_fetch_assoc($forum_questions_query); $forum_count++)
{

	if(date('Ymd') <= date('Ymd', $forum['UNIX_TIMESTAMP(q.pub_date)'])+7)
	{
		$todayQuestion = '<span class="new-question-badge"></span>';
	}
	else
		$todayQuestion = '';

	$forumBlock .= '<li>'.$todayQuestion.' <a href="http://macilove.com/questions/question/'.$forum['id'].'/">'.$forum['title'].'</a> <span class="index-question-author">'.$forum['name'].'</span> <a href="http://macilove.com/questions/question/'.$forum['id'].'" class="answers-count">'.$forum['count(a.id)'].'</a></li>';

}



// popular

$popular_articles_query = mysql_query("
SELECT c.id, c.categories, c.title, c.url, count(com.id)
FROM `content` AS `c`
LEFT JOIN `comments` AS `com` ON c.id = com.article_id
LEFT JOIN `statistic` AS `st` ON c.id = st.content_id
WHERE c.draft=1 AND c.pub_date > (NOW() - INTERVAL 1 MONTH)  
GROUP BY c.id
ORDER BY st.visits 
DESC LIMIT 0,15
");


for ($pop_count = 1; $popnews = mysql_fetch_assoc($popular_articles_query); ++$pop_count){
	
	$category = getNewsCategory($popnews['categories']);
	if($pop_count>3)
			$hide_popularArticles = '"';
			
	$popular_articles .= '<div id="popular_'.$pop_count.'" class="three-column" '.$hide_popularArticles.'>
		<div class="img"><a href="http://macilove.com/news/'.$popnews['url'].'/#comments" class="comment-count">'.$popnews['count(com.id)'].'</a><a href="http://macilove.com/news/'.$popnews['url'].'/"><img src="http://macilove.com/images/'.$popnews['url'].'.jpg" alt="'.stripslashes($popnews['title']).'" width="302" height="157"></a></div>
		<div class="toolbar">
			<span class="type"><a href="http://macilove.com/news/'.$category['cat_url'].'/">'.$category['cat_title'].'</a></span>
		</div>
		<div class="title"><a href="http://macilove.com/news/'.$popnews['url'].'/">'.stripslashes($popnews['title']).'</a></div>
	</div>';
	
}

?>
<!DOCTYPE HTML>
<html lang="ru">
<head prefix="og: http://ogp.me/ns#">
<link href='http://fonts.googleapis.com/css?family=Ubuntu:300,400,500&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" href="http://macilove.com/styles-v2.css">
<link rel="stylesheet" media="only screen and (-webkit-min-device-pixel-ratio: 2)" 	href="http://macilove.com/retina-v2.css">

<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="http://macilove.com/resources/jquery-2.1.0.min.js"></script>

<meta name="viewport" content="width=1024">
<meta name="keywords" content="iTunes, Mac OS X, Macintosh, блог Apple, новости Apple, приложения для iPhone, игры для iPad">
<meta name="description" content="Новости Apple для настоящих фанатов">
<title><?php echo $title; ?></title>

<meta property="og:site_name" content="Macilove" />
<!-- <meta property="og:image" content="http://macilove.com/images/how-to-charge-your-iphone-or-ipad-faster.jpg" /> -->
<meta property="og:title" content="<?php echo $title; ?>" />
<meta property="og:type" content="article" />
<meta property="og:description" content="Новости Apple для настоящих фанатов" />
<meta property="og:url" content="http://macilove.com/" />
<link rel="alternate" type="application/rss+xml" href="http://macilove.com/rss/" />
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="http://macilove.com/resources/apple-touch-icon-114x114.png" />
<link rel="shortcut icon" href="http://macilove.com/favicon.ico" />
<script type="text/javascript">
	var popPage = 1;
	$(document).ready(function(){
		function sliderLeft()
		{
			if(popPage>1)
			{	

			
				$('#popular_1').animate({"margin-left": ""+(-1*(950*(popPage-2)+10*(popPage-3)))+"px" }, "300");
				
				popPage--;
				
				$('#right_popular').css('display', 'inline-block');
				
			}
			
			if(popPage==1)
			{
				$('#left_popular').hide();
			}
			
			$('.switch-badges').find('#active').removeAttr('id');
			$('.switch-badges span').eq(popPage-1).attr('id', 'active');

		}
 
		
		function sliderRight()
		{
			if(popPage<=4)
			{
				if(popPage==4)
					$('#popular_1').animate({"margin-left": "-"+(950*popPage + 40)+"px" }, "300");
				else
					$('#popular_1').animate({"margin-left": "-"+(950*popPage + 10*(popPage-1))+"px" }, "300");
				

				popPage++;
				$('#left_popular').css('display', 'inline-block');

			}
			
			if(popPage==5)
			{

				$('#right_popular').hide();
			}
			
			$('.switch-badges').find('#active').removeAttr('id');
			$('.switch-badges span').eq(popPage-1).attr('id', 'active');

		}

		$('#left_popular').click(function(){
			sliderLeft();			
		});
		
		$('#right_popular').click(function(){
			sliderRight();		
		});
		
		
		$('.switch-badges').on('click','span', function(){
			
			if($('.switch-badges').find('#active').index()>$(this).index())//left
			{
				popPage = $(this).index()+2;
				sliderLeft();
				
			}
			else if($('.switch-badges').find('#active').index()<$(this).index())//right
			{
				popPage = $(this).index();
				
				sliderRight();
			} 
			

		});
		
	});
</script>


</head>
<body>

<nav>
	<ul>
		<li><a href="http://macilove.com/" id="logo"></a></li>
		<li><a href="http://macilove.com/news/" id="active">Новости</a></li>
		<li><a href="http://macilove.com/questions/">Форум</a></li>
		<li><a href="http://macilove.com/books/">Книги</a></li>
		<li><a href="http://macilove.com/video/">Видео</a></li>
		<li><a href="http://macilove.com/russian-xcode-tutorials/">Mac разработчики</a></li>
		<li id="search">
			<form method="get" action="http://www.google.com/search">
			<input type="search" name="q" maxlength="255" placeholder="Поиск">
			<input type="hidden" name="sitesearch" value="macilove.com" />
			</form>
		</li>
	</ul>
</nav>

<div id="main-bg" class="wrapper">

	<div id="filter-box">
		<a href="http://macilove.com/news/apple-news/" <?php echo $active[0]; ?>  class="filter-icons">
				<span class="filter-news-icon"></span>
		<p>Новости Apple</p>
		</a>
		
		<a href="http://macilove.com/news/games-for-ios/" <?php echo $active[1]; ?>  class="filter-icons">
				<span class="filter-ipad-icon"></span>
		<p>Игры для iOS</p>
		</a>
		
		<a href="http://macilove.com/news/apps-for-ios/" <?php echo $active[2]; ?>  class="filter-icons">
				<span class="filter-ios-icon"></span>
		<p>Приложения<br>для iOS</p>
		</a>
		
		<a href="http://macilove.com/news/apps-and-games-for-mac-os-x/" <?php echo $active[3]; ?>  class="filter-icons">
				<span class="filter-app-icon"></span>
		<p>Приложения<br>для Mac</p>
		</a>
		
		<a href="http://macilove.com/news/tricks-and-secrets-mac-os-x-ios/" <?php echo $active[4]; ?> class="filter-icons">
				<span class="filter-trick-icon"></span>
		<p>Трюки и секреты</p>
		</a>
	</div>
	
	<?php echo $category_with_selection; ?>

<section id="index-latest-news">
	
	<h1><?php echo $title; ?></h1>	
	
	<div class="vertical-column">
		<?php echo $onAir[1]; ?>
	</div><div class="vertical-column">
		<?php echo $onAir[2]; ?>
	</div><div class="vertical-column">
		<?php echo $onAir[3]; ?>
	</div>
	
	<div class="pages">
		<a href="http://macilove.com/news/<?php echo $pageCat; ?>page/<?php echo $page-1; ?>/" class="left-arrow"></a>
		<ul>
			<?php echo $pages; ?>
			<li class="hide-cursor">—</li>
			<li><a href="http://macilove.com/news/<?php echo $pageCat; ?>page/<?php echo $max_page; ?>/"><?php echo $max_page; ?></a></li>
		</ul>
		<a href="http://macilove.com/news/<?php echo $pageCat; ?>page/<?php echo $page+1; ?>/" class="right-arrow" <?php echo $close_next_page; ?>></a>
	</div>
</section>

<section id="index-forum" class="forum-full-width">
	<div id="forum-area">
		<h3><a href="http://macilove.com/questions/">Форум</a></h3>
		<span id="ask-question-link"><a href="http://macilove.com/questions/ask/">Задать вопрос</a></span>
		<ul>
			<?php echo $forumBlock; ?>
		</ul>
	</div>
	
	<div id="additional-pages">
		<a href="http://macilove.com/best-mac-os-x-apps/" class="best-apps">
			<img src="http://macilove.com/resources/best-apps-icon.png" width="150" height="97">
			<div>Лучшие приложения для Mac OS X</div>
		</a>
		<a href="http://macilove.com/best-iphone-and-ipad-games/" class="best-apps">
			<img src="http://macilove.com/resources/best-ios-games-icon.png" width="150" height="97">
			<div>Лучшие приложения для iOS</div>
		</a>
		<a href="http://goo.gl/B8o5Bm" target="_blank" rel="nofollow" class="best-apps reversi">
			<div class="reversi-icon"></div>
			<div>Fresh Reversi для iOS</div>
		</a>
	</div>
</section>

<section id="best-articles">
	<h1>Популярное за месяц</h1>
	
	<div class="best-articles-box">
		<div class="best-articles-box-scroll">
			<?php echo $popular_articles; ?>
		</div>	
		<div class="best-articles-toolbar">
			<span id="left_popular" class="left-arrow" style="display:none"></span>
				<span class="switch-badges"><span id="active"></span><span></span><span></span><span></span><span></span></span>
			<span id="right_popular" class="right-arrow"></span>
		</div>
	</div>
</section>

</div>
<footer class="wrapper">
	<ul>
		<li class="copy">© 2013 Macilove.com</li>
		<li><a href="http://macilove.com/about/">О нас</a></li>
		<li class="sep">&middot;</li>
		<li><a href="http://macilove.com/feedback/">Обратная связь</a></li>
		<li class="sep">&middot;</li>
		<li><a href="http://twitter.com/macilove_com" rel="nofollow">Twitter</a></li>
		<li class="sep">&middot;</li>
		<li><a href="http://facebook.com/macilovecom" rel="nofollow">Facebook</a></li>
		<li class="sep">&middot;</li>
		<li><a href="http://macilove.com/use-of-cookies/">Использование cookies</a></li>
		<li class="sep">&middot;</li>
		<li><a href="http://macilove-com.tumblr.com/" rel="nofollow">Блог</a></li>
		<li class="sep">&middot;</li>
		<li><a href="http://macilove.com/rss/">RSS</a></li>
	</ul>
</footer>

<div id="made-on-mac" class="wrapper">
	<a href="http://store.apple.com/" id="made-on-a-mac-icon" target="_blank" rel="nofollow"></a>
</div>

</body>
</html>