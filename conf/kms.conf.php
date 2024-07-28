<?php // KMS Conf

// Application
define('KMS_VERSION', '3.0');
define('KMS_CHARSET', 'UTF-8');
define('JS_OBJECT_NAME', 'kms');
define('DEBUG_MODE', 1);
define('TARTARUS_IP','81.0.57.125');//81.0.57.125');
// paths
define("PATH_KMS","/usr/local/kms");
define("PATH_TPL","/usr/local/kms/tpl");
define("PATH_IMG_BIG","/kms/css/aqua/img/big");
define("PATH_IMG_SMALL","/kms/css/aqua/img/small");
define("PATH_IMG_FILETYPES","/kms/css/aqua/img/filetypes");
define("PATH_TPL_TEMPLATE","/usr/local/kms/tpl/");
define("PATH_LIB","/usr/local/kms/lib");
define("PATH_EXPORT","/usr/local/kms/lib/export");
define("PATH_RULES","/usr/local/kms/lib/components");
define("PATH_BUTTONS","/usr/local/kms/lib/buttons");

$conf=$setup = array(
	"master_db_user" 	=> "",
	"master_db_pass" 	=> "",
	"super_admin_user" 	=> "",
	"super_admin_pass" 	=> "",
	"auth_server" 		=> "",
	"intranet_server" 	=> "", 
	"auth_db_name" 		=> "",
	"intranet_db_name" 	=> "",
	"mailer_server"		=> "",
	"mailer_db_user"	=> "",
	"mailer_db_pass"	=> "",
	"mailer_db_name"	=> "",
	"pwd_mail"		=> "",
	"client_db_pass"	=> "",
	"pwd_cert"		=> ""
);

?>
