<?php
function my_function()
{

$email = 'okqkt@vidchart.com';

$from ='noreply@macilove.com';

$headers = 'MIME-Version: 1.0' .$n;
$headers .= 'Content-Type: text/html; charset=utf8' .$n;
$headers .= 'From:<'.$from.'>'.$n;
$headers .= 'Date: '. date('D, d M Y h:i:s O') . $n; 


$mailto = "$email";
$subject = "Good news everyone";
$message = nl2br("");


// письмо отсылается на почту
mail($mailto,$subject,$message,$headers, '-f'.$from);



}

?>