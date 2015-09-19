 <?php 
@include_once("./../config.inc.php");
@include_once("./../functions.inc.php");
@include_once("./../utilities/check_reg.php");
header("Content-Type: text/html; charset=utf-8"); 

$link_old = mysqli_connect($DBSERVER, $DBUSER, $DBPASS,'macilove') or die("Can't connect");
$link_new = mysqli_connect($DBSERVER, $DBUSER, $DBPASS,'Macilove') or die("Can't connect");

mysqli_set_charset($link_new, "utf8");	

date_default_timezone_set('Europe/Moscow');


$url = mysql_escape_string(trim($_GET['url']));

if(empty($url))
header("Location: ../");


	$newArticle = false;
	
	$user = $_COOKIE['user'];
	checkUser($user);

	if(isset($_COOKIE['admmacilove']) AND $_COOKIE['admmacilove'] == 111111){
		$edit = '<a href="http://macilove.com/editor/'.$url.'/" id="screwdriver"></a>';
		$admin = true;
	}

	
	$content_old_bd_query = mysqli_query($link_old,"SELECT `id`, `categories`, `title`, `body`, UNIX_TIMESTAMP(`pub_date`), `cut`, `draft`,`description`,`source` FROM `content` WHERE `url`='".$url."'");
	
	
	$content_num_old = mysqli_num_rows($content_old_bd_query);
	
	if(isset($content_num_old) && $content_num_old != 0){
		
		
		
		$content = mysqli_fetch_array($content_old_bd_query, MYSQLI_ASSOC);
	
		mysqli_free_result($content_old_bd_query);
		$body = stripslashes($content['body']);
		
		$title = $content['title'];

		$id = $content['id'];
		$version = 0;
		
		
		$originalImage = 'http://macilove.com/images/'.$url.'.jpg';
		
		$cut = $content['cut'];
	}
	else{
			
			
		$content_query = mysqli_query($link_new,"SELECT `id`,`title`,`categories`,`body`,UNIX_TIMESTAMP(`pub_date`),`description`,`source`,`draft` FROM `articles` WHERE `url`='".$url."'");
		
		$content_num = mysqli_num_rows($content_query);
	
		if(!$content_num)
		{
			mysqli_free_result($content_query);
			header("Location: ../../404/");		
		}
	
		$content = mysqli_fetch_array($content_query, MYSQLI_ASSOC);
	
		mysqli_free_result($content_query);
		
		$newArticle = true;
		
		
	
		$title = $content['title'];
		$body = $content['body'];
		
		$id = $content['id'];
	
		$version = 1;
		
		$originalImage = 'http://macilove.com/img/original/'.$url.'.jpg';
		
		$cut = $content['description'];
	
	
	/* Article decoding */
			

	
		// link
		preg_match_all('/((?<!@)\[(.+?)\]\[([0-9]+)\])/u', $body, $inBodyLinks);
		
			
		for($n=0;!empty($inBodyLinks[2][$n]);$n++)
		{
	
			preg_match('/\['.$inBodyLinks[3][$n].'\] https?:\/\/(.+)(\R)?/', $body, $inBodyLinkURLs);
			
				
			if(parse_url('http://'.trim($inBodyLinkURLs[1]), PHP_URL_HOST) != 'madrobots.ru')
				$body = str_replace($inBodyLinks[0][$n], '<a href="http://'.trim($inBodyLinkURLs[1]).'">'.$inBodyLinks[2][$n].'</a>', $body);
			else
				$body = str_replace($inBodyLinks[0][$n], '<a href="http://'.trim($inBodyLinkURLs[1]).'" onClick="_gaq.push([\'_trackEvent\', \'Madrobots\', \'click\', \''.$title.'\']);">'.$inBodyLinks[2][$n].'</a>', $body);
				
				
			//$body = preg_replace('/([^@]\[(.+?)\]\[([0-9]+)\])/',' <a href="http://'.$inBodyLinkURLs[1].'">'.$inBodyLinks[2][$n].'</a>' , $body,1);
				
				
			$body = preg_replace('/\['.$inBodyLinks[3][$n].'\] https?:\/\/(.+)(\R)?/', '', $body,1);
			
		}
		$body = trim($body);
		
		
	//	preg_match('/^((.+)\R){1}/', $body,$test);
		
	//	print_r($test);
		
//	/(?:(\r|\r?\n){2})/	

		
		
		$body = preg_replace('/^((.+)\R){1}/', '<p>$1', $body);
		$body = preg_replace('/(\r?\n){2,}/', '</p><p>', $body);
		
		
		$body = preg_replace('/<p>###(.+?)<\/p>/', '<h3>$1</h3>', $body);
		
		$body = preg_replace('/<p>##(.+?)<\/p>/', '<h2>$1</h2>', $body);
		
		$body = preg_replace('/\*\*(.+?)\*\*/', '<strong>$1</strong>', $body);
		
		
		$body = preg_replace_callback('/<p>\[(ul|ol)\]((\r\n|\n|\r)?)(.+)\[\/(ul|ol)\]<\/p>/s', create_function('$matches', '$matches[4] = preg_replace("/(.+)/","<li>$1</li>",$matches[4]);
		$matches[4] = preg_replace("/(\r\n|\n|\r)/","",$matches[4]);
		return "<".$matches[1].">".$matches[4]."</".$matches[1].">";'), $body);
	
	
		$body = preg_replace('/\*\*(.+?)\*\*/', '<strong>$1</strong>', $body);
		
		
		$body = preg_replace('/<p>\[Q\](\r?\n|\r|\n)(.+)(\r?\n|\r|\n)\[\/Q\]<\/p>/', '<p class="quote">$2</p>',$body);
		
		$body = preg_replace('/<p>\[code\](.+)\[\/code\]<\/p>/', '<p class="code">$1</p>',$body);

		
// IMG
		preg_match_all('/@\[([0-9]+)\]\[([0-9]+)\]\[(.*?)\]/', $body, $inBodyImage);

		//there is some imgs
		if($inBodyImage[2])
		{
			$inBodyImageIndexes = $inBodyImage[2];
		
			
			for($n=0;!empty($inBodyImageIndexes[$n]);$n++)
			{	
				
				$index = $inBodyImageIndexes[$n];
				
				
				$imageURLWithoutFileType = './../img/articles/'.$url.'-'.$index;
								
				if(file_exists($imageURLWithoutFileType.'.jpg'))
				{
					
					
					if(!empty($inBodyImage[3][$n]))
						$imageReplace = '<div class="article-img"><img class="lazy" data-original="'."./.".$imageURLWithoutFileType.'.jpg"><p>'.$inBodyImage[3][$n].'</p></div>';
					else
						$imageReplace = '<img class="lazy" data-original="'."./.".$imageURLWithoutFileType.'.jpg">';
					
				}
				else if(file_exists($imageURLWithoutFileType.'.gif'))
				{
					
					if(!empty($inBodyImage[3][$n]))
						$imageReplace = '<div class="article-img"><img class="lazy" data-original="'."./.".$imageURLWithoutFileType.'.gif"><p>'.$inBodyImage[3][$n].'</p></div>';
					else
						$imageReplace = '<img class="lazy" data-original="'."./.".$imageURLWithoutFileType.'.gif">';
				}
				
				
				
			
				//$body = str_replace('<p>'.$inBodyImage[0][$n].'</p>', $imageReplace, $body);
				

					$body = preg_replace('/<p>@\[([0-9]+)\]\[([0-9]+)\]\[(.*?)\](<\/p>)?/', $imageReplace, $body,1);


						
			
			}
			
		}
 
		$body = preg_replace('/(?<!<p>[ *])(\r?\n|\r|\n){1,}/', '<br />', $body);
		
		
		

	
		
		
/////////////////////////		
		
//		$body = preg_replace('/<p>[ *]<br \/>/', '', $body);		
		//remove extra p
		/* $body = preg_replace('/(<p>)((\s|&nbsp;|<\/?\s?br\s?\/?>)*)<\/p>/', '', $body); */
		
		
		
		

		
/*	
		$body = preg_replace('/[^\:]###(.+)/', '</p><h3>$1</h3><p>', $body);
		$body = preg_replace('/[^\:]##(.+)/', '</p><h2>$1</h2><p>', $body);
		$body = preg_replace('/[^\:]#(.+)/', '</p><h1>$1</h1><p>', $body);
		
		
		//list
		
		$body = preg_replace_callback('/\[(ul|ol)\]((\r\n|\n|\r)?)(.+)\[\/(ul|ol)\]/s', create_function('$matches', '$matches[4] = preg_replace("/(.+)/","<li>$1</li>",$matches[4]);
		$matches[4] = preg_replace("/(\r\n|\n|\r)/","",$matches[4]);
		return "</p><".$matches[1].">".$matches[4]."</".$matches[1]."><p>";'), $body);
		
		
		
				
		$body = preg_replace('/^((.+)\R){1}/', '<p>$1', $body);
		

		
		// IMG
		preg_match_all('/@\[(.+)\]\[(.+)\]\[(.*)\]/', $body, $inBodyImage);
			
		//there is some imgs
		if($inBodyImage[2])
		{
			$inBodyImageIndexes = $inBodyImage[2];
		
		
		
			for($n=0;!empty($inBodyImageIndexes[$n]);$n++)
			{	
				$index = $inBodyImageIndexes[$n];
				
				//$imageURLWithoutFileType = './images/'.$url.'-'.$index;
				$imageURLWithoutFileType = './../img/articles/'.$url.'-'.$index;
				 
				
			//	echo $imageURLWithoutFileType.'.jpg';
			//	echo '<img src="'.$imageURLWithoutFileType.'.jpg">';
			//	echo "<br />";
			//	echo $index;
			//	echo $inBodyImage[0][$n];
				 
								
				//echo $inBodyImage[0][$n];
				
				if(file_exists($imageURLWithoutFileType.'.jpg'))
				{
					$body = preg_replace('/@\[(.+)\]\[(.+)\]\[(.*)\]/', '</p><img src="'.$imageURLWithoutFileType.'.jpg">', $body,1);
				}
				else if(file_exists($imageURLWithoutFileType.'.gif'))
				{
					$body = preg_replace($inBodyImage[0][$n], '</p><img src="'.$imageURLWithoutFileType.'.gif">', $body,1);
	
				}
				
			}
			
		}
	
				
		
		// link
		preg_match_all('/([^@]\[(.+?)\]\[([0-9]+)\])/', $body, $inBodyLinks);
		
		for($n=0;!empty($inBodyLinks[2][$n]);$n++)
		{
	
			preg_match('/\['.$inBodyLinks[3][$n].'\] http:\/\/(.+)(\R)?/', $body, $inBodyLinkURLs);
		
			$body = preg_replace('/([^@]\[(.+?)\]\[([0-9]+)\])/', ' <a href="http://'.$inBodyLinkURLs[1].'">'.$inBodyLinks[2][$n].'</a>', $body,1);
				
				
			$body = preg_replace('/\['.$inBodyLinks[3][$n].'\] http:\/\/(.+)(\R)?/', '', $body,1);
				
		}
	
		//bold-strong
		
	*/
	//	$body = preg_replace('/\*\*(.+?)\*\*/', '<strong>$1</strong>', $body);
	/*	
		//2 новых строки
		$body = preg_replace('/(.+)[\n]{2,}/', '$1</p><p>', $body);
	
		
	
		//1 новая строка
		$body = preg_replace('/(.+)\n^(<\/p>)/', '$1<br \/>', $body);	
	
	
		//remove extra p
		$body = preg_replace('/<p>((\s|&nbsp;|<\/?\s?br\s?\/?>)*)<\/p>/', '', $body);
		
		
		$body = preg_replace('/<p[^>]*><\\/p[^>]*>/', '', $body);

	
	
*/		
	}


	
	
		
	$category = $content['categories'];
	
	switch($category){
			case 0:
			$active[0] = 'id="active"';
			$name_cat = "Новости Apple";
			$cat_url = "http://macilove.com/news/apple-news/";
			break;
			case 13:
			$active[0] = 'id="active"';
			$name_cat = "Обзор аксессуаров";
			$cat_url = "http://macilove.com/news/apple-accessories-reviews/";
			break;
			case 1:
			$active[1] = 'id="active"';
			$name_cat = "Игры для iPhone";			
			$cat_url = "http://macilove.com/news/games-for-iphone/";
			break;
			case 2:
			$active[1] = 'id="active"';
			$name_cat = "Игры для iPad";			
			$cat_url = "http://macilove.com/news/games-for-ipad/";
			break;
			case 3:
			$active[1] = 'id="active"';
			$name_cat = "Игры для iPhone и iPad";
			$cat_url = "http://macilove.com/news/games-for-ios/";
			break;
			case 4:
			$active[2] = 'id="active"';
			$name_cat = "Приложения для iPhone";			
			$cat_url = "http://macilove.com/news/apps-for-iphone/";
			break;
			case 5:
			$active[2] = 'id="active"';
			$name_cat = "Приложения для iPad";			
			$cat_url = "http://macilove.com/news/apps-for-ipad/";
			break;
			case 6:
			$active[2] = 'id="active"';
			$name_cat = "Приложения для iPhone и iPad";			
			$cat_url = "http://macilove.com/news/apps-for-ios/";
			break;
			case 7:
			$active[3] = 'id="active"';
			$name_cat = "Приложения для Mac OS X";			
			$cat_url = "http://macilove.com/news/apps-for-mac-os-x/";
			break;
			case 8:
			$active[3] = 'id="active"';
			$name_cat = "Игры для Mac OS X";			
			$cat_url = "http://macilove.com/news/games-for-mac-os-x/";
			break;
			case 9:
			$active[4] = 'id="active"';
			$name_cat = "Трюки и секреты iPhone и iPad";			
			$cat_url = "http://macilove.com/news/secrets-iphone-ipad/";
			break;
			case 10:
			$active[4] = 'id="active"';
			$name_cat = "Трюки и секреты Mac OS X";			
			$cat_url = "http://macilove.com/news/secrets-mac-os-x/";
			break;
	
	}	
	//Sources
	$source = stripslashes($content['source']);
	if(!empty($source))
	{
	$exploded_sources = explode(',', $source);
	$i=0;
	
	$sources_string = '';
	
	do
	{
	$source_domain[$i] = parse_url(trim($exploded_sources[$i]));
	
	if($i>0)
	$sources_string .= ', <a href="'.trim($exploded_sources[$i]).'" rel="nofollow" target="_blank">'.$source_domain[$i]['host'].'</a>';
	else
	$sources_string = '<a href="'.trim($exploded_sources[0]).'" rel="nofollow" target="_blank">'.$source_domain[$i]['host'].'</a>';
	
	$i++;
	}
	while(!empty($exploded_sources[$i]));
	$sources = 'Источники: '.$sources_string;
		
	}



		
	
	$published = dateTimeFormatting($content['UNIX_TIMESTAMP(`pub_date`)']);

	
	$newBDArticleQuery = mysqli_query($link_new,"SELECT `title`,`categories`,UNIX_TIMESTAMP(`pub_date`),`description`,`url` FROM `articles` WHERE `draft`=1 ORDER BY `id` DESC LIMIT 0,10");
	
	$articlesNum = mysqli_num_rows($newBDArticleQuery);
	

	
	$max_readMore = 10;
	$bigArticle = 8;

			
	
	for($n=1; $readMore = mysqli_fetch_array($newBDArticleQuery, MYSQLI_ASSOC); $n++)
	{
	
		$cat = getNewsCategory($readMore['categories']);
		$imgURL = 'http://macilove.com/img/thumbnails/'.$readMore['url'].'-m.jpg';
		
		
		$bigArticle--;
		
		
		if($bigArticle==0 || $max_readMore==10 || $max_readMore == 9){
			$readMoreArticles .= '<li>
			<a href="http://macilove.com/news/'.$readMore['url'].'/" class="big">
				<img class="lazy" data-original="http://macilove.com/img/original/'.$readMore['url'].'.jpg" width="560" height="290">
				<h2>'.$readMore['title'].'</h2>
				<p>'.$readMore['description'].'
				</p>
				<div class="toolb">'.dateTimeFormatting($readMore['UNIX_TIMESTAMP(`pub_date`)']).'</div>
			</a>
			</li>';
			
			
			$bigArticle = 8;
		}
		else {
			$readMoreArticles .= '<li><div class="title"><div class="toolbar">
					<span class="type"><a href="http://macilove.com/news/'.$cat['cat_url'].'/">'.$cat['cat_title'].'</a></span>
					<span class="sep">|</span>
					<span class="date">'.dateTimeFormatting($readMore['UNIX_TIMESTAMP(`pub_date`)']).'</span>
				</div>
				<h2><a href="http://macilove.com/news/'.$readMore['url'].'/">'.$readMore['title'].'</a></h2>
				<p>'.$readMore['description'].'</p>
			</div><a href="http://macilove.com/news/'.$readMore['url'].'/"><img src="'.$imgURL.'" width="200" height="140" alt="'.$readMore['title'].'"></a>
		</li>';	
		}
		
		
		
		
		
		
		
		
		
		
		$max_readMore--;
	}
	
	mysqli_free_result($newBDArticleQuery);
	
	
	if($max_readMore!=0)
	{
		
		$oldBDArticleQuery = mysqli_query($link_old,"SELECT `title`,UNIX_TIMESTAMP(`pub_date`),`categories`,`description`,`url` FROM `content` WHERE `draft`=1 ORDER BY `id` DESC LIMIT 0,$max_readMore");
	
		for($n=1; $readMoreOld = mysqli_fetch_array($oldBDArticleQuery, MYSQLI_ASSOC); $n++)
		{
		
			$cat = getNewsCategory($readMoreOld['categories']);


			$bigArticle--;
			if($bigArticle==0 || $max_readMore==10 || $max_readMore == 9){
				$readMoreArticles .= '<li>
				<a href="http://macilove.com/news/'.$readMoreOld['url'].'/" class="big">
					<img class="lazy" data-original="http://macilove.com/images/'.$readMoreOld['url'].'.jpg">
					<h2>'.$readMoreOld['title'].'</h2>
					<p>'.$readMoreOld['description'].'
					</p>
					<div class="toolb">'.dateTimeFormatting($readMoreOld['UNIX_TIMESTAMP(`pub_date`)']).'</div>
				</a>
				</li>';
				
				
				$bigArticle = 8;
			}
			else {

					$readMoreArticles .= '<li><div class="title"><div class="toolbar">
						<span class="type"><a href="http://macilove.com/news/'.$cat['cat_url'].'/">'.$cat['cat_title'].'</a></span>
						<span class="sep">|</span>
						<span class="date">'.dateTimeFormatting($readMoreOld['UNIX_TIMESTAMP(`pub_date`)']).'</span>
					</div>
					<h2><a href="http://macilove.com/news/'.$readMoreOld['url'].'/">'.$readMoreOld['title'].'</a></h2>
					<p>'.$readMoreOld['description'].'</p>
				</div><a href="http://macilove.com/news/'.$readMoreOld['url'].'/"><img src="http://macilove.com/images/'.$readMoreOld['url'].'-m.jpg" width="200" height="140" alt="'.$readMoreOld['title'].'"></a>
			</li>';
			}
		}
		
		mysqli_free_result($oldBDArticleQuery);

	}
	

	
	
	//get right now reads
	$readNowQuery = mysqli_query($link_new, "SELECT `url`,`version`,`title` FROM `readNow` ORDER BY `id` DESC LIMIT 0,8");

	$addToReadNow = true;
	
	for($n=1; $readNowArr = mysqli_fetch_array($readNowQuery, MYSQLI_ASSOC); $n++)
	{
		
		//new 
		if($readNowArr['version']==1){
			
			$readNow .= '<li><a href="http://macilove.com/news/'.$readNowArr['url'].'/"><img src="http://macilove.com/img/thumbnails/'.$readNowArr['url'].'-s.jpg" width="150" height="100" alt="'.$readNowArr['title'].'"></a><a href="http://macilove.com/news/'.$readNowArr['url'].'/">'.$readNowArr['title'].'</a></li>';
			
				
		}
		else //old
		{
			
			$readNow .= '<li><a href="http://macilove.com/news/'.$readNowArr['url'].'/"><img src="http://macilove.com/images/'.$readNowArr['url'].'-s.jpg" width="150" height="100" alt="'.$readNowArr['title'].'"></a><a href="http://macilove.com/news/'.$readNowArr['url'].'/">'.$readNowArr['title'].'</a></li>'; 
			
		}
		
		if($n==4)
			$readNow .= '</ul><ul>';
			
					
		if($url == $readNowArr['url']){
			$addToReadNow = false;
		}
			
	
	}
	mysqli_free_result($newBDArticleQuery);





	

	if($addToReadNow && $title && $content['draft']==1){
		mysqli_query($link_new,"INSERT INTO `readNow` VALUES(NULL,'".$url."',".intval($newArticle).",'".$title."')");

		$readNowNumRowsQ = mysqli_query($link_new,"SELECT `id` FROM `readNow`");
		$readNowNumRows = mysqli_num_rows($readNowNumRowsQ);
		if($readNowNumRows > 8)
			mysqli_query($link_new,"DELETE FROM `readNow` ORDER BY `id` LIMIT 1");
	}

	$isAlreadyVisit =  mysqli_query($link_old,"SELECT `id` FROM `statistic_users` WHERE `content_id`=".$id." AND `version`=".$version." AND `user`='".$user."'");

	
	$alreadyVisit_num = mysqli_num_rows($isAlreadyVisit);
	mysqli_free_result($isAlreadyVisit);
	
	
if($alreadyVisit_num==0){


	

	mysqli_query($link_old,"INSERT INTO `statistic_users` VALUES(null,".$id.",".$version.",null,'".$user."')");
	$get_visits = mysqli_query($link_old,"SELECT `visits` FROM `statistic` WHERE `content_id`=".$id."AND `version`=".$version);
	
	$cont_visits = mysqli_fetch_array($get_visits, MYSQLI_ASSOC);

	
	$visits = $cont_visits[0] + 1;
	
	mysqli_query($link_old,"UPDATE `statistic` SET `visits`=".$visits." WHERE `content_id`=".$id." AND `version`=".$version);

	mysqli_free_result($get_visits);
}

	
//add to statistic	




	$get_visits = mysqli_query($link_old,"SELECT `visits` FROM `statistic` WHERE `content_id`=".$id." AND `version`=".$version);
	$cont_visits = mysqli_fetch_array($get_visits, MYSQLI_ASSOC);
	$visits = $cont_visits['visits'] + 1;
	mysqli_query($link_old,"UPDATE `statistic` SET `visits`=".$visits." WHERE `content_id`=".$id." AND `version`=".$version);
	
	
	
	


$words = 0;
$myText = str_replace('(\n)', ' ', $body); 
$myText = explode(' ', $myText);

for($n =0; $n< count($myText); $n++)
{
	if(strlen($myText[$n])>0)
	{	
		$words++;
	}
}
$readTime = ceil($words /120);




//Email / Facebook

if(empty($_SESSION['social']))
{
	if(rand(0,1)==1)
		$social = "<h2>Читайте нас на Facebook</h2>		
		<div id=\"fb-root\"></div>
		<script>(function(d, s, id) {
		  var js, fjs = d.getElementsByTagName(s)[0];
		  if (d.getElementById(id)) return;
		  js = d.createElement(s); js.id = id;
		  js.src = \"//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=298417946992396&version=v2.0\";
		  fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));</script><div class=\"fb-like-box\" data-href=\"https://www.facebook.com/macilovecom\" data-width=\"660\" data-colorscheme=\"light\" data-show-faces=\"true\" data-header=\"false\" data-stream=\"false\" data-show-border=\"false\"></div>";
	else
		$social = "<h2>Новости по электронной почте — это удобно!</h2>
		<p>Присоединяйтесь к более чем 1000+ фанатам, которые уже читают новости Apple, обзоры приложений для OS X и iOS, а также узнают секреты пользования техникой Apple по электронной почте.</p>
		<div id=\"subscribe\">
			<input id=\"emailUserName\" type=\"text\" placeholder=\"Ваше имя\">
			<input id=\"emailUserBox\" type=\"email\" placeholder=\"Email адрес\">
			<button id=\"emailUserSignUp\">Присоединиться сейчас</button>
			<div style=\"display: none;\" id=\"succeed\">Вы успешно подписались!</div>
		</div>";
		


}
else if($_SESSION['social']==1)
{

$social = "<h2>Читайте нас на Facebook</h2>		
		<div id=\"fb-root\"></div>
		<script>(function(d, s, id) {
		  var js, fjs = d.getElementsByTagName(s)[0];
		  if (d.getElementById(id)) return;
		  js = d.createElement(s); js.id = id;
		  js.src = \"//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=298417946992396&version=v2.0\";
		  fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));</script><div class=\"fb-like-box\" data-href=\"https://www.facebook.com/macilovecom\" data-width=\"660\" data-colorscheme=\"light\" data-show-faces=\"true\" data-header=\"false\" data-stream=\"false\" data-show-border=\"false\"></div>";

$_SESSION['social'] = 0;

}
else
{


$social = "<h2>Новости по электронной почте — это удобно!</h2>
		<p>Присоединяйтесь к более чем 1000+ фанатам, которые уже читают новости Apple, обзоры приложений для OS X и iOS, а также узнают секреты пользования техникой Apple по электронной почте.</p>
		<div id=\"subscribe\">
			<input id=\"emailUserName\" type=\"text\" placeholder=\"Ваше имя\">
			<input id=\"emailUserBox\" type=\"email\" placeholder=\"Email адрес\">
			<button id=\"emailUserSignUp\">Присоединиться сейчас</button>
			<div style=\"display: none;\" id=\"succeed\">Вы успешно подписались!</div>
		</div>";
		
$_SESSION['social'] = 1;

}



?>
<!DOCTYPE HTML>
<html lang="en">
<head prefix="og: http://ogp.me/ns#">
<link rel="stylesheet" type="text/css" href="http://macilove.com/news/style.css">
<script type="text/javascript" src="http://macilove.com/resources/jquery-2.1.0.min.js"></script>
<script src="http://macilove.com/news/jquery.lazyload.min.js" type="text/javascript"></script>
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Noto+Serif:400,700,400italic,700italic&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
<script src="http://macilove.com/resources/slideshow.js"></script>

<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<!-- <meta name="apple-itunes-app" content="app-id= 732986215"> -->
<!-- <meta name="viewport" content="width=1140"> -->
<meta name="viewport" content="width=device-width, initial-scale=1" />
<link rel="shortcut icon" href="http://macilove.com/resources/favicon.ico" />
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="http://macilove.com/resources/apple-touch-icon-114x114.png" />
<link rel="alternate" type="application/rss+xml" href="http://macilove.com/rss/" />

<script type="text/javascript">

		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', 'UA-8052564-20']);
		_gaq.push(['_trackPageview']);
		
		setTimeout("_gaq.push(['_trackEvent', '15_seconds', 'read'])", 15000);
		
		(function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		})();
  
		$(function() {
		$("img.lazy").lazyload();	
		});
  

</script>
<!-- Please call pinit.js only once per page -->
<!-- <script type="text/javascript" async defer  data-pin-color="red" data-pin-hover="true" src="//assets.pinterest.com/js/pinit.js"></script> -->


<title><?php echo $title." — ".$name_cat." — Macilove"; ?></title>
<meta property="og:title" content="<?php echo $title; ?>"/>
<meta property="og:type" content="article"/>
<meta property="og:image" content="http://macilove.com/<?php if($version==1) echo "img/original/$url.jpg"; else echo "images/$url.jpg"; ?>"/>
<meta property="og:description" content="<?php echo $content['description']; ?>" />
<meta property="og:url" content="http://macilove.com/news/<?php echo $url;?>/" />


<script type="text/javascript">
/*  console.log('<?php echo $trest; ?>'); */


$(window).load(function() {

	$(window).scroll(function(){
	if ($(this).scrollTop() > 3000) {
	$('#up-arrow').fadeIn();
	} else {
		$('#up-arrow').fadeOut();
	}
	});
	
	$('#up-arrow').click(function(){	
	$("html, body").animate({ scrollTop: 0 }, "slow");
	return false;
	});

	$('#subscribe input').keypress(function(e) {
        if(e.which == 13) {
            jQuery(this).blur();
            jQuery('#emailUserSignUp').focus().click();
        }
    });

  /* Every time the window is scrolled ... */
    $(window).scroll( function(){
    
        $('.hideme').each( function(i){
            
            var bottom_of_object = $(this).position().top + $(this).outerHeight();
            var bottom_of_window = $(window).scrollTop() + $(window).height();
           
            if( bottom_of_window > bottom_of_object ){
                
                $(this).animate({'opacity':'1'},300);
                    
            }
            
        }); 
    
    });

	$(document).ready(function(){
		
	

		$('#emailUserSignUp').click(function()
		{
		
			var name = $('#emailUserName').val();
			var box = $('#emailUserBox').val();
			if(name && box)
			{
				$.post(
				'../../news_delivery_invite.php',  
		        {'email':box,'name':name},
		        function(responseText){ 
		        	/* console.log(responseText); */
		        
					$('#emailUserName').hide();
					$('#emailUserBox').hide();
					$('#emailUserSignUp').hide();
					$('#succeed').show();
					return;
				    
				},  
		        "html");
				
			}
			
		});
	
	
	
	});
	

var showMorePage =2;
var allow_autoload = 1;
var scrolltrigger = 0.9;
	
$(window).scroll(function()
{
	
	var wintop = $(window).scrollTop(), docheight = $(document).height(), winheight = $(window).height();


	
	
	
	if(allow_autoload ==1)
	if  ((wintop/(docheight-winheight)) > scrolltrigger) 
	{
	allow_autoload = 0;
	    $('#spinner').toggle();
		$.post(
			'./../moreArticles.php',  
	        {'showMore':1,'showMorePage':showMorePage,'showMoreColumn':1},  
	        function(responseText){  
		      	
		    	$('#news-article ul').append(responseText); 
		      
				showMorePage++;
		      
	        },  
	        "html"  
	        ).done(function() {
	        allow_autoload = 1; 
		        $('.spinner').toggle();
		    });
	        
	}
});

});
</script>
<script>
    var _roost = _roost || [];
    _roost.push(['appkey','4c81eda8d1c6482b80fc49459d4c2a33']);

    !function(d,s,id){
        var js, fjs = d.getElementsByTagName(s)[0];
        if(!d.getElementById(id)){
            js=d.createElement(s); js.id=id;
            js.src='//cdn.goroost.com/js/roost.js';
            fjs.parentNode.insertBefore(js,fjs);
        }
    }(document, 'script', 'roost-js');
</script>
<style type="text/css">
#fresh-reversi-banner{
	width: 660px;
	background: hsl(58, 100%, 51%);
	border-bottom: 1px solid #ebebeb;
	display: block;
	color: #212417;
	text-decoration: none;
	font-family: "SF UI Display", "Helvetica Neue", Arial, sans-serif;
	z-index: 100;
	text-align: center;
	line-height: 140%;
	padding: 10px 0;
	box-sizing: border-box;
	margin: 0 auto;
	margin-bottom: 40px;
	margin-top: -20px;
}
#fresh-reversi-banner #grey{
	color: #999;
	display: none;
}
#revers-wrapper{
	max-width: 980px;
	text-align: left;
	display: inline-block;
}
#fresh-reversi-banner h1{
	font-size: 16px;
	line-height: 140%;
}
#fresh-reversi-banner h2{
	font-size: 14px;
	font-weight: normal;
	line-height: 140%;
}
#fresh-reversi-banner h3{
	font-size: 14px;
	color: black;
	line-height: 140%;
}
#fresh-icon{
	width: 80px;
	display: inline-block;
	vertical-align: middle;
	margin-right: 10px;
}
#fresh-title{
	display: inline-block;
	vertical-align: middle;
}

