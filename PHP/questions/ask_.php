<?php                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  session_start();
@include_once("../config.inc.php");
@include_once("../functions.inc.php");
header("Content-type:text/html;charset=utf-8"); 
$link = mysql_connect($DBSERVER, $DBUSER, $DBPASS)
or header("../apple-news/");
mysql_select_db($DB, $link) or die ("Can't select DB");

$check_for_login_q = mysql_query("SELECT * FROM `register` WHERE `hash`='".$_COOKIE['user']."' AND `confirm`=1");
$user_exist = mysql_num_rows($check_for_login_q);






if($_POST){
//mysql_query("SET NAMES utf8");

if($user_exist == 1){
$user_post = mysql_fetch_assoc($check_for_login_q);

if($_POST['upd']){

if(is_numeric($_POST['type_sel']))
$type = $_POST['type_sel'];
$title = mysql_escape_string(trim($_POST['title']));
$text = mysql_escape_string(trim($_POST['text']));
if(is_numeric($_GET['url']))
$id = $_GET['url'];



$img_patt = "#([^\"])http([A-Za-z0-9:\/\.\+\?\.\=\%\/\@\!\#\&_-]+)\.(jpg|jpeg|png|gif|JPG|JPEG|PNG|GIF)#";
$img_repl = '<img src="http$2.$3">';
$text = preg_replace($img_patt, $img_repl, $text);

$patt = "#([^\"\>])http([A-Za-z0-9:\/\.\+\?\.\=\%\/\@\!\#\&_-]+)#";
/* $repl = '<a href="http$2" target="_blank" rel="nofollow">http$2</a> '; */
$text = preg_replace($patt, $repl, $text);



$inst = mysql_query("UPDATE `questions` SET `type` = $type, `title` ='".$title."', `body`='".$text."' WHERE `id`=".$id." AND `user_id`=".$user_post['id']."");

header("Location: ../../question/".$id."/");

	
}
else{
if(is_numeric($_POST['type_sel']))
$type = $_POST['type_sel'];
$title = mysql_escape_string(trim($_POST['title']));
$text = mysql_escape_string(trim($_POST['text']));


$img_patt = "#([^\"])http([A-Za-z0-9:\/\.\+\?\.\=\%\/\@\!\#\&_-]+)\.(jpg|jpeg|png|gif|JPG|JPEG|PNG|GIF)#";
$img_repl = '<img src="http$2.$3">';
$text = preg_replace($img_patt, $img_repl, $text);

$patt = "#([^\"\>])http([A-Za-z0-9:\/\.\+\?\.\=\%\/\@\!\#\&_-]+)#";
$repl = '<a href="http$2" target="_blank" rel="nofollow">http$2</a> ';
$text = preg_replace($patt, $repl, $text);


$inst = mysql_query("INSERT INTO `questions` VALUES(null,$type,".$user_post['id'].",'".$title."','".$text."',null)");
$q_id = mysql_insert_id();

$inst_notif = mysql_query("INSERT INTO `answers_notif` VALUES(null,".$q_id.",".$user_post['id'].")");

call_user_func(userActivityCallback(1,null,$q_id,$text));

header("Location: ../question/".$q_id."/");
}

}	
}
else{

if($user_exist != 1){

//$js_show_reg_form = "";


//$js_for_reg = "";


$name_disp_none = "style=\"display:none\"";
$hide_notif_trigger = "style=\"display:none;\"";
$show_forms = 'true';
$user_id = "''";
}
else{

$user = mysql_fetch_assoc($check_for_login_q);


if($_GET['url']){
	$que_id = $_GET['url']; 	
$mysql_quest_q = mysql_query("SELECT * FROM `questions` WHERE `id`=".$que_id." AND `user_id`=".$user['id']."");
$get_num_rows = mysql_num_rows($mysql_quest_q);
if($get_num_rows == 1){
	
	$update = '<input name="upd" type="hidden" value=1>';

	$question = mysql_fetch_assoc($mysql_quest_q);
	
	switch($question['type']){
		case 1:
		$type[1] = 'selected="selected"';
		break;
		case 2:
		$type[2] = 'selected="selected"';
		break;
		case 3:
		$type[3] = 'selected="selected"';
		break;
		case 4:
		$type[4] = 'selected="selected"';
		break;
		case 5:
		$type[5] = 'selected="selected"';
		break;
		case 6:
		$type[6] = 'selected="selected"';
		break;
		case 7:
		$type[7] = 'selected="selected"';
		break;
		case 8:
		$type[8] = 'selected="selected"';
		break;
		case 9:
		$type[9] = 'selected="selected"';
		break;
		case 10:
		$type[10] = 'selected="selected"';
		break;
		case 11:
		$type[11] = 'selected="selected"';
		break;
		case 12:
		$type[12] = 'selected="selected"';
		break;
		case 13:
		$type[13] = 'selected="selected"';
		break;
		case 14:
		$type[14] = 'selected="selected"';
		break;
	}
$upd_title = 'value=\''.stripslashes($question['title']).'\'';
$upd_text = nl2br(stripslashes($question['body']));	



$img_gif_patt = "#<img src=\"([A-Za-z0-9:\/\.\+\?\.\=\%\/\@\!\#\&_-]+)\">#";
$img_gif_repl = ' $1 ';

$upd_text = preg_replace($img_gif_patt, $img_gif_repl, $upd_text);
$upd_text = strip_tags($upd_text,'<br />');

}	
else
header("Location: ../");
	
}


$show_forms = 'false';

if(isset($user['id']))
$user_id = $user['id'];
else
$user_id = "''";

	
}
}
?>
<!DOCTYPE HTML>
<html>
<head>
<link rel="stylesheet" type="text/css" href="http://macilove.com/styles.css">
<link rel="stylesheet" type="text/css" href="http://macilove.com/retina-new.css">
<link rel="stylesheet" type="text/css" href="http://macilove.com/questions/answers.css">
<link rel="stylesheet" media="only screen and (-webkit-min-device-pixel-ratio: 2)" 	href="http://macilove.com/questions/answers_2x.css">

