<?

// ----------------------------------------------
// Class Sites Countries for KMS
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class sites_countries extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

	var $table	= "kms_sites_countries";
	var $key	= "id";	
	var $fields = array("code", "name", "area", "delivery_zone");
	var $default_content_type = "web_countries";
	var $orderby = "id";

        /*=[ PERMISSIONS ]===========================================================*/

        var $can_view = false;
        var $can_edit = true;
        var $can_delete = true;
        var $can_add   = true;
        var $import = false;
        var $export = false;
        var $search = true;
        var $can_duplicate = true;

       //*=[ CONSTRUCTOR ]===========================================================*/

        function sites_countries($client_account,$user_account,$dm) {
                parent::mod($client_account,$user_account,$extranet);
        }

        function setup($client_account,$user_account,$dm) {

		$this->humanize("dr_folder","Carpeta");
		$this->humanize("title","titol");
		$uploadDate = date('Y-m-d');
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
		$this->insert_label = "Nou pais";
		$linkfield = "domain";
		$this->setComponent("select","status",array("online"=>"<font color='#009900'>online</font>", "offline"=>"<font color='#990000'>offline</font>"));
		$this->setComponent("select","lang",array("ct"=>"catal&agrave;", "es"=>"espa&ntilde;ol", "en-UK"=>"english"));
		$this->setComponent("select","charset",array("iso-8859-15"=>"iso-8859-15","utf-8"=>"utf-8"));
		$this->setComponent("checklist","forcelogin",array("1"=>""));
		$this->setComponent("checklist","multiuser",array("1"=>""));
		$this->setComponent("checklist","topmenu",array("1"=>""));
		$this->setComponent("file","logo",array("/var/www/vhosts/".$this->current_domain."/subdomains/data/httpdocs/files/web","files/web"));
		$this->setComponent("file","favicon",array("/var/www/vhosts/".$this->current_domain."/subdomains/data/httpdocs/files/web","files/web"));
	  	$this->setComponent("xcombo","default_page",array("xtable"=>"kms_sites_pages","xkey"=>"id","xfield"=>"title","readonly"=>false,"linkcreate"=>true,"linkedit"=>true,"sql"=>""));	
		$this->setComponent("xcombo","sr_legaltext",array("xtable"=>"kms_sites_lang","xkey"=>"id","xfield"=>"const","readonly"=>false,"linkcreate"=>true,"linkedit"=>true,"sql"=>""));
		$this->setComponent("wysiwyg","footer");
		$this->setComponent("uniselect","area");
		$this->setComponent("uniselect","delivery_zone");
	}
}
?>
