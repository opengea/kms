<?

// ----------------------------------------------
// Class Sites Language for KMS
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class sites_lang extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

	var $table	= "kms_sites_lang";
	var $key	= "id";	
	var $fields = array("const");
	var $hidden = array("type","ca","es","en","de","fr","it","pt","eu");
	var $orderby = "id";
	var $sortdir = "desc";

	/*=[ PERMISOS ]===========================================================*/

	var $can_view = false;
	var $can_edit = true;
	var $can_delete = true;
	var $can_add   = true;
	var $can_import = false;
	var $can_export = true;
	var $search = true;
	var $can_duplicate = true;

       //*=[ CONSTRUCTOR ]===========================================================*/

        function sites_lang ($client_account,$user_account,$dm) {
                parent::mod($client_account,$user_account,$extranet);
        }

        function setup($client_account,$user_account,$dm) {
		$site=$this->dbi->get_record("select available_languages from kms_sites limit 1");
		$this->fields=array("id","const");
		$langs=explode(",",$site['available_languages']);
		foreach ($langs as $l) {
                        $l=strtolower($l);
                        array_push($this->fields,$l);
                        $this->hidden=array_diff($this->hidden, array($l));
                        $this->setComponent("ckeditor_standard",$l,array("type"=>"html"));
		}
		$this->setComponent("uniselect", "type", true);
		$this->setComponent("select","type",array("pages"=>_KMS_TY_WEB_PAGES,"menus"=>_KMS_TY_WEB_MENUS,"texts"=>_KMS_TY_WEB_LANG));
		$this->setComponent("xcombo","page_id",array("xtable"=>"kms_sites_pages","xkey"=>"id","xfield"=>"title","readonly"=>false,"linkcreate"=>false,"linkedit"=>false,"sql"=>""));
	}
}

?>
