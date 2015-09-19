<?php
session_start();
@include_once("../config.inc.php");
@include_once("../functions.inc.php");

header("Content-type:text/html;charset=utf-8"); 
$link = mysql_connect($DBSERVER, $DBUSER, $DBPASS)
or header("../");
mysql_select_db($DB, $link) or die ("Can't select DB");

$title = "Новости Apple для настоящих фанатов";

if(!empty($_GET['categories']))
{

$cat_pref = "../";

switch($_GET['categories']){
			case "apple-news":{
			$category = 0;
			$icon_a[0] = "-a";
			$icon_text[0]=" style=\"color:#333\"";
			$title = "Новости Apple для настоящих фанатов";
			}
			break;
			case "ios-games":{
			$category = 1;
			$icon_a[1] = "-a";
			$icon_text[1]=" style=\"color:#333\"";
			$title = "Игры для iOS";
			}
			break;
			case "ios-apps":{
			$category = 2;
			$icon_a[2] = "-a";
			$icon_text[2]=" style=\"color:#333\"";
			$title = "Приложения для iOS";
			}
			break;
			case "mac-apps":{
			$category = 3;
			$icon_a[3] = "-a";
			$icon_text[3]=" style=\"color:#333\"";
			$title = "Приложения для Mac";
			}
			break;
			case "tricks":{
			$category = 4;
			$icon_a[4] = "-a";
			$icon_text[4]=" style=\"color:#333\"";
			$title = "Трюки и секреты";
			}
			break;
			default:{
			$category = 0;
			$icon_a[0] = "-a";
			$icon_text[0]=" style=\"color:#333\"";
			$title = "Новости Apple для настоящих фанатов";
			}
			break;
}
	
$filter = "`categories`=$category";
}
else{
$filter = "type=0";
$no_cat = true;
}


//print_r($_SESSION['last_visit']);
//unset($_SESSION['content_counter']);
//unset($_SESSION['last_visit']);
//unset($_SESSION['pages_category_check']);
//print_r($_SESSION['pages_category_check'][0]);

