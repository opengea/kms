<?
// ----------------------------------------------
// Class ISP DNS Zones for KMS
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class isp_dns_recs_tpl extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

	var $table	= "kms_isp_dns_recs_tpl";
	var $key	= "id";	
	var $fields	= array("service","type","host","val","opt");
	var $readonly	= array("dns_zone_id");
	var $orderby	= "type";
	var $sortdir    = "desc,host";
	var $notedit 	= array("time_stamp");

        /*=[ PERMISSIONS ]===========================================================*/

	var $can_view   = false;
	var $can_edit   = true;
	var $can_delete = true;
	var $can_add    = true;
	var $can_import = false;
	var $can_export = false;
	var $can_search = true;

       //*=[ CONSTRUCTOR ]===========================================================*/

        function isp_dns_recs_tpl($client_account,$user_account,$dm) { //,$silent) {

                parent::mod($client_account,$user_account,$extranet);
	}

        function setup($client_account,$user_account,$dm) {
		$this->setComponent("uniselect","service");
        }

}
?>
