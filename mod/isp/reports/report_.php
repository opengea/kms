<?php
   session_start();
   setlocale(LC_CTYPE,"es_ES");



   if (!$_SESSION['user_logged']) {
   echo "Session expired or user not logged. Please, autenticate first";exit;
   header ('location: http://intranet.intergrid.cat');
   }
// read domain and subdomain, open intergrid kms
require_once ('/usr/local/kms/lib/kms_dbconnect.php');
require_once ('/usr/local/kms/mod/erp/reports/download.php');

if (($_SESSION['user_logged']!= true)||($current_subdomain!="intranet")) {
    die ("Access denied. Session invalid.");
}

switch ($_GET['mod']) {
    case "erp_invoices":
	$result = mysqli_query("SELECT * FROM kms_erp_invoices WHERE id='".$_GET['id']."'");
	if (!$result) {echo mysqli_error();exit;}
	$document_data = mysqli_fetch_array($result);
	$result = mysqli_query("SELECT * FROM kms_ent_clients_extended WHERE id='".$document_data['sr_client']."'");
	if (!$result) {echo mysqli_error();exit;}
	$client_data = mysqli_fetch_array($result);
	$type = _KMS_ERP_INVOICE;
	break;
    case "erp_budgets":
    	$result = mysqli_query("SELECT * FROM kms_erp_budgets WHERE id='".$_GET['id']."'");
        if (!$result) {echo mysqli_error();exit;}
        $document_data = mysqli_fetch_array($result);

        $result = mysqli_query("SELECT * FROM kms_ent_clients_extended WHERE id='".$document_data['sr_client']."'");
        if (!$result) {echo mysqli_error();exit;}
        $client_data = mysqli_fetch_array($result);
        $type = _KMS_ERP_BUDGET;
        break;
    default:
	die ("Report type not valid or not defined");
}
$case=false;
include "/usr/local/kms/lang/".strtolower($client_data['language']).".php";

// recuperem metode de pagament

$result = mysqli_query("SELECT payment_name FROM kms_ecom_payment_methods where id='".$document_data['payment_method']."'");
if (!$result) {echo mysqli_error();exit;}
$payment_method_name = mysqli_fetch_array($result);

if ($client_data['billing_email']!="") { $email_address = $client_data['billing_email']; } else {  $email_address =  $client_data['email']; }

include "lang/".strtolower($client_data['language']).'.php';
ob_start();
eval('?>' . file_get_contents('headers.php') . '<?');
$headers = ob_get_contents();
ob_end_clean();
ob_start();

eval('?>' . file_get_contents('tpl/'.$_GET['mod'].'.php') . '<?');
$report = ob_get_contents();
ob_end_clean();
// generem PDF per descarregar o enviar
if (isset ($_GET['pdf']) || (isset ($_GET['sendmail']))) {
	$rpt = $headers."<body><br>".$report."</body>";
	$fp = fopen('/tmp/'.$document_data['number'].'.html', 'w');
	if (fwrite($fp, $rpt)) {
	exec('/usr/local/bin/wkhtmltopdf /tmp/'.$document_data['number'].'.html /tmp/'.$document_data['number'].'.pdf');
	//descarreguem el fitxer o enviem per email
	set_time_limit(0);
	$file_path='/tmp/'.$document_data['number'].'.pdf';
	if (isset ($_GET['pdf'])) {
	output_file($file_path,$document_data['number'].'.pdf'); //enviem fitxer per descarregar
				} else {
	//enviem per email
	ob_start();
	eval('?>' . file_get_contents('tpl/email_'.$_GET['mod'].'.php') . '<?');
	$bodymes = ob_get_contents();
	ob_end_clean();
	
	echo $bodymes;
	require '/usr/local/kms/lib/geekMail-1.0.php';
	$geekMail = new geekMail();
	$geekMail->setMailType('html');
	
	if ($client_data['language']=="es") $from_email = "gestion@intergrid.es"; else $from_email = "gestio@intergrid.cat";
	
	$geekMail->from($from_email,'Intergrid SL'); // agafar l'email i el nom d'usuari de la sessió?
	$geekMail->to($_GET['destiny']); //cc o bcc també es poden fer servir
	if ($_GET['checksendcc2'] !="") { $geekMail->bcc($_GET['destiny_cc']); }
	$geekMail->subject('Intergrid SL - '.$type.' Nº '.$document_data['number']);
	//$geekMail->message($_GET['emailBody']); //html?
	$geekMail->message($bodymes);
	$geekMail->attach($file_path);
	 
	if (!$geekMail->send())
	{
	  $errors = $geekMail->getDebugger();
	  print_r($errors);
	}
					}
	//esborrem fitxers temporals
	exec('/bin/rm /tmp/'.$document_data['number'].'.html');
	exec('/bin/rm /tmp/'.$document_data['number'].'.pdf');
	
		print_r('<br><hr><br>Email enviat correctament a '.$_GET['destiny']);
		print_r('<br>');
		print_r('<a href="#" onclick=self.close()>Clic aqu&iacute; per tancar la finestra</a>');
	
	// introduim a la BD hora i email d'enviament
		$result = mysqli_query("UPDATE kms_".$_GET['mod']." SET sent_email='".$_GET['destiny']."',sent_date='".date('Y-m-d h:i:s')."',check_sent=1 WHERE id='".$_GET['id']."'");
		if (!$result) {echo mysqli_error();exit;}
		return true;
	} else  {
	        return false;
        }
}

