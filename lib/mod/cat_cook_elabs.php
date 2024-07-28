<?

// ----------------------------------------------
// Class Cook Elaborations for KMS
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class cat_cook_elabs extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

        var $table  	= "kms_cat_cook_elabs";
	var $key		= "id";	
	var $fields 	= array("id", "status", "language", "title", "year");
	var $notedit 	= array('dr_folder',"external_url", "size");
	var $orderby 	= "id";

       /*=[ PERMISSIONS ]===========================================================*/

        var $can_view = false;
        var $can_edit = true;
        var $can_delete = true;
        var $can_add   = true;
        var $can_import = false;
        var $can_export = false;
        var $can_search = true;

        //*=[ CONSTRUCTOR ]===========================================================*/

        function cat_cook_elabs($client_account,$user_account,$dm) {
                parent::mod($client_account,$user_account,$extranet);
        }

        function setup($client_account,$user_account,$dm) {

		$this->defvalue("status","active");
		$this->setComponent("select","status",array("draft"=>"<font color='#ff831f'><b>"._KMS_WEB_PAGE_DRAFT."</b></font>", "published"=>"<font color='#090'><b>"._KMS_WEB_PAGE_PUBLISHED."</b></font>"));
		$this->defvalue("priority","normal");
		$uploadDate = date('Y-m-d');
		$this->defvalue("creation_date",$uploadDate);
		$this->default_content_type = "files";
		$this->insert_label = _NEW_FILE;

		$this->setComponent("file","file",array($this->kms_datapath."files/files","files/files"));
		$this->setComponent("select","downloadable",array("0"=>"No","1"=>"Si"));
	}
}
?>
