<?php
define('IN_MEDIA',true);
include('./ajaxinit.php');

include('../functions.php');

// Main content
if(isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    
    $isOnline = $DB->GetOne("SELECT LoginIP FROM `onlineuser` WHERE userid='".$id."' ");
    if($isOnline !== Null){
        echo "0| Bạn đang online trong game, quá trình đổi vật phẩm không thực hiện được. Bạn vui lòng out game và thử lại lần nữa.";
        exit();
    }
    
    $present1 = present_count($id, $OfficalPos, $OfficalMoney);
    
    if ($present1['sum'] == 0) {
        echo "0| Hiện tại bạn đã nhận hết quà, xin hãy quay lại sau khi thăng quan lên cấp cao hơn!";
        exit();
    } else {
        $currentMoney = $DB->GetOne("SELECT money FROM `alluser` WHERE userid='".$id."' ");
        $newMoney = $currentMoney + $present1['sum'];
        $r1 = $DB->Autoexecute("alluser_copy", array('Recommender' => $present1['title_end']), "UPDATE", " UserID='".$id."' ");
        if ($r1)
            $r2 = $DB->Autoexecute("alluser", array('Money' => $newMoney), "UPDATE", " UserID='".$id."' ");
        
        $logtime = date("Y-m-d H:i:s");
        if ($r1 && $r2) {
            $status = "Thành công: ";
        } else {
            $status = "Thất bại: ";
        }
        $DB->Autoexecute("logs", 
                        array(
                            'userid'=> $id, 
                            'type'=> "Phần Thưởng Quan Chức", 
                            'target'=> 0, 
                            'time' => $logtime , 
                            'content'=> $status.'Nhận đến chức '.$present1['title_end'].' ('.$currentMoney.'->'.$newMoney.')'
                        ), 
                        "INSERT"
        );
        echo "1| Nhận thưởng thành công!";
        exit();
    }
    
} else {
    echo "0| Thất bại!";
}
?>
