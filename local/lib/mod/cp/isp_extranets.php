<?

// ----------------------------------------------
// Class ISP Extranets for KMS
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class isp_extranets extends mod {

        /*=[ CONFIGURATION ]=====================================================*/
	var $table  = "kms_isp_extranets";
	var $key    = "id";	
	var $fields = array("id", "status", "client_id", "client_name", "subdomain","domain", "dbhost","creation_date");
	var $readonly = array("expiration_date","creation_date","updated_date","authcode","domain_name");
	var $notedit_insert  = array("hosting_id","client_name","default_lang","");
	var $notedit = array("uaa_mapping","logo");
	var $orderby = "creation_date";
	var $sortdir = "desc";
	//var $notedit=array("client_id");
        /*=[ PERMISSIONS ]===========================================================*/

	var $can_edit   = true;
	var $can_delete = true;
	var $can_add    = true;
	var $can_import = false;
	var $can_export = true;
	var $can_duplicate = true;

       //*=[ CONSTRUCTOR ]===========================================================*/

        function isp_extranets($client_account,$user_account,$dm) {
                parent::mod($client_account,$user_account,$extranet);
        }

        function setup($client_account,$user_account,$dm) {
//		$this->setComponent("ranxid","dbpasswd");
//		 $this->setComponent("ranxid","password");
		$this->setComponent("random","password");
		$this->humanize("client_id","Id Client");
		$this->humanize("notes","Notes");
		$this->humanize("Last updated","Ultima notificaci&oacute;");
		$this->humanize("type","Tipus");
		$this->humanize("status","Estat");
		$this->humanize("creation_date","Data de creaci&oacute;");
		$this->defvalue("status","online");
		$this->defvalue("modules","extranet|sites|imark");
		$this->defvalue("autorenew","1");
		$this->defvalue("hide_whois_info","1");
		$this->defvalue("nameserver1","ns3.intergridnetwork.net");
		$this->defvalue("nameserver2","ns4.intergridnetwork.net");
		$this->humanize("mailing_discount_pc","Descompte mailings (%)");
		$this->defvalue("max_users",-1);
		$this->defvalue("dbhost","a2.intergridnetwork.net");
		$this->defvalue("dbtype","mysql");
		$this->defvalue("dbport","3306");
		$this->defvalue("default_lang","ct");
		$this->setComponent("uniselect","default_lang");
		$this->setComponent("multiselect","modules");
		$this->defvalue("subdomain","extranet");
		$this->defvalue("username","admin");
		$this->maxlength("dbuser","16");
		$uploadDate = date('Y-m-d');
		$this->defvalue("creation_date",$uploadDate);
		$this->default_content_type = "host";
		$this->default_php = "hosts.php";
//		$this->setComponent("xcombo","client_id",array("xtable"=>"kms_ent_clients","xfield"=>"id","xselectionfield"=>"id","readonly"=>false,"linkcreate"=>true,"linkedit"=>true,"sql"=>"select id,name from kms_ent_contacts where kms_ent_contacts.id in (select sr_client from kms_ent_clients) order by name"));
//		$this->setComponent("xcombo","client_id",array("xtable"=>"kms_ent_clients","xfield"=>"id","xselectionfield"=>"email","readonly"=>false,"linkcreate"=>true,"linkedit"=>true,"sql"=>""));
		$this->multixref("client_id", "id", "email", "kms_ent_clients");


		$this->setComponent("xcombo","client_id",array("xtable"=>"kms_ent_clients","xkey"=>"id","xfield"=>"email","readonly"=>false,"linkcreate"=>true,"linkedit"=>true,"sql"=>""));
		 $this->setComponent("xcombo","hosting_id",array("xtable"=>"kms_isp_hostings","xkey"=>"id","xfield"=>"description","readonly"=>false,"linkcreate"=>true,"linkedit"=>true,"sql"=>""));
//		$this->setComponent("xcombo","contract_id",array("xtable"=>"kms_erp_contracts","xkey"=>"id","xfield"=>"description","readonly"=>false,"linkcreate"=>true,"linkedit"=>true,"sql"=>"select description from kms_erp_contracts where sr_client="));
		$this->setComponent("xcombo","contract_id",array("xtable"=>"kms_erp_contracts","xkey"=>"id","xfield"=>"domain","readonly"=>false,"linkcreate"=>true,"linkedit"=>true,"sql"=>"select kms_erp_contracts.id,CONCAT(domain,' - ',name_ca) from kms_erp_contracts INNER JOIN kms_ecom_services ON kms_erp_contracts.sr_ecom_service=kms_ecom_services.id and (family=3 or family=2) and kms_erp_contracts.status='active' order by domain"));
		$this->insert_label = "Nou client KMS";
		$this->setComponent("select", "status", array("online"=>"<font color='#00aa00'><b>online</b></font>","offline"=>"<font color='#cc0000'><b>offline</b></font>"));
		$this->setComponent("checklist","autorenew",array("1"=>""));
		$this->setComponent("checklist","hide_whois_info",array("1"=>""));
        	$this->onInsert = "onInsert";
	        $this->onUpdate ="onUpdate";
		$this->onDelete = "onDelete";
		$this->customOptions = Array();
		$this->customOptions[0] = Array ("label"=>"Instal&middot;lar client","url"=>"http://intranet.intergrid.cat/kms/lib/isp/install/install_isp_kms_client.php?","ico"=>"on.gif","params"=>"","target"=>"_self");
//		$this->setComponent("cipher","password","plain");
	}

	 function onInsert ($post,$id) {
		// No hi hauria d'haver aquesta funcio perque MAI crearem una extranet manualment, sino que es creara a partir d'un CONTRACTE sempre.


                // update extranets on master server
		$select="select * from kms_ent_contacts inner join kms_ent_clients on kms_ent_contacts.id=kms_ent_clients.sr_client and kms_ent_clients.sr_client=$id";
		$result=$this->dbi->query($select);
		$extended_client=mysql_fetch_array($result);
		$dblink=$this->dbi->db_connect("master",$this->dbi,"JADF7320cSJdcj3750492x42dj244");
		$post['client_name']=$extended_client['name'];
		$post['default_lang']=$extended_client['language'];
	
		$extranet=$this->dbi->get_record("kms_isp_extranets","id=$id");		
		include "shared/db_links.php";

		if ($_SERVER['HTTP_HOST']=="intranet.intergrid.cat") {
		$this->dbi->insert_record("kms_isp_extranets",$extranet,$dblink_cp);
		} else {
		$this->dbi->insert_record("kms_isp_extranets",$extranet,$dblink_erp);	
		}
        }

	function onUpdate ($post,$id) {
		include "shared/db_links.php";
                $extranet=$this->dbi->get_record("select * from kms_isp_extranets where id=$id");
                if ($_SERVER['HTTP_HOST']=="intranet.intergrid.cat") {
                        $this->dbi->update_record("kms_isp_extranets",$extranet,"id=".$id,$dblink_cp);
                } else {
                        $this->dbi->update_record("kms_isp_extranets",$extranet,"id=".$id,$dblink_erp);
                }
	}
	
	function onDelete ($post,$id) {
		include "shared/db_links.php";
                if ($_SERVER['HTTP_HOST']=="intranet.intergrid.cat") {
                        $this->dbi->query("delete from kms_isp_extranets where id=$id",$dblink_cp);
                } else {
                        $this->dbi->query("delete from kms_isp_extranets where id=$id",$dblink_erp);
                }

	}
}
?>
