<?php 
@include_once("../config.inc.php");
@include_once("../functions.inc.php");
header("Content-type:text/html;charset=utf-8"); 
$link = mysql_connect($DBSERVER, $DBUSER, $DBPASS)
or header("../all/");
mysql_select_db($DB, $link) or die ("Can't select DB");


$get_books_q = mysql_query("SELECT `id`,`category`,`url`,`izd`,`img` FROM `books` ORDER BY `category`, id DESC");	
	
$k = 1;	
for($i = 1; $book[$i] = mysql_fetch_array($get_books_q); $i++){


$type = explode('.', $book[$i]['img']);
	$a = 0;
while($type[$a] != '')
{
	$a++;
}
$a--;

$img_ext = $type[$a];


switch($book[$i]['category']){
		case 1:
		$category = 'Компания Apple';
		break;
		case 2:
		$category = 'Биографии';
		break;
		case 3:
		$category = 'Mac OS X';
		break;
		case 4:
		$category = 'iPhone & iPad';
		break;
		case 5:
		$category = 'Программирование под Mac и iOS';
		break;
		case 6:
		$category = 'Руководства';
		break;
		case 7:
		$category = 'Приложения';
		break;
		case 8:
		$category = 'Бизнес';
		break;
	
}


if(empty($book[($i -1)]['category'])){
$body = '<h1 class="category">'.$category.'</h1>
			<div class="see-also-books see-also-bookpage">
			<div class="bookshelf-row">
			<div class="bookshelf-also-book">';

	
	
}
else if($book[($i -1)]['category'] == $book[$i]['category']){
$k++;

if((($k-1) % 5) == 0)
$body .= '</div></div><div class="bookshelf-row"><div class="bookshelf-also-book">';

}
else{
$k = 1;
	
$body .= '</div></div></div>
<h1 class="category">'.$category.'</h1>
<div class="see-also-books see-also-bookpage">
<div class="bookshelf-row">
	<div class="bookshelf-also-book">';	
}



$body .=  '<a href="../'.$book[$i]['url'].'/" class="see-also-book-153">
		<img src="../books-images/'.$book[$i]['url'].'-p.'.$img_ext.'">
		</a>';



	
}	
$body .= '</div></div>';
		
	
?>
<!DOCTYPE HTML>
<html lang="ru">
<head>
<link rel="stylesheet" type="text/css" href="http://macilove.com/styles.css">
<link rel="stylesheet" type="text/css" href="http://macilove.com/books/books.css">
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=1024">
<meta name="description" content="В интернет магазине Аймобилко появилась книга «Стив Джобс» автора Уолтера Айзексона на русском я">
<title>Все книги</title>
<link href="http://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet" type="text/css">
<script type="text/javascript" src="http://userapi.com/js/api/openapi.js?41"></script><meta name="viewport" content="width=1024"><meta name="viewport" content="width=1024">
<link rel="alternate" type="application/rss+xml" href="http://macilove.com/rss/" />
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="http://macilove.com/resources/apple-touch-icon-114x114.png" />
<link rel="shortcut icon" href="http://macilove.com/favicon.ico" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
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

</head>
<body>
<div class="wrapper">
<div class="nav">
	
	<a href="http://macilove.com" id="logo"></a>
	<span class="main-nav">
	<a class="main-menu" href="http://macilove.com/news/">Новости</a>
	<a class="main-menu" href="http://macilove.com/questions/">Форум</a>
	<a class="active-main-menu" href="http://macilove.com/books/">Книги</a>
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
<div class="main-bg books-bg">
<div id="books-toolbar">
	Библиотека Mac пользователя
</div>
<div id="books-toolbar-wrapper">
<div id="books-toolbar-filter">
	<span id="books-filter-left">
		<a href="http://macilove.com/books/"><span id="books-home-icon-inactive"></span>Главная</a>
		<a href="http://macilove.com/books/all/" id="active">Все книги</a>
		<a href="http://macilove.com/books/publishers/">Издательства</a>
	</span>
	<span id="books-filter-right">
		<a href="#">Пользовательское соглашение</a>
	</span>
</div>
</div>


<?php echo $body;?>


</div>
</div>

<div id="footer">
	<span class="copy">© 2013 Macilove.com</span>
	<a href="http://macilove.com/about/">О нас</a>
	<span class="footer-sep">·</span>
	<a href="http://macilove.com/feedback/">Обратная связь</a>
	<span class="footer-sep">·</span>
	<a href="http://twitter.com/macilove_com" target="_blank">Twitter</a>
	<span class="footer-sep">·</span>
	<a href="http://www.facebook.com/pages/macilovecom" target="_blank">Facebook</a>
	<span class="footer-sep">·</span>
	<a href="http://macilove.com/use-of-cookies/">Использование cookies</a>
	<span class="footer-sep">·</span>
	<a href="http://macilove-com.tumblr.com">Блог</a>
	<span class="footer-sep">·</span>
	<a href="http://macilove.com/rss/">RSS</a>
</div>
<div id="made-on-mac">
<a href="http://store.apple.com/" id="made-on-a-mac-icon" target="_blank" rel="nofollow"></a>
</div>
</div>
</div>
</body>
</html>
