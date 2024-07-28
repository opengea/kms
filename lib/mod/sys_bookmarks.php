<?

// ----------------------------------------------
// Class for KMS top menu bookmarks
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class sys_bookmarks extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

	var $table	= "kms_sys_bookmarks";
	var $key	= "id";	
	var $fields = array("id", "description", "userid","url","sort_order");
	var $readonly = array("id","creation_date","password_type","groups","notes","language","autorun_app");
	var $hidden = array("dr_folder","creation_date","password_type","notes","language","autorun_app");
	var $orderby = "userid";
	var $insert_label = _NEW_USER;

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

        function sys_bookmarks($client_account,$user_account,$dm) {
                parent::mod($client_account,$user_account,$extranet);
        }

        //*=[ USER FUNCTIONS PATCH ]==================================================*/ 
        // This is needed to declare member functions outside the class. Just define them as "ClassName__FunctionName" and call it normally $this->FuncionName

        function __call($name, $args) {
                call_user_func_array(sprintf('%s__%s', get_class($this), $name), array_merge(array($this), $args));
        }

        /*=[ METHODS ]===========================================================*/

        function setup($client_account,$user_account,$dm) {

		if (!$this->_group_permissions(1,$user_account['groups'])) {
		$this->where = "userid='".$user_account['id']."'";
		}

		$this->humanize("dr_folder","Carpeta");
		$this->humanize("location","Poblaci&oacute;");
		$this->humanize("creation_date","Data d'alta");
		$this->humanize("name","Nom");
		$this->humanize("comments","Notes");
		$this->humanize("mobile","M&ograve;bil");
		$this->humanize("address","Adre&ccedil;a");
		$this->humanize("zipcode","Codi Postal");
		$this->humanize("phone","Tel&egrave;fon");
		$this->humanize("email","E-mail principal");
		$this->humanize("type","Tipus");
		$this->humanize("contacts","Contactes");
		$this->setComponent("select","status",array("active"=>"<font color=#009900>"._KMS_GL_STATUS_ACTIVE."</font>","inactive"=>"<font color=#ff0000>"._KMS_GL_STATUS_INACTIVE."</font>"));
		$this->defvalue("status","active");
		$this->defvalue("password_type","plain");
		$uploadDate = date('y-m-d');
		$this->defvalue("creation_date",$uploadDate);
		$this->setComponent("xcombo","userid",array("xtable"=>"kms_sys_users","xkey"=>"id","xfield"=>"username","readonly"=>false,"linkcreate"=>true,"linkedit"=>true,"sql"=>""));
                $this->setComponent("xcombo","autorun_app",array("xtable"=>"kms_sys_apps","xkey"=>"keyname","xfield"=>"name","readonly"=>false,"linkcreate"=>false,"linkedit"=>false,"sql"=>""));

		$this->setComponent("multiselect","groups",array("sql"=>"select * from kms_sys_groups where name!='_KMS_GROUPS_ALL'","xkey"=>"name","xkey"=>"id","xtable"=>"kms_sys_groups"));	
	
		//$this->setComponent("xcombo","groups",array("xtable"=>"kms_sys_groups","xkey"=>"id","xfield"=>"name","readonly"=>false,"linkcreate"=>true,"linkedit"=>true,"sql"=>""));
		$this->setComponent("select","language",array("ct"=>"catal&agrave;", "es"=>"espa&ntilde;ol", "en-UK"=>"english", "eu"=>"euskara"));
		//$this->setComponent("xcombo","contact_id",array("xtable"=>"kms_ent_contacts","xkey"=>"id","xfield"=>"fullname","readonly"=>false,"linkcreate"=>true,"linkedit"=>true,"sql"=>""));

                // Extra Client Setup
                $extra_include="/var/www/vhosts/".$this->current_domain."/subdomains/data/httpdocs/".$_GET['mod'].".php";
                if (file_exists($extra_include)) include $extra_include;



 	}
}
?>
