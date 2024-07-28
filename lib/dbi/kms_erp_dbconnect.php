<?
//KMS Master server (with kms_isp_extranets 
include "/etc/kms/kms.conf.php";

$host=$setup['intranet_server'];
if (substr($host,0,8)==gethostname()) $host="localhost";

$host="localhost";
$link = mysqli_connect($host, $setup['master_db_user'], $setup['master_db_pass'],$setup['intranet_db_name']);
if (!$link) die ('kms_erp_dbconnect.php error. Could not connect: '.mysqli_error());
mysqli_query($link,"SET NAMES 'utf8'"); 
?>
