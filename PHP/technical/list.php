<?php 
@include_once("../config.inc.php");
header('Content-Type: text/html; charset=utf-8');
$link = mysql_connect($DBSERVER, $DBUSER, $DBPASS)
or die("Can't connect");
mysql_select_db($DB, $link) or die ("Can't select DB");
mysql_set_charset('utf8');

$query = mysql_query("SELECT * FROM `poni_express`");



?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
</head>
<body>
<?php

for($count = 0; $k = mysql_fetch_assoc($query); ++$count){
	$arr = $k;

echo $arr['id']." ";

print_r($arr['city']);

echo " ".$arr['weight_0.5']." ".$arr['weight_0.5']." ".$arr['weight_1']." ".$arr['weight_1.5']." ".$arr['weight_2']." ".$arr['weight_2.5']."<br />";
	
}

?>
</body>
</html>