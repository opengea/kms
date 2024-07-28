<?

// ----------------------------------------------
// Class Docs Pictures Galleries for KMS 
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class docs_pictures_galleries extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

	var $table	= "kms_docs_pictures_galleries";
	var $key	= "id";	
	var $fields = array("status", "creation_date", "name", "description");
	var $title = "Albums";
	var $orderby = "name";

	/*=[ PERMISOS ]===========================================================*/

	var $can_view = true;
	var $can_edit = true;
	var $can_delete = true;
	var $can_add   = true;
	var $can_import = false;
	var $can_export = false;
	var $can_search = true;
	var $can_duplicate = true;

       //*=[ CONSTRUCTOR ]===========================================================*/

        function docs_pictures_galleries ($client_account,$user_account,$dm) {
                parent::mod($client_account,$user_account,$extranet);
        }

        function setup($client_account,$user_account,$dm) {

		$this->defvalue("creation_date",date('y-m-d'));
		$this->defvalue("status","1");
		$this->defvalue("max_resize_width","720");
		$this->defvalue("max_resize_height","365");
		$this->defvalue("max_thumb_width","100");
		$this->defvalue("max_thumb_height","100");
		$this->defvalue("scaleType","h");
		$this->defvalue("animate",1);
		$this->defvalue("animateFade",1);
		$this->defvalue("animSequence","wh");
		$this->defvalue("autoplayMovies",1);
		$this->defvalue("continous","0");
		$this->defvalue("counterType","default");
		$this->defvalue("counterLimit","10");
		$this->defvalue("displayCounter",1);
		$this->defvalue("displayNav",1);
		$this->defvalue("enableKeys",1);
		$this->defvalue("fadeDuration","0.35");
		$this->defvalue("flashParams","{bgcolor:\"#000000\"}");
		$this->defvalue("flashVars","{}");
		$this->defvalue("flashVersion","9.0.0");
		$this->defvalue("handleOversize","drag");
		$this->defvalue("handleUnsupported","link");
		$this->defvalue("initialWidth","320");
		$this->defvalue("initialHeight","160");
		$this->defvalue("modal",0);
		$this->defvalue("overlayColor","#000");
		$this->defvalue("overlayOpacity","0.5");
		$this->defvalue("resizeDuration","0.35");
		$this->defvalue("showOverlay",1);
		$this->defvalue("showMovieControls",1);
		$this->defvalue("skipSetup",1);
		$this->defvalue("slideshowDelay",0);
		$this->defvalue("troubleElements","[\"select\", \"object\", \"embed\", \"canvas\"]");
		$this->defvalue("viewportPadding",20);
		$this->defvalue("default_gallery_action","autoplay");
		$this->defvalue("default_album_action","autoplay");

		$notedit = array("dr_folder","id");
		$this->setComponent("checklist","animate",array("1"=>""));
		$this->setComponent("checklist","animateFade",array("1"=>""));
		$this->setComponent("checklist","autoplayMovies",array("1"=>""));
		$this->setComponent("checklist","continous",array("1"=>""));
		$this->setComponent("checklist","displayCounter",array("1"=>""));
		$this->setComponent("checklist","displayNav",array("1"=>""));
		$this->setComponent("checklist","enableKeys",array("1"=>""));
		$this->setComponent("checklist","enable_albums_menu",array("1"=>""));
		$this->setComponent("checklist","modal",array("1"=>""));
		$this->setComponent("checklist","showOverlay",array("1"=>""));
		$this->setComponent("checklist","showMovieControls",array("1"=>""));
		$this->setComponent("checklist","skipSetup",array("1"=>""));
		$this->setComponent("select","status",array("0"=>"<font color='#ff831f'><b>"._KMS_WEB_PAGE_DRAFT."</b></font>", "1"=>"<font color='#090'><b>"._KMS_WEB_PAGE_PUBLISHED."</b></font>"));
		$this->setComponent("select","scaleType",array("w"=>"force width","h"=>"force height"));
		$this->setComponent("select","animSequence",array("wh"=>"width first, then height","hw"=>"height first, then width","sync"=>"both simultaneously"));
		$this->setComponent("select","counterType",array("default"=>"default","skip"=>"skip"));
		$this->setComponent("select","handleOversize",array("none"=>"none","resize"=>"resize","drag"=>"drag"));
		$this->setComponent("select","handleUnsupported",array("link"=>"link","remove"=>"remove"));
		$this->setComponent("select","default_gallery_action",array("none"=>"none","autoplay_ranxid"=>"autoplay (ranxid)","autoplay_date"=>"autoplay (date)","autoplay_featured"=>"autoplay (only featured)","photogrid"=>"show photo grid","albums"=>"show albums"));
		$this->setComponent("select","default_album_action",array("none"=>"none","autoplay_ranxid"=>"autoplay (ranxid)","autoplay_date"=>"autoplay (date)","autoplay_featured"=>"autoplay (only featured)","photogrid"=>"show photo grid"));
		$this->setComponent("uniselect","type");
	}
}
?>
