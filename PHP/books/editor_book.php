<?php
@include_once("../config.inc.php");
@include_once("../functions.inc.php");
header("Content-type:text/html;charset=utf-8"); 
$link = mysql_connect($DBSERVER, $DBUSER, $DBPASS)
or die("Can't connect" );
mysql_select_db($DB, $link) or die ("Can't select DB");


if(isset($_COOKIE['admmacilove']) AND $_COOKIE['admmacilove'] == 111111){


setcookie('admmacilove', '111111', time() + 3600 * 24 * 30, '/'); 




if(isset($_GET['url'])){
$update = true;


$check = mysql_query("SELECT * FROM `books` WHERE `url`='".$_GET['url']."'");
$check_num = mysql_num_rows($check);


if($check_num){
	$book = mysql_fetch_assoc($check);
$car_sel[$book['category']]  = "selected=\"selected\"";
	
}



// view tags//
$existing_tags = mysql_query("SELECT `tag_id` FROM `tag_books` WHERE `book_id`=".$book['id']."");
$num_rows = mysql_num_rows($existing_tags);
for ($count = 1; $ex_tags = mysql_fetch_assoc($existing_tags); ++$count){
		 $id_tag= $ex_tags['tag_id'];
		 $exist_tags_q = mysql_query("SELECT `tag` FROM `book_tags` WHERE `id`=".$id_tag."");
		 $t_s = mysql_fetch_array($exist_tags_q);
		 $old_tags[$count] = $t_s[0];
		 $tags_string .= $old_tags[$count].", "; 
	}
$l = strlen("$tags_string")-2;
$tags_strign_print = substr($tags_string,0,$l);





	
}
else 
$def_cat = "selected=\"selected\"";
 

if(isset($_POST['add'])){
	
$title = trim($_POST['title']);
$ozon = trim($_POST['ozone_url']);
$url = strtolower(trim($_POST['url']));
$aut = trim($_POST['aut']);
$izd = trim($_POST['izd']);
$sopr_text = trim($_POST['sopr_text']);
$red_text = trim($_POST['red_text']);
$volume = trim($_POST['volume']);
$format =  trim($_POST['format']);
$isbn = trim($_POST['isbn']);
$cover = trim($_POST['cover']);
$img = trim($_POST['img']);
$category = trim($_POST['category']);

if(!$update){
//mysql_query("SET NAMES utf8");

mysql_query("INSERT INTO `books` VALUES(null,".$category.",'".$title."','".$ozon."','".$url."','".$aut."','".$izd."','".$sopr_text."','".$red_text."','".$volume."','".$format."','".$isbn."','".$cover."','".$img."')");		


$book_id = mysql_insert_id();

/////////////////////////////////////////////////////////////////////////////////////////////////

$tags = addslashes(trim($_POST['tags']));

$tags = explode(",", strtolower($tags));

for($n = 0; !empty($tags[$n]); $n++){

$s_tag = mysql_query("SELECT * FROM `book_tags` WHERE `tag`='".trim(strtolower($tags[$n]))."'");

if(mysql_num_rows($s_tag) !== 0){
$s_t = mysql_fetch_assoc($s_tag);
$tag_id = $s_t['id'];
$tag_ratio = $s_t['ratio']+ 1;
$upd_t = mysql_query("UPDATE `book_tags`  SET `ratio`=".$tag_ratio." WHERE `id`=".$tag_id.""); 
}
else{
$add_t = mysql_query("INSERT INTO `book_tags` VALUES(NULL,'".trim(strtolower($tags[$n]))."',1)");
$tag_id = mysql_insert_id();
}

$photo_tag = mysql_query("INSERT INTO `tag_books` VALUES(NULL,".$tag_id.",".$cont_id." )");
}

/////////////////////////////////////////////////////////////////////////////////


}
else{

mysql_query("UPDATE `books` SET `category`=".$category.",`title`='".$title."',`ozon_url`='".$ozon."',`url`='".$url."',`author`='".$aut."',`izd`='".$izd."',`izd_text`='".$sopr_text."',`red_text`='".$red_text."',`volume`='".$volume."',`format`='".$format."',`ISBN`='".$isbn."',`cover`='".$cover."',`img`='".$img."' WHERE `id`=".$book['id']."");



$tags = addslashes(trim($_POST['tags']));
if(!empty($tags)){

$tags = " ".$tags; 
$new_tags = explode(",", strtolower($tags));
$new_tags = array_values(array_unique($new_tags));
$new_tags_count = count($new_tags)-1;




$numer_new = 0;
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
$add_q = mysql_query("SELECT `id`, `ratio` FROM `book_tags` WHERE `tag`='".trim($add_tag[$add_start_num])."'");
if(mysql_num_rows($add_q) !== 0 ){
$add_check = mysql_fetch_array($add_q);
$add_img_tag = mysql_query("INSERT INTO `tag_books` VALUES(NULL, ".$add_check[0].", ".$book['id'].")");
$new_add_ratio = $add_check[1]+1;
$add_ratio = mysql_query("UPDATE `book_tags` SET `ratio`=".$new_add_ratio." WHERE `id`=".$add_check[0]."");
}
else{
$add_new_tag = mysql_query("INSERT INTO `book_tags` VALUES(NULL, '".trim($add_tag[$add_start_num])."', 1)");
$new_tag_id = mysql_insert_id();
$add_new_img_tag = mysql_query("INSERT INTO `tag_books` VALUES(NULL, ".$new_tag_id.", ".$book['id'].")");


}

}
$add_start_num++;
}



$del_start_num = 1;
while($del_start_num <= $num_rows){
if(!empty($old_tags[$del_start_num])){
$del_q = mysql_query("SELECT `id`, `ratio` FROM `book_tags` WHERE `tag`='".trim($old_tags[$del_start_num])."'");
$del_check = mysql_fetch_array($del_q);
$del_img_tag = mysql_query("DELETE FROM `tag_books` WHERE `book_id`=".$book['id']." AND `tag_id`=".$del_check[0]."");

if($del_check[1] > 1){
$new_del_ratio = $del_check[1] - 1;
$ratio_query = mysql_query("UPDATE `book_tags` SET `ratio`=".$new_del_ratio." WHERE `id`=".$del_check[0]."");
}
else{
$delete_tag = mysql_query("DELETE FROM `book_tags` WHERE `id`=".$del_check[0]."");
}
}
$del_start_num++;
}
/////////////////////////////


$exg_tg = mysql_query("SELECT `tag_id` FROM `tag_books` WHERE `book_id`=".$book['id']."");
for ($count = 1; $img = mysql_fetch_assoc($exg_tg); ++$count){
		 $id_tag= $img['tag_id'];
		 $exist_tags_q = mysql_query("SELECT `tag` FROM `book_tags` WHERE `id`=".$id_tag."");
		 $upd_t = mysql_fetch_array($exist_tags_q);
		 $t_string .= $upd_t['tag'].", "; 
	}
$l = strlen("$t_string")-2;
$tags_strign_print = substr($t_string,0,$l);



}
}

