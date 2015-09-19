<?php


if($_POST && !empty($_FILES))
{
	/*
print_r($_POST);
	exit;
*/
	
	$n = $_POST['img_n'];
	
	$file_name = 'file'.$n;
	
	
	//Get the file information
	$mainUserfile_tmp = $_FILES[$file_name]['tmp_name'];
	$mainFilename = basename($_FILES[$file_name]['name']);
	
	$mainFile_ext = strtolower(substr($mainFilename, strrpos($mainFilename, '.') + 1));


	$tempFilePlace = 'temp_images/'.$file_name.'.'.$mainFile_ext; 

	
	
	move_uploaded_file($mainUserfile_tmp, './'.$tempFilePlace);
	
	
//	echo $mainFilename." ".$tempFilePlace;

}


?>