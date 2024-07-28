<?

// ----------------------------------------------
// Class System Sessions for KMS
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class sys_sessions extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

	var $table	= "kms_sys_sessions";
	var $key	= "datetime";	
	var $fields = array("datetime", "username", "type", "action", "ip_address");
	var $where = "";
	var $orderby = "datetime";
	var $sortdir = "desc";
	
	var $can_edit = false;
	var $can_delete = false;
	var $can_add        = false;
	var $can_import  = false;
	var $can_export = true;
	var $can_search = true;

       //*=[ CONSTRUCTOR ]===========================================================*/

        function sys_sessions ($client_account,$user_account,$dm) {
                parent::mod($client_account,$user_account,$extranet);
        }

        function setup($client_account,$user_account,$dm) {

		$this->defvalue("content_type","entities");
		$uploadDate = date('Y-m-d');
		$this->defvalue("creation_date",$uploadDate);
		$this->setComponent("uniselect","type");
		$this->setComponent("uniselect","location");
		$this->setComponent("multiselect","contacts");
	}
}
?>
