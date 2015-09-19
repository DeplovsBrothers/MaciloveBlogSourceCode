<?php
@include_once("./config.inc.php");
@include_once("./functions.inc.php");
header("Content-type:text/html;charset=utf-8"); 
$link = mysql_connect($DBSERVER, $DBUSER, $DBPASS)
or die("Can't connect" );
mysql_select_db($DB, $link) or die ("Can't select DB");
 
	
	
	
for($i=0; $i<=7; $i++){
$get_videos = mysql_query("SELECT * FROM `video` WHERE `type`=$i ORDER BY `year` DESC, `id` DESC");

$video_arr[$i] = '<div class="video-row-box"><div class="video-row-wrapper">';

for($k=1; $video = mysql_fetch_assoc($get_videos); $k++){

$img_src = substr($video['url'],31);


$video_arr[$i] .= '<div class="video-box">
                <a class="play" href="'.$video['url'].'&autoplay=1&ap=%2526fmt%3D22?hd=1&fs=1;">
                <div class="video-gloss"></div>
                <div class="video-image"><img src="http://img.youtube.com/vi/'.$img_src.'/hqdefault.jpg"></div>
                </a>
                <p class="video-name">'.$video['title'].'</p>
                <p class="video-year">'.$video['year'].'</p>
                </div>';

$num_of_rows = mysql_num_rows($get_videos);
$multiplicity = $k % 3;
if($multiplicity == 0 && $k !=$num_of_rows)
$video_arr[$i] .= '</div></div><div class="video-row-box"><div class="video-row-wrapper">'; 	
	
}
$video_arr[$i] .= '</div></div>'; 	
		
		
}
	
	
	
$random_video_q = mysql_query("SELECT * FROM `video` ORDER BY RAND() LIMIT 1");
$video_of_the_day = mysql_fetch_assoc($random_video_q);	
$video_day_url = substr($video_of_the_day['url'],31);

	
?>
<!DOCTYPE HTML>
<html lang="ru">
<head>
<link rel="stylesheet" type="text/css" href="http://macilove.com/styles.css">
<link rel="stylesheet" type="text/css" href="http://macilove.com/video-styles.css">

<meta charset="UTF-8" />
<meta name="Description" content="Рекрамные ролики Apple" />
<meta http-equiv="Keywords" content="реклама apple, рекламное видео apple, реклама эппл" />
<meta name="viewport" content="width=1024">

<title>Рекламные ролики Apple</title>
<link rel="shortcut icon" href="http://macilove.com/favicon.ico" />
<link rel="alternate" type="application/rss+xml" title="Новости из мира Apple, обзор iPhone игр и программ" href="http://macilove.com/rss/" />
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="http://macilove.com/resources/apple-touch-icon-114x114.png" />
<link rel="stylesheet" href="http://macilove.com/fancybox/jquery.fancybox.css?v=2.0.1" type="text/css" media="screen" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
<script type="text/javascript" src="http://macilove.com/fancybox/jquery.fancybox.pack.js?v=2.0.1"></script>

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
jQuery(document).ready(function() {
        $(".play").click(function() {
                $.fancybox({
                        'padding'               : 0,
                        'autoScale'             : false,
                        'transitionIn'  : 'none',
                        'transitionOut' : 'none',
                        'openEffect': 'elastic',
                        'closeEffect': 'elastic',
                        'title'                 : this.title,
                        'width'                 : 640,
                        'height'                : 385,
                        'href'                  : this.href.replace(new RegExp("watch\\?v=", "i"), 'v/'),
                        'type'                  : 'swf',
                        'closeClick'    : false,
                        'swf'                   : {
                        'wmode'                         : 'transparent',
                        'allowfullscreen'       : 'true'
                        }
                });
                return false;
        });


        $(".video-row-box a").mouseenter(function() {
                 $(this).find(".video-image").css("box-shadow","none");
                 $(this).find(".video-gloss").toggleClass("video-gloss video-gloss-play");
        });


        $(".video-row-box a").mouseleave(function() {
                $(this).find(".video-image").css("box-shadow","0 2px 5px rgba(0, 0, 0, 0.8)");
                $(this).find(".video-gloss-play").toggleClass("video-gloss-play video-gloss");
        });
});
</script>
<style type="text/css">

