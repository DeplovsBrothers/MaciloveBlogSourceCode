<?php
@include_once("./config.inc.php");
@include_once("./functions.inc.php");
@include_once("./utilities/check_reg.php");
header("Content-Type: text/html; charset=utf-8"); 

$link_old = mysqli_connect($DBSERVER, $DBUSER, $DBPASS,'macilove') or die("Can't connect");
$link_new = mysqli_connect($DBSERVER, $DBUSER, $DBPASS,'Macilove') or die("Can't connect");


mysqli_set_charset($link_new, "utf8");	

date_default_timezone_set('Europe/Moscow');

//category

if(!empty($_GET['categories']))
{
$prefix = './../.'; 

switch($_GET['categories']){
			case "apple-news":{
			$category = 0;
			$active[0] = 'id="active"';
			$title = "Новости Apple для настоящих фанатов — Macilove";
			$categoryHeader = '<section id="cat"><h1>Новости Apple</h1><div id="filter"><a href="http://macilove.com/news/apple-news/" class="active">Новости Apple</a><a href="http://macilove.com/news/apple-accessories-reviews/">Обзор аксессуаров</a></div></section>';
			
	

			}
			break;
			
			case "apple-accessories-reviews":{
			$category = 13;
			$active[0] = 'id="active"';
			$title = "Обзор аксессуаров для Apple устройств — Macilove";
			$categoryHeader = '<section id="cat"><h1>Обзор аксессуаров для Apple устройств</h1><div id="filter"><a href="http://macilove.com/news/apple-news/">Новости Apple</a><a href="http://macilove.com/news/apple-accessories-reviews/" class="active">Обзор аксессуаров</a></div></section>';
			
			}
			break;
			
			case "games-for-iphone":{
			$category = 1;
			$active[1] = 'id="active"';
			$title = "Игры для iPhone — Macilove";
			$categoryHeader = '<section id="cat"><h1>Игры для iPhone</h1><div id="filter"><a href="http://macilove.com/news/games-for-iphone/" class="active">Игры для iPhone</a><a href="http://macilove.com/news/games-for-ipad/">Игры для iPad</a></div></section>';
			
		

			}
			break;
			case "games-for-ipad":{
			$category = 2;
			$active[1] = 'id="active"';
			$title = "Игры для iPad — Macilove";
			$categoryHeader = '<section id="cat"><h1>Игры для iPad</h1><div id="filter"><a href="http://macilove.com/news/games-for-iphone/">Игры для iPhone</a><a href="http://macilove.com/news/games-for-ipad/" class="active">Игры для iPad</a></div></section>';
			
			
			}
			break;
			case "games-for-ios":{
			$category = 3;
			$active[1] = 'id="active"';
			$title = "Игры для iPhone и iPad — Macilove";
			$categoryHeader = '<section id="cat"><h1>Игры для iPhone и iPad</h1><div id="filter"><a href="http://macilove.com/news/games-for-iphone/">Игры для iPhone</a><a href="http://macilove.com/news/games-for-ipad/">Игры для iPad</a></div></section>';

			}
			break;
			case "apps-for-iphone":{
			$category = 4;
			$active[2] = 'id="active"';
			$title = "Приложения для iPhone — Macilove";
			$categoryHeader = '<section id="cat"><h1>Приложения для iPhone</h1><div id="filter"><a href="http://macilove.com/news/apps-for-iphone/" class="active">Приложения для iPhone</a><a href="http://macilove.com/news/apps-for-ipad/">Приложения для iPad</a></div></section>';

			}
			break;
			case "apps-for-ipad":{
			$category = 5;
			$active[2] = 'id="active"';
			$title = "Приложения для iPad — Macilove";
			$categoryHeader = '<section id="cat"><h1>Приложения для iPad</h1><div id="filter"><a href="http://macilove.com/news/apps-for-iphone/">Приложения для iPhone</a><a href="http://macilove.com/news/apps-for-ipad/" class="active">Приложения для iPad</a></div></section>';

			}
			break;
			case "apps-for-ios":{
			$category = 6;
			$active[2] = 'id="active"';
			$title = "Приложения для iPhone и iPad - Macilove";
			$categoryHeader = '<section id="cat"><h1>Приложения для iPhone и iPad</h1><div id="filter"><a href="http://macilove.com/news/apps-for-iphone/">Приложения для iPhone</a><a href="http://macilove.com/news/apps-for-ipad/">Приложения для iPad</a></div></section>';


			}
			break;
				case "apps-for-mac-os-x":{
			$category = 7;
			$active[3] = 'id="active"';
			$title = "Приложения для Mac OS X — Macilove";
			$categoryHeader = '<section id="cat"><h1>Приложения для Mac OS X</h1><div id="filter"><a href="http://macilove.com/news/apps-for-mac-os-x/" class="active">Приложения для Mac OS X</a><a href="http://macilove.com/news/games-for-mac-os-x/">Игры для Mac OS X</a></div></section>';
			
		
			}
			break;
			case "games-for-mac-os-x":{
			$category = 8;
			$active[3] = 'id="active"';
			$title = "Игры для Mac OS X — Macilove";
			$categoryHeader = '<section id="cat"><h1>Игры для Mac OS X</h1><div id="filter"><a href="http://macilove.com/news/apps-for-mac-os-x/">Приложения для Mac OS X</a><a href="http://macilove.com/news/games-for-mac-os-x/" class="active">Игры для Mac OS X</a></div></section>';

			}
			
			break;
			case "apps-and-games-for-mac-os-x":{
			$category = 12;
			$active[3] = 'id="active"';
			$title = "Приложения и игры для Mac OS X — Macilove";
			$categoryHeader = '<section id="cat"><h1>Приложения и игры для Mac OS X</h1><div id="filter"><a href="http://macilove.com/news/apps-for-mac-os-x/">Приложения для Mac OS X</a><a href="http://macilove.com/news/games-for-mac-os-x/">Игры для Mac OS X</a></div></section>';

			}
			
			break;
			case "secrets-iphone-ipad":{
			$category = 9;
			$active[4] = 'id="active"';
			$title = "Трюки и секреты iPhone и iPad — Macilove";
			$categoryHeader = '<section id="cat"><h1>Трюки и секреты iPhone и iPad</h1><div id="filter"><a href="http://macilove.com/news/secrets-mac-os-x/">Трюки и секреты Mac OS X</a><a href="http://macilove.com/news/secrets-iphone-ipad/" class="active">Трюки и секреты iPhone и iPad</a></div></section>';
			
			}
			break;
			
			case "secrets-mac-os-x":{
			$category = 10;
			$active[4] = 'id="active"';
			$title = "Трюки и секреты Mac OS X — Macilove";
			$categoryHeader = '<section id="cat"><h1>Трюки и секреты Mac OS X</h1><div id="filter"><a href="http://macilove.com/news/secrets-mac-os-x/" class="active">Трюки и секреты Mac OS X</a><a href="http://macilove.com/news/secrets-iphone-ipad/">Трюки и секреты iPhone и iPad</a></div></section>';
			
			
			}
			break;
			case "tricks-and-secrets-mac-os-x-ios":{
			$category = 11;
			$active[4] = 'id="active"';
			$title = "Трюки и секреты Mac OS X и iOS — Macilove";
			$categoryHeader = '<section id="cat"><h1>Трюки и секреты Mac OS X и iOS</h1><div id="filter"><a href="http://macilove.com/news/secrets-mac-os-x/">Трюки и секреты Mac OS X</a><a href="http://macilove.com/news/secrets-iphone-ipad/">Трюки и секреты iPhone и iPad</a></div></section>';


			}
			break;
			default:{
			
			header("Location ./404/");
			
			/*
$category = 0;
			$active[0] = 'id="active"';
			$title = "Новости Apple для настоящих фанатов";
			$categoryHeader = '<section id="cat"><h1>Новости Apple для настоящих фанатов</h1><div id="filter"><a href="http://macilove.com/news/apple-news/" class="active">Новости Apple</a><a href="http://macilove.com/news/apple-accessories-reviews/">Обзор аксессуаров</a></div></section>';		
*/
			}
			break;
}


$pageCat = $_GET['categories']."/";



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
else{
$category = '""';
}

//	echo $filter;
	
	
//get right now reads
$readNowQuery = mysqli_query($link_new, "SELECT `url`,`version`,`title` FROM `readNow` ORDER BY `id` DESC LIMIT 0,4");

$k=1;
for($n=1; $readNowArr = mysqli_fetch_array($readNowQuery, MYSQLI_ASSOC); $n++)
{
	if($n>2)
		$k = 2;
	
	//new 
	if($readNowArr['version']==1){
		
		$readNow[$k] .= '<div><a href="http://macilove.com/news/'.$readNowArr['url'].'/"><img src="http://macilove.com/img/thumbnails/'.$readNowArr['url'].'-s.jpg" width="120" alt="'.$readNowArr['title'].'"></a><h4><a href="http://macilove.com/news/'.$readNowArr['url'].'/">'.$readNowArr['title'].'</a></h4></div>';
		
						
	}
	else //old
	{
		
		$readNow[$k] .= '<div><a href="http://macilove.com/news/'.$readNowArr['url'].'/"><img src="http://macilove.com/images/'.$readNowArr['url'].'-s.jpg" width="120" alt="'.$readNowArr['title'].'"></a><h4><a href="http://macilove.com/news/'.$readNowArr['url'].'/">'.$readNowArr['title'].'</a></h4></div>'; 
		
	}
			

}
mysqli_free_result($newBDArticleQuery);
	
	
// popular week

$popular_articles_week_query = mysqli_query($link_old, "
SELECT `content_id`,`version`
FROM `statistic_users` 
WHERE `date` > (NOW() - INTERVAL 1 WEEK) 
GROUP BY content_id
ORDER BY COUNT(`content_id`) DESC
LIMIT 0,5");

for($n=1; $popularWeekArticles = mysqli_fetch_array($popular_articles_week_query, MYSQLI_ASSOC); $n++)
{	
	if($popularWeekArticles['version']==0)
	{
		$popular_old_q = mysqli_query($link_old,"SELECT `title`,`url` FROM `content` WHERE `draft`=1 AND `id`=".$popularWeekArticles['content_id']);
		$article = mysqli_fetch_array($popular_old_q, MYSQLI_ASSOC);
		mysqli_free_result($popular_old_q); 	
			
	}
	else
	{
		$popular_new_q = mysqli_query($link_new,"SELECT `title`,`url` FROM `articles` WHERE `draft`=1 AND `id`=".$popularWeekArticles['content_id']);
		$article = mysqli_fetch_array($popular_new_q, MYSQLI_ASSOC);
		mysqli_free_result($popular_new_q);
	}

	$popularWeek .= '<li><h4><a href="http://macilove.com/news/'.$article['url'].'/">'.$article['title'].'</a></h4></li>';

				


}
mysqli_free_result($popular_articles_week_query);





// popular today

$popular_articles_day_query = mysqli_query($link_old, "
SELECT `content_id`,`version`
FROM `statistic_users` 
WHERE `date` > (NOW() - INTERVAL 1 DAY) 
GROUP BY content_id
ORDER BY COUNT(`content_id`) DESC
LIMIT 0,3");

for($n=1; $popularDayArticles = mysqli_fetch_array($popular_articles_day_query, MYSQLI_ASSOC); $n++)
{	
	if($popularDayArticles['version']==0)
	{
			$popular_old_q = mysqli_query($link_old,"SELECT `title`,`url` FROM `content` WHERE `draft`=1 AND `id`=".$popularDayArticles['content_id']);
		$article = mysqli_fetch_array($popular_old_q, MYSQLI_ASSOC);
		mysqli_free_result($popular_old_q); 	
		$imgURL = 'http://macilove.com/images/'.$article['url'];
		
					
	}
	else
	{
		$popular_new_q = mysqli_query($link_new,"SELECT `title`,`url` FROM `articles` WHERE `draft`=1 AND `id`=".$popularDayArticles['content_id']);
		$article = mysqli_fetch_array($popular_new_q, MYSQLI_ASSOC);
		mysqli_free_result($popular_new_q);
	
		$imgURL = 'http://macilove.com/img/thumbnails/'.$article['url'];
	}

	$popularDay .= '<li class="aside-1"><a href="http://macilove.com/news/'.$article['url'].'/"><img src="'.$imgURL.'-l.jpg" width="260"></a><h4><a href="http://macilove.com/news/'.$article['url'].'/">'.$article['title'].'</a></h4></li>';
	
			
}
mysqli_free_result($popular_articles_day_query);



//editors choice
/*

$editors_choice_query = mysqli_query($link_old, "
SELECT `content_id`,`version`
FROM `editors_choice` 
ORDER BY `id` DESC
LIMIT 0,5");

for($n=1; $editorsArticles = mysqli_fetch_array($editors_choice_query, MYSQLI_ASSOC); $n++)
{

	if($editorsArticles['version']==0)
	{
		$editors_old_q = mysqli_query($link_old,"SELECT `title`,`url` FROM `content` WHERE `draft`=1 AND `id`=".$editorsArticles['content_id']);
		$article = mysqli_fetch_array($editors_old_q, MYSQLI_ASSOC);
		mysqli_free_result($editors_old_q); 	
		$imgURL = 'http://macilove.com/images/'.$article['url'];	
	}
	else
	{	
		$editors_new_q = mysqli_query($link_new,"SELECT `title`,`url` FROM `articles` WHERE `id`=".$editorsArticles['content_id']);
		$article = mysqli_fetch_array($editors_new_q, MYSQLI_ASSOC);
		mysqli_free_result($editors_new_q);
		$imgURL = 'http://macilove.com/img/thumbnails/'.$article['url'];
	}



	if($n==3)
	{
		$editorsChoice .= '</li><li class="aside-1"><a href="http://macilove.com/news/'.$article['url'].'/"><img src="'.$imgURL.'-l.jpg" width="260"></a><h4><a href="http://macilove.com/news/'.$article['url'].'/">'.$article['title'].'</a></h4></li><li class="aside-2">';
		
		
		
	}	
	else
	{
		$editorsChoice .= '<div><a href="http://macilove.com/news/'.$article['url'].'/"><img src="'.$imgURL.'-s.jpg" width="120"></a><h4><a href="http://macilove.com/news/'.$article['url'].'/">'.$article['title'].'</a></h4></div>';
	}
		

}
mysqli_free_result($editors_choice_query);
*/




		
		
//READ MORE


$newBDArticleQuery = mysqli_query($link_new,"SELECT `title`,`categories`,UNIX_TIMESTAMP(`pub_date`),`description`,`url` FROM `articles` WHERE `draft`=1 $filter ORDER BY `id` DESC LIMIT 0,16");
	
$max_readMore = 16;


for($n=1; $readMore = mysqli_fetch_array($newBDArticleQuery, MYSQLI_ASSOC); $n++)
{
	$cat = getNewsCategory($readMore['categories']);

	if($n==1)
		$latestArticle = '<a href="http://macilove.com/news/'.$readMore['url'].'/"><img src="http://macilove.com/img/original/'.$readMore['url'].'.jpg" width="560" height="290"></a><h1><a href="http://macilove.com/news/'.$readMore['url'].'/">'.$readMore['title'].'</a></h1><div class="toolbar"><a href="http://macilove.com/news/'.$cat['cat_url'].'/" class="type">'.$cat['cat_title'].'</a></span><span class="sep">|</span><span class="date">'.dateTimeFormatting($readMore['UNIX_TIMESTAMP(`pub_date`)']).'</span></div><p>'.$readMore['description'].'</p><a href="http://macilove.com/news/'.$readMore['url'].'/" class="read-more">Читать дальше</a>';
	else
		$readMoreArticles .= '<li><div class="title"><div class="toolbar"><a href="http://macilove.com/news/'.$cat['cat_url'].'/" class="type">'.$cat['cat_title'].'</a></span><span class="sep">|</span><span class="date">'.dateTimeFormatting($readMore['UNIX_TIMESTAMP(`pub_date`)']).'</span></div><h2><a href="http://macilove.com/news/'.$readMore['url'].'/">'.$readMore['title'].'</a></h2><p>'.$readMore['description'].'</p></div><a href="http://macilove.com/news/'.$readMore['url'].'/"><img src="http://macilove.com/img/thumbnails/'.$readMore['url'].'-m.jpg" width="200" height="140" alt="'.$readMore['title'].'"></a></li>';
	
	$max_readMore--;
}

mysqli_free_result($newBDArticleQuery);


if($max_readMore!=0)
{
	
	$oldBDArticleQuery = mysqli_query($link_old,"SELECT `title`,UNIX_TIMESTAMP(`pub_date`),`categories`,`cut`,`url` FROM `content` WHERE `draft`=1 $filter ORDER BY `id` DESC LIMIT 0,$max_readMore");

	for($n=1; $readMoreOld = mysqli_fetch_array($oldBDArticleQuery, MYSQLI_ASSOC); $n++)
	{
		$cat = getNewsCategory($readMoreOld['categories']);

		if($max_readMore==16){
			$latestArticle = '<a href="http://macilove.com/news/'.$readMoreOld['url'].'/"><img src="http://macilove.com/images/'.$readMoreOld['url'].'.jpg" width="560" height="290"></a><h1><a href="http://macilove.com/news/'.$readMoreOld['url'].'/">'.$readMoreOld['title'].'</a></h1><div class="toolbar"><a href="http://macilove.com/news/'.$cat['cat_url'].'/" class="type">'.$cat['cat_title'].'</a></span><span class="sep">|</span><span class="date">'.dateTimeFormatting($readMoreOld['UNIX_TIMESTAMP(`pub_date`)']).'</span></div><p>'.$readMoreOld['cut'].'</p><a href="http://macilove.com/news/'.$readMoreOld['url'].'/" class="read-more">Читать дальше</a>';
			$max_readMore--;	
		}
		else
			$readMoreArticles .= '<li><div class="title"><div class="toolbar"><a href="http://macilove.com/news/'.$cat['cat_url'].'/" class="type">'.$cat['cat_title'].'</a></span><span class="sep">|</span><span class="date">'.dateTimeFormatting($readMoreOld['UNIX_TIMESTAMP(`pub_date`)']).'</span></div><h2><a href="http://macilove.com/news/'.$readMoreOld['url'].'/">'.$readMoreOld['title'].'</a></h2><p>'.$readMoreOld['cut'].'</p></div><a href="http://macilove.com/news/'.$readMoreOld['url'].'/"><img src="http://macilove.com/images/'.$readMoreOld['url'].'-m.jpg" width="200" height="140" alt="'.$readMoreOld['title'].'"></a></li>';

	}
	
	mysqli_free_result($oldBDArticleQuery);

}

	
	
	
	
	
	
	
?>
<!DOCTYPE HTML>
<html lang="en">
<head prefix="og: http://ogp.me/ns#">
<link rel="stylesheet" type="text/css" href="http://macilove.com/news/style.css">
<link href='http://fonts.googleapis.com/css?family=Noto+Serif:400,700,400italic,700italic&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
<script type="text/javascript" src="http://macilove.com/resources/jquery-2.1.0.min.js"></script>
<title>Новости Apple для настоящих фанатов — Macilove</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<!-- <meta name="apple-itunes-app" content="app-id= 732986215"> -->
<!-- <meta name="viewport" content="width=1140" /> -->
<meta name="viewport" content="width=device-width, initial-scale=1" />
<link rel="shortcut icon" href="http://macilove.com/resources/favicon.ico" />

<link rel="apple-touch-icon-precomposed" href="http://macilove.com/resources/apple-touch-icon-114x114.png">
<link rel="alternate" type="application/rss+xml" href="http://macilove.com/rss/" />

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-8052564-20']);
  _gaq.push(['_trackPageview']);
  
  setTimeout("_gaq.push(['_trackEvent', '15_seconds', 'read'])", 15000);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>


<title><?php echo $title; ?></title>
<meta property="og:title" content="Новости Apple для настоящих фанатов"/>
<meta property="og:type" content="article"/>
<meta property="og:image" content="https://pbs.twimg.com/profile_images/1903863734/metal.png"/>
<meta property="og:description" content="Новости Apple, обзоры приложений, трюки и секреты для OS X и iOS" />
<meta property="og:url" content="http://macilove.com/" />

<link rel="alternate" type="application/rss+xml" href="http://macilove.com/rss/"/>
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="http://macilove.com/resources/apple-touch-icon-114x114.png" />

<script type="text/javascript">
$(window).load(function() {

	$(window).scroll(function(){
	if ($(this).scrollTop() > 2000) {
	$('#up-arrow').fadeIn();
	} else {
		$('#up-arrow').fadeOut();
	}
	});
	
	$('#up-arrow').click(function(){	
	$("html, body").animate({ scrollTop: 0 }, "slow");
	return false;
	});
	
	
  /* Every time the window is scrolled ... */
    $(window).scroll( function(){
    
        $('.hideme').each( function(i){
            
            var bottom_of_object = $(this).position().top + $(this).outerHeight();
            var bottom_of_window = $(window).scrollTop() + $(window).height();
           
            if( bottom_of_window > bottom_of_object ){
                
                $(this).animate({'opacity':'1'},300);
                    
            }
            
        }); 
    
    });

	var asideHeight = 40+$('aside').height() - $(window).height();
	var flag = false;
/*
	console.log("h: "+(40+$('aside').height()));
	console.log("ass: " +asideHeight);
	console.log("br: "+$(window).height());//653
*/
	
	$(window).scroll(function(){
		
		if(asideHeight <= $(window).scrollTop() && !flag)
		{
/* 			console.log($(window).scrollTop()); */

			$('aside').css('position','fixed');
			$('aside').css('bottom', '-10px');
			
			flag = true;
		}	
		else if(asideHeight > $(window).scrollTop() && flag)
		{
			$('aside').css('position','relative','bottom', '');
			flag = false;
		}
	});	
	
	

	//_roost.prompt();
	
});


var showMorePage =2;
var allow_autoload = 1;
var scrolltrigger = 0.9;
var category = <?php echo $category; ?>;

$(window).scroll(function()
{
	
	var wintop = $(window).scrollTop(), docheight = $(document).height(), winheight = $(window).height();


	
	
	if(allow_autoload ==1)
	if  ((wintop/(docheight-winheight)) > scrolltrigger) 
	{
	allow_autoload = 0;
	    $('#spinner').toggle();
		$.post(
			'<?php echo $prefix; ?>./indexMoreArticles.php',  
	        {'showMore':1,'showMorePage':showMorePage,'showMoreColumn':1,'cat':category},  
	        function(responseText){  
		      
		    	$('#news ul').append(responseText); 
		      
				showMorePage++;
		      
	        },  
	        "html"  
	        ).done(function() {
	        allow_autoload = 1; 
		        $('.spinner').toggle();
		    });
	        
	}
});
</script>
<script>
    var _roost = _roost || [];
    _roost.push(['appkey','4c81eda8d1c6482b80fc49459d4c2a33']);

    !function(d,s,id){
        var js, fjs = d.getElementsByTagName(s)[0];
        if(!d.getElementById(id)){
            js=d.createElement(s); js.id=id;
            js.src='//cdn.goroost.com/js/roost.js';
            fjs.parentNode.insertBefore(js,fjs);
        }
    }(document, 'script', 'roost-js');


</script>
<style type="text/css">
#fresh-reversi-banner{
	width: 100%;
	background: hsl(58, 100%, 51%);
	border-bottom: 1px solid #ebebeb;
	display: block;
	color: #212417;
	text-decoration: none;
	font-family: "SF UI Display", "Helvetica Neue", Arial, sans-serif;
	z-index: 100;
	text-align: center;
	line-height: 140%;
	padding: 10px 0;
	box-sizing: border-box;
	margin-bottom: 20px;
}
#fresh-reversi-banner #grey{
	color: #999;
	display: none;
}
#revers-wrapper{
	max-width: 980px;
	text-align: left;
	display: inline-block;
}
#fresh-reversi-banner h1{
	font-size: 16px;
	line-height: 140%;
}
#fresh-reversi-banner h2{
	font-size: 14px;
	font-weight: normal;
	line-height: 140%;
}
#fresh-reversi-banner h3{
	font-size: 14px;
	color: black;
	line-height: 140%;
}
#fresh-icon{
	width: 80px;
	display: inline-block;
	vertical-align: middle;
	margin-right: 10px;
}
#fresh-title{
	display: inline-block;
	vertical-align: middle;
}

