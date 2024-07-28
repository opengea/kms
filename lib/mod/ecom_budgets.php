<?

// ----------------------------------------------
// Class Ecommerce Budgets for KMS 
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class ecom_budgets extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

	var $table	= "kms_ecom_budgets";
	var $key	= "id";	
	var $fields = array("id", "creation_date", "status", "sr_client", "description", "import", "payment_status", "attachment");
	var $hidden=array("number","payment_method");
	var $orderby = "creation_date";
	var $sortdir = "desc";

        /*=[ PERMISSIONS ]===========================================================*/

	var $can_edit = true;
	var $can_delete = true;
	var $can_add = true;
	var $import = true;
	var $export = true;
	var $search = true;
	var $can_duplicate =true;

       //*=[ CONSTRUCTOR ]===========================================================*/

        function sys_views($client_account,$user_account,$dm) {
                parent::mod($client_account,$user_account,$extranet);
        }

        function setup($client_account,$user_account,$dm) {

		$this->defvalue("status","pendent");
		$this->defvalue("creation_date",date('Y-m-d H:i:s'));
		$this->defvalue("end_date",date('Y-m-d', strtotime("+30 days")));
		$this->defvalue("satisfaction","no avaluat");
		$this->default_content_type = "budgets";
		$this->default_php = "budgets.php";
		$this->insert_label = "Nou pressupost";
		$this->setComponent("select","status",array("1pendent"=>"<font color=#ff0000>pendent</font>","2espera"=>"<font color=#FFBf2a><b>a l'espera</b></font>","3aprovat"=>"<font color=#00cc00><b>aprovat</b></font>", "6rebutjat"=>"rebutjat","5no_response"=>"sense resposta","4congelat"=>"<font color=#cccccc>congelat</font>"));
		$this->setComponent("select","assigned",array("JB"=>"JB","SB"=>"SB","JE"=>"JE","JB,JE"=>"JB,JE", "SB,JB"=>"SB,JB", "SB,JE"=>"SB,JE"));
		$this->setComponent("select","priority",array("baixa"=>"<font color=#666666>baixa</font>","normal"=>"<font color=#0000ff>normal</font>","active"=>"<font color=#ff3300>alta</alta>","critica"=>"<font color=#ff0000><b>critica</b></font>"));
		$this->setComponent("file", "attachment",array($this->kms_datapath."/files/budgets","http://data.intergrid.cat/files/budgets"));
		$this->setComponent("xcombo","sr_client",array("xtable"=>"kms_ent_contacts","xkey"=>"id","xfield"=>"name","readonly"=>false,"linkcreate"=>true,"linkedit"=>true,"sql"=>""));
		$this->customOptions = Array();
	        $this->customOptions[0] = Array ("label"=>_KMS_ERP_RPT_GENERATEPDF,"url"=>"","ico"=>"pdf.gif","params"=>"action=view_pdf","target"=>"new","checkFunction"=>"");
        	$this->action("view_pdf","/usr/local/kms/mod/erp/reports/budgets/report.php");
		$this->action("get_pdf","/usr/local/kms/mod/erp/reports/budgets/report.php");
	}

}
?>

