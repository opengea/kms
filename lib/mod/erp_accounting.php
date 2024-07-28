<?

// ----------------------------------------------
// Class ERP Finance for KMS
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class erp_accounting extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

	var $table	= "kms_erp_accounting";
	var $key	= "id";	
	var $fields 	= array("status", "account", "description", "acc_subgroup", "acc_group", "vr_debit","vr_credit","vr_balance");
	var $orderby 	= "account";
	var $sortdir 	= "asc";

        /*=[ PERMISSIONS ]===========================================================*/

        var $can_view 	= true;
        var $can_edit 	= true;
        var $can_delete = true;
	var $can_duplicate = true;
        var $can_add  	= true;
        var $can_import = false;
        var $can_export = true;
        var $can_search = true;

       //*=[ CONSTRUCTOR ]===========================================================*/
        function erp_accounting($client_account,$user_account,$dm) {
                parent::mod($client_account,$user_account,$extranet);
        }

        function setup($client_account,$user_account,$dm) {
		$this->page_rows = 50;
		$this->setComponent("wysiwyg","comments",array("type"=>"richtext"));
		$this->setComponent("xcombo","plan_id",array("xtable"=>"kms_erp_accounting_plans","xkey"=>"id","xfield"=>"description","readonly"=>false,"linkcreate"=>false,"linkedit"=>false,"sql"=>""));
		$this->setComponent("select","status",array("1"=>"<font color=#009900>"._KMS_GL_STATUS_ACTIVE."</font>","0"=>"<font color=#ff0000>"._KMS_GL_STATUS_INACTIVE."</font>"));
		$this->setComponent("select","account_type",array("0"=>"PASSIU","1"=>"ACTIU","2"=>"DESPESES","3"=>"INGRESSOS","4"=>"COMPRA-VENTA","5"=>"PATRIMONI NET","6"=>"EFECTIU","7"=>"IMMOBILITZAT","8"=>"PERDUES I GUANYS"));
		$this->setComponent("uniselect","acc_group");
		$this->setComponent("uniselect","acc_subgroup");
                //formules
                $this->setComponent("status_icon", "vr_debit", array("script"=>"erp_accounting_debit"));
		$this->setComponent("status_icon", "vr_credit", array("script"=>"erp_accounting_credit"));
		$this->setComponent("status_icon", "vr_balance", array("script"=>"erp_accounting_balance"));
                $this->customButtons=Array();
                if ($_SESSION['erp_accounting_exercici']=="") $_SESSION['erp_accounting_exercici']=date('Y');
                $this->customButtons[0] = Array ("label"=>"Exercici ".$_SESSION['erp_accounting_exercici'],"url"=>"","ico"=>"pdf.gif","params"=>"action=change_exercici","target"=>"_self","checkFunction"=>"","class"=>"highlight");
                $this->action("change_exercici","/usr/local/kms/mod/erp/change_exercici.php");
		$this->styleRow=array("field"=>"","rule"=>"styleRowRule","styles"=>array("1"=>"color:#20827a","2"=>"color:#206882","3"=>"color:#618220","4"=>"color:#822081","5"=>"color:#2d64c7","6"=>"color:#c42b2b","7"=>"color:#037619","8"=>"color:#c10466","9"=>"color:#019a98"));

		//reports
		$this->action("report_model_303","/usr/share/kms/lib/reports/report_model_303.php");
        	$this->action("report_model_390","/usr/share/kms/lib/reports/report_model_390.php");
		$this->action("report_years","/usr/share/kms/lib/reports/rpt_invoices_compare_years.php");
  	        $this->action("report_months","/usr/share/kms/lib/reports/rpt_invoices_compare_months.php");
       		$this->action("report_mailings","/usr/share/kms/lib/reports/report-mailings.php");
       		$this->action("rpt_invoices_year","/usr/share/kms/lib/reports/rpt_invoices_year.php");
       		$this->action("rpt_model_347","/usr/share/kms/lib/reports/rpt_model_347.php");
       		$this->action("rpt_model_349","/usr/share/kms/lib/reports/rpt_model_349.php");
	        $this->action("rpt_top_clients","/usr/share/kms/lib/reports/rpt_top_clients.php");
	        $this->action("rpt_model_200","/usr/share/kms/lib/reports/rpt_model_200.php");


        }

        function styleRowRule($record) {
                return substr($record->account,0,1);
        }


}
?>
