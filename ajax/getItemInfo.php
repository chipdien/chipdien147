<?php
define('IN_MEDIA',true);
include('./ajaxinit.php');

include('../functions.php');

if (!$_SESSION['id']) {
    header("Location: login.php");
    exit();
}
$userid = $_SESSION['id'];

if(isset($_GET['item'])) {
    $itemid = (int) $_GET['item'];
    switch ($_GET['view']) {
        case 'quantity':
            $sql = "SELECT num FROM playerbaggoodsinfo WHERE userid = '".$userid."' AND goodsid = '".$itemid."' ";
            $r = $DB->GetRow($sql);
            if (!$r) $out = 0;
            else $out = $r['num'];
            echo $out;
            break;
        default: 
            echo "0";
            break;
    }
} else {
    echo "0";
    exit();
}

?>
