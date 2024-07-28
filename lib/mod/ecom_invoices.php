<?
// ----------------------------------------------
// Class ECOM Invoices for KMS
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class ecom_invoices extends mod {

	/*=[ CONFIGURACIO ]=====================================================*/
	
	var $table	= "kms_ecom_invoices";
	var $key	= "id";	
	var $fields 	= array("number", "ordernum", "status", "creation_date", "vr_cif", "client_id", "concept", "base", "total_tax", "total", "payment_method","payment_date", "check_sent");
	var $sum 	= array("base","total_tax","total");
	var $shorten 	= array("vr_payment_method","check_sent");
	var $export_f   = array("status", "number", "creation_date", "client_id", "concept", "base", "total_tax", "total", "payment_method", "payment_date");
	var $title 	= "Factures";
	var $orderby 	= "creation_date";
	var $sortdir 	= "desc";
	var $notedit 	= array("tax_values","total_values","sent_email","sent_date","status_terminator","bank_account_number","bank","check_sent","payment_method");
	var $excludeBrowser = array("payment_method");
	var $readonly 	= array("end_date");
        var $page_rows	= 100;
        var $page_links = 15;
        var $ts_format  = "m/d/Y h:i A";
        var $insert_label = _KMS_NEW_INVOICE;

        /*=[ PERMISOS ]===========================================================*/

        var $can_view   = true;
        var $can_edit   = true;
        var $can_delete = false;
	var $can_duplicate = false; //* no duplicar perque es lien els ids
        var $can_add    = true;
        var $can_import = true;
        var $can_export = true;
        var $can_search = true;
        var $can_print  = true;

       //*=[ CONSTRUCTOR ]===========================================================*/

       function ecom_invoices($client_account,$user_account,$dm) {
                parent::mod($client_account,$user_account,$extranet);
        }

       function setup($client_account,$user_account,$dm) {

	//$this->safedel("Display","N","Disable");

	//$this->xlist("partners","Business_Rid",array("Rid","Name","Description"));

	$this->defvalue("serie","A");
	$this->defvalue("tax_percent","21");
	$this->defvalue("payment_method","3");
	$this->abbreviate("vr_payment_method","MP");
	$this->abbreviate("payment_method","MP");
	$this->abbreviate("check_sent","Env");
	$this->abbreviate("creation_date","Data");
	$this->abbreviate("sr_remittance","Rem");
	$this->abbreviate("base","Base imp.");
	$this->humanize("vr_cif","CIF");	
	$LY=date('Y',strtotime("-1 year"));
	$this->humanize("YEAR(creation_date)","Any");
	$this->humanize("SUM(CASE when creation_date between '{$LY}-01-01' and '{$LY}-03-31' THEN base END)","Base T1");
	$this->humanize("SUM(CASE when creation_date between '{$LY}-04-01' and '{$LY}-06-31' THEN base END)","Base T2");
	$this->humanize("SUM(CASE when creation_date between '{$LY}-07-01' and '{$LY}-09-31' THEN base END)","Base T3");
	$this->humanize("SUM(CASE when creation_date between '{$LY}-10-01' and '{$LY}-12-31' THEN base END)","Base T4");
	$this->humanize("SUM(base)","BASE");
	$this->humanize("SUM(total_tax)","IVA");
	$this->humanize("SUM(total)","TOTAL");
	$uploadDate = date('Y-m-d');
	$this->defvalue("creation_date",$uploadDate);
	$this->defvalue("payment_date",$uploadDate);
	$this->defvalue("discount",'0');	
	$this->default_content_type = "invoice";
	$this->default_file = "invoices.php";
	//$this->validate("Email");
	//$this->validate("WWW");

	// -- events --
	$this->onFieldChange("base","b=parseFloat($('#base').val());d=parseFloat($('#discount').val());t=parseFloat($('#tax_percent').val());$('#total_tax').val(Math.round((((b-((b*d)/100))*t)/100)*100)/100);$('#total_tax').change()");
	$this->onFieldChange("total_tax","b=parseFloat($('#base').val());tt=parseFloat($('#total_tax').val());$('#total').val((b-((b*d)/100))+tt)");
	$this->onFieldChange("tax_percent","$('#base').change()");	
	$this->onFieldChange("discount","$('#base').change()");
	$this->onDocumentReady("if ($('#discount').val()=='') $('#discount').val(0)");	
	// ----------------- components -----------------

	// Combobox
	$this->setComponent("select","status",array("0"=>"<font color=#ff0000>pendent</font>","1"=>"<font color=#00AA00><b>cobrat</b></font>","2"=>"<font color=#5f3bef><b>remesa</b></font>","3"=>"<font color=#ff0000><b>retornat</b></font>","4"=>"<font color=#999999><b>anulat</b></font>","5"=>"<font color=#ff0000><b>impagada</b></font>"));
	$this->setComponent("select","type",array("ordinaria"=>"ordinaria","rectificativa"=>"rectificativa","abonament"=>"abonament"));

	$this->customOptions = Array();
//	$this->customOptions[0] = Array ("label"=>"_KMS_ERP_RPT_GENERATEPDF","url"=>"/kms/mod/erp/invoices/invoice.php?idfact=".array($this->fields['number'])."&pdf","ico"=>"pdf.gif","params"=>"action=view_pdf","target"=>"new","checkFunction"=>"");
        $this->customOptions[0] = Array ("label"=>"_KMS_ERP_RPT_GENERATEPDF","url"=>"","ico"=>"pdf.gif","params"=>"action=view_pdf","target"=>"new","checkFunction"=>"");
//	$this->action("view_pdf","/usr/local/kms/mod/erp/reports/report.php");
//	$this->action("get_pdf","/usr/local/kms/mod/erp/reports/report.php");
//	$this->action("email_invoice","/usr/local/kms/mod/erp/reports/report.php");
//	if ($_SERVER['REMOTE_ADDR']=='88.12.33.163') {
	$_GET['b']=$_GET['id'];
	$this->action("view_pdf","/usr/share/kms/lib/app/ecommerce/getinvoice.php"); ///usr/local/kms/mod/ecom/reports/report.php");
 //       $this->action("get_pdf","/usr/local/kms/mod/ecom/reports/report.php");
   //     $this->action("email_invoice","/usr/local/kms/mod/ecom/reports/report.php");
//	}
	$this->action("report_years","/usr/share/kms/lib/reports/report-facturacio-anual.php");
	$this->action("report_months","/usr/share/kms/lib/reports/report-facturacio-mensual.php");
	$this->action("report_mailings","/usr/share/kms/lib/reports/report-mailings.php");
	$this->nowrap("number");
        $this->nowrap("creation_date");
	
	// SELECT permet seleccionar multiples valors d'una llista de valors unics
	// si la llista es fixe, posar el segon parametre a true
	//$this->setComponent("uniselect","payment_method");
        $this->setComponent("xcombo","payment_method",array("xtable"=>"kms_ecom_payment_methods","xkey"=>"id","xfield"=>"payment_name","readonly"=>false, "linkcreate"=>true, "linkedit"=>true, "sql"=>""));
        $this->setComponent("xcombo","client_id",array("xtable"=>"kms_ent_clients","xkey"=>"id","xfield"=>"name","readonly"=>false,"linkcreate"=>true,"linkedit"=>true,"sql"=>""));
        $this->multixref("client_id", "id", "CONCAT(name,' ',surname)", "kms_ent_clients");
	$this->setComponent("file","attachment",array($this->kms_datapath."/files/invoices","files/invoices"));
	$this->setComponent("status_icon", "check_sent", array("script"=>"invoice_check_sent"));

	// editor wysiwyg
	//$this->setComponent("wysiwyg","concept");
	//$this->setComponent("wysiwyg","price_values");

        $xsql=array("xv_xtable"=>"kms_ent_clients", "xv_field"=>"client_id", "xv_xkey"=>"id", "xv_xfield"=>"cif");
        $this->xvField("vr_cif",array("sql"=>$xsql));
        $xsql=array("xv_xtable"=>"kms_ecom_payment_methods", "xv_field"=>"payment_method", "xv_xkey"=>"id", "xv_xfield"=>"payment_type");
        $this->xvField("vr_payment_method",array("sql"=>$xsql));

	//camps virtuals referenciats (columna virtual, taula ref, camp id taula, camp id taula ref, camp taula ref)
	//$this->xvField("vr_email","kms_ent_clients", "client_id", "id", "email");
	//$this->xvField("vr_facturation_address","kms_ent_clients", "client_id", "id", "facturation_address");
        $this->setValidator("number","alphanumeric");
        $this->setValidator("concept","notnull");
        $this->setValidator("base","float");	

	//$this->dbi->debug = true;
	$this->onUpdate="onUpdate";
	}

	function onUpdate($post,$id) {
		include "shared/db_links.php";
		$invoice=array("status"=>$post['status'],"concept"=>$post['concept'],"price_values"=>$post['price_values'],"base"=>$post['base'],"discount"=>$post['discount'],"total_tax"=>$post['total_tax'],"total"=>$post['total'],"payment_method"=>$post['payment_method'],"tax_values"=>$post['tax_values'],"total_values"=>$post['total_values'],"payment_date"=>$post['payment_date']);
		//$this->dbi->update_record("kms_isp_invoices",$invoice,"number like 'F-$id.%'",$dblink_cp,$dblink_erp);	
	}

}

?>
