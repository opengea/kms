<?

// ----------------------------------------------
// Class Docs Pictures Albums for KMS 
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class docs_pictures_albums extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

	var $table	= "kms_docs_pictures_albums";
	var $key	= "id";	
	var $fields = array("id","status", "gallery", "name", "description", "creation_date");
	var $title = "Albums";
	var $orderby = "name";

        /*=[ PERMISSIONS ]===========================================================*/

        var $can_view = true;
        var $can_edit = true;
        var $can_delete = true;
        var $can_add   = true;
        var $import = false;
        var $export = false;
        var $search = true;

      //*=[ CONSTRUCTOR ]===========================================================*/

        function docs_videos ($client_account,$user_account,$dm) {
                parent::mod($client_account,$user_account,$extranet);
        }

       //*=[ SETUP ]===========================================================*/

        function setup($client_account,$user_account,$dm) {

		$this->defvalue("creation_date",date('y-m-d'));
		$this->defvalue("status","1");
		$this->defvalue("private","1");
		$notedit = array("dr_folder","id");
		$this->setComponent("select","status",array("0"=>"<font color='#ff831f'><b>"._KMS_WEB_PAGE_DRAFT."</b></font>", "1"=>"<font color='#090'><b>"._KMS_WEB_PAGE_PUBLISHED."</b></font>"));

		// replace with rule xcombo:
		$this->setComponent("xcombo","gallery",array("xtable"=>"kms_docs_pictures_galleries","xkey"=>"id","xfield"=>"name","readonly"=>false,"linkcreate"=>false,"linkedit"=>false,"sql"=>""));
		$this->multixref("gallery", "id", "name", "kms_docs_pictures_galleries");

		$this->onInsert = "onInsert";
		$this->onDelete = "onDelete";
	}

	function onInsert($post,$id) {
	        $select="select id from kms_folders where content_type='views'";
	        $result=mysqli_query($this->dblinks['client'],$select);
	        $folder_views=mysqli_fetch_array($result);
		$insert="INSERT INTO kms_sys_views (`name`,`module`,`where`,`orderby`,`sort`) VALUES ('".mysqli_escape_string($post['name'])."','pictures','album_id=".$id."','creation_date','des');";
		$result=mysqli_query($this->dblinks['client'],$insert);
		if (!$result) die('error'.mysqli_error());
	}

	function onDelete($post,$id) {
	        $delete="DELETE from kms_sys_views where `where` like '%album_id=".$id."%'";
	        $result=mysqli_query($this->dblinks['client'],$delete);
	        if (!$result) die('error'.mysqli_error());
		$result=mysqli_query($this->dblinks['client'],"ALTER TABLE kms_sys_views auto_increment=1");
	}
}
?>