<meta charset="UTF-8" />
<title>Задать вопрос в сообщество Apple пользователей</title>
<script type="text/javascript" src="http://userapi.com/js/api/openapi.js?41"></script>
<meta name="viewport" content="width=1024">
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="http://macilove.com/resources/apple-touch-icon-114x114.png" />
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-8052564-20']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
  
var user_id = <?php echo $user_id; ?>;
var name = '<?php echo $user['name']; ?>'; 	 
var show = <?php echo $show_forms; ?>;


function close_lost(){
document.body.style.overflow='visible';
document.getElementById('subscribe-box-reg').style.display = 'none';
return;
}
  
function reg_to_log(){

if(document.getElementById('aut_check').value==1)
	{	
		document.getElementById('aut_check').value = 0;
		document.getElementById('span-box-log').style.display = 'block';
		document.getElementById('span-box-reg').style.display = 'none';
		document.getElementById('aut_log_window').setAttribute('class', 'post-switch-active');
		document.getElementById('aut_reg_window').setAttribute('class', 'post-switch');
	}
	else{

		document.getElementById('aut_check').value = 1;
		document.getElementById('span-box-reg').style.display = 'block';
		document.getElementById('span-box-log').style.display = 'none';	
		document.getElementById('aut_log_window').setAttribute('class', 'post-switch');
		document.getElementById('aut_reg_window').setAttribute('class', 'post-switch-active');		
	}
return;
	
}


