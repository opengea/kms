<?

// ----------------------------------------------
// Class Docs Files for KMS
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class docs_files extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

	var $table	= "kms_docs_files";
	var $key	= "id";	
	var $fields = array("name", "creation_date", "status", "downloadcount", "file");
	var $notedit = array('dr_folder',"external_url", "size");
	var $orderby = "creation_date";
	var $sortdir = "desc";

        /*=[ PERMISSIONS ]===========================================================*/

        var $can_view = true;
        var $can_edit = true;
        var $can_delete = true;
        var $can_add   = true;
        var $can_import = false;
        var $can_export = false;
        var $can_search = true;
	var $can_mupload = true;
	
       //*=[ CONSTRUCTOR ]===========================================================*/

        function contacts($client_account,$user_account,$dm) {
                parent::mod($client_account,$user_account,$extranet);
        }

       //*=[ SETUP ]===========================================================*/

        function setup($client_account,$user_account,$dm) {

	$this->defvalue("status","published");
	$this->setComponent("select","status",array("draft"=>"<font color='#ff831f'><b>"._KMS_WEB_PAGE_DRAFT."</b></font>", "published"=>"<font color='#090'><b>"._KMS_WEB_PAGE_PUBLISHED."</b></font>"));
	$this->defvalue("priority","normal");
	$uploadDate = date('y-m-d');
	$this->defvalue("creation_date",$uploadDate);
	$this->defvalue("downloadable",1);
	$this->default_content_type = "files";
	$this->insert_label = _NEW_FILE;
	$this->setComponent("file","file",array($this->kms_datapath."files/files","files/files"));
	$this->setComponent("select","downloadable",array("0"=>"No","1"=>"Si"));
	$this->action("mupload","/usr/share/kms/lib/mupload/mupload.php");
	}
}
?>
