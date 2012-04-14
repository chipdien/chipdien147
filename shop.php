<?php
define('IN_MEDIA',true);
include dirname(__FILE__).'/inc/init.php';
include dirname(__FILE__).'/inc/shop.class.php';
include dirname(__FILE__).'/inc/functions.php';

if (!$_SESSION['id']) {
    header("Location: login.php");
    exit();
}


// Global Vars
$hook_sidebars = array();
$view = ''; // Template view
$userid = $_SESSION['id'];

// Nav
$smarty->assign('currMenu', getCurrentPage());


// Sidebar
$emperorinfo = $DB->GetRow("SELECT a.EmperorName, b.Level, b.TransformWorkTimes, b.FavorName, b.Gender, b.Icon, a.OfficialPos, a.Reputation, a.League FROM `emperorinfo` as a, `citygeneralinfo` as b WHERE a.userid = '".$userid."' AND a.emperorname = b.showname ");
$emperorinfo['OfficialGrade'] = $DB->GetOne("SELECT b.grade FROM emperorinfo as a, officialposinfo as b WHERE (a.officialpos = b.name) AND (a.userid = '$userid') ");
$smarty->assign('emperor', $emperorinfo);

// Additional Sidebar
$addsidebars_shop = array(
    'title' => 'Giao dịch - Trao đổi', 
    'body' => array(
        array('title' => 'Chợ trời', 'type' => 'mod', 'name' => 'oshop'),
        array('title' => 'kShop', 'type' => 'mod', 'name' => 'kshop'),
    )
);
$hook_sidebars[] = $addsidebars_shop;

// Main 
if(isset($_GET['mod'])) {
    switch ($_GET['mod']) {
        case 'oshop': 
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
            
            $view = 'shop_oshop.tpl'; 
            break;
        case 'kshop': $view = 'shop_kshop.tpl'; break;
    }
    
} else $view = 'shop.tpl';
    

$smarty->assign('hook_sidebar', $hook_sidebars);
$smarty->assign('view', $view); 
$smarty->assign('is_logged_in', true);
$smarty->display('index.tpl');
?>
