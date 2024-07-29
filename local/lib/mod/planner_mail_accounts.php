<?

// ----------------------------------------------
// Class Planner Mail for KMS
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class planner_mail_accounts extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

        var $table      = "kms_planner_mail_accounts";
        var $key        = "id";
        var $fields = array("id", "status", "name", "email", "user_id");
//	var $readonly = array("user_id","creation_date");
	var $hidden = array("user_id","creation_date");
        var $orderby = "creation_date";
        var $sortdir = "desc";

        /*=[ PERMISSIONS ]===========================================================*/

        var $can_view = false;
        var $can_edit = true;
        var $can_delete = true;
        var $can_add   = true;
        var $can_import = false;
        var $can_export = false;
        var $can_search = true;
        var $can_print  = true;

       //*=[ CONSTRUCTOR ]===========================================================*/

        function planner_mail_accounts ($client_account,$user_account,$dm) {
                parent::mod($client_account,$user_account,$extranet);
        }

        function setup($client_account,$user_account,$dm) {
        	$this->defvalue("creation_date",date('Y-m-d'));
		$this->defvalue("imap_port","143");
		$this->defvalue("smtp_port","110");
		$this->setComponent("cipher","password","protected");
		$this->setComponent("select","status",array("1"=>"<font color=#009900>"._KMS_GL_STATUS_ACTIVE."</font>","0"=>"<font color=#ff0000>"._KMS_GL_STATUS_INACTIVE."</font>"));
		$this->setComponent("checklist","ssl",array("1"=>""));
		$this->setComponent("xcombo","user_id",array("xtable"=>"kms_sys_users","xkey"=>"id","xfield"=>"username","readonly"=>false,"linkcreate"=>true,"linkedit"=>true,"sql"=>""));
		$this->setComponent("select","authentication",array("password"=>"Contrasenya","encrypted_password"=>"Contrasenya encriptada","tls"=>"Certificat TLS")); 
		$this->setComponent("select","format",array("plain/text"=>"text","html"=>"html"));
		$this->setComponent("file","certificate",array($this->kms_datapath."files/certificates","http://data.".$this->current_domain."/files/certificates"));
                $this->where = "user_id='".$user_account['id']."'";
		$this->defvalue("user_id",$user_account['id']);
	}
}
?>
