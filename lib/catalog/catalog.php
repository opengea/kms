<?

// GLOBALS.PHP - Intergrid Knowledge Management System


// application constants
define('KMS_VERSION', '1.0b');
define('KMS_CHARSET', 'UTF-8');
define('JS_OBJECT_NAME', 'kms');

// define global vars
$OUTPUT_TYPE = 'html';
$INSTALL_PATH = dirname(__FILE__);
$MAIN_TASKS = array('my account', 'settings', 'logout');

if (empty($INSTALL_PATH))
  $INSTALL_PATH = './';
else
  $INSTALL_PATH .= '/';

// instead the ones provided by RC
ini_set('include_path', $INSTALL_PATH.PATH_SEPARATOR.$INSTALL_PATH.'program'.PATH_SEPARATOR.$INSTALL_PATH.'program/lib'.PATH_SEPARATOR.ini_get('include_path'));

ini_set('session.name', 'kms_sessid');
ini_set('session.use_cookies', 1);
ini_set('session.gc_maxlifetime', 21600);
ini_set('session.gc_divisor', 500);
ini_set('error_reporting', E_ALL&~E_NOTICE);
set_magic_quotes_runtime(0);

// increase maximum execution time for php scripts
// (does not work in safe mode)
//if (!ini_get('safe_mode')) @set_time_limit(120);

// include base files (aixo son libs de roundcube, no fan falta)
//require_once('/usr/local/kms/lib/include/kms_shared.php');
//require_once('/usr/local/kms/lib/include/kms_imap.php');
//require_once('/usr/local/kms/lib/include/bugs.php');
//require_once('/usr/local/kms/lib/include/main.php');

//require_once( 'conf/configuration.php' );
$case=true;
require_once( '/usr/local/kms/lang/'.$client_account['default_lang'].".php");

include_once("/usr/local/kms/lib/catalog/catalog.class.php"); 

$kms =& intergridKMS::getInstance();

// use gzip compression if supported
if (function_exists('ob_gzhandler')) {

ob_start("ob_gzhandler");

} else if (ini_get('zlib.output_compression')) {
        if (extension_loaded('zlib')) {
                        $do_gzip_compress = TRUE;
                        ob_start();
                        ob_implicit_flush(0);
                        //header('Content-Encoding: gzip');
                }
}


?>
