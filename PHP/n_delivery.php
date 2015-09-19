<?php
@include("functions.inc.php");
@include("config.inc.php");
header("Content-type:text/html;charset=utf-8");

$link = mysql_connect($DBSERVER, $DBUSER, $DBPASS)
or die("Can't connect" );
mysql_select_db($DB, $link) or die ("Can't select DB");

ignore_user_abort(true);
set_time_limit(0);

//cron
//30 18  * * * /usr/bin/php5 /var/www/macilove.com/n_delivery.php 1 > /dev/null


if($argv[1]){

$news_query = mysql_query("SELECT `type`, `title`, `url` FROM `content` WHERE `pub_date` > NOW( ) - INTERVAL 24 HOUR AND `draft`=1 ORDER BY `id` DESC");
$num =mysql_num_rows($news_query); 


if($num >= 1){


	for ($count = 1; $news = mysql_fetch_assoc($news_query); ++$count){
		 
		$news_cont[$count]= $news;
	}
}	
else
exit;

	



$n = "\n";

for($k =1; $k<=$num; ++$k)
{


$text .= $n.'<a href="http://macilove.com/news/'.$news_cont[$k]['url'].'/" style="width: 200px; font-size: 13px; line-height: 16px; color: #333; text-decoration: none; display: inline-block; vertical-align: top; margin-right: 20px;">'.$n.'<img src="http://macilove.com/images/'.$news_cont[$k]['url'].'-m.jpg"'.$n.' width="200" height="104" style="width: 200px; border-radius: 4px; box-shadow: 0 1px 2px rgba(25,25,25,0.3);">'.$n.'<p style="width: 200px; text-align: center; margin-top: 5px; font-family: lucida grande, sans-serif;" align="center">'.$n.stripslashes($news_cont[$k]['title']).$n.'</p></a>'.$n;
if($k%3==0 && $k!=$num)
$text .= '</div>'.$n.'<div style="margin-bottom: 20px; overflow-x: hidden;">';
else if($k==$num)
$text .='</div>'.$n;		

}


 

$headers .= 'MIME-Version: 1.0' .$n;
$headers .= 'Content-Type:text/html;charset=utf-8'.$n;

$from ='apple_news@macilove.com';
$headers .= 'From:<'.$from.'>'.$n;
$headers .= 'Date: '.date('D, d M Y h:i:s O').$n; 

$subject = "Новости Apple";

$email_query = mysql_query("SELECT `email`,`user` FROM `email_delivery`");



for ($c = 1; $del = mysql_fetch_assoc($email_query); ++$c){
	
		$arr_email = $del['email'];

		$arr_user = $del['user'];



$message='<!DOCTYPE HTML>'.$n.'<html lang="ru"><head><meta http-equiv="content-type" content="text/html; charset=utf-8"></head>'.$n.'<body style="padding: 20px; background-color: #f2f2f2; font-family: helvetica neue, helvetica, arial, sans-serif;" bgcolor="#f2f2f2"><style type="text/css">.avatar-img::before { box-shadow: 0 0 1px 1px rgba(0,0,0,.2) inset, 0 0 1px 2px rgba(255,255,255,.3) inset !important; width: 60px !important; height: 60px !important; display: block !important; position: absolute !important; left: 0 !important; top: 0 !important; content: "" !important; border-radius: 8px !important; }></style>'.$n.'<div style="margin: 0 auto; background-color: white; border: 1px solid #dedede; padding: 20px 20px 0 20px; width: 690px; border-radius: 3px 3px 0 0;"><div style="padding-bottom: 20px; border-bottom-color: #eee; border-bottom-width: 1px; border-bottom-style: solid; text-align: center; margin-left: -20px; width: 730px;" align="center"><a href="http://macilove.com/" style="position: relative; display: inline-block; margin-bottom: 0px;"><img src="https://pbs.twimg.com/profile_images/1903863734/metal.png" style="box-shadow: 0 12px 27px rgba(0,0,0,.25); border-radius: 8px;" width="60" height="60"></a><h1 style="margin-top: 10px; margin-bottom: 0px; color: #83a520; font-size: 22px; font-weight: 200;">Macilove</h1>'.$n.'<p style="margin-top: 0px; color: #c1c9a3; font-size: 14px; margin-bottom: 0;">Новости Apple для настоящих фанатов</p></div>'.$n.'<div style="padding: 40px 0 0 20px; display: inline-block; vertical-align: top;"><div style="margin-bottom: 20px; overflow-x: hidden;">'.$text.'</div></div><a href="http://macilove.com/news/" style="text-align: center; background-color: #E3E3E3; width: 732px; display: block; padding: 10px 0px; border-radius: 0 0 3px 3px; font-size: 14px; font-weight: bold; text-shadow: 0 1px 0 rgba(255,255,255,.6); color: #b1b1b1; text-decoration: none; margin: 0 auto;">'.$n.'Все новости'.$n.'</a></div>'.$n.'<div style="width: 690px; margin: 0 auto; text-align: center; padding-top: 40px; font-size: 12px; padding-bottom: 20px;" align="center"><a href="http://macilove.com/feedback/" style="margin: 0 5px; color: #999; text-decoration: none; border-bottom-width: 1px; border-bottom-style: solid; border-bottom-color: #D4D4D4;">'.$n.'Обратная связь'.$n.'</a><a href="https://twitter.com/macilove_com" style="margin: 0 5px; color: #999; text-decoration: none; border-bottom-width: 1px; border-bottom-style: solid; border-bottom-color: #D4D4D4;">Twitter</a>'.$n.'<a href="http://www.facebook.com/macilovecom" style="margin: 0 5px; color: #999; text-decoration: none; border-bottom-width: 1px; border-bottom-style: solid; border-bottom-color: #D4D4D4;">Facebook</a>'.$n.'<a href="http://macilove.com/rss/" style="margin: 0 5px; color: #999; text-decoration: none; border-bottom-width: 1px; border-bottom-style: solid; border-bottom-color: #D4D4D4;">RSS</a>'.$n.'<a href="http://macilove.com/news_delivery_confirm.php?id='.$arr_user.'&email='.$arr_email.'&del=1" style="margin-left: 20px; color: #999; text-decoration: none; border-bottom: 1px solid #D4D4D4; ">Отписаться</a></div></body></html>';

$mailto = $arr_email;


// письмо отсылается на почту
@mail($mailto,$subject,$message,$headers, '-f'.$from);




}

}

?>