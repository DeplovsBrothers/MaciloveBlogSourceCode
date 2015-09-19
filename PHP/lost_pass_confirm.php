<?php 
session_start();
@include("./config.inc.php");
@include("./functions.inc.php");
header("Content-type:text/html;charset=utf-8");

$link = mysql_connect($DBSERVER, $DBUSER, $DBPASS)
or die("Can't connect" );
mysql_select_db($DB, $link) or die ("Can't select DB");

if(isset($_GET['id']) AND isset($_GET['em'])){
$id = $_GET['id'];
$email = $_GET['em'];


$check = mysql_query("SELECT `nickname` FROM `register` WHERE `id`=".$id." AND `email`='".$email."'");
$nm = mysql_num_rows($check);
if($nm==0){

header("Location: ../registration/");
exit;
}


$arr = mysql_fetch_assoc($check);
$nick = $arr['nick'];

$pass = randStr();

$SID = md5(crypt($nick,md5($pass.salt)));
$upd = mysql_query("UPDATE `register` SET `password`='".md5($pass.salt)."', `SID`='".$SID."' WHERE `id`=".$id."");

if($upd){
if(substr(PHP_OS, 0, 3) == "WIN")
        $n = "\r\n";
        else
        $n = "\n";

$headers .= 'MIME-Version: 1.0'.$n;
$headers = 'Content-type: text/html; charset=utf8'.$n;

$from ='noreply@macilove.com';
$headers .= 'From:<'.$from.'>'.$n;
$headers .= 'Date: '.date('D, d M Y h:i:s O').$n; 
$mailto = $email;
$subject = "Пароль на Macilove восстановлен";
$message = "<div style=\"background-color: #F2F2F2; padding:20px; color: #333; float:left; font-family: Helvetica Neue, Helvetica, Aria, sans-serif; \"><div style=\"width: 100%;\"><a href=\"http://macilove.com\" style=\"text-decoration: none;\"><h1 style=\"font-weight: bold; font-size: 24px;	margin-bottom: 0; text-decoration: none !important; color: black !important;\">Macilove</h1><h2 style=\"font-weight: normal; font-size: 12px; margin-top: 5px; color: #999 !important;\">Новости Apple, новые игры для iPhone и iPad, программы для Mac</h2></a><div style=\"background: white; padding: 10px; width: 80%; margin-top: 10px; border: 1px #999; -moz-box-shadow: 0 1px 3px #999; -webkit-box-shadow: 0 1px 3px #999; border-radius: 4px; padding: 20px; margin-bottom: 10px; float: left; font-size: 16px; line-height: 22px;\"><h3 style=\"font-size: 14px; margin-top: 0; color: #333;\">Восстановление пароля на <a href=\"http://macilove.com\" style=\"color:#333 !important; text-decoration: none !important;\">Macilove.com</a></h3><p style=\"font-size:12px; line-height: 18px; color: #333; \">Ваш новый пароль <strong>".$pass."</strong></p></div><div style=\"margin-bottom: 40px; float: left; width: 60%;\"><a href=\"http://twitter.com/macilove_com\" target=\"_blank\" class=\"footer-link\" style=\"float: left; font-size: 11px; margin-right: 5px; color: #08C; text-decoration: none;\">Twitter</a><span style=\"color: #ccc; font-size: 11px; float: left; margin-right: 5px;\">|</span><a href=\"http://www.facebook.com/pages/Macilove/170787086348435?sk=wall\" target=\"_blank\" class=\"footer-link\" style=\"float: left; font-size: 11px; margin-right: 5px; color: #08C; text-decoration: none;\">Facebook</a><span style=\"color: #ccc; font-size: 11px; float: left; margin-right: 5px;\">|</span><a href=\"feed://macilove.com/rss/\" target=\"_blank\" class=\"footer-link\" style=\"float: left; font-size: 11px; margin-right: 5px; color: #08C; text-decoration: none;\">RSS</a></div></div></div>";

// письмо отсылается на почту
sendmail($mailto,$subject,$message,$headers, '-f'.$from);

$user = md5(randStr().$id); 

// теперь создаем кукес с этим хэшем на 30 дней 
setcookie('user', $user, time() + 3600 * 24 * 30, '/'); 
$registration_hash = mysql_query("UPDATE `register` SET  `hash` = '".$user."' WHERE `nick` = '".$nick."'"); 

header("Location: ./login/");
}

}
else
header("Location: ./news/");











?>