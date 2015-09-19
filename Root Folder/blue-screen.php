<?php 
session_start();
setcookie('blue_screen', 1, time() + 3600 * 24 * 30*12, '/');
	
	
	
?>
<!DOCTYPE HTML>
<html lang="ru">
<head prefix="og: http://ogp.me/ns#">
<meta charset = "utf-8">
<meta name="keywords" content="Новости Apple, приложения для iPhone, игры для iPad">
<meta name="description" content="Новости Apple для настоящих фанатов">
<title>Blue Screen Of Death</title>
<script>
	document.onkeydown = function(e) { 
    e = e || window.event;
    if (e.keyCode == 86) {
    document.getElementById("help2").style.display = 'block';
    document.getElementById("help2").setAttribute("src", "http://www.youtube.com/embed/wvsboPUjrGc?list=PLKUuw95_tpmVJUeu4e0e1LgRXTecH3Haz&autoplay=1&controls=0&showinfo=0");
    }

};
</script>
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
<style>
body{
	background: #0000bf;
	color: white;
	font-family: monospace;
	margin: 0;
	padding: 0;
}

p{
	white-space: pre-wrap;
	font-size: 16px;
	padding: 10px;
	margin: 0;
}

a{
	color: blue;
	display: inline-block;
	padding: 4px 8px;
	background: yellow;
}

.button-box{
	text-align: center;
	position: fixed;
	bottom: 20px;
	left: 50%;
	margin-left: -80px;
}

.cursor{
	-webkit-animation: pulsate 1.2s ease-out;
    -webkit-animation-iteration-count: infinite;
}

@-webkit-keyframes pulsate {
    0% {color: transparent;
    }
	50% {color: white;}
    100% {color: transparent;}
}

#video{
	display: none;
}
</style>
</head>
<body>
<div id="video2" style="position: fixed; z-index: -99; width: 100%; height: 100%">
  <iframe id="help2" frameborder="0" height="100%" width="100%" 
    src="">
  </iframe>
</div>
<p id="text">A problem has been detected and Windows has been shut down to prevent damage
to your computer.

IRQL_NOT_LESS_OR_EQUAL

If this is the first time you've seen this Stop error screen,
restart your computer. If this screen appears again, follow
these steps:

Check to make sure any new hardware or software is properly installed. 
If this is a new installation, ask your hardware or software manufacturer
for any Windows updates you might need or <strong>press <span style="background: yellow;">V</span> for additional info</strong>.

If problems continues, disable or remove any newly installed hardware
or software. Disable BIOS memory options such as caching or shadowing. 
If you need to use Safe Mode to remove or disable components, restart
your computer, press F8 to select Advanced Startup Options, and then
select Save Mode.

Technical information:

*** STOP: 0x00000000B (0x0000000000000007C, 0x00000000000000063, 0x00000000000000003, 0
xFFFFF30002B87BBF)

Collection data for crash dump ...
Initialising disk for crash dump ...
Beginning dump of physical memory.
Dumping physical memory to disk: Win7<span class="cursor">&#x2588;</span></p>

<div class="button-box">
	<a href="http://macilove.com/news/">Reboot in Mac OS X</a>
</div>
</body>
</html>