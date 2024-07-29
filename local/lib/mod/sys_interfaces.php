<?

// ----------------------------------------------
// Class System Interfaces for KMS
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class sys_interfaces extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

	var $table     = "kms_sys_interfaces";
	var $key       = "id";
	var $fields = array("status", "name", "interface_app", "interface_mod", "action", "definition");
	var $title =  _KMS_TY_INTERFACES;
	var $orderby = "name";

       //*=[ CONSTRUCTOR ]===========================================================*/

        function sys_interfaces ($client_account,$user_account,$dm) {
                parent::mod($client_account,$user_account,$extranet);
        }

        function setup($client_account,$user_account,$dm) {

		$this->defvalue("status","active");
		$uploadDate = date('Y-m-d');
		$this->defvalue("creation_date",$uploadDate);
		$this->insert_label = _NEW_INTERFACE;
		$this->setComponent("checklist","visible",array("1"=>""));
		$this->setComponent("checklist","default",array("1"=>""));
		$this->setComponent("checklist","show_tags",array("1"=>""));
		$this->setComponent("checklist","show_views",array("1"=>""));
		$this->setComponent("select","status",array("active"=>"<font color=#009900>"._KMS_GL_STATUS_ACTIVE."</font>","inactive"=>"<font color=#ff0000>"._KMS_GL_STATUS_INACTIVE."</font>"));
		$this->setComponent("select","type",array("f"=>"full","h"=>"horitzontal","v"=>"vertical"));
		//$this->xcombo("interface_app", "kms_apps", "name", "name", true, "");
		$this->setComponent("xcombo","interface_app",array("xtable"=>"kms_sys_apps","xkey"=>"name","xfield"=>"name","readonly"=>true,"linkcreate"=>true,"linkedit"=>true,"sql"=>""));
	}
}
?>
