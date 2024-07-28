<?

// ----------------------------------------------
// Class ISP Messages for KMS
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class isp_messages extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

	var $table	= "kms_isp_messages";
	var $key	= "id";	
	var $fields = array("creation_date", "type", "message");
//	var $readonly = array("expiration_date","creation_date","updated_date","authcode","domain_name");
	var $orderby = "creation_date";
	var $notedit=array("dr_folder");

        /*=[ PERMISSIONS ]===========================================================*/

	var $can_edit   = false;
	var $can_delete = false;
	var $can_add    = false;
	var $can_import = false;
	var $can_export = false;

       //*=[ CONSTRUCTOR ]===========================================================*/

        function isp_messages($client_account,$user_account,$dm,$dblinks) { 
                parent::mod($client_account,$user_account,$extranet);
        }

        function setup($client_account,$user_account,$dm) {
		if (($_GET['app']=="cp"||$_GET['app']=="cp-reseller")&&!$this->_group_permissions(1)) {
		$select="SELECT * FROM kms_isp_clients where sr_user=".$user_account['id'];
                $result=mysqli_query($this->dblinks['client'],$select);
                if (!$result) die(mysqli_error($result));
                $client=mysqli_fetch_array($result);
		if ($client['sr_client']=="") { $this->_error("","User disabled. Contact your administator.","logout");  }

		//force complete client data
		if ($client['cif']==""||$client['contacts']==""||$client['language']==""||$client['email']==""||$client['phone']==""||$client['address']==""||$client['country']==""||$client['sr_payment_method']==""||($client['sr_payment_method']=="3"&&$client['bank_accountNumber']=="")||($client['sr_payment_method']=="12"&&($client['credit_card']==""||$client['credit_card_name']==""||$client['credit_card_expiration_date']==""||$client['credit_card_vcs']==""))) {
		echo "<script language='javascript'>document.location='http://control.intergridnetwork.net/?app=".$_GET['app']."&mod=isp_clients&action=edit_client';</script>";	

		}
		}
		if ($_GET['app']=="sysadmin"||$_GET['app']=="sys_dashboards") include "/usr/local/kms/tpl/panels/sysadmin/main.php"; else include "/usr/local/kms/tpl/panels/isp_dashboard.php";

		$this->setComponent("uniselect","registrar");
		$this->setComponent("uniselect","status");
		$this->setComponent("uniselect","nameserver1");
		$this->setComponent("uniselect","nameserver2");
		$this->setComponent("uniselect","htype");
		$this->humanize("dr_folder","carpeta");
		$this->humanize("notes","Notes");
		$this->humanize("Last updated","Ultima notificaci&oacute;");
		$this->humanize("type","Tipus");
		$this->humanize("creation_date","Data de creaci&oacute;");
		$this->defvalue("status","LOCK");
		$this->defvalue("autorenew","1");
		$this->defvalue("hide_whois_info","1");
		$this->defvalue("nameserver1","ns3.intergridnetwork.net");
		$this->defvalue("nameserver2","ns4.intergridnetwork.net");
		$uploadDate = date('Y-m-d');
		$this->defvalue("creation_date",$uploadDate);
		$this->default_content_type = "host";
		$this->default_php = "hosts.php";
		$this->humanize("dr_folder","carpeta");
                $this->humanize("name","Domini");
                $this->humanize("real_size","Espai total");
                $this->humanize("plesk_space_limit","Espai Plesk");
                $this->humanize("real_traffic","Trafic total");
                $this->humanize("contract_space_limit","Espai contr.");
                $this->setComponent("bytes","real_size");
                $this->setComponent("bytes","plesk_space_limit");
                $this->setComponent("bytes","contract_space_limit");
                $this->setComponent("bytes","plesk_traffic_limit");
                $this->setComponent("bytes","contract_traffic_limit");
                $this->setComponent("bytes","real_traffic");
                $this->setComponent("bytes","httpdocs");
                $this->setComponent("bytes","httpsdocs");
                $this->setComponent("bytes","web_users");
                $this->setComponent("bytes","anonftp");
                $this->setComponent("bytes","logs");
                $this->setComponent("bytes","dbases");
                $this->setComponent("bytes","mailboxes");
		//($xcombo_field,$xcombo_sql,$show,$value,$open)
		$this->setComponent("xcombo","sr_client",array("xtable"=>"kms_ent_contacts","xkey"=>"id","xfield"=>"name","readonly"=>false,"linkcreate"=>true,"linkedit"=>true,"sql"=>""));
		$this->insert_label = "Registrar nou domini";
		$this->setComponent("checklist","autorenew",array("1"=>""));
		$this->setComponent("checklist","hide_whois_info",array("1"=>""));
	}
}
?>