</style>
</head>
<body>
	
<nav>
	<div class="pin">
		<a href="http://macilove.com" id="logo"></a>
	<ul>
		<li <?php echo $active[0]; ?>><a href="http://macilove.com/news/apple-news/">Новости Apple</a></li>
		<li <?php echo $active[1]; ?>><a href="http://macilove.com/news/games-for-ios/">iOS игры</a></li>
		<li <?php echo $active[2]; ?>><a href="http://macilove.com/news/apps-for-ios/">iOS приложения</a></li>
		<li <?php echo $active[3]; ?>><a href="http://macilove.com/news/apps-and-games-for-mac-os-x/">Mac приложения</a></li>
		<li <?php echo $active[4]; ?>><a href="http://macilove.com/news/tricks-and-secrets-mac-os-x-ios/">Трюки и секреты</a></li>
	</ul>
	<ul>
		<li><a href="http://macilove.com/best-mac-os-x-apps/">Best Apps</a></li>
		<li><a href="http://macilove.com/os-x-wallpapers/">Обои</a></li>
<!-- 		<li><a href="http://macilove.com/russian-xcode-tutorials/">Xcode уроки</a></li> -->
		<li><a href="http://macilove.com/books/">Книги</a></li>
	</ul>
	<footer>
		<ul>
			<li>© 2015 Macilove.com</li>
			<li><a href="http://macilove.com/about/">О сайте</a></li>
		</ul>
	</footer>
	<div id="up-arrow"></div>
	</div>
