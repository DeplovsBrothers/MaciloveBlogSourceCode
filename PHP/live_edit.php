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

if($_GET['id']){

$ff = mysql_query("SELECT * FROM `live` WHERE `id`=".$_GET['id']." AND `type`=1 AND `presentation`=".$presentation_number."");
$gg = mysql_fetch_assoc($ff);

}

if(empty($_POST['ok1'])){
?>

<html>
<head></head>
<body>
<div style="float:left;">
<form name="one" action="" method="post">
<textarea style="	float:left; 
	clear:left; 
	width: 500px; 
	height: 140px;
	margin-bottom: 10px;
	max-width: 500px;
" name="text"><?php echo $gg['content']; ?></textarea>
<input type="submit" name="ok1" style="float:left; clear:left;" value="add text">
</form>
</div>
</body>
</html>




<?php 
}
else{
$text = $_POST['text'];

mysql_query("UPDATE `live` SET `content`='".$text."' WHERE `id`=".$_GET['id']." AND `presentation`=".$presentation_number."");
header("Location: ./live_edit.php?id=".$_GET['id']."");


}


}
else
header("Location: ../news/");