// controlem si s'imprimeix per pantalla o no
if (!isset ($_GET['nooutput'])) { 
echo $headers;?>
<body style="background-color:#eee;">
<div class="rpt_controller" id="rpt_controller">
<div class="rpt_controller_form" id="rpt_controller_form">
<form action="report.php" method="get"  name="sendMailForm" target="_self" class="sendMailForm" id="sendMailForm" dir="ltr" lang="<?=$client_data['language']?>">
<input type="hidden" name="mod" value="<?=$_GET['mod']?>">
<input type="hidden" name="id" value="<?=$_GET['id']?>">
<input type="hidden" name="sendmail">
<table class="rpt_form_table" id="report_form_table">
<tr>
    <td colspan="6"><b>Introduir dades d'enviament</b></td>
  </tr>
  <tr>
    <td>mail:</td>
    <td><input type="checkbox" name="checksendmail2" id="checksendmail2" checked="checked">
    &nbsp;<input type="text" name="destiny" id="destiny" value="<?=$email_address?>"></td>
    <td>Assumpte:</td>
    <td><input type="text" name="subject2" id="subject2" value="Intergrid SL - <?=$type?> Num. <?=$document_data['number']?>"></td>
    <td>Missatge enviat a:</td>
    <td><?=$document_data['sent_email']?></td>
  </tr>
  <tr>
    <td>CC:</td>
    <td><input type="checkbox" name="checksendcc2" id="checksendcc2">
    &nbsp;<input type="text" name="destiny_cc" id="destiny_cc" value="gestio@intergrid.cat"></td>
    <td>Cos de missatge:</td>
    <td><textarea name="emailBody" id="emailBody" cols="40" rows="4"></textarea></td>
    <td>Amb data:</td>
    <td><?=date('d-m-Y',strtotime($document_data['sent_date']))?>&nbsp;a les&nbsp;<?=date('H:m:s',strtotime($document_data['sent_date']))?></td>
  </tr>
 <tr>
    <td><input type="submit" name="submit" id="submit" value="Enviar"></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</form>
</div>
<div class="rpt_controller_buttons" id="rpt_controller_buttons">
<a href="#" onclick="moveIt(document.getElementById('rpt_controller'))"><img src="img/email.png" width="35" height="35" border="0" title=<?=_KMS_ERP_RPT_SENDMAIL?>></a>&nbsp;<a href="report.php?id=<?=$_GET['id']."&mod=".$_GET['mod']?>&pdf"><img src="img/pdf.png" width="35" height=35 border="0" title="<?=_KMS_ERP_RPT_GENERATEPDF?>" widht=50></a>
</div>
</div>
<?
echo $report;
}
?>
</body>
<script language="JavaScript" type="text/javascript" charset="iso-8859-1">
<!-- hide from older browser
function sendMail() {
var email=prompt("Comprova l'adre\347a de correu","<?=$client_data['email']?>");
url="http://intranet.intergrid.cat/kms/mod/erp/reports/report.php?id=<?=$_GET['id']?>&mod=<?=$_GET['mod']?>&sendmail";
url+= "&email=" + email;
window.location = url;
}
//-->
</script>
<script language="JavaScript" type="text/JavaScript">
function moveIt(obj) {
	if (obj.style.top == "0px") { obj.style.top = "-179px"}
	else { obj.style.top = "0px"}
}
</script>

