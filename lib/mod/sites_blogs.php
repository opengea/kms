<?

// ----------------------------------------------
// Class Sites Blogs for KMS
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class sites_blogs extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

	var $table	= "kms_sites_blogs";
	var $key	= "id";	
	var $fields = array("id","creation_date", "name");
	var $orderby = "id";
	var $readonly = array("lectures","dr_folder","karma");

        /*=[ PERMISOS ]===========================================================*/

        var $can_view = false;
        var $can_edit = true;
        var $can_delete = true;
        var $can_add = true;
        var $can_import = false;
        var $can_export = false;
        var $can_search = true;
        var $can_duplicate = true;

       //*=[ CONSTRUCTOR ]===========================================================*/

        function sites_blogs ($client_account,$user_account,$dm) {
                parent::mod($client_account,$user_account,$extranet);
        }

        function setup($client_account,$user_account,$dm) {
		$this->humanize("dr_folder","Carpeta");
		$this->humanize("file","Imatge");
		$this->humanize("image","Frame");
		$uploadDate = date('Y-m-d');
		$this->defvalue("creation_date",$uploadDate);
		$this->default_content_type = "web_blogs";
		$this->insert_label = _NEW_WEB_BLOG;
		$this->setComponent("checklist","show_karma",array("1"=>""));
		$this->setComponent("checklist","show_comments",array("1"=>""));
		$this->setComponent("checklist","show_useravatar",array("1"=>""));
	}
}
?>
