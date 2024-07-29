<?

// ----------------------------------------------
// Class Library Pictures for KMS 
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class docs_videos extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

	var $table	= "kms_docs_videos";
	var $key	= "id";	
	var $fields	= array("id", "image", "file", "title", "category");
	var $hidden 	= array("");
	var $readonly	= array("");
	var $orderby 	= "sort_order";
	var $sortdir 	= "desc";

        /*=[ PERMISSIONS ]===========================================================*/

        var $can_view 	 = false;
        var $can_edit 	 = true;
        var $can_delete  = true;
        var $can_add   	 = false;
        var $can_import  = false;
        var $can_export  = false;
        var $can_search  = true;
        var $can_mupload = true;

       //*=[ CONSTRUCTOR ]===========================================================*/

        function docs_videos($client_account,$user_account,$dm) {
                parent::mod($client_account,$user_account,$extranet);
        }

        //*=[ USER FUNCTIONS PATCH ]==================================================*/ 
        // This is needed to declare member functions outside the class. Just define them as "ClassName__FunctionName" and call it normally $this->FuncionName

        function __call($name, $args) {
                call_user_func_array(sprintf('%s__%s', get_class($this), $name), array_merge(array($this), $args));
        }


       //*=[ SETUP ]===========================================================*/

        function setup($client_account,$user_account,$dm,$This) {

		if ($This=="") $This=$this;
                $This->setComponent("select","status",array("queued"=>"<font color='#ff831f'><b>Queued</b></font>", "converting"=>"<font color='#6f831f'><b>Converting</b></font>","published"=>"<font color='#090'><b>"._KMS_WEB_PAGE_PUBLISHED."</b></font>"));

		if ($_GET['_']=="e") {array_push($This->readonly,"mod"); array_push($This->readonly,"fieldname"); }
                // set draggable
                $This->uid=$This-key;
                $This->rowclick = "drag"; //"edit"; //need $This->uid=$This-key; on setup(), and orderby="sort_order"
                $This->orderby="sort_order";
		$This->setComponent("tags","tags");
		$This->humanize("mod",_KMS_SYS_VIEWS_MODULE);
		$This->humanize("fieldname",_KMS_TY_OBJECT);
		$This->humanize("origin_id","Registre relacionat");
		$uploadDate = date('Y-m-d');
		$This->defvalue("creation_date",$uploadDate);
		$This->insert_label = _NEW_VIDEO;
		$notedit = array("dr_folder");

//		$select="SELECT * FROM kms_docs_videos_albums WHERE kms_docs_videos_albums.id=kms_docs_videos.album AND kms_docs_videos.album={$_GET["dr_folder"]} LIMIT 1";
		$This->action("mupload","/usr/share/kms/lib/mupload/mupload.php");
		$This->action("docs_videos_albums","/usr/share/kms/mod/lib/videos_albums.php");

		$This->customButtons=Array();
                $This->customButtons[0] = Array ("label"=>_KMS_TY_DOCS_PICTURES_ALBUMS,"url"=>"/?app=".$_GET['app']."&mod=docs_videos_albums","ico"=>"","params"=>"mod=docs_videos_albums","target"=>"_self","checkFunction"=>"");


		$This->setComponent("picture","image",array("path"=>"/var/www/vhosts/".$This->current_domain."/subdomains/data/httpdocs/files/videos","url"=>"//data.".$This->current_domain."/files/videos","resize_max_width"=>$resize_max_width,"resize_max_height"=>$resize_max_height,"thumb_max_width"=>$thumb_max_width,"thumb_max_height"=>$thumb_max_height,"scaleType"=>"w"));
		$This->setComponent("video","file",array("path"=>"/var/www/vhosts/".$This->current_domain."/subdomains/data/httpdocs/files/videos","url"=>"//data.".$This->current_domain."/files/videos","resize_max_width"=>$resize_max_width,"resize_max_height"=>$resize_max_height,"thumb_max_width"=>$thumb_max_width,"thumb_max_height"=>$thumb_max_height,"scaleType"=>"w"));
		$this->onPreDelete ="onPreDelete";

		if ($_GET['_']=="e") { 
//	                include "shared/db_links.php";
			//registe relacionat
	                $pic=$this->dbi->get_record("SELECT * from kms_docs_videos WHERE id=".$_GET['id']);
			if ($pic['origin_id']!=0) {
                	$This->setComponent("xcombo","origin_id",array("xtable"=>"kms_".$pic['mod'],"xkey"=>"id","xfield"=>$pic['fieldname'],"readonly"=>false, "linkcreate"=>false, "linkedit"=>false, "sql"=>"select id,".$pic['fieldname']." from kms_".$pic['mod']));
			}
		}

		$This->setStyle("origin_id","width:50px;max-width:100px","b");
                $This->setGroup("Meta",true,array("creation_date","description","caption","tags"));
		$This->setGroup("_KMS_GL_RELATIONS",true,array("mod","fieldname","origin_id","album_id"));
		$This->setGroup("_KMS_GL_OWNERSHIP",true,array("owner","group","permissions"));

	}

	function onPreDelete($post,$id) {
		unlink ("/var/www/vhosts/".$this->current_domain."/subdomains/data/httpdocs/files/videos/".$post['file']);
		unlink ("/var/www/vhosts/".$this->current_domain."/subdomains/data/httpdocs/files/videos/img_".$post['file']);
		unlink ("/var/www/vhosts/".$this->current_domain."/subdomains/data/httpdocs/files/videos/thumb/".$post['file']);
	}
}
?>
