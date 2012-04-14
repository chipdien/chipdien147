<?php
define('IN_MEDIA',true);
include dirname(__FILE__).'/inc/init.php';
include dirname(__FILE__).'/inc/functions.php';

if (!$_SESSION['id']) {
    header("Location: login.php");
    exit();
}
if(isset($_GET['logoff']))
{
    $_SESSION = array();
    session_destroy();
    header("Location: index.php");
    exit();
}

$userid = $_SESSION['id'];

// Nav
$smarty->assign('currMenu', getCurrentPage());

// Sidebar
$emperorinfo = $DB->GetRow("SELECT a.EmperorName, b.Level, b.TransformWorkTimes, b.FavorName, b.Gender, b.Icon, a.OfficialPos, a.Reputation, a.League FROM `emperorinfo` as a, `citygeneralinfo` as b WHERE a.userid = '".$userid."' AND a.emperorname = b.showname ");
$emperorinfo['OfficialGrade'] = $DB->GetOne("SELECT b.grade FROM emperorinfo as a, officialposinfo as b WHERE (a.officialpos = b.name) AND (a.userid = '$userid') ");
$smarty->assign('emperor', $emperorinfo);


// Phan thuong tan thu 
$newbiePresent = $DB->GetOne("SELECT NewbiePresent FROM alluser_copy WHERE userid = '".$userid."' ");
if ($newbiePresent)
    $smarty->assign('NewbiePresent', FALSE);
else
    $smarty->assign('NewbiePresent', TRUE);



//$db->close();

