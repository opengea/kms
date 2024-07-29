<? 
// KMS GET_CLIENT_CONFIG
// Mostra la configuració de serveis d'un client
$authorized_ips = [
	'81.0.57.125',
	'83.42.73.141', // Dani - Ip Dinàmica
];
//if (!in_array($_SERVER['REMOTE_ADDR'], $authorized_ips)){
if ($_SESSION['user_logged']!=1&&(!strpos($_SESSION['user_groups'],"6"))) {
// if($_GET['check']!='ok') {
 die ('ERROR: Can\'t continue. Your IP address is not authorized');
//}
};
//if ($_SERVER['REMOTE_ADDR']!='81.0.57.125') die( "Your IP address is not authorized");
require "/usr/local/kms/mod/isp/session_check.php"; 
//require "/usr/local/kms/lib/include/pwcrypt.functions.php";
//if ($check!="ok") { echo $check." invalid session";exit; } /fà falta aquest xequeix? ja ho fà a session_check.php

include "/usr/local/kms/lang/".$_GET['l'].".php";
if ($_GET['cp']=="") { 
	include "form.php"; 
} else if ($_GET['cp']=="control.intergridnetwork.net") {
	$_GET['cp']="cp.intergridnetwork.net";
	include "control.php";
}

?>