if(empty($_SESSION['content_counter']) OR empty($_SESSION['last_visit']) OR empty($_SESSION['pages_category_check'])){
if(empty($_COOKIE['user'])){
$hash = md5(microtime(true));
setcookie('user', $hash, time() + 3600 * 24 * 30 , '/');
mysql_query("INSERT INTO `users` VALUES(null, '$hash', null)"); 

$_SESSION['first_time_visit'] = 1;
$number_of_unread= array(0,0,0,0,0);

}
else{
$hash = $_COOKIE['user'];
$user_q = mysql_query("SELECT `id`, UNIX_TIMESTAMP(`last_visit`) FROM `users` WHERE `user_hash`='".$hash."'");
$hash_trouble_check_num  = mysql_num_rows($user_q);

if($hash_trouble_check_num == 0){
mysql_query("INSERT INTO `users` VALUES(null, '".$hash."', null)"); 
$user_q = mysql_query("SELECT `id`, UNIX_TIMESTAMP(`last_visit`) FROM `users` WHERE `user_hash`='".$hash."'");
}
if($hash_trouble_check_num == 1){

setcookie('user', $hash, time() + 3600 * 24 * 30, '/');
$user_l_v = mysql_fetch_array($user_q);
$user_id = $user_l_v[0];
$user_last_visit = $user_l_v[1];

//echo $user_last_visit;  
//if($_COOKIE['user']=='6ced208145b9802d97f3356bb6830ae6')
//$user_last_visit = 4465655;
//if($_COOKIE['user']=='a59e1e917bcfec1d674c3c4b11e1b902')
//$user_last_visit = 1333214728;


$_SESSION['last_visit'] = $user_last_visit;
mysql_query("UPDATE `users` SET `last_visit`=null WHERE id=$user_id");



$number_of_unread_q = mysql_query("SELECT COUNT(`id`) FROM `content` WHERE UNIX_TIMESTAMP(`pub_date`)>$user_last_visit AND categories=0 AND `draft`=1");///news
$num_of_unr_arr = mysql_fetch_array($number_of_unread_q);
$number_of_unread[0] = $num_of_unr_arr[0];


$number_of_unread_q = mysql_query("SELECT COUNT(`id`) FROM `content` WHERE UNIX_TIMESTAMP(`pub_date`)>$user_last_visit AND categories=1 AND `draft`=1");//ios games
$num_of_unr_arr = mysql_fetch_array($number_of_unread_q);
$number_of_unread[1] = $num_of_unr_arr[0];


$number_of_unread_q = mysql_query("SELECT COUNT(`id`) FROM `content` WHERE UNIX_TIMESTAMP(`pub_date`)>$user_last_visit AND categories=2 AND `draft`=1");//ios apps
$num_of_unr_arr = mysql_fetch_array($number_of_unread_q);
$number_of_unread[2] = $num_of_unr_arr[0];



$number_of_unread_q = mysql_query("SELECT COUNT(`id`) FROM `content` WHERE UNIX_TIMESTAMP(`pub_date`)>$user_last_visit AND categories=3 AND `draft`=1");//ios apps
$num_of_unr_arr = mysql_fetch_array($number_of_unread_q);
$number_of_unread[3] = $num_of_unr_arr[0];

$number_of_unread_q = mysql_query("SELECT COUNT(`id`) FROM `content` WHERE UNIX_TIMESTAMP(`pub_date`)>$user_last_visit AND categories=4 AND `draft`=1");//ios apps
$num_of_unr_arr = mysql_fetch_array($number_of_unread_q);
$number_of_unread[4] = $num_of_unr_arr[0];


//print_r($number_of_unread);

//////////////////////////////////////////////////отметка на каждой странице, чтобы не отнимался счетчик при обновлении страницы
for ($cat=0;$cat<=4; $cat++){
$cat_num = ceil($number_of_unread[$cat]/10);
if($cat_num >1)
{
$category_check[$cat][1]=0;
$category_check[$cat] = array_pad($category_check[$cat],$cat_num,0);
}
//for($page_cat=1;$page_cat<=$cat_num; $page_cat++){
//$category_check[$cat][$page_cat]=0;
//}
/////////////////////////////////////////////////////	
		 
}
	

}
else{
$hash = md5(microtime(true));
setcookie('user', $hash, time() + 3600 * 24 * 30 , '/');
mysql_query("INSERT INTO `users` VALUES(null, '$hash', null)"); 

$_SESSION['first_time_visit'] = 1;
$number_of_unread= array(0,0,0,0,0);
	
}
 
}
}
else{
$content_counter = $_SESSION['content_counter'];
$user_last_visit = $_SESSION['last_visit'];
$category_check = $_SESSION['pages_category_check'];


if($content_counter=="f")
$number_of_unread= array(0,0,0,0,0);
else 
$number_of_unread = $content_counter;
}


////////\//\/\/\/\/\//\\//\/\/\/\/\///\/\/\\//\/\/\//\/\/\/\/\/\//\/\/\/\/\/\/\/\//\/\/////////////////////////////////////
/*if(empty($_COOKIE['subscription']) AND empty($_SESSION['first_time_visit'])){
setcookie('subscription', '1', time() + 3600 * 24 * 30, '/');

$hash_user = $_COOKIE['user'];
$check_email = mysql_query("SELECT `email` FROM `email_delivery` WHERE `user`='".$hash_user."'");
$check_num = mysql_num_rows($check_email);
if($check_num==0)
$show_email_form = '<div id="subscribe-box" style="display: block;">
	<div class="popup-question-box">
	<a href="javascript:close_lost()" class="popup-question-close">&times;</a>
	<img src="http://macilove.com/images/email-subscribtion-icon.jpg" width="144" height="87">
	<h3>Подпишитесь на новости Apple по email</h3>
	
	<div class="subscribe-bottom-box">
	<input id="popup_box_email" onkeydown="if (event.keyCode == 13) close_and_submit()"  type="email" placeholder="Ваш email" autofocus>
	<button type="button" onclick="close_and_submit()" id="call-me-back" class="blue-button">Подписаться</button>
	</div>
	</div>
</div>';
}*/
/////////\/\/\/\/\/\/\/\/\/\/\/\/\/\///\/\/\/\/\\//\/\/\/\/\/\/\/\/\/\/\\//////////////////////////////////////////////////
//$unread = array(0,0,0,0,0);