function login(){
	document.getElementById('login_err').style.display = 'none';
	var error = false;
	var email = document.getElementById('login_email').value;
	var password = document.getElementById('login_pass').value;
	if(!email && !password){
		document.getElementById('login_err').style.display = 'block';
		document.getElementById('login_error').innerHTML = '<span class=\"error-tail\"></span><span class=\"error-note-icon\"></span>Введите Email и пароль.';
	error = true;
	return;
	}
	else if(!email){
		document.getElementById('login_err').style.display = 'block';
		document.getElementById('login_error').innerHTML = '<span class=\"error-tail\"></span><span class=\"error-note-icon\"></span>Введите Email.';
	error = true;
	return;
	}
	else if(!password){
		document.getElementById('login_err').style.display = 'block';
		document.getElementById('login_error').innerHTML = '<span class=\"error-tail\"></span><span class=\"error-note-icon\"></span>Введите пароль.';
	error = true;
	return;
	}
	
	if(!error){
		
		
	var checkStr = "em="+email+"&pass="+password; 
	var xmlHttpReq = false;
    var self = this;
   
    if (window.XMLHttpRequest) {
        self.xmlHttpReq = new XMLHttpRequest();
    }
    else if (window.ActiveXObject) {
        self.xmlHttpReq = new ActiveXObject("Microsoft.XMLHTTP");
    }

    self.xmlHttpReq.open('POST', '../../news/login_handler.php', true);
    self.xmlHttpReq.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    self.xmlHttpReq.onreadystatechange = function() {
        if (self.xmlHttpReq.readyState == 4 && self.xmlHttpReq.status == 200) {
		    if(self.xmlHttpReq.responseText ==1 ){
		    	document.getElementById('login_err').style.display = 'block';
		    	document.getElementById('login_error').innerHTML = '<span class=\"error-tail\"></span><span class=\"error-note-icon\"></span>Email должен быть вида email@domain.com.';
		    	error = true;
		    	return;
		    }
		    else if(self.xmlHttpReq.responseText ==2 ){
				document.getElementById('login_err').style.display = 'block';
		    	document.getElementById('login_error').innerHTML = '<span class=\"error-tail\"></span><span class=\"error-note-icon\"></span>Пара Email / пароль не совпадают. <a href=\"../lost_password/\">Забыли пароль?</a>';
		    	error = true;
		    	return;    
		    }
		    else{
			var pattern_id = /([0-9]+)/; 
			var id = pattern_id.exec(self.xmlHttpReq.responseText);
			var pattern_user = /name=([A-ZА-Яа-яa-z0-9_-]+)/;
			var user = pattern_user.exec(self.xmlHttpReq.responseText);	   
			user_id = id[1];
			name = user[1]; 	 
			document.getElementById('name-p').innerHTML = name+'<span class=\"sep\">|</span> <a href=\"javascript:log_out()\">Выход</a>';
			document.getElementById('name-p').style.display = 'block';
			document.body.style.overflow = 'visible';
			//document.getElementById('notif-trigger-id').style.display = 'block';
			document.getElementById('subscribe-box-reg').style.display = 'none';    			    
		    show = false;
		   
		    var us_com_1 = document.getElementsByName('text-'+user_id);
			var us_com_2 = document.getElementsByName('gloss-'+user_id);
			for(i=0; i<=us_com_1.length;i++){
			if(us_com_1[i])
			us_com_1[i].setAttribute('class','yours-comment-text');
			if(us_com_2[i])
			us_com_2[i].setAttribute('class','yours-comment-gloss');
			}

		   
		    add_question();
		    return;
		    }
		    
		}	           	
		
    }
    self.xmlHttpReq.send(checkStr);
			
	}
	else
	return;
}





