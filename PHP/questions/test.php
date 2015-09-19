<?php 
	

$text= 'bla https://itunes.apple.com/ru/app/visa-qiwi-wallet-for-ipad/id455301180?l=en bla';

$patt = "#(?<!\=\")http([A-Za-z0-9:\/\.\+\=\?\%\@\!\#\&_-]+)#";

$repl = '<a href="http$1" target="_blank" rel="nofollow">http$1</a> ';
$text = preg_replace($patt, $repl, $text);
	
echo $text;
 	
?>