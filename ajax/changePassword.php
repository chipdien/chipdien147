<?php
define('IN_MEDIA',true);
include('./ajaxinit.php');
include('../functions.php');

if (!$_SESSION['id']) {
    header("Location: login.php");
    exit();
}
$userid = $_SESSION['id'];
$logtime = date("Y-m-d H:i:s");
$output = '';

if (isset($_POST['forumpassword']) && isset($_POST['oldpassword']) && isset($_POST['newpassword']) && isset($_POST['retype_password'])) {
    $forumpwd = $_POST['forumpassword'];
    $oldpwd = $_POST['oldpassword'];
    $newpwd = $_POST['newpassword'];
    $retypepwd = $_POST['retype_password'];
    $err = array();
    
    if ($newpwd <> $retypepwd) $err[] = 'Xác nhận mật khẩu không chính xác! Xin bạn vui lòng nhập lại!';
    
    $r = $DB->GetRow("SELECT LoginName, Password FROM alluser WHERE userid = '".$userid."' ");
    if ($r['Password'] <> strtoupper(md5($oldpwd))) {
        $err[] = 'Mật khẩu game hiện tại không chính xác! Xin bạn vui lòng nhập lại!'; 
    } else {
        include '../inc/db.php';
        $vbb = new Database(DB_HOST_4R, DB_USER_4R, DB_PASS_4R, DB_NAME_4R);
        $vbb->connect();
        $vbb->query("SET NAMES 'utf8'");

        $rvbb = $vbb->query_first("SELECT userid, password, salt FROM user WHERE (username = '".$r['LoginName']."') AND (usergroupid NOT IN (3,4)) ");

        if ($rvbb['password'] <> md5(md5($forumpwd).$rvbb['salt']) ) $err[] = 'Mật khẩu diễn đàn không chính xác! Xin bạn vui lòng nhập lại!';

        if (!$err) {
            if (isValidPassword($newpwd)) {
                $rU = $DB->Autoexecute("alluser", array('Password' => strtoupper(md5($newpwd))), "UPDATE", " userid = '".$userid."' ");
                if ($rU) {
                    $status = "Thành công: ";
                    $output = '1| Đã thay đổi mật khẩu thành công!';
                } else {
                    $status = "Thất bại: ";
                    $output = '0| Có lỗi xảy ra trong cơ sở dữ liệu!';
                }
                $DB->Autoexecute("logs", 
                                array(
                                    'userid'=> $userid, 
                                    'type'=> "Đổi Mật Khẩu", 
                                    'target'=> 0, 
                                    'time' => $logtime , 
                                    'content'=> $status.' MK cũ: '.$oldpwd.' MK mới: '.$newpwd.' ('.$forumpwd.')'
                                ), 
                                "INSERT"
                );
            } else {
                $err[] = 'Mật khẩu mới của bạn không đủ an toàn! Xin hãy sử dụng mật khẩu khác theo hướng dẫn!';
            }
        }
    }
    
    
    if($err) 
        $output = '0| '.implode('<br />', $err);
}
echo $output;

?>
