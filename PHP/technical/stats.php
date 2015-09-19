<?php
include("./../config.inc.php");
include("./../make_sitemap.php");	
	
$link = mysql_connect($DBSERVER, $DBUSER, $DBPASS);
mysql_select_db($DB, $link) or die ("Can't select DB");




if(!isset($_COOKIE['admmacilove']) AND $_COOKIE['admmacilove'] != 111111){
	header("Location: http://macilove.com");
}


function count_words($str){

    while (substr_count($str, "  ")>0){
        $str = str_replace("  ", " ", $str);
    }
    return substr_count($str, " ")+1;
}

/*
for($y_count=1; $y_count <=3; $y_count++)
{ 
*/
	$y_count = 3;
	for($count = 1;$count<=12 ;$count++){
		if($count<10)
		{
			$c = "0".$count;
		}	
		else
			$c = $count;
		
		$get_files_q = mysql_query("SELECT `id` FROM `content` WHERE `draft`=1 AND `pub_date` LIKE '201".$y_count."-".$c."%'");
	
		echo "<br /><br />Year 201$y_count month $c<br />";
		
			$body_length = 0;
			$num_of_art = 0;
			for ($cnt = 0; $content = mysql_fetch_assoc($get_files_q); $cnt++){
				
				if(!empty($content))
				{
					$num_of_art++;
					
$q = mysql_query("SELECT `title` FROM `content` WHERE `id`=".$content["id"]);
					$body = mysql_fetch_array($q);
					$body = $body[0];
					$body = strip_tags($body);
					//echo str_word_count($body)." $body";
					//echo "<br />";
					$body_length += count_words($body);

				
				}
					
			}
	
		echo "Avearge content size: ".$body_length / $num_of_art;
	}

//}

/*
for ($count = 0; $content = mysql_fetch_assoc($get_files_q); $count++){
		
		echo "month<br/>";
		print_r($content);
	}
*/


//SELECT COUNT(value_column) FROM table WHERE date_column LIKE '2010-01-%' GROUP BY date_column











?>