</nav>

<article>
<!--
	<a href="https://itunes.apple.com/ru/app/fresh-reversi-othello-like/id732986215?mt=8" id="fresh-reversi-banner" target="_blank" rel="nofollow" width="260" onClick="_gaq.push(['_trackEvent', 'PleeqSoftware', 'Macilove', 'Fresh Reversi - Index Page, Top']);">
	<div id="revers-wrapper">
		<img id="fresh-icon" src="http://pleeq.com/fresh-reversi/fresh-reversi-140px.png">
		
		<div id="fresh-title">
			<h1>Fresh Reversi</h1>
			<h2>iOS игра для развития логики</h2>
			<h3>Скачать в App Store <span id="grey">(119 р.)</span></h3>
		</div>
	</div>
</a>
-->

	<?php echo $categoryHeader; ?>

	<section id="latest">
		<?php echo $latestArticle; ?>
	</section>
	<section class="yandex-index-flow ya-candy">
<!-- Яндекс.Директ -->
<div id="yandex_ad"></div>
<script type="text/javascript">
(function(w, d, n, s, t) {
    w[n] = w[n] || [];
    w[n].push(function() {
        Ya.Direct.insertInto(113966, "yandex_ad", {
            stat_id: 1,
            ad_format: "direct",
            font_size: 0.9,
            font_family: "arial",
            type: "horizontal",
            limit: 1,
            title_font_size: 1,
            links_underline: false,
            site_bg_color: "FFFFFF",
            title_color: "0000CC",
            url_color: "5A7321",
            text_color: "444444",
            hover_color: "0088CC",
            sitelinks_color: "0000CC",
            no_sitelinks: false
        });
    });
    t = d.getElementsByTagName("script")[0];
    s = d.createElement("script");
    s.src = "//an.yandex.ru/system/context.js";
    s.type = "text/javascript";
    s.async = true;
    t.parentNode.insertBefore(s, t);
})(window, document, "yandex_context_callbacks");
</script>
	</section>
	<section id="news">
		<ul>
		<?php echo $readMoreArticles; ?>
		</ul>
		
		<div id="spinner">
			<img src="http://macilove.com/resources/spinner.gif">
		</div>
	</section>
