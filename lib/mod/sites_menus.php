<?
// ----------------------------------------------
// Class Sites Menus for KMS
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class sites_menus extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

	var $table	= "kms_sites_menus";
	var $key	= "id";	
	var $fields = array("status","name","parent_menu","vr_manage");
	var $orderby = "id";
	var $hidden = array("creation_date","sort_order");

	var $can_duplicate=true;

       //*=[ CONSTRUCTOR ]===========================================================*/

        function sites_menus ($client_account,$user_account,$dm) {
                parent::mod($client_account,$user_account,$extranet);
        }

        function setup($client_account,$user_account,$dm) {
		$uploadDate = date('y-m-d');
		$this->defvalue("creation_date",$uploadDate);
		$this->defvalue("target","_self");
		 $this->defvalue("status","1");
	         /*$this->setComponent("select","style",array("none"=>"--none--","standard"=>"standard","classic"=>"classic","simple"=>"simple","dropdown"=>"dropdown","unfold"=>"unfold","lined"=>"lined","rounded"=>"rounded","double"=>"double","grid"=>"grid"));*/
		$this->setComponent("select","status",array("1"=>"<font color='#009900'>"._KMS_GL_STATUS_ACTIVE."</font>", "0"=>"<font color='#990000'>"._KMS_GL_STATUS_INACTIVE."</font>"));
		$this->defvalue("menu","main");
		$this->setComponent("select","menu",array("top"=>"top", "main"=>"main", "sidemenu"=>"sidemenu","footer"=>"footer"));
		$this->setComponent("status_icon", "vr_manage", array("path"=>"/usr/local/kms/lib/mod/sites_menus/","script"=>"manage"));
		//$this->setComponent("select","location",array("top"=>"top", "main"=>"main", "left"=>"left","right"=>"right","bottom"=>"bottom"));
		//$this->setComponent("select","type",array("standard"=>"Standard","pop"=>"Pop","expanded"=>"Expanded","accordion"=>"Accordion"));
		$this->setComponent("xcombo","parent_menu",array("xtable"=>"kms_sites_menus","xkey"=>"id","xfield"=>"name","readonly"=>false,"linkcreate"=>true,"linkedit"=>true,"sql"=>"select id,name from kms_sites_menus where parent_menu=\"0\""));
		$this->default_php = "variables.php";
		$this->setComponent("select","target",array("_self"=>_KMS_SITES_PAGES_TARGET_SELF,"_blank"=>_KMS_SITES_PAGES_TARGET_BLANK));
		$this->insert_label = _KMS_SITES_MENU_NEW;

                $this->onFieldChange("parent_menu","onParentChange(this.value)");
                $this->onDocumentReady("function onParentChange(parent) { console.log(parent);  } ");

	}
}
?>

