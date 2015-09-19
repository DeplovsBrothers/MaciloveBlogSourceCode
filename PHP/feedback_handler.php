<?php
session_start();
@include_once('./functions.inc.php');
@include_once('./config.inc.php');

$link = mysql_connect($DBSERVER, $DBUSER, $DBPASS)
or die("Can't connect" );

mysql_select_db($DB, $link) or die ("Can't select DB");

if(!$_POST)
header("Location: ./apple-news/");

if($_POST['em'] AND $_POST['te']){
$email = mysql_escape_string(strtolower(trim($_POST['em'])));
$text = mysql_escape_string(trim($_POST['te']));
if(checkmail($email) == -1){
	echo 1;//not an email
	exit;
}

if(substr(PHP_OS, 0, 3) == "WIN")
        $n = "\r\n";
        else
        $n = "\n";

$headers .= 'MIME-Version: 1.0'.$n;
$headers .= 'Content-type: text/html; charset=utf8'.$n;
$from = $email;
$headers .= 'From:<'.$from.'>'.$n;
$headers .= 'Date: '.date('D, d M Y h:i:s O').$n; 
$mailto = 'deplovsbrothers@gmail.com';
$subject = "Обратная связь Macilove";
$message = str_replace('\n', '<br />', $text);


if(mail($mailto,$subject,$message,$headers,'-fmail@macilove.com')){
	
echo 2;
exit;	
	
}
else {
echo 3;
exit;}
}
else{
echo 3;
exit;}


?>