function registraion(){
	document.getElementById('login_err').style.display = 'none';
	var error = false;
	var email = document.getElementById('registr_email').value;
	var password = document.getElementById('registr_pass').value;
	name = document.getElementById('registr_name').value;
	var nickname = document.getElementById('registr_nick').value;
	if(!email && !password && !name && !nickname){
		document.getElementById('login_err').style.display = 'block';
		document.getElementById('login_error').innerHTML = '<span class=\"error-tail\"></span><span class=\"error-note-icon\"></span>Все поля обязательны для заполнения.';
	error = true;
	return;
	}
	else if(!nickname){
		document.getElementById('login_err').style.display = 'block';
		document.getElementById('login_error').innerHTML = '<span class=\"error-tail\"></span><span class=\"error-note-icon\"></span>Введите ваш никнейм.';
	error = true;
	return;
	}
	else if(!name){
		document.getElementById('login_err').style.display = 'block';
		document.getElementById('login_error').innerHTML = '<span class=\"error-tail\"></span><span class=\"error-note-icon\"></span>Введите ваше имя.';
	error = true;
	return;
	}
	else if(!email){
		document.getElementById('login_err').style.display = 'block';
		document.getElementById('login_error').innerHTML = '<span class=\"error-tail\"></span><span class=\"error-note-icon\"></span>Введите email.';
	error = true;
	return;
	}
	else if(!password){
		document.getElementById('login_err').style.display = 'block';
		document.getElementById('login_error').innerHTML = '<span class=\"error-tail\"></span><span class=\"error-note-icon\"></span>Введите пароль.';
	error = true;
	return;
	}
		
	
	if(!error){
		
		
	var checkStr = "em="+email+"&pass="+password+"&name="+name+"&nick="+nickname; 
	var xmlHttpReq = false;
    var self = this;
   
    if (window.XMLHttpRequest) {
        self.xmlHttpReq = new XMLHttpRequest();
    }
    else if (window.ActiveXObject) {
        self.xmlHttpReq = new ActiveXObject("Microsoft.XMLHTTP");
    }

    self.xmlHttpReq.open('POST', '../../news/registration_handler.php', true);
    self.xmlHttpReq.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    self.xmlHttpReq.onreadystatechange = function() {
        if (self.xmlHttpReq.readyState == 4 && self.xmlHttpReq.status == 200) {
		    if(self.xmlHttpReq.responseText ==1){
		    	document.getElementById('login_err').style.display = 'block';
		    	document.getElementById('login_error').innerHTML = '<span class=\"error-tail\"></span><span class=\"error-note-icon\"></span>Email должен быть вида email@domain.com.';
		    	error = true;
		    	return;
		    }
		    else if(self.xmlHttpReq.responseText ==2){
				document.getElementById('login_err').style.display = 'block';
		    	document.getElementById('login_error').innerHTML = '<span class=\"error-tail\"></span><span class=\"error-note-icon\"></span>Данный email уже используется.</a>';
		    	error = true;
		    	return;    
		    }
		    else if(self.xmlHttpReq.responseText ==3){
				document.getElementById('login_err').style.display = 'block';
		    	document.getElementById('login_error').innerHTML = '<span class=\"error-tail\"></span><span class=\"error-note-icon\"></span>Такой никнейм уже занят.</a>';
		    	error = true;
		    	return;    
		    }
		    else if(self.xmlHttpReq.responseText ==4){
				document.getElementById('login_err').style.display = 'block';
		    	document.getElementById('login_error').innerHTML = '<span class=\"error-tail\"></span><span class=\"error-note-icon\"></span>Никнейм может состоять только из латинских букв, цифр и знаков подчеркивания.</a>';
		    	error = true;
		    	return;    
		    }
		    else if(self.xmlHttpReq.responseText ==5){
				document.getElementById('login_err').style.display = 'block';
		    
		    	document.getElementById('login_error').innerHTML = '<span class=\"error-tail\"></span><span class=\"error-note-icon\"></span>Никнейм должен быть длиннее 3х символов.</a>';
		    	
		    	error = true;
		    	return;    
		    }
		    else if(self.xmlHttpReq.responseText ==6){
				document.getElementById('login_err').style.display = 'block';
		    	document.getElementById('login_error').innerHTML = '<span class=\"error-tail\"></span><span class=\"error-note-icon\"></span>Произошла ошибка при регистрации, попробуйте зарегистрироваться позже.</a>';
		    	error = true;    
		    	return;
		    }
		    else{
		   	document.getElementById('login_err').style.display = 'none';
		    var pattern_id = /([0-9]+)/; 
			var id = pattern_id.exec(self.xmlHttpReq.responseText);
			user_id = id[1];
			document.getElementById('name-p').innerHTML = name+'<span class=\"sep\">|</span> <a href=\"javascript:log_out()\">Выход</a>';
			document.getElementById('name-p').style.display = 'block';
			//document.body.style.overflow = 'visible';
			//document.getElementById('notif-trigger-id').style.display = 'block';
			//document.getElementById('subscribe-box-reg').style.display = 'none';    			    
		    //document.getElementById('comment_error').innerHTML = '<span class=\"error-tail\"></span><span class=\"error-note-icon\"></span>Вы успешно зарегистрировались, на указанный email отправленно письмо. Активируйте ваш аккаунт чтобы ваши коментарии были видны всем.</a>.';
		    show = false;
		   // add_comment();
		   	document.getElementById('span-box-reg').style.display = 'none';
		    document.getElementById('span-conformation').style.display = 'block';
		    document.getElementById('login-reg-switch').style.display = 'none';
   			document.getElementById('subscribe-box-title').innerHTML = 'Подтвердите email';    
		    
		    return;
		    }
  
		}	           	
		else{
		document.getElementById('login_err').style.display = 'block';
		document.getElementById('login_error').innerHTML = '<img width=\"16\" height=\"16\" class=\"spinner\" src=\"http://macilove.com/images/img/spinner.gif\">';
		}
		
    }
    self.xmlHttpReq.send(checkStr);			
    }
else
return;

}


