#!/usr/bin/php -q
<?php
error_reporting(0);
include "/usr/local/kms/lib/dbi/db_localhost_connect.php";
include "/usr/local/kms/mod/erp/erp_options.php";
include_once "/usr/local/kms/lib/include/functions.php";
//$today=10;
// aquest script envia les factures que fa 7 vencin a 15 dies del dia d'avui, per email als clients de forma automatica en el seu idioma..
//$older_than = date('Y-m-d', strtotime("+15 days"));
//$select = "SELECT * from kms_erp_invoices WHERE check_sent=0 AND payment_date<='".$older_than."' AND status!='pausa' and status!='anulat' AND serie='A'"; //AND total!=0";
// s'envien les factures que fa 5 dies que s'han generat 
$older_than = date('Y-m-d');//   , strtotime("-1 days")); enviem factures l'endemà
//$older_than = date('Y-m-d');
//$venciment_on = date('Y-m-d', strtotime("+5 days"));

//$select = "SELECT * from kms_erp_invoices";$res_=mysqli_query($dblink_local,$select); //is idiot but it may fix the idiot mysql bug ?

//$select = "SELECT * from kms_erp_invoices WHERE sr_client!=0 and check_sent=0 AND (creation_date<='".$older_than."' or payment_date<='".$venciment_on."') AND status!='pausa' and status!='anulat' AND serie='A'";
//$select = "SELECT * from kms_erp_invoices WHERE sr_client!=0 and (check_sent=0 or check_sent is null or check_sent='') AND creation_date<='".$older_than."' AND status!='pausa' and status!='anulat' AND serie='A'";
$select = "SELECT * from kms_erp_invoices WHERE sr_client!=0 and (check_sent=0 or check_sent is null or check_sent='') AND creation_date<='".$older_than."' AND status!='pausa' AND status!='anulada-impagada' AND (status!='anulada' AND total!=0) AND serie='A'";

$select.=" AND creation_date>'2012-10-26'"; //AND id>18112"; //NO TREURE!! es per evitar que s'enviin factures que no es van enviar al seu dia

//$select.=" limit 1";
//#$select="select * from kms_erp_invoices where id=22607";
echo $select."\n\n";
$res_=mysqli_query($dblink_local,$select);
while ($invoice = mysqli_fetch_array($res_)) {
	$_GET['mod']="erp_invoices";
	$_GET['app']="accounting";
	$_GET['action']="email_invoice";
	$_GET['id']=$invoice['id'];
	$_POST['type']="invoice";
	$_POST['checksendmail2']=true;
	//$_POST['subject']="Intergrid SL - Factura Num. ".$invoice['number'];
//	if ($invoice['id']<21654) $_POST['destiny']="j.berenguer@intergrid.cat";
	//$_POST['emailBody']=""; //opcional
	$silent=true;
	echo "\nSending ".$_GET['id']."... ".$_POST['destiny']."\n";
	include "/usr/local/kms/mod/erp/reports/report.php";
}
mysqli_close();
echo "Nothing more to do\n";
?>
