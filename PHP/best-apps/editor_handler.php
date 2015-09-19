<?php
session_start();
@include_once("../config.inc.php");
header("Content-Type: text/html; charset=utf-8"); 

$link = mysql_connect($DBSERVER, $DBUSER, $DBPASS)
or die("Can't connect" );
mysql_select_db($DB, $link) or die ("Can't select DB");


if($_POST['t'])// type
{
$type = mysql_real_escape_string($_POST['t']);

$get_categories = mysql_query("SELECT * FROM `best_apps_category` WHERE `type`=".$type);


for ($count = 1; $cats = mysql_fetch_assoc($get_categories); ++$count){
		 
		 if($count==1)
		 	$sel ='selected="selected"';
		 
		$categories .= '<option '.$sel.' value="'.$cats['id'].'">'.$cats['cat_title'].'</option>';
		
		$sel='';
}

echo $categories;




}



?>