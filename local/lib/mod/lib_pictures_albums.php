<?

// ----------------------------------------------
// Class Docs Pictures Albums for KMS 
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class lib_pictures_albums extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

	var $table	= "kms_lib_pictures_albums";
	var $key	= "id";	
	var $fields = array("id","status", "gallery", "name", "description", "creation_date");
	var $hidden = array("private","owner","group","permissions");
	var $title = "Albums";
	var $orderby = "name";

        /*=[ PERMISSIONS ]===========================================================*/

        var $can_view = false;
        var $can_edit = true;
        var $can_delete = true;
        var $can_add   = true;
	var $can_duplicate = true;
        var $import = false;
        var $export = false;
        var $search = true;

      //*=[ CONSTRUCTOR ]===========================================================*/

        function lib_pictures_albums ($client_account,$user_account,$dm) {
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
		$this->setComponent("xcombo","gallery",array("xtable"=>"kms_sites_galleries","xkey"=>"id","xfield"=>"name","readonly"=>false,"linkcreate"=>false,"linkedit"=>false,"sql"=>""));
		$this->setComponent("picture","picture",array("path"=>"/var/www/vhosts/".$this->current_domain."/subdomains/data/httpdocs/files/pictures","url"=>"//data.".$this->current_domain."/files/pictures","resize_max_width"=>150,"resize_max_height"=>130,"thumb_max_width"=>100,"thumb_max_height"=>100,"scaleType"=>"w"));
		$this->addComment("name",_KMS_GL_REQUIREDFIELD);
		$this->addComment("resize_max_width",_KMS_GL_REQUIREDFIELD);
		$this->addComment("resize_max_height",_KMS_GL_REQUIREDFIELD);
		
		$this->alerts['delete']['msg']=_KMS_LIB_PICTURES_ALBUMS_DELETE_MSG;
		$this->onInsert = "onInsert";
		$this->onUpdate = "onUpdate";
		$this->onDelete = "onDelete";
	}

	function onInsert($post,$id) {
		$view_type=$this->getConf("sys_conf","lib_pictures_def_view_type");
		if ($view_type=="") $view_type="left";
		$album_name=mysqli_escape_string($post['name']);
		$insert="INSERT INTO kms_sys_views (`creation_date`,`name`,`type`,`module`,`where`,`orderby`,`sort`,`fields`) VALUES ('".date("Y-m-d")."','".$album_name."','{$view_type}','lib_pictures','album_id={$id}','id','desc','id,description,file,album_id,creation_date,sort_order');";
                $result=mysqli_query($this->dblinks['client'],$insert);
		if (!$result) die('error'.mysqli_error());
		mkdir('/var/www/vhosts/'.$this->current_domain.'/subdomains/data/httpdocs/files/pictures/albums/'.$id);
	}

        function onUpdate($post,$id) {
                mkdir('/var/www/vhosts/'.$this->current_domain.'/subdomains/data/httpdocs/files/pictures/albums/'.$id);
        }


	function onDelete($post,$id) {

	        $delete="DELETE from kms_sys_views where `module`='lib_pictures' and `where` like 'album_id={$id}'";
	        $result=mysqli_query($this->dblinks['client'],$delete);
	        if (!$result) die('error 1:'.mysqli_error());
		$result=mysqli_query($this->dblinks['client'],"ALTER TABLE kms_sys_views auto_increment=1");
		//delete also pics files
		$sel="SELECT * FROM kms_lib_pictures WHERE album_id=".$id;
		$result=mysqli_query($this->dblinks['client'],$sel);
		$this->rrmdir('/var/www/vhosts/'.$this->current_domain.'/subdomains/data/httpdocs/files/pictures/albums/'.$id);
		while ($row=mysqli_fetch_array($result)) {
			unlink('/var/www/vhosts/'.$this->current_domain.'/subdomains/data/httpdocs/files/pictures/'.$row['file']);
			unlink('/var/www/vhosts/'.$this->current_domain.'/subdomains/data/httpdocs/files/pictures/img_'.$row['file']);
			unlink('/var/www/vhosts/'.$this->current_domain.'/subdomains/data/httpdocs/files/pictures/thumb/'.$row['file']);
		}
		// delete database pictures records
		$delete="DELETE FROM kms_lib_pictures WHERE album_id=".$id;
		$result=mysqli_query($this->dblinks['client'],$delete);
		$result=mysqli_query($this->dblinks['client'],"ALTER TABLE kms_lib_pictures auto_increment=1");
                if (!$result) die('error 2:'.mysqli_error());
		
	}

	function rrmdir($dir) {
	   if (is_dir($dir)) {
	     $objects = scandir($dir);
	     foreach ($objects as $object) {
	       if ($object != "." && $object != "..") {
	         if (is_dir($dir. DIRECTORY_SEPARATOR .$object) && !is_link($dir."/".$object))
	           rrmdir($dir. DIRECTORY_SEPARATOR .$object);
	         else
	           unlink($dir. DIRECTORY_SEPARATOR .$object);
	       }
	     }
	     rmdir($dir);
	   }
	 }


}
?>
