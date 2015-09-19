<?php
@include_once("config.inc.php");
@include_once("functions.inc.php");
$link = mysql_connect($DBSERVER, $DBUSER, $DBPASS)
or die("Can't connect" );
mysql_select_db($DB, $link) or die ("Can't select DB");

//error_reporting(E_ALL); ini_set('display_errors','1'); 
//cron
//
//00 */12 * * * /usr/bin/php5 /var/www/macilove.com/make_sitemap.php


function make_sitemap()
{


$xml = '<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
		xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">';



$an_q = mysql_query("SELECT UNIX_TIMESTAMP(`pub_date`) FROM `content` WHERE `draft`=1 ORDER BY `id` DESC LIMIT 1");
$an_last_all = mysql_fetch_array($an_q);

$an_n_q = mysql_query("SELECT UNIX_TIMESTAMP(`pub_date`) FROM `content` WHERE `draft`=1 AND `categories`=0 ORDER BY `id` DESC LIMIT 1");
$an = mysql_fetch_array($an_n_q);

$an_acc_q = mysql_query("SELECT UNIX_TIMESTAMP(`pub_date`) FROM `content` WHERE `draft`=1 AND `categories`=13 ORDER BY `id` DESC LIMIT 1");
$an_acc = mysql_fetch_array($an_acc_q);

$ios_q = mysql_query("SELECT UNIX_TIMESTAMP(`pub_date`) FROM `content` WHERE `draft`=1 AND `categories`=3 ORDER BY `id` DESC LIMIT 1");
$ios = mysql_fetch_array($ios_q);

$iphg_q = mysql_query("SELECT UNIX_TIMESTAMP(`pub_date`) FROM `content` WHERE `draft`=1 AND `categories`=1 ORDER BY `id` DESC LIMIT 1"); 
$iphg = mysql_fetch_array($iphg_q);

$ipag_q = mysql_query("SELECT UNIX_TIMESTAMP(`pub_date`) FROM `content` WHERE `draft`=1 AND `categories`=3 ORDER BY `id` DESC LIMIT 1"); 
$ipag = mysql_fetch_array($ipag_q);

$ios_apps_q = mysql_query("SELECT UNIX_TIMESTAMP(`pub_date`) FROM `content` WHERE `draft`=1 AND `categories`=6 ORDER BY `id` DESC LIMIT 1"); 
$ios_apps = mysql_fetch_array($ios_apps_q);

$ios_apps_for_iphone_q = mysql_query("SELECT UNIX_TIMESTAMP(`pub_date`) FROM `content` WHERE `draft`=1 AND `categories`=4 ORDER BY `id` DESC LIMIT 1"); 
$ios_apps_iphone = mysql_fetch_array($ios_apps_for_iphone_q);

$ios_apps_for_ipad_q = mysql_query("SELECT UNIX_TIMESTAMP(`pub_date`) FROM `content` WHERE `draft`=1 AND `categories`=5 ORDER BY `id` DESC LIMIT 1"); 
$ios_apps_ipad = mysql_fetch_array($ios_apps_for_ipad_q);



$mac_g_and_a_q = mysql_query("SELECT UNIX_TIMESTAMP(`pub_date`) FROM `content` WHERE `draft`=1 AND (`categories`=7 OR `categories`=8) ORDER BY `id` DESC LIMIT 1"); 
$mac_g_and_a = mysql_fetch_array($mac_g_and_a_q);

$mac_a_q = mysql_query("SELECT UNIX_TIMESTAMP(`pub_date`) FROM `content` WHERE `draft`=1 AND `categories`=7 ORDER BY `id` DESC LIMIT 1"); 
$mac_a = mysql_fetch_array($mac_a_q);

$mac_g_q = mysql_query("SELECT UNIX_TIMESTAMP(`pub_date`) FROM `content` WHERE `draft`=1 AND `categories`=8 ORDER BY `id` DESC LIMIT 1"); 
$mac_g = mysql_fetch_array($mac_g_q);

$sec_mac_ios_q = mysql_query("SELECT UNIX_TIMESTAMP(`pub_date`) FROM `content` WHERE `draft`=1 AND (`categories`=9 OR `categories`=10) ORDER BY `id` DESC LIMIT 1"); 
$sec_mac_ios = mysql_fetch_array($sec_mac_ios_q);

$sec_mac_q = mysql_query("SELECT UNIX_TIMESTAMP(`pub_date`) FROM `content` WHERE `draft`=1 AND `categories`=10 ORDER BY `id` DESC LIMIT 1"); 
$sec_mac = mysql_fetch_array($sec_mac_q);

$sec_ios_q = mysql_query("SELECT UNIX_TIMESTAMP(`pub_date`) FROM `content` WHERE `draft`=1 AND `categories`=9 ORDER BY `id` DESC LIMIT 1"); 
$sec_ios = mysql_fetch_array($sec_ios_q);



//$ad_q = mysql_query("SELECT UNIX_TIMESTAMP(`adv_date`) FROM `advertising` WHERE `sold`=0 ORDER BY `id` DESC LIMIT 1"); 
//$ad = mysql_fetch_array($ad_q);


$xml .= "<url><loc>http://macilove.com/news/</loc><lastmod>".date('Y-m-d',$an_last_all[0])."</lastmod><changefreq>hourly</changefreq><priority>1.0</priority></url><url><loc>http://macilove.com/news/apple-news/</loc><lastmod>".date('Y-m-d',$an[0])."</lastmod><changefreq>hourly</changefreq><priority>0.9</priority></url><url><loc>http://macilove.com/news/apple-accessories-reviews/</loc><lastmod>".date('Y-m-d',$an_acc[0])."</lastmod><changefreq>weekly</changefreq><priority>0.7</priority></url><url><loc>http://macilove.com/news/games-for-ios/</loc><lastmod>".date('Y-m-d',$ios[0])."</lastmod><changefreq>daily</changefreq><priority>0.9</priority></url><url><loc>http://macilove.com/news/games-for-iphone/</loc><lastmod>".date('Y-m-d',$iphg[0])."</lastmod><changefreq>daily</changefreq><priority>0.8</priority></url><url><loc>http://macilove.com/news/games-for-ipad/</loc><lastmod>".date('Y-m-d',$ipag[0])."</lastmod><changefreq>daily</changefreq><priority>0.8</priority></url><url><loc>http://macilove.com/news/apps-for-ios/</loc><lastmod>".date('Y-m-d',$ios_apps[0])."</lastmod><changefreq>daily</changefreq><priority>0.9</priority></url><url><loc>http://macilove.com/news/apps-for-iphone/</loc><lastmod>".date('Y-m-d',$ios_apps_iphone[0])."</lastmod><changefreq>daily</changefreq><priority>0.8</priority></url><url><loc>http://macilove.com/news/apps-for-ipad/</loc><lastmod>".date('Y-m-d',$ios_apps_ipad[0])."</lastmod><changefreq>daily</changefreq><priority>0.8</priority></url><url><loc>http://macilove.com/news/apps-and-games-for-mac-os-x/</loc><lastmod>".date('Y-m-d',$mac_g_and_a[0])."</lastmod><changefreq>daily</changefreq><priority>0.9</priority></url><url><loc>http://macilove.com/news/apps-for-mac-os-x/</loc><lastmod>".date('Y-m-d',$mac_a[0])."</lastmod><changefreq>daily</changefreq><priority>0.8</priority></url><url><loc>http://macilove.com/news/games-for-mac-os-x/</loc><lastmod>".date('Y-m-d',$mac_g[0])."</lastmod><changefreq>daily</changefreq><priority>0.8</priority></url><url><loc>http://macilove.com/news/tricks-and-secrets-mac-os-x-ios/</loc><lastmod>".date('Y-m-d',$sec_mac_ios[0])."</lastmod><changefreq>daily</changefreq><priority>0.9</priority></url><url><loc>http://macilove.com/news/secrets-mac-os-x/</loc><lastmod>".date('Y-m-d',$sec_mac[0])."</lastmod><changefreq>daily</changefreq><priority>0.8</priority></url><url><loc>http://macilove.com/news/secrets-iphone-ipad/</loc><lastmod>".date('Y-m-d',$sec_ios[0])."</lastmod><changefreq>daily</changefreq><priority>0.8</priority></url><url><loc>http://macilove.com/video/</loc><lastmod>2013-12-08</lastmod><changefreq>weekly</changefreq><priority>0.5</priority></url>";

$apple_news_page_query = mysql_query("SELECT *,UNIX_TIMESTAMP(`pub_date`) FROM `content` WHERE `draft`=1  ORDER BY `id` DESC");


for($i=1;$cont = mysql_fetch_assoc($apple_news_page_query); $i++){



$content = htmlspecialchars($cont['url']);

$xml .= "<url><loc>http://macilove.com/news/".$content."/</loc><lastmod>".date('Y-m-d',$cont['UNIX_TIMESTAMP(`pub_date`)'])."</lastmod><changefreq>daily</changefreq><priority>0.8</priority></url>";

}

$xml .="</urlset>";




//$fp = fopen($doc_root.'http://macilove.com/sitemap.xml', 'w');

$fp = fopen('sitemap.xml', 'w');


fwrite($fp, $xml, strlen($xml));

fclose($fp);


//echo "end";
}


//make_sitemap();



?>