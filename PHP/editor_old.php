<?php
session_start();
@include_once("./config.inc.php");
@include_once("./functions.inc.php");
@include_once("./twi-master/tmhOAuth.php");
@include_once("./twi-master/tmhUtilities.php");
@include_once('./make_sitemap.php');
//@include_once("./editor_files/amazon_functions.php");

header("Content-Type: text/html; charset=utf-8"); 

$link = mysql_connect($DBSERVER, $DBUSER, $DBPASS)
or die("Can't connect" );
mysql_select_db($DB, $link) or die ("Can't select DB");

//echo mysql_client_encoding($link);
//if()
//mysql_set_charset("UTF8", $link);

if(isset($_COOKIE['admmacilove']) AND $_COOKIE['admmacilove'] == 111111){


setcookie('admmacilove', '111111', time() + 3600 * 24 * 30, '/'); 

$prefix = "./../";

function resize($file_input, $file_output, $w_o) {
switch($w_o){
	case 120:{
		$standart_width = 120;
		$standart_height = 80;
		break;
	}
	case 200:{
		$standart_width = 200;
		$standart_height = 104;
		break;
	}
	case 270:{
		$standart_width = 270;
		$standart_height = 140;
		break;
	}
	
	
	
}



list($w_i, $h_i, $type) = getimagesize($file_input);
	if (!$w_i || !$h_i) {
		echo "can't get height and size from: ".$file_input;
    }
$types = array('','', 'jpeg','png', '', '', 'bmp');

$ext = $types[$type];
    if ($ext){
    	$func_imgcrt = 'imagecreatefrom'.$ext;
    	$img = $func_imgcrt($file_input);
    } else {
    	echo 'Invalid file format';
		return;
    }



	if($w_i >= $h_i){
	
	$h_o = $standart_height;
	$w_o = ceil($h_o*$w_i/$h_i);
	if($w_o < $standart_width)
	$w_o = $standart_width;
	$w_cr = ($w_o-$standart_width)/2;
	}
	else{
	$h_o = ceil($w_o*$h_i/$w_i);
	if($h_o < $standart_height)
	$h_o = $standart_height;
	$h_cr = ($h_o-$standart_height)/2;
	}
	 
	
	$img_o = imagecreatetruecolor($w_o, $h_o);	
	imagecopyresampled($img_o, $img, 0, 0, 0, 0, $w_o, $h_o, $w_i, $h_i);
	
	if($type == 2){
		imagejpeg($img_o,$file_output,100);
	} else {
		$func = 'image'.$ext;
		$func($img_o,$file_output);
	}
	
	imagedestroy($img_o);
	
//переменная велечина в функции только для macilvoe
	$img_crop = $func_imgcrt($file_output);

	$img_canvas = imagecreatetruecolor($standart_width, $standart_height);

	if($w_i >= $h_i)
	imagecopy($img_canvas, $img_crop, 0, 0, $w_cr, 0, $standart_width, $standart_height);	
	else
	imagecopy($img_canvas, $img_crop, 0, 0, 0, $h_cr, $standart_width, $standart_height);	
	
	if ($type == 2) {
		imagejpeg($img_canvas,$file_output,100);
	
	}else{
		$func = 'image'.$ext;
		$func($img_canvas,$file_output);
	}
	imagedestroy($img_canvas); 
	return;
}





//mysql_query("SET NAMES utf8");


if(!empty($_GET['url'])){
$url = mysql_escape_string(trim($_GET['url']));
$prefix = "./../../";

$query_exist_cont = mysql_query("SELECT `id`, `categories`, `title`, `body`, `cut`,`description`,`source` FROM `content` WHERE `url`='".$url."'");
if(mysql_num_rows($query_exist_cont) !== 1)
header("Location: ./../");
$exist_cont = mysql_fetch_assoc($query_exist_cont);
$id_cont = $exist_cont['id'];
$title_cont = stripslashes($exist_cont['title']);
$textarea_cont = stripslashes($exist_cont['body']);
$cut_cont = stripslashes($exist_cont['cut']);
$description = stripslashes($exist_cont['description']);
$source_from_db = stripslashes($exist_cont['source']);

$categories = $exist_cont['categories'];
switch($categories){
	case 0:{
	$categories0 = "selected=\"selected\"";
	break;}
	case 1:{
	$categories1 = "selected=\"selected\"";
	break;}
	case 2:{
	$categories2 = "selected=\"selected\"";
	break;}
	case 3:{
	$categories3 = "selected=\"selected\"";
	break;}
	case 4:{
	$categories4 = "selected=\"selected\"";
	break;}
	case 5:{
	$categories5 = "selected=\"selected\"";
	break;}
	case 6:{
	$categories6 = "selected=\"selected\"";
	break;}
	case 7:{
	$categories7 = "selected=\"selected\"";
	break;}
	case 8:{
	$categories8 = "selected=\"selected\"";
	break;}
	case 9:{
	$categories9 = "selected=\"selected\"";
	break;}
	case 10:{
	$categories10 = "selected=\"selected\"";
	break;}
	case 13:{
	$categories13 = "selected=\"selected\"";
	break;}
	
	}

/////////////////////////////////////////////////////////////////////////////////////////////////
// view tags//
$existing_tags = mysql_query("SELECT `tag_id` FROM `tag_cont` WHERE `cont_id`=".$id_cont."");
$num_rows = mysql_num_rows($existing_tags);
for ($count = 1; $img = mysql_fetch_assoc($existing_tags); ++$count){
		 $id_tag= $img['tag_id'];
		 $exist_tags_q = mysql_query("SELECT `tag` FROM `tags` WHERE `id`=".$id_tag."");
		 $t_s = mysql_fetch_array($exist_tags_q);
		 $old_tags[$count] = $t_s[0];
		 $tags_string .= $old_tags[$count].", "; 
	}
$l = strlen("$tags_string")-2;
$tags_strign_print = substr($tags_string,0,$l);




////////////////////////////////////////////////////////////////////////////////////////////////////
$update = true;

if(!empty($_POST['publish'])){


$publish_q = mysql_query("UPDATE `content` SET `draft`=1 WHERE id=".$id_cont."");

$tmhOAuth = new tmhOAuth(array(
  'consumer_key' => 't0ZPEQfcFhgnzi60ASQn5g',
  'consumer_secret' => '2AzmZ2CNyylBzMWmnq80jUcJ9ZG4DAqvejox1ktOTY',
  'user_token' => '406829796-Lkd6X3shmYd1DCLB3sHwpjqAN8FSJaI0bN7OQ2Mr',
  'user_secret' => 'TIp4PBkzwqHgzrzRvM8kiIh45tOqRMoDiiyOkK6kjo',
));



$response = $tmhOAuth->request('POST', $tmhOAuth->url('1.1/statuses/update'), array(
  'status' => $title_cont.' http://macilove.com/news/'.$url
));




$_SESSION['make_sitemap'] = true;
call_user_func(make_sitemap());


}



}
else
{
	$start_index = 0;
//$show_img_form = 'false';
	$hide_dropzone = 'display:none';
}


$last_p_q = mysql_query("SELECT `url` FROM `content` ORDER BY `id` DESC LIMIT 1");
$last_posted = mysql_fetch_assoc($last_p_q);





/////////////////////// images in article body

$img_jpg_patt = '#http://macilove.com/images/([A-Za-z0-9:\/\.\+\?\.\%\/\@\!\#\&_\-\-]+)-([0-9]+)\.([A-Za-z]+)#';

preg_match_all($img_jpg_patt, $textarea_cont,$matches);

//print_r($matches);
//$textarea_cont

for($k=0; $k< count($matches[2]);$k++)
{

	$in_article_images .= '<div class="photo_images"><img src="'.$matches[0][$k].'" ><input name="add_images_'.$matches[2][$k].'" type="file"></div>';


}

$start_index = $k;


//////////////////


if(!empty($_POST['submit'])){
$new_cat = $_POST['categories']; 

if($new_cat==0 || $new_cat==13)
	$cat_type = 0;
else if($new_cat==1 || $new_cat==2 || $new_cat==3)
	$cat_type = 1;
else if($new_cat==4 || $new_cat==5 || $new_cat==6)
	$cat_type = 2;
else if($new_cat==7 || $new_cat==8)
	$cat_type = 3;
else if($new_cat==9 || $new_cat==10)
	$cat_type = 4;

	

$title = mysql_escape_string(trim($_POST['title']));
$body = trim($_POST['text']);
$url = stripslashes(trim(strtolower($_POST['url'])));
$url = str_replace(' - ','-',$url);
$url = str_replace(' — ','-',$url);
$url = str_replace(' — ','-',$url);
$url = str_replace(' _ ','-',$url);
$url = str_replace(' — ','-',$url);
$url = str_replace(' ','-',$url);
$url = str_replace('.','-',$url);
$url = str_replace('?','-',$url);
$url = str_replace("'",'-',$url);
$url = str_replace(",",'-',$url);
$url = mysql_escape_string($url);

$cut = mysql_escape_string(trim($_POST['cut']));
$source = mysql_escape_string(trim($_POST['source'])); 

$description = mysql_escape_string(trim($_POST['description']));


/*if(substr($body, 0,5) == '[img]'){
$p_img_main = '#\[img\]\[src\]([a-z0-9\/\.\#\$\%\^\&\*\(\)\=\+\?\!\@\:\;\.\<\>\'\"_-]+)\[/src\]\[p\]\[/p\]\[/img\](.*)#ui';
$r_img_main = '<div class="image"><img src="$1"></div><p class="post-text">$2';
$body = preg_replace($p_img_main, $r_img_main, $body,1);


}
elseif(!$update){
$body = '<p class="post-text">'.$body;
}
*/
if(!$update)
$body = "<div class=\"image\"><img src=\"http://macilove.com/images/".$url.".jpg\" width=\"520\" height=\"270\"  alt=\"".$title."\"></div><p>".$body;

// h3 + img
$p_h2_img = '#(\r\n)*\[h2\](.+)\[/h2\](\r\n)*\[img\]\[src\](.+)\[/src\]\[p\]\[/p\]\[/img\](\r\n)*#ui';
$r_h2_img = '<h2>$2</h2><div class="article-img"><img src="$4"></div>';
$body = preg_replace($p_h2_img, $r_h2_img, $body);


$p_h2_img_p = '#(\r\n)*\[h2\](.+)\[/h2\](\r\n)*\[img\]\[src\](.+)\[/src\]\[p\](.+)\[/p\]\[/img\](\r\n)*#ui';
$r_h2_img_p = '<h2>$2</h2><div class="article-img"><img src="$4"><p>$5</p></div>';
$body = preg_replace($p_h2_img_p, $r_h2_img_p, $body);

///



$p_img = '#\[img\]\[src\]([a-zа-яёА-Я0-9\.\/\$\#\%\&\@\!\^\*\(\)\=\+\?\!\:\;\<\>\'\"\,\_\_-]+)\[/src\]\[p\]\[/p\]\[/img\]#ui';
$r_img = '<div class="article-img"><img src="$1"></div>';
$body = preg_replace($p_img, $r_img, $body);

$p_img_p = '#\[img\]\[src\]([a-zа-яёА-Я0-9\.\/\$\#\%\&\@\!\^\*\(\)\=\+\?\!\:\;\<\>\'\"\,\_\_-]+)\[/src\]\[p\]([ a-zа-яА-Яё0-9\.\/\$\#\%\&\@\!\^\*\(\)\=\+\?\!\:\;\<\>\'\"\«\»\,\_\_\-\-]+)\[/p\]\[/img\]#ui';
$r_img_p = '<div class="article-img"><img src="$1"><p>$2</p></div>';
$body = preg_replace($p_img_p, $r_img_p, $body);




/*
$p_url= '#\[url rel\]http(s)*://([a-zа-яё0-9\.\/\$\#\%\&\@\!\^\*\(\)\=\+\?\!\:\;\<\>\'\"\_-]+)\[/url\]#ui';
$r_url = '<a href="http$1://$2">$3</a>';
$body = preg_replace($p_url, $r_url, $body);
*/

$p_url_err = '#\[url\]([a-zа-яё0-9\.\/\$\#\%\&\@\!\^\*\(\)\=\+\?\!\:\;\<\>\'\"\_-]+)\[/url\]#ui';
$r_url_err = '';
$body = preg_replace($p_url_err, $r_url_err, $body);

$p_url= '#\[url=http(s)*://([a-zа-яё0-9\.\/\$\#\%\&\@\!\^\*\(\)\=\+\?\!\:\;\<\>\'\"\_-]+)\]([ a-zа-яА-Яё0-9\.\/\$\#\%\&\@\!\^\*\(\)\=\+\?\!\:\;\<\>\'\"\«\»\,\_\_\-\-]+)\[/url\]#ui';
$r_url = '<a href="http$1://$2">$3</a>';
$body = preg_replace($p_url, $r_url, $body);

$p_url_ext= '#\[url=http(s)*://([a-zа-яёА-Я0-9\.\/\$\#\%\&\@\!\^\*\(\)\=\+\?\!\:\;\<\>\'\"\,\_\_-]+) ext\]([ a-zа-яА-Яё0-9\.\/\$\#\%\&\@\!\^\*\(\)\=\+\?\!\:\;\<\>\'\"\«\»\,\_\_\-\-]+)\[/url\]#ui';
$r_url_ext = '<a href="http$1://$2" rel="nofollow" target="_blank">$3</a>';
$body = preg_replace($p_url_ext, $r_url_ext, $body);




// h2

$p_h2 = "#(\r\n)*\[h2\](.+)\[/h2\](\r\n)*#ui";
$r_h2 = '</p><h2>$2</h2><p>';
$body = preg_replace($p_h2, $r_h2, $body);




//$p_br = '#\r\n#';
//$r_br = '';
//$body = preg_replace($p_br, $r_br, $body);


//youtube



$p_youtube = "#(\r\n)*\[YT\]http(s)*://www\.youtube\.com/watch\?v=([A-Za-z0-9_-]+)(.*)\[/YT\](\r\n)*#ui";
$r_youtube = '</p><iframe width="660" height="371" src="//www.youtube.com/embed/$3?hd=1&rel=0&theme=light&color=white&iv_load_policy=3" frameborder="0" allowfullscreen></iframe><p>';
$body = preg_replace($p_youtube, $r_youtube, $body);

$p_p_2 = '#\r\n(\r\n)+#';
$r_p_2 = '</p><p>';
$body = preg_replace($p_p_2, $r_p_2, $body);

//code 
$body = addslashes($body);
$p_code = '#\[code\](.+)\[/code\]#ui';
$r_code = '<div class="plain-code-wrapper"><div class="plain_code">$1</div></div>';
$body = preg_replace($p_code, $r_code, $body);




if($update){

//$p_p_upd = '#(?<=</p>)</p><p class="post-text">([ a-zа-яё0-9\(\)\.\/\&\?\!\@\#\=_-]+)(?!</p>)#ui';
//$r_p_upd = '<p class="post-text">$1</p>';

//if($source !=='')
//$body .= "<a class=\"source\" href=\"".$source."\" rel=\"nofollow\" target=\"_blank\">Источник</a>"; 







//$body = preg_replace($p_p_upd, $r_p_upd, $body);


$body = mysql_escape_string($body);


$query = mysql_query("UPDATE `content` SET `type`=".$cat_type.", `categories`=".$new_cat.",`title`='".$title."', `body`='".$body."', `url`='".$url."', `cut`='".$cut."', `description`='".$description."',`source`='".$source."' WHERE id=".$id_cont."");
$loc = "http://macilove.com/news/$url/";

///////////////////////////////////TAGS////////////////////////////////////////
$str = addslashes(trim($_POST['tags']));


$new_tags = explode(",", strtolower($str));
$new_tags_count = count($new_tags)-1;
//$$$$$$$$$$$$////////////////////////////////////////режет одинаковые теги сокращая их до одного
$eq = 0;
$equal = 0;
while($eq <= $new_tags_count){
$equal = 0;
if(!empty($new_tags[$eq])){
while($equal <= $new_tags_count){
if($eq != $equal){
if(!empty($new_tags[$equal])){


if(trim($new_tags[$eq]) == trim($new_tags[$equal])){
unset($new_tags[$equal]);
}
}
}
$equal++;
}
}

$eq++;
}
//$$$$$$$$$$$$$$/////////////////////////////////////////////////////////

$numer_new = 0;
$numer_old = 1;
$a_t = 1;

while($numer_new <= $new_tags_count){/// два цикла первый внешний по кол-ву переменных новых тегов второй по старым из базы
$numer_old = 1;
$match = 0;
while($numer_old <= $num_rows){

if($old_tags[$numer_old] == trim($new_tags[$numer_new])){// проверка на одинаковость тегов во всех старых тегах, новым, те что не прошли равенство являются новыми, условие описывающее удаление тега нужно сделать еще в одном похожем блоке
$match_tags[$numer_new]['old'] = $old_tags[$numer_old];//в переменные загоняем старые и новые значения тегов(идентичны)
$match_tags[$numer_new]['new'] = $new_tags[$numer_new];
unset($old_tags[$numer_old]);
$match = 1;}

++$numer_old;
}
if($match == 0){// если тег не совпал ни с одним из старых то вероятно это новый тег и его следует далее добавить в базу
$add_tag[$a_t] = $new_tags[$numer_new];
$a_t++;
}
	 
++$numer_new;
}

$add_start_num = 1;
while($add_start_num <= count($add_tag)){
if(!empty($add_tag[$add_start_num])){
$add_q = mysql_query("SELECT `id`, `ratio` FROM `tags` WHERE `tag`='".trim($add_tag[$add_start_num])."'");
if(mysql_num_rows($add_q) !== 0 ){
$add_check = mysql_fetch_array($add_q);
$add_img_tag = mysql_query("INSERT INTO `tag_cont` VALUES(NULL, ".$add_check[0].", ".$id_cont.")");
$new_add_ratio = $add_check[1]+1;
$add_ratio = mysql_query("UPDATE `tags` SET `ratio`=".$new_add_ratio." WHERE `id`=".$add_check[0]."");
}
else{
$add_new_tag = mysql_query("INSERT INTO `tags` VALUES(NULL, '".trim($add_tag[$add_start_num])."', 1)");
$new_tag_id = mysql_insert_id();
$add_new_img_tag = mysql_query("INSERT INTO `tag_cont` VALUES(NULL, ".$new_tag_id.", ".$id_cont.")");


}

}
$add_start_num++;
}



$del_start_num = 1;
while($del_start_num <= $num_rows){
if(!empty($old_tags[$del_start_num])){
$del_q = mysql_query("SELECT `id`, `ratio` FROM `tags` WHERE `tag`='".trim($old_tags[$del_start_num])."'");
$del_check = mysql_fetch_array($del_q);
$del_img_tag = mysql_query("DELETE FROM `tag_cont` WHERE `cont_id`=".$id_cont." AND `tag_id`=".$del_check[0]."");

if($del_check[1] > 1){
$new_del_ratio = $del_check[1] - 1;
$ratio_query = mysql_query("UPDATE `tags` SET `ratio`=".$new_del_ratio." WHERE `id`=".$del_check[0]."");
}
else{
$delete_tag = mysql_query("DELETE FROM `tags` WHERE `id`=".$del_check[0]."");
}
}
$del_start_num++;
}
/////////////////////////////


$exg_tg = mysql_query("SELECT `tag_id` FROM `tag_cont` WHERE `cont_id`=".$id_cont."");
for ($count = 1; $img = mysql_fetch_assoc($exg_tg); ++$count){
		 $id_tag= $img['tag_id'];
		 $exist_tags_q = mysql_query("SELECT `tag` FROM `tags` WHERE `id`=".$id_tag."");
		 $upd_t = mysql_fetch_array($exist_tags_q);
		 $t_string .= $upd_t['tag'].", "; 
	}
$l = strlen("$t_string")-2;
$tags_strign_print = substr($t_string,0,$l);







}
else
{


$body .= '</p>';
//if($source !=='')
//$body .= "<a class=\"source\" href=\"".$source."\" rel=\"nofollow\" target=\"_blank\">Источник</a>"; 
$body = mysql_escape_string($body);

if(!$url){
	
header('Location: ./');	
}

$query = mysql_query("INSERT INTO `content` VALUES(null, ".$cat_type.", ".$new_cat.",'".$title."','".$body."', null, 0,'".$url."','".$cut."',0,'".$description."','".$source."')");
$cont_id = mysql_insert_id();

$add_to_statistic = mysql_query("INSERT INTO `statistic` VALUES(null,".$cont_id.",0,0,0)");

$comment_query = mysql_query("INSERT INTO `comments` VALUES(".$cont_id.", 0)"); 

$loc = "http://macilove.com/news/$url/";


/////////////////////////////////////////////////////////////////////////////////////////////////

$tags = addslashes(trim($_POST['tags']));

$tags = explode(",", strtolower($tags));

for($n = 0; !empty($tags[$n]); $n++){

$s_tag = mysql_query("SELECT * FROM `tags` WHERE `tag`='".trim(strtolower($tags[$n]))."'");

if(mysql_num_rows($s_tag) !== 0){
$s_t = mysql_fetch_assoc($s_tag);
$tag_id = $s_t['id'];
$tag_ratio = $s_t['ratio']+ 1;
$upd_t = mysql_query("UPDATE `tags`  SET `ratio`=".$tag_ratio." WHERE `id`=".$tag_id.""); 
}
else{
$add_t = mysql_query("INSERT INTO `tags` VALUES(NULL,'".trim(strtolower($tags[$n]))."',1)");
$tag_id = mysql_insert_id();
}

$photo_tag = mysql_query("INSERT INTO `tag_cont` VALUES(NULL,".$tag_id.",".$cont_id." )");
}

/////////////////////////////////////////////////////////////////////////////////

}


if(!empty($_FILES['image'])){

//Get the file information
	$userfile_tmp = $_FILES['image']['tmp_name'];
	$filename = basename($_FILES['image']['name']);
	$file_ext = strtolower(substr($filename, strrpos($filename, '.') + 1));


$file = 'images/'.$url.'.'.$file_ext; 
$file_m = 'images/'.$url.'-m.'.$file_ext;
$file_s = 'images/'.$url.'-s.'.$file_ext;
$file_l = 'images/'.$url.'-l.'.$file_ext;



if(move_uploaded_file($userfile_tmp, './'.$file)){ 
chmod('./'.$file, 0777);
	
			
resize('./'.$file, './'.$file_l, 270);
resize('./'.$file, './'.$file_m, 200);
resize('./'.$file, './'.$file_s, 120);


/*
AMAZON S3

$sources[1]['name'] = $url.".jpg";
$sources[2]['name'] = $url."-s.jpg";
$sources[3]['name'] = $url."-m.jpg";
$sources[4]['name'] = $url."-l.jpg";


$sources[1]['path'] = $file;
$sources[2]['path'] = $file_s;
$sources[3]['path'] = $file_m;
$sources[4]['path'] = $file_l;

$public[3] =true;
for($i=1; $i<=4; $i++){


	
	
	upload_to_s3("http://macilove.com/".$sources[$i]['path'], $sources[$i]['name'],$fp,$aws_key,$public[$i]);
	unlink($sources[$i]['path']);
}
*/

}





}

//////////////////////// aditional images

$l=0;
$trig = true;

for($l; $l<$k; $l++)
{

	
if($_FILES["add_images_".$l]['error']==4 || empty($_FILES["add_images_".$l]))
	{
		continue;
	}
	else{
		
		
		///upload here

		$tempFile = $_FILES["add_images_".$l]['tmp_name'];
	
		$ext = pathinfo($_FILES["add_images_".$l]['name']);
		
		$new_file_name = $url."-".$l.".".$ext['extension'];
		
		
		$file = "./images/".$new_file_name;
		

		move_uploaded_file($tempFile, $file);
		
		
		
			
		/* AMAZON S3
upload_to_s3("http://macilove.com/images/".$new_file_name,$new_file_name ,$fp,$aws_key);
		unlink($file);
*/

	}
		
}





//header("Location: $loc");
}

?>
<!DOCTYPE HTML>
<html>
<head>
<title>Macilove — editor</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" type="text/css" href="<?php echo $prefix; ?>./editor_files/style.css" />
<link rel="apple-touch-icon-precomposed" href="<?php echo $prefix; ?>./editor_files/images/idevsource_ipad_icon.png" />
<meta http-equiv="Cache-Control" content="public">

<script src="http://yandex.st/jquery/1.5.2/jquery.min.js" type="text/javascript"></script>

<link rel="stylesheet" type="text/css" href="<?php echo $prefix; ?>./editor_files/js/bbedit/bbedit.css" />
<script type="text/javascript" src="<?php echo $prefix; ?>./editor_files/js/bbedit/jquery.bbedit.js"></script>
<script type="text/javascript" src="<?php echo $prefix; ?>./editor_files/dropzone.js"></script>
<style type="text/css">
.dropzone{
	display: none !important;
}
</style>
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
		<li class="menu"><a href="<?php echo $prefix;?>./editor/<?php echo $last_posted['url']; ?>/" >Последняя добавленная</a></li>
        <li class="menu"><a href="./../../news/<?php echo $url; ?>/">Просмотр</a></li>
        <li class="menu"><form action="" method="post"><input name="publish" type="submit" style="float:right;font-size:13px; margin-top: 7px;" value="Опубликовать"></form></li>
	</span>    
</ul>
</div>

<div class="user_info_conteiner">
	<h4>Написать в раздел:</h4>
	<form action="" method="post" enctype="multipart/form-data">
	<select name="categories" style="float:left; clear:left; font-size:12px;">
      <option selected="selected" value="0" <?php echo $categories0; ?>>Новости Apple</option>
      <option value="13" <?php echo $categories13; ?>>Обзор аксессуаров Apple</option>
      <option></option>
      <option value="3" <?php echo $categories3; ?>> Игры для iOS</option>
      <option value="1" <?php echo $categories1; ?>> Игры для iPhone</option>
      <option value="2" <?php echo $categories2; ?>> Игры для iPad</option>      
      <option></option>
      <option value="6" <?php echo $categories6; ?>>Приложения для iOS</option>
      <option value="4" <?php echo $categories4; ?>>Приложения для iPhone</option>
      <option value="5" <?php echo $categories5; ?>>Приложения для iPad</option>
      <option></option>
      <option value="7" <?php echo $categories7; ?>>Приложения для Mac OS X</option>
      <option value="8" <?php echo $categories8; ?>>Игры для Mac OS X</option>
      <option></option>
      <option value="10" <?php echo $categories10; ?>>Трюки и секреты Mac OS X</option>
      <option value="9" <?php echo $categories9; ?>>Трюки и секреты iOS</option>
    </select>
    
    	
    <h4>Заголовок</h4>
    <span class="inputs-width">
	<input name="title" type="text" style="width:669px; margin-bottom:0 !important; float:left; clear:left;" maxlength="140" class="space_under" placeholder="Без точки" value="<?php echo $title_cont; ?>">
	<h4>Description</h4>
	<textarea name="description" class="new_post_textarea" maxlength="156" cols="50" rows="10" id="text4" style="height: 50px; border-radius: 0;"><?php echo $description; ?></textarea>
	<h4>URL</h4>
	<input name="url" type="text" style="width:669px; float:left; clear:left;" maxlength="140" placeholder="article-name" value="<?php echo $url; ?>">
	<h4>Источник</h4>
	<input name="source" type="text" style="width:669px; margin-bottom:0 !important; float:left; clear:left;" value="<?php echo $source_from_db; ?>" class="space_under" placeholder="/source/" >
	<h4>Основная картинка</h4>
	<input name="image" type="file" style="float:left; clear:left;" class="space_under" >
	<h4>Cut</h4>
	<textarea name="cut" class="new_post_textarea" cols="50" rows="10" style="height:100px; margin-bottom:20px;" id="text"><?php echo $cut_cont; ?></textarea>
    </span>
	
	<script type="text/javascript">
    $(document).ready(function() {

      // Bbcode editor with highlight
      $("#text3").bbedit({
        highlight: true,
        enableSmileybar: false,
        tags: 'b,code,url,url_ext,img,h2,youtube'
      });
      
      
    
	/*
	$('input[name="url"]').blur(function () {
			
			
			if (!$('input:text.url').is(":empty")) {
				$('#dropzone_div').show();
				$('#dropzone_url').val($('input[name="url"]').val());
				 
			}
	
		});
*/

$('input[name="url"]').blur(function () {
			
		//var show_form = !<?php echo $show_img_form; ?>;
		//&& show_form	
			if (!$('input:text.url').is(":empty") ) {
				$('.dropzone').show();
				$('#dropzone_url').val($('input[name="url"]').val());
			}
	
		});



	$(".dropzone").dropzone({
		
       init: function() {
       
			this.on("complete", function(file) { 
				var num = parseInt($('#dropzone_num').val()) + 1;
				
				$('#dropzone_num').val(num);
				$('#dropzone_url').val($('input[name="url"]').val());
				
			});
			}
	});

   









    
	    
/*
	   var myDropzone = new Dropzone("#dropzone_div", {url : "./editor_files/file_handler.php"});

	      
	  myDropzone.options.headers = {"dropzone_num":"0"};
	  myDropzone.options.headers = {"dropzone_url":$('input[name="url"]').val()};

	   
	   myDropzone.on("complete", function(file) { 
				var num = parseInt($('#dropzone_num').val()) + 1;
				
				$('#dropzone_num').val(num);
				$('#dropzone_url').val($('input[name="url"]').val());

			});
		
	   
*/
	       
	    
	    
    
    });
    </script>
    
	<textarea name="text" class="new_post_textarea" cols="50" rows="10" id="text3"><?php echo $textarea_cont; ?></textarea>

	<span style="float:left; clear:left;">
	<input name="tags" type="text" style="width:420px; margin-top:20px; float:left; clear:left;" maxlength="140" placeholder="Теги"  class="space_under" id="text3" value="<?php echo $tags_strign_print; ?>">
	
	<div id="publish_button_box">
	
	<input name="submit"  type="submit" style="float:right;font-size:13px;" value="Сохранить">
	</div>
	
	<div class=""uploaded-images>	
	<?php echo $in_article_images; ?>
	</div>
	</form>
	
	<!-- additional images	 -->
	
	
	
	
	<form action="http://macilove.com/editor_files/file_handler.php" class="dropzone" style="<?php echo $hide_dropzone;?>">
		<input id="dropzone_url" type="hidden" name="params_url"/>
		<input id="dropzone_num" type="hidden" name="params_num" value="<?php echo $start_index; ?>"/>
		
	</form>

		
</div>       
</div>
</body>
</html>

<?php }

else
header("Location: ../news/");



?>
