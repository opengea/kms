<?

// ----------------------------------------------
// Class Contacts for KMS
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class ent_contacts extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

	var $table		= "kms_ent_contacts";
	var $key		= "id";
	var $fields		= array("status", "creation_date", "fullname", "email", "location", "groups", "newsletter");
	var $title		= "Contacts";
	var $orderby	= "creation_date";
	var $sortdir	= "desc";
	var $notedit		= array("dr_folder","name","surname","labels","stars");
	var $readonly	= array("dr_folder");
//	var $linkfield	= "fullname";
	var $insert_label	= _NEW_CONTACT;

        /*=[ PERMISSIONS ]===========================================================*/

	var $can_import = false;
	var $can_export = true;
	var $can_duplicate = false;

       //*=[ CONSTRUCTOR ]===========================================================*/

        function ent_contacts($client_account,$user_account,$dm) {
                parent::mod($client_account,$user_account,$extranet);
        }

        function setup($client_account,$user_account,$dm) {

		$this->uploadDate = date('Y-m-d');
	        $this->defvalue("status","active");
	        $this->defvalue("newsletter","1");
		$this->defvalue("creation_date",$uploadDate);
		$this->validate("email");
		//$this->validate("WWW");
		$this->subtitle = "Contacts";
		$this->setComponent("cipher","cpassword","MD5");
		$this->setComponent("uniselect","country");
		$this->setComponent("uniselect","location");
		//$this->setComponent("uniselect","organization");

		// CHECKBOX
		$this->setComponent("checklist","newsletter",array("1"=>"Si"));
		$this->setComponent("select","language",array("en"=>"English","es"=>"Spanish","ct"=>"Catalan","fr"=>"French","de"=>"Deutch","it"=>"Italiano","eu"=>"Euskera"));
		$this->setComponent("select","status",array("active"=>"<font color=#009900>"._KMS_GL_STATUS_ACTIVE."</font>","inactive"=>"<font color=#ff0000>"._KMS_GL_STATUS_INACTIVE."</font>"));

		// uploads

		$this->setComponent("multiselect","groups",array("sql"=>"select * from kms_sys_groups where name!='_KMS_GROUPS_ALL'","xkey"=>"name","xkey"=>"id","xtable"=>"kms_sys_groups"));
//		$this->multixref("groups", "id", "name", "kms_sys_groups");

		$this->setComponent("picture","photo",array("path"=>"/var/www/vhosts/".$this->current_domain."/subdomains/data/httpdocs/files/contacts/photos","url"=>"http://data.".$this->current_domain."/files/contacts/photos","resize_max_width"=>290,"resize_max_height"=>193,"thumb_max_width"=>100,"thumb_max_height"=>100));

                $this->customButtons=Array();
                $this->customButtons[0] = Array ("label"=>_KMS_TY_CONTACTS_MANAGER,"url"=>"","ico"=>"","params"=>"action=contacts_manager","target"=>"new","checkFunction"=>"");
		$this->customButtons[1] = Array ("label"=>_KMS_TY_SYS_GROUPS,"url"=>"","ico"=>"","params"=>"action=groups","target"=>"new","checkFunction"=>"");
                $this->action("contacts_manager","/usr/share/kms/mod/emailing/mod/robot/contacts_manager.php");
		$this->action("groups","/usr/share/kms/mod/sys/groups.php");
	}

}

?>

