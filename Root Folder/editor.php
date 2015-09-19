<?php 
@include_once("./config.inc.php");
@include_once("./twi-master/tmhOAuth.php");
@include_once("./twi-master/tmhUtilities.php");
@include_once('./make_sitemap.php');

header("Content-Type: text/html; charset=utf-8"); 

$link_old = mysqli_connect($DBSERVER, $DBUSER, $DBPASS,'macilove') or die("Can't connect");

$link = mysqli_connect($DBSERVER, $DBUSER, $DBPASS,'Macilove') or die("Can't connect");

mysqli_set_charset($link, "utf8");	


if(isset($_COOKIE['admmacilove']) AND $_COOKIE['admmacilove'] == 111111)
	setcookie('admmacilove', '111111', time() + 3600 * 24 * 30, '/'); 
else
	header("Location: ./../../");	

function resize($file_input, $file_output, $w_o) {
	switch($w_o){
		case 150:{
			$standart_width = 150;
			$standart_height = 100;
			break;
		}
		case 200:{
			$standart_width = 200;
			$standart_height = 140;
			break;	
		}
		case 260:{
			$standart_width = 260;
			$standart_height = 135;
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

////////////
	
	$imageCounter = 0;
	
	
if(!empty($_GET['url']))
{
	
	
	$url = mysql_escape_string(trim($_GET['url']));

	$update = true;
	

	$exist_content_query = mysqli_query($link,"SELECT * FROM `articles` WHERE `url`='".$url."'");
	$content_num = mysqli_num_rows($exist_content_query);
		
	
	if(!$content_num)
	{
		
		header("Location: ./../../editor_old.php?url=".$url);	
		
	}

	$content = mysqli_fetch_array($exist_content_query, MYSQLI_ASSOC);

	mysqli_free_result($exist_content_query);
	
	
	$title = $content['title'];
	$body = $content['body'];
	$description = $content['description'];
	$source = $content['source'];
	
	$id = $content['id'];
	
	$categories = $content['categories'];
	

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


	$textAreaContent = $title."\n\n".$description."\n\n".$body;
	
	
	
	//change numberOfImages
	//change preview to function that can be run

	//0-9
	preg_match_all('/@\[(.+)\]\[(.+)\]\[(.*)\]/', $body, $inBodyImage);

	//new image indexes
	$inBodyImageIndexes = $inBodyImage[2];
	
	
	
	while($imageCounter <= intval($inBodyImageIndexes[$imageCounter]))
	{
		
		//if($uploadedImagesSrc)
		//{
			$uploadedImagesSrc .= ', ';
			$uploadedImageIndex .= ',';
		//}
		
		
		//echo $imageCounter;
		if(is_file('./img/articles/'.$url.'-'.$inBodyImageIndexes[$imageCounter].'.jpg'))
		{
	//		echo $inBodyImageIndexes[$imageCounter];
		
			$uploadedImageIndex .= $inBodyImageIndexes[$imageCounter];
			$uploadedImagesSrc .= "'img/articles/".$url."-".$inBodyImageIndexes[$imageCounter].".jpg'";
		}
		else if(is_file($prefix.'./img/articles/'.$url.'-'.$inBodyImageIndexes[$imageCounter].'.gif'))
		{
			$uploadedImageIndex .= $inBodyImageIndexes[$imageCounter];
			$uploadedImagesSrc .= "'img/articles/".$url."-".$inBodyImageIndexes[$imageCounter].".gif'";
		}
		$imageCounter++;
	

	}


	
	

}
else
$update = false;
	
//$nameHash = md5(mktime());	




if(!empty($_POST['publish']) && $update){
			
	$publish_q = mysqli_query($link,"UPDATE `articles` SET `draft`=1 WHERE id=".$id."");
	
	
	
	$message = mysql_real_escape_string($title);
	$data = '{"alert": "'.$message.'", "url" : "http://macilove.com/news/'.$url.'"}';



	$ch = curl_init();
	
	curl_setopt($ch, CURLOPT_URL,"https://go.goroost.com/api/push");
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_USERPWD, "path");
	curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_exec($ch);
	curl_close ($ch);

	$tmhOAuth = new tmhOAuth(array(
	  'consumer_key' => 'key',
	  'consumer_secret' => 'secret',
	  'user_token' => 'token',
	  'user_secret' => 'secret',
	));
	
	
	
	$response = $tmhOAuth->request('POST', $tmhOAuth->url('1.1/statuses/update'), array(
	  'status' => $title.' http://macilove.com/news/'.$url
	));
	
	
	$_SESSION['make_sitemap'] = true;
	call_user_func(make_sitemap());
	
	$loc = "http://macilove.com/editor/$url/";
	header("Location: $loc");
}
else if($_POST)
{
	
	if(!$update)
	{
			
		$body = trim($_POST['text']); 
					
		//title
		preg_match('/(.+)\R/', $body, $title);
	
		$title = trim($title[0]);
		
		//echo $title;
		
		$body = trim(preg_replace('/^((.+)\R){1}/', '', $body));
		
		
		//description
		preg_match('/(.+)/', $body, $description);
		
		$description = trim($description[0]);
		
		//echo $cut."<br />";
		
		$body = trim(preg_replace('/^((.+)\R){1}/', '', $body));
	
		preg_match('/^((.+)\R){1}/', $body, $cut);
		$cut = trim($cut[0]);
		
	
	
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
		$url = str_replace("--",'-',$url);
		$url = str_replace("---",'-',$url);
		
		$source = trim($_POST['source']);
		$keywords = trim($_POST['keywords']);
		$categories = trim($_POST['categories']);
			
*/




	
$insertToBase = mysqli_query($link,"INSERT INTO `articles` VALUES(NULL, ".$categories." , '".mysqli_real_escape_string($link,$title)."' , '".mysqli_real_escape_string($link,$body)."' ,NULL, '".$url."' ,0, '".mysqli_real_escape_string($link,$description)."' , '".$source."','".mysqli_real_escape_string($link,$cut)."')");
	
$id = mysqli_insert_id($link);


$add_to_statistic = mysqli_query($link_old,"INSERT INTO `statistic` VALUES(null,".$id.",0,0,1)");

	
mysqli_free_result($insertToBase);
		//parse body for images
		
		
		if($insertToBase){
		
			if(!empty($_FILES['mainImage']))
			{
	
				//Get the file information
				$mainUserfile_tmp = $_FILES['mainImage']['tmp_name'];
				$mainFilename = basename($_FILES['mainImage']['name']);
				
				$mainFile_ext = strtolower(substr($mainFilename, strrpos($mainFilename, '.') + 1));
			
			
				$mainFile = 'img/original/'.$url.'.'.$mainFile_ext; 
				$mainFile_l = 'img/thumbnails/'.$url.'-l.'.$mainFile_ext;			
				$mainFile_m = 'img/thumbnails/'.$url.'-m.'.$mainFile_ext;
				$mainFile_s = 'img/thumbnails/'.$url.'-s.'.$mainFile_ext;			
				
				//отдельная -l
				
				
				if(move_uploaded_file($mainUserfile_tmp, './'.$mainFile))
				{ 
					chmod('./'.$mainFile, 0777);
					
					resize('./'.$mainFile, './'.$mainFile_l, 260);
					resize('./'.$mainFile, './'.$mainFile_m, 200);
					resize('./'.$mainFile, './'.$mainFile_s, 150);			
				}
				
				
	
			
			}
			
			
			// show images in body
			//0-9
			preg_match_all('/@\[(.+)\]\[(.+)\]\[(.*)\]/', $body, $inBodyImage);
			
			//new image indexes
			$inBodyImageIndexes = $inBodyImage[2];
			//print_r($inBodyImageIndexes);
			$n=1;
			while(!empty($inBodyImageIndexes[$n-1]))
			{
				//echo $n;
				if(is_file('./editor2/temp_images/file'.$n.'.jpg'))
					rename('./editor2/temp_images/file'.$n.'.jpg', './img/articles/'.$url.'-'.$n.'.jpg');
				else if(is_file('./editor2/temp_images/file'.$n.'.gif'))
					rename('./editor2/temp_images/file'.$n.'.gif', './img/articles/'.$url.'-'.$n.'.gif');
				$n++;
			}
			//print_r($inBodyImage);
			
			array_map('unlink', glob("./editor2/temp_images/*"));
	
		
		
		}
	}
	else
	{
		
		
		$body = trim($_POST['text']); 
					
		//title
		preg_match('/(.+)\R/', $body, $title);
	
		$title = trim($title[0]);
				
		$body = trim(preg_replace('/^((.+)\R){1}/', '', $body));

		//description
		preg_match('/(.+)/', $body, $description);
		
		$description = trim($description[0]);
		
		$body = trim(preg_replace('/^((.+)\R){1}/', '', $body));
		
		$source = trim($_POST['source']);
		$keywords = trim($_POST['keywords']);
		
		$categories = trim($_POST['categories']);
		
		preg_match('/^((.+)\R){1}/', $body, $cut);
		$cut = trim($cut[0]);
		
				
				
		if(!empty($_FILES['mainImage']))
		{
			echo 1;
			//Get the file information
			$mainUserfile_tmp = $_FILES['mainImage']['tmp_name'];
			$mainFilename = basename($_FILES['mainImage']['name']);
			
			$mainFile_ext = strtolower(substr($mainFilename, strrpos($mainFilename, '.') + 1));
		
		
			$mainFile = 'img/original/'.$url.'.'.$mainFile_ext; 
			$mainFile_l = 'img/thumbnails/'.$url.'-l.'.$mainFile_ext;			
			$mainFile_m = 'img/thumbnails/'.$url.'-m.'.$mainFile_ext;
			$mainFile_s = 'img/thumbnails/'.$url.'-s.'.$mainFile_ext;			
			
			//отдельная -l
			
			
			if(move_uploaded_file($mainUserfile_tmp, './'.$mainFile))
			{ 
				echo 2;
				chmod('./'.$mainFile, 0777);
				
				resize('./'.$mainFile, './'.$mainFile_m, 260);
				resize('./'.$mainFile, './'.$mainFile_l, 200);
				resize('./'.$mainFile, './'.$mainFile_s, 150);			
			}
			
			

		
		}
		
		//TEST DELETE
		
		$previousVersionOfBodyQuery = mysqli_query($link,"SELECT `body` FROM `articles` WHERE `id`=".$id."");

		$previousVersionOfBody = mysqli_fetch_array($previousVersionOfBodyQuery, MYSQLI_ASSOC);
		mysqli_free_result($previousVersionOfBodyQuery);
		
		mysqli_query($link, "UPDATE `articles` SET `categories`=".$categories.", `title`='".mysqli_real_escape_string($link,$title)."', `body`='".mysqli_real_escape_string($link,$body)."', `description`='".mysqli_real_escape_string($link,$description)."',`source`='".$source."',`cut`='".mysqli_real_escape_string($link,$cut)."' WHERE `id`=".$id);


		$previousVersionOfBody = $previousVersionOfBody['body']; 
	
		preg_match_all('/@\[(.+)\]\[(.+)\]\[(.*)\]/', $previousVersionOfBody, $inPreviousVersionBodyImage);
		
		$inPreviousVersionBodyImage = $inPreviousVersionBodyImage[2];
		
		
		// show images in body
		//0-9
		preg_match_all('/@\[(.+)\]\[(.+)\]\[(.*)\]/', $body, $inBodyImage);
		
		//new image indexes
		$inBodyImageIndexes = $inBodyImage[2];
		

		$checkForDeletedImages = array_diff($inPreviousVersionBodyImage,$inBodyImageIndexes);
		
		
		if($checkForDeletedImages)
		{
			$delIndex = 0;
			while($delIndex < count($checkForDeletedImages))
			{	
//				echo $delIndex;
				if(is_file('./img/articles/'.$url.'-'.$checkForDeletedImages[$delIndex].'.jpg'))
					unlink('./img/articles/'.$url.'-'.$checkForDeletedImages[$delIndex].'.jpg');
				else if(is_file('./img/articles/'.$url.'-'.$checkForDeletedImages[$delIndex].'.gif'))
					unlink('./img/articles/'.$url.'-'.$checkForDeletedImages[$delIndex].'.gif');
				
				$delIndex++;
			}
		}
		
				
		//print_r($inBodyImageIndexes);
		$n=0;
		while($n < count($inBodyImageIndexes))
		{
		
			
			if(is_file('./editor2/temp_images/file'.$inBodyImageIndexes[$n].'.jpg'))
			{	
				rename($prefix.'./editor2/temp_images/file'.$inBodyImageIndexes[$n].'.jpg', $prefix.'./img/articles/'.$url.'-'.$inBodyImageIndexes[$n].'.jpg');
			}		
			else if(is_file('./editor2/temp_images/file'.$inBodyImageIndexes[$n].'.gif'))
				rename('./editor2/temp_images/file'.$inBodyImageIndexes[$n].'.gif', './img/articles/'.$url.'-'.$inBodyImageIndexes[$n].'.gif');
			$n++;
		}
		
		array_map('unlink', glob("./editor2/temp_images/*"));
		
		
	}



	if($_POST['editors'] && !$alreadyEditorChoice){
				
		mysqli_query($link_old, "INSERT INTO `editors_choice` VALUES(null, ".$id.",1)");

		
	}


	$loc = "http://macilove.com/editor/$url/";
	header("Location: $loc");

}
else
{
array_map('unlink', glob("./editor2/temp_images/*"));
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Editor v2</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<script src="http://macilove.com/resources/jquery-1.9.1.min.js"></script>
<style type="text/css">
body{
	position: relative;
}

#chars{
	font-family: arial;
	font-size: 12px;
}

.prew-h1 {
	font-size: 26px;
	line-height: normal;
}

.prew-descr{
	color: #799a2d;
	line-height: normal;
	font-size: 13px;
}


#preview, textarea{
	display: inline-block;
	margin: 0;
	vertical-align: top;
}

textarea{
	vertical-align: top;
	height: 100%;
	min-height: 400px;
	font-family: arial;
	font-size: 13px;
	-webkit-box-sizing: border-box;
	padding: 10px;
	width: 98%;
	margin-top: 10px;
}

textarea:focus{
	outline: 0; 
	outline-offset: 0; 
	box-shadow: 0px 0px 3px 2px #cfe8ff;
	border: 1px solid #58a3e9;
}

#preview iframe{
	display: block;
	margin: 0 auto;
}

