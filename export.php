<?php
define('IN_MEDIA',true);
include('./inc/config.php');
include('./libs/db/adodb.inc.php');
$DB = NewADOConnection('mysql');
$DB->Connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$DB->Execute("SET NAMES 'utf8'");

include('./functions.php');
include('./inc/jgcache.php');

if ($_GET['view'] == 'top10') {
    
    $cache = new JG_Cache('./cache'); //Make sure it exists and is writeable
    $data = $cache->get('top10');
    if ($data === FALSE)
    {
        $sql = "SELECT a.EmperorName FROM emperorinfo as a, officialposinfo as b 
                WHERE a.UserID > '2000003' AND a.OfficialPos = b.Name 
                ORDER BY b.Grade DESC  
                LIMIT 10 ";
        $rs = $DB->Execute($sql);
        $rows = $rs->GetRows();

        $i = 1;
        foreach ($rows as $r) {
            $data .= $i.". ".$r['EmperorName']." <br/>";
            $i++;
        }
        
        $cache->set('top10', $data);
    }
    echo $data;
    
}


?>