</style>
</head>
<body>
<div class="wrapper">
<div class="nav">
        
    <a href="http://macilove.com" id="logo-light"></a>
	<span class="main-nav">
	<a class="main-menu" href="http://macilove.com/news/">Новости</a>
	<a class="main-menu" href="http://macilove.com/questions/">Форум</a>
	<a class="main-menu" href="http://macilove.com/books/">Книги</a>
	<a class="active-main-menu" href="http://macilove.com/video/">Видео</a>
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
<div class="main-bg" style="background:#2e2e2e; box-shadow: 0 0 3px rgba(0,0,0,0.2) inset;">
<div class="left-side">

        <div style="text-align:center;">
        <h1 class="h1-video">Рекламные ролики Apple</h1>
        
        <div class="video-of-the-day">
        <iframe width="640" height="360" src="http://www.youtube.com/embed/<?php echo $video_day_url; ?>?rel=0" frameborder="0" allowfullscreen></iframe>
        <p class="video-name"><?php echo $video_of_the_day['title']; ?></p>
        <p class="video-year"><?php echo $video_of_the_day['year']; ?></p>
        </div>
        </div>




        <div class="video-small-title-box">
                <div class="video-small-title-box-bg">iPod</div>
                <div class="video-small-title-sep-dark"></div>
                <div class="video-small-title-sep-light"></div>
        </div>
        

        <?php echo $video_arr[2]; ?>

        <div class="video-small-title-box">
                <div class="video-small-title-box-bg">iPad</div>
                <div class="video-small-title-sep-dark"></div>
                <div class="video-small-title-sep-light"></div>
        </div>

        <?php echo $video_arr[0]; ?>
        
        <div class="video-small-title-box">
                <div class="video-small-title-box-bg">iPhone</div>
                <div class="video-small-title-sep-dark"></div>
                <div class="video-small-title-sep-light"></div>
        </div>

        <?php echo $video_arr[1]; ?>
        
        <div class="video-small-title-box">
                <div class="video-small-title-box-bg">iMac</div>
                <div class="video-small-title-sep-dark"></div>
                <div class="video-small-title-sep-light"></div>
        </div>

        <?php echo $video_arr[3]; ?>

        <div class="video-small-title-box">
                <div class="video-small-title-box-bg">OS X</div>
                <div class="video-small-title-sep-dark"></div>
                <div class="video-small-title-sep-light"></div>
        </div>

        <?php echo $video_arr[5]; ?>


        <div class="video-small-title-box">
                <div class="video-small-title-box-bg">MacBook</div>
                <div class="video-small-title-sep-dark"></div>
                <div class="video-small-title-sep-light"></div>
        </div>

        <?php echo $video_arr[4]; ?>

        <div class="video-small-title-box">
                <div class="video-small-title-box-bg">На русском языке</div>
                <div class="video-small-title-sep-dark"></div>
                <div class="video-small-title-sep-light"></div>
        </div>

        <?php echo $video_arr[6]; ?>
        
        
        
        <div class="video-small-title-box">
                <div class="video-small-title-box-bg">Другое</div>
                <div class="video-small-title-sep-dark"></div>
                <div class="video-small-title-sep-light"></div>
        </div>

        <?php echo $video_arr[7]; ?>
</div>
</div>
</div>

<div class="wrapper">
<div id="footer">
<span class="copy">© 2013 Macilove.com</span>
<a href="http://macilove.com/about/">О нас</a>
<!--
<span class="footer-sep">|</span>
<a href="http://macilove.com/commercial/">Реклама</a>
-->
<span class="footer-sep">|</span>
<a href="http://macilove.com/feedback/">Обратная связь</a>
<span class="footer-sep">|</span>
<a href="http://twitter.com/macilove_com" target="_blank">Twitter</a>
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
</div>
</body>
</html>