<?php 
@include_once("../config.inc.php");
@include_once("../functions.inc.php");
header("Content-type:text/html;charset=utf-8"); 
$link = mysql_connect($DBSERVER, $DBUSER, $DBPASS)
or die("Can't connect" );
mysql_select_db($DB, $link) or die ("Can't select DB");


if(empty($_GET['book']))
header("Location: ./");
$book_url = mysql_escape_string($_GET['book']);
$check_for_book = mysql_query("SELECT * FROM `books` WHERE `url`='".$book_url."'");

$num = mysql_num_rows($check_for_book);
if($num !=1)
header("Location: /404/");

$book = mysql_fetch_assoc($check_for_book);

$id = $book['id'];
/* read too books */


$latest_tag_query = mysql_query("SELECT `tag_id` FROM `tag_books` WHERE `book_id`=".$id."");


for ($count = 1; $t = mysql_fetch_assoc($latest_tag_query); ++$count){
		$preview_tags .= $t['tag_id'].", ";
		
		}
	$l = strlen("$preview_tags")-2;
$preview_tags = substr($preview_tags,0,$l);	
		  
if(!empty($preview_tags)){

$preview_query = mysql_query("SELECT tb.book_id
FROM  `tag_books` AS  `tb` 
LEFT JOIN `books` AS `b` ON b.id=tb.book_id
WHERE tb.tag_id
IN ( ".$preview_tags." ) 
AND tb.book_id !=".$id."
"); //AND b.categories = ".$category."

$mnr=mysql_num_rows($preview_query);
}
else
$mnr = 0;

if($mnr>=1){
for($count = 0; $k = mysql_fetch_assoc($preview_query); ++$count){
	$pr_quer[$count] = $k['book_id'];
}

$pr_quer = array_values(array_unique($pr_quer));
$pr_n_r = count($pr_quer)-1;

if($pr_n_r > 10){

for($cnt = 1; $cnt <= 10; $cnt++){


if($cnt ==1){
$random = rand(0, $pr_n_r);
$also_arr[$cnt] = $random;
}
else{
do
$random = rand(0, $pr_n_r);
while(in_array($random, $also_arr));
$also_arr[$cnt] = $random;
}


$option = "WHERE `id`=".$pr_quer[$random]."";
$no_option[$cnt] .= " AND `id`!=".$pr_quer[$random]."";
$not_option = $not_option.$no_option[($cnt-1)];

$get_also_books_q = mysql_query("SELECT `url`,`img` FROM `books` ".$option.$not_option."");
$also_book = mysql_fetch_assoc($get_also_books_q);

	$atype = explode('.', $also_book['img']);
	$a = 0;
while($atype[$a] != '')
{
	$a++;
}
$a--;

$also_img_ext = $atype[$a];


if($cnt == 1)
$also_books_body = '<div class="bookshelf-row">
	<div class="bookshelf-also-book">
		<a href="../'.$also_book['url'].'/" class="see-also-book-153">
		<img src="../books-images/'.$also_book['url'].'-p.'.$also_img_ext.'">
		</a>';
else if($cnt == 5){
	
$also_books_body .= '<a href="../'.$also_book['url'].'/" class="see-also-book-153">
		<img src="../books-images/'.$also_book['url'].'-p.'.$also_img_ext.'">
		</a>
	</div>
</div>
<div class="bookshelf-row">
	<div class="bookshelf-also-book">';
	
}
else if($cnt == 10){
$also_books_body .= '<a href="../'.$also_book['url'].'/" class="see-also-book-153">
		<img src="../books-images/'.$also_book['url'].'-p.'.$also_img_ext.'">
		</a>
	</div>
</div>';
}
else
$also_books_body .= '<a href="../'.$also_book['url'].'/" class="see-also-book-153">
		<img src="../books-images/'.$also_book['url'].'-p.'.$also_img_ext.'">
		</a>';



//$pr_n_r = $pr_n_r -1;
	
}

}
else{

if($pr_n_r >= 3){

for($cnt = 1; $cnt <= $pr_n_r; $cnt++){




if($cnt ==1){
$random = rand(0, $pr_n_r);
$also_arr[$cnt] = $random;
}
else{
do
$random = rand(0, $pr_n_r);
while(in_array($random, $also_arr));
$also_arr[$cnt] = $random;
}


$option = "WHERE `id`=".$pr_quer[$random]."";
$no_option[$cnt] .= " AND `id`!=".$pr_quer[$random]."";
$not_option = $not_option.$no_option[($cnt-1)];

$get_also_books_q = mysql_query("SELECT `url`,`img` FROM `books` ".$option.$not_option."");
$also_book = mysql_fetch_assoc($get_also_books_q);

	$atype = explode('.', $also_book['img']);
	$a = 0;
while($atype[$a] != '')
{
	$a++;
}
$a--;

$also_img_ext = $atype[$a];


if($cnt == 1)
$also_books_body = '<div class="bookshelf-row">
	<div class="bookshelf-also-book">
		<a href="../'.$also_book['url'].'/" class="see-also-book-153">
		<img src="../books-images/'.$also_book['url'].'-p.'.$also_img_ext.'">
		</a>';
else if($cnt == 5 AND $cnt !=$pr_n_r){
	
$also_books_body .= '<a href="../'.$also_book['url'].'/" class="see-also-book-153">
		<img src="../books-images/'.$also_book['url'].'-p.'.$also_img_ext.'">
		</a>
	</div>
</div>
<div class="bookshelf-row">
	<div class="bookshelf-also-book">';
	
}
else if($cnt == $pr_n_r){
$also_books_body .= '<a href="../'.$also_book['url'].'/" class="see-also-book-153">
		<img src="../books-images/'.$also_book['url'].'-p.'.$also_img_ext.'">
		</a>
	</div>
</div>';
}
else
$also_books_body .= '<a href="../'.$also_book['url'].'/" class="see-also-book-153">
		<img src="../books-images/'.$also_book['url'].'-p.'.$also_img_ext.'">
		</a>';



//$pr_n_r = $pr_n_r -1;
	
}



}
else{

$rand_query = mysql_query("SELECT `url`,`img` FROM `books` WHERE id !=".$id." AND `category`=".$book['category']." ORDER BY RAND() LIMIT 5");
for ($rn_c = 1; $rand_arr = mysql_fetch_assoc($rand_query); ++$rn_c){

	$rtype = explode('.', $rand_arr['img']);
	$r = 0;
while($rtype[$r] != '')
{
	$r++;
}
$r--;

$rand_img_ext = $rtype[$r];

	if($rn_c == 1)	 
	$also_books_body = '<div class="bookshelf-row">
	<div class="bookshelf-also-book">
		<a href="../'.$rand_arr['url'].'/" class="see-also-book-153">
		<img src="../books-images/'.$rand_arr['url'].'-p.'.$rand_img_ext.'">
		</a>';
else
	$also_books_body .= '<a href="../'.$rand_arr['url'].'/" class="see-also-book-153">
		<img src="../books-images/'.$rand_arr['url'].'-p.'.$rand_img_ext.'">
		</a>';
}
	$also_books_body .=	'</div></div>';


}		
}
}
else{

$rand_query = mysql_query("SELECT `url`,`img` FROM `books` WHERE id !=".$id." AND `category`=".$book['category']." ORDER BY RAND() LIMIT 5");


for ($rn_c = 1; $rand_arr = mysql_fetch_assoc($rand_query); ++$rn_c){
	$rtype = explode('.', $rand_arr['img']);
	$r = 0;
while($rtype[$r] != '')
{
	$r++;
}
$r--;

$rand_img_ext = $rtype[$r];
	
	if($rn_c == 1)	 
	$also_books_body = '<div class="bookshelf-row">
	<div class="bookshelf-also-book">
		<a href="../'.$rand_arr['url'].'/" class="see-also-book-153">
		<img src="../books-images/'.$rand_arr['url'].'-p.'.$rand_img_ext.'">
		</a>';
else
	$also_books_body .= '<a href="../'.$rand_arr['url'].'/" class="see-also-book-153">
		<img src="../books-images/'.$rand_arr['url'].'-p.'.$rand_img_ext.'">
		</a>';
}
	$also_books_body .=	'</div></div>';

}			

//echo '<a href="../editor_book.php?url='.$book_url.'">Editor</a>';



$ftype = explode('.', $book['img']);

$i = 0;
while($ftype[$i] != '')
{
	$i++;
}
$i--;

$ftype = $ftype[$i];


$image = '../books-images/'.$book['url'].'.'.$ftype;


?>
<!DOCTYPE HTML>
<html lang="ru">
<head>
<link rel="stylesheet" type="text/css" href="http://macilove.com/styles.css">
<link rel="stylesheet" type="text/css" href="http://macilove.com/books/books.css">
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=1024">
<meta name="description" content="Купить книгу <?php echo $book['title']; ?>">
<meta name="format-detection" content="telephone=no">
<title>Книга: «<?php echo $book['title']; ?>»</title>

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
	<a class="main-menu" href="http://macilove.com/russian-xcode-tutorials/">Mac разработчики</a>
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
		<a href="http://macilove.com/books/all/">Все книги</a>
		<a href="http://macilove.com/books/publishers/">Издательства</a>
	</span>
	<span id="books-filter-right">
		<a href="#">Пользовательское соглашение</a>
	</span>
</div>
</div>

<div class="book-page-box">
	<div class="book-page-cover">
		<a href="<?php echo $book['ozon_url']; ?>" target="_blank">
		<img src="<?php echo $image; ?>" title="<?php echo $book['title']; ?>">
		</a>
		<h5>Выходные данные</h5>
		<p>Объем: <?php echo $book['volume']; ?> стр.<br/>
		Формат: <?php echo $book['format']; ?><br/>
		Переплет: <?php echo $book['cover']; ?><br/>
		<?php echo $book['ISBN']; ?><br/>
		</p>
	</div>
	<div class="book-page-title">
		<h1><?php echo $book['title']; ?></h1>
		<p class="author">Автор: <?php echo $book['author']; ?><br />Издательство: <?php echo $book['izd']; ?></p>
		<p class="price">234 руб.</p>
		<a class="buy-book-link" href="<?php echo $book['ozon_url']; ?>" target="_blank">Купить в Ozon.ru</a>
		<h3>От производителя</h3>
		<p><?php echo nl2br($book['izd_text']); ?></p>
	</div>
	<div class="book-info-bottom-border">
	</div>
	</div>

<div class="see-also-books see-also-bookpage">
<h2>Вам должно понравиться</h2>

<?php echo $also_books_body; ?>

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
