<?

// ----------------------------------------------
// KMS System Mod Class
// ----------------------------------------------
// Model Object Definition (MOD) Class 
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class sys_mod extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

	var $table	= "kms_sys_mod";
	var $key	= "id";	
        var $fields     = array("id", "status", "name", "type", "orderby", "sortdir", "perm", "show_fields" );
	var $hidden	= array("sort_order");
        var $orderby    = "id";
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

        function sys_mod ($client_account,$user_account,$dm) {
                parent::mod($client_account,$user_account,$extranet);
        }

        function setup($client_account,$user_account,$dm) {

		$this->defvalue("status","active");
		$this->defvalue("page_rows","100");
		$this->defvalue("priority","normal");
		$this->defvalue("stock","-1");
		$uploadDate = date('Y-m-d');
		$this->defvalue("creation_date",$uploadDate);
		$this->defvalue("highlight",0);
//		$this->setComponent("multilang","name"); $this->setComponent("wysiwyg","name");
//		$this->setComponent("multilang","description");
		$this->setComponent("wysiwyg","description");
		$this->insert_label = _NEW_PRODUCT;
		$this->setComponent("select","status",array("active"=>"<font color='#009900'>"._KMS_GL_STATUS_ACTIVE."</font>", "inactive"=>"<font color='#990000'>"._KMS_GL_STATUS_INACTIVE."</font>"));
		$this->setComponent("checklist","can_add",array(1=>""));
		$this->setComponent("checklist","can_delete",array(1=>""));
		$this->setComponent("checklist","can_edit",array(1=>""));
		$this->setComponent("checklist","can_duplicate",array(1=>""));
		$this->setComponent("checklist","can_import",array(1=>""));
		$this->setComponent("checklist","can_export",array(1=>""));
		$this->setComponent("xcombo","parent",array("xtable"=>"kms_sys_mod","xkey"=>"id","xfield"=>"name","readonly"=>false,"linkcreate"=>true,"linkedit"=>true,"sql"=>""));
		$this->setComponent("xcombo","family",array("xtable"=>"kms_sys_mod_fam","xkey"=>"id","xfield"=>"name","readonly"=>false,"linkcreate"=>true,"linkedit"=>true,"sql"=>""));
		if ($_SERVER['HTTP_HOST']=="intranet.intergrid.cat") {
			$this->setComponent("uniselect","type");
		} else {
			$this->setComponent("select","type",array("ent"=>_KMS_TY_ENT_ENTITIES,"docs"=>_KMS_TY_DOCS,"lib"=>_KMS_TY_LIBRARY,"cat"=>_KMS_TY_CATALOG,"events"=>_KMS_TY_EVENTS,"kb"=>_KMS_TY_KBASE,"ecom"=>"Ecommerce","sys"=>"System"));
		}
		$this->setComponent("picture","picture",array("path"=>"/var/www/vhosts/".$this->current_domain."/subdomains/data/httpdocs/files/pictures","url"=>"http://data.".$this->current_domain."/files/pictures","resize_max_width"=>220,"resize_max_height"=>165,"thumb_max_width"=>125,"thumb_max_height"=>125,"scaleType"=>"w"));

                $this->customOptions = Array();
                $this->customOptions[0] = Array("label"=>"Edit fields","url"=>"","ico"=>"editfields.png","params"=>"action=mod_edit_attributes","target"=>"_self","checkFunction"=>"");
		$this->customOptions[1] = Array("label"=>"Edit actions","url"=>"","ico"=>"actions.png","params"=>"action=mod_edit_actions","target"=>"_self","checkFunction"=>"");
                $this->action("mod_edit_attributes","/usr/local/kms/mod/sys/mod_edit_attributes.php");
		$this->action("mod_edit_actions","/usr/local/kms/mod/sys/mod_edit_actions.php");
		$this->setComponent("select","status",array("active"=>"<font color=#009900>"._KMS_GL_STATUS_ACTIVE."</font>","inactive"=>"<font color=#ff0000>"._KMS_GL_STATUS_INACTIVE."</font>"));
		$this->onInsert = "onInsert";
		$this->onDelete = "onDelete";
	}

	function onInsert($post,$id) {
		//create table
		include_once "/usr/share/kms/lib/app/sites/functions.php";
		$normalized_name=str_replace("-","_",strtolower(urlize($post['name'])));
	
		$create="CREATE TABLE `kms_".$post['type']."_".$normalized_name."` (
				id int(11) NOT NULL auto_increment, 
				creation_date datetime,
				status varchar(30),
				PRIMARY KEY (id)
		) ENGINE=MyISAM;";
		$result=$this->dbi->query($create);
		if (!$result) $this->_error("","error onInsert ".mysqli_error($result),"fatal");
		//add module into extranet Catalogs
		$catalogs=$this->dbi->get_record("select modules from kms_sys_apps where name='Catalogs'");
		if ($catalogs['modules']=="") $modules="obj_usr_".$post['name']; else $modules=$catalogs['modules'].",obj_usr_".$post['name'];
		$this->dbi->update_record("kms_sys_apps",array("modules"=>$modules),"name='Catalogs'");
		// insert default attributes
                $insert="INSERT INTO kms_sys_mod_attributes (class,name,type) values ('{$normalized_name}','creation_date','datetime')"; 
                $result=$this->dbi->query($insert);
                $insert="INSERT INTO kms_sys_mod_attributes (class,name,type) values ('{$normalized_name}','status','openlist')";      
                $result=$this->dbi->query($insert);
		
	}

	function onDelete($post,$id) {
                $delete="DROP TABLE `kms_".$post['type']."_".$post['name']."`";
                $result=$this->dbi->query($delete);
		$query="ALTER TABLE `kms_sys_mod` auto_increment=1";
		$result=$this->dbi->query($query);
                if (!$result) $this->_error("","error onDelete ".mysqli_error($result),"fatal");
        }

}
?>
