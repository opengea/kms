<?

// ----------------------------------------------
// Class Docs Files for KMS
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class lib_files extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

	var $table	= "kms_lib_files";
	var $key	= "id";	
	var $fields = array("status", "file", "name", "creation_date");
	var $notedit = array('dr_folder',"external_url", "size");
	var $orderby = "creation_date";
	var $sortdir = "desc";
	var $title = _KMS_TY_LIB_FILES;
	var $hidden = array("folder_id","owner","group","permissions","downloadCount");
	var $readonly = array("owner","group","permissions","downloadCount");
//	var $action = array("key"=>"fb","action"=>"");	

        /*=[ PERMISSIONS ]===========================================================*/

        var $can_view = false;
        var $can_edit = true;
        var $can_delete = true;
        var $can_add   = false;
	var $can_duplicate = true;
        var $can_import = false;
        var $can_export = false;
        var $can_search = true;
	var $can_mupload = true;
	
       //*=[ CONSTRUCTOR ]===========================================================*/

        function lib_files($client_account,$user_account,$dm) {
                parent::mod($client_account,$user_account,$extranet);
        }

        //*=[ USER FUNCTIONS PATCH ]==================================================*/ 
        // This is needed to declare member functions outside the class. Just define them as "ClassName__FunctionName" and call it normally $this->FuncionName

        function __call($name, $args) {
                call_user_func_array(sprintf('%s__%s', get_class($this), $name), array_merge(array($this), $args));
        }

       //*=[ SETUP ]===========================================================*/

        function setup($client_account,$user_account,$dm) {

	$this->setComponent("wysiwyg","description",array("type"=>"richtext"));

	$this->defvalue("status",0);
	$this->setComponent("select","status",array(0=>"<font color='#ff831f'><b>"._KMS_WEB_PAGE_DRAFT."</b></font>", 1=>"<font color='#090'><b>"._KMS_WEB_PAGE_PUBLISHED."</b></font>"));
	$this->defvalue("priority","normal");
	$uploadDate = date('y-m-d');
	$this->defvalue("creation_date",$uploadDate);
	$this->defvalue("downloadable",1);
	$this->default_content_type = "files";
	$this->insert_label = _NEW_FILE;
	$this->setComponent("file","file",array($this->kms_datapath."files/files","http://data.".$this->current_domain."/files/files"));
	$this->setComponent("select","downloadable",array("0"=>"No","1"=>"Si"));
	$this->action("mupload","/usr/share/kms/lib/mupload/mupload.php");

//	$_GET['mod']="lib_folders";
	$this->customButtons=Array();
	if ($_GET['folder']=="") $_GET['folder']=0;
        $this->customButtons[0] = Array ("label"=>_MB_NEWFOLDER,"url"=>"/?menu=&_=i","ico"=>"","params"=>"mod=lib_folders&folder=".$_GET['folder'],"target"=>"_self","checkFunction"=>"","class"=>"highlight");
	$this->action("new_folder","/usr/local/kms/mod/isp/domains/index.php");

	}
}
?>
