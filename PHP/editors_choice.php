<?php 
@include_once("./config.inc.php");
@include_once("./functions.inc.php");
header("Content-type:text/html;charset=utf-8"); 
$link = mysql_connect($DBSERVER, $DBUSER, $DBPASS)
or die("Can't connect" );
mysql_select_db($DB, $link) or die ("Can't select DB");

if(isset($_COOKIE['admmacilove']) AND $_COOKIE['admmacilove'] == 111111){


setcookie('admmacilove', '111111', time() + 3600 * 24 * 30, '/'); 
	
	
	
	
if($_POST && isset($_POST['ok'])){
$url = explode('/',$_POST['url']);
$url = $url[4];
$get_content_q = mysql_query("SELECT `id` FROM `content` WHERE `url`='".$url."'");
$cont_id = mysql_fetch_array($get_content_q);
$cont_id = $cont_id[0];

mysql_query("INSERT INTO `editors_choice` VALUES(null, ".$cont_id.")"); 

}
else if($_POST['id_cont'])
{
	mysql_query("DELETE FROM `editors_choice` WHERE `id`='".$_POST['id_cont']."'");

}

$show_all_editors_choice_q = mysql_query("
SELECT e.id,c.url 
FROM `editors_choice` AS `e`
LEFT JOIN `content` AS `c` ON e.content_id = c.id
WHERE c.draft=1
GROUP BY e.content_id
ORDER BY e.id DESC
");


for ($count = 1; $editorChoice = mysql_fetch_assoc($show_all_editors_choice_q); ++$count)
{
	
	
	$editor .= '<img src="http://macilove.com/images/'.$editorChoice['url'].'-m.jpg"><button data-id="'.$editorChoice['id'].'">del</button><br />';
	
		
}


}
else
header("Location: ./news/apple-news/");
	
	
	
	
?>
<head>
<script src="http://macilove.com/resources/jquery-1.9.1.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		
		$('button').click(function(){
			$('#del_content').val($(this).data('id'));	 
			$('#del_form').submit();
		});
		
	});
</script>
</head>
<body>
<form method="post" action="">
<input autofocus="autofocus" type="text" name="url">
<input type="submit" name="ok">
</form>

<form id="del_form" method="post" action="">
<input id="del_content" type="hidden" name="id_cont">
<?php echo $editor; ?>
</form>
</body>
