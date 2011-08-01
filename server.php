<?php

include 'db_config.php';

$addr3 = trim($_REQUEST['addr3']);
if(!$addr3) exit();

$connect = mysql_connect($db_host,$db_user,$db_password) or die(mysql_error());
mysql_select_db($db_database, $connect) or die(mysql_error());
mysql_query("SET NAMES 'utf8'", $connect) or die(mysql_error());

if(get_magic_quotes_gpc()) $addr3 = stripslashes(str_replace("\\","\\\\",$addr3));
if(!is_numeric($addr3)) $addr3 = mysql_real_escape_string($addr3,$connect);

$query = "select * from kr_zipcode where addr3 like '".$addr3."%'";
$result = mysql_query($query, $connect) or die(mysql_error());
while($tmp = mysql_fetch_object($result)) {
    $address[] = sprintf("%s %s %s %s (%s)", $tmp->addr1, $tmp->addr2, $tmp->addr3, $tmp->addr4, $tmp->zip);
}

print base64_encode(serialize($address));
?>