<?

// ----------------------------------------------
// Class ISP Support System for KMS
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class isp_support extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

	var $table	= "kms_isp_support";
	var $key	= "id";	
	var $fields = array("id","status","sr_client","creation_date","request_type","subject");
	var $readonly = array("sr_client","sr_user","creation_date","status");
	var $orderby = "creation_date";
	var $sortdir		= "desc";	
	var $notedit=array("dr_folder","sr_user","creation_date","closed_date","sr_client","status");
//	var $hidden = array("status");
        /*=[ PERMISSIONS ]===========================================================*/

        var $can_gohome = true;
	var $can_edit  = false;
	var $can_delete = false;
	var $can_add    = true;
	var $can_import = false;
	var $can_export = false;

       //*=[ CONSTRUCTOR ]===========================================================*/

        function isp_support($client_account,$user_account,$dm) {
		$select="SELECT * FROM kms_isp_support where sr_user=".$user_account['id'];
		$result=mysqli_query($this->dblinks['client'],$select);
//	           if (!$result) die($select.mysqli_error($result));
                $row=mysqli_fetch_array($result);
                //users and resellers edit... (administrators can see everything and can browse)
                if ($_SESSION['user_groups']!=1&&$_SESSION['user_groups']!=6) {  $_GET['_']="i"; $_GET['id']=$row['id']; }
		parent::mod($client_account,$user_account,$extranet);
        }

        function setup() {
		include "/usr/local/kms/tpl/panels/isp_support.php";
//		$this->action("update_domains","/usr/local/kms/mod/isp/update_domains.php");
//		$this->setComponent("select","subject",array(""=>"Catal&agrave;","es"=>"Espa&ntilde;ol","eu"=>"Euskara","en"=>"English"));
		$this->button_insert=_KMS_GL_SENDDATA_BUT;
		$this->setComponent("xcombo","sr_client",array("xtable"=>"kms_ent_contacts","xkey"=>"id","xfield"=>"name","readonly"=>false,"linkcreate"=>false,"linkedit"=>true,"sql"=>""));
		$this->defvalue("request_type",2); 
		$this->setComponent("select","request_type",array("1"=>_KMS_GL_ACCOUNTANCY,"2"=>_KMS_GL_TECHNICAL_SUPPORT,"3"=>_KMS_GL_COMMERCIAL));
		$this->setComponent("select","status",array("closed"=>"<font color=#990000>"._KMS_TICKET_CLOSED."</font>","open"=>"<font color=#009900>"._KMS_TICKET_OPEN."</font>"));

                $this->defvalue("creation_date",date('Y-m-d h:i:s'));
//		$this->setComponent("xcombosql","select * from kms_lib_pictures_galleries","name","id",false);


	     $this->setComponent("ckeditor_standard","message",array("type"=>"richtext"));

		if ($_SERVER['HTTP_HOST']=="intranet.intergrid.cat")  { 
		 $this->notedit=array("dr_folder");
                        $this->can_edit=true; $this->can_delete=true;
		$this->fields = array("id","creation_date", "status","sr_client","request_type","subject","closed_date");			

		} else { //customers

		$select="SELECT * FROM kms_isp_clients where sr_user=".$this->user_account['id'];
//print_r($this->user_account);
		$result=mysqli_query($this->dblinks['client'],$select);
		$isp_client=mysqli_fetch_array($result);
                $this->defvalue("closed_date",date('Y-m-d'));
                $this->setComponent("xcombo","sr_service",array("xtable"=>"kms_isp_hostings","xkey"=>"id","xfield"=>"description","readonly"=>false,"linkcreate"=>false,"linkedit"=>false,"sql"=>"select id,description from kms_isp_hostings"));
		 $this->setComponent("ckeditor_standard","message",array("type"=>"html"));

		$select="select sr_client from kms_isp_clients where sr_user=".$this->user_account['id'];
		$res=mysqli_query($this->dblinks['client'],$select);
		$isp_client=mysqli_fetch_array($res);


		$this->defvalue("sr_client",$isp_client['sr_client']);
		}

                $this->onUpdate = "onUpdate";
		$this->onInsert = "onInsert";

	}

	function onInsert($post,$id) {
                include "shared/db_links.php";
                $select="select * from kms_isp_clients where sr_user=".$this->user_account['id'];
                $res=mysql_query($select);
                $isp_client=mysql_fetch_array($res);

                $update=array("status"=>"open","creation_date"=>date('Y-m-d H:i:s'),"sr_client"=>$isp_client['sr_client']);
                $this->dbi->update_record("kms_isp_support",$update,"id=$id",$dblink_cp);

                $ticket=$this->dbi->get_record("select * from kms_isp_support where id=$id");
                if ($_GET['app']=="sysadmin") $this->dbi->insert_record("kms_isp_support",$ticket,$dblink_cp);
                else $this->dbi->insert_record("kms_isp_support",$ticket,$dblink_erp);

                //notify 
                $from=$post['email']; if ($from=="") $from=$isp_client['email'];
                if ($isp_client['language']=="es") $to="soporte@intergrid.es"; else $to="suport@intergrid.cat";
                $subject="[Ticket#$id] ".$isp_client['name']." | ".$post['subject'];
                $body=mysql_real_escape_string(str_replace("\r\n","<br>",$post['message']));
                //send email to support
                $email = new Email($from,$to,$subject,$body,1);
                $goodemail = $email->send();

                //notify client
                $from=$to;
                $to=$post['email']; if ($to=="") $to=$isp_client['email'];
                $body=str_replace("[BODY]",$body,_KMS_ISP_SUPPORT_NOTIFY_BODY);
                $email = new Email($from,$to,$subject,$body,1);
                $goodemail = $email->send();
                if (!$goodemail) echo "failed sending email notification to client.";

	}

        function onUpdate($post,$id) {
                include "shared/db_links.php";

		$update=array("status"=>$post['status'],"closed_date"=>date('Y-m-d H:i:s'));
                $this->dbi->update_record("kms_isp_support",$update,"id=$id",$dblink_cp);
		$this->dbi->update_record("kms_isp_support",$update,"id=$id",$dblink_erp);

	}



}
?>
