<?php
define('IN_MEDIA',true);
require './init.php';
require('./functions.php');

if (!$_SESSION['id']) {
    header("Location: login.php");
    exit();
}
if (!in_array($_SESSION['id'], $ModCP)) {
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

// HOOK Sidebar
/*$addsidebars = array(
    'title' => 'Quản lý thành viên', 'body' => array(
                                                array('title' => 'Đổi mật khẩu', 'act' => 'change.password'),
                                                array('title' => 'Xem thông tin', 'act' => 'view.account'),
                                                ));*/
// Additional Sidebar
$addsidebars_present = array(
    'title' => 'Quản lý quà tặng', 
    'body' => array(
        array('title' => 'Nhóm tặng phẩm',          'type' => 'mod', 'name' => 'actgroup'),
        array('title' => 'Cài đặt tặng phẩm',       'type' => 'mod', 'name' => 'action'),
        array('title' => 'Thực hiện trao thưởng',   'type' => 'mod', 'name' => 'doaction'),
    )
); 
$hook_sidebars[] = $addsidebars_present;

        
// Main 
if(isset($_GET['mod'])) {
    switch ($_GET['mod']) {
        case 'actgroup': 
            /*
            $shop = new Shop();
            $shop->setShopType('1');
            $paytype = array('1' => 'xu', '2' => 'thẻ quà', '3' => 'điểm thanh danh', '4' => 'điểm phong thần tháp', '5' => 'điểm cống hiến bang hội', '6' => 'điểm PGold');
            $itemSell = $shop->getItemList(TRUE);
            $itemBuy = $shop->getItemList(FALSE);
            $itemAllId = $shop->getItemListID();
            $listIdStr = '';
            foreach ($itemAllId as $k => $item) {
                if ($k <> 0) $listIdStr .= ',';
                $listIdStr .= $item['goodsid']; 
            }
            $playerbag = getQuantityFromInventory($userid, $listIdStr);
            
            $smarty->assign('playerBag', $playerbag);
            $smarty->assign('payType', $paytype);
            $smarty->assign('itemToSell', $itemSell);
            $smarty->assign('itemToBuy', $itemBuy);
            */
            $view = 'modcp_add_actgroup.tpl'; 
            break;
        case 'action': $view = 'modcp_add_action.tpl'; break;    
        case 'doaction': $view = 'modcp_add_doaction.tpl'; break;
    }
    
} else $view = 'modcp.tpl';



/*
global $smarty, $DB;

$hook_sidebars = array();

if (!$_SESSION['id']) :
    header("Location: index.php");
    exit;
else :
    // Da dang nhap
    $is_logged_in = true;

    // Maincontent
    $view = 'modcp.tpl';              
    
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
    

endif;
    
 * 
 */
$smarty->assign('hook_sidebar', $hook_sidebars);
$smarty->assign('view', $view); 
$smarty->assign('is_logged_in', TRUE);
$smarty->display('index.tpl');
?>