</style>
</head>
<body>

<nav>
	<div class="pin">
		<a href="http://macilove.com" id="logo"></a>
	<ul>
		<li <?php echo $active[0]; ?>><a href="http://macilove.com/news/apple-news/">Новости Apple</a></li>
		<li <?php echo $active[1]; ?>><a href="http://macilove.com/news/games-for-ios/">iOS игры</a></li>
		<li <?php echo $active[2]; ?>><a href="http://macilove.com/news/apps-for-ios/">iOS приложения</a></li>
		<li <?php echo $active[3]; ?>><a href="http://macilove.com/news/apps-and-games-for-mac-os-x/">Mac приложения</a></li>
		<li <?php echo $active[4]; ?>><a href="http://macilove.com/news/tricks-and-secrets-mac-os-x-ios/">Трюки и секреты</a></li>
	</ul>
	<ul>
		<li><a href="http://macilove.com/best-mac-os-x-apps/">Best Apps</a></li>
		<li><a href="http://macilove.com/os-x-wallpapers/">Обои</a></li>
<!-- 		<li><a href="http://macilove.com/russian-xcode-tutorials/">Xcode уроки</a></li> -->
		<li><a href="http://macilove.com/books/">Книги</a></li>
	</ul>
	<footer>
		<ul>
			<li>© 2015 Macilove.com</li>
			<li><a href="http://macilove.com/about/">О сайте</a></li>
		</ul>
	</footer>
	<div id="up-arrow"></div>
	</div>