function confirmation(){

	document.getElementById('login_err').style.display = 'none';
	var code = document.getElementById('check_code').value;
	if(!code){
		document.getElementById('login_err').style.display = 'block';
		document.getElementById('login_error').innerHTML = '<span class=\"error-tail\"></span><span class=\"error-note-icon\"></span>Введите код для продолжения.</a>';
	}
   	
	var checkStr = "id="+user_id+"&code="+code;

	var xmlHttpReq = false;
    var self = this;
    if (window.XMLHttpRequest) {
        self.xmlHttpReq = new XMLHttpRequest();
    }
    else if (window.ActiveXObject) {
        self.xmlHttpReq = new ActiveXObject("Microsoft.XMLHTTP");
    }

    self.xmlHttpReq.open('POST', '../../news/confirm_reg.php', true);
    self.xmlHttpReq.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    self.xmlHttpReq.onreadystatechange = function() {
        if (self.xmlHttpReq.readyState == 4 && self.xmlHttpReq.status == 200) {
		    if(self.xmlHttpReq.responseText ==1){
			document.body.style.overflow = 'visible';
			
			add_question();
		   	document.getElementById('subscribe-box-reg').style.display = 'none';
		    document.getElementById('login_err').style.display = 'none';
			document.getElementById('span-box-reg').style.display = 'block';
		    document.getElementById('span-conformation').style.display = 'none';
		    document.getElementById('subscribe-box-title').innerHTML = 'Авторизация';    
   			
			return;
		    }
		    if(self.xmlHttpReq.responseText ==2){
		    
			document.getElementById('login_err').style.display = 'block';
			document.getElementById('login_error').innerHTML = '<span class=\"error-tail\"></span><span class=\"error-note-icon\"></span>Произошла ошибка, попробуйте зарегистрироваться позже.</a>';
		    
			return;
		    }
		}	           	
		
    }
    self.xmlHttpReq.send(checkStr);
    
    return;	
}

  
function add_question(){

if(!user_id || !name || show){
document.getElementById('subscribe-box-reg').style.display = 'block';
document.body.style.overflow = 'hidden';
return;
}
else{
document.getElementById('error').style.display = 'none';
sel_val = document.comment.type_sel.value;
title_val = document.comment.title.value;
text_val = document.comment.text.value;
if(!sel_val || sel_val==0){
document.getElementById('error').style.display = 'block';
document.getElementById('error').innerHTML = '<span class="error-tail"></span><span class="error-note-icon"></span>Выберите раздел вопроса.';
return;

} else if(!title_val){
document.getElementById('error').style.display = 'block';
document.getElementById('error').innerHTML = '<span class="error-tail"></span><span class="error-note-icon"></span>Введите заголовок вопроса.';
return;

} else if(!text_val){
document.getElementById('error').style.display = 'block';
document.getElementById('error').innerHTML = '<span class="error-tail"></span><span class="error-note-icon"></span>Введите текст сообщения.';
return;

} else if(sel_val && title_val && text_val){
	document.comment.submit();
}


return;

}
}  
  
  
  
