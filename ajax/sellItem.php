<?php
define('IN_MEDIA',true);
include('./ajaxinit.php');

include('../functions.php');

if (!$_SESSION['id']) {
    header("Location: login.php");
    exit();
}
$userid = $_SESSION['id'];

if(isset($_GET['shoptype'])) {
    $currTime = date("Y-m-d H:i:s");
    $shoptype = (int) $_GET['shoptype'];
    
    $isOnline = $DB->GetOne("SELECT LoginIP FROM `onlineuser` WHERE userid='".$userid."' ");
    if($isOnline !== Null){
        echo "0| Bạn đang online trong game, quá trình đổi vật phẩm không thực hiện được. Bạn vui lòng out game và thử lại lần nữa.";
        exit();
    }
    
    if (isset($_POST['quantity']) && isset($_POST['goodsid']) && $_POST['submit'] == 'Bán') {
        $goodsid = (int) $_POST['goodsid'];
        $num = (int) $_POST['quantity'];
        $sql = "SELECT * FROM web_shop 
                WHERE shoptype='".$shoptype."' 
                      AND starttime<'".$currTime."' 
                      AND endtime>'".$currTime."' 
                      AND npctype = '1'
                      AND goodsid = '".$goodsid."'  ";
        $r = $DB->GetRow($sql);
        if($r) {
            // Ktra co du dieu kien khong?
            $currNum = getQuantityFromInventoryOne($userid, $goodsid);
            if ($currNum < $num) {
                echo "0| Bạn không đủ vật phẩm để bán!";
                exit();
            } 
            $newNum = $currNum - $num; 
            
            // 1- Xu, 2- The qua, 3- Thanh danh, 4- PVPCredit, 5- GuildPoint, 6- PGold
            // $paytype = array('1' => 'xu', '2' => 'thẻ quà', '3' => 'điểm thanh danh', '4' => 'điểm phong thần tháp', '5' => 'điểm cống hiến bang hội', '6' => 'điểm PGold');
            $returnVal = (int)$r['price']*$num;
            $currVal = 0;
            switch ($r['paytype']) {
                case '1': 
                    $currVal = (int)getPlayerMoney($userid);
                    $requireItem = "Xu";
                    break;
                case '2':
                    $currVal = (int)getPlayerGiftcert($userid);
                    $requireItem = "Thẻ Quà";
                    break;
                case '3':
                    $currVal = (int)getPlayerReputation($userid);
                    $requireItem = "điểm Thanh Danh";
                    break;
                case '4':
                    $currVal = (int)getPlayerPVPCredit($userid);
                    $requireItem = "điểm Phong Thần Tháp";
                    break;
                case '5':
                    $currVal = (int)getPlayerLeagueProffer($userid);
                    $requireItem = "điểm Cống Hiến Bang Hội";
                    break;
                case '6';
                    break;
            }
            $newVal = (int)$currVal + (int)$returnVal;
            
            // Lay di vat pham
            $p = $DB->AutoExecute("playerbaggoodsinfo", array('Num' => $newNum), "UPDATE", " userid='".$userid."' AND goodsid='".$goodsid."' ");
            if ($p) {
                $status = "Trừ VP thành công: ".$num." ".$r['goodsname']." (".$goodsid.") (".$currNum."->".$newNum.")";
                writeLogs($userid, "Chợ Trời", 0, $currTime, $status);
            } else {
                $status = "Trừ VP thất bại";
                echo "0| Trừ VP thất bại!";
                writeLogs($userid, "Chợ Trời", 0, $currTime, $status);
                exit();
            }
            
            // Thuc hien thanh toan
            switch ($r['paytype']) {
                case '1': 
                    $p = $DB->AutoExecute("alluser", array('Money' => $newVal), "UPDATE", " userid='".$userid."' ");
                    break;
                case '2':
                    $p = $DB->AutoExecute("alluser", array('GiftCertificate' => $newVal), "UPDATE", " userid='".$userid."' ");
                    break;
                case '3':
                    //
                    break;
                case '4':
                    //
                    break;
                case '5':
                    //
                    break;
                case '6';
                    //
                    break;
            } 
            
            if ($p) {
                $status = "Thêm ".$requireItem." thành công: ".$returnVal." ".$requireItem." (".$currVal."->".$newVal.")";
                writeLogs($userid, "Chợ Trời", 0, $currTime, $status);
            } else {
                $status = "Thêm ".$requireItem." thất bại";
                echo "0| Thanh toán thất bại!";
                writeLogs($userid, "Chợ Trời", 0, $currTime, $status);
                exit();
            }

            echo "1| Giao dịch thành công!";
            // Ghi log
            
            
        } else {
            echo "0| Vật phẩm bạn cần mua hiện không có bán hoặc quá thời hạn để mua!";
        }
    } else {
        echo "0| Bạn đang cố gắng thực hiện công việc không được cho phép!";
    }
} else {
    echo "0| Bạn đang cố gắng thực hiện công việc không được cho phép!";
}

?>