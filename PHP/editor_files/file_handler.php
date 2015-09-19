<?php
@include_once("./amazon_functions.php");

 

 
if (!empty($_FILES)) {
     
    $tempFile = $_FILES['file']['tmp_name'];                        
    $targetFile = $_FILES['file']['name']; 
	
	
//	file_put_contents("./images/save.txt", 'ok'); 

	




$i = $_POST['params_num'];
$file_url = $_POST['params_url'];

$ext = pathinfo($targetFile);

$new_file_name = $file_url."-".$i.".".$ext['extension'];

$file = "./../images/".$new_file_name;



move_uploaded_file($tempFile, $file);


//$con = file_get_contents("../technical/images/save.txt");

file_put_contents("../technical/images/save.txt","ok".$file_url); 



	upload_to_s3("http://macilove.com/images/".$new_file_name,$new_file_name ,$fp,$aws_key);
	unlink($file);




	


}





?>



