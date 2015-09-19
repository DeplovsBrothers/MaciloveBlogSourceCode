<?php
@include_once("./config.inc.php");
@include_once("./functions.inc.php");

header("Content-type:text/html;charset=utf-8");
$link = mysql_connect($DBSERVER, $DBUSER, $DBPASS)
or die("Can't connect" );
mysql_select_db($DB, $link) or die ("Can't select DB");

//$presentation_number =0;
//$presentation_number =1;
//$presentation_number =2;
$presentation_number =3;

if(!empty($_GET['page']) AND $_GET['page']>1){// определяем номер страницы
$page = $_GET['page'];
$prefix = "../../live/.";
$stop_autoposting = 1;
}
else if($_GET['page']==1){
	header("Location: http://macilove.com/live/");

}
else {
$page = 1;
$prefix = "";
$previous_button_disabled="style=\"display:none;\"";
$stop_autoposting = 0;
}







$page_query = mysql_query("SELECT `id` FROM `live` WHERE `presentation`=".$presentation_number."");
$coll = mysql_num_rows($page_query);
$max_page = ceil($coll/10);
if($max_page <=1)
$pg = "style=\"display:none;\"";

$next_button_class = "next-page-con";
$previous_button_class = "prew-page-con";

if ($page + 1 <= $max_page){
$next_page = $page + 1;}
else{
$next_button_class = "disable";
$previous_button_class="prew-page-sep";

$next_page = $page;
}

if($page - 1 >=1){
$previous_page = $page-1; }
else{
$previous_button_class="disable";
$next_button_class = "next-page-sep";
$previous_page = 1;
}

$next_page_button = $prefix."./page/".$next_page."/";
$previous_page_button = $prefix."./page/".$previous_page."/";

$limit = ($page-1)*10;

$query = mysql_query("SELECT `id`, `type`,`content`, UNIX_TIMESTAMP(`time`) FROM `live` WHERE `presentation`=".$presentation_number." ORDER BY `id` ASC LIMIT ".$limit.",10");

for ($count = 1; $news = mysql_fetch_assoc($query); ++$count){
$cont[$count]= $news;
}
$n = 1;
$last_post_id = 0;
while($n<=$count-1){

if($n==1)
$last_post_id = $cont[$n]['id'];



$pub_date = ($cont[$n]['UNIX_TIMESTAMP(`time`)']);

$hour = strftime( "%H", $pub_date);
$minute = strftime( "%M" ,$pub_date);
$second = strftime( "%S" ,$pub_date);
$hour = $hour;

$published = $hour.':'.$minute.':'.$second;


if($cont[$n]['type'] == 0)
$all_content .='<div class="live-news">
			<div class="live-date">
				'.$published.'
			</div>
			<div class="live-text">
				<img src="'.$cont[$n]['content'].'">
			</div>
			</div>';

else if($cont[$n]['type'] == 1)
$all_content .='<div class="live-news">
			<div class="live-date">
				'.$published.'
			</div>
			<div class="live-text">
				<p>'.nl2br($cont[$n]['content']).'</p>
			</div>
			</div>';




$n++;
}



?>



<!DOCTYPE HTML>
<html lang="ru">
<head>
<link rel="stylesheet" type="text/css" href="http://macilove.com/styles-new.css">
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="Description" content="Новости из мира Apple, обзор iPhone игр и программ" />
<meta http-equiv="content-language" content="ru">
<meta http-equiv="Keywords" content="WWDC 2013, конференция разработчиков, Apple" />

<title>Прямая трансляция презентации Apple WWDC 2013</title>

<link rel="alternate" type="application/rss+xml" href="http://macilove.com/rss/" />
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="http://macilove.com/resources/apple-touch-icon-114x114.png" />
<link rel="shortcut icon" href="http://macilove.com/favicon.ico" />

<script src="http://macilove.com/resources/jquery-1.9.1.min.js"></script>


<style>
.live-text{
	width: 740px;
	display: inline-block;
	vertical-align: top;
}

.live-text p{
	margin: 0;
	padding: 0;
	width: 460px;
	margin-bottom: 20px;
}

.live-date{
	display: inline-block;
	vertical-align: top;
	font-size: 13px;
	width: 120px;
	text-align: right;
	margin-top: 3px;
	padding-right: 20px;
	color: #799a2d;
}

