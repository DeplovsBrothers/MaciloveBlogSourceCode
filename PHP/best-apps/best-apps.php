<?php 
session_start();
@include_once("../config.inc.php");
header("Content-Type: text/html; charset=utf-8"); 

$link = mysql_connect($DBSERVER, $DBUSER, $DBPASS)
or die("Can't connect" );
mysql_select_db($DB, $link) or die ("Can't select DB");
	
$best_apps_type = 	mysql_real_escape_string($_GET['type']);
	
	switch($best_apps_type){
	case 'mac-os-x':
		$title = 'Лучшие программы для Mac OS X';
		$sub_title = 'Каталог лучших программ для OS X';
		$active_best_type[1] = 'class="active"';
		$type = 1;
		$ad = "<div><a href=\"https://itunes.apple.com/ru/app/anchor-pointer-gps-compass/id791684332?mt=8\" id=\"promo-app-ap\" target=\"_blank\" rel=\"nofollow\" width=\"260\" onClick=\"_gaq.push(['_trackEvent', 'PleeqSoftware', 'click', 'Anchor Pointer - Top Mac Apps']);\"></a></div>";
	
	break;
	case 'mac-os-x-games':
		$title = 'Лучшие игры для Mac OS X';
		$sub_title = 'Каталог лучших игр для OS X';
		$active_best_type[2] = 'class="active"';
		$type = 2;
		$ad = "<div><a href=\"https://itunes.apple.com/ru/app/fresh-reversi-othello-like/id732986215?mt=8\" id=\"promo-app\" target=\"_blank\" rel=\"nofollow\" width=\"260\" onClick=\"_gaq.push(['_trackEvent', 'PleeqSoftware', 'click', 'Fresh Reversi - Top Mac Apps']);\"></a></div>";
		
	break;
	case 'ios':
		$active_best_type[3] = 'class="active"';	
		$type = 3;
	break;
	case 'ios-games':
		$active_best_type[4] = 'class="active"';
		$type = 4;
	break;
	
	}
	

