<?php 
	
function checkUser(&$user)
{

	if(empty($user)){
		$hash = md5(microtime(true));
		setcookie('user', $hash, time() + 3600 * 24 * 30 , '/');
		mysql_query("INSERT INTO `users` VALUES(null, '$hash', null)"); 
				
	}
	else{
	
		$hash = $user;
		
		setcookie('user', $hash, time() + 3600 * 24 * 30, '/');
		
		mysql_query("UPDATE `users` SET `last_visit`=null WHERE `user_hash`='".$hash."'");
	}

	$user = $hash;
	
}	



function emailSubscribe(&$emailSubscribeBox, &$emailSubscribeJS, $cookie)
{

	if(empty($cookie)) // показывать подписку по email
	{	//style="display: block;" ломает анимацию
		$emailSubscribeBox = '<div class="regular-subscribe">
	<div class="close">
	Закрыть
	</div>
		<h2>Подпишитесь на новости Macilove</h2>
		<div class="white-page">
			<div class="white-padding">
			<input type="email" id="email-subscribe-article" class="input" placeholder="Ваш email" autofocus="">
			<button type="button" class="subcrb-email-button">Подписаться</button>
			</div>
			<div class="white-padding">

			</div>
		</div>
	</div>';
		
		$emailSubscribeJS = "function submit_email() {
        	
			var email = document.getElementById('email-subscribe-article').value; 
			
			if(email == '')
			return;
			
			$.get(
    \"http://macilove.com/news_delivery_invite.php\",
    {email : email},
    function(data) {
      
			  
			
						$('.white-page').html('<div>Вы успешно подписались на рассылку Macilove</div>');
						$('.regular-subscribe').slideUp(300); 
					setCookie('reject_email_d',2,30);
				    return;
			    }
			);
}
function setCookie(c_name,value,exdays)
{
var exdate=new Date();
exdate.setDate(exdate.getDate() + exdays);
var c_value=escape(value) +  '; expires='+exdate.toUTCString()+'; Path=/;';
document.cookie=c_name + '=' + c_value;
}

$('.regular-subscribe').slideDown(700); 

$('.subcrb-email-button').click(submit_email);




$('.close').click(function() {
	setCookie('reject_email_d',1,15);
	$('.regular-subscribe').slideUp(300);
});

"; 
	
	}
	else
	{
		// соц сети
	}
	

}





function getRussianDateView($date)
{

$day = strftime( "%e", $date);
$year = strftime( "%Y" ,$date);
$month = strftime( "%b" ,$date);
$hour = strftime("%H", $date);
$minute = strftime("%M", $date);

switch($month){
	case "Jan":
	$month = "января";
	break;
	case "Feb":
	$month = "февраля";
	break;
	case "Mar":
	$month = "марта";
	break;
	case "Apr":
	$month = "апреля";
	break;
	case "May":
	$month = "мая";
	break;
	case "Jun":
	$month = "июня";
	break;
	case "Jul":
	$month = "июля";
	break;
	case "Aug":
	$month = "августа";
	break;
	case "Sep":
	$month = "сентября";
	break;
	case "Oct":
	$month = "октября";
	break;
	case "Nov":
	$month = "ноября";
	break;
	case "Dec":
	$month = "декабря";
	break;
}

$russianDate['day'] = $day;
$russianDate['month'] = $month;
$russianDate['year'] = $year;
$russianDate['hour'] = $hour;
$russianDate['minute'] = $minute;

return $russianDate;
}