.live-news{
	text-align: left;
}

.live-text img{
	margin: 5px 0;
	max-width: 640px;
	margin-bottom: 20px;
}

.pages-box{
	margin: 40px auto 40px auto;
	width: 470px;
}

article h1{
	margin-top: 20px !important;
}

.subtitle{
	font-size:12px; 
	color: #666; 
	margin-top:20px;
	margin-bottom:20px; 
	padding: 0 200px;
	text-align: center;
	line-height: 140%;
}

.time-box{
	margin-top: 20px;
	margin-bottom: 40px;
}

.date-box{
	margin: 20px 0 40px 0;
}

.date{
	font-weight: bold;
}

.page-buttons a, .page-buttons a:hover{
	border-bottom: none;
	
}
</style>


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

<script type="text/javascript">


var stop_autoposting = 1


var starttime
var nowtime
var reloadseconds=0
var secondssinceloaded=0
var refreshinterval=10
var post_id=<?php echo $last_post_id; ?>;


function starttime_f() {
if(!stop_autoposting)
{
starttime=new Date()
starttime=starttime.getTime()
countdown()
}
}


function countdown() {
nowtime= new Date()
nowtime=nowtime.getTime()
secondssinceloaded=(nowtime-starttime)/1000
reloadseconds=Math.round(refreshinterval-secondssinceloaded)
if (refreshinterval>=secondssinceloaded) {
var timer=setTimeout("countdown()",1000)
$('#countdown').html(reloadseconds);

}
else {
clearTimeout(timer)



$.post(
		'../live_handler.php',  
        {'id':post_id},  
        
        function(responseText){ 
			if(responseText){
				$('section').prepend(responseText.content);
				
				if(post_id != responseText.id && responseText.id>0)
				{
					document.getElementById('aud').play()
					post_id = responseText.id;
				}
				 
			}
		},
	  
           "json"
    );


starttime_f()
}
}
window.onload=starttime_f





</script>
</head>
<body>
<audio id="aud" src="http://macilove.com/resources/sound.mp3" type="audio/mpeg" preload="auto">
</audio>
<nav>
	<ul>
		<li><a href="http://macilove.com/news/" id="logo"></a></li>
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

<article>
		<h1>Прямая трансляция презентации Apple WWDC 2013</h1>
		<p class="subtitle">Трансляция проходит в формате живого блога, страница обновляется автоматически. Сообщения об основных событиях публикуются по ходу презентации Apple. Начало трансляции 10 июня 2013 г. в 21:00 по Московскому времени.</p>
		<div class="time-box" >
<!--
			<div class="date-box">
				<span class="date">Обновление… <span id="countdown">10</span></span>
			</div>
-->
		</div>
		
		<section>

<?php echo $all_content; ?>

		<div class="pages-box" <?php echo $pg;?>>
			<span class="page-number">Страницы <?php echo $page; ?> из <?php echo $max_page; ?></span>
			<span class="page-buttons">
	
			<a href="<?php echo $previous_page_button; ?>" class="prev-button <?php echo $previous_button_class; ?> page-button"><span class="prev-p-arrow"></span> Предыдущая</a>
			<a href="<?php echo $next_page_button; ?>" class="next-button <?php echo $next_button_class; ?>  page-button">Следующая <span class="next-p-arrow"></span></a>
			</span>
		</div>
		</section>
		</article>	
</div>

<footer class="wrapper">
	<ul>
		<li class="copy">© 2013 Macilove.com</li>
		<li><a href="http://macilove.com/about/">О нас</a></li>
		<li class="sep">|</li>
		<li><a href="http://macilove.com/feedback/">Обратная связь</a></li>
		<li class="sep">|</li>
		<li><a href="http://twitter.com/macilove_com">Twitter</a></li>
		<li class="sep">|</li>
		<li><a href="http://www.facebook.com/macilovecom">Facebook</a></li>
		<li class="sep">|</li>
		<li><a href="http://macilove-com.tumblr.com/">Блог</a></li>
		<li class="sep">|</li>
		<li><a href="http://macilove.com/rss/">RSS</a></li>
	</ul>
</footer>

<div id="made-on-mac" class="wrapper">
	<a href="http://store.apple.com/" id="made-on-a-mac-icon" target="_blank" rel="nofollow"></a>
</div>

</body>
</html>