if(isset($_GET['page']) AND $_GET['page']>1){// определяем номер страницы
		$page = $_GET['page'];
		$prefix = "../.";
		if(!$no_cat AND $category_check[$category][$page]==0) 
		$number_of_unread[$category] = $number_of_unread[$category]-10;
		$category_check[$category][$page] =1;
		}
		else {
		if($_GET['page']==1)
		$prefix = "../.";
		else
		$prefix = "";
		$page = 1;
		
		if(!$no_cat)
		$category_check[$category][1]=1;
		//if(!$no_cat){ 
		//$minus = 10;
		//$number_of_unread[$category] = $number_of_unread[$category]-$minus;
		//}
		}

		if($number_of_unread[0] >0){
		$unread[0] ="<div class=\"badge".$icon_a[0]." retina-news-icon-badge\">".$number_of_unread[0]."</div>";
		$title_unread[0] = "title=\"Количество непрочитанных сообщений с вашего последнего визита\"";
		}
		else
		unset($number_of_unread[0]);
		if($number_of_unread[1] >0){
		$unread[1] ="<div class=\"badge".$icon_a[1]." retina-ipad-icon-badge\">".$number_of_unread[1]."</div>";
		$title_unread[1] = "title=\"Количество непрочитанных сообщений с вашего последнего визита\"";
		}
		else
		unset($number_of_unread[1]);
		if($number_of_unread[2] >0){
		$unread[2] ="<div class=\"badge".$icon_a[2]." retina-ios-icon-badge\">".$number_of_unread[2]."</div>";
		$title_unread[2] = "title=\"Количество непрочитанных сообщений с вашего последнего визита\"";
		}
		else
		unset($number_of_unread[2]);
		if($number_of_unread[3] >0){
		$unread[3] ="<div class=\"badge".$icon_a[3]." retina-app-icon-badge\">".$number_of_unread[3]."</div>";
		$title_unread[3] = "title=\"Количество непрочитанных сообщений с вашего последнего визита\"";		
		}
		else
		unset($number_of_unread[3]);
		if($number_of_unread[4] >0){
		$unread[4] ="<div class=\"badge".$icon_a[4]." retina-trick-icon-badge\">".$number_of_unread[4]."</div>";
		$title_unread[4] = "title=\"Количество непрочитанных сообщений с вашего последнего визита\"";		
		}
		else
		unset($number_of_unread[4]);
	
	
		if($number_of_unread[$category]<=10)
		unset($number_of_unread[$category]);
		
		
		if(empty($number_of_unread))
$number_of_unread = "f";

$_SESSION['content_counter']=$number_of_unread;
$_SESSION['pages_category_check'] = $category_check;


$page_query = mysql_query("SELECT `id` FROM `content` WHERE `draft`=1 AND $filter");
$coll = mysql_num_rows($page_query);
$max_page = ceil($coll/10);

$next_button_class = "next-button-comb";
$previous_button_class = "prev-button-comb";

if ($page + 1 <= $max_page){
$next_page = $page + 1;}
else{
$next_button_class = "disable";
$previous_button_class="";

$next_page = $page;
}

if($page - 1 >=1){
$previous_page = $page-1; }
else{
$previous_button_class="disable";
$next_button_class = "";
$previous_page = 1; 
}   

if($max_page==1){
$next_button_class = "disable";
$previous_button_class="disable";
}


$next_page_button  = $prefix."./page/".$next_page."/";
$previous_page_button = $prefix."./page/".$previous_page."/"; 

$limit = ($page-1)*10;


$query = mysql_query("SELECT `id`, `categories`, `title`, UNIX_TIMESTAMP(`pub_date`), `url`, `cut` FROM `content` WHERE `draft`=1 AND  ".$filter." ORDER BY `id` DESC LIMIT ".$limit.",10");


	for ($count = 1; $news = mysql_fetch_assoc($query); ++$count){
		 
		$cont[$count]= $news;
	}
	
	
