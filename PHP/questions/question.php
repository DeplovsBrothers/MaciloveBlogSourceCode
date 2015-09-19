<?php
session_start();
@include_once("../config.inc.php");
@include_once("../functions.inc.php");
header("Content-type:text/html;charset=utf-8"); 
$link = mysql_connect($DBSERVER, $DBUSER, $DBPASS)
or header("../apple-news/");
mysql_select_db($DB, $link) or die ("Can't select DB");

if(!$_GET['q_id'])
header("Location: ../");
else if(!is_numeric($_GET['q_id']))
header("Location: ../../");

$check_for_login_q = mysql_query("SELECT * FROM `register` WHERE `hash`='".$_COOKIE['user']."' AND `confirm`=1");
$user_exist = mysql_num_rows($check_for_login_q);
if($user_exist != 1){

//$js_show_reg_form = "";


//$js_for_reg = "";


$name_disp_none = "style=\"display:none\"";
$show_forms = 'true';
$user_id = "''";
}
else{
$show_forms = 'false';

$user = mysql_fetch_assoc($check_for_login_q);

if(isset($user['id']))
$user_id = $user['id'];
else
$user_id = "''";

	
}


$q_id = $_GET['q_id'];



$question_q = mysql_query("SELECT q.*, UNIX_TIMESTAMP(q.pub_date), r.name, r.nickname 
FROM `questions` AS `q` 
LEFT JOIN `register` AS `r` ON q.user_id = r.id
WHERE q.id =$q_id");

$question_exist = mysql_num_rows($question_q);
if($question_exist !=1)
header("Location: ../../");

$question = mysql_fetch_assoc($question_q);

$type_n = $question['type'];
switch($type_n){
	case 1:
	$type = 'App Store';
	$cat_url = 'app-store';
	$img_class = 'app-store-icon';
	break;
	case 2:
	$type = 'iMac';
	$cat_url = 'imac';
	$img_class = 'imac-icon';
	break;
	case 3:
	$type = 'iPad';
	$cat_url = 'ipad';
	$img_class = 'ipad-icon';
	break;
	case 4:
	$type = 'iPhone';
	$cat_url = 'iphone';
	$img_class = 'iphone-icon';
	break;
	case 5:
	$type = 'iPod';
	$cat_url = 'ipod';
	$img_class = 'ipod-icon';
	break;
	case 6:
	$type = 'iOS';
	$cat_url = 'ios';
	$img_class = 'ios-icon';
	break;
	case 7:
	$type = 'MacBook';
	$cat_url = 'macbook';
	$img_class = 'macbook-icon';
	break;
	case 8:
	$type = 'Mac mini';
	$cat_url = 'mac-mini';
	$img_class = 'mac-mini-icon';
	break;
	case 9:
	$type = 'Mac Pro';
	$cat_url = 'mac-pro';
	$img_class = 'mac-pro-icon';
	break;
	case 10:
	$type = 'OS X';
	$cat_url = 'os-x';
	$img_class = 'os-x-icon';
	break;
	case 11:
	$type = 'Xcode';
	$cat_url = 'xcode';
	$img_class = 'xcode-icon';
	break;
	case 12:
	$type = 'Аксессуары';
	$cat_url = 'accessories';
	$img_class = 'accessories-icon';
	break;
	case 13:
	$type = 'Приложения';
	$cat_url = 'apps';
	$img_class = 'applications-icon';
	break;	
	case 14:
	$type = 'Другое';
	$cat_url = 'other';
	$img_class = 'other-icon';
	break;	

}

$type_num_q = mysql_query("SELECT `id` FROM `questions` WHERE `type`=".$type_n);
$type_num = mysql_num_rows($type_num_q);

$title = stripslashes($question['title']);
$text = stripslashes(nl2br($question['body']));
if($question['user_id']==$user['id'])
$edit_question = '<span class="sep">|</span><a href="./../../ask/'.$question['id'].'/" class="edit-question-text-link">Редактировать</a>';

if(!empty($question['name']))
$name = $question['name'];
else
$name = $question['nickname'];


$pub_date = $question['UNIX_TIMESTAMP(q.pub_date)'];

$que_date = strftime( "%e", $pub_date);
$que_year = strftime( "%Y", $pub_date);
$que_month = strftime( "%m", $pub_date);

$info_date = $que_date.'.'.$que_month.'.'.$que_year;




//answers

$answers_q = mysql_query("SELECT *, UNIX_TIMESTAMP(pub_date) FROM `answers` WHERE `question_id`=".$q_id." ORDER BY `pub_date`,`best`");


$answers_num = mysql_num_rows($answers_q);
if($answers_num>0){
$check_best = 0;
$check_answer = 0;
for($cnt = 0; $answer_arr = mysql_fetch_assoc($answers_q); ++$cnt){
$a_pub_date = $answer_arr['UNIX_TIMESTAMP(pub_date)'];

$a_que_date = strftime( "%e", $a_pub_date);
$a_que_year = strftime( "%Y" ,$a_pub_date);
$a_que_month = strftime( "%m" ,$a_pub_date);
$a_date = $a_que_date.'.'.$a_que_month.'.'.$a_que_year;
	if($answer_arr['best']==1){
	$check_best++;
	
		$best_answer .= '<div class="answer-comment best-answer">
<div class="answer-name-n-date">
	<span class="answer-name">'.$answer_arr['name'].'
	</span>
	<span class="answer-date">
	'.$a_date.'
	</span>
</div>
<p>'.nl2br(($answer_arr['answer'])).'</p>
<div class="answer-comment-toolbar">
	<div class="its-help">
	<span class="its-help-icon"></span>Это помогло
	</div>
</div>
</div>';
		
	}
	else{
	$check_answer++;
	
	if($answer_arr['user_id']==$user['id'])
	$edit_answer = '<a href="javascript:edit_answer()" class="answer-reply">Редактировать</a>';
	else
	$edit_answer = '<a style="display:none;" href="#" class="answer-reply">Ответить</a>';
	 
$answer .= '<div class="answer-comment">
				<div class="answer-name-n-date">
					<span class="answer-name">'.$answer_arr['name'].'
					</span>
					<span class="answer-date">
						'.$a_date.'
					</span>
				</div>
				
				<p>'.nl2br(stripslashes($answer_arr['answer'])).'</p>	
			</div>';
		
	}
}	
	if($check_best ==0)
	$hide_best = 'style="display:none;"';
	
	
	
}
else{
	$hide_answer = 'style="display:none;"';
	$hide_best = 'style="display:none;"';
}




?>


<!DOCTYPE HTML>
<html lang="ru">
<head>
	<link rel="stylesheet" type="text/css" href="http://macilove.com/styles-new.css">
	<link rel="stylesheet" type="text/css" href="http://macilove.com/questions/new-questions.css">
	<link rel="stylesheet" type="text/css" href="http://macilove.com/questions/new-questions-retina.css">
	<link rel="stylesheet" media="only screen and (-webkit-min-device-pixel-ratio: 2)" 	href="http://macilove.com/retina-new.css">

	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=1024">
	<title><?php echo $title; ?> — Форум Apple</title>
	<meta name="viewport" content="width=1024">	
	<link rel="shortcut icon" href="http://macilove.com/favicon.ico" />
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
  
 
function switch_the_trigger(){


if(!user_id)
return;

if(document.getElementById('comments-hidden').value ==1){
document.getElementById('comments_image_trigger').setAttribute('class', 'switcher-icon-right');
document.getElementById('comments-subscribe-0').style.color = "#999";
document.getElementById('comments-hidden').value = 0;

}
else{
document.getElementById('comments_image_trigger').setAttribute('class', 'switcher-icon-left');
document.getElementById('comments-subscribe-0').style.color = "#333";
document.getElementById('comments-hidden').value = 1;
}

var inp_val = document.getElementById('comments-hidden').value;

	var checkStr = "v="+inp_val+"&usid="+user_id+"&queid="+<?php echo $q_id;?>;
	var xmlHttpReq = false;
    var self = this;
   
    if (window.XMLHttpRequest) {
        self.xmlHttpReq = new XMLHttpRequest();
    }
    else if (window.ActiveXObject) {
        self.xmlHttpReq = new ActiveXObject("Microsoft.XMLHTTP");
    }

    self.xmlHttpReq.open('POST', './../../answer_notif.php', true);
    self.xmlHttpReq.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    self.xmlHttpReq.onreadystatechange = function() {
        if (self.xmlHttpReq.readyState == 4 && self.xmlHttpReq.status == 200) {
		    if(self.xmlHttpReq.responseText ==2){
				if(document.getElementById('comments-hidden').value ==1){
				document.getElementById('comments_image_trigger').setAttribute('class', 'switcher-icon-right');
				document.getElementById('comments-hidden').value = 0;
				}
				else{
				document.getElementById('comments_image_trigger').setAttribute('class', 'switcher-icon-left');
				document.getElementById('comments-hidden').value = 1;
				}	
				return;
			}
		}
    
    }
    self.xmlHttpReq.send(checkStr);	


} 
  
 

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

    self.xmlHttpReq.open('POST', './../../../news/login_handler.php', true);
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
			document.getElementById('switcher').style.display = 'block';
			document.body.style.overflow = 'visible';
			//document.getElementById('notif-trigger-id').style.display = 'block';
			document.getElementById('subscribe-box-reg').style.display = 'none';    			    
		    show = false;
		   
		    var us_com_1 = document.getElementsByName('answer-toolbar-'+user_id);
			for(i=0; i<=us_com_1.length;i++){
			if(us_com_1[i])
			us_com_1[i].innerHTML = '<a href="javascript:edit_answer()" class="answer-reply">Редактировать</a>';
			}

			document.getElementById('q-toolbar-'+user_id).innerHTML = '<span class="sep">|</span><a href="./../../ask/<?php echo $question['id']; ?>/" class="edit-question-text-link">Редактировать</a>';

		   
		    //add_question();
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

    self.xmlHttpReq.open('POST', './../../../news/registration_handler.php', true);
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
			document.getElementById('switcher').style.display = 'block';
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

    self.xmlHttpReq.open('POST', './../../../news/confirm_reg.php', true);
    self.xmlHttpReq.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    self.xmlHttpReq.onreadystatechange = function() {
        if (self.xmlHttpReq.readyState == 4 && self.xmlHttpReq.status == 200) {
		    if(self.xmlHttpReq.responseText ==1){
			document.body.style.overflow = 'visible';
			
			add_answer();
		   	document.getElementById('subscribe-box-reg').style.display = 'none';
		    document.getElementById('login_err').style.display = 'none';
			document.getElementById('span-box-reg').style.display = 'block';
		    document.getElementById('login-reg-switch').style.display = 'block';
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

  
function add_answer(){
//alert('1');
if(!user_id || !name || show){
document.getElementById('subscribe-box-reg').style.display = 'block';
document.body.style.overflow = 'hidden';
return;
}
else{
text = document.answer_form.text.value;
if(!text){
	document.getElementById('error').style.display = 'block';
	document.getElementById('error').innerHTML = 'Введите текст.';
	return;
} else {
//alert('2');

	text = text.replace(/http([A-Za-z0-9:\/\.\+\?\=\.\%\/\@\!\#\&_-]+).(jpg|jpeg|png|gif|JPG|JPEG|PNG|GIF)/g, '<img src="http$1.$2">');
		    //	text = text.replace(/http([A-Za-z0-9:\/\.\+\?\=\.\%\/\@\!\#\&_-]+).jpeg/g, '<img src="http$1.jpeg">');
		    //	text = text.replace(/http([A-Za-z0-9:\/\.\+\?\=\.\%\/\@\!\#\&_-]+).png/g, '<img src="http$1.png">');
		    //	text = text.replace(/http([A-Za-z0-9:\/\.\+\?\=\.\%\/\@\!\#\&_-]+).gif/g, '<img src="http$1.gif">');
	text = ' '+text;
	text = text.replace(/([^\"\>])http([A-Za-z0-9:\/\.\+\=\?\%\@\!\#\&_-]+)/g, ' <a href="http$2" target="_blank" rel="nofollow">http$2</a> ');
	


		 
//	alert('2.1');
	  
	 text_show = (text + '').replace(/([^>]?)\n/g, '$1'+ '<br />' +'\n');

	var checkStr = "usid="+user_id+"&name="+name+"&queid="+<?php echo $q_id;?>+"&text="+text;
	var xmlHttpReq = false;
    var self = this;
//    alert('2.2');
    if (window.XMLHttpRequest) {
        self.xmlHttpReq = new XMLHttpRequest();
    }
    else if (window.ActiveXObject) {
        self.xmlHttpReq = new ActiveXObject("Microsoft.XMLHTTP");
    }
//alert('2.3');
    self.xmlHttpReq.open('POST', './../../add_answer_handler.php', true);
    self.xmlHttpReq.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
//    alert('2.4');
    self.xmlHttpReq.onreadystatechange = function() {
//        alert('2.5');
        if (self.xmlHttpReq.readyState == 4 && self.xmlHttpReq.status == 200) {
		    if(self.xmlHttpReq.responseText ==1){
//		    alert('3');

		    document.getElementById('news-add-comment').value = '';
		    	document.getElementById('error').innerHTML = '<span class="error-tail"></span><span class="error-note-icon"></span>Подтвердите свой email, чтобы ваш комментрарий стал виден для всех, если вы не получили письмо, проверьте его в папке Спам. <a href="#">Выслать повторное письмо</a>.';

		    	document.getElementById('comment_error').style.display = 'block';
		    	var parent_div = document.getElementById('parrent_comment_box');
		    	var new_comment_div = document.createElement('div');
		    			    	
		    	var d = new Date();
		    	
		    	
		    	new_comment_div.setAttribute('class','answer-comment');
		    	var minuts = d.getMinutes()
		    	if(minuts < 10)
		    	minuts = '0'+minuts;
		    	new_comment_div.innerHTML = '<div class="answer-name-n-date"><span class="answer-name">'+name+'</span><span class="answer-date">'+d.getHours()+':'+minuts+'</span></div><p>'+text_show+'</p><div class="answer-comment-toolbar"><a style="display:none;" href="#" class="answer-reply">Ответить</a></div>';	    
		 
		    	parent_div.appendChild(new_comment_div);
		    	document.getElementById('answers_box_id').style.display = 'block';
//		    	alert('4');

		    	return;
		    
		    
}
else if(self.xmlHttpReq.responseText ==2){
//alert('5');

		 		document.getElementById('news-add-comment').value = '';
		    	var parent_div = document.getElementById('parrent_comment_box');
		    	var new_comment_div = document.createElement('div');
		    			    				    	
		    	var d = new Date();
		    	
		    	new_comment_div.setAttribute('class','answer-comment');
		    	var minuts = d.getMinutes()
		    	if(minuts < 10)
		    	minuts = '0'+minuts;
		    	new_comment_div.innerHTML = '<div class="answer-name-n-date"><span class="answer-name">'+name+'</span><span class="answer-date">'+d.getHours()+':'+minuts+'</span></div><p>'+text_show+'</p><div class="answer-comment-toolbar"><a style="display:none;" href="#" class="answer-reply">Ответить</a></div>';	    
		    	parent_div.appendChild(new_comment_div);
		    	document.getElementById('answers_box_id').style.display = 'block';
//		    	alert('6');

		    	return;		    

}
		    else if(self.xmlHttpReq.responseText ==3){
//		    alert('7');

		    	document.getElementById('error').innerHTML = '<span class="error-tail"></span><span class="error-note-icon"></span>Произошла ошибка, попробуйте добавить свой комментарий позже.</a>.';
		    	document.getElementById('error').style.display = 'block';	    
		    	return;
	
}	
}
}
self.xmlHttpReq.send(checkStr);	
}
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

    self.xmlHttpReq.open('POST', './../../../news/login_handler.php', true);
    self.xmlHttpReq.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    self.xmlHttpReq.onreadystatechange = function() {
        if (self.xmlHttpReq.readyState == 4 && self.xmlHttpReq.status == 200) {
		    if(self.xmlHttpReq.responseText ==1){
	
			var us_com_1 = document.getElementsByName('answer-toolbar-'+user_id);
			for(i=0; i<=us_com_1.length;i++){
			if(us_com_1[i])
			us_com_1[i].innerHTML = '<a style="display:none;" href="#" class="answer-reply">Ответить</a>';
			
			}
			
			user_id = '';
			name = '';
			show = true;
			document.getElementById('q-toolbar-<?php echo $question['user_id']; ?>').innerHTML = '';
			document.getElementById('name-p').innerHTML = '';
			document.getElementById('switcher').style.display = 'none';
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

  
  
function edit_answer(){
	return;	
} 

  

</script>
</head>


<body>
<nav>
	<ul>
		<li><a href="http://macilove.com/news/" id="logo"></a></li>
		<li><a href="http://macilove.com/news/">Новости</a></li>
		<li><a href="http://macilove.com/questions/" id="active">Форум</a></li>
		<li><a href="http://macilove.com/books/">Книги</a></li>
		<li><a href="http://macilove.com/video/">Видео</a></li>
		<li><a href="http://macilove.com/russian-mac-developers/">Mac разработчики</a></li>
		<li id="search"><input type="search" placeholder="Поиск"></li>
	</ul>
</nav>
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
	<div>
	<button type="button" onclick="registraion()">Зарегистрироваться</button>
	</div>
	</form>
	</span>
	<span id="span-box-log" style="display: none;">
	<form name="login_form">
	<input id="login_email" onkeydown="if (event.keyCode == 13) login()"  type="email" placeholder="Email" autofocus="" title="Email">
	<input id="login_pass" onkeydown="if (event.keyCode == 13) login()"  type="password" placeholder="Пароль" title="Пароль">
	<button type="button" onclick="login()">Войти</button>
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


<div id="main-bg" class="wrapper answers-bg">
	<div class="answers-top">
		<h1>Форум вопросов и ответов по Apple устройствам</h1>
		<div class="answers-search">
		</div>
<!-- 		<a href="http://macilove.com/questions/ask/" class="ask-question-link">Задать вопрос в форум</a> -->
	</div>


<div class="answers-index-sep"></div>
	
	<div class="answer-index-row">
		<div class="answers-category">
			<a href="../../<?php echo $cat_url; ?>/">
				<div class="<?php echo $img_class; ?>">
				</div>
				<h2><?php echo $type; ?></h2>
				<div class="all-questions-counter">
					 Все вопросы: <?php echo $type_num; ?>
				</div>
			</a>
		</div>
		
	
<div class="question-text-box">
			<h1><?php echo $title; ?></h1>
			<p class="question-text">
			<?php echo $text; ?></p>
			
			<div class="question-bottom-toolbar">
				<span class="question-text-by">
					<?php echo $name; ?>	
				</span>			
				<span id="q-toolbar-<?php echo $question['user_id']; ?>">
				<?php echo $edit_question; ?>
				</span>
				<span class="question-date">
					<?php echo $info_date; ?>		
				</span>
			</div>
			
		</div>
	</div>

<div class="all-answers-box">

<div id="candy-yandex-forum">
<!-- Яндекс.Директ -->
<div id="yandex_ad"></div>
<script type="text/javascript">
(function(w, d, n, s, t) {
    w[n] = w[n] || [];
    w[n].push(function() {
        Ya.Direct.insertInto(113966, "yandex_ad", {
            stat_id: 3,
            ad_format: "direct",
            font_size: 0.8,
            type: "horizontal",
            border_type: "block",
            limit: 1,
            title_font_size: 1,
            site_bg_color: "FFFFFF",
            header_bg_color: "FEEAC7",
            border_color: "FBE5C0",
            title_color: "0088CC",
            url_color: "006600",
            text_color: "000000",
            hover_color: "0066FF",
            favicon: true,
            no_sitelinks: false
        });
    });
    t = d.documentElement.firstChild;
    s = d.createElement("script");
    s.type = "text/javascript";
    s.src = "http://an.yandex.ru/system/context.js";
    s.setAttribute("async", "true");
    t.insertBefore(s, t.firstChild);
})(window, document, "yandex_context_callbacks");
</script>
</div>

	
		<div class="all-answers" id="parrent_comment_box">
			<h2>Ответы</h2>
	
		<?php echo $answer; ?>
		</div>
		
		
<div class="add-answer-box">
			<div class="add-answer">
				<div id="switcher" <?php echo $name_disp_none; ?>>
					<span id="name-p"><?php echo $user['name']; ?><span class="sep">|</span><a href="javascript:log_out()" id="exit">Выход</a></span>
				</div>
				
				<input name="comment_update" type="hidden" id="comments-hidden" value="0">
				<form name="answer_form">
				<textarea name="text" id="news-add-comment" class="input" maxlength="5000" placeholder="Ваш ответ"></textarea>
				</form>
				
				<p id="error" class="error-note ask-error"><span class="error-note-icon"></span>Не удалось добавить ответ, отсутствует связь с сервером. Пожалуйста повторите попытку снова.</p>
				
				<button onclick="add_answer()" class="blue-button">Добавить</button>
				<span class="ask-question-note">Подсказка: чтобы вставить изображение просто укажите в тексте ссылку на картинку.</span>
				 <p id="error" class="error-note ask-error" style="display:none;"><span class="error-tail"></span><span class="error-note-icon"></span>Не удалось добавить ответ, отсутствует связь с серверо.</p>
			</div>


</div>
	</div>
	</div>
	
	
	</div>
	</div>
					
<footer class="wrapper">
	<ul>
		<li class="copy">© 2013 Macilove.com</li>
		<li><a href="http://macilove.com/about/">О нас</a></li>
		<li class="sep">&middot;</li>
		<li><a href="http://macilove.com/feedback/">Обратная связь</a></li>
		<li class="sep">&middot;</li>
		<li><a href="http://twitter.com/macilove_com" rel="nofollow">Twitter</a></li>
		<li class="sep">&middot;</li>
		<li><a href="http://facebook.com/macilovecom" rel="nofollow">Facebook</a></li>
		<li class="sep">&middot;</li>
		<li><a href="http://macilove.com/use-of-cookies/">Использование cookies</a></li>
		<li class="sep">&middot;</li>
		<li><a href="http://macilove-com.tumblr.com/" rel="nofollow">Блог</a></li>
		<li class="sep">&middot;</li>
		<li><a href="http://macilove.com/rss/">RSS</a></li>
	</ul>	
</footer>			

<div id="made-on-mac" class="wrapper">
	<a href="http://store.apple.com/" id="made-on-a-mac-icon" target="_blank" rel="nofollow"></a>
</div>

</body>
</html>