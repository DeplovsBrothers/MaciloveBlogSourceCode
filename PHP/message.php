<?php
session_start();
@include_once("./config.inc.php");
@include_once("./functions.inc.php");
header("Content-type:text/html;charset=utf-8"); 
//$link = mysql_connect($DBSERVER, $DBUSER, $DBPASS)
//or die("Can't connect" );
//mysql_select_db($DB, $link) or die ("Can't select DB");

if(!empty($_SESSION['err']))
{

switch($_SESSION['err']){
			case 1:
			$message = "Этот email уже подписан, если вы не получаете от нас письма, попробуйте поискать их в папке «Спам».";
			$title = 'Этот email уже подписан';
			break;
			case 2:
			$message = "На ваш email выслано письмо для подтверждения подписки.";
			$title = 'Вам выслано письмо для подтверждения';	
			break;
			case 3:
			$message = "Вы успешно подписались на рассылку.";
			$title = 'Вы успешно подписались на рассылку';	
			break;
			case 4:
			$message = "Вы успешно отписались от рассылки.";
			$title = 'Вы успешно отписались от рассылки';	
			break;
			
}
	
}
else{
header("Location: ../news/");

}

?>

<!DOCTYPE HTML>
<html>
<head>
<link rel="stylesheet" type="text/css" href="http://macilove.com/styles.css">
<link rel="stylesheet" media="only screen and (-webkit-min-device-pixel-ratio: 2)" 	href="http://macilove.com/retina.css">

<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title><?php echo $title; ?></title>
<script type="text/javascript" src="http://userapi.com/js/api/openapi.js?41"></script>
<meta name="viewport" content="width=1024"><meta name="viewport" content="width=1024">
<link href='http://fonts.googleapis.com/css?family=Varela+Round' rel='stylesheet' type='text/css'>
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="http://macilove.com/images/apple-touch-icon-72x72.png" />
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="http://macilove.com/images/apple-touch-icon-114x114.png" />
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
<div class="wrapper">
<div class="nav">

	<a href="http://macilove.com" id="retina-logo"></a>
	<span class="main-nav">
	<a class="main-menu" href="http://macilove.com/news/">Новости</a>
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
<div class="main-bg" style="padding-top:40px; padding-bottom: 40px; text-align:center; ">

<h1 style="margin-bottom: 20px;"><?php echo $message; ?></h1>
	<a href="http://macilove.com/" class="purple-bubble pulse-animation">Перейти на главную</a>
</div>
<div id="footer">
<span class="copy">© 2013 Macilove.com</span>
<a href="http://macilove.com/about/">О нас</a>
<span class="footer-sep">|</span>
<a href="http://macilove.com/feedback/">Обратная связь</a>
<span class="footer-sep">|</span>
<a href="http://twitter.com/macilove_com" target="_blank">Twitter</a>
<span class="footer-sep">|</span>
<a href="http://vkontakte.ru/macilove_com" target="_blank">Вконтакте</a>
<span class="footer-sep">|</span>
<a href="http://www.facebook.com/pages/Macilove/170787086348435?sk=wall" target="_blank">Facebook</a>
<span class="footer-sep">|</span>
<a href="http://macilove-com.tumblr.com/">Блог</a>
<span class="footer-sep">|</span>
<a href="http://macilove.com/rss/">RSS</a>
</div>

<div id="made-on-mac">
<a href="http://store.apple.com/" id="made-on-a-mac-icon" target="_blank" rel="nofollow"></a>
</div>
</div>
</div>
</body>
</html>