/////////////////////////////////////////////////


if($book['id'] != $img OR !$update)
{

$img_url = $_POST['img'];


// file type
$ftype = explode('.', $img_url);

$i = 0;
while($ftype[$i] != '')
{
	$i++;
}
$i--;

$ftype = $ftype[$i];




//

$source_file = './books-images/'.$url.".$ftype"; 

$pre_source_file = './books-images/'.$url."-p.$ftype";




switch($ftype){
	case 'jpg':
	$file_type = "image/jpeg";
	break;
	case 'png':
	$file_type = "image/png";
	break;
	case 'gif':
	$file_type = "image/gif";
	break;
	case 'JPG':
	$file_type = "image/JEPG";
	break;
	case 'PNG':
	$file_type = "image/PNG";
	break;
	case 'GIF':
	$file_type = "image/GIF";
	break;
	default:
	$file_type = "image/jpeg";
	break;
	
}


function GetImageFromUrl($link)
 
{
 
$ch = curl_init();
 
curl_setopt($ch, CURLOPT_POST, 0);
 
curl_setopt($ch,CURLOPT_URL,$link);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
 
$result=curl_exec($ch);
 
curl_close($ch);
 
return $result;
 
} 


$contents = GetImageFromUrl($img_url);
$savefile = fopen($source_file, 'w');
fwrite($savefile, $contents);
fclose($savefile);

function resize($file_input, $file_output) {
$w_o = 306;


list($w_i, $h_i, $type) = getimagesize($file_input);
	if (!$w_i || !$h_i){
		header("Location: ../ff/");
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

$h_o = $w_o*$h_i/$w_i;

	 
	 
	$img_o = imagecreatetruecolor($w_o, $h_o);	
	imagecopyresampled($img_o, $img, 0, 0, 0, 0, $w_o, $h_o, $w_i, $h_i);
	if($type == 2){
		imagejpeg($img_o,$file_output,100);
	} else {
		$func = 'image'.$ext;
		$func($img_o,$file_output);
	}
	
	imagedestroy($img_o);
	return;
}


resize($source_file, $pre_source_file);



/////////////////////////////////////////////////////////////////////







header("Location: ./editor_book.php?url=".$url);
}
}
	


