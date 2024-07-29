<?
// ----------------------------------------------
// Class ERP Invoices for KMS
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class isp_invoices extends mod {

	/*=[ CONFIGURACIO ]=====================================================*/
	
	var $table	= "kms_isp_invoices";
	var $key	= "id";	
	var $fields 	= array("number", "creation_date", "sr_client", "concept", "total", "status", "payment_method","vr_payment_method", "payment_date");
//	var $sum 	= array("base","total_tax","total");
	var $export_f   = array("status", "number", "creation_date", "concept", "base", "total_tax", "total", "payment_date");
	var $shorten 	= array("vr_payment_method","check_sent");
	var $title 	= "Factures";
	var $orderby 	= "number";
	var $sortdir 	= "desc";
	var $notedit 	= array("tax_values","total_values");
	var $excludeBrowser = array("payment_method");
	var $readonly 	= array("end_date");
        var $page_rows	= 30;
        var $page_links = 10;
        var $ts_format  = "m/d/Y h:i A";
        var $insert_label = _KMS_NEW_INVOICE;

        /*=[ PERMISOS ]===========================================================*/

        var $can_gohome = true;
        var $can_view   = false;
        var $can_edit   = false;
        var $can_delete = false;
	var $can_duplicate = false; //* no duplicar perque es lien els ids
        var $can_add    = false;
        var $can_import = false;
        var $can_export = true;
        var $can_search = true;
        var $can_print  = true;

       //*=[ CONSTRUCTOR ]===========================================================*/

       function isp_invoices($client_account,$user_account,$dm) {
		include "/usr/local/kms/tpl/panels/isp_invoices.php";

                $select="SELECT * FROM kms_isp_clients where sr_user=".$user_account['id'];
                $result=mysqli_query($this->dblinks['client'],$select);
                if (!$result) die(mysqli_error($result));
                $client=mysqli_fetch_array($result);
                if ($this->_group_permissions(1,$user_account['groups']))  {
			$this->can_delete=true;$this->can_edit=true;
                } else if ($this->_group_permissions(3,$user_account['groups'])) {
			if ($client['id']=="") $this->_error("","Client not found for user ".$user_account['id'],"fatal");
                        $this->where = "kms_isp_invoices.sr_client in (select sr_client from kms_isp_clients where sr_provider=".$client['sr_client'].")";
			$_SESSION['where']=$this->where; //force see only invoices of this provider
			if ($_GET['_']=="f") {
				$select="SELECT id,sr_client FROM kms_isp_invoices WHERE id=".$_GET['id']." and kms_isp_invoices.sr_client in (select sr_client from kms_isp_clients where sr_provider=".$client['sr_client'].")";
				$result=mysqli_query($this->dblinks['client'],$select);
		                if (!$result) die(mysqli_error($result));
		                $invoice=mysqli_fetch_array($result);
				if ($invoice['id']=="") die('Error. Invalid call');
			}
                } else  {
			if ($client['id']=="") $this->_error("","Client not found for user ".$user_account['id'],"fatal");
	                $_SESSION['sr_client']=$client['sr_client'];
        	        $_SESSION['sr_client_id']=$client['id'];
                        if ($_GET['_']=='b') $_GET['id']=$client['id'];
                        $this->where = "kms_isp_invoices.sr_client=".$client['sr_client'];
			$_SESSION['where']=$this->where; //force see only invoices of this client on  /usr/local/kms/mod/isp/reports/report.php
		        $this->fields     = array("number", "creation_date", "concept", "base", "total_tax", "total", "payment_date", "status");
                }


                parent::mod($client_account,$user_account,$extranet);
        }

       function setup($client_account,$user_account,$dm) {
	//$this->safedel("Display","N","Disable");

	//$this->xlist("partners","Business_Rid",array("Rid","Name","Description"));
	$this->humanize("total_tax","IVA");
	$this->defvalue("status","active");
	$this->defvalue("serie","A");
	$this->defvalue("tax_percent","18");
	$this->defvalue("payment_method","3");
	$this->abbreviate("vr_payment_method","MP");
	$this->abbreviate("payment_method","MP");
	$this->abbreviate("check_sent","Env");
	$this->abbreviate("creation_date",_KMS_GL_DATE);
	$this->abbreviate("sr_remittance","Rem");
	$this->abbreviate("base","Base imp.");
	
	$uploadDate = date('Y-m-d');
	$this->defvalue("creation_date",$uploadDate);
	$this->defvalue("payment_date",$uploadDate);
	
	$this->default_content_type = "invoice";
	$this->default_file = "invoices.php";
	//$this->validate("Email");
	//$this->validate("WWW");
	
	// ----------------- components -----------------
	if ($_SESSION['user_groups']!=1) $status_cobrat=_KMS_WEB_ECOM_STATUS_PAYED; else $status_cobrat=_KMS_WEB_ECOM_STATUS_COBRAT;
	// Combobox
	$this->setComponent("select","status",array("pendent"=>"<font color=#ff0000>"._KMS_GL_PENDING."</font>","remesa"=>"<font color=#5f3bef><b>"._KMS_ERP_REMESA."</b></font>","cobrat"=>"<font color=#00AA00><b>".$status_cobrat."</b></font>","retornat"=>"<font color=#ff0000><b>"._KMS_ERP_STATUS_RETORNAT."</b></font>","anulat"=>"<font color=#999999><b>"._KMS_GL_STATUS_ANULAT."</b></font>","impagada"=>"<font color=#ff0000><b>"._KMS_GL_STATUS_IMPAGADA."</b></font>"));
	$this->setComponent("select","type",array("ordinaria"=>_KMS_ERP_INVOICE_ORDINARIA,"rectificativa"=>_KMS_ERP_INVOICE_RECTIFICATIVA,"abonament"=>_KMS_ERP_ABONO));

	$this->customOptions = Array();
//	$this->customOptions[0] = Array ("label"=>"_KMS_ERP_RPT_GENERATEPDF","url"=>"/kms/mod/erp/invoices/invoice.php?idfact=".array($this->fields['number'])."&pdf","ico"=>"pdf.gif","params"=>"action=view_pdf","target"=>"new","checkFunction"=>"");
	$this->customOptions[0] = Array ("label"=>_KMS_ERP_INVOICE,"url"=>"","ico"=>"pdf.gif","params"=>"action=view_pdf","target"=>"new","checkFunction"=>"");
	$this->setComponent("status_icon", "status", array("script"=>"isp_invoices_payment","show_label"=>false));
	
	$this->nowrap("number");
	$this->nowrap("creation_date");
	$this->action("view_pdf","/usr/local/kms/mod/isp/reports/report.php");
	$this->action("get_pdf","/usr/local/kms/mod/isp/reports/report.php");
	$this->action("email_invoice","/usr/local/kms/mod/isp/reports/report.php");
	$this->action("invoice_payment","/usr/local/kms/mod/isp/tpv/tpv_visa_payment.php");
	$this->action("invoice_payment_result","/usr/local/kms/mod/isp/tpv/tpv_visa_payment_result.php");
	$this->action("invoice_payment_paypal","/usr/local/kms/mod/isp/tpv/paypal_payment.php");
	$this->action("invoice_payment_paypal_result","/usr/local/kms/mod/isp/tpv/paypal_payment_result.php");
	$this->action("paypal_subscribe","/usr/local/kms/mod/isp/tpv/paypal_subscribe.php");
	// SELECT permet seleccionar multiples valors d'una llista de valors unics
	// si la llista es fixe, posar el segon parametre a true
	//$this->setComponent("uniselect","payment_method");
        $this->setComponent("xcombo","payment_method",array("xtable"=>"kms_ecom_payment_methods","xkey"=>"id","xfield"=>"payment_name","readonly"=>true, "linkcreate"=>true, "linkedit"=>true, "sql"=>""));
        if ($this->_group_permissions(1,$user_account['groups'])||($this->_group_permissions(3,$user_account['groups']))) {
                $this->setComponent("xcombo","sr_client",array("xtable"=>"kms_isp_clients","xkey"=>"sr_client","xfield"=>"name","readonly"=>false,"linkcreate"=>true,"linkedit"=>true,"sql"=>""));
        }

	$this->setComponent("file","attachment",array($this->kms_datapath."/files/invoices","files/invoices"));
	$this->setComponent("status_icon", "check_sent", array("script"=>"invoice_check_sent"));

	// editor wysiwyg
	//$this->setComponent("wysiwyg","concept");
	//$this->setComponent("wysiwyg","price_values");
	$xsql=array("xv_xtable"=>"kms_ent_clients", "xv_field"=>"sr_client", "xv_xkey"=>"sr_client", "xv_xfield"=>"cif");
	$this->xvField("vr_cif",array("sql"=>$xsql));
	$xsql=array("xv_xtable"=>"kms_ecom_payment_methods", "xv_field"=>"payment_method", "xv_xkey"=>"id", "xv_xfield"=>"payment_type");
	$this->xvField("vr_payment_method",array("sql"=>$xsql));
	//$this->xvField("vr_","kms_whe

	//camps virtuals referenciats (columna virtual, taula ref, camp id taula, camp id taula ref, camp taula ref)
	//$this->xvField("vr_email","kms_ent_contacts", "sr_client", "id", "email");
	//$this->xvField("vr_facturation_address","kms_ent_contacts", "sr_client", "id", "facturation_address");
	
	//$this->dbi->debug = true;

	}

}

?>
