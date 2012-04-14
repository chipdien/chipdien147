<?php

if (!defined('IN_MEDIA')) die("Hack");
include '../inc/config.php';

// Maintaince Mode
if (MAINTAINCE) {
	echo "<h1 style='margin-top: 40px; text-align:center; width: 100%;'>May chu hien dang trong tinh trang bao tri.<br/>
	Xin ban vui long tro lai sau!</h1>";
	exit;
}

// Init Session
if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ob_start('ob_gzhandler');
else ob_start();
@session_start();
header("Content-Type: text/html; charset=UTF-8");
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
if (!ini_get('register_globals')) {
	@$_GET = $HTTP_GET_VARS;
	@$_POST = $HTTP_POST_VARS;
	@$_COOKIE = $HTTP_COOKIE_VARS;
	extract($_GET);
	extract($_POST);
}
define('NOW',time());
define('IP',$_SERVER['REMOTE_ADDR']);
define('USER_AGENT',$_SERVER['HTTP_USER_AGENT']);
define('URL_NOW',$_SERVER["REQUEST_URI"]);
if (!USER_AGENT || !IP) exit();

// Init Adodb
include('../libs/db/adodb.inc.php');
include("../libs/db/adodb-errorpear.inc.php"); 
$DB = NewADOConnection('mysql');
$DB->Connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$DB->Execute("SET NAMES 'utf8'");

?>
