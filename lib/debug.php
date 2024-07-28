<?
// debuging
error_reporting(E_ALL&~E_NOTICE&~E_WARNING&~E_STRICT);
//error_reporting(E_ALL); // & ~E_NOTICE & ~E_WARNING);
if ($_GET['debug']==1||DEBUG_MODE==1) $debug=1; else $debug=0;

ini_set('display_errors', $debug);

if ($debug) {
	error_reporting(E_ALL&~E_NOTICE&~E_WARNING&~E_STRICT);
} else {
	error_reporting(E_ALL&~E_NOTICE&~E_WARNING&~E_STRICT);
	ini_set('error_reporting', E_ALL&~E_NOTICE&~E_STRICT);
}
?>
