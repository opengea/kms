<?

// ----------------------------------------------
// Class ISP Hostings for KMS 
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class isp_hostings extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

	var $table	= "kms_isp_hostings";
	var $key	= "id";	
	var $fields = array("creation_date", "status", "sr_contract", "sr_client", "sr_family", "domain_name", "nameserver1","expiration_date");
	var $orderby = "creation_date";
	var $readonly = array("status","sr_client","sr_family","expiration_date","creation_date","updated_date","domain_authcode","domain_name");

        function isp_hostings($client_account,$user_account,$dm) {
                parent::mod($client_account,$user_account,$extranet);
        }

        function setup($client_account,$user_account,$dm) {

		$this->humanize("dr_folder","carpeta");
		$this->defvalue("status","active");
		$this->defvalue("domain_autorenew","1");
		$this->defvalue("domain_hide_whois_info","1");
		$this->defvalue("nameserver1","ns3.intergridnetwork.net");
		$this->defvalue("nameserver2","ns4.intergridnetwork.net");
		$uploadDate = date('Y-m-d');
		$this->defvalue("creation_date",$uploadDate);
		$this->setComponent("xcombo","sr_client",array("xtable"=>"kms_contacts_entities","xkey"=>"id","xfield"=>"name","readonly"=>false,"linkcreate"=>true,"linkedit"=>true,"sql"=>""));
		$this->setComponent("xcombo","sr_family",array("xtable"=>"kms_ecom_services","xkey"=>"id","xfield"=>"name_ct","readonly"=>false,"linkcreate"=>true,"linkedit"=>true,"sql"=>""));
		$this->insert_label = "Registrar nou domini";
		$this->setComponent("select","status",array("actiu"=>"<font color=#00AA00><b>actiu</b></font>","anulat"=>"<font color=#999999>anulat</b>","terminator"=>"<b><font color=#ff0000>terminator</b></b>","finalitzat"=>"<b><font color=#8A084B>finalitzat</b></font>"));
		$this->setComponent("checklist","domain_autorenew",array("1"=>""));
		$this->setComponent("checklist","domain_hide_whois_info",array("1"=>""));
	}

}
?>
