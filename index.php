<?php
/*session_start();
if(!isset($_SESSION['umami'])) {
	header('Location: https://umamisquare.com/umami');
	exit;
}*/   

//phpinfo();exit;
/*@include("Mobile_Detect.php");
$detect = new Mobile_Detect();
if ($detect->isMobile() && isset($_COOKIE['mobile'])){
$detect = "false";
}elseif ($detect->isMobile()){
	$str = "$_SERVER[REQUEST_URI]";
	$actual_link=str_replace('/eCommerce', 'm.eCommerce', $str);
	header("Location:http://ecomm.aqualeafitsol.com/".$actual_link);exit;
}*/
/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * @package  Laravel
 * @author   Taylor Otwell <taylor@laravel.com>
 */

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

// This file allows us to emulate Apache's "mod_rewrite" functionality from the
// built-in PHP web server. This provides a convenient way to test a Laravel
// application without having installed a "real" web server software here.
if ($uri !== '/' && file_exists(__DIR__.'/public'.$uri)) {
    return false;
}

require_once __DIR__.'/public/index.php';
