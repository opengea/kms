<?

// ----------------------------------------------
// Class Ecommerce Sales for KMS 
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class ecom_sales extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

	var $table	= "kms_ecom_sales";
	var $key	= "id";	
	var $fields = array("id", "creation_date", "status",  "client_name", "service", "lang", "price");
	var $orderby = "creation_date";
	var $sortdir = "desc";

        /*=[ PERMISOS ]===========================================================*/

        var $can_edit 	= true;
        var $can_delete = true;
        var $can_add	= true;
        var $can_import = true;
        var $can_export = true;
        var $can_duplicate = true;

      //*=[ CONSTRUCTOR ]===========================================================*/

        function ecom_sales($client_account,$user_account,$dm) {
                parent::mod($client_account,$user_account,$extranet);
        }

        function setup($client_account,$user_account,$dm) {


$this->setComponent("xcombo","sr_entity",array("xtable"=>"kms_ent_contacts","xkey"=>"id", "xfield"=>"name","readonly"=>false, "linkcreate"=>true, "linkedit"=>true, "sql"=>""));

$this->setComponent("xcombo","sr_family",array("xtable"=>"kms_ecom_services","xkey"=>"id", "xfield"=>"name","readonly"=>false, "linkcreate"=>true, "linkedit"=>true, "sql"=>""));

		$this->humanize("agent","Agent");
		$this->humanize("closing_date","Closing Date");
		$this->humanize("description","Description");

		$uploadDate = date('d-m-Y');
		$this->defvalue("start_date",$uploadDate);
		//$closingDate = date('d-'.date('m')+6.'-Y');
		$closingDate = date ("d-m-Y", mktime (0,0,0,date('m')+6,date('d'),date('Y')));

		//zonedate('Y-m-d',-12,true,mktime(0, 0, 0, date("d"), date("m")+6, date("Y"));
		$this->defvalue("closing_date",$closingDate);

		$this->default_content_type = "sales";
		$this->default_php = "sales.php";

		$this->setComponent("uniselect","lang");
		$this->setComponent("select","status",array("pending"=>"<font color=#ff4400>Pending</font>","failed"=>"<font color=#00ff00><b>Payment failed</b></font>","payed"=>"<font color=#090>Payed</font>","delivered"=>"<font color=#ff0000>Delivered</font>","completed"=>"<font color=#000066>Completed</a>"));

		$this->setComponent("select","priority",array("Low"=>"<font color=#666666>low</font>","Normal"=>"<font color=#0000ff>normal</font>","High"=>"<font color=#ff3300>high</alta>","Top"=>"<font color=#ff0000><b>top</b></font>"));
		$this->setComponent("select","product",array("Membership"=>"Membership","Advertising"=>"Advertising", "Exchanges"=>"Exchanges", "Media Press"=>"Media Press", "Mailing"=>"Mailing"));

		$this->setComponent("file", "contract",array($this->kms_datapath."/files/sales","http://data.intergrid.cat/files/sales"));

	}
}
?>

