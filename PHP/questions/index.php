<?php                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  session_start();
@include_once("../config.inc.php");
@include_once("../functions.inc.php");
header("Content-type:text/html;charset=utf-8"); 
$link = mysql_connect($DBSERVER, $DBUSER, $DBPASS)
or header("../apple-news/");
mysql_select_db($DB, $link) or die ("Can't select DB");


if($_GET['category']){
$prefix = './.';
$type = mysql_escape_string($_GET['category']);

switch($type){
	case 'app-store':
	$type_id = 1;
	$cat_url = 'app-store';
	$cat_name = 'App Store';
	$icon = 'app-store-icon';
	break;
	case 'imac':
	$type_id = 2;
	$cat_url = 'imac';
	$cat_name = 'iMac';
	$icon = 'imac-icon';
	break;	
	case 'ipad':
	$type_id = 3;
	$cat_url = 'ipad';
	$cat_name = 'iPad';
	$icon = 'ipad-icon';
	break;
	case 'iphone':
	$type_id = 4;
	$cat_url = 'iphone';
	$cat_name = 'iPhone';
	$icon = 'iphone-icon';
	break;
	case 'ipod':
	$type_id = 5;
	$cat_url = 'ipod';
	$cat_name = 'iPod';
	$icon = 'ipod-icon';
	break;
	case 'ios':
	$type_id = 6;
	$cat_url = 'ios';
	$cat_name = 'iOS';
	$icon = 'ios-icon';	
	break;
	case 'macbook':
	$type_id = 7;
	$cat_url = 'macbook';
	$cat_name = 'MacBook';
	$icon = 'macbook-icon';
	break;
	case 'mac-mini':
	$type_id = 8;
	$cat_url = 'mac-mini';
	$cat_name = 'Mac mini';
	$icon = 'mac-mini-icon';	
	break;
	case 'mac-pro':
	$type_id = 9;
	$cat_url = 'mac-pro';
	$cat_name = 'Mac Pro';
	$icon = 'mac-pro-icon';
	break;
	case 'os-x':
	$type_id = 10;
	$cat_url = 'os-x';
	$cat_name = 'OS X';
	$icon = 'os-x-icon';	
	break;
	case 'xcode':
	$type_id = 11;
	$cat_url = 'xcode';
	$cat_name = 'Xcode';
	$icon = 'xcode-icon';	
	break;
	case 'accessories':
	$type_id = 12;
	$cat_url = 'accessories';
	$cat_name = 'Аксессуары';
	$icon = 'accessories-icon';	
	break;
	case 'apps':
	$type_id = 13;
	$cat_url = 'apps';
	$cat_name = 'Приложения';
	$icon = 'applications-icon';
	break;
	case 'other':
	$type_id = 14;
	$cat_url = 'other';
	$cat_name = 'Другое';
	$icon = 'other-icon';	
	break;
	default:
	header("Location: /404/");
	break;
	
}

$get_questions = mysql_query("SELECT * FROM `questions` WHERE `type`=".$type_id." ORDER BY `id` DESC");
$questions_num = mysql_num_rows($get_questions);

$category[$type_id] .= 


'<div class="answers-index-sep"></div>
	

	<div class="answer-index-row">
		<div class="answers-category">
			<a href="'.$prefix.'./'.$cat_url.'/">
				<div class="'.$icon.'">
				</div>
				<h2>'.$cat_name.'</h2>
			</a>
		</div>
		<div class="answers-index-question-box">
			<div class="answers-index-list">';
				



for($cnt = 1; $questions = mysql_fetch_assoc($get_questions); ++$cnt){
	
	$get_answers = mysql_query("SELECT `id` FROM `answers` WHERE `question_id`=".$questions['id']."");

$answers_num = mysql_num_rows($get_answers);

if($answers_num >0){
	$answer = ': '.$answers_num;
	$best_q = mysql_query("SELECT `id` FROM `answers` WHERE `question_id`=".$questions['id']." AND `best`=1"); 
	$best_q_num = mysql_num_rows($best_q);
	if($best_q_num >0)
	$best[$tp_cnt] = mysql_num_rows($best_q);
	else
	$close_best[$tp_cnt] = 'style="display:none;"';
		
}
else
{
$close_best[$tp_cnt] = 'style="display:none;"';
$answer =" нет";
}
			
$category[$type_id] .= '<a href="'.$prefix.'./question/'.$questions['id'].'/" class="question-index-link"><div>'.stripcslashes($questions['title']).'</div><div class="question-index-answers-count">Ответов'.$answer.'</div></a>';
		
	
}
$category[$type_id] .= '<a href="'.$prefix.'./'.$cat_url.'/" class="question-index-all">
					<div class="">Все вопросы: '.$questions_num.'</div>
				</a>
			</div>
		</div>
	</div>';


$title = 'Вопросы и ответы в категории '.$cat_name;

}
else{


$category = '';

for($tp_cnt=1; $tp_cnt < 15; $tp_cnt++){
if($tp_cnt==9)
continue;

$get_questions = mysql_query("SELECT * FROM `questions` WHERE `type`=".$tp_cnt." ORDER BY `id` DESC LIMIT 0,4");


switch($tp_cnt){
	case 1:
	$cat_url = 'app-store';
	$cat_name = 'App Store';
	$icon = 'app-store-icon';
	break;
	case 2:
	$cat_url = 'imac';
	$cat_name = 'iMac';
	$icon = 'imac-icon';
	break;	
	case 3:
	$cat_url = 'ipad';
	$cat_name = 'iPad';
	$icon = 'ipad-icon';
	break;
	case 4:
	$cat_url = 'iphone';
	$cat_name = 'iPhone';
	$icon = 'iphone-icon';
	break;
	case 5:
	$cat_url = 'ipod';
	$cat_name = 'iPod';
	$icon = 'ipod-icon';
	break;
	case 6:
	$cat_url = 'ios';
	$cat_name = 'iOS';
	$icon = 'ios-icon';	
	break;
	case 7:
	$cat_url = 'macbook';
	$cat_name = 'MacBook';
	$icon = 'macbook-icon';
	break;
	case 8:
	$cat_url = 'mac-mini';
	$cat_name = 'Mac mini';
	$icon = 'mac-mini-icon';	
	break;
	case 9:
	$cat_url = 'mac-pro';
	$cat_name = 'Mac Pro';
	$icon = 'mac-pro-icon';
	break;
	case 10:
	$cat_url = 'os-x';
	$cat_name = 'OS X';
	$icon = 'os-x-icon';	
	break;
	case 11:
	$cat_url = 'xcode';
	$cat_name = 'Xcode';
	$icon = 'xcode-icon';	
	break;
	case 12:
	$cat_url = 'accessories';
	$cat_name = 'Аксессуары';
	$icon = 'accessories-icon';	
	break;
	case 13:
	$cat_url = 'apps';
	$cat_name = 'Приложения';
	$icon = 'applications-icon';
	break;
	case 14:
	$cat_url = 'other';
	$cat_name = 'Другое';
	$icon = 'other-icon';	
	break;
	
}
/*
switch($tp_cnt){
	case 1:
	$cat_url = 'iphone';
	$cat_name = 'iPhone';
	$icon = 'iphone-icon';
	break;
	case 2:
	$cat_url = 'ipad';
	$cat_name = 'iPad';
	$icon = 'ipad-icon';
	break;	
	case 3:
	$cat_url = 'ipod';
	$cat_name = 'iPod';
	$icon = 'ipod-icon';
	break;
	case 4:
	$cat_url = 'ios';
	$cat_name = 'iOS';
	$icon = 'ios-icon';	
	break;
	case 5:
	$cat_url = 'macbook';
	$cat_name = 'MacBook';
	$icon = 'macbook-icon';
	break;
	case 6:
	$cat_url = 'imac';
	$cat_name = 'iMac';
	$icon = 'imac-icon';
	break;
	case 7:
	$cat_url = 'mac-mini';
	$cat_name = 'Mac mini';
	$icon = 'mac-mini-icon';	
	break;
	case 8:
	$cat_url = 'os-x';
	$cat_name = 'OS X';
	$icon = 'os-x-icon';	
	break;
	case 9:
	$cat_url = 'mac-pro';
	$cat_name = 'Mac Pro';
	$icon = 'mac-pro-icon';
	break;
	case 10:
	$cat_url = 'app-store';
	$cat_name = 'App Store';
	$icon = 'app-store-icon';
	break;
	case 11:
	$cat_url = 'apps';
	$cat_name = 'Приложения';
	$icon = 'applications-icon';
	break;
	case 12:
	$cat_url = 'accessories';
	$cat_name = 'Аксессуары';
	$icon = 'accessories-icon';	
	break;
	case 13:
	$cat_url = 'xcode';
	$cat_name = 'Xcode';
	$icon = 'xcode-icon';	
	break;
	case 14:
	$cat_url = 'other';
	$cat_name = 'Другое';
	$icon = 'other-icon';	
	break;
	
}
*/
$questions_num_query = mysql_query("SELECT `id` FROM `questions` WHERE `type`=".$tp_cnt."");
$questions_num = mysql_num_rows($questions_num_query);

$category[$tp_cnt] .= '<div class="answers-index-sep"></div>
	

	<div class="answer-index-row">
		<div class="answers-category">
			<a href="'.$prefix.'./'.$cat_url.'/">
				<div class="'.$icon.'">
				</div>
				<h2>'.$cat_name.'</h2>
			</a>
		</div>
		<div class="answers-index-question-box">
			<div class="answers-index-list">';
				




for($cnt = 1; $questions = mysql_fetch_assoc($get_questions); ++$cnt){

$get_answers = mysql_query("SELECT `id` FROM `answers` WHERE `question_id`=".$questions['id']."");

$answers_num = mysql_num_rows($get_answers);

if($answers_num >0){
	$answer = ': '.$answers_num;
	$best_q = mysql_query("SELECT `id` FROM `answers` WHERE `question_id`=".$questions['id']." AND `best`=1"); 
	$best_q_num = mysql_num_rows($best_q);
	if($best_q_num >0)
	$best[$tp_cnt] = mysql_num_rows($best_q);
	else
	$close_best[$tp_cnt] = 'style="display:none;"';
}
else
{
$close_best[$tp_cnt] = 'style="display:none;"';
$answer =" нет";
}
			
$category[$tp_cnt] .= '<a href="'.$prefix.'./question/'.$questions['id'].'/" class="question-index-link"><div>'.stripcslashes($questions['title']).'</div><div class="question-index-answers-count">Ответов'.$answer.'</div></a>';		
	
}





$category[$tp_cnt] .= '<a href="'.$prefix.'./'.$cat_url.'/" class="question-index-all">
					<div class="">Все вопросы: '.$questions_num.'</div>
				</a>
			</div>
		</div>
	</div>';

}
$title = 'Форум вопросов и ответов по Apple устройствам';

}
	
