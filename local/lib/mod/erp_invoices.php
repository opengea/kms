<?
// ----------------------------------------------
// Class ERP Invoices for KMS
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class erp_invoices extends mod {

	/*=[ CONFIGURACIO ]=====================================================*/
	
	var $table	= "kms_erp_invoices";
	var $key	= "id";	
	var $fields 	= array("number", "creation_date", "vr_cif", "sr_client", "concept", "base", "discount", "total_tax", "total", "bank_charges",  "status", "payment_method","vr_payment_method", "sr_remittance", "payment_date", "check_sent","cancelled_invoice_id","valid_cancellation","paid_on_date");
	var $sum 	= array("base","total_tax","total","bank_charges");
	var $shorten 	= array("vr_payment_method","check_sent");
	var $export_f   = array("status", "number", "creation_date", "sr_client", "concept", "base", "total_tax", "total", "payment_method", "payment_date");
	var $title 	= "Factures";
	var $orderby 	= "number";
	var $sortdir 	= "desc";
	var $notedit 	= array("tax_values","total_values","sent_email","sent_date","status_terminator","bank_account_number","bank","vr_payment_method","vr_cif");
	var $hidden	= array("cancelled_invoice_id","valid_cancellation");
	var $excludeBrowser = array("payment_method","cancelled_invoice_id","valid_cancellation");
	var $readonly 	= array("end_date","acc_status");
        var $page_rows	= 50;
        var $page_links = 10;
        var $ts_format  = "m/d/Y h:i A";
        var $insert_label = _KMS_NEW_INVOICE;

        /*=[ PERMISOS ]===========================================================*/

        var $can_view   = false;
        var $can_edit   = true;
        var $can_delete = false;
	var $can_duplicate = false; //* no duplicar perque es lien els ids
        var $can_add    = true;
        var $can_import = true;
        var $can_export = true;
        var $can_search = true;
        var $can_print  = true;

       //*=[ CONSTRUCTOR ]===========================================================*/

       function erp_invoices($client_account,$user_account,$dm) {
                parent::mod($client_account,$user_account,$extranet);
        }

       function setup($client_account,$user_account,$dm) {

	//$this->safedel("Display","N","Disable");

	//$this->xlist("partners","Business_Rid",array("Rid","Name","Description"));
	$this->setStyle("creation_date","max-width:70px","b");
        $this->setStyle("sr_remittance","width:70px","e");

	$this->defvalue("status","active");
	$this->defvalue("serie","A");
	$this->defvalue("tax_percent","21");
	$this->defvalue("payment_method","3");
	$this->abbreviate("vr_payment_method","MP");
	$this->abbreviate("payment_method","MP");
	$this->abbreviate("check_sent","Env");
	$this->abbreviate("creation_date","Data");
	$this->abbreviate("sr_remittance","Rem");
	$this->abbreviate("bank_charges","Recàrrec");
	$this->abbreviate("base","Base imp.");
	$this->humanize("vr_cif","CIF");	
	$this->humanize("pre_client","Prefix per factura");
	$this->humanize("post_client","Sufix per factura");
	$this->humanize("paid_on_date","Pagat el dia");
	$LY=date('Y',strtotime("-1 year"));
	$this->humanize("YEAR(creation_date)","Any");
	$this->humanize("SUM(CASE when creation_date between '{$LY}-01-01' and '{$LY}-03-31' THEN base END)","Base T1");
	$this->humanize("SUM(CASE when creation_date between '{$LY}-04-01' and '{$LY}-06-31' THEN base END)","Base T2");
	$this->humanize("SUM(CASE when creation_date between '{$LY}-07-01' and '{$LY}-09-31' THEN base END)","Base T3");
	$this->humanize("SUM(CASE when creation_date between '{$LY}-10-01' and '{$LY}-12-31' THEN base END)","Base T4");
	$this->humanize("SUM(base)","BASE");
	$this->humanize("SUM(total_tax)","IVA");
	$this->humanize("SUM(total)","TOTAL");
	$this->humanize("proforma","Proforma");
//	$this->humanize("payment_date","Payment date");
	$uploadDate = date('Y-m-d');
	$this->defvalue("creation_date",$uploadDate);
//	$this->defvalue("payment_date",$uploadDate);
	$this->defvalue("discount",'0');	
	$this->default_content_type = "invoice";
	$this->default_file = "invoices.php";
	//$this->validate("Email");
	//$this->validate("WWW");

	// ----------------- components -----------------

	// Combobox
	if ($_GET['_']!="e") $this->setComponent("select","status",array("processing"=>"<font color=#ff7700>"._KMS_GL_PROCESSING."</font>","pendent"=>"<font color=#ff0000>"._KMS_GL_PENDING."</font>","remesa"=>"<font color=#5f3bef><b>"._KMS_ERP_REMESA."</b></font>","cobrat"=>"<font color=#00AA00><b>"._KMS_GL_STATUS_PAID."</b></font>","abonada"=>"abonada","retornat"=>"<font color=#ff0000><b>"._KMS_ERP_STATUS_RETORNAT."</b></font>","anulat"=>"<font color=#999999><b>"._KMS_GL_STATUS_ANULAT."</b></font>","impagada"=>"<font color=#ff0000><b>"._KMS_GL_STATUS_IMPAGADA."</b></font>","anulada-impagada"=>"<font color=#999999><b>"._KMS_GL_STATUS_ANULAT." per "._KMS_GL_STATUS_IMPAGADA."</b></font>","pausa"=>"<font style='background-color:#9f0'> PAUSA </font>","pagada-embargo"=>"<font color=#00AA00><b>Pagada embargo</b></font>"));
	$this->setComponent("select","currency",array("EUR"=>"EUR","USD"=>"USD"));
	$this->setComponent("select","acc_status",array("0"=>"No","1"=>"S&iacute;"));
	$this->setComponent("select","type",array("ordinaria"=>"ordinaria","rectificativa"=>"rectificativa","abonament"=>"abonament"));
	$this->setComponent("checklist","valid_cancellation",array("1"=>""));
	$this->setComponent("checklist","proforma",array("1"=>""));
	$this->customOptions = Array();
        $this->customOptions[0] = Array ("label"=>_KMS_ERP_RPT_GENERATEPDF,"url"=>"","ico"=>"pdf.gif","params"=>"action=view_pdf","target"=>"new","checkFunction"=>"");
	$this->action("view_pdf","/usr/local/kms/mod/erp/reports/report.php");
	$this->action("get_pdf","/usr/local/kms/mod/erp/reports/report.php");
	$this->action("email_invoice","/usr/local/kms/mod/erp/reports/report.php");
	$this->action("report_years","/usr/share/kms/lib/reports/rpt_invoices_compare_years.php");
	$this->action("report_months","/usr/share/kms/lib/reports/rpt_invoices_compare_months.php");
	$this->action("report_mailings","/usr/share/kms/lib/reports/report-mailings.php");
        $this->action("rpt_invoices_year","/usr/share/kms/lib/reports/rpt_invoices_year.php");
	$this->action("rpt_model_347","/usr/share/kms/lib/reports/rpt_model_347.php");
	$this->action("rpt_model_349","/usr/share/kms/lib/reports/rpt_model_349.php");
	$this->action("rpt_top_clients","/usr/share/kms/lib/reports/rpt_top_clients.php");
	$this->nowrap("number");
        $this->nowrap("creation_date");
		
	// SELECT permet seleccionar multiples valors d'una llista de valors unics
	// si la llista es fixe, posar el segon parametre a true
	//$this->setComponent("uniselect","payment_method");
	$this->setComponent("uniselect","logo");
        $this->setComponent("xcombo","payment_method",array("xtable"=>"kms_ecom_payment_methods","xkey"=>"id","xfield"=>"payment_name","readonly"=>false, "linkcreate"=>false, "linkedit"=>false, "sql"=>""));

	if ($_GET['_']=="e") {
		include "shared/db_links.php";
                $invoice=$this->dbi->get_record("SELECT * from kms_erp_invoices WHERE id=".$_GET['id'],$this->dblinks['client']);
		$this->humanize("cancelled_invoice_id","Anula la factura");
		$this->humanize("valid_cancellation","Anulaci&oacute; multiple");
        	$this->setComponent("xcombo","cancelled_invoice_id",array("xtable"=>"kms_erp_invoices","xkey"=>"number","xfield"=>"number","readonly"=>false, "linkcreate"=>false, "linkedit"=>false, "sql"=>"select number,id from kms_erp_invoices where total='".(-$invoice['total'])."' and sr_client='".$invoice['sr_client']."' and (status='anulat' or status='impagada')","orderby"=>"number desc"));
		if (($invoice['status']=="anulat"||$invoice['status']=="anulada-impagada")&&$invoice['total']!=0) {
			unset($this->hidden[array_search('cancelled_invoice_id', $this->hidden)]);
			unset($this->hidden[array_search('valid_cancellation', $this->hidden)]);
			if ($invoice['cancelled_invoice_id']=="") {
			$this->addComment("cancelled_invoice_id","<span style='color:#d00;'><-- Seleccioneu la factura que anula aquesta factura o marqueu anulaci&oacute; m&uacute;ltiple</span>");
			}
		}
		// set possible new status according current status (necessary for jornaling system )
		if ($invoice['status']=="pendent"||$invoice['status']=="pausa"||$invoice['status']=="remesa") {
			$this->setComponent("select","status",array("processing"=>"<font color=#ff7700>"._KMS_GL_PROCESSING."</font>","pendent"=>"<font color=#ff0000>pendent</font>","pausa"=>"<font style='background-color:#9f0'> PAUSA </font>","remesa"=>"<font color=#5f3bef><b>remesa</b></font>","cobrat"=>"<font color=#00AA00><b>cobrat</b></font>","abonada"=>"abonada","anulat"=>"<font color=#999999><b>anulat</b></font>","impagada"=>"<font color=#ff0000><b>impagada</b></font>","anulada-impagada"=>"<font color=#999999><b>"._KMS_GL_STATUS_ANULAT." per "._KMS_GL_STATUS_IMPAGADA."</b></font>","pagada-embargo"=>"<font color=#00AA00><b>Pagada embargo</b></font>")); 
		} else if ($invoice['status']=="cobrat"||$invoice['status']=="abonada") {
			$this->setComponent("select","status",array("pendent"=>"<font color=#ff0000>pendent</font>","cobrat"=>"<font color=#00AA00><b>cobrat</b></font>","abonada"=>"abonada","retornat"=>"<font color=#ff0000><b>retornat</b></font>","anulat"=>"<font color=#999999><b>anulat</b></font>","anulada-impagada"=>"<font color=#999999><b>"._KMS_GL_STATUS_ANULAT." per "._KMS_GL_STATUS_IMPAGADA."</b></font>","pagada-embargo"=>"<font color=#00AA00><b>Pagada embargo</b></font>"));
		} else if ($invoice['status']=="impagada") {
			$this->setComponent("select","status",array("cobrat"=>"<font color=#00AA00><b>cobrat</b></font>","impagada"=>"<font color=#ff0000><b>impagada</b></font>","abonada"=>"abonada","anulat"=>"<font color=#999999><b>anulat</b></font>","pendent"=>"<font color=#ff0000>pendent</font>","anulada-impagada"=>"<font color=#999999><b>"._KMS_GL_STATUS_ANULAT." per "._KMS_GL_STATUS_IMPAGADA."</b></font>","pagada-embargo"=>"<font color=#00AA00><b>Pagada embargo</b></font>"));
		} else if ($invoice['status']=="retornat") {
			$this->setComponent("select","status",array("cobrat"=>"<font color=#00AA00><b>cobrat</b></font>","abonada"=>"abonada","retornat"=>"<font color=#ff0000><b>retornat</b></font>","anulat"=>"<font color=#999999><b>anulat</b></font>","anulada-impagada"=>"<font color=#999999><b>"._KMS_GL_STATUS_ANULAT." per "._KMS_GL_STATUS_IMPAGADA."</b></font>","pendent"=>"<font color=#ff0000>pendent</font>","pagada-embargo"=>"<font color=#00AA00><b>Pagada embargo</b></font>"));
		} else if ($invoice['status']=="anulat"||$invoice['status']=="anulada-impagada") {
			$this->setComponent("select","status",array("anulat"=>"<font color=#999999><b>anulat</b></font>","anulada-impagada"=>"<font color=#999999><b>"._KMS_GL_STATUS_ANULAT." per "._KMS_GL_STATUS_IMPAGADA."</b></font>","pendent"=>"<font color=#ff0000>pendent</font>"));
		}
		// no es pot modificar la factura si ja ha estat enviada perque aleshores tambe ha estat comptabilitzada
		if ($invoice['check_sent']=="1") {
			$this->notice="El concepte i import d'aquesta factura no es pot modificar ja que ja ha estat enviada al client.<br>Per modificar la factura, canvieu el valor del camp enviada, deseu canvis i torneu a editar la factura.";
//			$this->readonly = array("serie","type","end_date","acc_status","number", "creation_date", "vr_cif", "sr_client", "total_tax", "total","concept","base","price_values","tax_percent","discount","irpf","bank_charges");
//			$this->hidden = array("sr_remittance","cancelled_invoice_id","valid_cancellation","acc_status");	
			$this->hidden = array("cancelled_invoice_id","valid_cancellation","acc_status");
		}
	}
	if ($_GET['edit']=="1")  $this->readonly = array(); 	

//	if ($_GET['_']=="b"&&!strpos($_SERVER['HTTP_REFERER'],"_=e")) 
	 if ($_GET['_']=="b") $this->setComponent("status_icon", "check_sent", array("script"=>"invoice_check_sent"));  // comentar per habilitar canvis de factura
        $this->setComponent("xcombo","sr_client",array("xtable"=>"kms_ent_contacts","xkey"=>"id","xfield"=>"name","readonly"=>false,"linkcreate"=>false,"linkedit"=>true,"sql"=>""));

	$this->setComponent("file","attachment",array($this->kms_datapath."/files/invoices","files/invoices"));
	if ($_GET['_']=="e") $this->setComponent("checklist","check_sent",array("1"=>""));
	
	// editor wysiwyg
	$this->setComponent("wysiwyg","concept",array("type"=>"richtext"));
	$this->setComponent("wysiwyg","price_values",array("type"=>"richtext"));

        $xsql=array("xv_xtable"=>"kms_ent_clients", "xv_field"=>"sr_client", "xv_xkey"=>"sr_client", "xv_xfield"=>"cif");
        $this->xvField("vr_cif",array("sql"=>$xsql));
        $xsql=array("xv_xtable"=>"kms_ecom_payment_methods", "xv_field"=>"payment_method", "xv_xkey"=>"id", "xv_xfield"=>"payment_type");
        $this->xvField("vr_payment_method",array("sql"=>$xsql));

	//camps virtuals referenciats (columna virtual, taula ref, camp id taula, camp id taula ref, camp taula ref)
	//$this->xvField("vr_email","kms_ent_contacts", "sr_client", "id", "email");
	//$this->xvField("vr_facturation_address","kms_ent_contacts", "sr_client", "id", "facturation_address");
        $this->setValidator("number","alphanumeric");
        $this->setValidator("concept","notnull");
        $this->setValidator("base","float");	

	$this->setComponent("money","total",array("show_euro"=>false));
	$this->setComponent("money","total_tax",array("show_euro"=>false));
	$this->setComponent("money","base",array("show_euro"=>false));

        // -- events --
        $this->onFieldChange("base","b=parseFloat($('#base').val());d=parseFloat($('#discount').val());t=parseFloat($('#tax_percent').val());$('#total_tax').val(Math.round((((b-((b*d)/100))*t)/100)*100)/100);$('#total_tax').change()");
        $this->onFieldChange("total_tax","b=parseFloat($('#base').val());tt=parseFloat($('#total_tax').val());$('#total').val(Math.round(((b-((b*d)/100))+tt)*100)/100)");
        $this->onFieldChange("tax_percent","$('#base').change()");
        $this->onFieldChange("discount","$('#base').change()");
	$this->onFieldChange("status","if (this.value=='anulat'||this.value=='anulada-impagada') { $('#tr_cancelled_invoice_id').show();$('#tr_valid_cancellation').show(); }  else { $('#tr_cancelled_invoice_id').hide();$('#tr_valid_cancellation').hide(); }");
        $this->onDocumentReady("if ($('#discount').val()=='') $('#discount').val(0); if ($('#status').val()=='anulat'||$('#status').val()=='anulada-impagada') { $('#tr_cancelled_invoice_id').show();$('#tr_valid_cancellation').show(); }");

	$this->styleRow=array("field"=>"","rule"=>"styleRowRule","styles"=>array("ok"=>"","error"=>"background-color:#FFaFaF"));

	$this->addComment("sr_remittance"," Posar a 0 i pendent per tornar a remesar");
	//set number11
//	mysqli_select_db('intergrid');
	$result = mysqli_query($this->dblinks['client'],'SELECT id from kms_erp_invoices order by id desc limit 1');
	$row = mysqli_fetch_array($result);
	$this->defvalue("number","F".(string)($row[0]+1).".".substr(date('Y'),-2));

	//$this->dbi->debug = true;
	$this->onUpdate="onUpdate";
	}

	function styleRowRule($record) {
		$result = mysqli_query($this->dblinks['client'],'SELECT total,cancelled_invoice_id,status from kms_erp_invoices where id='.$record->id);
	        $record = mysqli_fetch_array($result);
		if (($record->status!="anulat"&&$record->status!="anulada-impagada")||$record->valid_cancellation==1) {
			return "ok"; 
		} else {
		if ($record->total!=0&&$record->cancelled_invoice_id=="") return "error"; else {
			$other_invoice=$this->dbi->get_record("SELECT total from kms_erp_invoices WHERE number='".$record->cancelled_invoice_id."'",$this->dblinks['client']);
			if (($other_invoice['total']+$record->total)!=0) return "error"; else return "ok";
			}
		}
	}

	function onUpdate($post,$id) {
		include "shared/db_links.php";
		$invoice=array("sr_client"=>$post['sr_client'],"status"=>$post['status'],"concept"=>$post['concept'],"price_values"=>$post['price_values'],"base"=>$post['base'],"discount"=>$post['discount'],"total_tax"=>$post['total_tax'],"total"=>$post['total'],"payment_method"=>$post['payment_method'],"tax_values"=>$post['tax_values'],"total_values"=>$post['total_values'],"payment_date"=>$post['payment_date']);
		if ($post['proforma']=='1') $prefix="P"; else $prefix="F";
                if ($post['status']=="retornat") { $invoice['bank_charges']='3.5'; unset($this->readonly[16]); }
		$this->dbi->update_record("kms_isp_invoices",$invoice,"number like '{$prefix}$id.%'",$dblink_cp,$dblink_erp);	

	}

}

?>
