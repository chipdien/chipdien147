<?php
define('IN_MEDIA',true);
include('./ajaxinit.php');
include('../inc/functions.php');

if (!$_SESSION['id'] || !in_array($_SESSION['id'], $ModCP)) {
    echo "Bạn không có quyền truy cập vào khu vực này!";
    exit();
}
$userid = $_SESSION['id'];
$logtime = date("Y-m-d H:i:s");
$output = "";

switch ($_GET['type']) {
    case 'list':
        if(isset($_GET['active'])) $filter_active = $_GET['active']; 
            else $filter_active = 0;
        if(isset($_GET['actionbutton'])) $activebutton = $_GET['actionbutton']; 
            else $activebutton = '';
        $sql = "SELECT * FROM gm_actgroup WHERE active = '$filter_active' ORDER BY id DESC LIMIT 30";
        $rs = $DB->Execute($sql);
        $rows = $rs->GetRows();
        $output = "<table><tbody><tr>
                        <th style='width: 30px;'>ID</th>
                        <th style='width: 160px;'>Tiêu Đề</th>
                        <th>Nội Dung</th>
                        <th style='width: 20px;'>&nbsp;</th>
                    </tr>";
        foreach ($rows as $record) {
            $output .= "<tr>
                        <td>".$record['id']."</td>
                        <td><b>".$record['title']."</b><br/><font color='gray'>".$record['subtitle']."</font></td>
                        <td>".$record['content']."</td>";
            if ($activebutton == 'view') $output .= "<td><a href='#' onclick='reload_actgroup(".$record['id'].")'>Xem</a></td>"; 
            else $output .= "<td>&nbsp;</td>";
            $output .= "</tr>";
        }
        $output .= "</tbody></table>";
        echo $output;
        break;
    
    case 'list_select':
        $sql = "SELECT * FROM gm_actgroup WHERE active='0' ORDER BY id DESC LIMIT 30";
        $rs = $DB->Execute($sql);
        $rows = $rs->GetRows();
        $output = "<option value='0'>---</option>";
        foreach ($rows as $record) {
            $output .= "<option value='".$record['id']."'>".$record['title']." (".$record['subtitle'].")</option>";
        }
        echo $output;
        break;
    
    case 'add':
        $_POST['titel'] = mysql_real_escape_string($_POST['title']);
        $_POST['desc'] = mysql_real_escape_string($_POST['desc']); 
        $_POST['content'] = mysql_real_escape_string($_POST['content']); 
        $data = array(
            'title' => $_POST['titel'], 
            'subtitle' => $_POST['desc'], 
            'content' => $_POST['content']
        );
        $p = $DB->AutoExecute("gm_actgroup", $data, "INSERT");
        if ($p) {
            $output = '1| Thêm nhóm quà tặng thành công!';
        } else {
            $errobj = ADODB_Pear_Error();
            $output = '0| Không thể thêm nhóm quà tặng! ('.$errobj->message.')';
        }
        echo $output;
        break;
        
    case 'detail':
        if (isset($_GET['id'])) {
            $sql = "SELECT * FROM gm_actgroup WHERE id = '".$_GET['id']."' ";
            $row = $DB->GetRow($sql);
            //$row = $db->query_first($sql);
            $is_active = $row['active'];
            $output = "<h2>Nhóm tặng thưởng: ".$row['title']."</h2>";
            $output .= "<p>Ghi chú: ".$row['subtitle']."</p>";
            $output .= "<p>Nội dung: ".$row['content']."</p>";

            $sql = "SELECT * FROM gm_acts WHERE groupid = '".$_GET['id']."' AND type = '5' ";
            $rs = $DB->Execute($sql);
            $rows = $rs->GetRows();
            $output .= "<h2>Người nhận thưởng: </h2><p>";
            foreach ($rows as $record1) {
                $output .= "- ".$record1['data']." (UserID: ".$record1['goodsid'].") [<a href='#' onclick='delete_receiver(".$record1['goodsid'].",".$_GET['id'].")'>Xóa</a>]<br/>";
            }
            $output .= "</p>";

            $sql2 = "SELECT * FROM gm_acts WHERE groupid = '".$_GET['id']."' AND type = '1' ";
            $rs = $DB->Execute($sql2);
            $rows2 = $rs->GetRows();
            $output .= "<h2>Phần thưởng: </h2><p>";
            foreach ($rows2 as $record2) {
                if($record2['goodsid'] == '1') $output .= "- ".$record2['num']." Xu [<a href='#' onclick='delete_good(".$record2['goodsid'].",".$_GET['id'].")'>Xóa</a>]<br/>";
                else if($record2['goodsid'] == '2') $output .= "- ".$record2['num']." Thẻ quà [<a href='#' onclick='delete_good(".$record2['goodsid'].",".$_GET['id'].")'>Xóa</a>]<br/>";
                else $output .= "- ".$record2['num']." x ".$record2['data']." [<a href='#' onclick='delete_good(".$record2['goodsid'].",".$_GET['id'].")'>Xóa</a>]<br/> ";
            }
            $output .= "</p>";
        }
        if(isset($_GET['button']) AND ($_GET['button'] == '1') AND ($is_active <> 1)) {
            $output .= "<div class='row'><p id='button_actrun' class='button' style='width: 90px;' onclick='javascript:actgroup_run(".$_GET['id'].")'>Thực hiện</p></div>";
            $output .= "<input type='hidden' id='actgroup_id_run' name='actgroup_id_run' value='".$_GET['id']."' />";
        }
        echo $output;
        break;
        
    //************* Actrun
    case 'actrun':
        if(isset($_GET['groupid'])) {
            $ret = array('status' => 1);
            $groupid = mysql_real_escape_string($_GET['groupid']);
            
            $sql1 = "SELECT * FROM gm_acts WHERE groupid = '$groupid' AND type = '5' ";
            $rs = $DB->Execute($sql1);
            $rows1 = $rs->GetRows();
            foreach ($rows1 as $record1) {
                $userid = $record1['goodsid'];
                $sql2 = "SELECT * FROM gm_acts WHERE groupid = '$groupid' AND type = '1' ";
                $rs = $DB->Execute($sql2);
                $rows2 = $rs->GetRows();
                foreach ($rows2 as $record2) {
                    $logtime = date("Y-m-d H:i:s");
                    if ($record2['goodsid'] == '1') {
                        $currMoney = $DB->GetOne("SELECT Money FROM alluser WHERE UserID = '$userid' ");
                        $newMoney = $currMoney + $record2['num'];
                        
                        $q = $DB->Execute(" UPDATE alluser SET Money = '".$newMoney."' WHERE UserID = '".$userid."' ");
                        if ($q) {
                            $status = "Tặng Xu thành công: ".$record2['num']." (".$currMoney."->".$newMoney.")";
                            writeLogs($userid, "BQT Tặng Thưởng", 0, $logtime, $status);
                        } else {
                            $status = "Tặng Xu thất bại: ".$record2['num']." (".$currMoney."->".$newMoney.")";
                            writeLogs($userid, "BQT Tặng Thưởng", 0, $logtime, $status);
                            $ret = array('status' => 0);
                        }
                        $q = $DB->Execute(" UPDATE gm_acts SET runtime='".$logtime."' WHERE groupid='$groupid' AND type='1' AND goodsid='1' ");
                    } else if ($record2['goodsid'] == '2') {
                        $currGift = $DB->GetOne("SELECT GiftCertificate FROM alluser WHERE UserID = '$userid' ");
                        $newGift = $currGift + $record2['num'];
                        
                        $q = $DB->Execute(" UPDATE alluser SET GiftCertificate = '".$newGift."' WHERE UserID = '".$userid."' ");
                        if ($q) {
                            $status = "Tặng Thẻ quà thành công: ".$record2['num']." (".$currGift."->".$newGift.")";
                            writeLogs($userid, "BQT Tặng Thưởng", 0, $logtime, $status);
                        } else {
                            $status = "Tặng Thẻ quà thất bại: ".$record2['num']." (".$currGift."->".$newGift.")";
                            writeLogs($userid, "BQT Tặng Thưởng", 0, $logtime, $status);
                            $ret = array('status' => 0);
                        }
                        $q = $DB->Execute(" UPDATE gm_acts SET runtime='".$logtime."' WHERE groupid='$groupid' AND type='1' AND goodsid='2' ");
                        
//                        $test_sql = ;
//                        $row_test = $DB->GetRow($test_sql);
//                        $money_1 = $row_test['GiftCertificate'];
//                        $run_sql = "UPDATE alluser SET GiftCertificate = GiftCertificate + ".$record2['num']." WHERE UserID = '$userid' ";
//                        $DB->Execute($run_sql);
//                        $run_sql = "UPDATE gm_acts SET runtime=NOW() WHERE groupid='$groupid' AND type='1' AND goodsid='2'  ";
//                        $DB->Execute($run_sql);
//                        $test_sql = "SELECT GiftCertificate FROM alluser WHERE UserID = '$userid' ";
//                        $row_test = $DB->GetRow($test_sql);
//                        $money_2 = $row_test['GiftCertificate'];                      
//                        $DB->AutoExecute('logs', array('userid'=> $userid, 'type'=> 'Quà Tặng Sự Kiện', 'target'=>$groupid, 'time' => $logtime , 'content'=>'Tặng Thẻ Quà: '.$record2['num'].' (Trước: '.$money_1.' & Sau: '.$money_2.')'));
                    }
                    else {
                        player_add_item($userid, $record2['goodsid'], $record2['num'], "BQT Trặng Thưởng");
                        $DB->Execute("UPDATE gm_acts SET runtime='".$logtime."' WHERE groupid='$groupid' AND type='1' AND goodsid='".$record2['goodsid']."'  ");
                        
//                        add_goodsitem($userid, $record2['goodsid'], $record2['num']);
//                        $run_sql = "UPDATE gm_acts SET runtime=NOW() WHERE groupid='$groupid' AND type='1' AND goodsid='".$record2['goodsid']."'  ";
//                        $DB->Execute($run_sql);
//                        $DB->AutoExecute('logs', array('userid'=> $userid, 'type'=> 'Quà Tặng Sự Kiện', 'target'=>$groupid, 'time' => $logtime , 'content'=>'Tặng Vật Phẩm: '.$record2['num'].' x '.$record2['data'].'(id: '.$record2['goodsid'].')'));
                    }
                }
            }
        }
        echo json_encode($ret);
        break;
    
    // Activated
    case 'activated':
        if(isset($_GET['groupid'])) {
            $groupid = mysql_real_escape_string($_GET['groupid']);
            $DB->Execute("UPDATE gm_actgroup SET active = '1' WHERE id = '$groupid' ");
            $ret = array('status' => 1);
        }
        echo json_encode($ret);
        break;
}


?>