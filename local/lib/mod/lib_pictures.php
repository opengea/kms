<?

// ----------------------------------------------
// Class Library Pictures for KMS 
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class lib_pictures extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

	var $table	= "kms_lib_pictures";
	var $key	= "id";	
	var $fields	= array("id", "file", "description", "creation_date");
	var $hidden 	= array("caption","mod","fieldname","path","owner","group","folder_id","creation_date","sort_order","sortorder","permissions","status");
	var $readonly	= array();
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

        function lib_pictures($client_account,$user_account,$dm) {
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
		$This->setComponent("select","status",array("0"=>"<font color='#ff831f'><b>"._KMS_WEB_PAGE_DRAFT."</b></font>", "1"=>"<font color='#090'><b>"._KMS_WEB_PAGE_PUBLISHED."</b></font>"));	
		if ($_GET['_']=="i") { array_push($This->hidden,"creation_date"); array_push($This->hidden,"path");  array_push($This->hidden,"link");}
		if ($_GET['_']=="e") array_push($This->readonly,"path");
	        // set draggable
                $This->uid=$This-key;
                $This->rowclick = "drag"; //"edit"; //need $This->uid=$This-key; on setup(), and orderby="sort_order"
                $This->orderby="sort_order";
		$This->setComponent("tags","tags");
	
		$uploadDate = date('Y-m-d');
		$This->defvalue("creation_date",$uploadDate);
//		$This->defvalue("path","/var/www/vhosts/".$this->current_domain."/subdomains/data/httpdocs/files/pictures/lib_pictures/albums/");
		$This->insert_label = _NEW_PICTURE;
		$notedit = array("dr_folder");
                $This->setComponent("xcombo","album_id",array("xtable"=>"kms_lib_pictures_albums","xkey"=>"id","xfield"=>"name","readonly"=>false, "linkcreate"=>true, "linkedit"=>true, "sql"=>"select id,name from kms_lib_pictures_albums"));

//		$select="SELECT * FROM kms_lib_pictures_albums WHERE kms_lib_pictures_albums.id=kms_lib_pictures.album AND kms_lib_pictures.album={$_GET["dr_folder"]} LIMIT 1";
		$This->action("mupload","/usr/share/kms/lib/mupload/mupload.php");
		$This->action("lib_pictures_albums","/usr/share/kms/mod/lib/pictures_albums.php");

		$This->customButtons=Array();
                $This->customButtons[0] = Array ("label"=>_KMS_TY_DOCS_PICTURES_ALBUMS,"url"=>"/?app=".$_GET['app']."&mod=lib_pictures_albums","ico"=>"","params"=>"mod=lib_pictures_albums","target"=>"_self","checkFunction"=>"");


		//if has album, get their sizes of scaled and thumb
		$select="SELECT album_id FROM kms_lib_pictures where id=".$_GET['id'];
		$result=mysqli_query($this->dblinks['client'],$select);
		$album_id=mysqli_fetch_array($result);
		
		if ($album_id[0]!="") {
			$select="SELECT * FROM kms_lib_pictures_albums WHERE id=".$album_id[0];
			$result=mysqli_query($this->dblinks['client'],$select);
	        	$album=mysqli_fetch_array($result);
		        $thumb_max_width=$album['max_thumb_width'];
        	        $thumb_max_height=$album['max_thumb_height'];
			$resize_max_width=$album['max_resize_width'];
	                $resize_max_height=$album['max_resize_height'];
		} else {
			$resize_max_width="720";$resize_max_height="365";
	                $thumb_max_width="100"; $thumb_max_height="100"; 
		}

		$This->setComponent("picture","file",array("path"=>"/var/www/vhosts/".$This->current_domain."/subdomains/data/httpdocs/files/pictures","url"=>"//data.".$This->current_domain."/files/pictures","resize_max_width"=>$resize_max_width,"resize_max_height"=>$resize_max_height,"thumb_max_width"=>$thumb_max_width,"thumb_max_height"=>$thumb_max_height,"scaleType"=>"w"));
		$This->onPreDelete ="onPreDelete";
		$This->onPreUpdate ="onPreUpdate";

                if ($_GET['album_id']!="") {
                        //quick view system
                        $This->where="album_id=".$_GET['album_id'];
                        $This->can_mupload=false;
                        $This->customButtons=Array();
                }


                $This->setGroup("Meta",true,array("creation_date","description","caption","tags"));
		$This->setGroup("_KMS_GL_OWNERSHIP",true,array("owner","group","permissions"));

		$This->onPreInsert = "onPreInsert";
		$this->onPreInsert = "onPreInsert";

	}

	function onPreInsert ($post,$id) {
		//no entra!
		return $post;
	}

	function onPreDelete($post,$id) {
		unlink ("/var/www/vhosts/".$this->current_domain."/subdomains/data/httpdocs/files/pictures/".$post['file']);
		unlink ("/var/www/vhosts/".$this->current_domain."/subdomains/data/httpdocs/files/pictures/img_".$post['file']);
		unlink ("/var/www/vhosts/".$this->current_domain."/subdomains/data/httpdocs/files/pictures/thumb/".$post['file']);
                $select="SELECT album_id FROM kms_lib_pictures where id=".$id;
                $result=mysql_query($select);
                $album_id=mysql_fetch_array($result);
                $url_base="/var/www/vhosts/".$this->current_domain."/subdomains/data/httpdocs";
                unlink ("/var/www/vhosts/".$this->current_domain."/subdomains/data/httpdocs/files/pictures/albums/".$post['album_id']."/".$post['file']);
	}

       function onPreUpdate($post,$id) {

                $select="SELECT album_id FROM kms_lib_pictures where id=".$id;
                $result=mysql_query($select);
                $album_id=mysql_fetch_array($result);

                $url_base="/var/www/vhosts/".$this->current_domain."/subdomains/data/httpdocs";
                //move_uploaded_file($url_base."/files/pictures/".$post['file'],$url_base."/files/pictures/albums/".$post['album_id']."/".$post['file']);
                $result=rename($url_base."/files/pictures/albums/".$album_id[0]."/".$post['file'],$url_base."/files/pictures/albums/".$post['album_id']."/".$post['file']);
                if (!$result) { die("Can't move file from ".$url_base."/files/pictures/albums/".$album_id[0]."/".$post['file']." TO ".$url_base."/files/pictures/albums/".$post['album_id']."/".$post['file']); }


        }


}
?>
