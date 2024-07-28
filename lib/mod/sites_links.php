<?

// ----------------------------------------------
// Class Sites Components for KMS
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class sites_links extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

	var $table	= "kms_sites_links";
	var $key	= "id";	
	var $fields = array("id","name","url");
	var $orderby = "id";

       //*=[ CONSTRUCTOR ]===========================================================*/

        function sites_links ($client_account,$user_account,$dm) {
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
		$this->defvalue("logo","logo.png");
		$this->defvalue("robots","all");
		$this->defvalue("status","online");
		$this->default_content_type = "web_links";
		$this->default_php = "variables.php";
		$this->insert_label = _KMS_NEW_WEB_COMPONENT;
		$this->setComponent("select","status",array("online"=>"<font color='#009900'>online</font>", "offline"=>"<font color='#990000'>offline</font>"));
		$this->setComponent("select","lang",array("ca"=>"catal&agrave;", "es"=>"espa&ntilde;ol", "en-UK"=>"english"));
		$this->setComponent("uniselect","type");
		$this->setComponent("checklist","forcelogin",array("1"=>""));
		$this->setComponent("checklist","multiuser",array("1"=>""));
		
	}
}
?>
