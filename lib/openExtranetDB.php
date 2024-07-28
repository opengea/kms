<?
//Load KMS Configuration
include_once "/etc/kms/kms.conf.php";
//include_once "/usr/local/kms/lib/mysql_wrapper.php";

// try local host to leverage load to the main kms auth_server
$extranet_server="localhost";
$link_extranetdb = mysqli_connect("localhost", $setup['master_db_user'], $setup['master_db_pass'],"intergrid_kms_isp");

// try tartarus if local database is inexistant
if (!$link_extranetdb) { 
//	$extranet_server=$setup['auth_server']; 
	$extranet_server=$setup['intranet_server'];
	$link_extranetdb = mysqli_connect($extranet_server, $setup['master_db_user'], $setup['master_db_pass'],$setup['intranet_db_name']); 
}
if (!$link_extranetdb) die ("[KMS OpenExtranetDB error] Can't connect to kms database ".mysqli_error());
?>
