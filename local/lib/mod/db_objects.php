<?

// ----------------------------------------------
// Class Ecommerce Products for KMS 
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class db_objects extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

	var $table	= "kms_db_objects";
	var $key	= "id";	
	var $fields 	= array("id", "sortorder", "status", "family", "subfamily", "ref", "name", "highlight");
	var $orderby 	= "sortorder";
	var $notedit 	= array("dr_folder");
	var$readonly 	= array("dr_folder");

        /*=[ PERMISSIONS ]===========================================================*/

        var $can_edit 		= true;
        var $can_delete		= true;
        var $can_add  	  	= true;
        var $can_import 	= false;
        var $can_export 	= true;
        var $can_duplicate 	= true;

      //*=[ CONSTRUCTOR ]===========================================================*/

        function db_objects ($client_account,$user_account,$dm) {
                parent::mod($client_account,$user_account,$extranet);
        }

        function setup($client_account,$user_account,$dm) {
		$this->defvalue("status","active");
		$this->defvalue("priority","normal");
		$this->defvalue("stock","-1");
		$uploadDate = date('y-m-d');
		$this->defvalue("creation_date",$uploadDate);
		$this->defvalue("highlight",0);
//		$this->setComponent("multilang","name"); $this->setComponent("wysiwyg","name");
//		$this->setComponent("multilang","description");
		$this->setComponent("wysiwyg","description");
		$this->insert_label = _NEW_PRODUCT;
		$this->setComponent("select","status",array("active"=>"<font color='#009900'>"._KMS_GL_STATUS_ACTIVE."</font>", "inactive"=>"<font color='#990000'>"._KMS_GL_STATUS_INACTIVE."</font>"));
		$this->setComponent("checklist","show_in_catalog",array(1=>""));
		$this->setComponent("checklist","show_in_shop",array(1=>""));
		$this->setComponent("checklist","highlight",array(1=>""));
		$this->setComponent("xcombo","catalog_id",array("xtable"=>"kms_db_catalogs","xkey"=>"id","xfield"=>"name","readonly"=>false,"linkcreate"=>true,"linkedit"=>true,"sql"=>""));
		$this->setComponent("xcombo","family",array("xtable"=>"kms_db_families","xkey"=>"id","xfield"=>"name","readonly"=>false,"linkcreate"=>true,"linkedit"=>true,"sql"=>""));
		$this->setComponent("xcombo","subfamily",array("xtable"=>"kms_db_subfamilies","xkey"=>"id","xfield"=>"name","readonly"=>false,"linkcreate"=>true,"linkedit"=>true,"sql"=>""));
		$this->setComponent("picture","picture",array("path"=>"/var/www/vhosts/".$this->current_domain."/subdomains/data/httpdocs/files/pictures","url"=>"http://data.".$this->current_domain."/files/pictures","resize_max_width"=>220,"resize_max_height"=>165,"thumb_max_width"=>125,"thumb_max_height"=>125,"scaleType"=>"w"));
	}

}
?>
