<?

// ----------------------------------------------
// Class System Templates for KMS
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class sys_templates extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

	var $table     = "kms_sys_templates";
	var $key       = "id";
	var $fields = array("id","name");
	var $title = TY_TEMPLATES;
	var $orderby = "name";
	var $notedit = array('dr_folder');

       //*=[ CONSTRUCTOR ]===========================================================*/

        function sys_templates ($client_account,$user_account,$dm) {
                parent::mod($client_account,$user_account,$extranet);
        }

        function setup($client_account,$user_account,$dm) {

		$this->defvalue("creation_date",$uploadDate);
		$this->defvalue("centerpage","1");
		$this->defvalue("body","<br><br>[body]<br><br>");
		$this->defvalue("font","Tahoma, arial, helvetica, sans-serif, \"Lucida Sans Unicode\",\"Lucida Sans\",Trebuchet");
		$this->defvalue("fontsize","13");
		$this->defvalue("line-height","16px");
		$this->defvalue("bgcolor","#ffffff");
		$this->defvalue("fontcolor","#444444");
		$this->defvalue("linkscolor","#A10635");
		$this->defvalue("openlinkcolor","#A10635");
		$this->defvalue("content_type","html");

		$this->default_content_type = "templates";
		$this->insert_label = _NEW_TEMPLATE;

		$this->setComponent("select","content_type",array("text"=>"text","html"=>"html"));
		$this->setComponent("checklist","centerpage", array("1"=>""));
		$can_duplicate = true;
		$this->setComponent("picture","bgimage",array("path"=>"/var/www/vhosts/".$this->current_domain."/subdomains/data/httpdocs/files/pictures","url"=>"http://data.".$this->current_domain."/files/pictures","resize_max_width"=>720,"resize_max_height"=>365,"thumb_max_width"=>100,"thumb_max_height"=>100,"scaleType"=>"w"));

		$this->setComponent("wysiwyg","template");

	}
}
?>
