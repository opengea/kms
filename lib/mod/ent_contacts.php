<?

// ----------------------------------------------
// Class Contacts Entities for KMS 
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class ent_contacts extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

	var $table	= "kms_ent_contacts";
	var $key	= "id";	
	var $fields 	= array("id","creation_date","status", "contacts", "name", "surname", "location", "email", "cellphone","language","newsletter");
	var $orderby 	= "creation_date";
	var $sortdir 	= "desc";
	var $hidden	= array("treatment","contacts","cpassword","fullname","stars","email2","email3");
	var $readonly   = array("unsubscribe_datetime");	
        /*=[ PERMISSIONS ]===========================================================*/

        var $can_edit           = true;
        var $can_delete         = true;
        var $can_add            = true;
        var $can_import         = false;
        var $can_export         = true;
        var $can_search         = true;
        var $can_print          = true;
        var $can_duplicate      = true;

       //*=[ CONSTRUCTOR ]===========================================================*/

        function ent_contacts($client_account,$user_account,$dm) {
                parent::mod($client_account,$user_account,$extranet);
        }

        function setup($client_account,$user_account,$dm) {

		if ($_GET['_']=="i") {
			array_push($this->hidden,"unsubscribe_reason");
			array_push($this->hidden,"unsubscribe_datetime");
		}
		$this->defvalue("status","active");
		$this->defvalue("newsletter","1");
		$this->setComponent("select","status",array("active"=>"<font color=#009900>"._KMS_GL_STATUS_ACTIVE."</font>","inactive"=>"<font color=#ff0000>"._KMS_GL_STATUS_INACTIVE."</font>","pending"=>"<font color=#ffAA00>"._KMS_GL_STATUS_PENDING."</font>"));

		$uploadDate = date('Y-m-d');

		$this->defvalue("creation_date",$uploadDate);
		$this->setComponent("select","language",array(""=>"","ct"=>_KMS_WEB_LANG_CA,"en"=>_KMS_WEB_LANG_EN,"es"=>_KMS_WEB_LANG_ES,"fr"=>_KMS_WEB_LANG_FR,"de"=>_KMS_WEB_LANG_DE,"it"=>_KMS_WEB_LANG_IT,"eu"=>_KMS_WEB_LANG_EU,"pt"=>_KMS_WEB_LANG_PT));

//		$this->setComponent("xcombo","country",array("xtable"=>"kms_sites_countries","xkey"=>"code", "xfield"=>"name", "readonly"=>false, "linkcreate"=>true, "linkedit"=>true, "sql"=>""));
		$this->setComponent("uniselect","country");

		$this->setComponent("uniselect","location");
//		$this->setComponent("uniselect","organization");
		
		$this->setComponent("uniselect","treatment");
		$this->setComponent("uniselect","province");
		$notedit= array("dr_folder","country");
		$this->default_content_type = "contacts";
		$this->default_file = "contacts.php";
		$export=true;
		$this->humanize('activity','Actividad');
		$this->humanize('address2','Web');
		$this->validate("email");
		$this->validate("website");
		$this->xlist("Contractes","SELECT * FROM kms_erp_contracts WHERE kms_erp_contracts.sr_client='".$_GET['id']."'","erp_contracts");
		$this->xlist("Factures","SELECT * FROM kms_erp_invoices WHERE kms_erp_invoices.sr_client='".$_GET['id']."'","erp_invoices");
		$this->insert_label = _NEW_ENTITY;
		$this->setComponent("checklist","newsletter",array("1"=>_CMN_YES));
                $this->onUpdate = "onUpdate";
//		$this->setValidator("fullname","notnull");
		$this->setValidator("email","email");
		$this->setComponent("multiselect","groups",array("sql"=>"select * from kms_sys_groups where type='ent_contacts' order by name","xfield"=>"name","xkey"=>"id","xtable"=>"kms_sys_groups"));

		$this->customButtons=Array();
                $this->customButtons[0] = Array ("label"=>_KMS_TY_CONTACTS_MANAGER,"url"=>"","ico"=>"pdf.gif","params"=>"action=contacts_manager","target"=>"_self","checkFunction"=>"","class"=>"highlight");
                $this->action("contacts_manager","/usr/share/kms/mod/emailing/mod/robot/contacts_manager.php");
		$this->action("download_xls","/usr/share/kms/mod/emailing/mod/robot/download_xls.php");
		$this->setComponent("picture","photo",array("path"=>"/var/www/vhosts/".$this->current_domain."/subdomains/data/httpdocs/files/contacts/photos","url"=>"http://data.".$this->current_domain."/files/contacts/photos","resize_max_width"=>290,"resize_max_height"=>193,"thumb_max_width"=>100,"thumb_max_height"=>100));
        }

	function onInsert($post,$id) {
	        // depenent de si es un grup intel·ligent o no la vista sera diferent
	        if ($post['sql']=="") { //vista normal
			$where = "(groups={$id} OR groups like \'{$id},%\' OR groups like \'%,{$id}\' OR groups like \'%,{$id},%\')";
	        } else {
			// vista intel.ligent
	                $post['sql']=str_replace("where ","WHERE ",$post['sql']);
	                $where=str_replace("'","\'",substr($post['sql'],strpos($post['sql'],"WHERE ")+6));
	        }
	        $insert="INSERT INTO kms_sys_views (`creation_date`,`name`,`module`,`where`,`orderby`,`sort`,`fields`) VALUES ('".date("Y-m-d")."','"._KMS_FOLDERS_GROUP." ".mysqli_real_escape_string($post['name'])."','".$post['type']."','".$where;

	        if ($post['sql']=="") {
			// vista normal
		        if ($post['type']=="contacts") $insert.=" AND email not like \'INVALID %\' AND newsletter=\'1\'"; //','creation_date','des','');";
	        }

	        if ($post['type']=="contacts") $insert.="','creation_date','des','');";
	        else if ($post['type']=="users") $insert.="','creation_date','username','groups');"; //,'contact_id');";
	
	        $result=mysqli_query($this->dblinks['client'],$insert);
	        if (!$result) die('error'.mysqli_error()."<br><br>kms_groups SQL:".$insert);
	
	        // add this grup on current user
	        $select ="select groups from kms_sys_users where id=".$_SESSION['user_id'];
	        $result=mysqli_query($this->dblinks['client'],$select);
	        $user=mysqli_fetch_array($result);
	        $update ="update kms_sys_users set groups ='{$user['groups']},{$id}' where id=".$_SESSION['user_id'];
	        $result=mysqli_query($this->dblinks['client'],$update);
	        $_SESSION['user_groups']="{$user['groups']},{$id}";
	}

	function onDelete($post,$id) {
	        // vista
	        $delete="DELETE from kms_sys_views where `where` like '(groups={$id} OR%AND newsletter=%' and (module='users' or module='contacts')";
	        $result=mysqli_query($this->dblinks['client'],$delete);
	        if (!$result) die('error'.mysqli_error());
	        // contactes unics del grup
	        $delete="DELETE from kms_ent_contacts where `groups`='".$id."'";
	        $result=mysqli_query($this->dblinks['client'],$delete);
	        if (!$result) die('error'.mysqli_error());
	}

        function onUpdate($post,$id) {
		// if this entity is client, we must update ISP module
		$select="select sr_client from kms_ent_clients where sr_client=$id";
		$result=$this->dbi->query($select);
		$client=mysqli_fetch_array($result);
		if ($client['sr_client']==$id) {
			include "shared/db_links.php";
	                $fields_to_update=array("name","contacts","phone","alt_phone","email","web","address","location","province","zipcode","country","language","newsletter");
                        $update=$this->dbi->make_update($post,"kms_isp_clients","sr_client=".$id,$fields_to_update,$dblink_cp);
			$this->dbi->query($update,$dblink_cp);
                        $this->dbi->query($update,$dblink_erp);
		} 
		// update view
		$update="UPDATE kms_sys_views SET name='"._KMS_FOLDERS_GROUP." ".mysqli_real_escape_string($post['name'])."' WHERE `where` like '(groups={$id} OR%AND newsletter=%' and (module='users' or module='contacts')";
		$result=mysqli_query($this->dblinks['client'],$update);
	        if (!$result) die('error'.mysqli_error()."<br><br>SQL:".$update);
        }

}
?>