$n = 1;
while($n<=$count-1){
$com_q = mysql_query("
SELECT c.id
FROM `comments` AS `c`
LEFT JOIN `register` AS `r` ON c.user_id = r.id
WHERE c.article_id=".$cont[$n]['id']."
AND r.confirm=1");


$amount_comments = mysql_num_rows($com_q);

if($amount_comments == 0){
$commets_class = "Написать комментарий";
}
else
$commets_class = "Комментарии (".$amount_comments.")";

$pub_date = $cont[$n]['UNIX_TIMESTAMP(`pub_date`)'];

$date = strftime( "%e", $pub_date);
$year = strftime( "%Y" ,$pub_date);
$month = strftime( "%b" ,$pub_date);
switch($month){
	case "Jan":
	$month = "января";
	break;
	case "Feb":
	$month = "февраля";
	break;
	case "Mar":
	$month = "марта";
	break;
	case "Apr":
	$month = "апреля";
	break;
	case "May":
	$month = "мая";
	break;
	case "Jun":
	$month = "июня";
	break;
	case "Jul":
	$month = "июля";
	break;
	case "Aug":
	$month = "августа";
	break;
	case "Sep":
	$month = "сентября";
	break;
	case "Oct":
	$month = "октября";
	break;
	case "Nov":
	$month = "ноября";
	break;
	case "Dec":
	$month = "декабря";
	break;
}

$published = $date.' '.$month.', '.$year;



/*
if($no_cat == true AND isset($number_of_unread[$cont[$n]['categories']])){
$number_of_unread[$cont[$n]['categories']] = $number_of_unread[$cont[$n]['categories']] - 1;
if($number_of_unread[$cont[$n]['categories']] <= 0)
unset($number_of_unread[$cont[$n]['categories']]);
}*/


if($pub_date < $user_last_visit AND $triger == false){

$break_line = "<div class=\"post-box\"><div class=\"later-sep\"><span>Ранее</span></div></div>";
if($n == 1){
$break_line ="";
}
$triger = true;
}
else 
$break_line ="";


$all_content .= $break_line."<div class=\"post-box\">
		<a href=\"".$cat_pref.$prefix."./".$cont[$n]['url']."/\" class=\"post-title\">".stripslashes($cont[$n]['title'])."</a>
		<span class=\"date\">".$published."</span>
		<div class=\"image\">
		<a href=\"".$cat_pref.$prefix."./".$cont[$n]['url']."/\">
		<img width=\"520\" height=\"270\" src=\"".$cat_pref.$prefix."./../images/".$cont[$n]['url'].".jpg\" alt=\"".$cont[$n]['title']."\">
		</a>
		</div>
		<p class=\"post-text-index\">
		".stripslashes($cont[$n]['cut'])."
		</p>		
		<div class=\"read-more\">
		<a href=\"".$cat_pref.$prefix."./".$cont[$n]['url']."/#comments\" class=\"read-more-comments\">".$commets_class."</a>
		</div>
</div>";

$n++;
}

/*
if($category == 1)
{

$main_news_disp_none = "style=\"display:none\"";

$q = mysql_query("SELECT * FROM `daily_deals` WHERE `ipad`=0 OR `ipad`=1 OR `ipad`=2 ORDER BY `id` DESC LIMIT 0,5");


	for ($n_dd = 1; $arr_dd = mysql_fetch_assoc($q); ++$n_dd){
		 
		$daily_deals[$n_dd]= $arr_dd;
	
	}

$price_down_apps = "<div class=\"top-news-box\">
<h3>Уцененные игры</h3>";

for($k_dd = 1; $k_dd <= mysql_num_rows($q); ++$k_dd)
$price_down_apps .= "
	<div class=\"selling-news\">
	<a href=\"".stripslashes($daily_deals[$k_dd]['url'])."\">
	<img src=\"".stripslashes($daily_deals[$k_dd]['image'])."\" width=\"78\" height=\"78\">
	<span class=\"selling-news-title\">
	<p class=\"app-name\">".stripslashes($daily_deals[$k_dd]['name'])."</p>
	<p class=\"price-was\">Было: ".stripslashes($daily_deals[$k_dd]['price_was'])."</p>
	<p class=\"price-now\">Стало: ".stripslashes($daily_deals[$k_dd]['price_now'])."</p>
	</span>
	</a>
	</div>";

$price_down_apps .= "</div>";
}
*/


/*
$new_ads_q = mysql_query("SELECT * FROM `advertising` ORDER BY `id` DESC LIMIT 4");

for($i=1;$arr_ads=mysql_fetch_assoc($new_ads_q); $i++)
{

switch ($arr_ads['item']){
	case 1:
	$item = "iPad";
	$stock_img = "/stock-images/ipad-s.jpg";
	break;
	case 2:
	$item = "iPhone";
	$stock_img = "/stock-images/iphone-s.jpg";
	break;
	case 3:
	$item = "iPod";
	$stock_img = "/stock-images/ipod-s.jpg";
	break;
	case 4:
	$item = "iMac";
	$stock_img = "/stock-images/imac-s.jpg";
	break;
	case 5:
	$item = "MacBook";
	$stock_img = "/stock-images/macbook-s.jpg";
	break;
	case 6:
	$item = "MacBook Pro";
	$stock_img = "/stock-images/macbook-pro-s.jpg";
	break;
	case 7:
	$item = "MacBook Air";
	$stock_img = "/stock-images/macbook-air-s.jpg";
	break;
	case 8:
	$item = "Mac Mini";
	$stock_img = "/stock-images/mac-mini-s.jpg";
	break;
	case 9:
	$item = "Mac Pro";
	$stock_img = "/stock-images/mac-pro-s.jpg";
	break;
	case 10:
	$item = "Apple Дисплей";
	$stock_img = "/stock-images/display-s.jpg";
	break;
	case 11:
	$item = "Аксессуары";
	$stock_img = "/stock-images/accessories-s.jpg";
	break;
	case 12:
	$item = "Другое";
	$stock_img = "/stock-images/other-s.jpg";
	break;	
}

switch ($arr_ads['model']){
	case 1:
	$model = "3";
	break;
	case 2:
	$model = "2";
	break;
	case 3:
	$model = "1";
	break;
	case 4:
	$model = "4S";
	break;
	case 5:
	$model = "4";
	break;
	case 6:
	$model = "3GS";
	break;
	case 7:
	$model = "3G";
	break;
	case 8:
	$model = "2G";
	break;
	case 9:
	$model = "Touch";
	break;
	case 10:
	$model = "Nano";
	break;
	case 11:
	$model = "Shuffle";
	break;
	case 12:
	$model = "Classic";
	break;
	case 13:
	$model = "";
	break;
	case 14:
	$model = "Аллюминиевый";
	break;
	case 15:
	$model = "Черный";
	break;
	case 16:
	$model = "Белый";
	break;
	case 17:
	$model = "Unibody";
	break;
	case 18:
	$model = "PowerBook";
	break;
	case 19:
	$model = "iBook";
	break;
	case 20:
	$model = "";
	break;
}


if($arr_ads['item'] <4)
$show_model[$i] = $model;



$ad_ph = $arr_ads['id']."/photo_1_pr.";

if($arr_ads['photo_1']==1)
{
$ext = "jpg";
$ad_ph .=$ext;
}
else if($arr_ads['photo_1']==2)
{
$ext = "png";
$ad_ph .=$ext;
}
else
$ad_ph = $stock_img;

$price = $arr_ads['price'];
if(strlen($price)>3)
$price = substr($price,-(strlen($price)),-3)." ".substr($price,-3);

$ads .= "<div class=\"top-news\">
	<a href=\"http://macilove.com/ad/".$arr_ads['url']."/\" class=\"more-small-box\">
	<img src=\"http://macilove.com/adv/".$ad_ph."\" alt=\"".$item." ".$show_model[$i]."\" width=\"120\" height=\"80\">
	<span class=\"top-news-title\"><p>".$item." ".$show_model[$i]."<br />".$price." р.</p></span>
	</a>
	</div>";
}
$ads .= "";

*/



$mn_q = mysql_query("SELECT `url` FROM `main_news` ORDER BY `id` DESC");
$main_news = '';
for($mn_c =1; $mn_arr = mysql_fetch_array($mn_q); $mn_c++){
$mn_arr_q = mysql_query("SELECT `url`,`title` FROM `content` WHERE `url`='".$mn_arr[0]."'");	
$mn_cont_arr = mysql_fetch_assoc($mn_arr_q);

$main_news .= '<div class="top-news">
<a href="http://macilove.com/news/'.$mn_cont_arr['url'].'/">
<img src="http://macilove.com/images/'.$mn_cont_arr['url'].'-s.jpg" alt="'.$mn_cont_arr['title'].'" width="120" height="80">
<span class="top-news-title">'.stripslashes($mn_cont_arr['title']).'</span>
</a>
</div>';
	
	
} 

$test_this_shit = $unread[4];
$test_this_shit_1 = $icon_text[4];

?>

<!DOCTYPE HTML>
<html lang="ru">
<head>
<link rel="stylesheet" type="text/css" href="https://s3-eu-west-1.amazonaws.com/macilove/style.css">
<link rel="stylesheet" media="only screen and (-webkit-min-device-pixel-ratio: 2)" 	href="https://s3.amazonaws.com/MaciloveNews/retina.css"/>

<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="Description" content="Новости Apple для настоящих фанатов" />
<meta http-equiv="Keywords" content="itunes, ipad, iphone, mac os x, mac, macintosh, блог, новости Apple, игры для iphone" />
<meta name="viewport" content="width=1024">
<title><?php echo $title; 	 ?></title>
<link rel="shortcut icon" href="http://macilove.com/favicon.ico" />
<link rel="alternate" type="application/rss+xml" title="Новости Apple для настоящих фанатов" href="http://macilove.com/rss/" />
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="http://macilove.com/images/apple-touch-icon-114x114.png" />
</head>
<?php flush(); ?>
<body>
<?php echo $show_email_form; ?>
<div class="wrapper">
<div class="nav">

	<a href="http://macilove.com" id="retina-logo"></a>
	<span class="main-nav">
	<a class="active-main-menu" href="http://macilove.com/news/">Новости</a>
	<a class="main-menu" href="http://macilove.com/questions/">Форум</a>
	<a class="main-menu" href="http://macilove.com/books/">Книги</a>
	<a class="main-menu" href="http://macilove.com/video/">Видео</a>
	<a class="main-menu" href="http://macilove.com/russian-mac-developers/">Mac разработчики</a>
	</span> 
	
	<span id="search-box">
	<form method="get" action="http://www.google.com/search">
	<input type="search" name="q" size="25" maxlength="255" placeholder="Поиск">
	<input type="hidden" name="sitesearch" value="macilove.com" />
	</form>
	</span>
	
</div>
</div>

<div class="wrapper">
<div class="main-bg" style="margin-top:10px;">
<div class="left-side">

<div class="filter-box">
	
	<a href="http://macilove.com/news/apple-news/" class="filter-icons">
	<span class="retina-news-icon<?php echo $icon_a[0]; ?>"></span>
	<p <?php echo $icon_text[0]; ?>>Новости Apple</p>
	<?php echo $unread[0]; ?>
	</a>

	<a href="http://macilove.com/news/ios-games/" class="filter-icons">
	<span class="retina-ipad-icon<?php echo $icon_a[1]; ?>"></span>
	<p <?php echo $icon_text[1]; ?>>Игры для iOS</p>
	<?php echo $unread[1]; ?>
	</a>
	
			
	<a href="http://macilove.com/news/ios-apps/" class="filter-icons">
	<span class="retina-ios-icon<?php echo $icon_a[2]; ?>"></span>
	<p <?php echo $icon_text[2]; ?>>Приложения<br/>для iOS</p>
	<?php echo $unread[2]; ?>
	</a>
	
	<a href="http://macilove.com/news/mac-apps/" class="filter-icons">
	<span class="retina-app-icon<?php echo $icon_a[3]; ?>"></span>
	<p <?php echo $icon_text[3]; ?>>Приложения<br/>для Mac</p>
	<?php echo $unread[3]; ?>
	</a>
	
	<a href="http://macilove.com/news/tricks/" class="filter-icons">
	<span class="retina-trick-icon<?php echo $icon_a[4]; ?>"></span>
	<p <?php echo $icon_text[4]; ?>>Трюки и секреты</p>
<?php echo $unread[4]; ?>
	
	</a>
	
</div>
	
	




<div class="content-box">
<div class="left-content">
<?php echo $all_content; ?>
<div class="pages-box">
	<span class="page-number">Страницы <?php echo $page; ?> из <?php echo $max_page; ?></span>
	<span class="page-buttons">
	
	<a href="<?php echo $previous_page_button; ?>" class="prev-button <?php echo $previous_button_class; ?> page-button"><span class="prev-p-arrow"></span> Предыдущая</a>
	<a href="<?php echo $next_page_button; ?>" class="next-button <?php echo $next_button_class; ?> page-button">Следующая <span class="next-p-arrow"></span></a>
	</span>
</div>
</div>

<?php echo $price_down_apps; ?>

<div class="top-news-box" <?php echo $main_news_disp_none; ?>>
<h3>Главные новости</h3>

<?php echo $main_news; ?>

</div>

<a href="http://macilove.com/best-ios-games/" id="best-mac-apps-link">
<img src="http://macilove.com/images/best-ios-games-icon.png" width="150" height="97" alt="Лучшие игры для iOS">
<p>
Лучшие игры для iOS
</p>
</a>

<a href="http://macilove.com/best-mac-os-x-apps/" id="best-mac-apps-link">
<img src="http://macilove.com/images/best-apps-images/best-apps-icon.png" width="150" height="97" alt="Лучшие приложения для OS X">
<p>
Лучшие приложения для OS X
</p>
</a>

<a href="http://macilove.com/questions/" id="best-mac-apps-link">
<img src="http://macilove.com/images/questions.png" width="150" height="97" alt="Вопросы и ответы по Apple устройствам">
<p>
Вопросы и ответы<br/>по Apple устройствам
</p>
</a>


<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/ru_RU/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<div id="fb-widget">
<div class="fb-like" data-href="http://macilove.com/news/apple-news/" data-send="false" data-width="224" data-show-faces="true" data-font="lucida grande"></div>
</div>

<div id="vk-widget">
<script type="text/javascript" src="http://userapi.com/js/api/openapi.js?47"></script>
<div id="vk_groups"></div>
<script type="text/javascript">
VK.Widgets.Group("vk_groups", {mode: 0, width: "200", height: "290"}, 32338886);
</script> 
</div>

</div>
</div>
</div>
<div id="footer">
<span class="copy">© 2013 Macilove.com</span>
<a href="http://macilove.com/about/">О нас</a>
<span class="footer-sep">|</span>
<a href="http://macilove.com/feedback/">Обратная связь</a>
<span class="footer-sep">|</span>
<a href="http://twitter.com/#!/macilove_com" target="_blank">Twitter</a>
<span class="footer-sep">|</span>
<a href="http://vkontakte.ru/macilove_com" target="_blank">Вконтакте</a>
<span class="footer-sep">|</span>
<a href="http://www.facebook.com/pages/Macilove/170787086348435?sk=wall" target="_blank">Facebook</a>
<span class="footer-sep">|</span>
<a href="http://macilove-com.tumblr.com">Блог</a>
<span class="footer-sep">|</span>
<a href="http://macilove.com/rss/">RSS</a>
</div>

<div id="made-on-mac">
<a href="http://store.apple.com/" id="made-on-a-mac-icon" target="_blank" rel="nofollow"></a>
</div>
</div>
</body>
</html>
<script type="text/javascript">
 var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-8052564-20']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>
<script type="text/javascript">

function close_lost(){
document.body.style.overflow="visible";
document.getElementById('subscribe-box').style.display = "none";

}


function close_and_submit() {

email = document.getElementById('popup_box_email').value;

if(email == '')
return;


document.body.style.overflow="visible";
document.getElementById('subscribe-box').style.display = "none";

var checkStr = "email=" + email+"&fm=1";

     var xmlHttpReq = false;
    var self = this;
    // Mozilla/Safari
    if (window.XMLHttpRequest) {
        self.xmlHttpReq = new XMLHttpRequest();
    }
    // IE
    else if (window.ActiveXObject) {
        self.xmlHttpReq = new ActiveXObject("Microsoft.XMLHTTP");
    }

    self.xmlHttpReq.open('POST', '../email_delivery_handler.php', true);
    self.xmlHttpReq.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    self.xmlHttpReq.onreadystatechange = function() {
        if (self.xmlHttpReq.readyState == 4 && self.xmlHttpReq.status == 200) {
        }
    }
    self.xmlHttpReq.send(checkStr);

}

</script>