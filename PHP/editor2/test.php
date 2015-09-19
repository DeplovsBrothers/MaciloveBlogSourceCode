<?php 
header("Content-Type: text/html; charset=utf-8"); 

	
	if($_POST)
	{
		
		
		

		
		
	//	print_r($title);
	
	//var_dump($_POST['text']);
		
	//	echo ' TIT'.$title;
	


/*
$re = '/(.+)\n\n/'; 
$str = "first string\n\nsecond string\n\nother strings bla bla bla"; 
if (preg_match($re, $_POST['text'], $matches))
   echo $matches[1];
else
   echo "nope";
*/


		/*
//get title
		$result = preg_split('/\<br \/\>\<br \/\>/', nl2br($textAreaValue), 2);
		
		$title = $result[0];
		
		$text = $result[1];

		$result = preg_split('\<br \/\>\<br \/\>', $text, 2);
		
		$cut = $result[0];
		
		$text = $result[1];

		
		echo($title.$cut.$text);		
*/
		
	}
	
	
?>

	<form method="post" action="" name="editorForm" enctype='multipart/form-data'>
<textarea id='ta' name="text" class="expanding"></textarea>
	<input type="submit">
	</form>