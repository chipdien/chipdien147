<?php
define('IN_MEDIA',true);
include dirname(__FILE__).'/inc/init.php';
include dirname(__FILE__).'/inc/functions.php';

if (!$_SESSION['id']) {
    header("Location: login.php");
    exit();
}
//global $smarty, $DB, $ExpQuest;

// $hook_sidebars = array();

$userid = $_SESSION['id'];

// Nav
$smarty->assign('currMenu', getCurrentPage());

// Sidebar
$emperorinfo = $DB->GetRow("SELECT a.EmperorName, b.Level, b.TransformWorkTimes, b.FavorName, b.Gender, b.Icon, a.OfficialPos, a.Reputation, a.League FROM `emperorinfo` as a, `citygeneralinfo` as b WHERE a.userid = '".$userid."' AND a.emperorname = b.showname ");
$emperorinfo['OfficialGrade'] = $DB->GetOne("SELECT b.grade FROM emperorinfo as a, officialposinfo as b WHERE (a.officialpos = b.name) AND (a.userid = '$userid') ");
$smarty->assign('emperor', $emperorinfo);


// Phan thuong thanh danh
$present1 = present_count($userid, $OfficalPos, $OfficalMoney);
$smarty->assign('present1',$present1);

    // Da dang nhap
//    $is_logged_in = true;
//    $userid = $_SESSION['id'];

    // Maincontent
    // Phan thuong quan chuc
//    $view = 'present.tpl';

    /*
    // Phan thuong thanh danh
    $bag = $DB->Execute("SELECT count(*) as maxinbag FROM `playerbagequipinfo` WHERE userid='2000001' AND goodsid='7156' ");
    if($bag->fields['maxinbag'] < 4)
        $errmsg = "Bạn hãy gửi thông điệp này đến GM: 'Trụ Vương đã khánh kiệt!' "; 
    if ($errmsg) {
        $smarty->assign('QuestOff', $errmsg);
    } else {
        $smarty->assign('ExpQst', $ExpQuest);
        $present2 = $DB->GetRow("SELECT a.ReputationUse, a.ReputationLog, b.Reputation FROM `alluser_copy` as a, `emperorinfo` as b WHERE a.userid='".$_SESSION['id']."' AND a.userid=b.userid ");
        $present2['finishQuest'] = unserialize($present2['ReputationLog']);
        $present2['repValue'] = $present2['Reputation'] - $present2['ReputationUse'];						
        $smarty->assign('present2',$present2);
    }
*/
    
//$smarty->assign('hook_sidebar', $hook_sidebars);
$smarty->assign('view', 'present.tpl'); 
$smarty->assign('is_logged_in', true);
$smarty->display('index.tpl');

?>