function getNewsCategory($category){
	
	switch($category){
			case 0:
			$cat_name_for_badge = "apple-news";
			$title_for_badge = 'Новости Apple';
			break;
			case 13:
			$cat_name_for_badge = "apple-accessories-reviews";
			$title_for_badge = 'Обзор аксессуаров';
			break;
			
			case 1:
			$cat_name_for_badge = "games-for-iphone";
			$title_for_badge = 'Игры для iPhone';
			break;
			case 2:
			$cat_name_for_badge = "games-for-ipad";
			$title_for_badge = 'Игры для iPad';
			break;
			case 3:
			if($category==1){
			$cat_name_for_badge = "games-for-iphone";
			$title_for_badge = 'Игры для iPhone';
			}
			else if($category==2){
			$cat_name_for_badge = "games-for-ipad";
			$title_for_badge = 'Игры для iPad';}
			else
			{
			$cat_name_for_badge = "games-for-iphone";
			$title_for_badge = 'Игры для iPhone и iPad';
			}
			break;
			case 4:
			$cat_name_for_badge = "apps-for-iphone";
			$title_for_badge = 'Приложения для iPhone';
			break;
			case 5:
			$cat_name_for_badge = "apps-for-ipad";
			$title_for_badge = 'Приложения для iPad';
			break;
			case 6:
			if($category==4){
			$cat_name_for_badge = "apps-for-iphone";
			$title_for_badge = 'Приложения для iPhone';
			}
			else if($category==5)
			{
			$cat_name_for_badge = "apps-for-ipad";
			$title_for_badge = 'Приложения для iPad';}
			else
			{
			$cat_name_for_badge = "apps-for-iphone";
			$title_for_badge = 'Приложения для iPhone и iPad';			
			}
			break;
			case 7:
			$cat_name_for_badge = "apps-for-mac-os-x";
			$title_for_badge = 'Приложения для Mac OS X';
			break;
			case 8:
			$cat_name_for_badge = "games-for-mac-os-x";
			$title_for_badge = 'Игры для Mac OS X';
			break;
			case 9:
			$cat_name_for_badge = "secrets-iphone-ipad";
			$title_for_badge = 'Трюки и секреты iPhone и iPad';
			break;
			case 10:
			$cat_name_for_badge = "secrets-mac-os-x";
			$title_for_badge = 'Трюки и секреты Mac OS X';
			break;
}

$cat['cat_url'] = $cat_name_for_badge;
$cat['cat_title'] = $title_for_badge;


return $cat;
}

function dateTimeFormatting($date){		
	$day = strftime( "%e", $date);
	$year = strftime( "%g" ,$date);
	$month = strftime( "%m" ,$date);
	$hour = strftime("%H", $date);
	$minute = strftime("%M", $date);
	
	return "$day.$month.$year в $hour:$minute";
		
}


function getForumCategoryInfoByType($type)
{
	switch($type){
		case 1:
		$category['url'] = 'app-store';
		$category['name'] = 'App Store';
		$$category['icon'] = 'app-store-icon';
		break;
		case 2:
		$category['url'] = 'imac';
		$category['name'] = 'iMac';
		$category['icon'] = 'imac-icon';
		break;	
		case 3:
		$category['url'] = 'ipad';
		$category['name'] = 'iPad';
		$category['icon'] = 'ipad-icon';
		break;
		case 4:
		$category['url'] = 'iphone';
		$category['name'] = 'iPhone';
		$category['icon'] = 'iphone-icon';
		break;
		case 5:
		$category['url'] = 'ipod';
		$category['name'] = 'iPod';
		$category['icon'] = 'ipod-icon';
		break;
		case 6:
		$category['url'] = 'ios';
		$category['name'] = 'iOS';
		$category['icon'] = 'ios-icon';	
		break;
		case 7:
		$category['url'] = 'macbook';
		$category['name'] = 'MacBook';
		$category['icon'] = 'macbook-icon';
		break;
		case 8:
		$category['url'] = 'mac-mini';
		$category['name'] = 'Mac mini';
		$category['icon'] = 'mac-mini-icon';	
		break;
		case 9:
		$category['url'] = 'mac-pro';
		$category['name'] = 'Mac Pro';
		$category['icon'] = 'mac-pro-icon';
		break;
		case 10:
		$category['url'] = 'os-x';
		$category['name'] = 'OS X';
		$category['icon'] = 'os-x-icon';	
		break;
		case 11:
		$category['url'] = 'xcode';
		$category['name'] = 'Xcode';
		$category['icon'] = 'xcode-icon';	
		break;
		case 12:
		$category['url'] = 'accessories';
		$category['name'] = 'Аксессуары';
		$category['icon'] = 'accessories-icon';	
		break;
		case 13:
		$category['url'] = 'apps';
		$category['name'] = 'Приложения';
		$category['icon'] = 'applications-icon';
		break;
		case 14:
		$category['url'] = 'other';
		$category['name'] = 'Другое';
		$category['icon'] = 'other-icon';	
		break;
		
	}

	return $category;
}









