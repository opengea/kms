<?
/******************************************************************************************************************
   Workgroup KMS Databases Configuration File

   This file configures the array of KMS Databases for a enabled Workgroup KMS Network.

*******************************************************************************************************************/

$this->ddbb_master = array();
//$this->ddbb_master = array();
// MASTER KMS SERVER 
// This server will contain the table kms_sys_extranets with the configuration of the extranet of the client 
// and also its database.

if ($_SERVER['HTTP_HOST']=="intranet.intergrid.cat") {
	$this->ddbb_master['master'] = array(
	        'dbhost' => "localhost",
	        'dbname' => "intergrid_kms_erp"
	);
} else {
	$this->ddbb_master['master'] = array(
	        'dbhost' => "cp.intergridnetwork.net",
	        'dbname' => "intergrid_kms_isp"
	);
}

// ADITIONAL SERVERS
// Intergrid KMS can work in grid with different databases and servers maintaining data syncronized between them.
// The reason to do that, could be for security and also to load balance services. For exemple, a database for
// Control Panel (CRM/ISP), another for Intranet (ERP), another for (WEB), another for (MAILING Services)...
// That means that not only the KMS client will be working with its single database defined in sys_extranets table
// and stored automaticaly in ddbb['client'], but distributing data with multiple databases or servers.

$this->ddbb_master['cp'] = array(
        'dbhost' => "cp.intergridnetwork.net",
        'dbname' => "intergrid_kms_isp"
);

$this->ddbb_master['erp'] = array(
	'dbhost' => "g1.intergridnetwork.net",
        'dbname' => "intergrid_kms_erp"
);

$this->ddbb_master['erp-localhost'] = array(
        'dbhost' => "localhost",
        'dbname' => "intergrid_kms_erp"
);

$this->ddbb_master['mailer'] = array(
        'dbhost' => "mailer.intergridnetwork.net",
        'dbname' => "intergrid"
);
/*
$this->ddbb_master['a1'] = array(
        'dbhost' => "a1.intergridnetwork.net",
        'dbname' => "intergrid_kms"
);

$this->ddbb_master['a2'] = array(
        'dbhost' => "a2.intergridnetwork.net",
        'dbname' => "intergrid_kms"
);

$this->ddbb_master['a3'] = array(
        'dbhost' => "a3.intergridnetwork.net",
        'dbname' => "intergrid_kms"
);

$this->ddbb_master['db1'] = array(
        'dbhost' => "db1.intergridnetwork.net",
        'dbname' => "intergrid_kms"
);
*/

