<?

// ----------------------------------------------
// Class Sites Blogs Comments for KMS
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class sites_comments extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

	var $table	= "kms_sites_comments";
	var $key	= "id";	
	var $fields = array("creation_date", "id_post", "name", "email");
	var $orderby = "id";
	var $sortdir = "desc";
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

        function sites_comments ($client_account,$user_account,$dm) {
                parent::mod($client_account,$user_account,$extranet);
        }

        function setup($client_account,$user_account,$dm) {
		$this->humanize("file","Imatge");
		$this->humanize("image","Frame");
		$uploadDate = date('Y-m-d');
		$this->defvalue("creation_date",$uploadDate);
		$this->default_content_type = "web_blogs_comments";
		$this->insert_label = _NEW_WEB_BLOG_COMMENT;

		$this->setComponent("uniselect","category");
		$this->setComponent("wysiwyg","body");
		$this->setComponent("select","status",array("draft"=>"<font color='#ff831f'><b>"._KMS_WEB_PAGE_DRAFT."</b></font>", "published"=>"<font color='#090'><b>"._KMS_WEB_PAGE_PUBLISHED."</b></font>"));
		$this->setComponent("xcombo","id_post",array("xtable"=>"kms_docs_articles","xkey"=>"id","xfield"=>"title","readonly"=>false,"linkcreate"=>true,"linkedit"=>true,"sql"=>""));
	}
}
?>
