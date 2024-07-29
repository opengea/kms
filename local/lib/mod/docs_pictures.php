<?

// ----------------------------------------------
// Class Docs Pictures for KMS 
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class docs_pictures extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

	var $table	= "kms_docs_pictures";
	var $key	= "id";	
	var $fields	= array("id", "description", "file", "album_id", "sortorder", "creation_date");
	var $orderby = "creation_date";
	var $sortdir = "desc";

        /*=[ PERMISSIONS ]===========================================================*/

        var $can_view = true;
        var $can_edit = true;
        var $can_delete = true;
        var $can_add   = false;
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

		$uploadDate = date('y-m-d');
		$this->defvalue("creation_date",$uploadDate);
		$this->default_content_type = "pictures";
		$this->default_php = "pictures.php";
		$this->insert_label = _NEW_PICTURE;
		$notedit = array("dr_folder");
                $this->setComponent("xcombo","album_id",array("xtable"=>"kms_docs_pictures_albums","xkey"=>"id","xfield"=>"name","readonly"=>false, "linkcreate"=>true, "linkedit"=>true, "sql"=>"select * from kms_docs_pictures_albums order by name"));

//		$select="SELECT * FROM kms_docs_pictures_albums WHERE kms_docs_pictures_albums.id=kms_docs_pictures.album AND kms_docs_pictures.album={$_GET["dr_folder"]} LIMIT 1";
		$this->action("mupload","/usr/share/kms/lib/mupload/mupload.php");
		$this->action("docs_pictures_albums","/usr/share/kms/mod/kbase/docs_pictures_albums.php");

		$this->customButtons=Array();
                $this->customButtons[0] = Array ("label"=>_KMS_TY_DOCS_PICTURES_ALBUMS,"url"=>"","ico"=>"","params"=>"action=docs_pictures_albums","target"=>"new","checkFunction"=>"");


		$this->setComponent("picture","file",array("path"=>"/var/www/vhosts/".$this->current_domain."/subdomains/data/httpdocs/files/pictures","url"=>"http://data.".$this->current_domain."/files/pictures","resize_max_width"=>720,"resize_max_height"=>365,"thumb_max_width"=>100,"thumb_max_height"=>100,"scaleType"=>"w"));
		$this->onPreDelete ="onPreDelete";
	}

	function onPreDelete($post,$id) {
		unlink ("/var/www/vhosts/".$this->current_domain."/subdomains/data/httpdocs/files/pictures/".$post['file']);
		unlink ("/var/www/vhosts/".$this->current_domain."/subdomains/data/httpdocs/files/pictures/img_".$post['file']);
		unlink ("/var/www/vhosts/".$this->current_domain."/subdomains/data/httpdocs/files/pictures/thumb/".$post['file']);
	}
}
?>
