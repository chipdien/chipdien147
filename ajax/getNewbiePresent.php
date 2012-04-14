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
    
    $check = $DB->GetOne("SELECT NewbiePresent FROM alluser_copy WHERE userid = '".$id."' ");
    if($check) {
        echo "0| Bạn đã nhận quà tặng này! Mỗi người chỉ được nhận một lần duy nhất.";
        exit();
    } else {
        $questName = "Quà Tặng Tân Thủ";
        player_add_item($id, '8738', '1', $questName); // 1 Kinh nghiem VIP (tuan)
        player_add_item($id, '8739', '1', $questName); // 1 Chiến Đấu VIP(Tuần)
        player_add_item($id, '8740', '1', $questName); // 1 Sản Xuất VIP(Tuần)
        player_add_item($id, '4502', '1', $questName); // 1 Hoàng Đế Lệnh(Tuần)
        player_add_item($id, '4505', '1', $questName); // 1 Hiên Viên Lệnh(Tuần)
        player_add_item($id, '4901', '2', $questName); // 2 Cáo Thị Tuyển Dụng
        player_add_item($id, '4955', '3', $questName); // 3 than ky tien hanh
        $DB->Autoexecute("alluser_copy", array('NewbiePresent' => '1'), "UPDATE", "UserID = '".$id."' ");
        echo "1| Nhận thưởng thành công!";
    }
    
} else {
    echo "0| Thất bại!";
}
?>
