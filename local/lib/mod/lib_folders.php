<?

// ----------------------------------------------
// Class Docs Files for KMS
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class lib_folders extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

	var $table	= "kms_lib_folders";
	var $key	= "id";	
	var $fields = array("name", "creation_date", "status");
	var $notedit = array('group','icon','status','icon','creation_date');
	var $hidden = array('parent');
	var $readonly = array('parent');
	var $orderby = "creation_date";
	var $sortdir = "desc";
	var $title = _KMS_TY_LIB_FILES;
	var $action = array("key"=>"fb","action"=>"");	

        /*=[ PERMISSIONS ]===========================================================*/

        var $can_view = false;
        var $can_edit = true;
        var $can_delete = true;
        var $can_add   = true;
        var $can_import = false;
        var $can_export = false;
        var $can_search = false;
	var $can_mupload = false;
	
       //*=[ CONSTRUCTOR ]===========================================================*/

        function lib_folders($client_account,$user_account,$dm) {
                parent::mod($client_account,$user_account,$extranet);
        }

       //*=[ SETUP ]===========================================================*/

        function setup($client_account,$user_account,$dm) {

        $this->defvalue("status",0);
        $this->humanize("name",_MB_FOLDER);
        $this->setComponent("select","status",array(0=>"<font color='#ff831f'><b>"._KMS_WEB_PAGE_DRAFT."</b></font>", 1=>"<font color='#090'><b>"._KMS_WEB_PAGE_PUBLISHED."</b></font>"));
        $this->setComponent("select","permissions",array("r"=>"Read only","rw"=>"Read and write"));
        $this->defvalue("priority","normal");
        $uploadDate = date('y-m-d');
        $this->defvalue("creation_date",$uploadDate);
        $this->defvalue("downloadable",1);
//      $this->setComponent("uniselect","owner");
        $this->setComponent("xcombo","owner",array("xtable"=>"kms_sys_users","xkey"=>"username","xfield"=>"username","readonly"=>false, "linkcreate"=>false, "linkedit"=>false, "sql"=>""));

        $this->default_content_type = "files";
        $this->insert_label = _NEW_FOLDER;
        $this->setComponent("file","file",array($this->kms_datapath."files/files","http://data.".$this->current_domain."/files/files"));
        $this->setComponent("select","downloadable",array("0"=>"No","1"=>"Si"));
        $this->action("mupload","/usr/share/kms/lib/mupload/mupload.php");

        $this->onPreInsert = "onPreInsert";

        $select="select permissions from kms_lib_folders where id=".$_GET['folder'];
        $result=mysql_query($select);
        $folder=mysql_fetch_assoc($result);

        if ($folder['permissions']=="r") {
                $this->can_add=$this->can_mupload=$this->can_upload=false;
                 if ($_SESSION['username']!="admin") { $readonly = array('parent','owner','permissions','name'); }

                } else {
                  if ($_GET['folder']!="0"&&$_GET['folder']!="") {
                $this->can_mupload=false;
                $this->customButtons=Array();
                $this->customButtons[0] = Array ("label"=>_CMN_UPLOAD_FILES,"url"=>"/?_=f&action=mupload&view=&folder=".$_GET['folder']."&fback=".$_GET['folder'],"ico"=>"","params"=>"","target"=>"_self","checkFunction"=>"","class"=>"highlight");
                }

                }

	}

	function onPreInsert($post,$id) {
		$post['owner']=$_SESSION['user_name'];
		$post['folder']=$_SESSION['folder'];
		$post['status']=1;
		$post['group']=$_SESSION['user_groups'];
		$post['parent']=$_REQUEST['folder'];
		return $post;

	}
}
?>
