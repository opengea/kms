<?
//IDEM AS  /usr/local/kms/lib/dbi/kms_erp_dbconnect.php ... es pot elimiar aquest.
//KMS Master server (with kms_isp_extranets 

include "/etc/kms/kms.conf.php";
$dblink_local = mysqli_connect("localhost", $conf['master_db_user'], $conf['master_db_pass'],$conf['intranet_db_name']);
$link=$dblink_local;
mysqli_query($dblink_local,"SET NAMES 'utf8'");
if (!$link) die('db_localhost_connect.php error. Could not connect: '.$conf['intranet_db_name'].mysqli_error());
//echo $conf['master_db_user'].":".$conf['master_db_pass']." ".$conf['intranet_db_name'];exit;
?>
