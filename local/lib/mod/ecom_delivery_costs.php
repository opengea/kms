<?

// ----------------------------------------------
// Class Ecommerce Delivery Costs for KMS 
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class ecom_delivery_costs extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

	var $table	= "kms_ecom_delivery_costs";
	var $key	= "id";	
	var $fields = array("zone_id", "zone_name", "pvp");
	var $hidden = array("max_weight","min_weight","pvd");
	var $orderby = "zone_id";

        /*=[ PERMISSIONS ]===========================================================*/

        var $can_edit           = true;
        var $can_delete         = true;
        var $can_add            = true;
        var $can_import         = false;
        var $can_export         = true;
        var $can_duplicate      = true;

        /*=[ CONSTRUCTOR ]===========================================================*/

        function ecom_delivery_costs ($client_account,$user_account,$dm) {
                parent::mod($client_account,$user_account,$extranet);
        }

        function setup($client_account,$user_account,$dm) {

		$notedit = array("dr_folder","pvd");
		$uploadDate = date('Y-m-d');
		$this->defvalue("creation_date",$uploadDate);
		$this->defvalue("button_history",0);
		$this->defvalue("button_edit",0);
		$this->defvalue("button_admin",0);
		$this->defvalue("button_subscription",1);
		$this->defvalue("button_login",1);
		$this->defvalue("homepage","index");
		//$this->defvalue("topmenu","");
		$this->defvalue("logo","logo.png");
		$this->defvalue("robots","all");
		$this->defvalue("status","online");
		$this->setComponent("uniselect","zone");
		$this->default_content_type = "ecom_delivery_costs";
		$this->default_php = "variables.php";
		//$this->validate("Email");
		//$this->validate("WWW");
		$this->insert_label = "Nova zona";
		$linkfield = "domain";

	}

}
?>
