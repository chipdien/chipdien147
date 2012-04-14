<?php

define('IN_MEDIA',true);
include 'init.php';
include 'functions.php';

if ($_SESSION['id']) 
{
    header("Location: index.php");
} 
else 
{
    if($_POST['submit'] == 'Đăng Nhập')
    {
        // Kiem tra thong tin dang nhap
        $err = array();

        if(!$_POST['username'] || !$_POST['password'])
            $err[] = 'Bạn phải điền đầy đủ thông tin và tất cả các ô trống';

        if(!count($err))
        {
            // Kiem tra gia tri nhap vao --- mysql_real_escape_string
            $_POST['username'] = addslashes($_POST['username']);
            $_POST['password'] = addslashes($_POST['password']);
            $_POST['rememberMe'] = (int)$_POST['rememberMe'];
            $password = strtoupper(md5($_POST['password']));

            $row = $DB->GetRow("SELECT UserID, LoginName, Password FROM alluser WHERE LoginName = '".$_POST['username']."' ");

            if($row['LoginName'])
            {
                if ($row['Password'] == $password) {
                    // Dang nhap thanh cong
                    $_SESSION['usr'] = $row['LoginName'];
                    $_SESSION['id'] = $row['UserID'];
                    $_SESSION['rememberMe'] = $_POST['rememberMe'];
                    $row_grade = $DB->GetOne("SELECT b.Grade FROM emperorinfo as a, officialposinfo as b WHERE (a.officialpos = b.name) AND (a.userid = '".$row['UserID']."')");           
                    $_SESSION['grade'] = $row_grade;

                    // luu thong tin
                    setcookie('dkRemember', $_POST['rememberMe']);
                    header("Location: index.php"); exit();
                } else {
                    $err[] = "Sai mật khẩu!";
                }
            }
            else 
            {   
                include 'inc/db.php';
                $vbb = new Database(DB_HOST_4R, DB_USER_4R, DB_PASS_4R, DB_NAME_4R);
                $vbb->connect();
                $vbb->query("SET NAMES 'utf8'");
                
                $rvbb = $vbb->query_first("SELECT userid, username, password, joindate, salt FROM user WHERE (username = '".$_POST['username']."') AND (usergroupid NOT IN (3,4)) ");
                      
                if (($rvbb['username']) && ($rvbb['password'] == md5(md5($_POST['password']).$rvbb['salt']) )){
                    // them tai khoan vao game
                    $data = array(
                        'LoginName' => $rvbb['username'],
                        'Password'  => strtoupper(md5($_POST['password'])),
                        'RegisterTime' => date('Y-m-d H:i:s', $rvbb['joindate']),
                    );
                    $newid = $DB->Autoexecute("alluser", $data, "INSERT");
                    if($newid) {
                        $newid = $DB->GetOne("SELECT UserId FROM alluser WHERE LoginName='".$_POST['username']."' ");
                        $data['Recommender'] = 'Toại Nhân';
                        $data['UserID'] = $newid;
                        $DB->Autoexecute("alluser_copy", $data, "INSERT");
                        
                        // thuc hien login
                        $_SESSION['usr'] = $data['LoginName'];
                        $_SESSION['id'] = $data['UserID'];
                        $_SESSION['rememberMe'] = $_POST['rememberMe'];
                        $row_grade = $DB->GetOne("SELECT b.Grade FROM emperorinfo as a, officialposinfo as b WHERE (a.officialpos = b.name) AND (a.userid = '".$data['UserID']."')");           
                        $_SESSION['grade'] = $row_grade;

                        // luu thong tin
                        setcookie('dkRemember', $_POST['rememberMe']);
                        header("Location: index.php"); exit();
                    }

                } else {
                    $err[] = 'Sai tên đăng nhập hoặc mật khẩu';
                }
            } 
        }

        if($err) 
            $login_err = implode('<br />', $err);
        
//        header("Location: index.php");
    } 
}

$smarty->assign('login_err', $login_err);
$smarty->assign('view', 'login.tpl'); 
//$smarty->assign('is_logged_in', $is_logged_in);
$smarty->display('index.tpl');


?>
