<?php 
include("./../config.inc.php");
include("./../make_sitemap.php");	
	
$link = mysql_connect($DBSERVER, $DBUSER, $DBPASS);
mysql_select_db($DB, $link) or die ("Can't select DB");


if(!isset($_COOKIE['admmacilove']) AND $_COOKIE['admmacilove'] != 111111){
	header("Location: http://macilove.com");
}

	
//	call_user_func(make_sitemap());
	
$get_files_q = mysql_query("SELECT * FROM `content` ORDER BY `id`");




for ($count = 0; $content = mysql_fetch_assoc($get_files_q); $count++){
		
		echo $count." ".$content['url']."<br />";
	}


	
	
?>