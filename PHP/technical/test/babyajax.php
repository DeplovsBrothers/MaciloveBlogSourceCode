<?php

if($_POST['sub']){
if(!empty($_FILES))
print_r($_FILES['photo_1']);
else
echo "clear";
}

echo $_POST['prod'];
/*session_start(); // Do not remove this
@require("../config.inc.php");
@require("../functions.inc.php");
header("Content-type:text/html;charset=utf-8");

///////////////////////////////////////////////////////////////////////////////////
function resize($file_input, $file_output, $w_o, $h_o, $percent = false) {
	list($w_i, $h_i, $type) = getimagesize($file_input);
	if (!$w_i || !$h_i) {
		echo 'Невозможно получить длину и ширину изображения';
		return;
    }
    $types = array('','gif','jpeg','png', 'GIF', 'JPEG', 'PNG');
    $ext = $types[$type];
    
    if ($ext) {
    	$func = 'imagecreatefrom'.$ext;
    	$img = $func($file_input);
    } else {
    	echo 'Некорректный формат файла';
		return;
    }
	if ($percent) {
		$w_o *= $w_i / 100;
		$h_o *= $h_i / 100;
	}
	if (!$h_o) $h_o = $w_o/($w_i/$h_i);
	if (!$w_o) $w_o = $h_o/($h_i/$w_i);
	$img_o = imagecreatetruecolor($w_o, $h_o);
	imagecopyresampled($img_o, $img, 0, 0, 0, 0, $w_o, $h_o, $w_i, $h_i);
	if ($type == 2) {
		return imagejpeg($img_o,$file_output,100);
				imagedestroy($img_o);

	} else {
		$func = 'image'.$ext;
		return $func($img_o,$file_output);
	}
}

function crop($file_input, $file_output, $crop = 'square',$percent = false) {
	list($w_i, $h_i, $type) = getimagesize($file_input);
	if (!$w_i || !$h_i) {
		echo 'Невозможно получить длину и ширину изображения';
		return;
    }
    $types = array('','gif','jpeg','png', 'GIF', 'JPEG', 'PNG');
    $ext = $types[$type];
    if ($ext) {
    	$func = 'imagecreatefrom'.$ext;
    	$img = $func($file_input);
    } else {
    	echo 'Некорректный формат файла';
		return;
    }
	if ($crop == 'square') {
		$min = $w_i;
		if ($w_i > $h_i) $min = $h_i;
		$w_o = $h_o = $min;
	} else {
		list($x_o, $y_o, $w_o, $h_o) = $crop;
		if ($percent) {
			$w_o *= $w_i / 100;
			$h_o *= $h_i / 100;
			$x_o *= $w_i / 100;
			$y_o *= $h_i / 100;
		}
    	if ($w_o < 0) $w_o += $w_i;
	    $w_o -= $x_o;
	   	if ($h_o < 0) $h_o += $h_i;
		$h_o -= $y_o;
	}
	$img_o = imagecreatetruecolor($w_o, $h_o);
	imagecopy($img_o, $img, 0, 0, $x_o, $y_o, $w_o, $h_o);
	if ($type == 2) {
		return imagejpeg($img_o,$file_output,100);
			   imagedestroy($img_o);
	
	} else {
		$func = 'image'.$ext;
		return $func($img_o,$file_output);
	}
	
}


/////////////////////////////////////////////////////////////////////////////////////////

/////////////////////////////// functions //////////////////////////////
function resizeImage($image,$width,$height,$scale) {
	list($imagewidth, $imageheight, $imageType) = getimagesize($image);
	$imageType = image_type_to_mime_type($imageType);
	$newImageWidth = ceil($width * $scale);
	$newImageHeight = ceil($height * $scale);
	$newImage = imagecreatetruecolor($newImageWidth,$newImageHeight);
	switch($imageType) {
		case "image/gif":
			$source=imagecreatefromgif($image); 
			break;
	    case "image/pjpeg":
		case "image/jpeg":
		case "image/jpg":
			if(@imagecreatefromjpeg($image) == true)
			{
			$source = @imagecreatefromjpeg($image);
			break;
			} 	
			else{
			echo "break";
			exit;
			
			break;}

			//$source=imagecreatefromjpeg($image); 
			
			
			
			
			
			
			
			//break;
	    case "image/png":
		case "image/x-png":
			$source=imagecreatefrompng($image); 
			break;
  	}
	@imagecopyresampled($newImage,$source,0,0,0,0,$newImageWidth,$newImageHeight,$width,$height);
	
	switch($imageType) {
		case "image/gif":
	  		imagegif($newImage,$image); 
			break;
    	case "image/pjpeg":
		case "image/jpeg":
		case "image/jpg":
	  		imagejpeg($newImage,$image,90); 
			break;
		case "image/png":
		case "image/x-png":
			imagepng($newImage,$image);  
			break;
    }
	
	chmod($image, 0777);
	return $image;
}


function getHeight($image) {
	$size = getimagesize($image);
	$height = $size[1];
	return $height;
}
//You do not need to alter these functions
function getWidth($image) {
	$size = getimagesize($image);
	$width = $size[0];
	return $width;
}
/////////////////////////////////////////////////////////////////////////

$link = mysql_connect($DBSERVER, $DBUSER, $DBPASS)
or die("Can't connect");

mysql_select_db($DB, $link) or die (mysql_error()); //("Can't select DB");

$query = mysql_query("SELECT * FROM `registration` WHERE `nick`='".$_GET['user']."'");
$query_arr = mysql_fetch_array($query);

$gallery_query = mysql_query("SELECT * FROM `gallery` WHERE `id`=".$query_arr['id']);
// записываем ее в качестве массива галлереи 
$gallery_arr = mysql_fetch_array($gallery_query);


$point = 5;


while ($gallery_arr[$point] !== ''){
$point++;
} 


switch ($point){

	case 5:
		$photo_number = "photo_1";
		$photo_crop = "crop_1";
		break;
	case 6:
		$photo_number = "photo_2";
		$photo_crop = "crop_2";
		break;
	case 7:
		$photo_number = "photo_3";
		$photo_crop = "crop_3";
		break;
	case 8:
		$photo_number = "photo_4";
		$photo_crop = "crop_4";
		break;
	case 9:
		$photo_number = "photo_5";
		$photo_crop = "crop_5";
		break;
	case 10:
		$photo_number = "photo_6";
		$photo_crop = "crop_6";
		break;
	case 11:
		$photo_number = "photo_7";
		$photo_crop = "crop_7";
		break;
	case 12:
		$photo_number = "photo_8";
		$photo_crop = "crop_8";
		break;
	case 13:
		$photo_number = "photo_9";
		$photo_crop = "crop_9";
		break;
	case 14:
		$photo_number = "photo_10";
		$photo_crop = "crop_10";
		break;
	case 15:
		$photo_number = "photo_11";
		$photo_crop = "crop_11";
		break;
	case 16:
		$photo_number = "photo_12";
		$photo_crop = "crop_12";
		break;
	case 17:
		$photo_number = "photo_13";
		$photo_crop = "crop_13";
		break;
	case 18:
		$photo_number = "photo_14";
		$photo_crop = "crop_14";
		break;
	case 19:
		$photo_number = "photo_15";
		$photo_crop = "crop_15";
		break;
	case 20:
		$photo_number = "photo_16";
		$photo_crop = "crop_16";
		break;
	case 21:
		$photo_number = "photo_17";
		$photo_crop = "crop_17";
		break;
	case 22:
		$photo_number = "photo_18";
		$photo_crop = "crop_18";
		break;
	case 23:
		$photo_number = "photo_19";
		$photo_crop = "crop_19";
		break;
	case 24:
		$photo_number = "photo_20";
		$photo_crop = "crop_20";
		break;
	case 25:
		$photo_number = "photo_21";
		$photo_crop = "crop_21";
		break;
	case 26:
		$photo_number = "photo_22";
		$photo_crop = "crop_22";
		break;
	case 27:
		$photo_number = "photo_23";
		$photo_crop = "crop_23";
		break;
	case 28:
		$photo_number = "photo_24";
		$photo_crop = "crop_24";
		break;
	case 29:
		$photo_number = "photo_25";
		$photo_crop = "crop_25";
		break;
	case 30:
		$photo_number = "photo_26";
		$photo_crop = "crop_26";
		break;
	case 31:
		$photo_number = "photo_27";
		$photo_crop = "crop_27";
		break;
	case 32:
		$photo_number = "photo_28";
		$photo_crop = "crop_28";
		break;
	case 33:
		$photo_number = "photo_29";
		$photo_crop = "crop_29";
		break;
	case 34:
		$photo_number = "photo_30";
		$photo_crop = "crop_30";
		break;
	case 35:
	    exit();	
	default:
		$photo_number = "photo_1";
		$photo_crop = "crop_1";
		break;	
	}



if (!empty($_FILES)) {
$max_width = "800";
$filename = basename($_FILES['Filedata']['name']);
$file_ext = strtolower(substr($filename, strrpos($filename, '.') + 1));
$user = $_GET['user'];


$file = '../user/'.$user.'/'.$photo_number.'_'.$user.'.'.$file_ext; 
$crop_image_location = '../user/'.$user.'/'.$photo_crop.'_'.$user.'.'.$file_ext;



if (move_uploaded_file($_FILES['Filedata']['tmp_name'], $file)) { 
 $large_image_location = $file;
 $width = getWidth($large_image_location);
 $height = getHeight($large_image_location);
		
		if ($width > $max_width){
				$scale = $max_width/$width;
				$uploaded = resizeImage($large_image_location,$width,$height,$scale);
				
			}else{
				$scale = 1;
				$uploaded = resizeImage($large_image_location,$width,$height,$scale);
				
				}

			crop($file, $crop_image_location);
			resize($crop_image_location, $crop_image_location, 115,115);


$photo_exist = $gallery_arr['photo_exist'] + 1;

 $insert = mysql_query("UPDATE `gallery`
				  SET `photo_exist`=".$photo_exist.", `".$photo_number."`='".$file."', `".$photo_crop."`='".$crop_image_location."' 
				  WHERE `id`='".$query_arr['id']."'");


if (file_exists($_FILES['Filedata']['tmp_name'])) {
		unlink($_FILES['Filedata']['tmp_name']);
	}

  
} else {
	unlink($_FILES['Filedata']['tmp_name']);
	exit;
}


	
		
		//////// обязательная строка echo для пробегания полоски и ее оттупливания
		echo "Exelent";
	
	
	}
	*/
?>
<html>
<head>
<script type="text/javascript">
function cs(){

console.log(document.getElementById('photo').value);
if(document.getElementById('photo1').value == false)
console.log("ok");



}
</script>
</head>
<body>
<form enctype="multipart/form-data" method="post" action="" name="add_ad">
<select id="product" name="prod">
				<option value="1">iPad</option>
				<option>iPhone</option>
				<option>iPod</option>
				<option>iMac</option>
				<option>MacBook</option>
				<option>MacBook Pro</option>
				<option>MacBook Air</option>
				<option>Mac Mini</option>
				<option>Mac Pro</option>
				<option>Apple дисплей</option>
				<option>Аксессуары</option>
				<option>Другое</option>
			</select>
			
<input id="photo" type="file" name="photo_1" accept="image/jpeg" style="float:left; clear:left;" onblur="javascript:cs()">
<input id="photo1" type="file" name="photo_2" accept="image/jpeg" style="float:left; clear:left;">
<input type="file" name="photo_3" accept="image/jpeg" style="float:left; clear:left;">
<input type="file" name="photo_4" accept="image/jpeg" style="float:left; clear:left;">
<input type="submit" name="sub" onclick="javascript:cs()" value="go">
</form>
</body>
</html>