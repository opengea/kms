<?
//KMS Master ISP Server (with kms_isp_extranets 
include_once "/etc/kms/kms.conf.php";

if (!isset($kms_server_db_name)) $kms_server_db_name=$conf['intranet_db_name'];
$dblink_erp = mysqli_connect($conf['intranet_server'], $conf['master_db_user'], $conf['master_db_pass'],$kms_server_db_name);
$link=$dblink_erp;
mysqli_query($dblink_erp,"SET NAMES 'utf8'"); 
if (!$link) die ('db_master_connect. Could not connect: '.$mysqli_error());

$dblink_cp=$link;
?>
