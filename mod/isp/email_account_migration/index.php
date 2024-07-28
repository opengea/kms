<? 
// KMS EMAIL_ACCOUNT_MIGRATION_TOOL
// Mostra la configuració de serveis d'un client
require "/usr/local/kms/mod/isp/session_check.php"; 
//if ($check!="ok") { echo $check." invalid session";exit; } /fà falta aquest xequeix? ja ho fà a session_check.php


include "/usr/local/kms/lang/".$_GET['l'].".php";

if ($_GET['cp']=="") { 
	include "form.php"; 
} else if ($_GET['cp']=="control.intergridnetwork.net") {
	$_GET['cp']="cp.intergridnetwork.net";
	include "control.php";
}

?>
