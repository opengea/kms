<?

// ----------------------------------------------
// Class Sites Plugins for KMS
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class sites_plugins extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

	var $table	= "kms_sites_plugins";
	var $key	= "id";	
	var $fields = array("status", "name", "network", "api_consumer_key","creation_date");
	var $orderby = "id";
	var $readonly = array("");

	/*=[ PERMISOS ]===========================================================*/

	var $can_view = false;
	var $can_edit = true;
	var $can_delete = true;
	var $can_add   = true;
	var $can_import = false;
	var $can_export = false;
	var $can_search = false;
	var $can_duplicate = true;

       //*=[ CONSTRUCTOR ]===========================================================*/

        function sites_plugins ($client_account,$user_account,$dm) {
                parent::mod($client_account,$user_account,$extranet);
        }

        function setup($client_account,$user_account,$dm) {

		$uploadDate = date('Y-m-d');
		$this->defvalue("creation_date",$uploadDate);
		$this->defvalue("status","published");
		$this->default_content_type = "web_pages";
		$this->default_php = "variables.php";
		$this->insert_label = _NEW_WEB_PAGE;
		$this->setComponent("checklist","show_title",array("1"=>""));
		$this->setComponent("checklist","private",array("1"=>""));
		 $this->setComponent("checklist","nomargin",array("1"=>""));
		$this->setComponent("checklist","remove_website_widgets",array("1"=>""));
		$this->setComponent("select","network",array("google_analytics"=>"Google Analytics", "google_remarketing"=>"Google Remarketing","twitter"=>"Twitter","Facebook"=>"facebook"));
		$this->customOptions = Array();
		$this->customOptions[0] = Array ("label"=>_KMS_GL_PREVIEW,"url"=>"http://www.".$KMS[current_domain]."/[title]&","ico"=>"details.gif","params"=>"&preview","target"=>"new");
//		$this->xcombosql("web_lang_constant", "select SUBSTR(const,2) from kms_sites_lang where const not like \"_KMS_%\"", false, false);
		$this->setComponent("xcombo","web_lang_constant",array("xtable"=>"kms_sites_lang","xkey"=>"","xfield"=>"","readonly"=>false,"linkcreate"=>false,"linkedit"=>false,"sql"=>"select SUBSTR(const,2) from kms_sites_lang where const not like \"_KMS_%\""));
		$this->setComponent("multilang","title",array("type"=>"textfield"));
		$this->setComponent("multilang","body",array("type"=>"full"));
	}
}
?>
