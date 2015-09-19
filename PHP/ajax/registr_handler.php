<?php
@include_once('./functions.inc.php');
@include_once('./config.inc.php');

$link = mysql_connect($DBSERVER, $DBUSER, $DBPASS)
or die("Can't connect" );

mysql_select_db($DB, $link) or die ("Can't select DB");

if($_POST['email']){

if(checkmail($_POST['email']) !== -1){
$email = strtolower(addslashes(trim($_POST['email'])));
$check_email = mysql_query("SELECT * FROM `register` WHERE `email`='".$email."' AND `confirm`=1");

if(mysql_num_rows($check_email) !== 0)
echo 1;

}
else
echo 2;
exit;
}

else if($_POST['nickname']){
if(strlen($_POST['nickname']) >=3){
$nick = addslashes(trim($_POST['nickname']));
if (preg_match ('#^([A-Za-z0-9\._-]*[A-Za-z\._-]+[A-Za-z0-9\._-]*)$#', $nick)){
$busy_nick = strtolower($nick);
$check_nick = mysql_query("SELECT `id` FROM `register` WHERE `busy_nick`='".$busy_nick."'");
if(mysql_num_rows($check_nick) !== 0)
echo 3;
}
else
echo 4;
}
else
echo 5;
exit;
}



?>