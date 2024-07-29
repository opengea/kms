<?

// ----------------------------------------------
// Class Ecommerce Products for KMS 
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class sys_mods extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

	var $table	= "kms_sys_mods";
	var $key	= "id";	
        var $fields     = array("id", "status", "name", "orderby", "sortdir", "perm", "show_fields" );
        var $orderby    = "orderby";
        var $notedit    = array("");
        var $readonly   = array("");

        /*=[ PERMISSIONS ]===========================================================*/

        var $can_edit 		= true;
        var $can_delete		= true;
        var $can_add  	  	= true;
        var $can_import 	= false;
        var $can_export 	= true;
        var $can_duplicate 	= true;

      //*=[ CONSTRUCTOR ]===========================================================*/

        function sys_mods ($client_account,$user_account,$dm) {
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
		$this->setComponent("xcombo","parent",array("xtable"=>"kms_sys_mods","xkey"=>"id","xfield"=>"name","readonly"=>false,"linkcreate"=>true,"linkedit"=>true,"sql"=>""));
		$this->setComponent("xcombo","family",array("xtable"=>"kms_sys_mods_fam","xkey"=>"id","xfield"=>"name","readonly"=>false,"linkcreate"=>true,"linkedit"=>true,"sql"=>""));
		$this->setComponent("picture","picture",array("path"=>"/var/www/vhosts/".$this->current_domain."/subdomains/data/httpdocs/files/pictures","url"=>"//data.".$this->current_domain."/files/pictures","resize_max_width"=>220,"resize_max_height"=>165,"thumb_max_width"=>125,"thumb_max_height"=>125,"scaleType"=>"w"));

                $this->customOptions = Array();
                $this->customOptions[0] = Array ("label"=>"edit fields","url"=>"","ico"=>"addon.gif","params"=>"action=mods_edit_attributes","target"=>"_self","checkFunction"=>"");
                $this->action("mods_edit_attributes","/usr/local/kms/mod/sys/mods_edit_attributes.php");
		$this->onInsert = "onInsert";
		$this->onDelete = "onDelete";
	}
	function onInsert($post,$id) {
		//create table
		$create="CREATE TABLE `kms_sys_mods_usr_".$post['name']."` (
				id int(11) NOT NULL auto_increment, 
				creation_date datetime,
				parent int(11),
				status varchar(30),
				PRIMARY KEY (id)
		) TYPE=MyISAM;";
		$result=$this->dbi->query($create);
		if (!$result) $this->_error("","error onInsert ".mysqli_error($result),"fatal");
		//add module into extranet Catalogs
		$catalogs=$this->dbi->get_record("select modules from kms_sys_apps where name='Catalogs'");
		if ($catalogs['modules']=="") $modules="obj_usr_".$post['name']; else $modules=$catalogs['modules'].",obj_usr_".$post['name'];
		$this->dbi->update_record("kms_sys_apps",array("modules"=>$modules),"name='Catalogs'");
		
	}

	function onDelete($post,$id) {
                $delete="DROP TABLE `kms_sys_mods_usr_".$post['name']."`";
                $result=$this->dbi->query($delete);
                if (!$result) $this->_error("","error onDelete ".mysqli_error($result),"fatal");
        }

}
?>
