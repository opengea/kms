<?php
if (!isset($_GET['_'])) $_GET['_']="b";

//gzip
ini_set('display_errors', '0');     # don't show any errors...
error_reporting(E_ALL | E_STRICT); 
date_default_timezone_set('Europe/Brussels');

//session with cross domain cookie
$domini=substr($_SERVER['SERVER_NAME'],strpos($_SERVER['SERVER_NAME'],"."));
$session_name="KMS".date('Ymd').str_replace(".","",strtoupper($domini));
session_name($session_name);
session_set_cookie_params(0, '/', "{$domini}");
session_start();

// Intergrid KMS Starter script
$msg="";
if ($msg) echo "<div style='width:100%;height:22px;background-color:#fcc;padding-top:4px'><center>".$msg."</center><br></div>";
// Init KMS kernel class
include_once("/usr/local/kms/lib/kms.class.php");
$kms =& intergridKMS::getInstance();
// Setup globals
include_once "/usr/local/kms/lib/globals.php";
if ($kms->exec_mode=="extranet") {
	// --------------------------- extranet mode (PRIVATE) -----------------------
        $kms->Start($kms->client_account,$kms->user_account,$kms->extranet);
} else {
	// --------------------------- sites mode (PUBLIC) ---------------------------
	include ("/usr/local/kms/lib/webs/start.php");
	include "/usr/local/kms/lib/dbi/dbclose.php";
}
?>
