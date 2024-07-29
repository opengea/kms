<?
// ----------------------------------------------
// Class ISP Hosts for KMS 
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class isp_servers extends mod {

        /*=[ CONFIGURATION ]=====================================================*/
	var $table	= "kms_isp_servers";
	var $key	= "id";	
	var $fields = array("id", "creation_date", "status", "free", "hostname", "type", "parent_server", "services", "description", "dc","alert","disk_used");
	var $orderby = "creation_date";
	var $sortdir = "desc";
	var $can_duplicate = true;

        function isp_servers($client_account,$user_account,$dm,$dblinks) { //,$silent
                parent::mod($client_account,$user_account,$extranet);
        }

        function setup($client_account,$user_account,$dm) {
		$this->humanize("Last updated","Ultima notificaci&oacute;");
		$this->humanize("type","Tipus");
		$this->humanize("parent_server","Parent server");
		$this->humanize("status","Estat");
		$this->humanize("creation_date","Data de creaci&oacute;");
		$this->humanize("alert","Alerta");
		$this->humanize("disk_used","Disk %");

		$this->defvalue("status","active");
		$this->defvalue("type","static");
		$this->defvalue("dc","IDC Alemanya");
		$uploadDate = date('Y-m-d');
		$this->defvalue("creation_date",$uploadDate);
		$this->default_content_type = "host";
		$this->insert_label = "Nou servidor";
		$this->defvalue("free",1);
		$this->setComponent("select", "alert", array("0"=>"<font color='#00aa00'>Ok</font>","1"=>"<font color='#cc0000'><b>Check</b></font>"));
		$this->setComponent("select", "status", array("active"=>"<font color='#00aa00'><b>actiu</b></font>","down"=>"<font color='#cc0000'>inactiu</font>"));
		$this->setComponent("select", "free", array("1"=>"<font color='#00aa00'><b>S&iacute;","0"=>"No"));
		$this->abbreviate("free","Free");
$this->setComponent("wysiwyg",'notes',array("type"=>"richtext"));
		$this->setComponent("select", "ip_type", array("static"=>"estatic","dynamic"=>"dinamic"));
		$this->setComponent("select", "type", array("physical"=>"f&iacute;sic","virtual"=>"virtual"));
		$this->setComponent("multiselect","services",array("sql"=>"select code,description from kms_isp_servers_types","xfield"=>"description","xkey"=>"code","xtable"=>"kms_isp_servers_types"));
		$this->setComponent("uniselect", "network");
		$this->setComponent("uniselect", "os");
		$this->setComponent("uniselect", "dc");
		$this->onInsert="onInsert";
		$this->onUpdate="onUpdate";
		$this->onDelete="onDelete";
		$this->addComment("free",_KMS_ISP_SERVERS_FREE_NOTE);
		$this->customOptions = Array();
                $this->customOptions[0] = Array ("label"=>"Instal&middot;lar servidor KMS","url"=>"http://intranet.intergrid.cat/kms/lib/isp/install/install_isp_kms_server.php?","ico"=>"on.gif","params"=>"","target"=>"_self");

	}

        function getInstallServers($type,$hosting) {
                $servers=array();

		if ($hosting['type']=="Virtual Private Server (VPS)"||$hosting['type']=="Dedicated Server") $type="dedicated";
		else if ($type=="kms") $type="kms"; 
		else $type="vhost";

		//si hosting ja existeix i esta definit
		if ($hosting['webserver_id']!=""||$hosting['mailserver']!="") {
                        $servers["webserver"]=$this->dbi->get_record("select id,hostname,ip from kms_isp_servers where id=".$hosting['webserver_id']);
                        $servers["mailserver"]=$this->dbi->get_record("select id,hostname,ip from kms_isp_servers where id=".$hosting['mailserver_id']);
                        $servers["nameserver1"]=$this->dbi->get_record("select id,hostname,ip from kms_isp_servers where id=1"); // ns3
                        $servers["nameserver2"]=$this->dbi->get_record("select id,hostname,ip from kms_isp_servers where id=8"); // ns4
                        return $servers;
                }

		//determine servers to install
                if ($type=="vhost") {
                        $servers["webserver"]=$this->dbi->get_record("select id,hostname,ip from kms_isp_servers where services like '%CH%' and free='1' and hostname like 'a%'"); 
                        $servers["mailserver"]=$this->dbi->get_record("select id,hostname,ip from kms_isp_servers where services like '%MX%' and free='1' and hostname like 'mx%'");
			$servers["nameserver1"]=$this->dbi->get_record("select id,hostname,ip from kms_isp_servers where id=1"); // ns3
                        $servers["nameserver2"]=$this->dbi->get_record("select id,hostname,ip from kms_isp_servers where id=8"); // ns4
                } else if ($type=="domain") {
                        $servers["nameserver1"]=$this->dbi->get_record("select id,hostname,ip from kms_isp_servers where id=1"); // ns3
                        $servers["nameserver2"]=$this->dbi->get_record("select id,hostname,ip from kms_isp_servers where id=8"); // ns4
                } else if ($type=="dedicated") {
			$servers["webserver"]=$this->dbi->get_record("select id,hostname,ip from kms_isp_servers where id=".$hosting['webserver_id']);
                        $servers["mailserver"]=$this->dbi->get_record("select id,hostname,ip from kms_isp_servers where id=".$hosting['mailserver_id']); 
			$servers["nameserver1"]=$this->dbi->get_record("select id,hostname,ip from kms_isp_servers where id=1"); // ns3
                        $servers["nameserver2"]=$this->dbi->get_record("select id,hostname,ip from kms_isp_servers where id=8"); // ns4
		} else if ($type=="kms") {
			$servers["webserver"]=$this->dbi->get_record("select id,hostname,ip from kms_isp_servers where services like '%KH%' and free='1' and hostname like 'a%'"); 
                        $servers["mailserver"]=$this->dbi->get_record("select id,hostname,ip from kms_isp_servers where services like '%MX%' and free='1' and hostname like 'mx%'"); 
			$servers["nameserver1"]=$this->dbi->get_record("select id,hostname,ip from kms_isp_servers where id=1"); // ns3
                        $servers["nameserver2"]=$this->dbi->get_record("select id,hostname,ip from kms_isp_servers where id=8"); // ns4
		} 
                return $servers;
        }

	function onInsert($post,$id) {
		$server=$this->dbi->get_record("select * from kms_isp_servers where id=$id");
		include "shared/db_links.php";
		if ($this->current_extranet=="erp") $this->dbi->insert_record("kms_isp_servers",$server,$dblink_cp);
		else $this->dbi->insert_record("kms_isp_servers",$server,"id=$id",$dblink_erp);
		die ("Servidor donat d'alta correctament.\nCal crear el servidor ".$post['hostname']." a les dns d'intergridnetwork.net i despr&eacute;s executar ssh-copy-id -i ~/.ssh/id_rsa root@".$post['hostname']." a tartarus i a cp!!");
	}

	function onUpdate($post,$id) {
		include "shared/db_links.php";
		$this->dbi->update_record("kms_isp_servers",array("last_updated"=>date('Y-m-d h:i:s')),"id=$id",$dblink_erp);
		$server=$this->dbi->get_record("select * from kms_isp_servers where id=$id");
                if ($this->current_extranet=="erp") $this->dbi->update_record("kms_isp_servers",$server,"id=$id",$dblink_cp);
                else $this->dbi->update_record("kms_isp_servers",$server,"id=$id",$dblink_erp);
        }

	function onDelete($post,$id) {
                include "shared/db_links.php";
                if ($this->current_extranet=="erp") $this->dbi->delete_record("kms_isp_servers","id=$id",$dblink_cp);
                else  $this->dbi->delete_record("kms_isp_servers","id=$id",$dblink_erp);
        }


}
?>
