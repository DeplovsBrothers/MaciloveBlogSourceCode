<?php
session_start();
@include_once('../functions.inc.php');
@include_once('../config.inc.php');

$link = mysql_connect($DBSERVER, $DBUSER, $DBPASS)
or die("Can't connect" );

mysql_select_db($DB, $link) or die ("Can't select DB");


if(!$_POST)
header("Location: ./apple-news/");


if($_POST['em'] AND $_POST['pass'] AND $_POST['name'] AND $_POST['nick']){
$email = mysql_escape_string(strtolower(trim($_POST['em'])));
$pass = mysql_escape_string(trim($_POST['pass']));
$name = mysql_escape_string(trim($_POST['name']));
$nick = mysql_escape_string(trim($_POST['nick']));


if(checkmail($email) == -1){
	echo 1;//not an email
	exit;
}

$check_email = mysql_query("SELECT * FROM `register` WHERE `email`='".$email."' AND `confirm`=1");
if(mysql_num_rows($check_email) == 1){
echo 2;//already exist email
exit;
}


$check_nick = mysql_query("SELECT * FROM `register` WHERE `busy_nick`='".strtolower($nick)."' 
 AND `confirm`=1");
if(mysql_num_rows($check_nick) == 1){
echo 3;//already exist nick
exit;
}



if (!preg_match('#^([A-Za-z0-9\._-]*[A-Za-z\._-]+[A-Za-z0-9\._-]*)$#', $nick)){
echo 4;// only latin
exit;
}

if(strlen($nick) < 4){
echo 5;// short nick
exit;
}



$SID = md5(crypt($nick,md5($pass.salt)));
if (isset($_SERVER["REMOTE_ADDR"]))
$ip = $_SERVER["REMOTE_ADDR"];
else
$ip='';


$r = mysql_query("INSERT INTO `register` VALUES(null,'".$nick."','".$name."','".$email."','".md5($pass.salt)."','".$ip."','','".$SID."','".strtolower($nick)."',0)");
$id = mysql_insert_id();


$confirm = substr($SID,0,10); 

if($r){
		
        $n = "\n";

$headers .= 'MIME-Version: 1.0'.$n;
$headers = 'Content-type: text/html; charset=utf8'.$n;

$from ='noreply@macilove.com';
$headers .= 'From:<'.$from.'>'.$n;
$headers .= 'Date: '.date('D, d M Y h:i:s O').$n; 
$subject = "Подтверждение регистрации на Macilove";

$mailto = $email;
$message = "<div style=\"background-color: #F2F2F2; padding:20px; color: #333; float:left; font-family: Helvetica Neue, Helvetica, Aria, sans-serif; \"><div style=\"width: 100%;\"><a href=\"http://macilove.com\" style=\"text-decoration: none;\"><h1 style=\"font-weight: bold; font-size: 24px;	margin-bottom: 0; text-decoration: none !important; color: black !important;\">Macilove</h1></a><div style=\"background: white; padding: 10px; width: 80%; margin-top: 10px; border: 1px #999; -moz-box-shadow: 0 1px 3px #999; -webkit-box-shadow: 0 1px 3px #999; border-radius: 4px; padding: 20px; margin-bottom: 10px; float: left; font-size: 16px; line-height: 22px;\"><h3 style=\"font-size: 14px; margin-top: 0;\">Подтверждение регистрации на <a href=\"http://macilove.com\" style=\"color:#333 !important; text-decoration: none !important;\">Macilove.com</a></h3><div>Код подтверждения: <h2>".$confirm."</h2></div></div><div style=\"margin-bottom: 40px; float: left; width: 60%;\"><a href=\"http://twitter.com/macilove_com\" target=\"_blank\" class=\"footer-link\" style=\"float: left; font-size: 11px; margin-right: 5px; color: #08C; text-decoration: none;\">Twitter</a><span style=\"color: #ccc; font-size: 11px; float: left; margin-right: 5px;\">|</span><a href=\"http://www.facebook.com/pages/Macilove/170787086348435?sk=wall\" target=\"_blank\" class=\"footer-link\" style=\"float: left; font-size: 11px; margin-right: 5px; color: #08C; text-decoration: none;\">Facebook</a><span style=\"color: #ccc; font-size: 11px; float: left; margin-right: 5px;\">|</span><a href=\"feed://macilove.com/rss/\" target=\"_blank\" class=\"footer-link\" style=\"float: left; font-size: 11px; margin-right: 5px; color: #08C; text-decoration: none;\">RSS</a></div></div></div>";




/*

<a href=\"http://macilove.com/news/confirm_reg.php?id=".$SID."\" style=\"padding: 15px 20px; color: #425705; border-radius: 8px; -webkit-border-radius: 8px; -moz-border-radius: 8px;	background: #b6e026; text-decoration: none !important; margin-bottom: 20px; float: left; border: 1px solid #8EBA0B; box-shadow: 0 1px 3px #8EBA0B; -webkit-box-shadow: 0 1px 3px #8EBA0B; -moz-box-shadow: 0 1px 3px #8EBA0B; text-shadow: 0 1px 0 #D3ED7E; font-weight: bold;\">Подтвердить регистрацию   Macilove</a>

*/

// письмо отсылается на почту
if(mail($mailto,$subject,$message,$headers, '-f'.$from)) {



$_SESSION['pass'] = md5($pass.salt);
$_SESSION['nick'] = $nick;
$_SESSION['SID'] = md5(crypt($nick, md5($pass.salt)));



echo $id.'c';
exit;
}
else{
$err= mysql_query("DELETE FROM `register` WHERE `id`=".$id);
echo 6;
exit;
}
}
else{
$err= mysql_query("DELETE FROM `register` WHERE `id`=".$id);
echo 6;
exit;
}
}
else
exit;


?>