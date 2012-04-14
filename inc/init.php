<?php
if (!defined('IN_MEDIA')) die("Hack");
include dirname(__FILE__).'/config.php';

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

// Init Smarty 
require(DIR_SMARTY.'/Smarty.class.php');
$smarty = new Smarty;
$smarty->setTemplateDir(DIR_ROOT.'/templates/');
$smarty->setCompileDir(DIR_SMARTY.'/templates_c/');
$smarty->setConfigDir(DIR_SMARTY.'/configs/');
$smarty->setCacheDir(DIR_ROOT.'/cache/');
$smarty->force_compile = true;
$smarty->debugging = false;
$smarty->caching = false;
$smarty->cache_lifetime = 120;

// Init Adodb
include(DIR_ADODB.'/adodb.inc.php');
$DB = NewADOConnection('mysql');
$DB->Connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$DB->Execute("SET NAMES 'utf8'");

// Maintaince Mode
if (MAINTAINCE || !$DB->IsConnected()) {
	echo "<h1 style='margin-top: 40px; text-align:center; width: 100%;'>May chu hien dang trong tinh trang bao tri.<br/>
	Xin ban vui long tro lai sau!</h1>";
	exit;
}

/*
include 'inc/db.php';
$db = new Database(DB_HOST, DB_USER, DB_PASS, DB_NAME);
//$db = new Database('localhost', 'root', '', '#mysql50#fswd-scgy');
$db->connect();
$db->query("SET NAMES 'utf8'");
*/

?>
