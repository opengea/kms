<?

// ----------------------------------------------
// Class Ecommerce TPV for KMS 
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class ecom extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

	var $table	= "kms_ecom";
	var $key	= "id";	
	var $fields = array("id", "status", "creation_date", "catalog_id", "admin_email");
	var $orderby = "id";
	var $readonly = array("");

       //*=[ CONSTRUCTOR ]===========================================================*/

        function ecom ($client_account,$user_account,$dm) {
                parent::mod($client_account,$user_account,$extranet);
        }

        function setup($client_account,$user_account,$dm) {

		$this->defvalue("status","active");
		$this->defvalue("priority","normal");
		$uploadDate = date('Y-m-d');
		$this->defvalue("creation_date",$uploadDate);
		$this->default_content_type = "ecom";
		$this->insert_label = _NEW_ECOM;
		$this->setComponent("xcombo","catalog_id",array("xtable"=>"kms_ecom_catalogs","xkey"=>"id","xfield"=>"name","readonly"=>false,"linkcreate"=>false,"linkedit"=>false,"sql"=>""));

	}
}
?>