#preview img{
	max-width: 100%;
	display: block;
	margin: 0 auto;
}

#preview{
	width: 50%;
	display: inline-table;
	vertical-align: top;
	border: none;
	box-sizing: border-box;
	min-height: 100%;
	padding: 0 20px;
	border-left: 1px solid #f1f1f1;
	border-right: 1px solid #f1f1f1;
	font-family: Helvetica Neue,Helvetica,Arial,sans-serif;
	color: #333;
	font-size: 15px;
	line-height: 150%;
	margin-top: 10px;
	box-sizing: border-box;
}

#editor-left{
	display: inline-block;
	vertical-align: top;
	width: 50%;
}

#preview .quote{
	border-left: 2px solid #bebebe;
	padding-left: 10px;
	color: #999;
}

#preview .quote:before{
	content: "'";
}

#preview p{
	margin-top: 0;
	margin-bottom: 15px;
	line-height: normal;
}

#toolbar{
	display: block;
}

#autosave_indicator{
	position: absolute;
	right: -3px;
	top: 10px;
	font-size: 28px;
	line-height: 0;
	pointer-events: none;
}

#top-toolbar{
}

#bottom-toolbar{
	margin: 20px 0;
}

</style>
<script type="text/javascript">
	
$(document).ready(function(){
	
 		
		
	var selectData;
	var numberOfLinks = 1;
	var numberOfImages = <?php echo $imageCounter; ?>;
	
	var imagesSources = new Array();
	var autosaveCallWithInterval = window.setInterval(autosave, 15000); // autosave every 30 seconds
	
	var uploadedImages =[0];
	var	uploadedImagesIndexes = [0];
		
	if('<?php echo $update; ?>')
	{	
		uploadedImages =[0<?php echo $uploadedImagesSrc; ?>];
		uploadedImagesIndexes = [0<?php echo $uploadedImageIndex; ?>];

		previewContent();
		setCursor(document.getElementById('ta').value.length);
	}
	
	{
	//autosave text to file
	function autosave(){
		$('#autosave_indicator').css('color','#05A7F7');

		$.post('./../../editor2/autosave_handler.php',
		{ content: $('textarea').val()},
		function(){
			setTimeout(function(){
				$('#autosave_indicator').css('color','#EDEDED');
			},1000);
			
		});
	
	}
	
	
 	$('textarea').select(function(e){
		selectData = new Array();
		selectData.start = e.target.selectionStart;
		selectData.end = e.target.selectionEnd;
		selectData.text =	window.getSelection().toString();
		selectData.contentLength = $('textarea').length;
    });	

    
    
  	
	
	//inser URL
	$('#url').click(function(){				
			
		var url;
		url = prompt('url: ', '');
		
		if (url=='')
			return;	

			
		markupButtonsAction('url',url);			
	
		numberOfLinks++;
		
	});
	
	// H3, H2, H1 tags
	$('#h3_tag').click(function(){
		
		markupButtonsAction('h',3);
		
	});
	$('#h2_tag').click(function(){
		
		markupButtonsAction('h',2);
		
	});
	$('#h1_tag').click(function(){
		
		markupButtonsAction('h',1);
		
	});


	//bold b
	$('#bold').click(function(){
		markupButtonsAction('bold');
		
	});

	$('#ul_tag').click(function(){

		markupButtonsAction('list','ul');
		
	});

	$('#ol_tag').click(function(){
		markupButtonsAction('list','ol');
		
	});	
		
		
	$('#code').click(function(){
		markupButtonsAction('code');
	});	
	
	
	$('#slide').click(function(){
		markupButtonsAction('slideshow');
	});
	
	$('#quote').click(function(){
		markupButtonsAction('quote');
	});
	}
	
		
	// обрамлять тегами слово где бы оно не находилось	
	function markupButtonsAction(tag,value) // local function for markup buttons
	{
		var text = $('textarea').val();
		var cursor;
		var endOfText;
		
		
		if(tag=='img')
		{
			var cursorPosition = $('textarea').prop("selectionStart");
						
			endOfText = text.substr(cursorPosition, text.length);
		
			text = text.substr(0, cursorPosition) + '\n@[1]['+value+'][]'+ endOfText;
			
			cursor = text.length - endOfText.length - 1;
		
		}
		else if(selectData) // if text is selected
		{	
			endOfText = text.substr(selectData.end, text.length);
			
			if(tag=='url')
			{
				stringWithTag = '['+selectData.text+']['+numberOfLinks+']';
				
				
				text = text.substr(0,selectData.start)+stringWithTag + endOfText;	
				
				cursor = text.length - endOfText.length;

		
				text = text+'\n\n ['+numberOfLinks+'] '+value;
				
				
				
			}
			else if(tag=='h')
			{
				var h='';
				for(i=1;i<=value;i++){
					h = h+'#';
				}
				
				stringWithTag = h+selectData.text;

				text = text.substr(0,selectData.start)+stringWithTag + endOfText;
				cursor = text.length - endOfText.length;	
				
			}
			else if(tag=='bold')
			{
				stringWithTag = '**'+selectData.text+'**';	
				text = text.substr(0,selectData.start)+stringWithTag + endOfText;
				cursor = text.length - endOfText.length;	

			}
			else if(tag=='list')
			{
				
				stringWithTag = '['+value+']\n'+selectData.text+'\n[/'+value+']';	
				text = text.substr(0,selectData.start)+stringWithTag + endOfText;
				cursor = text.length - endOfText.length;	
				
			}
			else if(tag=='code')
			{
				stringWithTag = '[code]'+selectData.text+'\n[/code]';	
				text = text.substr(0,selectData.start)+stringWithTag + endOfText;
				cursor = text.length - endOfText.length;
			}
			else if(tag=='slideshow')
			{
				
				stringWithTag = '[SS]\n'+selectData.text+'\n[/SS]';	
				text = text.substr(0,selectData.start)+stringWithTag + endOfText;
				cursor = text.length - endOfText.length;
			}
			else if(tag=='quote')
			{
				stringWithTag = '\n[Q]\n'+selectData.text+'\n[/Q]';	
				text = text.substr(0,selectData.start)+stringWithTag + endOfText;
				cursor = text.length - endOfText.length;
			}
		
			selectData = null;
		}
		else
		{
			var cursorPosition = $('textarea').prop("selectionStart");
			
			endOfText = text.substr(cursorPosition, text.length);
			
			if(tag=='url')
			{
				text = text.substr(0, cursorPosition) + '['+value+']['+numberOfLinks+']' + endOfText;
				
				cursor = text.length - endOfText.length;
				
				text = text+'\n\n ['+numberOfLinks+'] '+value;
			}
			else if(tag=='h')
			{	
				var h='';
				for(i=1;i<=value;i++){
					h = h+'#';
				}
				text = text.substr(0, cursorPosition) +h+ endOfText;
				
				cursor = text.length - endOfText.length;
				
			}
			else if(tag=='bold')
			{
				
				text = text.substr(0, cursorPosition) +'****'+ endOfText;
				cursor = text.length - endOfText.length - 2;
				
			}
			else if(tag=='list')
			{
				
				text = text.substr(0, cursorPosition) +'['+value+']'+'[/'+value+']'+ endOfText;
				cursor = text.length - endOfText.length - 5;
				
			}
			else if(tag=='code')
			{
				
				text = text.substr(0, cursorPosition) +'[code]'+'[/code]'+ endOfText;
				cursor = text.length - endOfText.length - 7;
			
			}
			else if(tag=='slideshow')
			{
				
				text = text.substr(0, cursorPosition) +'[SS]'+'[/SS]'+ endOfText;	
				
				cursor = text.length - endOfText.length - 5;
				
			}			
			else if(tag=='quote')
			{
				
				text = text.substr(0, cursorPosition) +'[Q]'+'[/Q]'+ endOfText;	
				
				cursor = text.length - endOfText.length - 4;
				
			}
			
			
		}
		$('textarea').val(text);
		$('textarea').keyup();
		setCursor(cursor);
	
	}
	
	// set cursor in the right position
	function setCursor(position)
	{
		textarea = document.getElementById('ta');
		textarea.focus();
		textarea.setSelectionRange(position,position);
	}
	

	function previewContent()
	{
		//destroy selection array if adding a text
		if(selectData && selectData.contentLength != $('textarea').length)
			selectData = null;
	
		var preview = $('textarea').val();
		
		//title
		preview = preview.replace(/(.+)\n\n/, '<span class="prew-h1">$1</span><br /><br />[cut]');
		
		//cut
		preview = preview.replace(/\[cut\](.+)\n\n/, '<span class="prew-descr">$1</span><br /><br /><p>');
		
		
		
		//h3
		preview = preview.replace(/[^\:]###(.+)/g, '</p><h3>$1</h3><p>');
		//h2
		preview = preview.replace(/[^\:]##(.+)/g, '</p><h2>$1</h2><p>');
		//h1
		preview = preview.replace(/[^\:]#(.+)/g, '</p><h1>$1</h1><p>');

		
		//list
		
		preview = preview.replace(/\[(ul|ol)\]([\s\S]+)\[\/(ul|ol)\]/g, ul_list); 


		//picture
		preview = preview.replace(/(.{3})?\@\[([0-9]+)\]\[([0-9]+)\]\[(.*?)\]/g, insertImage);
		

		
		// link
		preview = preview.replace(/([^@]\[(.+?)\]\[([0-9]+)\])/g, ' <span style="background-color:yellow"><a href="#$3">$2</a></span>');
		
		//bold-strong
		preview = preview.replace(/\*\*(.+?)\*\*/g, '<strong>$1</strong>');
		
		//code
		preview = preview.replace(/\[code\](.+)\[\/code\]/g, '</p><p style="background-color:blue;">$1</p><p>');
		
		
		//slideshow
		preview = preview.replace(/\[SS\](.+)\[\/SS\]/g, '</p><p style="background-color:purple;">$1</p><p>');
		//quotes
		preview = preview.replace(/\n\[Q\]\n(.+)\n\[\/Q\]/g, '</p><p class="quote">$1</p><p>');
		
		
		
		
		//2 new lines
		preview = preview.replace(/(.+)\n\n/g, '$1</p><p>');//'<p>' + preview.replace(/(.+)\n\n/g, '$1</p><p>') + '</p>';
		
//		preview = preview.replace(/\n/g, '<span style="color:red;">n</span>\n');
		
//		preview = preview.replace(/<p><\/p>/g, '');
		
		//1 new line
		preview = preview.replace(/(.+)\n/g, '$1<br \/> ');
		
		
		//links in preview zone down with id 
		preview = preview.replace(/<p> \[([0-9]+)\] (.+)<\/p>/g, '<p><span id="$1">[$1] $2</span></p>');
		
		$('#preview').html(preview);

		// number of symbols in textarea
		$('#chars').text('Chars: '+$('#preview').text().length);
	}

		
	$("textarea").on("change keyup keydown paste cut copy", function(e) {
			
		previewContent();

	});
	
	//insert 4th index to the image tag
	function insertImage(p1,p2,p3,p4,p5)
	{ 
	
		console.log('insert');
		var addToStart = '';
		var addToEnd = '';
		
		if(p2!= '<p>' && p2!=undefined)
		{
			addToStart = p2+'</p>';
			addToEnd = '<p>'; 
		}
		
		var	description = '';
		if(p5){
			description = '<p style="background-color:aqua">'+p5+'</p>';
		}
		
		console.log("ind "+uploadedImagesIndexes);	
				
		if('<?php echo $update; ?>' && jQuery.inArray(parseInt(p4),uploadedImagesIndexes)>-1)			
		{
			console.log(uploadedImages[uploadedImagesIndexes.indexOf(parseInt(p4))]);
			
			var source = uploadedImages[uploadedImagesIndexes.indexOf(parseInt(p4))];
			if(source)
				return addToStart+'<img src="http://macilove.com/'+source+'">' + description + addToEnd;	
			else
				return addToStart+'<img src="'+imagesSources[p4]+'">' + description + addToEnd;
		}
			
		else
		{
		
			return addToStart+'<img src="'+imagesSources[p4]+'">' + description + addToEnd;
		}
			
			
		
			
	}	
	

	

	
	
	function ul_list(p1,p2,p3)
	{	
	
		p3 = p3.replace(/(.+)/g, '<li>$1</li>');  
		p3 = p3.replace(/(\r\n|\n|\r)/gm,"");
		return '</p><'+p2+'>'+p3+'</'+p2+'><p>';
	}
	
		
		
		
/* 			Add Images To Text Area And Upload It To Handler Script 		 */

var dropzone = document.getElementById('ta');

dropzone.ondrop = function(e){
	console.log('drop');
    e.preventDefault();
    readfiles(e.dataTransfer.files);

};

function previewImg(file,imageNumber) {
   
	
    imagesSources[imageNumber] = webkitURL.createObjectURL(file);
    console.log('preview');
    
    markupButtonsAction('img',imageNumber);
    
	return;
}

function readfiles(files) {
	console.log('read');
    var formData = new FormData();	

	console.log('free index '+numberOfImages+ ' '+ uploadedImagesIndexes)
	//use free index
	
	
	while(jQuery.inArray(numberOfImages,uploadedImagesIndexes)>-1)
    {	
    	numberOfImages++;
    }
	
	uploadedImagesIndexes.push(numberOfImages);
	
	
	previewImg(files[0],numberOfImages);
	formData.append('file'+numberOfImages, files[0]);
    formData.append('img_n',numberOfImages);
    console.log('FILES: '+numberOfImages);
    
    
	


$.ajax({
        url: './../../editor2/image_insert_handler.php',
        type: 'POST',
        data: formData,
        async: true,
        success: function (data) {
           	console.log('IMG '+data);
        },
        cache: false,
        contentType: false,
        processData: false
    });
}		




$('#saveChanges').click(function(){
	
	//console.log($('#ta').val());
	document.forms["editorForm"].submit();

});





});
	



</script>
</head>
<body>
	<div id="toolbar">
		<button id="url">link</button>
		<button id="h1_tag">H1</button>
		<button id="h2_tag">H2</button>
		<button id="h3_tag">H3</button>
		<button id="bold"><b>b</b></button>
		<button id="ul_tag">ul</button>
		<button id="ol_tag">ol</button>
		<button id="code">code</button>
		<button id="slide">slideshow</button>
		<button id="quote">Quote</button>
		<span id="chars"><a href="http://webmaster.yandex.ru/site/service-plugin.xml?host=6171177&service=ORIGINALS&need_auth=false&new_site=false" target="_blank">Chars: 0</a></span>

		
	</div>
	<div id="editor-left">
		<div id="top-toolbar"><form action="" name="publishForm" method="post"><input name="publish" type="submit" value="Publish"><a href="http://macilove.com/news/<?php echo $url; ?>/">Preview</a>  <a href="http://macilove.com">Macilove</a></form><form method="post" action="" name="editorForm" enctype='multipart/form-data'>
		<br />
		Main image (560x290px): <input type="file" name="mainImage" id="mainImage"><br />
		<select name="categories" style="float:left; clear:left; font-size:12px;">
	      <option selected="selected" value="0" <?php echo $categories0; ?>>Apple Apple</option>
	      <option value="13" <?php echo $categories13; ?>>Apple accessories reviews </option>
	      <option></option>
	      <option value="3" <?php echo $categories3; ?>> Games for iOS</option>
	      <option value="1" <?php echo $categories1; ?>> Games for iPhone</option>
	      <option value="2" <?php echo $categories2; ?>> Games for iPad</option>      
	      <option></option>
	      <option value="6" <?php echo $categories6; ?>>Apps for iOS</option>
	      <option value="4" <?php echo $categories4; ?>>Apps for iPhone</option>
	      <option value="5" <?php echo $categories5; ?>>Apps for iPad</option>
	      <option></option>
	      <option value="7" <?php echo $categories7; ?>>Apps for Mac OS X</option>
	      <option value="8" <?php echo $categories8; ?>>Games for Mac OS X</option>
	      <option></option>
	      <option value="10" <?php echo $categories10; ?>>Tricks and secrets Mac OS X</option>
	      <option value="9" <?php echo $categories9; ?>>Tricks and secrets iOS</option>
	    </select><br />
		<br />
		<input type="button" name="saveChanges" id="saveChanges" value="Save">
		<br />Editors choice: <input type="checkbox" name="editors">
		</div>
		
		<textarea id='ta' name="text" class="expanding"><?php echo $textAreaContent; ?></textarea><br />
		
		<div id="bottom-toolbar"><b>URL</b><br />
		<input type="text" name="url" placeholder="url" value="<?php echo $url; ?>"><br />
		<b>Source</b><br />
		<input type="text" name="source" placeholder="source" value="<?php echo $source; ?>"><br />
<!--
		<b>Keywords</b><br />
		<input type="text" name="keywords" placeholder="keywords"></div>
-->
		
		</form>
	</div><div id="preview"></div>


	<div id="autosave_indicator" style="color:#EDEDED">・</div>
</body>
</html>

<?php
}

 ?>