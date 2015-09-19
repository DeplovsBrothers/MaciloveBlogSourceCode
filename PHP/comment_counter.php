<?php
@include_once("./config.inc.php");
@include_once("./functions.inc.php");
header("Content-type:text/html;charset=utf-8"); 
$link = mysql_connect($DBSERVER, $DBUSER, $DBPASS)
or die("Can't connect" );
mysql_select_db($DB, $link) or die ("Can't select DB");


// Защита от XSS 
function _filter( $var , $sql = 0) { 
  
    $var = strip_tags($var); 
    $var=str_replace ("\n"," ", $var); 
    $var=str_replace ("\r","", $var); 
    $var = htmlentities($var); 
    if ( $sql == 1) {  
        $var = mysql_real_escape_string($var); 
    } 
    return $var; 
} 

$id=_filter($_GET['id'],1);
$num=_filter($_GET['num'],1); 
echo "$num";
mysql_query("UPDATE `comments` SET `amount`=".$num." WHERE `id`='".$id."'") or die(mysql_error()); 

$url_q = mysql_query("SELECT `url` FROM `content` WHERE `id`=".$id);
$url = mysql_fetch_assoc($url_q);


		if(substr(PHP_OS, 0, 3) == "WIN") 
        $n = "\r\n"; 
        else
        $n = "\n"; 

$headers .= 'MIME-Version: 1.0' .$n;
$headers = 'Content-type: text/html; charset=utf8' .$n;

$from ='noreply@macilove.com';
$headers .= 'From:<'.$from.'>'.$n;
$headers .= 'Date: '. date('D, d M Y h:i:s O') . $n; 
$mailto = "macilove.com@gmail.com";
$subject = "New comment";
$message = "New comment on page <a href=\"http://macilove.com/news/".$url['url']."/\">".$url['url']."</a>";

// письмо отсылается на почту
sendmail($mailto,$subject,$message,$headers, '-f'.$from);



?>