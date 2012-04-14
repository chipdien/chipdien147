<?php
define('IN_MEDIA',true);
include dirname(__FILE__).'/inc/init.php';
include dirname(__FILE__).'/inc/functions.php';

if (!$_SESSION['id']) {
    header("Location: login.php");
    exit();
}

$userid = $_SESSION['id'];
// Nav
$smarty->assign('currMenu', getCurrentPage());

// Sidebar
$emperorinfo = $DB->GetRow("SELECT a.EmperorName, b.Level, b.TransformWorkTimes, b.FavorName, b.Gender, b.Icon, a.OfficialPos, a.Reputation, a.League FROM `emperorinfo` as a, `citygeneralinfo` as b WHERE a.userid = '".$userid."' AND a.emperorname = b.showname ");
$emperorinfo['OfficialGrade'] = $DB->GetOne("SELECT b.grade FROM emperorinfo as a, officialposinfo as b WHERE (a.officialpos = b.name) AND (a.userid = '$userid') ");
$smarty->assign('emperor', $emperorinfo);




$smarty->assign('view', 'profile.tpl'); 
$smarty->assign('is_logged_in', true);
$smarty->display('index.tpl');

?>
