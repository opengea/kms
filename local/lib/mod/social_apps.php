<?

// ----------------------------------------------
// Class Social Apps for KMS
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class social_apps extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

	var $table	= "kms_social_apps";
	var $key	= "id";	
	var $fields = array("id", "status", "network", "description");
	var $orderby = "id";
	var $notedit = array("name","dr_folder");

       //*=[ CONSTRUCTOR ]===========================================================*/

        function sys_interfaces ($client_account,$user_account,$dm) {
                parent::mod($client_account,$user_account,$extranet);
        }

        function setup($client_account,$user_account,$dm) {

		$this->humanize("dr_folder","Carpeta");
		$this->humanize("title","titol");

		//date_default_timezone_set('UTC');
		//$uploadDate = date('D j M Y');
		$uploadDate = date('y-m-d');
		$this->defvalue("creation_date",$uploadDate);
		$this->defvalue("button_history",0);
		$this->defvalue("button_edit",0);
		$this->defvalue("button_admin",0);
		$this->defvalue("button_subscription",1);
		$this->defvalue("button_login",1);
		$this->defvalue("homepage","index");
		//$this->defvalue("topmenu","");
		$this->defvalue("robots","all");
		$this->defvalue("status","online");
		$this->defvalue("webwidth","840");
		//$this->validate("Email");
		//$this->validate("WWW");
	
		$this->insert_label = "Nova web";

		$linkfield = "domain";
		$this->setComponent("select","status",array("online"=>"<font color='#009900'>online</font>", "offline"=>"<font color='#990000'>offline</font>"));
		$this->setComponent("select","lang",array("ct"=>"catal&agrave;", "es"=>"espa&ntilde;ol", "en-UK"=>"english"));
		$this->setComponent("select","charset",array("iso-8859-15"=>"iso-8859-15","utf-8"=>"utf-8"));
		$this->setComponent("select","network",array("audioboo"=>"audioboo","dropbox"=>"dropbox","facebook"=>"facebook","flickr"=>"flickr","google"=>"google","google_analytics"=>"google analytics","twitter"=>"twitter","vimeo"=>"vimeo","youtube"=>"youtube"));
		$this->setComponent("checklist","multiuser",array("1"=>""));
		$this->setComponent("checklist","topmenu",array("1"=>""));
		$this->setComponent("file","favicon",array("/var/www/vhosts/".$current_domain."/subdomains/data/httpdocs/files/web","files/web"));
                $this->setComponent("xcombo","default_page",array("xtable"=>"kms_sites_pages","xkey"=>"id","xfield"=>"title","readonly"=>false,"linkcreate"=>false,"linkedit"=>false,"sql"=>""));
		$this->setComponent("xcombo","sr_legaltext",array("xtable"=>"kms_sites_lang","xkey"=>"id","xfield"=>"const","readonly"=>false,"linkcreate"=>false,"linkedit"=>false,"sql"=>""));
		$this->setComponent("xcombo","theme",array("xtable"=>"kms_sites_themes","xkey"=>"name","xfield"=>"name","readonly"=>false,"linkcreate"=>false,"linkedit"=>false,"sql"=>""));
		$this->setComponent("wysiwyg","footer");
	}
}
?>
