<?php
@include_once("./config.inc.php");
@include_once("./functions.inc.php");

header("Content-type:text/html;charset=utf-8");
$link = mysql_connect($DBSERVER, $DBUSER, $DBPASS)
or die("Can't connect" );
mysql_select_db($DB, $link) or die ("Can't select DB");
	
	

$presentation_number =3;
	
if($_POST)
{
if(is_numeric($_POST['id']))
$id = intval($_POST['id']);


$query = mysql_query("SELECT `id`, `type`,`content`, UNIX_TIMESTAMP(`time`) FROM `live` WHERE `presentation`=".$presentation_number." AND `id`>".$id." ORDER BY `id` DESC");
$all_content ='';

$last_post_id = 0;

for ($count = 1; $news = mysql_fetch_assoc($query); ++$count){
$cont[$count]= $news;
}
$n = 1;
while($n<=$count-1){
if($n==1)
$last_post_id = $cont[$n]['id'];


$pub_date = ($cont[$n]['UNIX_TIMESTAMP(`time`)']);

$hour = strftime( "%H", $pub_date);
$minute = strftime( "%M" ,$pub_date);
$second = strftime( "%S" ,$pub_date);
$hour = $hour;

$published = $hour.':'.$minute.':'.$second;


if($cont[$n]['type'] == 0)
$all_content .='<div class="live-news">
			<div class="live-date">
				'.$published.'
			</div>
			<div class="live-text">
				<img src="'.$cont[$n]['content'].'">
			</div>
			</div>';

else if($cont[$n]['type'] == 1)
$all_content .='<div class="live-news">
			<div class="live-date">
				'.$published.'
			</div>
			<div class="live-text">
				<p>'.nl2br($cont[$n]['content']).'</p>
			</div>
			</div>';


$n++;
}



$encoded = json_encode(array("content" => $all_content, "id"=>$last_post_id));
echo $encoded; 




}	
else
header("Location: ./apple-news/");

	
	
	
	
	
	
	
	
	
	
	
?>