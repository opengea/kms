<?

// ----------------------------------------------
// Class Sites Galleries for KMS 
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class sites_galleries extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

	var $table	= "kms_sites_galleries";
	var $key	= "id";	
	var $fields = array("id","status", "creation_date", "name", "description");
	var $orderby = "name";

	/*=[ PERMISOS ]===========================================================*/

	var $can_view = false;
	var $can_edit = true;
	var $can_delete = true;
	var $can_add   = true;
	var $can_import = false;
	var $can_export = false;
	var $can_search = true;
	var $can_duplicate = true;

       //*=[ CONSTRUCTOR ]===========================================================*/

        function sites_galleries ($client_account,$user_account,$dm) {
                parent::mod($client_account,$user_account,$extranet);
        }

        function setup($client_account,$user_account,$dm) {

		$this->defvalue("creation_date",date('Y-m-d H:i:s'));
		$this->defvalue("status","1");
		$this->defvalue("animSpeed",500);
		$this->defvalue("pauseTime",3000);
		$this->defvalue("directionNav","1");
		$this->defvalue("controlNav","1");
		$this->defvalue("controlNavThumbs","1");
		$this->defvalue("pauseOnHover","1");
		$this->defvalue("manualAdvance","0");
		$this->defvalue("randomStart","0");
		$this->defvalue("htmlCaption","0");

		$this->setComponent("checklist","directionNav",array("1"=>""));		
		$this->setComponent("checklist","zoomOnClick",array("1"=>""));
		$this->setComponent("checklist","controlNav",array("1"=>""));
		$this->setComponent("checklist","controlNavThumbs",array("1"=>""));
		$this->setComponent("checklist","pauseOnHover",array("1"=>""));
		$this->setComponent("checklist","manualAdvance",array("1"=>""));
		$this->setComponent("checklist","randomStart",array("1"=>""));
		$this->setComponent("checklist","showCaption",array("1"=>""));
		$this->setComponent("checklist","htmlCaption",array("1"=>""));
		$this->setComponent("checklist","showResized",array("1"=>""));

		$this->setComponent("select","status",array("0"=>"<font color='#ff831f'><b>"._KMS_WEB_PAGE_DRAFT."</b></font>", "1"=>"<font color='#090'><b>"._KMS_WEB_PAGE_PUBLISHED."</b></font>"));
		$this->setComponent("select","theme",array("default"=>"default","clever"=>"clever","light"=>"light","dark"=>"dark","bar"=>"bar"));
		$this->setComponent("select","player_size",array("fixed"=>"fixed","resizable"=>"resizable"));
		$this->setComponent("select","effect",array("random"=>"random","fold"=>"fold","fade"=>"fade","boxRandom"=>"boxRandom","boxRain"=>"boxRain","boxRainReverse"=>"boxRainReverse","boxRainGrow"=>"boxRainGrow","boxRainGrowReverse"=>"boxRainGrowReverse","sliceDownRight"=>"sliceDownRight","sliceDownLeft"=>"sliceDownLeft","sliceUpRight"=>"sliceUpRight","sliceUpLeft"=>"sliceUpLeft","sliceUpDown"=>"sliceUpDown","sliceUpDownLeft"=>"sliceUpDownLeft"));
		$this->setComponent("xcombo","play_album",array("xtable"=>"kms_lib_pictures_albums","xkey"=>"id","xfield"=>"name","readonly"=>false,"linkcreate"=>false,"linkedit"=>true,"sql"=>""));
	}
}
?>