</article>

<aside>
	<ul>
		<li id="search">
			<form method="get" action="http://www.google.com/search">
			<input type="search" name="q" maxlength="255" placeholder="Поиск">
			<input type="hidden" name="sitesearch" value="macilove.com" />
			</form>
		</li>
<!--
		<li class="aside-1">		
			<div>
				<a href="https://itunes.apple.com/ru/app/anchor-pointer-gps-compass/id791684332?mt=8" id="promo-app-ap" target="_blank" rel="nofollow" width="260" onClick="_gaq.push(['_trackEvent', 'PleeqSoftware', 'click', 'Anchor Pointer - Index Page, Top']);"></a>
			</div>
		</li>
-->
		<li class="aside-1">
			<h3>Популярное сегодня</h3>
			<?php echo $popularDay; ?>
		</li>
	<li class="aside-1">
	<!-- Яндекс.Директ -->
<script type="text/javascript">
yandex_partner_id = 113966;
yandex_site_bg_color = 'FFFFFF';
yandex_stat_id = 14;
yandex_ad_format = 'direct';
yandex_direct_type = 'posterVertical';
yandex_direct_limit = 1;
yandex_direct_title_font_size = 3;
yandex_direct_links_underline = false;
yandex_direct_title_color = '3C5160';
yandex_direct_url_color = '006600';
yandex_direct_text_color = '000000';
yandex_direct_hover_color = '0066FF';
yandex_direct_sitelinks_color = '5A7321';
yandex_direct_favicon = false;
yandex_no_sitelinks = false;
document.write('<scr'+'ipt type="text/javascript" src="//an.yandex.ru/system/context.js"></scr'+'ipt>');
</script>
</li>

		<li class="aside-text">
			<h3>Популярное за неделю</h3>
			<ul>
				<?php echo $popularWeek; ?> 
			</ul>
		</li>
<!--
		<li class="aside-1">
			<h3>Рекомендуем установить</h3>
			<div>
				<a href="https://itunes.apple.com/ru/app/fresh-reversi-othello-like/id732986215?mt=8" id="promo-app" target="_blank" rel="nofollow" width="260" onClick="_gaq.push(['_trackEvent', 'PleeqSoftware', 'click', 'Fresh Reversi - Index Page, Bottom']);"></a>
			</div>
		</li>
-->
		<li class="aside-2">
			<h3>Сейчас читают</h3>
			<?php echo $readNow[1]; ?>
		</li>
		<li class="aside-2">
			<?php echo $readNow[2]; ?>
		</li>
	</ul>
</aside>

</body>
</html>