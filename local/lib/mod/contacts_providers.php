<?
// ----------------------------------------------
// Class Contacts Providers for KMS
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class contacts_providers extends mod {

        /*=[ CONFIGURACIO ]=====================================================*/

	var $table	= "kms_contacts_providers";
	var $key	= "id";	
	var $fields = array("creation_date", "status", "type", "entity_id","fixed_cost","estimated_cost","credit","venciment");
	var $orderby = "creation_date";
	var $sortdir = "desc";
	var $linkField = "entity_id";
	var $notedit = array("dr_folder");

       //*=[ CONSTRUCTOR ]===========================================================*/

        function contacts_providers($client_account,$user_account,$dm) {
                parent::mod($client_account,$user_account,$extranet);
        }

        function setup($client_account,$user_account,$dm) {

		$this->multixref("entity_id", "id", "name", "kms_contacts_entities");
		
//		DESFASSAT $this->xcombo("entity_id", "kms_contacts_entities", "id", "name", false, "");
//		DESFASSAT $this->xcombo("sr_payment_method", "kms_ecom_payment_methods", "id", "payment_name", true, "");
//		DESFASSAT  $this->xlist("Contractes","SELECT kms_contracts.id, kms_contracts.status, kms_services.name, kms_contracts.description, kms_contracts.billing_period FROM kms_contracts,kms_services WHERE kms_contracts.sr_client='".$_GET['srid']."' and kms_services.id = kms_contracts.sr_ecom_service");
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
		$this->custom_action1 = "?mod=contacts_entities&_=e";
		$this->custom_action2 = "?mod=contracts&dr_folder=160&queryfield=sr_client";
		$this->custom_action3 = "?mod=invoices&dr_folder=159&queryfield=sr_client";
		$this->custom_action4 = "";
		//$this->custom_action5 = "";
		$this->setComponent("select","status",array("alta"=>"<font color=#00AA00><b>alta</b></font>","migracio"=>"<font color=#ff0000>migracio</font>","aturat"=>"<font color=#ff0000>aturat</a>","baixa"=>"<font color=#ff0000>baixa</font>"));
		$this->setComponent("uniselect","type");
//		DESFASSAT $this->xcombo("sr_bank_name", "kms_erp_finance_banks", "id", "bank_name", false, "");

	}
}
?>

