<?

// ----------------------------------------------
// Class ERP Contracts for KMS
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class erp_contracts_providers extends mod {
	/*=[ CONFIGURATION ]=====================================================*/
	var $table	= "kms_erp_contracts_providers";
	var $key	= "id";	
	var $fields 	= array("id", "creation_date", "status", "auto_renov", "sr_provider", "family", "description", "price", "end_date", "billing_period","payment_method");
	var $sum 	= array("price");

	var $title 	= "Contractes";
	var $orderby 	= "initial_date";
	var $sortdir 	= "desc";
	var $notedit 	= array("dr_folder");
//	var $readonly   = array("content_type");   // compte: si es marca readonly no s'inserta
	var $default_content_type = "contracts";
        var $ts_format  = "XXm/d/Y h:i A";
        var $insert_label = "Nou contracte"; 
        var $customOptions = Array();
        var $iam = "erp_contracts_providers";
	/*=[ PERMISSIONS ]===========================================================*/

	var $can_view 	= true;
	var $can_edit 	= true;
	var $can_delete = true;
	var $can_add   	= true;
	var $can_import = false;
	var $can_export = true;
	var $can_search = true;
        var $can_print  = true;
	var $can_duplicate =true;

       //*=[ CONSTRUCTOR ]===========================================================*/
        function erp_contracts_providers($provider_account,$dm) {
        	parent::mod($provider_account,$extranet);
	}

	function setup($provider_account,$dm) {

        $this->folder     = $_GET['dr_folder'];
	$this->page_rows = 100;
        $this->action("make_invoice","/usr/local/kms/mod/erp/contracts/make_invoice.php");

	$this->humanize("price_discount_pc","Descompte (%)");
	$this->humanize("sr_provider","Entitat");
	$this->abbreviate("price_discount_pc","-%");
	$this->abbreviate("auto_renov","Ren");
	$this->defvalue("status","active");
	$this->defvalue("content_type","contracts");
	$this->defvalue("venciment","10");
	$this->defvalue("billing_period","Mensual");
	$this->defvalue("auto_renov","1");
	$this->defvalue("payment_method",3);
	$uploadDate = date('Y-m-d');
	$this->defvalue("creation_date",$uploadDate);
	$this->defvalue("initial_date",$uploadDate);
	$this->defvalue("end_date",$uploadDate);
	//Encriptacio MD5 un sentit per passwords o MCRYPT per targetes de credit (two-way encryption)
	//setComponent("cipher","Password","MD5");
	//setComponent("cipher","CardNum","MD5");
	$this->setComponent("xref","Type_Rid",array("Rid","Type","business_types"));
	//event("status", "=", "xxx", "function", "params", "retorn")
	//ordreform (array("camp1",6,0)
	//setComponent("select","status",array("active"=>"<font color=#009900>actiu</font>","stopped"=>"<font color=#ff0000>aturat</font>","development"=>"<font color=#ff00ff>en desenvolupament</font>"));
	$this->setComponent("select","status",array("active"=>"<font color=#00AA00><b>actiu</b></font>","anulat"=>"<font color=#999999>anulat</b>","terminator"=>"<b><font color=#ff0000>terminator</b></b>","finalitzat"=>"<b><font color=#8A084B>finalitzat</b></font>"));
	$this->setComponent("select","max_space",array("524288000"=>"500 Mb","1073741824"=>"1 Gb","3221225472"=>"3 Gb","5242880000"=>"5 Gb","10737418240"=>"10 Gb","21474836480"=>"20 Gb","31457280000"=>"30 Gb","42949672960"=>"40 Gb","53687091200"=>"50 Gb","107374182400"=>"100 Gb","214748364800"=>"200 Gb","322122547200"=>"300 Gb","536870912000"=>"500 Gb","-1"=>"Unlimited"));
	$this->setComponent("select","max_transfer",array("1073741824"=>"1 Gb","3221225472"=>"3 Gb","5242880000"=>"5 Gb","10737418240"=>"10 Gb","31457280000"=>"30 Gb","53687091200"=>"50 Gb","107374182400"=>"100 Gb","214748364800"=>"200 Gb","536870912000"=>"500 Gb","-1"=>"Unlimited"));
	$this->setComponent("file","attachment",array('/var/www/vhosts/intergrid.cat/subdomains/data/httpdocs/files/contracts/','http://data.intergrid.cat/files/contracts'));
	$this->setComponent("uniselect","billing_period");
	$this->setComponent("uniselect","family");
	$this->setComponent("uniselect","bill_period_temp");
	$this->setComponent("select","auto_renov",array("1"=>"<font color=#00AA00>SI</font>","0"=>"<font color=#ff0000>NO</font>"));
	//$this->dbi->debug = true;
	$this->setComponent("xcombo","payment_method",array("xtable"=>"kms_ecom_payment_methods","xkey"=>"id","xfield"=>"payment_name","readonly"=>false, "linkcreate"=>true, "linkedit"=>true, "sql"=>""));
	$this->setComponent("xcombo","sr_provider",array("xtable"=>"kms_ent_contacts","xkey"=>"id","xfield"=>"name","readonly"=>false,"linkcreate"=>true,"linkedit"=>true,"sql"=>""));

	}

	function getProvider($service) {
	$provider=array();
		//if ($service=="DOMAIN") $provider=array("id"=>254,"payment_method"=>12); // InternetX Visa
		if ($service=="DOMAIN") $provider=array("id"=>747,"payment_method"=>1); //OpenProvider Transferencia
		// else if ($service=="HOSTING") return 
		return $provider;
	}

	function add($contract) {
                $provider=$this->getProvider($contract['family']);
//              $payment_method=12; // Metode de pagament a InternetX : Targeta de credit  
	 	$payment_method=1; // Metode de pagament a OpenProvider : Transferencia
		$service=$this->dbi->get_record("select * from kms_ecom_services where id=".$provider['sr_contract']);	
                $contract_prov=array("creation_date"=>date('Y-m-d H:i:s'),"status"=>"active","sr_provider"=>$provider['id'],"description"=>$contract['description'],"family"=>$contract['family'],"price"=>$service['cost_price'],"billing_period"=>$contract['billing_period'],"auto_renov"=>$contract['auto_renov'],"initial_date"=>$contract['creation_date'],"end_date"=>$contract['end_date'],"payment_method"=>$provider['payment_method']);
//print_r($contract_prov);        
        	$contract_id=$this->dbi->insert_record("kms_erp_contracts_providers",$contract_prov);
		return $contract_id;
	}

} // class

?>
