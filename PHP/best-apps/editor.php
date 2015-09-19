<?php
session_start();
@include_once("../config.inc.php");
header("Content-Type: text/html; charset=utf-8"); 

$link = mysql_connect($DBSERVER, $DBUSER, $DBPASS)
or die("Can't connect" );
mysql_select_db($DB, $link) or die ("Can't select DB");

if(!isset($_COOKIE['admmacilove']) OR $_COOKIE['admmacilove'] != 111111){
header("Location: http://macilove.com/news/");
}


setcookie('admmacilove', '111111', time() + 3600 * 24 * 30, '/'); 

if($_POST['submit'])
{


if($_POST['new_type_add']==1)
{
	$new_cat = true;
	$catygory_name = mysql_escape_string(trim($_POST['new_type']));
	
$type = mysql_real_escape_string($_POST['type']);



	mysql_query("INSERT INTO `best_apps_category` VALUES(null, ".$type.",'".$catygory_name."')"); // type 1 = best apps 
	$category_id = mysql_insert_id();

}
else
{
	$category_id = $_POST['categories'];
}

$title = mysql_real_escape_string($_POST['title']);
$description = mysql_real_escape_string($_POST['description']);
$url = $_POST['url'];
$review = $_POST['url-review'];

if(!empty($title) && !empty($description) && !empty($url)) 
{




$insert_to_db = mysql_query("INSERT INTO `best_apps` VALUES(null,".$category_id.",'".$title."','".$description."','".$url."','".$review."')");

$id = mysql_insert_id();



if(!empty($_FILES['image'])){
//Get the file information
	$userfile_tmp = $_FILES['image']['tmp_name'];
	$filename = basename($_FILES['image']['name']);
	$file_ext = strtolower(substr($filename, strrpos($filename, '.') + 1));

	$file = './images/'.$id.'.'.$file_ext; 


move_uploaded_file($userfile_tmp, $file);

}

}

}




//default type
$get_categories = mysql_query("SELECT * FROM `best_apps_category` WHERE `type`=1");


for ($count = 1; $cats = mysql_fetch_assoc($get_categories); ++$count){
		 
		 if($count==1)
		 	$sel ='selected="selected"';
		 
		$categories .= '<option '.$sel.' value="'.$cats['id'].'">'.$cats['cat_title'].'</option>';
		
		$sel='';
}


 
	
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Macilove — editor</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" type="text/css" href="http://macilove.com/editor_files/style.css" />
<link rel="apple-touch-icon-precomposed" href="http://macilove.com/editor_files/images/idevsource_ipad_icon.png" />
<meta http-equiv="Cache-Control" content="public">
<script src="http://yandex.st/jquery/1.5.2/jquery.min.js" type="text/javascript"></script>

<style>
h1{
	font-size: 18px;
}
</style>

<script type="text/javascript">
$(document).ready(function(){

$('#type_select').change(function(){ 
  
  
  if($(this).val() == 'new'){
   $('#new_type_div').show();
   $('#new-type-input').focus();
   $('input[name="new_type_add"]').val(1);
  }
  else
  {
	$('#new_type_div').hide();
	$('input[name="new_type_add"]').val(0);
  }	
  
});


$('#type').change(function(){ 

	

$.post(
			'./editor_handler.php',  
	        {'t':$(this).val()},  
	        function(responseText){
	        $('#type_select').html(responseText+'<option></option><option value="new" id="select">Создать новый тип…</option>');
	        
		    },'html');

});



});

</script>

</head>

<body>

<div id="center">
<div id="navigation" style="float:left;">
<ul>	
	<span id="logo">
	<a href="http://macilove.com">
	<li> 
	<strong>Macilove</strong> editor</li>
	</a>
	</span>
	<span id="global_menu">
		<li class="menu"><a href="./.././editor/hueshifter-os-x-app-for-transposition-color-in-images/" >Последняя добавленная</a></li>
        <li class="menu"><a href="./../../news//">Просмотр</a></li>
	</span>    
</ul>
</div>

<div class="user_info_conteiner">
	<h1>Редактор лучших приложений и игр</h1>
	<h4>Категория лучших:</h4>
	<form action="" method="post" enctype="multipart/form-data">
	<select id="type" name="type" style="float:left; clear:left; font-size:12px;">
		<option value="1" selected="selected">Mac OS Приложений</option>
		<option value="2">Mac OS Игр</option>
		<option value="3">iOS Приложений</option>
		<option value="4">iOS Игр</option>
	</select>
	
	<h4>Написать в раздел:</h4>
	<select id="type_select" name="categories" style="float:left; clear:left; font-size:12px;">
      
      <?php echo $categories; ?>
      
      <option></option>
      <option value="new" id="select">Создать новый тип…</option>
    </select>
    
    <div id="new_type_div" style="display:none;">
    <h4>Новый радел</h4>
    <input name="new_type" type="text" style="width:669px; margin-bottom:0 !important; float:left; clear:left;" id="new-type-input" maxlength="140" class="space_under" value="">
    <input type="hidden" name="new_type_add" value="0">
    </div>
    	
    <h4>Название</h4>
	<input name="title" type="text" style="width:669px; margin-bottom:0 !important; float:left; clear:left;" maxlength="140" class="space_under" value="">
	<h4>Описание</h4>
	<textarea name="description" class="new_post_textarea" maxlength="156" cols="50" rows="10" id="text4" style="height: 50px; border-radius: 0;"></textarea>
	<h4>URL Скачать</h4>
	<input name="url" type="text" style="width:669px; float:left; clear:left;" maxlength="140" placeholder="Скачать" value="">
	<h4>URL Обзор</h4>
	<input name="url-review" type="text" style="width:669px; float:left; clear:left;" maxlength="140" placeholder="Обзор" value="">
	<h4>Иконка</h4>
	<input name="image" type="file" style="float:left; clear:left;" class="space_under" >
	
	
	
	<span style="float:left; clear:left;">
		
	<span id="publish_button_box">
	<input name="submit" type="submit" style="float:right;font-size:13px;" value="Сохранить">
	</form>
	</span>
	
		
</div>       
</div>
</body>
</html>

