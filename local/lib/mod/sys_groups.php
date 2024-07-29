<?

// ----------------------------------------------
// Class System Groups for KMS
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class sys_groups extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

	var $table     = "kms_sys_groups";
	var $key       = "id";
	var $fields 	= array("id", "name", "creation_date");
	var $orderby = "id";
	var $notedit 	= array("dr_folder","creation_date");
	var $hidden = array("sql");
	/*=[ PERMISOS ]===========================================================*/

	var $can_view = true;
	var $can_edit = true;
	var $can_delete = true;
	var $can_duplicate = true;
	var $can_add   = true;
	var $can_import = false;
	var $can_export = false;
	var $can_search = true;

        //*=[ CONSTRUCTOR ]===========================================================*/

        function sys_groups($client_account,$user_account,$dm) {
                parent::mod($client_account,$user_account,$extranet);
        }

        function setup($client_account,$user_account,$dm) {

		if ($_SERVER['REMOTE_ADDR']=='81.0.57.125')  $this->hidden=array();
		$uploadDate = date('Y-m-d');
		$this->defvalue("creation_date",$uploadDate);
		$this->defvalue("type","ent_contacts");
		$this->default_content_type = "groups";
		if ($_GET['app']=="imarketing"||$_GET['app']=="db") {
			$this->fields=array("id", "name");
			$this->where=" `type`='ent_contacts'";	
			$this->defvalue("type","ent_contacts");
			$this->hidden=array("type","creation_date","sql");
		} else if ($_GET['app']=="pref") {
			$this->fields=array("id", "name");
			$this->where=" `type`='sys_users'";
			$this->defvalue("type","sys_users");
			$this->hidden=array("type","creation_date","sql");
		}
		$this->setComponent("select","type",array("sys_users"=>_KMS_TY_USERS,"ent_contacts"=>_KMS_TY_CONTACTS));
		$this->setComponent("cipher","password","MD5");
		$this->setComponent("uniselect","location");
		$this->insert_label = _NEW_GROUP;
		$this->onInsert = "onInsert";
		$this->onDelete = "onDelete";
		$this->onUpdate = "onUpdate";
		$this->alerts['delete']['msg']=_KMS_GL_CONFIRM_DELETE;
                $this->alerts['delete']['ok_label']=_MB_CONFIRM_OFF;
                $this->alerts['delete']['add_html']="<div style='margin:auto;width:auto;display:table;margin-top:20px;'><div style='float:left'><input type='checkbox' name='delete_contacts'></div><div style='float:left;padding-top:7px;text-align:left'>"._DELETE_GROUP_CONTACTS."</div></div>";
	}

	function onInsert($post,$id) {
/*		$select="select id from kms_sys_folders where content_type='views'";
		$result=mysqli_query($this->dblinks['client'],$select);
		$row=mysqli_fetch_array($result);
		if ($row['id']=="") die ("Trying to create view. 'Views' folder does not exist.");*/

		// take the fields from the customized data directory
		//$contacts=new ent_contacts($this->client_account,$this->user_account,$this->dm,1);
		// custom mod
		$kmspath = "/var/www/vhosts/".$this->current_domain."/subdomains/data/httpdocs/";
		if (file_exists($kmspath."ent_contacts.php")) { include ($kmspath."ent_contacts.php");
		} else { $this->fields= array("id","creation_date","status","name", "surname", "location", "email", "cellphone","language","newsletter"); }
		$fields=implode(",",$this->fields);
		if ($fields=="") $fields="status,creation_date,name,surname,email,location,groups,language";

		if (constant($post['name'])!="") $group_name=constant($post['name']); else $group_name=$post['name'];
	        $insert="INSERT INTO kms_sys_views (`creation_date`,`name`,`type`,`module`,`where`,`orderby`,`sort`,`fields`) VALUES ('".date("Y-m-d")."','".$group_name."','left','ent_contacts','(`groups`={$id} OR `groups` like \'{$id},%\' OR `groups` like \'%,{$id}\' OR `groups` like \'%,{$id},%\') AND `email` not like \'INVALID %\'','creation_date','des','{$fields}');";
	        $result=mysqli_query($this->dblinks['client'],$insert);
	        if (!$result) die('error'.mysqli_error()."<br><br>kms_groups SQL:".$insert);
	}

	function onDelete($post,$id) {
		// vista
                $delete="DELETE from kms_sys_views where `where` like '(groups={$id} OR%' and (module='sys_users' or module='ent_contacts')";
                $result=mysqli_query($this->dblinks['client'],$delete);
		$result=mysqli_query($this->dblinks['client'],"ALTER TABLE kms_sys_views auto_increment=1");
                if (!$result) die('error'.mysqli_error());
                // contactes unics del grup
                if ($post['delete_contacts']=="on") {
                $delete="DELETE from kms_ent_contacts where `groups`='".$id."'";
                $result=mysqli_query($this->dblinks['client'],$delete);
		$result=mysqli_query($this->dblinks['client'],"ALTER TABLE kms_ent_contacts auto_increment=1");
                if (!$result) die('error'.mysqli_error());
                }
	}

	function onUpdate($post,$id) {
/*	        $select="select id from kms_folders where content_type='views'";
	        $result=mysqli_query($this->dblinks['client'],$select);
	        $row=mysqli_fetch_array($result);
	        if ($row['id']=="") die ("Trying to create view. 'Views' folder does not exist."); */
	        $update="UPDATE kms_sys_views SET name='".$post['name']."' WHERE `where` like '(groups={$id} OR%' and (module='sys_users' or module='ent_contacts')";
       		$result=mysqli_query($this->dblinks['client'],$update);
       		if (!$result) die('error'.mysqli_error()."<br><br>SQL:".$update);
	}

}
?>
