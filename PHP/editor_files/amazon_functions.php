<?php 


if(!isset($_COOKIE['admmacilove']) AND $_COOKIE['admmacilove'] != 111111){
	header("Location: http://macilove.com");
}


$aws_key = 'AKIAI744XO4CWDPNCNOQ';
$aws_secret = '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';


// Sending HTTP query and receiving, with trivial keep-alive support
function sendREST($fp, $q, $debug = false)
{
    if ($debug) echo "\nQUERY<<{$q}>>\n";

    fwrite($fp, $q);
   
    $r = '';
    $check_header = true;
    while (!feof($fp)) {
        $tr = fgets($fp, 256);
        if ($debug) echo "\nRESPONSE<<{$tr}>>"; 
        $r .= $tr;

        if (($check_header)&&(strpos($r, "\r\n\r\n") !== false))
        {
            // if content-length == 0, return query result
            if (strpos($r, 'Content-Length: 0') !== false)
                return $r;
        }

        // Keep-alive responses does not return EOF
        // they end with \r\n0\r\n\r\n string
        if (substr($r, -7) == "\r\n0\r\n\r\n")
            return $r;
    }
    return $r;

}

// hmac-sha1 code START
// hmac-sha1 function:  assuming key is global $aws_secret 40 bytes long
// read more at http://en.wikipedia.org/wiki/HMAC
// warning: key($aws_secret) is padded to 64 bytes with 0x0 after first function call 


// helper function binsha1 for amazon_hmac (returns binary value of sha1 hash)    
function binsha1($d) { return sha1($d, true); }


function amazon_hmac($stringToSign) 
{

    global $aws_secret;

    if (strlen($aws_secret) == 40)
        $aws_secret = $aws_secret.str_repeat(chr(0), 24);

    $ipad = str_repeat(chr(0x36), 64);
    $opad = str_repeat(chr(0x5c), 64);

    $hmac = binsha1(($aws_secret^$opad).binsha1(($aws_secret^$ipad).$stringToSign));
    return base64_encode($hmac);
}



function upload_to_s3($file_url, $file_name,$fp,$aws_key, $public = false)
{

if($public)
$public_read = 
'x-amz-acl:public-read
x-amz-storage-class:REDUCED_REDUNDANCY';
else
	$public_read ='x-amz-storage-class:REDUCED_REDUNDANCY';

	

	$aws_object = $file_name; 
	$aws_bucket = 'macilove-images'; // AWS bucket 

	$ftype = explode('.', $file_url);
	$i = 0;
	while($ftype[$i] != '')
	{
		$i++;
	}
	$i--;
	
	$ftype = $ftype[$i];
	
	switch($ftype){
		case 'jpg':
		$file_type = "image/jpeg";
		break;
		case 'png':
		$file_type = "image/png";
		break;
		case 'gif':
		$file_type = "image/gif";
		break;
		case 'JPG':
		$file_type = "image/JPEG";
		break;
		case 'PNG':
		$file_type = "image/PNG";
		break;
		case 'GIF':
		$file_type = "image/GIF";
		break;
		default:
		$file_type = "image/jpeg";
		break;
		
	}
	
	
	
	
	$file_data = file_get_contents($file_url);
	if ($file_data == false) die("Failed to read file ".$file_url);
	
	$dt = gmdate('r'); // GMT based timestamp
	
	$file_length = strlen($file_data); // for Content-Length HTTP field 
	
	
$string2sign = "PUT

{$file_type}
{$dt}
$public_read
/{$aws_bucket}/news/{$aws_object}";


// preparing HTTP PUT query
$query = "PUT /news/{$aws_object} HTTP/1.1
Content-Type: {$file_type}
Content-Length: {$file_length}
Host: $aws_bucket.s3-eu-west-1.amazonaws.com
Date: $dt
$public_read
Cache-control:max-age=1296000
Connection: keep-alive
Authorization: AWS {$aws_key}:".amazon_hmac($string2sign)."\n\n";


$query .= $file_data;


sendREST($fp, $query);
	
	
	$filesaved_as = "http://s3-eu-west-1.amazonaws.com/{$aws_bucket}/news/{$aws_object}";
	return 	$filesaved_as;

}



$fp = fsockopen("s3-eu-west-1.amazonaws.com", 80, $errno, $errstr, 30);
if (!$fp) {
    die("$errstr ($errno)\n");
}


//Example of use
//echo upload_to_s3('http://macilove.com/images/ivi_ru-present-the-free-movie-steve-jobs-the-lost-interview-0.jpg', 'ivi_ru-present-the-free-movie-steve-jobs-the-lost-interview-0.jpg',$fp,$aws_key);	
	
	
	
?>