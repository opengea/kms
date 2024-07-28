<?
// ----------------------------------------------
// Class ERP Invoices Sending Log for KMS
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class erp_invoices_sending_log extends mod {

        /*=[ CONFIGURACIO ]=====================================================*/

	$table	= "kms_erp_invoices_sending_log";
$key	= "id";	

$fields = array("sr_invoice","type","number","sr_client","sent_date","sent_to","sent_cc","total","payment_method","payment_date");

$notedit = array("sr_invoice");
$title = "Hist&oagrave;ric enviament factures";
$orderby = "sent_date";
$sortdir = "desc";
$this->multixref("sr_client", "id", "name", "kms_ent_contacts");
$this->ts_format  = "m/d/Y h:i A";

/*=[ PERMISOS ]===========================================================*/

$can_view = false;
$can_edit = false;
$can_delete = false;
$can_add	= false;
$import = false;
$export = true;
$search = true;

$this->page_rows = 50;

// default number of page links to display per page
// page_links = integer;
$this->page_links = 50;

$this->setComponent("select","type",array("1"=>"<font color=#00AA2E>N</font>","2"=>"<font color=#FF8040><b>T1</b></font>","3"=>"<font color=#ff0000><b>T2</b></font>"));

$this->setComponent("select","payment_method",array("1"=>"<font color=#00AA2E>Trans</font>","2"=>"<font color=#00AA2E><b>Xec</b></font>","3"=>"<font color=#00AA2E><b>Rebut</b></font>","3"=>"<font color=#00AA2E><b>Rebut60</b></font>","4"=>"<font color=#00AA2E><b>Rebut90</b></font>","5"=>"<font color=#00AA2E><b>Rebut90</b></font>","6"=>"<font color=#00AA2E><b>R306090</b></font>","7"=>"<font color=#00AA2E><b>R3090180</b></font>","8"=>"<font color=#00AA2E><b>Efectiu</b></font>","0"=>"<font color=#ff0000><b>-</b></font>"));

$this->customOptions = Array();
$this->customOptions[0] = Array ("label"=>_KMS_ERP_RPT_GENERATEPDF,"url"=>"/kms/mod/erp/reports/report.php","ico"=>"pdf.gif","params"=>"id=[sr_invoice]&mod=erp_invoices","target"=>"new");

/*=[ FI CONFIGURACIO ]=====================================================*/
$this->multixref("sr_client", "id", "name", "kms_ent_contacts");
$this->xcombo("sr_client", "kms_ent_contacts", "id", "name", false, "");
?>
