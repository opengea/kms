<?

// ----------------------------------------------
// Class Sites Blogs Posts for KMS
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class sites_blogs_posts extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

	var $table	= "kms_sites_blogs_posts";
	var $key	= "id";	
	var $fields = array("creation_date", "blogid", "status",  "title", "tags", "category", "lectures");
	var $orderby = "creation_date";
	var $sortdir = "desc";
	var $notedit = array("userid","subtitle","karma","labels","dr_folder");
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

        function sites_blogs_posts ($client_account,$user_account,$dm) {
                parent::mod($client_account,$user_account,$extranet);
        }

        //*=[ USER FUNCTIONS PATCH ]==================================================*/ 
        // This is needed to declare member functions outside the class. Just define them as "ClassName__FunctionName" and call it normally $this->FuncionName

        function __call($name, $args) {
                call_user_func_array(sprintf('%s__%s', get_class($this), $name), array_merge(array($this), $args));
        }

        function setup($client_account,$user_account,$dm) {

		$this->humanize("dr_folder","Carpeta");
		$this->humanize("file","Imatge");
		$this->humanize("image","Frame");
		$uploadDate = date('y-m-d h:i:s');
		$this->defvalue("creation_date",$uploadDate);
		$this->setComponent("tags","tags");
		$this->customOptions = Array();
		$this->customOptions[0] = Array ("label"=>_KMS_GL_PREVIEW,"url"=>"http://www.".$current_domain."/articles/preview/[title]?","ico"=>"details.gif","params"=>"","target"=>"new");
		$this->insert_label = _KMS_NEW_WEB_BLOG_POST;
		$this->defvalue("category","Articles");
		$this->setComponent("uniselect","category");
		$this->setComponent("wysiwyg","short_body");
		$this->setComponent("wysiwyg","body");
		$this->setComponent("select","status",array("draft"=>"<font color='#ff831f'><b>"._KMS_WEB_PAGE_DRAFT."</b></font>", "published"=>"<font color='#090'><b>"._KMS_WEB_PAGE_PUBLISHED."</b></font>"));
		$this->setComponent("xcombo","blogid",array("xtable"=>"kms_sites_blogs","xkey"=>"id","xfield"=>"name","readonly"=>false,"linkcreate"=>true,"linkedit"=>true,"sql"=>""));
		$this->onInsert = "onInsert";
		$this->onDelete = "onDelete";
	}

	function onInsert($post,$id) {
/*	        $select="select id from kms_folders where content_type='pictures'";
	        $result=mysqli_query($this->dblinks['client'],$select);
	        $folders=mysqli_fetch_array($result);
	        if ($folders['id']=="") die ("Trying to insert picture on pictures mod. 'Pictures' mod does not exist.");
	
*/
		// hem de llegir el filename de la imatge que s'ha pujat
		$select="select * from kms_sites_blogs_posts where id='{$id}'";
	        $result=mysqli_query($this->dblinks['client'],$select);
        	$post=mysqli_fetch_array($result);

		//si imatge no esta a pictures l'afegim
		$select="select file from kms_docs_pictures where file='".$post['picture']."'";
		$result=mysqli_query($this->dblinks['client'],$select);
		$pic=mysqli_fetch_array($result);

		if ($pic[0]!=$post['picture']) {	
	        $insert="INSERT INTO kms_docs_pictures (`creation_date`,`dr_folder`,`description`,`file`, `album_id`) VALUES (\"".date("Y-m-d")."\",".$folders['id'].",\"".str_replace('"',"'",$post['title'])."\",\"".$post['picture']."\",\"_KMS_PICTURES_ALBUMS_BLOGPICTURES\");";
	        $result=mysqli_query($this->dblinks['client'],$insert);
	        if (!$result) die('error'.mysqli_error()."<br><br>.SQL:".$insert);
		}
	}

	function onDelete($post,$id) {
	//        $delete="DELETE from kms_sys_views where `id`='".$post['id']."'";
	   //     $result=mysqli_query($this->dblinks['client'],$delete);
	     //   if (!$result) die('error'.mysqli_error());
	}

} // class
?>	
