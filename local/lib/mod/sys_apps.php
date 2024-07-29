<?

// ----------------------------------------------
// Class System Applications KMS
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class sys_apps extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

	var $table		= "kms_sys_apps";
	var $key		= "id";
	var $fields		= array("status", "sort_order", "name", "type", "owner", "group");
	var $title		= _KMS_TY_APPS;
	var $orderby		= "sort_order";
	var $sortdir		= "asc";
	var $notedit		= array("dr_folder","labels");
	var $readonly 		= array("dr_folder");
	var $linkfield 		= "fullname";
	var $insert_label 	= _NEW_CONTACT;

        /*=[ PERMISSIONS ]===========================================================*/

	var $can_import 	= false;
	var $can_export 	= true;
	var $can_duplicate  	= true;

       //*=[ CONSTRUCTOR ]===========================================================*/

        function sys_apps($client_account,$user_account,$dm) {

		if ($this->_group_permissions(1,$user_account['groups'])||$_SESSION['username']=="admin"||$_SESSION['username']=="root"||$_SERVER['HTTP_HOST']=="intranet.intergrid.cat") {
                parent::mod($client_account,$user_account,$extranet);
		} else {
		$this->_error("","You have no permissions","fatal");
		}
        }

        function setup($client_account,$user_account,$dm) {
		$this->defvalue("status","active");
		$this->defvalue("newsletter","1");
		$uploadDate = date('Y-m-d');
		$this->defvalue("creation_date",$uploadDate);
		//$this->custom_button1 = "Contractes";
		//$this->custom_button2 = "Factures";
		//$this->custom_action1 = "contracts.php?dr_folder=160&queryfield=sr_client";
		//$this->custom_action2 = "invoices.php?dr_folder=159&queryfield=sr_client";

		$this->subtitle = "Contacts";
		$this->setComponent("cipher","cpassword","MD5");
		$this->setComponent("checklist","show_sidemenu",array("1"=>""));
		$this->setComponent("checklist","show_modules",array("1"=>""));
		$this->setComponent("checklist","show_views",array("1"=>""));
		$this->setComponent("checklist","show_menu_xml",array("1"=>""));
		$this->setComponent("uniselect","country");
		$this->setComponent("uniselect","location");
                $this->setComponent("wysiwyg","menu_xml",array("type"=>"textarea"));
		//$this->setComponent("uniselect","organization");
		$this->setComponent("xcombo","group",array("xtable"=>"kms_sys_groups","xkey"=>"id","xfield"=>"name","readonly"=>false,"linkcreate"=>false,"linkedit"=>false,"sql"=>""));
		$this->setComponent("checklist","newsletter",array("1"=>""));
		$this->setComponent("select","language",array("en"=>"English","es"=>"Spanish","ct"=>"Catalan","fr"=>"French","de"=>"Deutch","it"=>"Italiano","eu"=>"Euskera"));
		$this->setComponent("select","status",array("active"=>"<font color=#009900>"._KMS_GL_STATUS_ACTIVE."</font>","inactive"=>"<font color=#ff0000>"._KMS_GL_STATUS_INACTIVE."</font>"));
		$select="select id from kms_folders where content_type='groups'";
		$result=mysqli_query($this->dblinks['client'],$select);
		$row=mysqli_fetch_array($result);
		$this->setComponent("multiselect","groups",array("select * from kms_groups where dr_folder=".$row[0]." and name!='_KMS_GROUPS_ALL'","name","id"));
		
	}

}

	
?>