function log_out(){

if(name && user_id){

	var checkStr = "id="+user_id+"&name="+name;
	var xmlHttpReq = false;
    var self = this;
    if (window.XMLHttpRequest) {
        self.xmlHttpReq = new XMLHttpRequest();
    }
    else if (window.ActiveXObject) {
        self.xmlHttpReq = new ActiveXObject("Microsoft.XMLHTTP");
    }

    self.xmlHttpReq.open('POST', '../../news/login_handler.php', true);
    self.xmlHttpReq.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    self.xmlHttpReq.onreadystatechange = function() {
        if (self.xmlHttpReq.readyState == 4 && self.xmlHttpReq.status == 200) {
		    if(self.xmlHttpReq.responseText ==1){
	
			var us_com_1 = document.getElementsByName('text-'+user_id);
			var us_com_2 = document.getElementsByName('gloss-'+user_id);
			var us_com_3 = document.getElementsByName('tail-'+user_id);
			for(i=0; i<=us_com_1.length;i++){
			if(us_com_1[i])
			us_com_1[i].setAttribute('class','comment-text');
			if(us_com_2[i])
			us_com_2[i].setAttribute('class','comment-gloss');
			if(us_com_3[i])
			us_com_3[i].setAttribute('class','comment-tail');
			}
			
			user_id = '';
			name = '';
			show = true;
			document.getElementById('name-p').innerHTML = '';
			document.getElementById('name-p').style.display = 'none';
			//document.getElementById('notif-trigger-id').style.display = 'none';
			
			
			return;
		    }
		}	           	
		
    }
    self.xmlHttpReq.send(checkStr);		
	
}
else	
return;	
}

  

</script>
</head>

<body>
<div id="subscribe-box-reg" style="display: none;">
<input type="hidden" value="1" id="aut_check">
	<div class="popup-question-box">
	<a href="javascript:close_lost()" class="popup-question-close">&times;</a>
	<h3 id="subscribe-box-title" class="login-reg-title">Авторизация</h3>
	<div class="subscribe-bottom-box">
	<div id="login-reg-switch">
		
	<a href="javascript:reg_to_log();" class="post-switch" id="aut_log_window">Войти</a>
	<a href="javascript:reg_to_log();" class="post-switch-active" id="aut_reg_window">Зарегистрироваться</a>
</div>

	<span id="span-box-reg" style="display: block;">
	<form name="registraion_form">
	<input id="registr_nick" onkeydown="if (event.keyCode == 13) registraion()"  type="text" placeholder="Никнейм латинскими" title="Никнейм латинскими" autofocus="">
	<input id="registr_name" onkeydown="if (event.keyCode == 13) registraion()"  type="text" placeholder="Ваше имя" title="Полное имя">
	<input id="registr_email" onkeydown="if (event.keyCode == 13) registraion()"  type="email" placeholder="Email" title="Email">
	<input id="registr_pass" onkeydown="if (event.keyCode == 13) registraion()"  type="password" placeholder="Пароль" title="Пароль">
	<button type="button" onclick="registraion()" class="blue-button">Зарегистрироваться</button>
	</form>
	</span>
	<span id="span-box-log" style="display: none;">
	<form name="login_form">
	<input id="login_email" onkeydown="if (event.keyCode == 13) login()"  type="email" placeholder="Email" autofocus="" title="Email">
	<input id="login_pass" onkeydown="if (event.keyCode == 13) login()"  type="password" placeholder="Пароль" title="Пароль">
	<button type="button" onclick="login()" class="blue-button">Войти</button>
	</form>	
	</span>
	
	<span id="span-conformation" style="display: none;">
	<p>Введите код подверждения, присланный вам на email:</p>
	<input id="check_code" onkeydown="if (event.keyCode == 13) confirmation()" maxlength="10" type="text" placeholder="Код подтверждения" title="Код подтверждения">
	<button type="button" onclick="confirmation()" class="blue-button">Подтвердить</button>
	
	</span>
	
	<div id="login_err" class="login-reg-error-box" style="display:none;">
	<p id="login_error" class="error-note"><span class="error-tail"></span><span class="error-note-icon"></span>
	</p>
	</div>
	</div>
	</div>
</div>

