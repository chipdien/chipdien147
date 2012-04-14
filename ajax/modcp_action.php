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
$ret = array();

switch ($_GET['type']) {
    
    // Search Account
    case 'search_account':
        if(isset($_POST['username'])){
            $username = mysql_real_escape_string($_POST['username']);
            $userid = $DB->GetOne("SELECT UserID FROM alluser WHERE LoginName = '".$username."' ");
            if(isset($userid)) {
                $ret = array(
                    'status' => 1,
                    'userid' => $userid,
                    'msg' => " &nbsp;<font color='green'>Tài khoản hợp lệ, UserID là <b>".$userid."</b></font>"
                );
            } else {
                $ret = array(
                    'status' => 0,
                    'userid' => 0,
                    'msg' => " &nbsp;<font color='red'>Tài khoản không tồn tại, xin bạn vui lòng nhập lại tài khoản khác</font>"
                );
            }
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
                $ret = array(
                    'status' => 0,
                    'msg' => " &nbsp;<font color='red'>Trong mỗi nhóm tặng thưởng, mỗi thành chủ chỉ được nhận quà một lần duy nhất!</font>"
                );
            } else {
                $data = array ('groupid' => $groupid, 'type' => 5, 'goodsid' => $userid, 'data' => $username, 'time'=>$logtime);
                $action_id = $DB->AutoExecute('gm_acts', $data, 'INSERT');
                if ($action_id) {
                    $ret = array(
                        'status' => 1,
                        'msg' => " &nbsp;<font color='green'>Thêm thành công.</font>"
                    );
                } else {
                    $ret = array(
                        'status' => 0,
                        'msg' => " &nbsp;<font color='red'>Lỗi cơ sở dữ liệu.</font>"
                    );
                }
            }
        }
        break;
        
    // Del Receiver
    case 'del_receiver':
        if(isset($_GET['userid']) AND isset($_GET['groupid'])){
            $userid = mysql_real_escape_string($_GET['userid']);
            $groupid = mysql_real_escape_string($_GET['groupid']);
            $sql = "DELETE FROM gm_acts WHERE groupid = '$groupid' AND type = '5' AND goodsid = '$userid' ";
            $DB->Execute($sql);
            $ret = array('status' => 1, 'msg' => 'Xóa thành công!');
        }
        break;
    
    // Search Good
    case 'search_good':
        if(isset($_POST['goodsid'])) {
            $goodsid = mysql_real_escape_string($_POST['goodsid']);
            if ($goodsid == '1'){
                $ret = array('status' => 1, 'good' => 'Xu', 'msg' => "&nbsp;<font color='green'>Xu</font>");
            } else if ($goodsid == '2') {
                $ret = array('status' => 1, 'good' => 'Thẻ quà', 'msg' => "&nbsp;<font color='green'>Thẻ quà</font>");
            } else {
                $sql = "SELECT GoodsName FROM goodsinfo WHERE goodsid = '".$goodsid."' ";
                $row = $DB->GetRow($sql);
                if($row) {
                    $ret = array('status' => 1, 'good' => $row['GoodsName'], 'msg' => "&nbsp;<font color='green'>".$row['GoodsName']."</font>");
                } else {
                    $ret = array('status' => 0, 'msg' => "&nbsp;<font color='red'>Vật phẩm không tồn tại, xin hãy nhập lại!</font>");
                }
            }
        }
        break;
        
    // Add Good    
    case 'add_good':
        if((isset($_POST['goodsid'])) AND (isset($_POST['groupid'])) AND (isset($_POST['goodsnum'])) AND (isset($_POST['goodsname']))){
            $goodsid = mysql_real_escape_string($_POST['goodsid']);
            $goodsnum = mysql_real_escape_string($_POST['goodsnum']);
            $groupid = mysql_real_escape_string($_POST['groupid']);
            $goodsname = mysql_real_escape_string($_POST['goodsname']);
            $sql = "SELECT id FROM gm_acts WHERE groupid = '$groupid' AND type = '1' AND goodsid = '$goodsid' ";
            $row = $DB->GetRow($sql);
            if($row){
                $output = "Trong mỗi nhóm tặng thưởng, mỗi vật phẩm chỉ được add một lần duy nhất!";
            } else {
                $data = array ('groupid' => $groupid, 'type' => 1, 'goodsid' => $goodsid, 'data' => $goodsname, 'num' => $goodsnum, 'time'=> $logtime);
                $action_id = $DB->AutoExecute('gm_acts', $data, 'INSERT');
                if ($action_id) {
                    $ret = array('status' => 1, 'msg' => " &nbsp;<font color='green'>Thêm thành công.</font>");
                } else {
                    $ret = array('status' => 0, 'msg' => " &nbsp;<font color='red'>Thêm thất bại.</font>");
                }
            }
        }
        break;
        
    // Del Good
    case 'del_good':    
        if(isset($_GET['goodsid']) AND isset($_GET['groupid'])){
            $goodsid = mysql_real_escape_string($_GET['goodsid']);
            $groupid = mysql_real_escape_string($_GET['groupid']);
            $sql = "DELETE FROM gm_acts WHERE groupid = '$groupid' AND type = '1' AND goodsid = '$goodsid' ";
            $DB->Execute($sql);
            $ret = array('status' => 1, 'msg' => 'Xóa thành công!');
        }
        break;
}

echo json_encode($ret);




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
