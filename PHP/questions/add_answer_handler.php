<?php
@include_once('../functions.inc.php');
@include_once('../config.inc.php');

$link = mysql_connect($DBSERVER, $DBUSER, $DBPASS)
or die("Can't connect" );

mysql_select_db($DB, $link) or die ("Can't select DB");
//mysql_query("SET NAMES utf8");


if(!$_POST)
header("Location: ../answers/");

if($_POST['usid'] AND $_POST['queid'] AND $_POST['text'] AND $_POST['name']){


$text = mysql_escape_string(trim($_POST['text']));
$name = mysql_escape_string(trim($_POST['name']));
if(is_numeric($_POST['usid']))
$user_id = $_POST['usid'];
else
exit;
if(is_numeric($_POST['queid']))
$question_id = $_POST['queid'];
else
exit;


/*images*/
/*
$img_jpg_patt = "#([A-Za-z0-9:\/\.\+\?\.\%\/\@\!\#\&_-]+).jpg#";
$img_jpg_repl = '<img src="$1.jpg">';
$text = preg_replace($img_jpg_patt, $img_jpg_repl, $text);

$img_jpeg_patt = "#([A-Za-z0-9:\/\.\+\?\.\%\/\@\!\#\&_-]+).jpeg#";
$img_jpeg_repl = '<img src="$1.jpeg">';
$text = preg_replace($img_jpeg_patt, $img_jpeg_repl, $text);

$img_png_patt = "#([A-Za-z0-9:\/\.\+\?\.\%\/\@\!\#\&_-]+).png#";
$img_png_repl = '<img src="$1.png">';
$text = preg_replace($img_png_patt, $img_png_repl, $text);

$img_gif_patt = "#([A-Za-z0-9:\/\.\+\?\.\%\/\@\!\#\&_-]+).gif#";
$img_gif_repl = '<img src="$1.gif">';
$text = preg_replace($img_gif_patt, $img_gif_repl, $text);
*/


/*
$patt = "#(?<!\=\")http([A-Za-z0-9:\/\.\+\?\%\@\!\#\&_-]+)#";
$repl = '<a href="http$1" target="_blank" rel="nofollow">http$1</a> ';
$text = preg_replace($patt, $repl, $text);
*/


 



$check_for_user = mysql_query("SELECT * FROM `register` WHERE `id`=".$user_id."");
$num_user = mysql_num_rows($check_for_user);
if($num_user == 1){
	$user_arr = mysql_fetch_assoc($check_for_user);
	$confirm = $user_arr['confirm'];
	
	$insert_new_comment = mysql_query("INSERT INTO `answers` VALUES(null,".$question_id.",".$user_id.",'".$name."','".$text."',null,0)");
	



	if($insert_new_comment AND $confirm == 0){
	echo 1;//message about confirm you email to show comment
	exit;
	}
	else if($insert_new_comment AND $confirm == 1){
	echo 2;// all allright

	call_user_func(userActivityCallback(2,null,$question_id,$text));

	exit;
	}
	else{
	echo 3;//unexpected error
	exit;
	}


	$email_to = mysql_query("SELECT `r.email` 
	FROM `answers_notif` AS `a` 
	LEFT JOIN `register` AS `r` ON a.user_id = r.id
	WHERE a.question_id =$question_id");
 
$notif_num = mysql_num_rows($email_to);
if($notif_num > 0){
if(substr(PHP_OS, 0, 3) == "WIN") 
        $n = "\r\n"; 
        else
        $n = "\n"; 
$headers = 'MIME-Version: 1.0' .$n;
$headers .= 'Content-Type: text/html; charset=utf8' .$n;
$headers .= 'From:<noreply@macilove.com>'.$n;
$headers .= 'Date: '. date('D, d M Y h:i:s O') . $n; 


$title_q = mysql_query("SELECT `title` FROM `questions` WHERE `id`=".$question_id."");
$title = mysql_fetch_assoc($title_q);
$title = stripcslashes($title);

for($cnt =1;$email_arr = mysql_fetch_assoc($email_to);$cnt++ ){




$mailto = $email_arr['email'];
$subject = "Ответ на ваш вопрос на Macilove";
$message = nl2br("<div style=\"background-color: #f2f2f2; float: left; padding-top: 20px; padding-left: 20px; padding-right: 20px; padding-bottom: 20px; font-family: Helvetica Neue, Helvetica, Aria, sans-serif;\"><div style=\"float: left; clear: left; width: 100%;\"><h1 style=\"margin-bottom: 0; margin-top: 10px;\"><a href=\"http://macilove.com\" style=\"font-size: 24px; margin-top: 0; margin-left: 0; margin-bottom: 0; margin-right: 0; text-decoration: none; color: black;\">Macilove</a></h1><div style=\"margin-left: 0; margin-bottom: 0; margin-right: 0; font-size: 12px; color: #999; margin-top: 5px;\">Новости Apple для настоящих фанатов</div></div><div style=\"background-color: white; border-radius: 4px; box-shadow: 0 1px 3px #999; float: left; clear: left; padding-right: 20px; padding-bottom: 10px; padding-top: 10px; padding-left: 20px; min-width: 400px; margin-top: 20px;\"><div style=\"float: left; clear: left; width: 100%; font-size: 13px; line-height: 20px; color: #333;\"><h2 style=\"font-size: 27px; line-height: 32px; margin-right: 0; margin-top: 0; margin-left: 0; width: 100%; font-weight: normal; padding-top: 10px; margin-bottom: 20px;\">На ваш вопрос <a href=\"http://macilove.com/questions/question/".$question_id."/\" style=\"color: #08c;\">".$title."</a> получен ответ</h2><p style=\"font-size: 13px;\"><a href=\"http://macilove.com/questions/\" style=\"color: #08c; font-weight: bold; font-size: 12px;\">Вопросы и ответы по Apple устройствам</a></p></div></div><div style=\"width: 100%;\"><a href=\"#\" style=\"font-size: 11px; color: #999; margin-top: 20px; float: left; clear: left;\">Отписаться от уведомлений</a></div></div>");


// письмо отсылается на почту
sendmail($mailto,$subject,$message,$headers, '-f'.$from);
}
}
exit;
	
}
else
exit;
	
	
}
else
header("Location: ./apple-news/");

	









?>