//http://www.ozon.ru/context/detail/id/18383236/?partner=macilove&from=bar


}
else
header("Location: ../news/apple-news/");



?>

<html>
<head>
<style type="text/css">

input{
	width: 540px;
	height: 30px;
	font-size: 13px;
	margin-bottom: 3px;
}
textarea{
	width: 540px;
	height: 140px;
	margin-bottom: 3px;
}
input[type="submit"] {
  margin-top: 5px;
  margin-bottom: 200px;
}
</style>
</head>
<body>

<form action="" method="post">
<select name="category">
	<option <?php echo $def_cat; ?>>– Категории –</option>
	<option <?php echo $car_sel[1]; ?> value="1">Компании</option>
	<option <?php echo $car_sel[2]; ?> value="2">Биографии</option>
	<option <?php echo $car_sel[3]; ?> value="3">Mac OS X</option>
	<option <?php echo $car_sel[4]; ?> value="4">iPhone & iPad</option>
	<option <?php echo $car_sel[5]; ?> value="5">Программирование</option>
	<option <?php echo $car_sel[6]; ?> value="6">Руководства</option>
	<option <?php echo $car_sel[7]; ?> value="7">Приложения</option>
	<option <?php echo $car_sel[8]; ?> value="8">Бизнес</option>
</select><br/>
<br/>
<input type="text" name="title" placeholder="Название" autocomplete="off" value="<?php echo $book['title']; ?>" autofocus=""><br />
<input type="text" name="ozone_url" placeholder="Партнерская ссылка" value="<?php echo $book['ozon_url']; ?>" autocomplete="off"><br />
<input type="text" name="url" placeholder="Внутренняя ссылка" value="<?php echo $book['url']; ?>" autocomplete="off"><br />
<input type="text" name="aut" placeholder="Автор" value="<?php echo $book['author']; ?>" autocomplete="off"><br />
<input type="text" name="izd" placeholder="Издательство" value="<?php echo $book['izd']; ?>" autocomplete="off"><br />
<input type="text" name="isbn" placeholder="ISBN" value="<?php echo $book['ISBN']; ?>" autocomplete="off"><br />
<textarea name="red_text" placeholder="От редакции Macilove" autocomplete="off" style="display:none;"><?php echo $book['red_text']; ?></textarea><br />
<br />
Выходные данные:
<br />
<input type="text" name="volume" placeholder="Страниц" value="<?php echo $book['volume']; ?>" autocomplete="off"><br />
<input type="text" name="format" placeholder="Формат" value="<?php echo $book['format']; ?>" autocomplete="off"><br />
<input type="text" name="cover" placeholder="Переплет" value="<?php echo $book['cover']; ?>" autocomplete="off"><br />

<input type="text" name="tags" placeholder="теги" value="<?php echo $tags_strign_print; ?>" autocomplete="off"><br />
<input type="text" name="img" placeholder="картинка" value="<?php echo $book['img']; ?>" autocomplete="off"><br />
<textarea name="sopr_text" placeholder="От производителя" autocomplete="off"><?php echo $book['izd_text']; ?></textarea><br />
<input type="submit" name="add" value="Добавить"><br />
</form>	
	
	
	
</body>
</html>