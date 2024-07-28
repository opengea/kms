<?

// ----------------------------------------------
// Class ERP Finance Bank Accounts for KMS
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class erp_finance_bankaccounts extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

	var $table	= "kms_erp_finance_banks_accounts";
	var $key	= "id";	
	var $fields = array("type", "description", "bank_name","account");
	var $notedit=array("dr_folder","entity_number","office_number","dc_number","account_number");
	var $title = "Bancs i Caixes";
	var $orderby = "bank_name";
	var $sortdir = "desc";

        /*=[ PERMISSIONS ]===========================================================*/

	var $can_edit = true;
	var $can_delete = true;
	var $can_add	= true;
	var $import = true;
	var $export = true;
	var $search = true;

       //*=[ CONSTRUCTOR ]===========================================================*/

        function erp_finance_bankaccounts ($client_account,$user_account,$dm) {
                parent::mod($client_account,$user_account,$extranet);
        }

        function setup($client_account,$user_account,$dm) {

		$this->setComponent("select","type",array("bank_account"=>_KMS_ERP_FINANCE_BANKACCOUNT,"visa"=>_KMS_ERP_FINANCE_BANKACCOUNTS_VISA));
		$this->setComponent("select","divisa",array("euro"=>"Euro","Dollar"=>"Dollar","Yen"=>"Yen"));
		$this->ts_format  = "m/d/Y h:i A";
		$this->insert_label = "Nou Banc o caixa";
		$this->setComponent("xcombo","bank_name",array("xtable"=>"kms_erp_finance_banks","xkey"=>"bank_name","xfield"=>"bank_name","readonly"=>false, "linkcreate"=>false, "linkedit"=>false, "sql"=>""));
	}

}

?>
