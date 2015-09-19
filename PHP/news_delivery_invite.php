<?php
session_start();
@include_once("./config.inc.php");
@include_once("./functions.inc.php");

header("Content-type:text/html;charset=utf-8"); 
$link = mysql_connect($DBSERVER, $DBUSER, $DBPASS)
or die("Can't connect" );
mysql_select_db($DB, $link) or die ("Can't select DB");

if(isset($_POST['email']) AND isset($_POST['name']) AND isset($_COOKIE['user'])){
$email = mysql_escape_string($_POST['email']);
$name = mysql_escape_string($_POST['name']);
$user = $_COOKIE['user'];

mysql_query("INSERT INTO `email_delivery` VALUES(null,'".$email."','".$user."','".$name."')");

echo 'ok';

	
}
else if(isset($_GET['email']) AND isset($_COOKIE['user'])){
$email = mysql_escape_string($_GET['email']);
$user = $_COOKIE['user'];


$check = mysql_query("SELECT `id` FROM `email_delivery` WHERE `email`='".$email."'");

if(mysql_num_rows($check) == 0)
mysql_query("INSERT INTO `email_delivery` VALUES(null,'".$email."','".$user."','')");


/*



		if(substr(PHP_OS, 0, 3) == "WIN") 
        $n = "\r\n"; 
        else
        $n = "\n"; 

$check = mysql_query("SELECT * FROM `email_delivery` WHERE `email`='".$email."'");
if(mysql_num_rows($check)==1){
$_SESSION['err'] = 1;
header("Location: ./message/");}





$from ='noreply@macilove.com';

$headers = 'MIME-Version: 1.0' .$n;
$headers .= 'Content-Type: text/html; charset=utf8' .$n;
$headers .= 'From:<'.$from.'>'.$n;
$headers .= 'Date: '. date('D, d M Y h:i:s O') . $n; 


$mailto = "$email";
$subject = "Подписка на новости Macilove";
$message = nl2br("<div style=\"background-color: #F2F2F2; padding:20px; color: #333; float:left; font-family: Helvetica Neue, Helvetica, Aria, sans-serif; \"><div style=\"width: 100%;\"><a href=\"http://macilove.com\" style=\"text-decoration: none;\"><h1 style=\"font-weight: bold; font-size: 24px;	margin-bottom: 0; text-decoration: none !important; color: black !important;\">Macilove</h1><h2 style=\"font-weight: normal; font-size: 12px; margin-top: 5px; color: #999 !important;\">Новости Apple, новые игры для iPhone и iPad, программы для Mac</h2></a><div style=\"background: white; padding: 10px; width: 80%; margin-top: 10px; border: 1px #999; -moz-box-shadow: 0 1px 3px #999; -webkit-box-shadow: 0 1px 3px #999; border-radius: 4px; padding: 20px; margin-bottom: 10px; float: left; font-size: 16px; line-height: 22px;\"><h3 style=\"font-size: 14px; margin-top: 0;\">Подтверждение подписки на новости <a href=\"http://macilove.com\" style=\"color:#333 !important; text-decoration: none !important;\">Macilove.com</a></h3><p style=\"font-size:12px; color: #999; line-height: 18px; \">Если вы этого не делали, просто проигнорируйте данное сообщение. Новости рассылаются каждый день в 11:00 по московскому времени.</p><div><a href=\"http://macilove.com/news_delivery_confirm.php?id=".$user."&email=".$email."\" style=\"padding: 15px 20px; color: #425705; border-radius: 8px; -webkit-border-radius: 8px; -moz-border-radius: 8px;	background: #b6e026; text-decoration: none !important; margin-bottom: 20px; float: left; border: 1px solid #8EBA0B; box-shadow: 0 1px 3px #8EBA0B; -webkit-box-shadow: 0 1px 3px #8EBA0B; -moz-box-shadow: 0 1px 3px #8EBA0B; text-shadow: 0 1px 0 #D3ED7E; font-weight: bold;\">Подписаться на новости Macilove</a></div></div><div style=\"margin-bottom: 40px; float: left; width: 60%;\"><a href=\"http://twitter.com/#!/macilove_com\" target=\"_blank\" class=\"footer-link\" style=\"float: left; font-size: 11px; margin-right: 5px; color: #08C; text-decoration: none;\">Twitter</a><span style=\"color: #ccc; font-size: 11px; float: left; margin-right: 5px;\">|</span><a href=\"http://www.facebook.com/pages/Macilove/170787086348435?sk=wall\" target=\"_blank\" class=\"footer-link\" style=\"float: left; font-size: 11px; margin-right: 5px; color: #08C; text-decoration: none;\">Facebook</a><span style=\"color: #ccc; font-size: 11px; float: left; margin-right: 5px;\">|</span><a href=\"feed://macilove.com/rss/\" target=\"_blank\" class=\"footer-link\" style=\"float: left; font-size: 11px; margin-right: 5px; color: #08C; text-decoration: none;\">RSS</a></div></div></div>");


// письмо отсылается на почту
sendmail($mailto,$subject,$message,$headers, '-f'.$from);

if($_GET['fm']==1){
$get_check = mysql_query('SELECT * FROM `check`');
$val = mysql_fetch_array($get_check);
$value = $val[0] + 1;
mysql_query('UPDATE `check` VALUE($value)');
}

$_SESSION['err'] = 2;
header("Location: ./message/");

*/
$_SESSION['err'] = 3;
header("Location: ./message/");


}
else
header("Location: ./news/apple-news/");









?>