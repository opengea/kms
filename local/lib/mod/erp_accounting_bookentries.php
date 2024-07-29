<?

// ----------------------------------------------
// Class ERP Finance for KMS
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class erp_accounting_bookentries extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

	var $table	= "kms_erp_accounting_bookentries";
	var $key	= "id";	
	var $fields 	= array("creation_date","exercici","status","entry_id","account_id", "description", "debit","credit","entry_type");
	var $orderby 	= "creation_date";
//	var $groupby	= "entry_id";
	var $sortdir 	= "desc";

        /*=[ PERMISSIONS ]===========================================================*/

        var $can_view 	= true;
        var $can_edit 	= true;
        var $can_delete = true;
        var $can_add  	= true;
        var $can_import = false;
        var $can_export = true;
        var $can_search = true;

       //*=[ CONSTRUCTOR ]===========================================================*/
        function erp_accounting_bookentries($client_account,$user_account,$dm) {
                parent::mod($client_account,$user_account,$extranet);
        }

        function setup($client_account,$user_account,$dm) {

		$this->defvalue("creation_date",date('Y-m-d H:i:s'));
		$this->defvalue("credit","0");
		$this->defvalue("debit","0");
		$this->defvalue("balance","0");
		$this->defvalue("exercici",date('Y'));
		$this->defvalue("acc_plan",1);
		$this->setComponent("xcombo","account_id",array("xtable"=>"kms_erp_accounting","xkey"=>"account","xfield"=>"CONCAT(account,' / ',description)","readonly"=>false,"linkcreate"=>false,"linkedit"=>true,"sql"=>"select account,CONCAT(account,': ',acc_group,' ',acc_subgroup,' - ',description) from kms_erp_accounting","orderby"=>"account"));
		$this->setComponent("xcombo","acc_plan",array("xtable"=>"kms_erp_accounting_plans","xkey"=>"id","xfield"=>"description","readonly"=>false,"linkcreate"=>false,"linkedit"=>true,"sql"=>""));
//		$this->defvalue("status",0);
//		$this->setComponent("xcombo","status",array("0"=>"esborrany","1"=>"assentat"));
		$this->sum = array("credit","debit","balance");
		$this->folder = $_GET['folder'];
		$this->setStyle("entry_id","width:100px","be");
		$this->setStyle("debit","width:100px","be");$this->concatField("debit");
                $this->setStyle("credit","width:100px","be");$this->concatField("credit");
                $this->setStyle("balance","width:100px","be");
		$this->setValidator("debit","float");
		$this->setValidator("credit","float");
		$this->setValidator("balance","float");

		//$notedit = array("type");
		$this->defvalue("content_type","billing");
			$this->default_content_type = "billing";
		$this->default_php = "billing";

		//date_default_timezone_set('UTC');
		//$uploadDate = date('D j M Y');
		$uploadDate = date('Y-m-d');
		$this->defvalue("date",$uploadDate);
		$this->insert_label = "Nou assentament";
		$this->setComponent("wysiwyg","notes",array("type"=>"full"));
		$this->setComponent("select","entry_type",array("0"=>"apertura","1"=>"operatiu","2"=>"ajustament","3"=>"regulaci&oacute;","4"=>"tancament"));
		$this->setComponent("select","status",array("0"=>"pendent","1"=>"assentat"));
		// SELECT permet seleccionar multiples valors d'una llista de valors unics
		// si la llista es fize, posar el segon parametre a true
		$this->setComponent("uniselect","family");
		$this->setComponent("uniselect","entity");


		// CHECKBOX
		//$this->setComponent("checklist","Decoration",array("E"=>"Embroiderable","I"=>"Inscribeable"));

		// uploads
		$this->setComponent("file","attachment",array($this->kms_datapath."/files/accounting_bookentries","files/accounting_bookentries",false));
		$this->customButtons=Array();
                $this->customButtons[0] = Array ("label"=>"Cercar desajustaments","url"=>"","ico"=>"pdf.gif","params"=>"action=search_errors","target"=>"_self","checkFunction"=>"","class"=>"highlight");
                $this->action("search_errors","/usr/local/kms/mod/erp/search_errors.php");
                
		$this->styleRow=array("field"=>"","rule"=>"styleRowRule","styles"=>array("1"=>"color:#20827a","2"=>"color:#206882","3"=>"color:#618220","4"=>"color:#822081","5"=>"color:#2d64c7","6"=>"color:#c42b2b","7"=>"color:#037619","8"=>"color:#c10466","9"=>"color:#019a98")); //modificar tambe erp_finance_accounting

	}

	function styleRowRule($record) {
		return substr($record->account_id,0,1);
	}

}
?>
