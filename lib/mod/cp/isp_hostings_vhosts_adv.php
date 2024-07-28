<?

// ----------------------------------------------
// Class ISP Hostings for KMS
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class isp_hostings_vhosts_adv extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

	var $table	= "kms_isp_hostings_vhosts";
	var $key	= "id";	
	var $fields = array("id","sr_client","name","hosting_id","vr_limits","vr_services");
	var $orderby = "name";
	var $notedit=array("dr_folder","client_id");

        /*=[ PERMISSIONS ]===========================================================*/

	var $can_edit = false;
	var $can_delete = false;
	var $can_add        = false;
	var $can_import = false;
	var $can_export = false;
	var $can_view = false;
	var $can_search = false;
       //*=[ CONSTRUCTOR ]===========================================================*/

        function isp_hostings_vhosts_adv($client_account,$user_account,$dm) { //,$silent) {
                if (!$silent) {
                $select="SELECT * FROM kms_isp_clients where sr_user=".$user_account['id'];
                $result=mysql_query($select);
                if (!$result) die(mysql_error($result));
                $client=mysql_fetch_array($result);

                if ($this->_group_permissions(1,$user_account['groups'])||$_SERVER['HTTP_HOST']=="intranet.intergrid.cat")  {
                        $this->notedit=array();
                        $this->readonly=array();
                } else if ($this->_group_permissions(3,$user_account['groups'])) {
			$this->where = "kms_isp_hostings_vhosts.sr_client in (select kms_isp_clients.sr_client from kms_isp_clients where kms_isp_clients.sr_provider=".$client['sr_client'].")";
                } else  {
			if ($client['sr_client']=="") $this->_error("","You don't have admin privileges.","fatal");
                        $this->fields = array("creation_date","name","hosting_id","vr_limits","vr_services");
                        if ($_GET['_']=='b') $_GET['id']=$client['id'];
                        $this->where = "kms_isp_hostings_vhosts.sr_client=".$client['sr_client'];
                }
		}
                parent::mod($client_account,$user_account,$extranet);
        }

        function setup($client_account,$user_account,$dm) {
		$hide_databrowser=true;	
		include "/usr/local/kms/tpl/panels/isp_hosting_vhost_adv.php";

		$this->defvalue("autorenew","1");
                $this->humanize("hosting_id","Hosting");
                $this->humanize("vr_limits",_KMS_ISP_DOMAINS_LIMITS);
                $this->humanize("vr_services",_KMS_ISP_DOMAINS_SERVICES);

		$uploadDate = date('Y-m-d');
		$this->defvalue("creation_date",$uploadDate);
		$this->default_content_type = "host";
		$this->default_php = "hosts.php";
		$this->humanize("dr_folder","carpeta");
                $this->humanize("name","Domini");
                $this->humanize("real_size","Espai total");
		$this->setstyle("vr_limits","width:230px");
		$this->setstyle("vr_services","width:100px");
                $this->setComponent("bytes","mailboxes");
		//($xcombo_field,$xcombo_sql,$show,$value,$open)
		$this->setComponent("xcombo","sr_client",array("xtable"=>"kms_isp_clients","xkey"=>"id","xfield"=>"name","readonly"=>false,"linkcreate"=>true,"linkedit"=>true,"sql"=>""));
		$this->insert_label = "Registrar nou domini";
		$this->setComponent("select", "contract_status", array("actiu"=>"<font color='#00aa00'><b>actiu</b></font>","expired"=>"<font color='#cc0000'><b>finalitzat</b></font>","pending_delete"=>"<font color='#cc0000'><b>finalitzat - pendent d'esborrar</b></font>"));

		$this->setComponent("checklist","autorenew",array("1"=>""));
		$this->setComponent("checklist","hide_whois_info",array("1"=>""));

                $xsql=array("xv_xtable"=>"kms_isp_hostings", "xv_field"=>"hosting_id", "xv_xfield"=>"id", "xv_xselectionfield"=>"max_space");
                $this->xvField("vr_limits",array("sql"=>$xsql));
                $xsql=array("xv_xtable"=>"kms_isp_hostings", "xv_field"=>"hosting_id", "xv_xfield"=>"id", "xv_xselectionfield"=>"max_space");
                $this->xvField("vr_services",array("sql"=>$xsql));

        	$this->setComponent("status_icon", "name", array("script"=>"domain","orderby"=>"name"));
	        $this->setComponent("status_icon", "hosting_id", array("script"=>"isp_hostings_vhosts_hosting","show_label"=>true));
	        $this->setComponent("status_icon", "vr_limits", array("script"=>"isp_hostings_vhosts_limits"));
	        $this->setComponent("status_icon", "vr_services", array("script"=>"isp_hostings_vhosts_services"));

	}
}
?>
