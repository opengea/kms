<?

// ----------------------------------------------
// Class Sites Blogs Posts for KMS
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class docs_articles extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

	var $table	= "kms_docs_articles";
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

        function docs_articles ($client_account,$user_account,$dm) {
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
		$uploadDate = date('Y-m-d h:i:s');
		$this->defvalue("creation_date",$uploadDate);
		$this->setComponent("tags","tags");
		$this->customOptions = Array();
//		$this->customOptions[0] = Array ("label"=>_KMS_GL_PREVIEW,"url"=>"http://www.".$current_domain."/articles/preview/[title]?","ico"=>"details.gif","params"=>"","target"=>"new");
		$this->customOptions[0] = Array ("label"=>_KMS_GL_PREVIEW,"url"=>"http://www.".$current_domain."/kms/lib/app/blog/blog_preview.php?title=[title]&blogid=[blogid]&domain=$current_domain&","ico"=>"details.gif","params"=>"","target"=>"new");

		$this->insert_label = _KMS_NEW_WEB_BLOG_POST;
		$this->defvalue("category","");
		$this->setComponent("uniselect","category");
		$this->setComponent("wysiwyg","short_body");
		$this->setComponent("wysiwyg","body");
		$this->setComponent("select","status",array("draft"=>"<font color='#ff831f'><b>"._KMS_WEB_PAGE_DRAFT."</b></font>", "published"=>"<font color='#090'><b>"._KMS_WEB_PAGE_PUBLISHED."</b></font>"));
		$this->setComponent("xcombo","blogid",array("xtable"=>"kms_sites_blogs","xkey"=>"id","xfield"=>"name","readonly"=>false,"linkcreate"=>true,"linkedit"=>true,"sql"=>""));
		$this->setComponent("picture","picture",array("path"=>"/var/www/vhosts/".$this->current_domain."/subdomains/data/httpdocs/files/pictures","url"=>"http://data.".$this->current_domain."/files/pictures","resize_max_width"=>600,"resize_max_height"=>365,"thumb_max_width"=>150,"thumb_max_height"=>50,"scaleType"=>"w"));
		$this->onInsert = "onInsert";
		$this->onDelete = "onDelete";

	}

	function onInsert($post,$id) {
		// hem de llegir el filename de la imatge que s'ha pujat
		$select="select * from kms_docs_articles where id='{$id}'";
	        $result=mysqli_query($this->dblinks['client'],$select);
        	$post=mysqli_fetch_array($result);

		//si imatge no esta a pictures l'afegim
		$select="select file from kms_lib_pictures where file='".$post['picture']."'";
		$result=mysqli_query($this->dblinks['client'],$select);
		$pic=mysqli_fetch_array($result);

		if ($pic[0]!=$post['picture']) {	
	        $insert="INSERT INTO kms_lib_pictures (`creation_date`,`description`,`file`, `album_id`) VALUES (\"".date("Y-m-d")."\",\"".str_replace('"',"'",$post['title'])."\",\"".$post['picture']."\",\"_KMS_PICTURES_ALBUMS_BLOGPICTURES\");";
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
