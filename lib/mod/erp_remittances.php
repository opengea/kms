<?

// ----------------------------------------------
// Class ERP Remittances for KMS
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class erp_remittances extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

	var $table	= "kms_erp_remittances";
	var $key	= "id";	

	var $fields = array("id", "creation_date", "status", "description","from_date", "to_date", "import", "records", "generated_date", "file");
	var $orderby = "creation_date";
	var $sortdir = "desc";
	//var $notedit = array("dr_folder","generated_date","import","records");

        /*=[ PERMISSIONS ]===========================================================*/

        var $can_view = false;
        var $can_edit = true;
        var $can_delete = true;
        var $can_add   = true;
        var $can_import = false;
        var $can_export = true;
        var $can_search = true;

       //*=[ CONSTRUCTOR ]===========================================================*/
        function erp_remittances($client_account,$user_account,$dm) {
                parent::mod($client_account,$user_account,$extranet);
        }

        function setup($client_account,$user_account,$dm) {

	$this->sum = array("import","records");
	$readonly = array("generated_date","import","records","file");
	$this->defvalue("file","");
	$this->defvalue("type","Q19");
	$this->defvalue("description","R-".date('d')."/".date('m')." de ".date('Y'));
	$uploadDate = date('Y-m-d');
	$this->defvalue("creation_date",$uploadDate);
	$this->defvalue("from_date",date('Y-m-1'));
	$this->defvalue("to_date",date('Y-m-20'));
	$this->defvalue("billing_date",date('Y-m-20'));
	$this->default_content_type = "invoice";
	$this->default_file = "invoices.php";
	$this->insert_label = "Nova remesa";

	/*=[ REGLES  ]========================================================*/

	$this->setComponent("select","status",array("pendent"=>"<font color=#ff0000>pendent</font>","generat"=>"<font color=#5fBf4f><b>generat</b></font>","enviat"=>"<font color=#00AA00><b>enviat</b></font>","anulat"=>"<font color=#999999><b>anulat</b></font>"));
	$this->setComponent("select","type",array("Q19"=>"Q19","Q32"=>"Q32"));
	
	$this->customOptions = Array();
	$this->customOptions[0] = Array ("label"=>_KMS_ERP_GENERATE_REMITTANCE,"url"=>"","ico"=>"generate.gif","params"=>"action=generate_remittance","target"=>"new");
	$this->action("generate_remittance","/usr/local/kms/mod/erp/remittances/generate.php");
	$this->setComponent("xcombo","payment_method",array("xtable"=>"kms_ecom_payment_methods","xkey"=>"id","xfield"=>"payment_name","readonly"=>true, "linkcreate"=>true, "linkedit"=>true, "sql"=>""));
//	$this->setComponent("file","file",array($this->kms_datapath."/files/erp/remittances","http://data.".$this->current_domain."/files/erp/remittances"));
/*	$this->setComponent("file","file",array($this->kms_datapath."/files/erp/remittances","files/erp/remittances"));*/
	$this->setComponent("file","file",array($this->kms_datapath."/files/erp/remittances","http://data.".$this->current_domain."/files/erp/remittances"));
	
	$this->onInsert = "onInsert";
	$this->onDelete = "onDelete";

	}

	function onInsert ($post,$id) {
		$select1="SELECT * FROM kms_erp_remittances where id={$id}";
		$result = mysqli_query($this->dblinks['client'],$select1);
		$r=mysqli_fetch_array($result);	
	        $select="SELECT * FROM kms_erp_invoices WHERE payment_date>='".$r['from_date']."' AND payment_date<='".$r['to_date']."' AND (status='pendent' or status='impagada') AND (payment_method='3' OR payment_method='9' OR payment_method='4' OR payment_method='5') AND total>0 AND sr_remittance=0";
//		echo $select;
		$result = mysqli_query($this->dblinks['client'],$select);
		$total=0;
		$n=0;
		while ($invoice = mysqli_fetch_array($result)) {
		        $total+=$invoice['total'];
		        $n++;
		}
		//	$total=str_replace(".",",",$total);
		setlocale(LC_MONETARY, 'es_ES');
		$total=money_format('%.2n',$total);
		$total=str_replace("EUR ","",$total);
		$update="UPDATE kms_erp_remittances SET import=\"{$total}\",records={$n},file='' WHERE id={$id}";
		$result = mysqli_query($this->dblinks['client'],$update);
	}
	function onDelete ($post,$id) {
		$select1="SELECT * FROM kms_erp_remittances where id={$id}";
                $result = mysqli_query($this->dblinks['client'],$select1);
                $r=mysqli_fetch_array($result);
		$update="UPDATE kms_erp_invoices SET status='pendent' WHERE payment_date>='".$r['from_date']."' AND payment_date<='".$r['to_date']."' AND status='cobrat' AND (payment_method='3' OR payment_method='9' OR payment_method='4' OR payment_method='5') AND total>0";
		$result = mysqli_query($this->dblinks['client'],$update);
	}
}
?>
