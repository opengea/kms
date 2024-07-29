<?

// ----------------------------------------------
// Class Sites Forms for KMS
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class sites_forms extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

	var $table	= "kms_sites_forms";
	var $key	= "id";	
	var $fields = array("name", "webpage_id", "admin_email");
	var $orderby = "id";
	var $readonly = array("lectures","dr_folder");

       //*=[ CONSTRUCTOR ]===========================================================*/

        function sites_forms ($client_account,$user_account,$dm) {
                parent::mod($client_account,$user_account,$extranet);
        }

        function setup($client_account,$user_account,$dm) {
		$this->humanize("dr_folder","Carpeta");
		$this->default_content_type = "web_forms";
		$this->insert_label = _NEW_WEB_FORM;
		$this->setComponent("wysiwyg","introtext");
		$this->setComponent("wysiwyg","footertext");
		$this->setComponent("xcombo","webpage_id",array("xtable"=>"kms_sites_pages","xkey"=>"id","xfield"=>"title","readonly"=>false,"linkcreate"=>true,"linkedit"=>true,"sql"=>""));
	}
}
?>

