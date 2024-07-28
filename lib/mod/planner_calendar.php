<?

// ----------------------------------------------
// Class Planner Calendar for KMS
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class planner_calendar extends mod {

	/*=[ CONFIGURACIO ]=====================================================*/

	var $table	= "kms_calendar";
	var $key	= "id";	
	var $fields = array("status", "title", "start_date", "end_date", "place");
	var $orderby = "start_date";
	var $sortdir = "desc";
	var $readonly = array("lectures","dr_folder","karma");

       //*=[ CONSTRUCTOR ]===========================================================*/

        function planner_calendar ($client_account,$user_account,$dm) {
                parent::mod($client_account,$user_account,$extranet);
        }

        function setup($client_account,$user_account,$dm) {

		$this->humanize("dr_folder","Carpeta");
		$this->humanize("image","Frame");
		$uploadDate = date('Y-m-d h:i:s');
		$this->defvalue("creation_date",$uploadDate);

		$this->default_content_type = "web_blogs_posts";
		$this->customOptions = Array();
			$this->customOptions[0] = Array ("label"=>_KMS_GL_PREVIEW,"url"=>"http://www.".$current_domain."/blog/preview/[title]?","ico"=>"details.gif","params"=>"","target"=>"new");
		$this->insert_label = _KMS_NEW_WEB_BLOG_POST;
		$this->defvalue("category","Articles");
		$this->defvalue("blog","Articles");

		$this->setComponent("uniselect","category");
		$this->setComponent("wysiwyg","short_body");
		$this->setComponent("wysiwyg","body");
		$this->setComponent("select","status",array("draft"=>"<font color='#ff831f'><b>"._KMS_WEB_PAGE_DRAFT."</b></font>", "published"=>"<font color='#090'><b>"._KMS_WEB_PAGE_PUBLISHED."</b></font>"));
		$this->xcombo("blogid", "kms_sites_blogs", "id", "name", false, "");
		$this->setComponent("file","file",array("/var/www/vhosts/".$current_domain."/subdomains/data/httpdocs/files/calendar/documents","files/calendar/documents"));
	}
}
?>