/*
require './init.php';
require('./functions.php');
global $smarty, $DB;

$hook_sidebars = array();

if (!$_SESSION['id']) :
    // Chua dang nhap
    $is_logged_in = false;
    include('./post_login.php');
    if($_GET['act'] == 'reg') $view = 'register.tpl';
    else $view = 'login.tpl';
    
    
else :
    // Da dang nhap
    $is_logged_in = true;
    $userid = $_SESSION['id'];

    // Sidebar
    $emperorinfo = $DB->GetRow("SELECT a.EmperorName, b.Level, b.TransformWorkTimes, b.FavorName, b.Gender, b.Icon, a.OfficialPos, a.Reputation, a.League FROM `emperorinfo` as a, `citygeneralinfo` as b WHERE a.userid = '".$userid."' AND a.emperorname = b.showname ");
    $emperorinfo['OfficialGrade'] = $DB->GetOne("SELECT b.grade FROM emperorinfo as a, officialposinfo as b WHERE (a.officialpos = b.name) AND (a.userid = '$userid') ");
    $smarty->assign('emperor', $emperorinfo);
    
    // Maincontent
    if (!isset($_GET['mod'])) $module = 'main'; else $module = $_GET['mod'];
    $view = $module.'.tpl';
    
    if(file_exists('./configs/config_'.$module.'.php'))        
        include './config/ocnfig_'.$module.'.php';
    
    if(file_exists('./includes/mod_'.$module.'.php'))        
        include './includes/mod_'.$module.'.php';
    
    /*
    switch($_GET['mod'])
    {
        case 'profile': $view = 'profile.tpl'; 
                        $profile['email'] = $DB->GetOne("SELECT Recommender FROM alluser WHERE UserId = '".$_SESSION['id']."' ");
                        $profile['requestname'] = $DB->GetOne("SELECT data2 FROM gm_request WHERE userid = '".$_SESSION['id']."'  ");
                        $smarty->assign('profile', $profile);
                        break;
                    
        case 'present': $view = 'present.tpl';
                        include('./configs/config_present.php');

                        // Phan thuong quan chuc
                        $present1 = present_count($_SESSION['id']);
                        $smarty->assign('present1',$present1);

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
                        break;
                        
        case 'market':	$view = 'market.tpl';
                        include('./configs/config_market.php');
                        $i = 0;
                        foreach ($items_allow as $k => $v) {
                            if ($i <> 0) $items_trade .= ',';
                            $items_trade .= $k;    
                            $i++;
                        }
                        $i = 0; $j = 0;
                        foreach ($Event01 as $k=>$event){
                            foreach ($event['in'] as $item){
                                if ($i <> 0) $items_event1 .= ',';
                                if ($j <> 0) $itemslist[$k] .= ',';
                                $items_event1 .= $item['id'];
                                $itemslist[$k] .= $item['id'];
                                $i++; $j++;
                            }
                            foreach ($event['out'] as $item){
                                $itemslist[$k] .= ','.$item['id'];
                                $itemout[$k] = $item['id'];
                            }
                            $j = 0;
                        }
                        $rs = $DB->Execute("SELECT GoodsID, Num FROM `playerbaggoodsinfo` WHERE `goodsid` IN ($items_trade) AND `userid` = '".$_SESSION['id']."' ORDER BY goodsid ASC ");
                        $rows = $rs->GetRows(); 
                        $rs = $DB->Execute("SELECT GoodsID, Num FROM `playerbaggoodsinfo` WHERE `goodsid` IN ($items_event1) AND `userid` = '".$_SESSION['id']."' ORDER BY goodsid ASC ");
                        $rows2 = $rs->GetRows(); 
                        foreach ($rows2 as $item){
                            $invent[$item['GoodsID']] = $item['Num'];
                        }
                        //print_r($invent);exit;
                        $smarty->assign("event1",$Event01);
                        $smarty->assign("event1_items",$itemslist);
                        $smarty->assign("event1_out", $itemout);
                        $smarty->assign("event1inv", $invent);
                        $smarty->assign('goodids',$rows);
                        $smarty->assign('itemlist',$items_allow);
                        break;
                        
        case 'famouscity': $view = 'famouscity.tpl';

                        break;
                    
        case 'modcp':	require('./configs/config_modcp.php');
                        if (is_mod($_SESSION['id'])) {
                            $addsidebars = array('title' => 'Quản lý thành viên', 'body' => array(
                                                array('title' => 'Đổi mật khẩu', 'act' => 'change.password'),
                                                array('title' => 'Xem thông tin', 'act' => 'view.account'),
                                                ));
                            $addsidebars_present = array('title' => 'Quản lý quà tặng', 'body' => array(

                                                array('title' => 'Nhóm tặng phẩm', 'act' => 'add.actgroup'),
                                                array('title' => 'Cài đặt tặng phẩm', 'act' => 'add.action'),
                                                array('title' => 'Thực hiện trao thưởng', 'act' => 'add.doaction'),
                                                )); 
                            $hook_sidebars[] = $addsidebars;
                            $hook_sidebars[] = $addsidebars_present;	
                            if(isset($_GET['act'])) {
                                $file = explode('.', $_GET['act']);
                                $view = "modcp_".$file[0]."_".$file[1].".tpl";
                            } else $view = 'modcp.tpl';	   
                        } else {
                            $view = 'error.tpl';
                        }
                        break;
                   
        
        case 'dev':	require('./configs/config_dev.php');
                        if (is_mod($_SESSION['id'])) {
                            $addsidebars = array('title' => 'Quản lý thành viên', 'body' => array(
                                                array('title' => 'Đổi mật khẩu', 'act' => 'change.password'),
                                                array('title' => 'Xem thông tin', 'act' => 'view.account'),
                                                ));
                            $addsidebars_present = array('title' => 'Quản lý quà tặng', 'body' => array(

                                                array('title' => 'Nhóm tặng phẩm', 'act' => 'add.actgroup'),
                                                array('title' => 'Cài đặt tặng phẩm', 'act' => 'add.action'),
                                                array('title' => 'Thực hiện trao thưởng', 'act' => 'add.doaction'),
                                                )); 
                            $hook_sidebars[] = $addsidebars;
                            $hook_sidebars[] = $addsidebars_present;	
                            if(isset($_GET['act'])) {
                                $file = explode('.', $_GET['act']);
                                $view = "modcp_".$file[0]."_".$file[1].".tpl";
                            } else $view = 'modcp.tpl';	   
                        } else {
                            $view = 'error.tpl';
                        }
                        break;
                        
        case 'magic':	$view = 'magic.tpl';
                        $rs = $DB->Execute("SELECT * FROM `playerbagequipinfo` WHERE userid='".$_SESSION['id']."' AND goodsid='7159'  ");
                        $rows = $rs->GetRows();
                        $smarty->assign('item1',$rows);
                        break;
                    
        default: $view = 'main.tpl'; break;   
    }
    */
/*
endif;
     */
//$smarty->assign('hook_sidebar', $hook_sidebars);
$smarty->assign('sdebug', $_SESSION);
$smarty->assign('view', 'main.tpl'); 
$smarty->assign('is_logged_in', true);
$smarty->display('index.tpl');


?>
