<?php

if(!empty($_POST['submit']))
{

if($_POST['pass']=='fila5656'){


setcookie('admmacilove', '111111', time() + 3600 * 24 * 30, '/'); 
header("Location: editor.php");


}
}


?>

<html>
<body>
<form method="post" action="">
<input type="password" name="pass">
<input type="submit" name="submit">
</form>
</body>
</html>