<?

// ----------------------------------------------
// Class Ecommerce Families for KMS 
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class ecom_families extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

	var $table	= "kms_ecom_families";
	var $key	= "id";	
	var $fields = array("id","catalog_id", "name", "creation_date");
	var $orderby = "creation_date";
	var $readonly = array("dr_folder");
	var $notedit= array("dr_folder");

        /*=[ PERMISSIONS ]===========================================================*/

        var $can_edit           = true;
        var $can_delete         = true;
        var $can_add            = true;
        var $can_import         = false;
        var $can_export         = true;
        var $can_duplicate      = true;

      //*=[ CONSTRUCTOR ]===========================================================*/

        function ecom_families ($client_account,$user_account,$dm) {
                parent::mod($client_account,$user_account,$extranet);
        }

        function setup($client_account,$user_account,$dm) {

		$this->defvalue("status","active");
		$this->setComponent("select","status",array("inactive"=>"<font color='#ff831f'><b>"._KMS_WEB_PAGE_DRAFT."</b></font>", "active"=>"<font color='#090'><b>"._KMS_WEB_PAGE_PUBLISHED."</b></font>"));
		$this->defvalue("priority","normal");
		//date_default_timezone_set('UTC');
		//$uploadDate = date('D j M Y');
		$uploadDate = date('Y-m-d');
		$this->defvalue("creation_date",$uploadDate);

		$this->default_content_type = "catalog";
		$this->default_php = "catalog.php";

		//$this->validate("Email");
		//$this->validate("WWW");

		$this->insert_label = _NEW_PRODUCT_FAMILY;
		//$linkfield = "title";
		$this->setComponent("checklist","highlight",array("SI"=>"Si"));
		$this->setComponent("xcombo","catalog_id",array("xtable"=>"kms_ecom_catalogs","xkey"=>"id","xfield"=>"name","readonly"=>false,"linkcreate"=>true,"linkedit"=>true,"sql"=>""));
		$this->setComponent("file","zipfile",array($this->kms_datapath."files/catalog/download","files/catalog/download",true,"75","100"));
	
	}

}
?>
