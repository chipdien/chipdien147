<?php
function getCurrentPage() {
    $url = parse_url($_SERVER['REQUEST_URI']);
    $current_file_name = basename($url['path'], ".php");
    return $current_file_name;
}
function player_add_item($id, $itemid, $num, $questName = NULL, $targetId = 0) {
    global $DB;
    
    $logtime = date("Y-m-d H:i:s");
    $r = 0; $r_new = 0;
    
    $data = array(
        'UserID' => $id,
        'GoodsID' => $itemid,
        'Num' => $num
    );
    $r = $DB->GetOne("SELECT num FROM playerbaggoodsinfo WHERE goodsid = '".$itemid."' AND userid = '".$id."' ");
    if (!$r) {
        $r_new = (int)$r + $num;
        $rs = $DB->Autoexecute('playerbaggoodsinfo', $data, "INSERT");
    } else {
        $r_new = $r + $num;
        $rs = $DB->Autoexecute("playerbaggoodsinfo", array('Num' => $r_new), "UPDATE", " goodsid = '".$itemid."' AND userid = '".$id."'  ");
    }
    $itemName = $DB->GetOne("SELECT GoodsName FROM goodsinfo WHERE goodsid = '".$itemid."' ");
    if ($rs) {
        $status = "Thành công: ";
    } else {
        $status = "Thất bại: ";
    }
    $DB->Autoexecute("logs", 
                    array(
                        'userid'=> $id, 
                        'type'=> $questName, 
                        'target'=> $targetId, 
                        'time' => $logtime , 
                        'content'=> $status.' '.$num.' '.$itemName.' ('.$itemid.')  ('.$r.'->'.$r_new.')'
                    ), 
                    "INSERT"
    );
    return $r;
}

function writeLogs($userid, $questName, $targetId, $logtime, $content) {
    global $DB;
    $DB->Autoexecute("logs", 
        array(
            'userid'=> $userid, 
            'type'=> $questName, 
            'target'=> $targetId, 
            'time' => $logtime , 
            'content'=> $content
        ), 
        "INSERT"
    );
}

function present_count($userid, $OfficalPos, $OfficalMoney)
{
    global $DB;
    $title = $OfficalPos;
    $present = $OfficalMoney;

    $grade_o = $DB->GetOne("SELECT b.grade FROM alluser_copy as a, officialposinfo as b WHERE (a.recommender = b.name) AND (a.userid = '$userid') ");
    $grade_n = $DB->GetOne("SELECT b.grade FROM emperorinfo as a, officialposinfo as b WHERE (a.officialpos = b.name) AND (a.userid = '$userid')");

    $xu = 0;
    $j = $grade_o;
    if ($grade_n <> $grade_o) {
        $datas['title'] = $title[$j];
        $i = $grade_o+1;
        for ($i; $i <= $grade_n; $i++) {
            $xu = $xu + $present[$i];
            $tmp_title = $title[$i];
            $datas['list'][$tmp_title] = $present[$i];
            $datas['title_end'] = $title[$i];
        }
        $datas['sum'] = $xu;
    } else {
        $i = $j+1;
        $datas['title'] = $title[$j];
        $datas['title_end'] = $title[$j];
        $tmp_title = $title[$i];
        $datas['list'][$tmp_title] = $present[$i];
        $datas['sum'] = $xu;
    }
    return $datas;
}

function getQuantityFromInventory($uid, $listItem) {
    global $DB;
    $data = array();
    $sql = "SELECT goodsid, num FROM playerbaggoodsinfo 
            WHERE userid='".$uid."' AND goodsid IN (".$listItem.")
            ORDER BY goodsid ";
    $r = $DB->Execute($sql);
    $rs = $r->GetRows();
    foreach ($rs as $item) {
        $data[$item['goodsid']] = $item['num']; 
    }
    return $data;
}

function getQuantityFromInventoryOne($uid, $itemid) {
    global $DB;
    $r = $DB->GetOne("SELECT num FROM playerbaggoodsinfo WHERE userid='".$uid."' AND goodsid='".$itemid."' ");
    return $r;
}

function getPlayerMoney($uid) {
    global $DB;
    $r = $DB->GetOne("SELECT Money FROM alluser WHERE userid='".$uid."' ");
    return $r;   
}

function getPlayerGiftcert($uid) {
    global $DB;
    $r = $DB->GetOne("SELECT GiftCertificate FROM alluser WHERE userid='".$uid."' ");
    return $r;   
}

function getPlayerReputation($uid) {
    global $DB;
    $r = $DB->GetOne("SELECT Reputation FROM emperorinfo WHERE userid='".$uid."' ");
    return $r;   
}

function getPlayerPVPCredit($uid) {
    global $DB;
    $r = $DB->GetOne("SELECT PVPCredit FROM emperorinfo WHERE userid='".$uid."' ");
    return $r;   
}

function getPlayerLeagueProffer($uid) {
    global $DB;
    $r = $DB->GetOne("SELECT LeagueProffer FROM emperorinfo WHERE userid='".$uid."' ");
    return $r;   
}



function insert_unsetSession($params)
{
	if(isset($params['type1']) && isset($params['type2']))
		unset($_SESSION[$params['type1']][$params['type2']]);
}

function checkEmail($str)
{
    return preg_match("/^[\.A-z0-9_\-\+]+[@][A-z0-9_\-]+([.][A-z0-9_\-]+)+[A-z]{1,4}$/", $str);
}

function isValidPassword($password)
{
    //Validate that 1st char is alpha, ALL characters are valid and length is correct
    if(preg_match("/^[a-zA-Z0-9\!\@\#\$\%\^\&\*\(\)\+\=\.\_\-]{5,15}$/i", $password)===0)
    {
        return 'Mật khẩu mới của bạn chứa những ký tự không cho phép! Bạn vui lòng lựa chọn mật khẩu khác.';
    }
    //Validate that password has at least 3 of 4 classes
    $classes = 0;
    $classes += preg_match("/[A-Z]/", $password);
    $classes += preg_match("/[a-z]/", $password);
    $classes += preg_match("/[0-9]/", $password);
    $classes += preg_match("/[!@#$%^&*()+=._-]/", $password);
    
    return ($classes >= 3);
}


function send_mail($from,$to,$subject,$body)
{
    $headers = '';
    $headers .= "From: $from\n";
    $headers .= "Reply-to: $from\n";
    $headers .= "Return-Path: $from\n";
    $headers .= "Message-ID: <" . md5(uniqid(time())) . "@" . $_SERVER['SERVER_NAME'] . ">\n";
    $headers .= "MIME-Version: 1.0\n";
    $headers .= "Date: " . date('r', time()) . "\n";

    mail($to,$subject,$body,$headers);
}
?>