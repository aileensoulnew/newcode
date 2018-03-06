<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');

if($_SERVER['HTTP_HOST'] == 'localhost' || $_SERVER['SERVER_ADDR'] == '127.0.0.1'){
	$db_host 	 = 'localhost';
	$db_user 	 = 'root';
	$db_password = '';
	$db_name 	 = 'laceberry';
        
    define('SITEURL','http://localhost/aileensoul-new/');
	define('SITEPATH',$_SERVER['DOCUMENT_ROOT'].'/aileensoul/');
	define('SITEMAPPATH',$_SERVER['DOCUMENT_ROOT'].'/laceberry/');
	define('NEWSITEURL','http://localhost/laceberry/');
	define('NEWSITEPATH',$_SERVER['DOCUMENT_ROOT'].'/laceberry/');
	error_reporting(0);
}
else
{
	$db_host 	 = 'localhost';
	$db_user 	 = 'alael_elalanew';
	$db_password = '_PcEefMObeyP';
	$db_name 	 = 'alael_elalanew';
	
	$sitenewpath = str_split($_SERVER['DOCUMENT_ROOT'],23);
	
	define('SITEURL','https://www.aileensoul.com/');
	define('NEWSITEURL','http://laceberry.in/live/');
	define('SITEPATH',$sitenewpath[0].'/aileensoul/');
	define('NEWSITEPATH',$_SERVER['DOCUMENT_ROOT'].'/');
	define('SITEMAPPATH',$_SERVER['DOCUMENT_ROOT'].'/live/');
	error_reporting(0);
}

date_default_timezone_set('Asia/Kolkata');
header('Cache-Control: max-age=900');
define('DOCTYPE','<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">');
define('XMLNS','<html xmlns="http://www.w3.org/1999/xhtml">');
define('CONTENTTYPE','<meta http-equiv="content-type" content="text/html; charset=utf-8" /><link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">
<link rel="icon" href="images/favicon.png" type="image/x-icon">');
define('SITETITLE','Seller Desk');
define('SITEIMGURL',SITEURL.'storepanel/');

define('RECIMAGE',SITEPATH.'uploads/recruiter');


$current_date = date('Y-m-d H:i:s');
$date	= $current_date;
$year	= date('y', strtotime($date));
$month	= date('m', strtotime($date));
$hour	= date('H', strtotime($date));
$minute	= date('i', strtotime($date));
$sec	= date('s', strtotime($date));





$current_date = date('Y-m-d H:i:s');

$CURRENT_MONTH = date("m"); 

$CURRENT_YEAR = date("y");


$time	=	array(
						'1' => '1:00',
						'2' => '2:00',
						'3' => '3:00',
						'4' => '4:00',
						'5' => '5:00',
						'6' => '6:00',
						'7' => '7:00',
						'8' => '8:00',
						'9' => '9:00',
						'10' => '10:00',
						'11' => '11:00',
						'12' => '12:00',
						'13' => '13:00',
						'14' => '14:00',
						'15' => '15:00',
						'16' => '16:00',
						'17' => '17:00',
						'18' => '18:00',
						'19' => '19:00',
						'20' => '20:00',
						'21' => '21:00',
						'22' => '22:00',
						'23' => '23:00',
						'24' => '24:00'
);				  			


if($_SERVER['HTTP_HOST'] == 'localhost' || $_SERVER['SERVER_ADDR'] == '127.0.0.1'){

	 error_reporting(0);
}
else
{
	error_reporting(0);
}
  			
define('NOIMAGE', 'uploads/avatar.png');
define('WHITEIMAGE', 'uploads/white.png');

define('PROFILENA', '--');


// GOVERMENT MAIN IMAGE
    define('GOV_MAIN_UPLOAD_URL', SITEURL . 'uploads/goverment/main/');

// GOVERMENT THUMB THUMB
    define('GOV_THUMB_UPLOAD_URL', SITEURL . 'uploads/goverment/thumbs/');

// GOVERMENT CATEGORY MAIN
    define('GOV_CAT_UPLOAD_URL', SITEURL . 'uploads/gov_cate_icon/');

// GOVERMENT CATEGORY  NOMAIN
    define('GOV_CAT_NOUPLOAD', SITEURL . 'uploads/gov_cate_icon/agj.png');