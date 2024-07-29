<?

// ----------------------------------------------
// Class Ecommerce Services Limits for KMS 
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class ecom_services_limits extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

	var $table     = "kms_ecom_services_limits";
	var $key       = "id";
	var $fields = array("service", "from_value", "to_value", "unit", "price", "category");

        /*=[ PERMISSIONS ]===========================================================*/

        var $can_edit           = true;
        var $can_delete         = true;
        var $can_add            = true;
        var $can_import         = false;
        var $can_export         = true;
        var $can_duplicate      = true;

        /*=[ CONSTRUCTOR ]===========================================================*/

        function ecom_services_limits ($client_account,$user_account,$dm) {
                parent::mod($client_account,$user_account,$extranet);
        }

        function setup($client_account,$user_account,$dm) {
		$this->insert_label = "Nova entrada";
		$this->setComponent("xref","service",array("id","name_".$_SESSION['lang'],"kms_ecom_services"));
		$this->setComponent("xcombo","service",array("xtable"=>"kms_ecom_services","xkey"=>"id","xfield"=>"name_".$_SESSION['lang'],"readonly"=>false,"linkcreate"=>true,"linkedit"=>true,"sql"=>""));
		$this->setComponent("multiselect","Colors");
		$this->setComponent("uniselect","unit");
		$this->setComponent("uniselect","category");
	}

}
?>