$get_best_apps = mysql_query("SELECT a.*, b.cat_title FROM `best_apps` AS `a`
							  LEFT JOIN `best_apps_category` AS `b` ON a.category_id = b.id
							  WHERE b.type=".$type."
							  ORDER BY b.id, b.cat_title");


$end_row_counter = 0;	
	
for ($count = 1; $best_apps = mysql_fetch_assoc($get_best_apps); ++$count){

	$best_app[$count] = $best_apps;



if($count==1)
{
	$best_apps_content = '<figure><h2>'.$best_app[$count]['cat_title'].'</h2><ul>';
}

if(!empty($best_app[$count]['url-review']))
	$review[$count] = '<span class="sep">|</span><a href="'.$best_app[$count]['url-review'].'">Обзор</a>';



if($count !=1 && $best_app[$count-1]['category_id']!= $best_app[$count]['category_id'])
{ 
	if($best_app[$count-1]['category_id'] == $best_app[1]['category_id']){
		/*
$ad_block = '<div id="best-apps-candy">
	<!-- Яндекс.Директ -->
<div id="yandex_ad"></div>
<script type="text/javascript">
(function(w, d, n, s, t) {
    w[n] = w[n] || [];
    w[n].push(function() {
        Ya.Direct.insertInto(113966, "yandex_ad", {
            ad_format: "direct",
            font_size: 0.9,
            type: "horizontal",
            border_type: "block",
            limit: 1,
            title_font_size: 1,
            site_bg_color: "FFFFFF",
            header_bg_color: "FEEAC7",
            border_color: "FBE5C0",
            title_color: "0088CC",
            url_color: "006600",
            text_color: "000000",
            hover_color: "0088CC",
            favicon: true,
            no_sitelinks: false
        });
    });
    t = d.documentElement.firstChild;
    s = d.createElement("script");
    s.type = "text/javascript";
    s.src = "http://an.yandex.ru/system/context.js";
    s.setAttribute("async", "true");
    t.insertBefore(s, t.firstChild);
})(window, document, "yandex_context_callbacks");
</script>
	</div>';
*/
		
	}

//	echo $end_row_counter%2;
//echo $end_row_counter."<br />";
	if($end_row_counter%3==1)
		$best_apps_content .='<li></li><li></li></ul></figure><figure><h2>'.$best_app[$count]['cat_title'].'</h2><ul>';
	else if((($end_row_counter+1)%3)==0) 	
		$best_apps_content .='<li></li></ul></figure><figure><h2>'.$best_app[$count]['cat_title'].'</h2><ul>';
	else
		$best_apps_content .='</ul></figure><figure><h2>'.$best_app[$count]['cat_title'].'</h2><ul>';
	
	$end_row_counter = 0;
}

if($end_row_counter%3==0 && $end_row_counter!=0)
{
	$best_apps_content .= '</ul><ul>';		

}

/*

if ($count==3){
	$best_apps_content .= $ad."</ul><ul>";
}
*/


	$best_apps_content .= '<li><img src="http://macilove.com/best-apps/images/'.$best_app[$count]['id'].'.png"><div><h3>'.$best_app[$count]['title'].'</h3><p>'.$best_app[$count]['description'].'</p><a href="'.$best_app[$count]['url'].'" rel="nofollow" target="_blank">Скачать</a>'.$review[$count].'</div></li>';		





$end_row_counter++;



$test[$count] = ($end_row_counter+1)%3;

}

	if($end_row_counter%3==1)
		$best_apps_content .='<li></li><li></li></ul></figure>';
	else if((($end_row_counter+1)%3)==0) 	
		$best_apps_content .='<li></li></ul></figure>';
	else
		$best_apps_content .='</ul></figure>';

	
	
?>

<!DOCTYPE HTML>
<html lang="en">
<head prefix="og: http://ogp.me/ns#">
<link rel="stylesheet" type="text/css" href="http://macilove.com/news/style.css">
<link rel="stylesheet" type="text/css" href="http://macilove.com/style-best-apps.css">
<link href='http://fonts.googleapis.com/css?family=Noto+Serif:400,700,400italic,700italic&subset=latin,cyrillic' rel='stylesheet' type='text/css'>

<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=1140">

<title><?php echo $title; ?></title>
<meta property="og:title" content="<?php echo $title; ?>"/>
<meta property="og:type" content="article"/>
<meta property="og:image" content="http://macilove.com/best-apps/images/132.png"/>
<meta property="og:description" content="<?php echo $sub_title; ?>" />
<meta property="og:url" content="" />
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
  
  
/*   console.log(<?php print_r($test); ?>); */
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
</head>
<body>

<nav>
	<div class="pin">
		<a href="http://macilove.com" id="logo"></a>
	<ul>
		<li><a href="http://macilove.com">Новости Apple</a></li>
		<li><a href="http://macilove.com/news/games-for-ios/">iOS игры</a></li>
		<li><a href="http://macilove.com/news/apps-for-ios/">iOS приложения</a></li>
		<li><a href="http://macilove.com/news/apps-and-games-for-mac-os-x/">Mac приложения</a></li>
		<li><a href="http://macilove.com/news/tricks-and-secrets-mac-os-x-ios/">Трюки и секреты</a></li>
	</ul>
	<ul>
		<li id="active"><a href="http://macilove.com/best-mac-os-x-apps/">Best Apps</a></li>
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
	</div>
</nav>

<article id="page">
	<section id="text">
		<div id="ap-top-apps">
		<a href="https://itunes.apple.com/ru/app/anchor-pointer-gps-compass/id791684332?mt=8" id="promo-app-ap" target="_blank" rel="nofollow" width="260" onClick="_gaq.push(['_trackEvent', 'PleeqSoftware', 'click', 'Anchor Pointer - Top Apps']);"></a>
		</div>
			
		<h1><?php echo $title; ?></h1>
		<p id="description"><?php echo $sub_title; ?> по версии редакции Macilove</p>
		<div id="filter">
			<a href="http://macilove.com/best-mac-os-x-apps/" <?php echo $active_best_type[1]; ?>>Лучшие программы</a>
			<a href="http://macilove.com/best-mac-os-x-games/" <?php echo $active_best_type[2]; ?>>Лучшие игры</a>
		</div>
		<?php echo $best_apps_content; ?>
	</section>
	<section id="yandex-top-page">
		<!-- Яндекс.Директ -->
		<div id="yandex_ad"></div>
		<script type="text/javascript">
		(function(w, d, n, s, t) {
		    w[n] = w[n] || [];
		    w[n].push(function() {
		        Ya.Direct.insertInto(113966, "yandex_ad", {
		            stat_id: 5,
		            ad_format: "direct",
		            font_size: 1.2,
		            type: "horizontal",
		            limit: 1,
		            title_font_size: 3,
		            links_underline: false,
		            site_bg_color: "FFFFFF",
		            title_color: "0088CC",
		            url_color: "006600",
		            text_color: "000000",
		            hover_color: "0088CC",
		            sitelinks_color: "0088CC",
		            favicon: true,
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
</article>

</body>
</html>