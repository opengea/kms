<?

// ----------------------------------------------
// Class Ecommerce Shopping Cart for KMS 
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class ecom_shoppingcart extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

	var $table	= "kms_ecom_shoppingcart";
	var $key	= "id";	
	var $fields = array("id", "name");
	var $orderby = "id";
	var $readonly = array("dr_folder");

       //*=[ CONSTRUCTOR ]===========================================================*/

        function ecom_shoppingcart ($client_account,$user_account,$dm) {
                parent::mod($client_account,$user_account,$extranet);
        }

        function setup($client_account,$user_account,$dm) {

		$this->defvalue("status","active");
		$this->defvalue("priority","normal");
		$uploadDate = date('Y-m-d');
		$this->defvalue("creation_date",$uploadDate);
		$this->insert_label = _NEW_ECOMMERCE;
		$this->setComponent("xcombo","tpv_id",array("xtable"=>"kms_ecom_tpv","xkey"=>"tpv_description","xfield"=>"tpv_description","readonly"=>false,"linkcreate"=>false,"linkedit"=>false,"sql"=>""));
	}
}
?>
