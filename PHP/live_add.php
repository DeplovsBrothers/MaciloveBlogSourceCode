<?php
@include_once("./config.inc.php");
@include_once("./functions.inc.php");
header("Content-type:text/html;charset=utf-8"); 
$link = mysql_connect($DBSERVER, $DBUSER, $DBPASS)
or die("Can't connect" );
mysql_select_db($DB, $link) or die ("Can't select DB");

//$presentation_number =0;
//$presentation_number =1;
//$presentation_number =2;
$presentation_number =3;


if(isset($_COOKIE['admmacilove']) AND $_COOKIE['admmacilove'] == 111111){


setcookie('admmacilove', '111111', time() + 3600 * 24 * 30, '/'); 

if(empty($_POST['ok1']) AND empty($_POST['ok2'])){
?>

<html>
<head></head>
<body>
<div style="float:left;">
<form name="one" action="" method="post">
<input type="text" style="float:left; clear:left;" name="img">
<input type="submit" name="ok1" style="float:left; clear:left;" value="add image">
</form>
</div>
<div style="float:left; margin-left:250px;">
<form name="two" action="" method="post">
<textarea style="	float:left; 
	clear:left; 
	width: 500px; 
	height: 140px;
	margin-bottom: 10px;
	max-width: 500px;
" name="text"></textarea>
<input type="submit" name="ok2" style="float:left; clear:left;" value="add text">
</form>
</div>
</body>
</html>




<?php 
}
else if(isset($_POST['ok1'])){
$img = $_POST['img'];

mysql_query("INSERT INTO `live` VALUES(null,0,'".$img."', null,".$presentation_number.")");
header("Location: ./live_add.php");

}
else if(isset($_POST['ok2'])){
$text = $_POST['text'];

mysql_query("INSERT INTO `live` VALUES(null,1,'".$text."', null,".$presentation_number.")");
header("Location: ./live_add.php");

}




}

else
header("Location: ../news/");



?>
