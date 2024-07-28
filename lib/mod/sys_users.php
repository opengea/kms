<?

// ----------------------------------------------
// Class System Users for KMS
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class sys_users extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

	var $table	= "kms_sys_users";
	var $key	= "id";	
	var $fields = array("id", "status", "username", "groups", "creation_date");
	var $notedit = array("creation_date");
	var $readonly = array("id","creation_date","password_type","groups","notes","language","autorun_app");
	var $hidden = array("creation_date","password_type","notes","language","autorun_app");
	var $orderby = "creation_date";
	var $insert_label = _NEW_USER;

        /*=[ PERMISSIONS ]===========================================================*/

        var $can_view = false;
        var $can_edit = true;
        var $can_delete = false;
        var $can_add   = true;
        var $import = false;
        var $export = false;
        var $search = true;
        var $can_duplicate = true;

       //*=[ CONSTRUCTOR ]===========================================================*/

        function sys_users($client_account,$user_account,$dm) {
		include_once "/usr/local/kms/lib/mod_defaults.php";
                if (!$this->_group_permissions(1,$user_account['groups'])||($_GET['opt']=="self")) {
                $_GET['_']="e"; //force edit    
                $_GET['id']=$user_account['id'];
                }

                parent::mod($client_account,$user_account,$extranet);
        }

        //*=[ USER FUNCTIONS PATCH ]==================================================*/ 
        // This is needed to declare member functions outside the class. Just define them as "ClassName__FunctionName" and call it normally $this->FuncionName

        function __call($name, $args) {
                call_user_func_array(sprintf('%s__%s', get_class($this), $name), array_merge(array($this), $args));
        }

        /*=[ METHODS ]===========================================================*/

        function setup($client_account,$user_account,$dm) {
                if (!$this->_group_permissions(1,$user_account['groups'])||($_GET['opt']=="self")) {
                $this->where = "id='".$user_account['id']."'";
		array_push($this->hidden,"groups");
                }
		$this->humanize("location","Poblaci&oacute;");
		$this->humanize("creation_date","Data d'alta");
		$this->humanize("name","Nom");
		$this->humanize("comments","Notes");
		$this->humanize("mobile","M&ograve;bil");
		$this->humanize("address","Adre&ccedil;a");
		$this->humanize("root_folder","Root folder");
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
                $this->setComponent("xcombo","autorun_app",array("xtable"=>"kms_sys_apps","xkey"=>"keyname","xfield"=>"name","readonly"=>false,"linkcreate"=>false,"linkedit"=>false,"sql"=>""));
		$this->setComponent("multixref","groups",array("sql"=>"select * from kms_sys_groups where name!='_KMS_GROUPS_ALL'","xfield"=>"name","xkey"=>"id","xtable"=>"kms_sys_groups"));
	
		//$this->setComponent("xcombo","groups",array("xtable"=>"kms_sys_groups","xkey"=>"id","xfield"=>"name","readonly"=>false,"linkcreate"=>true,"linkedit"=>true,"sql"=>""));
		$this->setComponent("select","language",array("ct"=>"catal&agrave;", "es"=>"espa&ntilde;ol", "en-UK"=>"english", "eu"=>"euskara"));
		//$this->setComponent("xcombo","contact_id",array("xtable"=>"kms_ent_contacts","xkey"=>"id","xfield"=>"fullname","readonly"=>false,"linkcreate"=>true,"linkedit"=>true,"sql"=>""));

                // Extra Client Setup
                $extra_include="/var/www/vhosts/".$this->current_domain."/subdomains/data/httpdocs/".$_GET['mod'].".php";
                if (file_exists($extra_include)) include $extra_include;

		if (substr($_GET['app'],0,2)=="cp") {	
			// CP Security ----------------------------------------------------------------------------------------------------------
			$select="SELECT * FROM kms_isp_clients WHERE sr_user=".$user_account['id'];
	                $result=mysqli_query($this->dblinks['client'],$select);
	                $client=mysqli_fetch_array($result);
		         if ($this->_group_permissions(1,$user_account['groups'])) { //admin  ($this->_group_permissions(1,$user_account['groups']))  {
	                        $_GET['app']="cp-admin";
				$this->can_delete=true;
	                        $this->notedit=array();
	                        $this->readonly=array();
	                } else if ($this->_group_permissions(3,$user_account['groups'])) { //reseller
	                        $_GET['app']="cp-reseller";
	                        $this->where = "id in (select sr_user from kms_isp_clients where sr_provider=".$client['sr_client'].")";
	                        if ($_GET['action']=='edit_client') {
	                                                $_GET['_']="e"; $_GET['id']=$client['id'];
	                        } else {
	                                                array_push($this->notedit,"billing_email");
	                        }
	                } else if ($this->_group_permissions(2,$user_account['groups'])) { // client
	                        if ($client['sr_client']=="") $this->_error("","You don't have admin privileges.","fatal");
	                        //always edit
	                        $_GET['app']="cp";
	                        $_GET['_']="e"; $_GET['id']=$client['id'];
	                        $this->fields = array("status","name","contacts","creation_date");
	                        $this->where = "sr_client=".$client['sr_client'];
	                }
		} else if (substr($_GET['app'],0,4)=="pref") {
			// Standard extranet --------------------------------------------------------------------------------------------------
			if ($this->_group_permissions(1,$user_account['groups'])) { //admin
				$this->can_delete=true;
	                        $this->notedit=array();
	                        $this->readonly=array();
			}
		}
		if ($_SESSION['username']=="admin"||$_SESSION['username']=="root"||substr($_SESSION['user_groups'],0,1)=="1") { //administradors
                        $this->hidden=array();
                        $this->readonly=array();
                }
 	}
}
?>
