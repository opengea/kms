<?
session_start();
// Init KMS kernel class
include_once("/usr/local/kms/lib/kms.class.php");
$kms =& intergridKMS::getInstance();
include_once "/usr/local/kms/lib/globals.php";
include "/usr/local/kms/lib/dbi/openClientDB.php";
//include "/usr/local/kms/tpl/common_header.php";
include "/usr/local/kms/lib/dbi/dbconnect.php";
include "/usr/local/kms/tpl/common_header_externalcall.php";
include "/usr/local/kms/tpl/interfaces/headers/quick_menu.php";

?>
