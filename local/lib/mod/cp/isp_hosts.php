<?
// ----------------------------------------------
// Class ISP Hosts for KMS 
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class isp_hosts extends mod {

        /*=[ CONFIGURATION ]=====================================================*/
	var $table	= "kms_isp_hosts";
	var $key	= "id";	
	var $fields = array("id", "status", "network", "hostname", "type", "ip", "last_updated", "creation_date");
	var $title = "Hosts";
	var $orderby = "network";

        function isp_hosts($client_account,$user_account,$dm) {
                parent::mod($client_account,$user_account,$extranet);
        }

        function setup($client_account,$user_account,$dm) {
		$this->humanize("Last updated","Ultima notificaci&oacute;");
		$this->humanize("type","Tipus");
		$this->humanize("status","Estat");
		$this->humanize("creation_date","Data de creaci&oacute;");

		$this->defvalue("status","active");
		$this->defvalue("type","static");
		$uploadDate = date('y-m-d');
		$this->defvalue("creation_date",$uploadDate);
		$this->default_content_type = "host";
		$this->default_php = "hosts.php";
		$this->insert_label = "Nou host";

		$this->setComponent("select", "status", array("active"=>"<font color='#00aa00'><b>actiu</b></font>","down"=>"<font color='#cc0000'>inactiu</font>"));
		$this->setComponent("select", "ip_type", array("static"=>"estatic","dynamic"=>"dinamic"));
		$this->setComponent("select", "type", array("physical"=>"f&iacute;sic","virtual"=>"virtual"));
		$this->setComponent("uniselect", "network");
		 $this->setComponent("uniselect", "services");
		$this->setComponent("uniselect", "os");
		$this->setComponent("uniselect", "datacenter");
	}
}
?>
