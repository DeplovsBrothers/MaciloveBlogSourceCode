<?php
@include_once('./functions.inc.php');
@include_once('./config.inc.php');

$link = mysql_connect($DBSERVER, $DBUSER, $DBPASS)
or die("Can't connect" );

mysql_select_db($DB, $link) or die ("Can't select DB");

if($_POST['email'] AND $_POST['password']){
$email = strtolower(addslashes(trim($_POST['email'])));
$pass = trim($_POST['password']);

$check_email = mysql_query("SELECT * FROM `register` WHERE `email`='".$email."' AND `password`='".md5($pass.salt)."' AND `confirm`=1");
if(mysql_num_rows($check_email) !== 1)
echo 3;


}
else
if($_POST['email']){

if(checkmail($_POST['email']) !== -1){
$email = strtolower(addslashes(trim($_POST['email'])));
$check_email = mysql_query("SELECT * FROM `register` WHERE `email`='".$email."' AND `confirm`=1");

if(mysql_num_rows($check_email) == 0)
echo 1;

}
else
echo 2;
exit;
}



?>