</nav>

<article id="page">
<!--
	<a href="https://itunes.apple.com/ru/app/fresh-reversi-othello-like/id732986215?mt=8" id="fresh-reversi-banner" target="_blank" rel="nofollow" width="260" onClick="_gaq.push(['_trackEvent', 'PleeqSoftware', 'Macilove', 'Fresh Reversi - Index Page, Top']);">
	<div id="revers-wrapper">
		<img id="fresh-icon" src="http://pleeq.com/fresh-reversi/fresh-reversi-140px.png">
		
		<div id="fresh-title">
			<h1>Fresh Reversi</h1>
			<h2>iOS игра для развития логики</h2>
			<h3>Скачать в App Store <span id="grey">(119 р.)</span></h3>
		</div>
	</div>
</a>
-->
	<section id="text">
		<?php echo $edit; ?>
		<div id="new-top-candy">
<!-- Яндекс.Директ -->
<div id="yandex_ad"></div>
<script type="text/javascript">
(function(w, d, n, s, t) {
    w[n] = w[n] || [];
    w[n].push(function() {
        Ya.Direct.insertInto(113966, "yandex_ad", {
            stat_id: 13,
            ad_format: "direct",
            font_size: 0.9,
            font_family: "tahoma",
            type: "horizontal",
            limit: 1,
            title_font_size: 2,
            links_underline: false,
            site_bg_color: "FFFFFF",
            title_color: "0000CC",
            url_color: "007700",
            text_color: "000000",
            hover_color: "DD0000",
            sitelinks_color: "0000CC",
            no_sitelinks: false
        });
    });
    t = d.getElementsByTagName("script")[0];
    s = d.createElement("script");
    s.src = "//an.yandex.ru/system/context.js";
    s.type = "text/javascript";
    s.async = true;
    t.parentNode.insertBefore(s, t);
})(window, document, "yandex_context_callbacks");
</script>
		</div>
		
		<style type="text/css">
			
		</style>
		
				
		<div id="article-header">
			
			<div>
				<div id="typ"></div>
				<img src="<?php echo $originalImage; ?>" width="560" height="290" alt="<?php echo $title; ?>">
			</div>
			<h1><?php echo $title; ?></h1>
			<h2><?php echo $cut; ?></h2>
			<hr/>
			<div id="toolb">
				<span><a href="<?php echo $cat_url; ?>"><?php echo $name_cat; ?></a></span>
				<span>·</span>
				<span><?php echo $published; ?></span>
				<span>·</span>
				<span><?php echo $readTime; ?> мин. чтения</span>
			</div>
		</div>

		
		<div id="source"><?php echo $sources; ?></div>
		<?php echo $body; ?>
		
		<div id="ya-article-bottom">
		<!-- Яндекс.Директ -->