/*
function adForCategoryWithIndex($category)
{
	switch($category)
	{
		case "apple-news":{
			$category = 0;
			$active[0] = 'id="active"';
			$title = "Новости Apple для настоящих фанатов";
			$category_with_selection = '<div id="articles-filter">
	<a href="http://macilove.com/news/apple-news/" id="active">Новости Apple</a>
	<a href="http://macilove.com/news/apple-accessories-reviews/">Обзор аксессуаров</a>
</div>';

			$rand = rand(1,5);
			if($rand==1)
				$candy = '<script type="text/javascript" src="http://aos-creative.prf.hn/creative/camref:11lo4J/creativeref:10l2118"></script>'; // 5s (iPad Air)

			else if($rand ==2)
				$candy = '<script type="text/javascript" src="http://aos-creative.prf.hn/creative/camref:11lo4J/creativeref:10l2126"></script>'; // macbook air

			else if($rand ==3)
				$candy = '<script type="text/javascript" src="http://aos-creative.prf.hn/creative/camref:11lo4J/creativeref:10l2686"></script>'; // iphone 5s
			else if($rand ==4)
				$candy = '<script type="text/javascript" src="http://aos-creative.prf.hn/creative/camref:11lo4J/creativeref:11l2134"></script>'; // ipad retina
			else if($rand ==5)
				$candy = '<script type="text/javascript" src="http://aos-creative.prf.hn/creative/camref:11lo4J/creativeref:11l2144"></script>'; // imac	
			else
				$candy = '<script type="text/javascript" src="http://aos-creative.prf.hn/creative/camref:11lo4J/creativeref:11l2160"></script>'; // iphone 5s
			}
			break;
			
			case "apple-accessories-reviews":{
			$category = 13;
			$active[0] = 'id="active"';
			$title = "Обзор аксессуаров";
			$category_title = '<h1 class="articles-filter-h1">'.$title.'</h1>';
			$category_with_selection = '<div id="articles-filter">
	<a href="http://macilove.com/news/apple-news/">Новости Apple</a>
	<a href="http://macilove.com/news/apple-accessories-reviews/" id="active">Обзор аксессуаров</a>
</div>';
			
			$rand = rand(1,6);
			if($rand==1)
				$candy = '<script type="text/javascript" src="http://aos-creative.prf.hn/creative/camref:11lo4J/creativeref:10l2118"></script>'; // 5s (iPad Air)
			
			else if($rand ==2)
				$candy = '<script type="text/javascript" src="http://aos-creative.prf.hn/creative/camref:11lo4J/creativeref:10l2126"></script>'; // macbook air
			 
			else if($rand ==3)
				$candy = '<script type="text/javascript" src="http://aos-creative.prf.hn/creative/camref:11lo4J/creativeref:10l2686"></script>'; // iphone 5s
			else if($rand ==4)
				$candy = '<script type="text/javascript" src="http://aos-creative.prf.hn/creative/camref:11lo4J/creativeref:11l2134"></script>'; // ipad retina
			else if($rand ==5)
				$candy = '<script type="text/javascript" src="http://aos-creative.prf.hn/creative/camref:11lo4J/creativeref:11l2144"></script>'; // imac	
			else
				$candy = '<script type="text/javascript" src="http://aos-creative.prf.hn/creative/camref:11lo4J/creativeref:11l2160"></script>'; // iphone 5s
			}
			break;
			
			case "games-for-iphone":{
			$category = 1;
			$active[1] = 'id="active"';
			$title = "Игры для iPhone";
			$category_title = '<h1 class="articles-filter-h1">'.$title.'</h1>';
			$category_with_selection = '<div id="articles-filter">
	<a href="http://macilove.com/news/games-for-iphone/" id="active">Игры для iPhone</a>
	<a href="http://macilove.com/news/games-for-ipad/">Игры для iPad</a>
</div>';

			$rand = rand(1,3);
			if($rand==1)
				$candy = '<script type="text/javascript" src="http://aos-creative.prf.hn/creative/camref:11lo4J/creativeref:10l2118"></script>'; // 5s (iPad Air)
			
			else if($rand ==2)
				$candy = '<script type="text/javascript" src="http://aos-creative.prf.hn/creative/camref:11lo4J/creativeref:10l2686"></script>'; // iphone 5s
			else
				$candy = '<script type="text/javascript" src="http://aos-creative.prf.hn/creative/camref:11lo4J/creativeref:11l2160"></script>'; // iphone 5s
			}
			break;
			case "games-for-ipad":{
			$category = 2;
			$active[1] = 'id="active"';
			$title = "Игры для iPad";
			$category_title = '<h1 class="articles-filter-h1">'.$title.'</h1>';
			$category_with_selection = '<div id="articles-filter">
	<a href="http://macilove.com/news/games-for-iphone/">Игры для iPhone</a>
	<a href="http://macilove.com/news/games-for-ipad/" id="active">Игры для iPad</a>
</div>';
			
			if(rand(1,2)==1)
				$candy = '<script type="text/javascript" src="http://aos-creative.prf.hn/creative/camref:11lo4J/creativeref:10l2118"></script>'; // 5s (iPad Air)
			else 
				$candy = '<script type="text/javascript" src="http://aos-creative.prf.hn/creative/camref:11lo4J/creativeref:11l2134"></script>'; // ipad retina
			
			}
			break;
			case "games-for-ios":{
			$category = 3;
			$active[1] = 'id="active"';
			$title = "Игры для iOS";
			$category_with_selection = '<div id="articles-filter">
	<a href="http://macilove.com/news/games-for-iphone/">Игры для iPhone</a>
	<a href="http://macilove.com/news/games-for-ipad/">Игры для iPad</a>
</div>';

			$rand = rand(1,4);
			if($rand==1)
				$candy = '<script type="text/javascript" src="http://aos-creative.prf.hn/creative/camref:11lo4J/creativeref:10l2118"></script>'; // 5s (iPad Air)
			 
			else if($rand ==2)
				$candy = '<script type="text/javascript" src="http://aos-creative.prf.hn/creative/camref:11lo4J/creativeref:10l2686"></script>'; // iphone 5s
			else if($rand ==3)
				$candy = '<script type="text/javascript" src="http://aos-creative.prf.hn/creative/camref:11lo4J/creativeref:11l2134"></script>'; // ipad retina
			else
				$candy = '<script type="text/javascript" src="http://aos-creative.prf.hn/creative/camref:11lo4J/creativeref:11l2160"></script>'; // iphone 5s
			}
			break;
			case "apps-for-iphone":{
			$category = 4;
			$active[2] = 'id="active"';
			$title = "Приложения для iPhone";
			$category_title = '<h1 class="articles-filter-h1">'.$title.'</h1>';
			$category_with_selection = '<div id="articles-filter">
	<a href="http://macilove.com/news/apps-for-iphone/" id="active">Приложения для iPhone</a>
	<a href="http://macilove.com/news/apps-for-ipad/">Приложения для iPad</a>
</div>';

			$rand = rand(1,3);
			if($rand==1)
				$candy = '<script type="text/javascript" src="http://aos-creative.prf.hn/creative/camref:11lo4J/creativeref:10l2118"></script>'; // 5s (iPad Air)
			 
			else if($rand ==2)
				$candy = '<script type="text/javascript" src="http://aos-creative.prf.hn/creative/camref:11lo4J/creativeref:10l2686"></script>'; // iphone 5s
			else
				$candy = '<script type="text/javascript" src="http://aos-creative.prf.hn/creative/camref:11lo4J/creativeref:11l2160"></script>'; // iphone 5s
			}
			break;
			case "apps-for-ipad":{
			$category = 5;
			$active[2] = 'id="active"';
			$title = "Приложения для iPad";
			$category_title = '<h1 class="articles-filter-h1">'.$title.'</h1>';
			$category_with_selection = '<div id="articles-filter">
	<a href="http://macilove.com/news/apps-for-iphone/">Приложения для iPhone</a>
	<a href="http://macilove.com/news/apps-for-ipad/" id="active">Приложения для iPad</a>
</div>';

			if(rand(1,2)==1)
				$candy = '<script type="text/javascript" src="http://aos-creative.prf.hn/creative/camref:11lo4J/creativeref:10l2118"></script>'; // 5s (iPad Air)
			else 
				$candy = '<script type="text/javascript" src="http://aos-creative.prf.hn/creative/camref:11lo4J/creativeref:11l2134"></script>'; // ipad retina
			}
			break;
			case "apps-for-ios":{
			$category = 6;
			$active[2] = 'id="active"';
			$title = "Приложения для iOS";
			$category_with_selection = '<div id="articles-filter">
	<a href="http://macilove.com/news/apps-for-iphone/">Приложения для iPhone</a>
	<a href="http://macilove.com/news/apps-for-ipad/">Приложения для iPad</a>
</div>';

			$rand = rand(1,4);
			if($rand==1)
				$candy = '<script type="text/javascript" src="http://aos-creative.prf.hn/creative/camref:11lo4J/creativeref:10l2118"></script>'; // 5s (iPad Air)
			
			else if($rand ==2)
				$candy = '<script type="text/javascript" src="http://aos-creative.prf.hn/creative/camref:11lo4J/creativeref:10l2686"></script>'; // iphone 5s
			else if($rand ==3)
				$candy = '<script type="text/javascript" src="http://aos-creative.prf.hn/creative/camref:11lo4J/creativeref:11l2134"></script>'; // ipad retina
			else
				$candy = '<script type="text/javascript" src="http://aos-creative.prf.hn/creative/camref:11lo4J/creativeref:11l2160"></script>'; // iphone 5s

			}
			break;
			case "apps-for-mac-os-x":{
			$category = 7;
			$active[3] = 'id="active"';
			$title = "Приложения для Mac OS X";
			$category_title = '<h1 class="articles-filter-h1">'.$title.'</h1>';
			$category_with_selection = '<div id="articles-filter">
	<a href="http://macilove.com/news/apps-for-mac-os-x/" id="active">Приложения для Mac OS X</a>
	<a href="http://macilove.com/news/games-for-mac-os-x/">Игры для Mac OS X</a>
</div>';
			if(rand(1,2)==1)			
				$candy = '<script type="text/javascript" src="http://aos-creative.prf.hn/creative/camref:11lo4J/creativeref:10l2126"></script>'; // macbook air
			else
				$candy = '<script type="text/javascript" src="http://aos-creative.prf.hn/creative/camref:11lo4J/creativeref:11l2144"></script>'; // imac
			}
			break;
			case "games-for-mac-os-x":{
			$category = 8;
			$active[3] = 'id="active"';
			$title = "Игры для Mac OS X";
			$category_title = '<h1 class="articles-filter-h1">'.$title.'</h1>';
			$category_with_selection = '<div id="articles-filter">
	<a href="http://macilove.com/news/apps-for-mac-os-x/">Приложения для Mac OS X</a>
	<a href="http://macilove.com/news/games-for-mac-os-x/" id="active">Игры для Mac OS X</a>
</div>';

			if(rand(1,2)==1)			
				$candy = '<script type="text/javascript" src="http://aos-creative.prf.hn/creative/camref:11lo4J/creativeref:10l2126"></script>'; // macbook air
			else
				$candy = '<script type="text/javascript" src="http://aos-creative.prf.hn/creative/camref:11lo4J/creativeref:11l2144"></script>'; // imac
			}
			
			break;
			case "apps-and-games-for-mac-os-x":{
			$category = 12;
			$active[3] = 'id="active"';
			$title = "Приложения и игры для Mac OS X";
			$category_with_selection = '<div id="articles-filter">
	<a href="http://macilove.com/news/apps-for-mac-os-x/">Приложения для Mac OS X</a>
	<a href="http://macilove.com/news/games-for-mac-os-x/">Игры для Mac OS X</a>
</div>';

			if(rand(1,2)==1)			
				$candy = '<script type="text/javascript" src="http://aos-creative.prf.hn/creative/camref:11lo4J/creativeref:10l2126"></script>'; // macbook air
			else
				$candy = '<script type="text/javascript" src="http://aos-creative.prf.hn/creative/camref:11lo4J/creativeref:11l2144"></script>'; // imac
			}
			
			break;
			case "secrets-iphone-ipad":{
			$category = 9;
			$active[4] = 'id="active"';
			$title = "Трюки и секреты iPhone и iPad";
			$category_title = '<h1 class="articles-filter-h1">'.$title.'</h1>';
			$category_with_selection = '<div id="articles-filter">
	<a href="http://macilove.com/news/secrets-mac-os-x/">Трюки и секреты Mac OS X</a>
	<a href="http://macilove.com/news/secrets-iphone-ipad/" id="active">Трюки и секреты iPhone и iPad</a>
</div>';

			$rand = rand(1,4);
			if($rand==1)
				$candy = '<script type="text/javascript" src="http://aos-creative.prf.hn/creative/camref:11lo4J/creativeref:10l2118"></script>'; // 5s (iPad Air)
			
			else if($rand ==2)
				$candy = '<script type="text/javascript" src="http://aos-creative.prf.hn/creative/camref:11lo4J/creativeref:10l2686"></script>'; // iphone 5s
			else if($rand ==3)
				$candy = '<script type="text/javascript" src="http://aos-creative.prf.hn/creative/camref:11lo4J/creativeref:11l2134"></script>'; // ipad retina
			else
				$candy = '<script type="text/javascript" src="http://aos-creative.prf.hn/creative/camref:11lo4J/creativeref:11l2160"></script>'; // iphone 5s
			}
			break;
			
			case "secrets-mac-os-x":{
			$category = 10;
			$active[4] = 'id="active"';
			$title = "Трюки и секреты Mac OS X";
			$category_title = '<h1 class="articles-filter-h1">'.$title.'</h1>';
			$category_with_selection = '<div id="articles-filter">
	<a href="http://macilove.com/news/secrets-mac-os-x/" id="active">Трюки и секреты Mac OS X</a>
	<a href="http://macilove.com/news/secrets-iphone-ipad/">Трюки и секреты iPhone и iPad</a>
</div>';

			if(rand(1,2)==1)			
				$candy = '<script type="text/javascript" src="http://aos-creative.prf.hn/creative/camref:11lo4J/creativeref:10l2126"></script>'; // macbook air
			else
				$candy = '<script type="text/javascript" src="http://aos-creative.prf.hn/creative/camref:11lo4J/creativeref:11l2144"></script>'; // imac	
			}
			break;
			case "tricks-and-secrets-mac-os-x-ios":{
			$category = 11;
			$active[4] = 'id="active"';
			$title = "Трюки и секреты Mac OS X и iOS";
			$category_with_selection = '<div id="articles-filter">
	<a href="http://macilove.com/news/secrets-mac-os-x/">Трюки и секреты Mac OS X</a>
	<a href="http://macilove.com/news/secrets-iphone-ipad/">Трюки и секреты iPhone и iPad</a>
</div>';

			$rand = rand(1,6);
			if($rand==1)
				$candy = '<script type="text/javascript" src="http://aos-creative.prf.hn/creative/camref:11lo4J/creativeref:10l2118"></script>'; // 5s (iPad Air)
			
			else if($rand ==2)
				$candy = '<script type="text/javascript" src="http://aos-creative.prf.hn/creative/camref:11lo4J/creativeref:10l2126"></script>'; // macbook air
			
			else if($rand ==3)
				$candy = '<script type="text/javascript" src="http://aos-creative.prf.hn/creative/camref:11lo4J/creativeref:10l2686"></script>'; // iphone 5s
			else if($rand ==4)
				$candy = '<script type="text/javascript" src="http://aos-creative.prf.hn/creative/camref:11lo4J/creativeref:11l2134"></script>'; // ipad retina
			else if($rand ==5)
				$candy = '<script type="text/javascript" src="http://aos-creative.prf.hn/creative/camref:11lo4J/creativeref:11l2144"></script>'; // imac	
			else
				$candy = '<script type="text/javascript" src="http://aos-creative.prf.hn/creative/camref:11lo4J/creativeref:11l2160"></script>'; // iphone 5s
			}
			break;
			default:{
			$category = 0;
			$active[0] = 'id="active"';
			$title = "Новости Apple для настоящих фанатов";
			$rand = rand(1,6);
			if($rand==1)
				$candy = '<script type="text/javascript" src="http://aos-creative.prf.hn/creative/camref:11lo4J/creativeref:10l2118"></script>'; // 5s (iPad Air)
			
			else if($rand ==2)
				$candy = '<script type="text/javascript" src="http://aos-creative.prf.hn/creative/camref:11lo4J/creativeref:10l2126"></script>'; // macbook air
			
			else if($rand ==3)
				$candy = '<script type="text/javascript" src="http://aos-creative.prf.hn/creative/camref:11lo4J/creativeref:10l2686"></script>'; // iphone 5s
			else if($rand ==4)
				$candy = '<script type="text/javascript" src="http://aos-creative.prf.hn/creative/camref:11lo4J/creativeref:11l2134"></script>'; // ipad retina
			else if($rand ==5)
				$candy = '<script type="text/javascript" src="http://aos-creative.prf.hn/creative/camref:11lo4J/creativeref:11l2144"></script>'; // imac	
			else
				$candy = '<script type="text/javascript" src="http://aos-creative.prf.hn/creative/camref:11lo4J/creativeref:11l2160"></script>'; // iphone 5s	
			
			
			
			}
			break;
	}

}
*/	


?>