<div class="wrapper">
<div class="nav">
	
	<a href="http://macilove.com" id="logo"></a>
	<span class="main-nav">
	<a class="main-menu" href="http://macilove.com/news/">Новости</a>
	<a class="active-main-menu" href="http://macilove.com/questions/">Форум</a>
	<a class="main-menu" href="http://macilove.com/books/">Книги</a>
	<a class="main-menu" href="http://macilove.com/video/">Видео</a>
	<a class="main-menu" href="http://macilove.com/russian-xcode-tutorials/">Mac разработчики</a>
	</span> 
	
	<span id="search-box">
	<form method="get" action="http://www.google.com/search">
	<input type="search" name="q" size="25" maxlength="255" placeholder="Поиск">
	<input type="hidden" name="sitesearch" value="macilove.com" />
	</form>
	</span>
	
</div>	
</div>

<div class="wrapper">
<div class="main-bg">

<div class="answers-top">
<h1>Задать вопрос в форум</h1>
</div>

<div class="answers-index-sep">
</div>


<div class="ask-question-box">
<div class="notes">Внимание: заголовок должен отражать суть вопроса, например «Как установить iTunes?». Вопросы с заголовками из 1 слова будут удалены без предупреждения.</div>
<div id="ask-toolbar">
<form name="comment" method="post" action="">
<select name="type_sel">
	<option value="0">– Выберите раздел –</option>
	<option <?php echo $type[1]; ?> value="1">App Store</option>
	<option <?php echo $type[2]; ?> value="2">iMac</option>
	<option <?php echo $type[3]; ?> value="3">iPad</option>
	<option <?php echo $type[4]; ?> value="4">iPhone</option>
	<option <?php echo $type[5]; ?> value="5">iPod</option>
	<option <?php echo $type[6]; ?> value="6">iOS</option>
	<option <?php echo $type[7]; ?> value="7">MacBook</option>
	<option <?php echo $type[8]; ?> value="8">Mac mini</option>
	<option <?php echo $type[9]; ?> value="9">Mac Pro</option>
	<option <?php echo $type[10]; ?> value="10">OS X</option>
	<option <?php echo $type[11]; ?> value="11">Xcode</option>
	<option <?php echo $type[12]; ?> value="12">Аксессуары</option>
	<option <?php echo $type[13]; ?> value="13">Приложения</option>
	<option <?php echo $type[14]; ?> value="14">Другое</option>
</select>

<div id="switcher" <?php echo $name_disp_none; ?>>
			<span id="name-p"><?php echo $user['name']; ?><span class="sep">|</span> 
			<a href="javascript:log_out()">Выход</a>
			</span>
</div>
</div>
<?php echo $update; ?>

<input type="text" name="title" placeholder="Заголовок" id="enter-title" <?php echo $upd_title; ?>>

<textarea name="text" id="news-add-comment" class="input" maxlength="5000" placeholder="Текст вопроса"><?php echo $upd_text; ?></textarea>
</form>

<button onclick="add_question()" class="blue-button">Опубликовать</button>
<span class="ask-question-note">Подсказка: чтобы вставить изображение просто укажите в тексте ссылку на картинку.</span>
<p id="error" class="error-note ask-error"></p>
</div>


</div>
<div id="footer">
<span class="copy">© 2013 Macilove.com</span>
<a href="http://macilove.com/about/">О нас</a>
<span class="footer-sep">&middot;</span>
<a href="http://macilove.com/feedback/">Обратная связь</a>
<span class="footer-sep">&middot;</span>
<a href="http://twitter.com/macilove_com" target="_blank">Twitter</a>
<span class="footer-sep">&middot;</span>
<a href="http://www.facebook.com/macilovecom" target="_blank">Facebook</a>
<span class="footer-sep">&middot;</span>
<a href="http://macilove.com/use-of-cookies/">Использование cookies</a>
<span class="footer-sep">&middot;</span>
<a href="http://macilove-com.tumblr.com/">Блог</a>
<span class="footer-sep">&middot;</span>
<a href="http://macilove.com/rss/">RSS</a>
</div>

<div id="made-on-mac">
<a href="http://store.apple.com/" id="made-on-a-mac-icon" target="_blank" rel="nofollow"></a>
</div>
</div>
</div>
</body>
</html>
