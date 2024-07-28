<?

// ----------------------------------------------
// Class ERP Finance Bank Accounts for KMS
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class erp_finance_banks_transactions extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

	var $table	= "kms_erp_finance_banks_transactions";
	var $key	= "id";	
	var $fields = array("id","validat","intracom","account_id","creation_date","txn_type","concept","description", "import", "balance","disable","from_office");
	var $notedit=array("entity_number","office_number","dc_number","account_number");
	var $orderby = "creation_date";
	var $readonly = array("balance","import","saldo","account_id","creation_date","from_office","concept","description","txn_type","validat", "code_concept");
	var $sortdir = "desc";
        var $sum        = array("import");
        /*=[ PERMISSIONS ]===========================================================*/

	var $can_edit = true;
	var $can_delete = false;
	var $can_add	= false;
	var $import = false;
	var $export = true;
	var $search = true;

       //*=[ CONSTRUCTOR ]===========================================================*/

        function erp_finance_banks_transactions ($client_account,$user_account,$dm) {
                parent::mod($client_account,$user_account,$extranet);
        }

        function setup($client_account,$user_account,$dm) {
		if ($this->_group_permissions(1,$user_account['groups'])) { //admin 
		$this->can_delete=true;
		$this->can_add=true;
		$this->can_duplicate=true;	
		$this->readonly = array("balance","import","saldo","creation_date");
		if ($_GET['_']=="i"||$_GET['_']=="e") $this->readonly=array();
		$this->setComponent("xcombo","account_id",array("xtable"=>"kms_erp_finance_banks_accounts","xkey"=>"id", "xfield"=>"description","readonly"=>false,"linkcreate"=>false,"linkedit"=>false,"sql"=>""));
		} else {
		$this->setComponent("xcombo","account_id",array("xtable"=>"kms_erp_finance_banks_accounts","xkey"=>"id", "xfield"=>"description","readonly"=>true,"linkcreate"=>false,"linkedit"=>false,"sql"=>""));
		}
		 $this->humanize("creation_date","Data");
		 $this->humanize("from_office","Oficina");
		$this->humanize("concept","Entitat/Concepte");
		$this->humanize("txn_type","Tipus");
		$this->humanize("import","Import");
		$this->setComponent("select","txn_type",array(
			"???????????"=>"<span style='background-color:#000;color:#fff;padding:6px'>?????????????</span>",
			"ingres.clients"=>"<span style='background-color:#090;color:#fff;padding:6px'>INGR&Eacute;S CLIENTS</span>",
			"aportacions.capital"=>"<span style='background-color:#0c8;color:#fff;padding:6px'>APORTACIONS SOCIS</span>",
			"despeses.financeres"=>"<span style='background-color:#ab0;color:#fff;padding:6px'>DESPESES FINANCERES</span>",
                	"credit financer"=>"<span style='background-color:#099;color:#fff;padding:6px'>CREDIT FINANCER</span>",
                	"devolucions"=>"<span style='background-color:#f99;color:#fff;padding:6px'>DEVOLUCIONS</span>",
                	"hisenda"=>"<span style='background-color:#900;color:#fff;padding:6px'>HISENDA</span>",
                	"seguretat_social"=>"<span style='background-color:#900;color:#fff;padding:6px'>SEG.SOCIAL</span>",
                	"ajuntament"=>"<span style='background-color:#900;color:#fff;padding:6px'>AJUNTAMENT</span>",
			"registre_mercantil"=>"<span style='background-color:#900;color:#fff;padding:6px'>REG.MERCANTIL</span>",
                	"nomines"=>"<span style='background-color:#f0f;color:#fff;padding:6px'>N&Ograve;MINES</span>",
                	"efectiu.compres"=>"<span style='background-color:#04d;color:#fff;padding:6px'>EFECTIU/COMPRES/DIETES</span>",
			"neteja local"=>"<span style='background-color:#0ac;color:#fff;padding:6px'>NETEJA LOCAL</span>",
			"lloguers"=>"<span style='background-color:#bbb145;color:#fff;padding:6px'>LLOGUERS</span>",
                	"despesa proveidors"=>"<span style='background-color:#009;color:#fff;padding:6px'>PROVE&Iuml;DORS</span>",
                	"embargos_aeat"=>"<span style='background-color:#f00;color:#fff;padding:6px'>EMBARGOS AEAT</span>",
			"op.estranger"=>"<span style='background-color:#222;color:#fff;padding:6px'>TRANS.INTERNACIONAL</span>",
                	"transports"=>"<span style='background-color:#f90;color:#fff;padding:6px'>TRANSPORTS</span>",
                	"credit concedit"=>"<span style='background-color:#099;color:#fff;padding:6px'>CREDIT TARGETA</span>",
        		"despesa subministraments"=>"<span style='background-color:#099;color:#fff;padding:6px'>SUBMINISTRAMENTS</span>",
			"ajustaments"=>"<span style='background-color:#9a9;color:#fff;padding:6px'>PRESTECS / AJUSTAMENTS COMPTES</span>"
		));
//		$this->styleRow=array("field"=>"disable","styles"=>array("0"=>"color:#000", "1"=>"color:#aaa"));
		$this->styleRow=array("field"=>"validat","styles"=>array("0"=>"font-family:arial;font-weight:bold", "1"=>"font-family:arial;font-weight:normal"));

		$this->setStyle("validat","width:25px","be");
		$this->abbreviate("validat","&nbsp; V");
                $this->setStyle("disable","width:25px","be");
                $this->abbreviate("disable","&nbsp; D");

		$this->setComponent("status_icon", "validat", array("script"=>"validat","show_label"=>true));
                $this->setComponent("status_icon", "disable", array("script"=>"disable","show_label"=>true));
		if ($_GET['_']=="e") $this->setComponent("checklist","validat",array("1"=>""));
		if ($_GET['_']=="e") $this->setComponent("checklist","disable",array("1"=>""));
		//$this->setComponent("select","from_office",array(""=>"","002"=>"C. Santa Clara, 9-11 (GIRONA)","005"=>"C. Francesc Layret, 86-88 (BADALONA)","0018"=>"C. Josep de Zulueta, 12 (SEU D'URGELL)","0071"=>"Malgrat de Mar","0569"=>"Diagonal 621-629 T.i P14 (BARCELONA)","0442"=>"C. Prim 76 I Sant Bru 4-6 (BADALONA)","9736"=>"Avenida Diagonal, 621-629 T.i P7 (BARCELONA)","9792"=>"Avenida Diagonal, 621-629 T.i P15 (BARCELONA)","3264"=>"Santiago Rusiñol (BADALONA)","0936"=>"Gran Via de Les Corts Catalanes, 1104 (BARCELONA)","0565"=>"Avenida Diagonal, 621-629 T.i P.14 (BARCELONA)","9612"=>"Avenida Diagonal, 621-629 T.1 Pl.7 (BARCELONA)","3496"=>"C.CARME 44 (Barcelona)","5074"=>"C.CARME 44 (Barcelona)","8432"=>"C.CARME 44 (Barcelona)","10533"=>"C.CARME 44 (Barcelona)","4260"=>"AV.Paral.lel,58 (BARCELONA)","7306"=>"Drassanes (BARCELONA)","10612"=>"Drassanes (BARCELONA)","10627"=>"Drassanes (BARCELONA)"));
		$this->setValidator("import","float");
		$this->setComponent("money","import",array("show_euro"=>false));
		$this->setComponent("money","balance",array("show_euro"=>false));
	}

}

?>
