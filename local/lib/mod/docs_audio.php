<?

// ----------------------------------------------
// Class Docs Audios for KMS
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class docs_audio extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

        var $table  = "kms_docs_files";
	var $key	= "id";	
	var $fields = array("status", "file", "name", "creation_date", "downloadcount");
	var $notedit = array('dr_folder',"external_url", "size");
	var $orderby = "creation_date";

        /*=[ PERMISSIONS ]===========================================================*/

	var $can_view = true;
	var $can_edit = true;
	var $can_delete = true;
	var $can_add   = true;
	var $import = false;
	var $export = false;
	var $search = true;

       //*=[ CONSTRUCTOR ]===========================================================*/

        function docs_audio ($client_account,$user_account,$dm) {
                parent::mod($client_account,$user_account,$extranet);
        }

       //*=[ SETUP ]===========================================================*/

        function setup($client_account,$user_account,$dm) {

	$this->defvalue("status","active");
	$this->setComponent("select","status",array("draft"=>"<font color='#ff831f'><b>"._KMS_WEB_PAGE_DRAFT."</b></font>", "published"=>"<font color='#090'><b>"._KMS_WEB_PAGE_PUBLISHED."</b></font>"));
	$this->defvalue("priority","normal");
	$uploadDate = date('y-m-d');
	$this->defvalue("creation_date",$uploadDate);
	$this->default_content_type = "files";
	$this->insert_label = _NEW_FILE;
	$this->setComponent("file","file",array($this->kms_datapath."files/mp3","files/mp3"));
	$this->setComponent("select","downloadable",array("0"=>"No","1"=>"Si"));

	}

}
?>
