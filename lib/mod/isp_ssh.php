<?
// ----------------------------------------------
// Class ISP SSH for KMS
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class isp_ssh extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

	var $table	= "kms_isp_hostings_vhosts";
	var $key	= "id";	
	var $fields = array("host","type","opt","val");
	var $readonly = array("dns_zone_id");
	var $orderby = "id";
	var $notedit = array("time_stamp","dns_zone_id");

        /*=[ PERMISSIONS ]===========================================================*/

	var $can_view = false;
	var $can_edit = true;
	var $can_delete = true;
	var $can_add        = true;
	var $can_import = false;
	var $can_export = false;
	var $can_search = true;

       //*=[ CONSTRUCTOR ]===========================================================*/

        function isp_ssh($client_account,$user_account,$dm,$silent) {

                parent::mod($client_account,$user_account,$extranet);
        }

        function setup($client_account,$user_account,$dm) {
                include "/usr/local/kms/tpl/panels/isp_hosting_vhost_adv.php";
		$this->action("ssh", "/usr/local/kms/mod/isp/hosting/service_ssh.php");
	}

}
?>
