<?
// ----------------------------------------------
// Class Contacts Providers for KMS
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class ent_providers extends mod {

        /*=[ CONFIGURACIO ]=====================================================*/

	var $table	= "kms_ent_providers";
	var $key	= "id";	
	var $fields = array("id","creation_date", "status", "type", "contact_id");
	var $orderby = "creation_date";
	var $sortdir = "desc";
	var $linkField = "contact_id";
	var $notedit = array("");

       //*=[ CONSTRUCTOR ]===========================================================*/

        function ent_providers($client_account,$user_account,$dm) {
                parent::mod($client_account,$user_account,$extranet);
        }

        function setup($client_account,$user_account,$dm) {

		$this->setComponent("xcombo","contact_id",array("xtable"=>"kms_ent_contacts","xkey"=>"id", "xfield"=>"name", "readonly"=>false, "linkcreate"=>true, "linkedit"=>true, "sql"=>""));
		$this->defvalue("status","active");
		$uploadDate = date('Y-m-d');
		$this->defvalue("creation_date",$uploadDate);
		$this->defvalue("satisfaction","no avaluat");
		$this->defvalue("sr_provider",1);
		$this->default_content_type = "client";
		$this->insert_label = "Nova fitxa";
		$this->edit_rfile = "Editar fitxa de client";
		$this->custom_button1 = "Fitxa de client";
		$this->custom_button2 = "Contractes";
		$this->custom_button3 = "Factures";
		$this->custom_button4 = "Estad&iacute;stiques";
		//$this->custom_button5 = "xxxxx";
		$this->custom_action1 = "?mod=ent_contacts&_=e";
		$this->custom_action2 = "?mod=contracts&dr_folder=160&queryfield=sr_client";
		$this->custom_action3 = "?mod=invoices&dr_folder=159&queryfield=sr_client";
		$this->custom_action4 = "";
		//$this->custom_action5 = "";
		$this->setComponent("select","status",array("alta"=>"<font color=#00AA00><b>alta</b></font>","migracio"=>"<font color=#ff0000>migracio</font>","aturat"=>"<font color=#ff0000>aturat</a>","baixa"=>"<font color=#ff0000>baixa</font>"));
		$this->setComponent("select","zone_id",array("0"=>"Estat Espanyol","1"=>"Estat membre UE","2"=>"Altres"));
		$this->setComponent("uniselect","type");
//		DESFASSAT $this->xcombo("sr_bank_name", "kms_erp_finance_banks", "id", "bank_name", false, "");

	}
}
?>

