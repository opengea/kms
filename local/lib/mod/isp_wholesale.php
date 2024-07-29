<?

// ----------------------------------------------
// Class ISP Clients for KMS
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class isp_wholesale extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

	var $table	= "kms_isp_wholesale";
	var $key	= "id";	
	var $fields = array("creation_date","status","sr_client", "business_type","domain");
	var $readonly = array("sr_client","sr_user","creation_date");
	var $orderby = "creation_date";
	var $notedit=array("sr_provider","status","sr_client","dr_folder","sr_user","creation_date","bank_name","default_payment_day");
	var $notedit_insert=array("sr_provider","status","sr_client","dr_folder","sr_user","creation_date","bank_name","default_payment_day","sr_user");

        /*=[ PERMISSIONS ]===========================================================*/

	// aqui seria interessant un can_browse = false
	var $can_edit  = true;
	var $can_delete = false;
	var $can_add    = true;
	var $can_import = false;
	var $can_export = false;

       //*=[ CONSTRUCTOR ]===========================================================*/

        function isp_wholesale($client_account,$user_account,$dm) {
		$select="SELECT * FROM kms_isp_wholesale WHERE sr_user=".$user_account['id'];
		$result=mysqli_query($this->dblinks['client'],$select);
		$client=mysqli_fetch_array($result);

                if ($this->_group_permissions(1,$user_account['groups']))  {
                        $this->notedit=array();
                        $this->readonly=array();
                } else if ($this->_group_permissions(3,$user_account['groups'])) {
			$this->notedit=array("sr_provider","sr_client","dr_folder","bank_name","default_payment_day");
                        $this->where = "sr_client in (select sr_client from kms_isp_wholesale where sr_provider=".$client['id'].")";
			if ($_GET['action']=='edit_client') { 
						$_GET['_']="e"; $_GET['id']=$client['id']; 
			} else { 
						array_push($this->notedit,"billing_email"); 
			}
                } else  {
			//always edit
			$_GET['_']="e"; $_GET['id']=$client['id'];
                        $this->fields = array("status","name","contacts","creation_date");
                        $this->where = "sr_client=".$client['sr_client'];
                }

		parent::mod($client_account,$user_account,$extranet);
        }

        function setup($client_account,$user_account,$dm) {
//		$this->action("update_domains","/usr/local/kms/mod/isp/update_domains.php");
		$this->setComponent("select","status",array("active"=>"<font color=#00AA00><b>"._KMS_GL_STATUS_ALTA."</b></font>","migracio"=>"<font color=#ff0000>"._KMS_GL_STATUS_MIGRACIO."</font>","aturat"=>"<font color=#ff0000>"._KMS_GL_STATUS_ATURAT."</a>","baixa"=>"<font color=#ff0000>"._KMS_GL_STATUS_BAIXA."</font>"));
                $this->setComponent("select","payment_status",array("al corrent"=>"<font color=#00AA00><b>"._KMS_GL_STATUS_AL_CORRENT."</b></font>","impagats"=>"<font color=#ff0000>"._KMS_GL_STATUS_IMPAGATS."</font>"));
		$this->setComponent("uniselect","sector");
		$this->setComponent("checklist","newsletter",array("1"=>""));
		$this->setComponent("select","language",array("ct"=>"Catal&agrave;","es"=>"Espa&ntilde;ol","eu"=>"Euskara","en"=>"English"));
		include "/usr/local/kms/lib/include/countries.php";
		$this->setComponent("select","country",$countries);
		$this->setComponent("select","business_type",array("reseller"=>"Reseller","Manager"=>"Manager","franchise"=>"Franchise"));
                $this->onUpdate = "onUpdate";
		$this->humanize("sr_user",_KMS_ISP_CP_USER);
                $this->setComponent("xref","sr_user",array("id","username","kms_sys_users"));
	}

	function onUpdate($post,$id) {
        }
}
?>
