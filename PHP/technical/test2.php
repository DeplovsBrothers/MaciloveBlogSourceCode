<?php 
$body = ' sdfs
 [YT]http://www.youtube.com/watch?v=-EJUCkSMN4k&feature=my_liked_videos&list=LLMyQ60qFGrHSPvhJ70UFCvQ[/YT] sdfsdf ';

$p_youtube = "#(\r\n)*\[YT\]http://www\.youtube\.com/watch\?v=([A-Za-z0-9_-]+)(.*)\[/YT\]#ui";
$r_youtube = '<iframe width="540" height="304" src="http://www.youtube.com/embed/$1?rel=0?hd=1&rel=0&theme=light&color=white" frameborder="0" allowfullscreen></iframe>';
$body = preg_replace($p_youtube, $r_youtube, $body);

echo $body;	
	exit;
	
$text = 'blablabla sdfgsdgd http://www.thisiscolossal.com/wp-content/uploads/2012/09/meyer-5.jpg';	

		
$img_jpg_patt = "#([A-Za-z0-9:\/\.\+\?\.\%\/\@\!\#\&_-]+).jpg#";
$img_jpg_repl = '<img src="$1.jpg">';
$text = preg_replace($img_jpg_patt, $img_jpg_repl, $text);

//$w_img_jpg_patt = "#([A-Za-z0-9:\/\.\+\?\.\%\/\@\!\#\&_-]+).jpg#";
//$w_img_jpg_repl = '<a href="http$1" target="_blank" rel="nofollow">http$1</a> ';
//$text = preg_replace($img_jpg_patt, $img_jpg_repl, $text);



//$img_jpeg_patt = "#http([A-Za-z0-9:\/\.\+\?\.\%\/\@\!\#\&_-]+).jpeg #";
//$img_jpeg_repl = '<a href="http$1" target="_blank" rel="nofollow">http$1</a> ';
//$text = preg_replace($img_jpg_patt, $img_jpeg_repl, $text);

$img_png_patt = "#http([A-Za-z0-9:\/\.\+\?\.\%\/\@\!\#\&_-]+).png #";
$img_png_repl = '<a href="http$1" target="_blank" rel="nofollow">http$1</a> ';
$text = preg_replace($img_png_patt, $img_png_repl, $text);

$img_gif_patt = "#http([A-Za-z0-9:\/\.\+\?\.\%\/\@\!\#\&_-]+).gif #";
$img_gif_repl = '<a href="http$1" target="_blank" rel="nofollow">http$1</a> ';
$text = preg_replace($img_gif_patt, $img_gif_repl, $text);

	echo $text;
	
	
	
?>