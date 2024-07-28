<?
// ----------------------------------------------
// KMS Sites for KMS 
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class sites extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

        var $table	= "kms_sites";
	var $key	= "id";	
	var $fields = array("id", "status", "domain", "url_base", "meta_title", "theme", "creation_date");
	var $title = "Webs";
	var $default_content_type = "web_sites";
	var $orderby = "id";
	var $notedit = array("dr_folder");
	var $hidden = array("sr_legaltext");

	/*=[ PERMISOS ]===========================================================*/

	var $can_view = false;
	var $can_edit = true;
	var $can_delete = true;
	var $can_add   = true;
	var $import = false;
	var $export = false;
	var $search = true;
	var $can_duplicate = true;

       //*=[ CONSTRUCTOR ]===========================================================*/

        function sites ($client_account,$user_account,$dm) {
                parent::mod($client_account,$user_account,$extranet);
        }

        function setup($client_account,$user_account,$dm) {

		$this->humanize("title","titol");
		$uploadDate = date('Y-m-d');
		$this->defvalue("creation_date",$uploadDate);
		$this->defvalue("button_history",0);
		$this->defvalue("button_edit",0);
		$this->defvalue("button_admin",0);
		$this->defvalue("button_subscription",1);
		$this->defvalue("button_login",1);
		$this->defvalue("homepage","index");
		$this->defvalue("robots","all");
		$this->defvalue("status","online");
		$this->defvalue("webwidth","840");
		//$this->validate("Email");
		//$this->validate("WWW");
		$this->insert_label = "Nou lloc web";
		$linkfield = "domain";
		$this->setComponent("select","status",array("online"=>"<font color='#009900'>online</font>", "offline"=>"<font color='#990000'>offline</font>","manteinance"=>"<font color='#CCCCCC'>manteinance</font>"));
		$this->setComponent("select","charset",array("iso-8859-15"=>"iso-8859-15","utf-8"=>"utf-8","latin-1"=>"latin-1"));
		$this->setComponent("multiselect","available_languages",array("sql"=>"select * from kms_sys_languages order by code","xfield"=>"name","xkey"=>"code","xtable"=>"kms_sys_languages"));
		$this->setComponent("select","login",array("disabled"=>"disabled","classic"=>"classic","social"=>"social"));
		$this->setComponent("checklist","multiuser",array("1"=>""));
		$this->setComponent("checklist","cookies",array("1"=>""));
		$this->setComponent("checklist","multilanguage",array("1"=>""));
		$this->setComponent("checklist","topmenu",array("1"=>""));
		$this->setComponent("picture","logo",array("path"=>"/var/www/vhosts/".$this->current_domain."/subdomains/data/httpdocs/files/web","url"=>"http://data.".$this->current_domain."/files/web","resize_max_width"=>830,"resize_max_height"=>121,"thumb_max_width"=>100,"thumb_max_height"=>100,"scaleType"=>"w"));
		$this->setComponent("picture","favicon",array("path"=>"/var/www/vhosts/".$this->current_domain."/subdomains/data/httpdocs/files/web","url"=>"http://data.".$this->current_domain."/files/web","resize_max_width"=>16,"resize_max_height"=>16,"thumb_max_width"=>16,"thumb_max_height"=>16,"scaleType"=>"w"));
		$this->setComponent("xcombo","default_page",array("xtable"=>"kms_sites_pages","xkey"=>"id","xfield"=>"name","readonly"=>false,"linkcreate"=>true,"linkedit"=>true,"sql"=>"select id,concat(id,':',name,' ',title) from kms_sites_pages"));	
                $this->setComponent("xcombo","default_page",array("xtable"=>"kms_sites_pages","xkey"=>"id","xfield"=>"name","readonly"=>false,"linkcreate"=>true,"linkedit"=>true,"sql"=>"select id,permalink from kms_sites_pages")); 
		$this->setComponent("xcombo","sr_legaltext",array("xtable"=>"kms_sites_lang","xkey"=>"id","xfield"=>"const","readonly"=>false,"linkcreate"=>true,"linkedit"=>true,"sql"=>""));	
		$this->setComponent("xcombo","theme",array("xtable"=>"kms_sites_themes","xkey"=>"name","xfield"=>"name","readonly"=>false,"linkcreate"=>true,"linkedit"=>true,"sql"=>""));
		$this->onPreUpdate="onPreUpdate";
		if ($_GET['_']!="b"&&$_GET['id']!="") $site=$this->dbi->get_record("select * from kms_sites WHERE id=".$_GET['id']);
		if ($site['multilanguage']) {
			$this->setComponent("ckeditor_multilang","meta_description",array("type"=>"richtext"));
                        $this->setComponent("ckeditor_multilang","meta_keywords",array("type"=>"richtext"));
		}
                $this->onFieldChange("multilanguage","if ($('#multilanguage').val()=='1') $('#tr_available_languages').show(); else $('#tr_available_languages').hide()");
                $this->onDocumentReady("if ($('#multilanguage').val()=='1') $('#tr_available_languages').show(); else $('#tr_available_languages').hide()");

	}

	function onPreUpdate($post,$id) {
		$old=$this->dbi->get_record("select * from kms_sites WHERE id=".$id);
		if ($old['theme']!=$post['theme']) {
		unlink("/var/www/vhosts/".$this->current_domain."/httpdocs/tpl/css/style_page.css");
                unlink("/var/www/vhosts/".$this->current_domain."/httpdocs/tpl/css/style.css");
                unlink("/var/www/vhosts/".$this->current_domain."/httpdocs/tpl/css/style_sidebar.css");
                unlink("/var/www/vhosts/".$this->current_domain."/httpdocs/tpl/css/style_base.css");
                unlink("/var/www/vhosts/".$this->current_domain."/httpdocs/tpl/css/style_page_default.css");
                unlink("/var/www/vhosts/".$this->current_domain."/httpdocs/tpl/css/style_menu.css");
                unlink("/var/www/vhosts/".$this->current_domain."/httpdocs/tpl/css/style_sidemenu.css");
		}

        }

}
?>
