<?

// ----------------------------------------------
// Class Sites Themes for KMS
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class sites_themes extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

	var $table	= "kms_sites_themes";
	var $key	= "id";	
	var $fields = array("name");
	var $title = "Templates";
	var $orderby = "id";
	var $notedit=array("dr_folder","creation_date");

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

        function sites_themes ($client_account,$user_account,$dm) {
                parent::mod($client_account,$user_account,$extranet);
        }

        function setup($client_account,$user_account,$dm) {

		$this->humanize("title","titol");
		$uploadDate = date('y-m-d');
		$this->defvalue("creation_date",$uploadDate);
		$this->defvalue("template","default");
		$this->defvalue("button_history",0);
		$this->defvalue("button_edit",0);
		$this->defvalue("button_admin",0);
		$this->defvalue("button_subscription",1);
		$this->defvalue("button_login",1);
		$this->defvalue("homepage","index");
		$this->defvalue("robots","all");
		$this->defvalue("status","online");
		$this->defvalue("webwidth","840");
		$this->setStyle("font-family","width:300px");
		$this->setStyle("line_height","width:60px");

		$this->insert_label = _NEW_THEME;
		$linkfield = "domain";
		$this->setComponent("select","status",array("online"=>"<font color='#009900'>online</font>", "offline"=>"<font color='#990000'>offline</font>"));
		$this->setComponent("select","width_unit",array("px"=>"pixels","%"=>"%"));
		$this->setComponent("select","menu_float",array("left"=>"left","right"=>"right"));
		$this->setComponent("select","lang",array("ct"=>"catal&agrave;", "es"=>"espa&ntilde;ol", "en-UK"=>"english"));
		$this->setComponent("select","charset",array("iso-8859-15"=>"iso-8859-15","utf-8"=>"utf-8"));
		$this->setComponent("select","search_style",array("classic"=>"classic","rounded"=>"rounded","minimal"=>"minimal","dark"=>"dark"));
                $this->setComponent("select","searchengine",array("none"=>"none", "top"=>"top", "head"=>"head", "menu"=>"menu"));
		$this->setComponent("select","h1_style",array("wide"=>"wide","inher"=>"inher","inset"=>"inset"));
		$this->setComponent("select","language_selector",array("list-names"=>"list-names","list-codes"=>"list-codes","list-flags"=>"list-flags","dropdown"=>"dropdown"));
// obsolete menu v1
//		$this->setComponent("select","menu_style",array("none"=>"--none--","standard"=>"standard","classic"=>"classic","simple"=>"simple","dropdown"=>"dropdown","unfold"=>"unfold","lined"=>"lined","rounded"=>"rounded","double"=>"double","grid"=>"grid"));
//		$this->setComponent("select","leftmenu_style",array("none"=>"--none--","standard"=>"standard","grid"=>"grid","sidemenu"=>"sidemenu","sidemenu-ajax"=>"sidemenu-ajax"));
		$this->setComponent("select","page_border",array("none"=>"none","light_topdown"=>"light topdown","dark_topdown"=>"dark topdown","light_outline"=>"light outline","dark_outline"=>"dark outline", "light_shadow"=>"light shadow", "dark_shadow"=>"dark shadow"));
		$this->setComponent("select","template",array("default"=>"default","parallax"=>"parallax"));

		// CHECKBOX
		$this->setComponent("checklist","forcelogin",array("1"=>""));
		$this->setComponent("checklist","multiuser",array("1"=>""));
		$this->setComponent("checklist","topmenu",array("1"=>""));
		$this->setComponent("checklist","centerpage",array("1"=>""));

		$this->setComponent("file","header_background_image",array("/var/www/vhosts/".$this->current_domain."/subdomains/data/httpdocs/files/web","files/web"));
		$this->setComponent("file","menu_background_image",array("/var/www/vhosts/".$this->current_domain."/subdomains/data/httpdocs/files/web","files/web"));
		$this->setComponent("file","web_background_image",array("/var/www/vhosts/".$this->current_domain."/subdomains/data/httpdocs/files/web","files/web"));
		$this->setComponent("file","page_background_image",array("/var/www/vhosts/".$this->current_domain."/subdomains/data/httpdocs/files/web","files/web"));
		$this->setComponent("file","footer_background_image",array("/var/www/vhosts/".$this->current_domain."/subdomains/data/httpdocs/files/web","files/web"));

		$this->customOptions = Array();
		$this->customOptions[0] = Array ("label"=>_KMS_WEB_WIDGET_STYLESWITCHER,"url"=>"http://www.".$this->current_domain."/?","ico"=>"css.gif","params"=>"&widget=styleswitcher");

		$this->setGroup("_KMS_SITES_THEMES_GROUP_TYPO",true,array("font-family","font-size","line_height","corp_color1","corp_color2","corp_color3","anchor_color","anchor_hover_color","anchor_bg_hover_color"));
		$this->setGroup("_KMS_SITES_THEMES_GROUP_LAYOUT",true,array("centerpage","top_height","header_height","page_width","page_minheight","logo_position_x","logo_position_y","width_unit","page_margin","leftcol_width","rightcol_width"));
		$this->setGroup("_KMS_SITES_THEMES_GROUP_STYLE",true,array("logo_text_color","page_border","h1_style","button_style","border_radius","language_selector","page_bg_opacity","static_sitebackground","footer_style","top_background_color","top_wide_bg_color","top_text_color","header_background_image","header_background_color","header_wide_background_color","web_background_image","web_background_color","web_wide_background_color", "page_background_image","page_background_color","page_wide_background_color","footer_background_image","footer_background_color","footer_wide_background_color","background_repeat_x","background_repeat_y","web_background_image_attachment","leftcol_bgcolor","rightcol_bgcolor","search_style","searchengine"));
		$this->setGroup("_KMS_SITES_THEMES_GROUP_MENU",true,array("menu_height","menu_float","menu_margin_top","menu_margin_bottom","menu_margin_left","menu_padding","menu_font_size","menu_text_color","menu_text_hover_color","menu_bg_hover_color","menu_bg_selected_color","menu_text_selected_color","menu_background_image","menu_background_color","menu_wide_background_color"));
		$this->setGroup("_KMS_SITES_THEMES_GROUP_SIDEMENU",true,array("sidemenu_text_color","sidemenu_text_hover_color","sidemenu_bg_hover_color","sidemenu_text_selected_color","sidemenu_option_bg_color","sidemenu_autocollapse","sidemenu_forceupper","sidemenu_bg_selected_color"));
		$this->setGroup("_KMS_SITES_THEMES_GROUP_OPTIONS",true,array("accessibility_options","sitesearch"));
		$this->onUpdate="onUpdate";
	}
	function onUpdate($post,$id) {
		unlink("/var/www/vhosts/".$this->current_domain."/httpdocs/tpl/css/style_page.css");
		unlink("/var/www/vhosts/".$this->current_domain."/httpdocs/tpl/css/style.css");
		unlink("/var/www/vhosts/".$this->current_domain."/httpdocs/tpl/css/style_sidebar.css");
		unlink("/var/www/vhosts/".$this->current_domain."/httpdocs/tpl/css/style_base.css");
		unlink("/var/www/vhosts/".$this->current_domain."/httpdocs/tpl/css/style_page_default.css");
		unlink("/var/www/vhosts/".$this->current_domain."/httpdocs/tpl/css/style_menu.css");
		unlink("/var/www/vhosts/".$this->current_domain."/httpdocs/tpl/css/style_sidemenu.css");
	}
}
?>
