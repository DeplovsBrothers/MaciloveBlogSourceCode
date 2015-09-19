<?php 
function checkmail($mail) {
//trim unused symbols and spaces
$mail=trim($mail); 

if (strlen($mail)==0) return -1;// if empty - exit
if (!preg_match("#^[a-z0-9_\.-]+@[a-z0-9\.-]+\.[a-z]{2,6}$#i",$mail))
return -1;
return $mail;
}



function sendmail($mail,$subject,$message,$headers) {

if(mail($mail,$subject,$message,$headers)) { return TRUE;}
else {return FALSE;}

}

function randStr()  
    { 
    	$num = 8;
    	$str = substr(str_shuffle(str_repeat('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789',5)),0,$num);
		return $str;
    } 
    
    
    
    function getLogin($hash) 
    { 
        $getlog = mysql_query("SELECT * FROM `register` WHERE `hash`='".$hash."'"); 
        if(mysql_num_rows($getlog) == 1) 
            return mysql_fetch_assoc($getlog); 	
        else 
            return false; 
    }


function randomChars(){

$min=6; 
$max=8; 
$pwd="";
for($i=0;$i<rand($min,$max);$i++) 

{
$num=rand(48,122); 
if(($num > 97 && $num < 122))
{
$pwd.=chr($num); 
}
else if(($num > 65 && $num < 90))
{
$pwd.=chr($num);
}
else if(($num >48 && $num < 57))
{
$pwd.=chr($num);
}
else if($num==95)
{
$pwd.=chr($num);
}
else
{
$i--;
}
}

 
$password = $pwd;
return ($pwd);
}



function refresh_cookie($cook){
if(!empty($cook))
setcookie('user', $cook, time() + 3600 * 24 * 30, '/');    
else{
$hash = md5(microtime(true));
setcookie('user', $hash, time() + 3600 * 24 * 30, '/');    
mysql_query("INSERT INTO `users` VALUES(null, '".$hash."', null)"); 
}
return 1;
}



function userActivityCallback($type, $url,$question_id,$text)
{

$email = 'deplov@me.com';

$from ='noreply@macilove.com';
$n = "\n";
$headers = 'MIME-Version: 1.0' .$n;
$headers .= 'Content-Type: text/html; charset=utf8' .$n;
$headers .= 'From:<'.$from.'>'.$n;
$headers .= 'Date: '. date('D, d M Y h:i:s O') . $n; 


$mailto = "$email";


switch($type)
{
	case 0:
	$subject = "New comment on Macilove";
	$message = nl2br('http://macilove.com/news/'.$url.'/#comments-box-wrapper<br /><br />'.$text.'');
	break;
	case 1:
	$subject = "New question on Macilove";
	$message = nl2br('http://macilove.com/questions/question/'.$question_id.'/<br /><br />'.$text.'');
	break;
	case 2:
	$subject = "New answer on Macilove";
	$message = nl2br('http://macilove.com/questions/question/'.$question_id.'/<br /><br />'.$text.'');
	break;

}

mail($mailto,$subject,$message,$headers, '-f'.$from);


}





    


?>