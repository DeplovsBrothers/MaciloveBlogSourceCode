<!DOCTYPE HTML>
<html lang="en">
<head prefix="og: http://ogp.me/ns#">
<link rel="stylesheet" type="text/css" href="http://macilove.com/news/style.css">
<link href='http://fonts.googleapis.com/css?family=Noto+Serif:400,700,400italic,700italic&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
<script type="text/javascript" src="http://yandex.st/jquery/2.1.0/jquery.min.js"></script>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=1140">

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

</script>

<title>Подпишитесь на новости Macilove по email</title>

<script type="text/javascript">
	$(document).ready(function(){
	
		$('#subscribe input').keypress(function(e) {
        if(e.which == 13) {
            jQuery(this).blur();
            jQuery('#emailUserSignUp').focus().click();
        }
	    });

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
</script>
</head>
<body>

<nav>
	<div class="pin">
		<a href="http://macilove.com" id="logo"><img src="http://macilove.com/resources/logo.png" width="120" height="23"></a>
	<ul>
		<li><a href="http://macilove.com">Новости Apple</a></li>
		<li><a href="http://macilove.com/news/games-for-ios/">iOS Игры</a></li>
		<li><a href="http://macilove.com/news/apps-for-ios/">iOS приложения</a></li>
		<li><a href="http://macilove.com/news/apps-and-games-for-mac-os-x/">Mac приложения</a></li>
		<li><a href="http://macilove.com/news/tricks-and-secrets-mac-os-x-ios/">Трюки и секреты</a></li>
	</ul>
	<ul>
		<li><a href="http://macilove.com/best-mac-os-x-apps/">Top приложения</a></li>
		<li><a href="http://macilove.com/books/">Книги</a></li>
	</ul>
	<footer>
		<ul>
			<li>© 2014 Macilove.com</li>
			<li><a href="http://macilove.com/about/">О нас</a></li>
			<li><a href="http://macilove.com/feedback/">Обратная связь</a></li>
		</ul>
	</footer>
	</div>
</nav>

<style type="text/css">

#text h1{
	text-align: center;
	margin-top: 20px;
	font-size: 220%;
}

#page{
	padding-bottom: 40px;
	position: relative;
	padding-top: 0 !important;
}

h2{
	margin-left: 100px;
	font-size: 150%;
	display: inline-block;
	vertical-align: top;
}

section{
	border-top: 1px solid #F0F0F0;
	padding: 40px 0;
	z-index: 2;
	position: relative;
	background: white;
}

#text{
	position: relative;
	z-index: 2;
	border-top: none;
}

</style>
<article id="page">
	<section id="text">
	<img src="http://macilove.com/resources/mail-icon.jpg" width="180" height="189">
		<h1>Подпишитесь на новости по email</h1>
		<p>Присоединяйтесь к более чем 1000+ фанатам, которые уже читают новости Apple, обзоры приложений для OS X и iOS, а также узнают секреты пользования техникой Apple по электронной почте.</p>
		<div id="subscribe">
			<input id="emailUserName" type="text" placeholder="Ваше имя" autofocus="">
			<input id="emailUserBox" type="email" placeholder="Email адрес">
			<button id="emailUserSignUp">Подписаться</button>
			<div style="display: none;" id="succeed">Вы успешно подписались!</div>
		</div>
	</section>
</article>

</body>
</html>