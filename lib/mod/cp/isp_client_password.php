<?

// ----------------------------------------------
// Class System Users for KMS
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class isp_client_password extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

	var $table	= "kms_sys_users";
	var $key	= "id";	
	var $fields = array("id", "status", "username");
	var $notedit = array("autorun_app","dr_folder","language","creation_date","groups","notes","email","password_type","status","birthdate","contact_id","sr_contact");
	var $readonly = array("username");
        /*=[ PERMISSIONS ]===========================================================*/

        var $can_gohome = true;
        var $can_view = false;
        var $can_edit = true;
        var $can_delete = false;
        var $can_add   = false;
        var $import = false;
        var $export = false;
        var $search = false;
        var $can_duplicate = false;

       //*=[ CONSTRUCTOR ]===========================================================*/

        function isp_client_password($client_account,$user_account,$dm) {
                // force editing password
                $_GET['_']="e";
                $select="SELECT * FROM kms_isp_clients where sr_user=".$user_account['id'];
                $result=mysql_query($select);
                if (!$result) die(mysql_error($result));
                $row=mysql_fetch_array($result);
                $_GET['id']=$row['sr_user'];

                parent::mod($client_account,$user_account,$extranet);
        }

        function setup($client_account,$user_account,$dm) {
                $hide_databrowser=false;
                include "/usr/local/kms/tpl/panels/isp_client_password.php";
		$this->setComponent("cipher","upassword","REVERSIBLE");
		$this->setComponent("select","status",array("active"=>"<font color=#009900>"._KMS_GL_STATUS_ACTIVE."</font>","inactive"=>"<font color=#ff0000>"._KMS_GL_STATUS_INACTIVE."</font>"));
		$this->defvalue("status","active");
		$this->defvalue("content_type","entities");
		$uploadDate = date('Y-m-d');
		$this->defvalue("creation_date",$uploadDate);
		
		$this->setComponent("uniselect","type");
		$this->setComponent("uniselect","location");
		$this->setComponent("multiselect","groups",array("select * from kms_groups where name!='_KMS_GROUPS_ALL'","name","id"));
		$this->setComponent("xcombo","groups",array("xtable"=>"kms_sys_groups","xkey"=>"id","xfield"=>"name","readonly"=>false,"linkcreate"=>true,"linkedit"=>true,"sql"=>""));
		$this->setComponent("xcombo","contact_id",array("xtable"=>"kms_ent_contacts","xkey"=>"id","xfield"=>"fullname","readonly"=>false,"linkcreate"=>true,"linkedit"=>true,"sql"=>""));
		$this->onUpdate="onUpdate";
 	}
	
	function onUpdate($post,$id) {
		include "shared/db_links.php";
		$update=array("password"=>$post['upassword']);
                $this->dbi->update_record("kms_ent_clients",$update,"username='".$post['username']."'",$dblink_erp);
	}


}

?>

