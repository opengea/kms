<?php
/*$_GET['mod']="isp_invoices";
$_GET['action']="get_pdf";
$_GET['id']="18821";
*/
require_once ('/usr/local/kms/mod/erp/reports/download.php');
function toup($s) {
        return htmlentities(strtoupper(html_entity_decode($s)));
}

switch ($_GET['mod']) {
    case "isp_invoices":
	$sel="SELECT * FROM kms_isp_invoices WHERE id='".$_GET['id']."'";
	if ($_SESSION['where']!="") $sel.=" AND ".$_SESSION['where'];
        $result = mysqli_query($this->dblinks['client'],$sel);

        if (!$result) {echo mysqli_error();exit;}
        $document_data = mysqli_fetch_array($result);
	if ($document_data['sr_client']=="") die('invalid data');
        $select = "SELECT * FROM kms_isp_clients WHERE sr_client='".$document_data['sr_client']."'";
        $result = mysqli_query($this->dblinks['client'],$select);
        if (!$result) {echo mysqli_error();exit;}
        $client_data = mysqli_fetch_array($result);
        $type = _KMS_ERP_INVOICE;
        if ($client_data['id']=="") {
                        $select =  "select * from kms_ent_contacts where id=".$document_data['sr_client'];
                        $result = mysqli_query($this->dblinks['client'],$select);
                        $entity = mysqli_fetch_array($result);
                        die ('No hi ha client associat a aquesta entitat ('.$select.'). Assegureu-vos de que estigui donat d\'alta.<br><br>Entitat: <b>'.$entity['name'].'</b>');
                        }
        $select = "select id from kms_isp_clients where sr_client=".$client_data['id'];
        $result = mysqli_query($this->dblinks['client'],$select);
        $client = mysqli_fetch_array($result);
        $client_data['id']=$document_data['sr_client'];
        break;

    case "ecom_budgets":
    	$result = mysqli_query($this->dblinks['client'],"SELECT * FROM kms_ecom_budgets WHERE id='".$_GET['id']."'");
        if (!$result) {echo mysqli_error();exit;}
        $document_data = mysqli_fetch_array($result);
        $result = mysqli_query($this->dblinks['client'],"SELECT * FROM kms_isp_clients t1 INNER JOIN (select * FROM kms_ent_contacts) t2 ON t1.sr_client=t2.id and t1.sr_client='".$document_data['sr_client']."'");
        if (!$result) {echo mysqli_error();exit;}
        $client_data = mysqli_fetch_array($result);
        $type = _KMS_ERP_BUDGET;
        break;
    default:
	die ("Report type '".$_GET['mod']."' not valid or not defined");
}

$case=false;
include "/usr/local/kms/lang/".strtolower($client_data['language']).".php";

//recuperem dades d'empresa propia
$result = mysqli_query($this->dblinks['client'],"SELECT * FROM kms_isp_clients where id='1'");
if (!$result) {echo mysqli_error();exit;}
$self_data = mysqli_fetch_array($result);

// recuperem metode de pagament
$result = mysqli_query($this->dblinks['client'],"SELECT payment_name,bank_charges FROM kms_ecom_payment_methods where id='".$document_data['payment_method']."'");
if (!$result) {echo mysqli_error();exit;}
$payment_method_name = mysqli_fetch_array($result);

if ($client_data['billing_email']!="") { $email_address = $client_data['billing_email']; } else {  $email_address =  $client_data['email']; }
include "/usr/local/kms/mod/erpp/reports/lang/".strtolower($client_data['language']).'.php';
$top_headers="<link REL=\"STYLESHEET\" TYPE=\"text/css\" HREF=\"https://control.intergridnetwork.net/kms/mod/erp/reports/report2.css\" Title=\"css\">";
// generem PDF per descarregar o enviar
if ($_GET['action']=="get_pdf"||$_GET['action']=="email_invoice") {
ob_start();
eval('?>'.file_get_contents('/usr/local/kms/mod/isp/reports/tpl/headers.php').'<?');
$headers = ob_get_contents();
eval('?>' . file_get_contents('/usr/local/kms/mod/erp/reports/tpl/'.$_GET['mod'].'.php') . '<?');
$report = ob_get_contents();
ob_end_clean();
	$rpt = $report;
	$fp = fopen('/tmp/'.$document_data['number'].'.html', 'w');
	if (fwrite($fp, $rpt)) {
	//echo '/usr/local/kms/bin/extras/wkhtmltopdf /tmp/'.$document_data['number'].'.html /tmp/'.$document_data['number'].'.pdf<br><br>';
	exec('/usr/bin/wkhtmltopdf /tmp/'.$document_data['number'].'.html /tmp/'.$document_data['number'].'.pdf');
	//descarreguem el fitxer o enviem per email
	set_time_limit(0);
	$file_path='/tmp/'.$document_data['number'].'.pdf';
	if(!is_readable($file_path)) die('[report.php] File '.$file_path.' not found or inaccessible!');
	if ($_GET['action']=="get_pdf") {
//		output_file($file_path,$document_data['number'].'.pdf'); //enviem fitxer per descarregar
		echo "<iframe width=200 height=20 frameborder=0 src='/kms/mod/erp/reports/direct_download.php?file=".$file_path."&name=".$document_data['number'].".pdf'></iframe>";

	} 
	}
} // pdf generat

echo $top_headers;
?>
<div>
<div class="rpt_controller" id="rpt_controller">
<div class="rpt_controller_buttons" id="rpt_controller_buttons">
<a href="/?_=f&id=<?=$_GET['id']?>&app=cp&mod=<?=$_GET['mod']?>&action=get_pdf"><img src="/kms/mod/erp/reports/img/pdf.png" width="35" height=35 border="0" title="<?=_KMS_ERP_RPT_GENERATEPDF?>" widht=50></a>
</div>
</div>
<?
$file='/usr/local/kms/mod/erp/reports/tpl/'.$_GET['mod'].'.php';
if (!file_exists($file)) die ("Template not found : ".$file);
ob_start();
eval('?>' . file_get_contents($file) . '<?');
$report = ob_get_contents();
ob_end_clean();
echo $report;
?>
<script language="JavaScript" type="text/javascript">
	<!-- hide from older browser
	function sendMail() {
	var email=prompt("Comprova l'adre\347a de correu","<?=$client_data['email']?>");
	url="http://intranet.intergrid.cat/kms/mod/erp/reports/report.php?id=<?=$_GET['id']?>&mod=<?=$_GET['mod']?>&sendmail";
	url+= "&email=" + email;
	window.location = url;
	}
</script>

<script language="JavaScript" type="text/javascript">
function updateSubject(value) {
	switch (value)
	{
	case 'invoice':
	document.sendMailForm.subject.value = "Intergrid SL - <?=$type?> Num. <?=$document_data['number']?>"
	break;
	case 'terminator1':
	document.sendMailForm.subject.value = "Reclamacio 1er avis - <?=$type?> Num. <?=$document_data['number']?>"
	break;
	case 'terminator2':
	document.sendMailForm.subject.value = "Reclamacio - 2on avis (bloqueig de servei) - <?=$type?> Num. <?=$document_data['number']?>"
	break;
	}
}
</script>
</div>
</body>
