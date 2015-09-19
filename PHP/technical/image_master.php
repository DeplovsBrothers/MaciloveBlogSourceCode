<?php 
@include_once("./../config.inc.php");
@include_once("./../functions.inc.php");
@include_once("./amazon_functions.php");
 

header("Content-Type: text/html; charset=utf-8"); 

$link = mysql_connect($DBSERVER, $DBUSER, $DBPASS)
or die("Can't connect" );
mysql_select_db($DB, $link) or die ("Can't select DB");


if(!isset($_COOKIE['admmacilove']) AND $_COOKIE['admmacilove'] != 111111){
	header("Location: http://macilove.com");
}



////////////////////////////////////////////////////////////////////////////////////////
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
//resize($file, $file_m, 200);
//resize($file, $file_s, 120);

 // get files from DB



for($k=1273; $k<1280; $k++)
{

echo $k;

$get_files_q = mysql_query("SELECT `url` FROM `content` ORDER BY `id` LIMIT $k,1");
$get_files = mysql_fetch_assoc($get_files_q);


//print_r($get_files);

$main_image_name = $get_files['url'].".jpg";

$main_image_name_s = $get_files['url']."-s.jpg"; 

$main_image_name_m = $get_files['url']."-m.jpg";

$main_image_name_l = $get_files['url']."-l.jpg";

$sources[1]['name'] = $main_image_name;
$sources[2]['name'] = $main_image_name_s;
$sources[3]['name'] = $main_image_name_m;
$sources[4]['name'] = $main_image_name_l;

$source_file = "./../images2/".$main_image_name;  // main image path

$source_file_s = "./../images2/".$main_image_name_s; // file small

$source_file_m = "./../images2/".$main_image_name_m; // file medium

$source_file_l = "./../images2/".$main_image_name_l; //file-l path after crop 

$sources[1]['path'] = $source_file;
$sources[2]['path'] = $source_file_s;
$sources[3]['path'] = $source_file_m;
$sources[4]['path'] = $source_file_l;



//if(is_file($source_file_m))
//echo $main_image_name_m." ok";






resize($source_file, $source_file_l, 270);
resize($source_file, $source_file_s, 120);

for($i=1; $i<=4; $i++){
	
	upload_to_s3($sources[$i]['path'], $sources[$i]['name'],$fp,$aws_key);
	
}	

unlink($source_file_l);


$l=0;
$trig = true;


while($trig)
{

	$body_images_path = "./../images2/".$get_files['url']."-".$l.".jpg";
	
	
	
	if(!file_exists($body_images_path))
	{ 
		$body_images_path_list = "./../images2/".$get_files['url']."-".($l+1).".jpg";
		if(!file_exists($body_images_path_list))
		{ 
			$body_images_path_list = "./../images2/".$get_files['url']."-".($l+2).".jpg";	
			if(!file_exists($body_images_path_list))
			{
				$trig = false;
			}
		}
		$l++;
		continue;
	}
	else
	{

		
		$body_image_name = $get_files['url']."-".$l.".jpg";
		
		upload_to_s3($body_images_path,$body_image_name ,$fp,$aws_key);
	}	
	
		
	

	
	$l++;

}


}




echo 'done<br />';
echo $get_files['url'];


?>