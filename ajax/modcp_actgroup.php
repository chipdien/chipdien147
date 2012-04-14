<?php
define('IN_MEDIA',true);
include('./ajaxinit.php');
include('../functions.php');

if (!$_SESSION['id'] || !in_array($_SESSION['id'], $ModCP)) {
    echo "Bạn không có quyền truy cập vào khu vực này!";
    exit();
}
$userid = $_SESSION['id'];

$output = "";

if ($_GET['type'] == 'list') {
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
                    <td><b>".$record['title']."</b><br/><font color='gray'>".$record['desc']."</font></td>
                    <td>".$record['content']."</td>";
        if ($activebutton == 'view') $output .= "<td><a href='#' onclick='reload_actgroup(".$record['id'].")'>Xem</a></td>"; 
        else $output .= "<td>&nbsp;</td>";
        $output .= "</tr>";
    }
    $output .= "</tbody></table>";
    echo $output;
    exit();
}

if ($_GET['type'] == 'list_select') {
    $sql = "SELECT * FROM gm_actgroup WHERE active='0' ORDER BY id DESC LIMIT 30";
    $rs = $DB->Execute($sql);
    $rows = $rs->GetRows();
    $output = "<option value='0'>---</option>";
    foreach ($rows as $record) {
        $output .= "<option value='".$record['id']."'>".$record['title']." (".$record['desc'].")</option>";
    }
    echo $output;
    exit();
}

if ($_GET['type'] == 'add') {
    $_POST['titel'] = mysql_real_escape_string($_POST['title']);
    $_POST['desc'] = mysql_real_escape_string($_POST['desc']); 
    $_POST['content'] = mysql_real_escape_string($_POST['content']); 
    $data = array(
        'title' => $_POST['titel'], 
        'desc' => $_POST['desc'], 
        'content' => $_POST['content']
    );
    $p = $DB->AutoExecute(
        "gm_actgroup", 
        array(
            'title' => $_POST['titel'], 
            'desc' => $_POST['desc'], 
            'content' => $_POST['content']
        ), 
        "INSERT");
    if ($p) {
        $output = '1| Thêm nhóm quà tặng thành công!';
    } else {
        $output = '0| Không thể thêm nhóm quà tặng!';
    }
    echo $output;
    exit();
}

if ($_GET['type'] == 'detail') {
    if (isset($_GET['id'])) {
        $sql = "SELECT * FROM gm_actgroup WHERE id = '".$_GET['id']."' ";
        $row = $DB->GetRow($sql);
        //$row = $db->query_first($sql);
        $is_active = $row['active'];
        $output = "<h2>Nhóm tặng thưởng: ".$row['title']."</h2>";
        $output .= "<p>Ghi chú: ".$row['desc']."</p>";
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
    exit();
}
?>