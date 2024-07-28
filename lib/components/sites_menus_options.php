<?
// ----------------------------------------------
// Class Sites Menus for KMS
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class sites_menus_options extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

	var $table	= "kms_sites_menus_options";
	var $key	= "id";	
	var $fields = array("id","menu_id","status","name","url");
	var $orderby = "id";
	var $readonly = array("menu_id");
	var $hidden = array("creation_date","menu_id","sort_order");

	var $can_duplicate=true;

       //*=[ CONSTRUCTOR ]===========================================================*/

        function sites_menus_options ($client_account,$user_account,$dm) {
                parent::mod($client_account,$user_account,$extranet);
        }

        function setup($client_account,$user_account,$dm) {
		$uploadDate = date('y-m-d');
		$this->defvalue("creation_date",$uploadDate);
		$this->defvalue("menu_id",$_GET['query']);
		$this->multixref("menu_id", "id", "name", "kms_sites_menus");
		 $this->setComponent("multilang","name",array("type"=>"textfield"));
	
		 $this->defvalue("status","1");
	         /*$this->setComponent("select","style",array("none"=>"--none--","standard"=>"standard","classic"=>"classic","simple"=>"simple","dropdown"=>"dropdown","unfold"=>"unfold","lined"=>"lined","rounded"=>"rounded","double"=>"double","grid"=>"grid"));*/
		$this->setComponent("select","status",array("1"=>"<font color='#009900'>"._KMS_GL_STATUS_ACTIVE."</font>", "0"=>"<font color='#990000'>"._KMS_GL_STATUS_INACTIVE."</font>"));
		$this->defvalue("menu","main");
//		$this->setComponent("select","menu",array("top"=>"top", "main"=>"main", "sidemenu"=>"sidemenu","footer"=>"footer"));
		//$this->setComponent("status_icon", "vr_manage", array("path"=>"/var/www/vhosts/".$this->current_domain."/subdomains/data/httpdocs/","script"=>"manage"));
		$this->setComponent("status_icon", "vr_manage", array("path"=>"/usr/local/kms/lib/mod/sites_menus_options/","script"=>"manage"));
		//$this->setComponent("select","location",array("top"=>"top", "main"=>"main", "left"=>"left","right"=>"right","bottom"=>"bottom"));
		//$this->setComponent("select","type",array("standard"=>"Standard","pop"=>"Pop","expanded"=>"Expanded","accordion"=>"Accordion"));
		$this->default_php = "variables.php";
		$this->setComponent("select","target",array("_self"=>_KMS_SITES_PAGES_TARGET_SELF,"_blank"=>_KMS_SITES_PAGES_TARGET_BLANK));
		$this->insert_label = _KMS_SITES_MENU_NEW;
	}
}
?>