<div id="yandex_ad2"></div>
<script type="text/javascript">
(function(w, d, n, s, t) {
    w[n] = w[n] || [];
    w[n].push(function() {
        Ya.Direct.insertInto(113966, "yandex_ad2", {
            stat_id: 10,
            ad_format: "direct",
            font_size: 0.9,
            type: "horizontal",
            limit: 1,
            title_font_size: 3,
            links_underline: false,
            site_bg_color: "FFFFFF",
            title_color: "F13900",
            url_color: "5A7321",
            text_color: "333333",
            hover_color: "3C5160",
            sitelinks_color: "ED5F05",
            no_sitelinks: false
        });
    });
    t = d.getElementsByTagName("script")[0];
    s = d.createElement("script");
    s.src = "//an.yandex.ru/system/context.js";
    s.type = "text/javascript";
    s.async = true;
    t.parentNode.insertBefore(s, t);
})(window, document, "yandex_context_callbacks");
</script>	
		</div>
						
	</section>
	<section id="top-article">
		<h2>Сейчас читают</h2>
		<ul>
			<?php echo $readNow; ?>
		</ul>
<!-- 		<ul style="margin-bottom: 20px; margin-top: 0px; margin-left: -7px;"> -->
				<!-- Яндекс.Директ -->
<!--
				<div id="yandex_ad3"></div>
				<script type="text/javascript">
				(function(w, d, n, s, t) {
				    w[n] = w[n] || [];
				    w[n].push(function() {
				        Ya.Direct.insertInto(113966, "yandex_ad3", {
				            stat_id: 15,
				            ad_format: "direct",
				            font_size: 0.9,
				            font_family: "arial",
				            type: "horizontal",
				            limit: 2,
				            title_font_size: 3,
				            links_underline: false,
				            site_bg_color: "FFFFFF",
				            title_color: "000000",
				            url_color: "ED5F05",
				            text_color: "777777",
				            hover_color: "ED5F05",
				            sitelinks_color: "ED5F05",
				            no_sitelinks: false
				        });
				    });
				    t = d.getElementsByTagName("script")[0];
				    s = d.createElement("script");
				    s.src = "//an.yandex.ru/system/context.js";
				    s.type = "text/javascript";
				    s.async = true;
				    t.parentNode.insertBefore(s, t);
				})(window, document, "yandex_context_callbacks");
				</script>
			</ul>
-->
	</section>

	<section id="news-article">
		<ul>
			<?php echo $readMoreArticles; ?>
			
		</ul>
		
		<div id="spinner">
			<img src="http://macilove.com/resources/spinner.gif" width="36" height="39">
		</div>
	</section>
</article>

</body>
</html>