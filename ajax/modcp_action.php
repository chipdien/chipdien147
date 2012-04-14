<?php
define('IN_MEDIA',true);
include('./ajaxinit.php');
include('../functions.php');

if (!$_SESSION['id'] || !in_array($_SESSION['id'], $ModCP)) {
    echo "Bạn không có quyền truy cập vào khu vực này!";
    exit();
}
$userid = $_SESSION['id'];
$logtime = date("Y-m-d H:i:s");
$output = "";

switch ($_GET['type']) {
    
    // Search Account
    case 'search_account':
        if(isset($_POST['username'])){
            $username = mysql_real_escape_string($_POST['username']);
            $userid = $DB->GetOne("SELECT UserID FROM alluser WHERE LoginName = '".$username."' ");

            if(isset($userid)) 
                $msg = "1|".$userid."| &nbsp;<font color='green'>Tài khoản hợp lệ, UserID là <b>".$userid."</b></font>";
            else
                $msg = "0| &nbsp;<font color='red'>Tài khoản không tồn tại, xin bạn vui lòng nhập lại tài khoản khác</font>";

            echo $msg;
        } 
        break;
        
        
    // Add Receiver    
    case 'add_receiver':
        if((isset($_POST['username'])) AND (isset($_POST['userid'])) AND (isset($_POST['groupid']))){
            $username = mysql_real_escape_string($_POST['username']);
            $userid = mysql_real_escape_string($_POST['userid']);
            $groupid = mysql_real_escape_string($_POST['groupid']);
            $sql = "SELECT id FROM gm_acts WHERE groupid = '$groupid' AND type = '5' AND goodsid = '$userid' ";
            $row = $DB->GetRow($sql);
            if($row){
                $output = "0| &nbsp;<font color='red'>Trong mỗi nhóm tặng thưởng, mỗi thành chủ chỉ được nhận quà một lần duy nhất!</font>";
            } else {
                $data = array ('groupid' => $groupid, 'type' => 5, 'goodsid' => $userid, 'data' => $username, 'time'=>$logtime);
                $action_id = $DB->AutoExecute('gm_acts', $data, 'INSERT');
                if ($action_id) {
                    $output = "1| &nbsp;<font color='green'>Thêm thành công.</font>";
                } else {
                    $error_object = ADODB_Pear_Error();
                    $output = "0| &nbsp;<font color='red'>".$error_object->message."</font>";
                }
            }
            echo $output;
        }
        break;
        
    // Del Receiver
    case 'del_receiver':
        if(isset($_GET['userid']) AND isset($_GET['groupid'])){
            $userid = mysql_real_escape_string($_GET['userid']);
            $groupid = mysql_real_escape_string($_GET['groupid']);
            $sql = "DELETE FROM gm_acts WHERE groupid = '$groupid' AND type = '5' AND goodsid = '$userid' ";
            $DB->Execute($sql);
            $output = '1| Xoa thanh cong!';
        }
        break;
    
}

if ($_GET['type'] == 'search_account') {
}


/*
if((isset($_POST['username'])) AND (isset($_POST['userid'])) AND (isset($_POST['groupid']))){
            $username = mysql_real_escape_string($_POST['username']);
            $userid = mysql_real_escape_string($_POST['userid']);
            $groupid = mysql_real_escape_string($_POST['groupid']);
            $sql = "SELECT id FROM gm_acts WHERE groupid = '$groupid' AND type = '5' AND goodsid = '$userid' ";
            $row = $DB->GetRow($sql);
            if($row){
                $output = "Trong mỗi nhóm tặng thưởng, mỗi thành chủ chỉ được nhận quà một lần duy nhất!";
            } else {
                $data = array ('groupid' => $groupid, 'type' => 5, 'goodsid' => $userid, 'data' => $username, 'time'=>$logtime);
                $action_id = $DB->AutoExecute('gm_acts', $data, 'INSERT');
                if ($action_id) {
                    $output = 'OK';
                } else {
                    $output = '[Connection] FAILD';
                }
            }
        }
 */
?>
