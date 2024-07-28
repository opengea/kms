<?
// ----------------------------------------------
// Class ERP Invoices for KMS
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class erp_invoices_providers extends mod {

	/*=[ CONFIGURACIO ]=====================================================*/
	
	var $table	= "kms_erp_invoices_providers";
	var $key	= "id";	
	var $fields 	= array("id", "validat", "creation_date","status","account_id","number","sr_provider", "concept1", "base", "total_tax", "total_irpf","total","allocate_cost_to","file");
	var $sum 	= array("base","total_tax","total","total_irpf");
	var $title 	= "Factures";
	var $orderby 	= "creation_date";
	var $sortdir 	= "desc";
	var $notedit 	= array("dr_folder","tax_values","total_values","vr_payment_method");
	var $excludeBrowser = array("payment_method");
	var $readonly 	= array("end_date","validat");
        var $page_rows	= 50;
        var $page_links = 10;
        var $ts_format  = "m/d/Y h:i A";
        var $insert_label = _KMS_NEW_INVOICE;

        /*=[ PERMISOS ]===========================================================*/

        var $can_view   = false;
        var $can_edit   = true;
        var $can_delete = true;
        var $can_add    = true;
        var $can_import = true;
	var $can_duplicate = true;
        var $can_export = true;
        var $can_search = true;
        var $can_print  = true;

       //*=[ CONSTRUCTOR ]===========================================================*/

       function erp_invoices_providers($client_account,$user_account,$dm) {
                parent::mod($client_account,$user_account,$extranet);
        }

       function setup($client_account,$user_account,$dm) {

	//validat
        $this->styleRow=array("field"=>"validat","styles"=>array("0"=>"font-family:arial;font-weight:bold", "1"=>"font-family:arial;font-weight:normal"));
        $this->setStyle("validat","width:25px","be");
        $this->abbreviate("validat","&nbsp; V");
        $this->setComponent("status_icon", "validat", array("script"=>"validat","show_label"=>true));
        if ($_GET['_']=="e") {
		$this->setComponent("checklist","validat",array("1"=>""));
		include "shared/db_links.php";
                $invoice=$this->dbi->get_record("SELECT * from kms_erp_invoices_providers WHERE id=".$_GET['id']);
		if ($invoice['validat']==1||$invoice['acc_status']!=0) { $this->can_delete=false; $_GET['_action']=""; } // no es poden borrar factures comptabilitzades
	
	}
	//$this->safedel("Display","N","Disable");
	$this->setComponent("file","file",array($this->kms_datapath."files/invoices_providers","http://data.".$this->current_domain."/files/invoices_providers"));

//$this->xlist("partners","Business_Rid",array("Rid","Name","Description"));

	$this->defvalue("tax_percent1","21");
	$this->defvalue("tax_percent2","10");
	$this->defvalue("tax_percent3","4");
	$this->defvalue("subtotal1","0");$this->defvalue("subtotal2","0");$this->defvalue("subtotal3","0");$this->defvalue("subtotal4","0");
	$this->defvalue("base1","0");$this->defvalue("base2","0");$this->defvalue("base3","0");$this->defvalue("base4","0");
	$this->defvalue("tax1","0");$this->defvalue("tax2","0");$this->defvalue("tax3","0");$this->defvalue("tax4","0");
	$this->defvalue("tax_percent1","0");$this->defvalue("tax_percent2","0");$this->defvalue("tax_percent3","0");$this->defvalue("tax_percent4","0");
	$this->defvalue("creation_date",date('Y-m-d'));
	$this->defvalue("payment_date",date('Y-m-d'));
        $this->setStyle("base","width:90px","e");
        $this->setStyle("total_tax","width:90px","e");
        $this->setStyle("total","width:90px","e");
	$this->setStyle("total_irpf","width:90px","e");
	$this->setStyle("concept1","width:300px;","e");	$this->setStyle("base1","width:90px","e");$this->setStyle("tax_percent1","width:90px","e");$this->setStyle("tax1","width:90px","e");$this->setStyle("subtotal1","width:90px","e");
	$this->setStyle("concept2","width:300px;","e");$this->setStyle("base2","width:90px","e");$this->setStyle("tax_percent2","width:90px","e");$this->setStyle("tax2","width:90px","e");$this->setStyle("subtotal2","width:90px","e");
	$this->setStyle("concept3","width:300px;","e");$this->setStyle("base3","width:90px","e");
	$this->setStyle("tax_percent3","width:90px","e");$this->setStyle("tax3","width:90px","e");$this->setStyle("subtotal3","width:90px","e");
	$this->setStyle("concept4","width:300px;","e");$this->setStyle("base4","width:90px","e");
	$this->setStyle("tax_percent4","width:90px","e");$this->setStyle("tax4","width:90px","e");$this->setStyle("subtotal4","width:90px","e");
	$this->defvalue("status","cobrat");
	$this->defvalue("serie","A");
	$this->defvalue("payment_method","3");
	$this->abbreviate("vr_payment_method","MP");
	
	$this->abbreviate("payment_method","MP");
	$this->abbreviate("creation_date","Data");
	$this->abbreviate("base","Base imp.");

        $this->setComponent("money","total",array("show_euro"=>false));
        $this->setComponent("money","total_tax",array("show_euro"=>false));
        $this->setComponent("money","base",array("show_euro"=>false));
	$this->setComponent("money","total_irpf",array("show_euro"=>false));
//	$this->humanize("vr_cif","CIF");
	 $this->humanize("total_irpf","Retenci&oacute; IRPF");
	$this->humanize("total_tax","Total IVA");	
	$this->humanize("creation_date","Data");
	$this->humanize("concept1","Concepte 1");$this->humanize("concept2","Concepte 2");$this->humanize("concept3","Concepte 3");$this->humanize("concept4","Concepte 4");
	$this->humanize("base1","Base (&euro;)");$this->humanize("base2","Base (&euro;)");$this->humanize("base3","Base (&euro;)");$this->humanize("base4","Base (&euro;)");
	$this->humanize("tax_percent1","% IVA");$this->humanize("tax_percent2","% IVA");$this->humanize("tax_percent3","% IVA");$this->humanize("tax_percent4","% IVA");
	$this->humanize("tax1","IVA (&euro;)");$this->humanize("tax2","IVA (&euro;)");$this->humanize("tax3","IVA (&euro;)");$this->humanize("tax4","IVA (&euro;)");
	$this->humanize("subtotal1","Subtotal (&euro;)");$this->humanize("subtotal2","Subtotal (&euro;)");$this->humanize("subtotal3","Subtotal (&euro;)");$this->humanize("subtotal4","Subtotal (&euro;)");
	//date_default_timezone_set('UTC');
	//$uploadDate = date('D j M Y');
	
	$this->default_content_type = "invoice";
	$this->default_file = "invoices.php";
	//$this->validate("Email");
	//$this->validate("WWW");
	
	// ----------------- components -----------------

	// Combobox
	$this->setComponent("select","status",array("pendent"=>"<font color=#ff0000>pendent</font>","cobrat"=>"<font color=#00AA00><b>pagat</b></font>","retornat"=>"<font color=#ff0000><b>retornat</b></font>"));
	$this->setComponent("select","type",array("provider_invoice"=>"FACTURA-P","creditor_invoice"=>"FACTURA-C","Tiquet"=>"TIQUET","Altres"=>"Altres"));

	$this->custom_button1 = "Fitxa de prove&iuml;dor";
	$this->custom_button2 = "Contracte";
	$this->custom_button3 = "Obtenir PDF";
	//$this->custom_button5 = "";
	$this->custom_action1 = "users.php?_=e";
	$this->custom_action2 = "contracts.php?queryfield=sr_provider";
	//$this->custom_action3 = "pdfgenerator.php?model=22&data=";
	$this->custom_action3 = "kms/mod/erp/invoices/invoice.php?idfact=".array($this->fields['number'])."&pdf";


	$this->nowrap("number");
	$this->nowrap("creation_date");
	$this->action("view_pdf","/usr/local/kms/mod/erp/reports/report.php");
	$this->action("get_pdf","/usr/local/kms/mod/erp/reports/report.php");
	$this->action("report_model_303","/usr/share/kms/lib/reports/report_model_303.php");
	$this->action("report_model_390","/usr/share/kms/lib/reports/report_model_390.php");
	$this->humanize("sr_provider","Entitat");
	$this->humanize("payment_date","Data de pagament");	
	$this->humanize("bank_account_number","N&uacute;mero de compte de pagament");
	$this->humanize("payment_method","M&egrave;tode de pagament");
	$this->humanize("base","Total base imposable");
	// SELECT permet seleccionar multiples valors d'una llista de valors unics
	// si la llista es fixe, posar el segon parametre a true
	//$this->setComponent("uniselect","payment_method");
	$this->setComponent("xcombo","bank_account_number",array("xtable"=>"kms_erp_finance_banks_accounts","xkey"=>"id","xfield"=>"account","readonly"=>false, "linkcreate"=>true, "linkedit"=>true, "sql"=>""));
        $this->setComponent("xcombo","payment_method",array("xtable"=>"kms_ecom_payment_methods","xkey"=>"id","xfield"=>"payment_name","readonly"=>false, "linkcreate"=>true, "linkedit"=>true, "sql"=>""));
        $this->setComponent("xcombo","sr_provider",array("xtable"=>"kms_ent_contacts","xkey"=>"id","xfield"=>"name","readonly"=>false,"linkcreate"=>true,"linkedit"=>true,"sql"=>"select id,name from kms_ent_contacts where id IN (select contact_id from kms_ent_providers)"));
	$this->setComponent("xcombo","account_id",array("xtable"=>"kms_erp_accounting","xkey"=>"id","xfield"=>"description","readonly"=>false,"linkcreate"=>false,"linkedit"=>false,"sql"=>"select id,CONCAT(account,' ',description,' (',acc_subgroup,')') as account from kms_erp_accounting WHERE account>=600 and account<700 and status='1'"));
	$this->setComponent("xcombo","allocate_cost_to",array("xtable"=>"kms_ent_staff","xkey"=>"id","xfield"=>"fullname","readonly"=>false,"linkcreate"=>false,"linkedit"=>false,"sql"=>""));
	$this->humanize("allocate_cost_to","Assignar cost a");
	$this->addComment("allocate_cost_to","Només si ho ha pagat l'empresa!");
	

        $this->multixref("sr_provider", "id", "name", "kms_ent_contacts");
	$this->setComponent("file","attachment",array($this->kms_datapath."/files/invoices","files/invoices"));

	// editor wysiwyg
	//$this->setComponent("wysiwyg","price_values");

//	$xsql=array("xv_xtable"=>"kms_ent_contacts", "xv_field"=>"sr_client", "xv_xkey"=>"id", "xv_xfield"=>"cif");
//        $this->xvField("vr_cif",array("sql"=>$xsql));
        $xsql=array("xv_xtable"=>"kms_ecom_payment_methods", "xv_field"=>"payment_method", "xv_xkey"=>"id", "xv_xfield"=>"payment_type");
        $this->xvField("vr_payment_method",array("sql"=>$xsql));

	//$this->xvField("vr_","kms_whe

	//camps virtuals referenciats (columna virtual, taula ref, camp id taula, camp id taula ref, camp taula ref)
	//$this->xvField("vr_email","kms_ent_contacts", "sr_provider", "id", "email");
	//$this->xvField("vr_facturation_address","kms_ent_contacts", "sr_provider", "id", "facturation_address");
	
	//$this->dbi->debug = true;
 // -- events --
        $this->onDocumentReady("if ($('#discount').val()=='') $('#discount').val(0)");
	// --- sub bases
	for ($i=1;$i<=4;$i++) {
	$this->concatField("concept{$i}");$this->concatField("base{$i}"); $this->concatField("tax_percent{$i}"); $this->concatField("tax{$i}");
	$this->onFieldChange("base{$i}","b=parseFloat($('#base{$i}').val());t=parseFloat($('#tax_percent{$i}').val());if (!isNaN(b)&&!isNaN(t)) { d=0;$('#tax{$i}').val(Math.round((((b-((b*d)/100))*t)/100)*100)/100);$('#tax{$i}').change()}");
        $this->onFieldChange("tax{$i}","b=parseFloat($('#base{$i}').val());tt=parseFloat($('#tax{$i}').val());$('#subtotal{$i}').val(Math.round(((b-((b*d)/100))+tt)*100)/100);$('#subtotal{$i}').change();");
        $this->onFieldChange("tax_percent{$i}","t=parseFloat($('#tax_percent{$i}').val()); if (!isNaN(t)) $('#base{$i}').change()");
        $this->onFieldChange("subtotal{$i}","t=parseFloat($('#subtotal{$i}').val());tp=parseFloat($('#tax_percent{$i}').val());if (!isNaN(t)&&!isNaN(tp)) { $('#base{$i}').val(Math.round((t/((tp/100)+1))*100)/100);$('#tax{$i}').val(Math.round((parseFloat($('#base{$i}').val())*tp/100)*100)/100)};t=parseFloat($('#subtotal1').val())+parseFloat($('#subtotal2').val())+parseFloat($('#subtotal3').val())+parseFloat($('#subtotal4').val());t=Math.round(t*100)/100;$('#total').val(t);$('#total').change()");
	}
	// --- totals
//	$this->onFieldChange("base","b=parseFloat($('#base').val());t=parseFloat($('#tax_percent').val());if (!isNaN(b)&&!isNaN(t)) { d=0;$('#total_tax').val(Math.round((((b-((b*d)/100))*t)/100)*100)/100);$('#total_tax').change()}");
 //       $this->onFieldChange("total_tax","b=parseFloat($('#base').val());tt=parseFloat($('#total_tax').val());$('#total').val(Math.round(((b-((b*d)/100))+tt)*100)/100)");
//        $this->onFieldChange("tax_percent","t=parseFloat($('#tax_percent').val()); if (!isNaN(t)) $('#base').change()");
        $this->onFieldChange("total","$('#total_tax').val(parseFloat($('#tax1').val())+parseFloat($('#tax2').val())+parseFloat($('#tax3').val())+parseFloat($('#tax4').val()));$('#base').val(parseFloat($('#base1').val())+parseFloat($('#base2').val())+parseFloat($('#base3').val())+parseFloat($('#base4').val()));");
	


	}

}

?>
