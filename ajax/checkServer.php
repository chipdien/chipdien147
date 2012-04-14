<?php
error_reporting(E_ALL &~ E_WARNING);

/*
$servers = array(
    "ns1.dackyvn.net" => 7073, 
    "ns1.dackyvn.net" => 8083);

foreach($servers as $key=>$val) { 
    //see php.net/fsockopen for last parameter
    var_dump( $handle = fsockopen($key, $val, $errno, $errstr, 2)  );
    if( $handle === true ) {
      fclose($handle);
    }
}
 * */


$is_open = fsockopen("ns1.dackyvn.net", 7073, $errno, $errstr, 30);

if (!$is_open) {

echo "$errstr ($errno)<br />\n";

} else {

echo "Port is open.<br />\n";

}


?>