?>

<!DOCTYPE HTML>
<html lang="ru">
<head>
	<link rel="stylesheet" type="text/css" href="http://macilove.com/styles-new.css">
	<link rel="stylesheet" type="text/css" href="http://macilove.com/questions/new-questions.css">
	<link rel="stylesheet" type="text/css" href="http://macilove.com/questions/new-questions-retina.css">
	<link rel="stylesheet" media="only screen and (-webkit-min-device-pixel-ratio: 2)" 	href="http://macilove.com/retina-new.css">
	
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=1024">
	<title>Форум Apple</title>
	
	<meta name="viewport" content="width=1024">	
	<link rel="shortcut icon" href="http://macilove.com/favicon.ico" />
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="http://macilove.com/resources/apple-touch-icon-114x114.png" />

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
</head>


<body>
<nav>
	<ul>
		<li><a href="http://macilove.com/news/" id="logo"></a></li>
		<li><a href="http://macilove.com/news/">Новости</a></li>
		<li><a href="http://macilove.com/questions/" id="active">Форум</a></li>
		<li><a href="http://macilove.com/books/">Книги</a></li>
		<li><a href="http://macilove.com/video/">Видео</a></li>
		<li><a href="http://macilove.com/russian-mac-developers/">Mac разработчики</a></li>
		<li id="search">
		<form method="get" action="http://www.google.com/search">
		<input type="search" placeholder="Поиск">
		<input type="hidden" name="sitesearch" value="macilove.com" />
		</form>
		</li>
	</ul>
</nav>
<div id="main-bg" class="wrapper">
	<div class="answers-top">
		<h1>Форум вопросов и ответов по Apple устройствам</h1>
		<div class="answers-search">
		</div>
<!--  		<a href="http://macilove.com/questions/ask/" class="ask-question-link">Задать вопрос в форум</a>  -->
	</div>



<?php echo $category[4]; ?>	
<?php echo $category[3]; ?>
<?php echo $category[5]; ?>
<?php echo $category[6]; ?>
<?php echo $category[7]; ?>
<?php echo $category[2]; ?>
<?php echo $category[8]; ?>
<?php echo $category[10]; ?>
<?php echo $category[1]; ?>
<?php echo $category[13]; ?>
<?php echo $category[12]; ?>
<?php echo $category[11]; ?>
<?php echo $category[14]; ?>

	</div>
	
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
