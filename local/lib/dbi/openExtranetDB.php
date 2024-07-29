<?
// Database master configuration
//Load KMS Configuration
include "/etc/kms/kms.conf.php";
$link_extranetdb = mysqli_connect($setup['auth_server'], $setup['master_db_user'], $setup['master_db_pass'],$setup['auth_db_name']);
mysqli_query($link_extranetdb,"SET NAMES 'utf8'"); 

if (!$link_extranetdb) die ("[dbi/openExtranetDB.php] : can't connect to kms database ".$setup['auth_db_name'].mysqli_error());
?>
