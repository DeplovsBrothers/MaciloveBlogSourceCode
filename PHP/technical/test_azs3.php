<?php 
	@include_once("./amazon_functions.php");


/*
$src = './images/testCrop-l.jpg';

$name = '001.jpg';

upload_to_s3($src,$name ,$fp,$aws_key);

echo 'ok';
*/


	
	
?>
<header>
	<script type="text/javascript" src="./../editor_files/dropzone.js"></script>
</header>
<body>
	<form action="./../editor_files/file_handler.php" class="dropzone" style="width:400px; height:400px; background-color:red;">
		<input type="hidden" name="params" value="ok"/>
	</form>
	
</body>