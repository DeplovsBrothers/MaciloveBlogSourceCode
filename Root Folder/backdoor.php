<?php

if(!empty($_POST['submit']))
{

if($_POST['pass']=='yourPass'){


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