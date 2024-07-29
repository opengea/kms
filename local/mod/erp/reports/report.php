<?php
//$silent=1;// ENVIA O DESCARREGA FACTURA

// definicio de textos d'idioma. S'han de definir aqui perque no podem recarregar constants
$idiomes=array("ca"=>array(),"es"=>array(),"en"=>array(),"eu"=>array());
/*
$ca=array(
'_KMS_ERP_REPORTS_INVOICE_BILLING_COMUNICATION'=>'Us comuniquem que ha estat emesa una factura que trobareu adjunta en aquest correu en concepte de serveis oferts per INTERGRID SL.',
'_KMS_ERP_REPORTS_INVOICE_BILLING_VENCIMENT1'=>'El c&agrave;rrec es far&agrave; efectiu al n&uacute;mero de compte bancari ',
'_KMS_ERP_REPORTS_INVOICE_BILLING_VENCIMENT2'=>'aproximadament el dia ',
'_KMS_ERP_REPORTS_INVOICE_BILLING_NOTES'=>'Per visualitzar la factura haureu de tenir instal.lat un <a href=\&quot;http://www.adobe.com/products/acrobat/readstep2_allversions.html\&quot;>programa lector de documents PDF</a>.<br><br>* Aquesta factura t&eacute; la mateixa validesa que una factura f&iacute;sica.',
'_KMS_ERP_REPORTS_INVOICE_BILLING_NOTES_RETURN_PAYMENT'=>'* Les devolucions per qualsevol motiu implicaran un rec&agrave;rrec addicional de 12 euros en concepte de despeses de devoluci&oacute;.',
'_KMS_ERP_REPORTS_INVOICE_BILLING_SIGNATURE'=>'Cordialment,<br><br><pre class=\&quot;moz-signature\&quot; cols=\&quot;72\&quot;>--<br>Dep. de Gesti&oacute;<br><br>Intergrid tecnologies del coneixement S.L<br>Tel. +34 934426787 - Fax. +34 934439639<br><a class=\&quot;moz-txt-link-abbreviated\&quot; href=\&quot;mailto:gestio@intergrid.cat\&quot;>gestio@intergrid.cat</a>&nbsp;|&nbsp;<a class=\&quot;moz-txt-link-abbreviated\&quot; href=\&quot;http://www.intergrid.cat\&quot;>www.intergrid.cat</a></pre>',
'_KMS_ERP_REPORTS_INVOICE_BILLING_CLIENT'=>'Client',
'_KMS_ERP_REPORTS_INVOICE_BILLING_NIF'=>'NIF',
'_KMS_ERP_REPORTS_INVOICE_CREATION_DATE'=>'Data d\'emissió',
'_KMS_ERP_REPORTS_INVOICE_NUM'=>'',
'_KMS_ERP_REPORTS_INVOICE_PROVIDERDATA'=>'INTERGRID SL<br /></span><br>Carrer d\'en Roig, 15 local - 08001 Barcelona<br>T. 93 442 6787<br>F. 93 443 9639<br><a href = \'http://www.intergrid.cat\' >www.intergrid.cat</ a>',
'_KMS_ERP_REPORTS_INVOICE_INVOICE'=>'Factura',
'_KMS_ERP_REPORTS_INVOICE_CONTRACT_NUM'=>'Contract number',
'_KMS_ERP_REPORTS_INVOICE_CONCEPT'=>'Concepte',
'_KMS_ERP_REPORTS_INVOICE_IMPORT'=>'Import',
'_KMS_ERP_REPORTS_INVOICE_NOTES'=>'Notes',
'_KMS_ERP_REPORTS_INVOICE_PAYMENT_METHOD'=>'Forma de pagament',
'_KMS_ERP_REPORTS_INVOICE_PAYMENT_DATE'=>'Venciment',
'_KMS_ERP_REPORTS_INVOICE_BANK_ACCOUNT'=>'Compte bancari',
'_KMS_ERP_REPORTS_INVOICE_BASE'=>'Base imposable',
'_KMS_ERP_REPORTS_INVOICE_VAT'=>'% IVA',
'_KMS_ERP_REPORTS_INVOICE_TOTAL'=>'Total',
'_KMS_ERP_REPORTS_INVOICE_FOOTER'=>'Intergrid Tecnologies del Coneixement, S.L., societat inscrita en el registre mercantil de Barcelona. Tom 39.209, Foli 53, Full B-341613, Inscripció; 1, CIF: B-6440150',
'_KMS_ERP_REPORTS_INVOICE_REBUT_DOMICILIAT'=>'Rebut domiciliat',
'_KMS_ERP_REPORTS_INVOICE_COMPTE_EMPRESA'=>'ES49 3025 0005 8014 3332 8418',
'xxxx'=>'ES49 3025 0005 8014 3332 8418',
'_KMS_ERP_REPORTS_INVOICE_BANK_TRANSFER'=>'Transferència bancaria al compte',
'_KMS_ERP_PAYMENT_CC_INFO'=>' (Realitzeu el pagament a través del apartat Factures del <a href=\"https://control.intergridnetwork.net/?lang=ca">Tauler de Control</a>)',
'_KMS_ERP_REPORTS_INVOICE_BANK_CHECK'=>'Xec bancari',
'_KMS_ERP_REPORTS_INVOICE_EFECTIU'=>'Efectiu',
'_KMS_ERP_REPORTS_INVOICE_MAIL_INTRO'=>'Benvolgut client,',
'_KMS_ERP_REPORTS_INVOICE_EURO'=>'Euros',
'_KMS_ERP_REPORTS_INVOICE_BUDGET_VALID_UNTIL'=>'Pressupost v| lid fins el dia ',
'_KMS_ERP_REPORTS_INVOICE_BANK_CHARGES'=>'Rec&agrave;rrec bancari',
'_KMS_ERP_REPORTS_INVOICE_TERM1_COMUNICATION1'=>'Us informem que actualment manteniu un deute amb INTERGRID S.L. corresponent a serveis contractats per la vostra empresa. Us preguem que regularitzeu la vostra situació procedint a realitzar el pagament de la següent factura:',
'_KMS_ERP_REPORTS_INVOICE_TERM2_COMUNICATION1'=>'Us informem que actualment manteniu un deute amb INTERGRID S.L. corresponent a serveis contractats per la vostra empresa. Degut a que no hem rebut cap notificaci&oacute; de pagament per part vostra ens tornem a posar en contacte per demanar-vos que si us plau regularizeu la vostra situació procedint a realitzar el pagament de la següent facta',
'_KMS_ERP_REPORTS_INVOICE_RETURNED_PAYMENT_ACCOUNT'=>'Compte bancari on fer el pagament',
'_KMS_ERP_REPORTS_INVOICE_PAYMENT_INSTRUCTIONS'=>'Per tal d\'evitar possibles perjudicis que la present situaci&oacute; pugui ocasionar, preguem feu el pagament de l\'import pendent el m&eacute;s aviat possible mitjan&ccedil;ant qualsevol d\'aquestes dues opcions:<br><br>1. Mitjan&ccedil;ant pagament segur (targeta de cr&egrave;dit o PayPal) a trav&eacute;s de l\'apartat Factures de l\'&Agrave;rea de client <a href="http://www.intergrid.cat/clients">http://www.intergrid.cat/clients</a><br /><br /> 2. Mitjan&ccedil;ant transfer&egrave;ncia banc&agrave;ria al n&uacute;mero de compte de [BANK_ACCOUNT] - [CC] amb el concepte: \'[FACT]\' i enviant el justificant al nostre departament de facturaci&oacute; via correu electr&ograve;nic a&nbsp;gestio@intergrid.cat.<br /><br /> Si en el moment de la recepci&oacute; d\'aquest comunicat, hagu&eacute;ssiu processat ja el pagament del deute, preguem deixeu sense efecte aquest comunicat i disculpeu les mol&egrave;sties que us hagi pogut ocasionar.',
'_KMS_ERP_REPORTS_INVOICE_BANK_CHARGE'=>'Rec&agrave;rrec per rebut retornat',
'_KMS_ERP_REPORTS_INVOICE_RETURNED_TOTAL_PAY'=>'Total a pagar',
'_KMS_ERP_REPORTS_INVOICE_RETURNED_PAYMENT_DATE1'=>'Data límit de pagament',
'_KMS_ERP_REPORTS_INVOICE_TERM2_COMUNICATION3'=>'Lamentem comunicar-vos que, si en les properes 48 hores no heu regularitzat la vostra situació, suspendrem temporalment els serveis que us prestem i, si passats 30 dies, aquesta situac&oacute; persisteix, procedirem a la interrupci&oacute; definitiva dels serveis, així com a la corresponent resoluci&oacute; del contracte.<br>',
'_KMS_ERP_REPORTS_INVOICE_MAIL_NOTES'=>'* Per visualitzar la factura &eacute;s necessari disposar d\'un <a href=\"http://www.adobe.com/products/acrobat/readstep2_allversions.html\">programa lector de documents PDF</a>.<br>* Aquesta factura electrònica t&eacute; la mateixa validesa que una factura física.<br><br>Intergrid SL<br>Tel. 934426787<br>www.intergrid.cat',
'_KMS_ERP_REPORTS_INVOICE_CHARGE_NOTE'=>'* Si us plau assegureu-vos que hi ha suficient saldo disponible en el vostre compte en la data de venciment. Les devolucions per qualsevol motiu implicaran un rec&agrave;rrec addicional de 12 euros.'
);
$es=array(
'_KMS_ERP_REPORTS_INVOICE_BILLING_COMUNICATION'=>'Le comunicamos que ha sido emitida una factura que encontrará adjunta es este correo en concepto de servicios prestados por INTERGRID SL.',
'_KMS_ERP_REPORTS_INVOICE_BILLING_VENCIMENT1'=>'Se le cargará el importe de esta factura en su cuenta bancaria Nº',
'_KMS_ERP_REPORTS_INVOICE_BILLING_VENCIMENT2'=>'aproximadamente el día ',
'_KMS_ERP_REPORTS_INVOICE_BILLING_NOTES'=>'<br>Para visualizar la factura debera tener instalado un <a href=\"http://www.adobe.com/products/acrobat/reaa
dstep2_allversions.html\">programa lector de documentos PDF</a>. ',
'_KMS_ERP_REPORTS_INVOICE_BILLING_NOTES_RETURN_PAYMENT'=>'* La devolución por cualquier motivo de las domiciliaciones implicará un cargo adicional de 12 euros en concepto de gastos de gestión.',
'_KMS_ERP_REPORTS_INVOICE_BILLING_SIGNATURE'=>'Cordialmente,<br><br><pre class=\"moz-signature\" cols=\"72\">--<br>Dep. de Gestión<br><br>Intergrid S.L<br>Tel. +34 934426787 - Fax. +34 934439639<br><a class=\"moz-txtt
-link-abbreviated\" href=\"mailto:gestion@intergrid.es\">gestion@intergrid.es</a>| || <a class=\"moz-txt-link-abbreviated\" href=\"http://www.intergrid.es\">www.intergrid.es</a></pre>',
'_KMS_ERP_REPORTS_INVOICE_BILLING_CLIENT'=>'Cliente',
'_KMS_ERP_REPORTS_INVOICE_BILLING_NIF'=>'NIF',
'_KMS_ERP_REPORTS_INVOICE_CREATION_DATE'=>'Fecha de emisi&oacute;n',
'_KMS_ERP_REPORTS_INVOICE_NUM'=>'Num. Factura',
'_KMS_ERP_REPORTS_INVOICE_PROVIDERDATA'=>'INTERGRID SL<br /></span><br>Carrer d\'en Roig, 15 local - 08001 Barcelona<br>T. 93 442 6787<br>F. 93 443 9639<br><a href = \'http://www.intergrid.es\' >www.intergrid.es</ a>',
'_KMS_ERP_REPORTS_INVOICE_INVOICE'=>'Factura',
'_KMS_ERP_REPORTS_INVOICE_FIRST_ADVICE'=>'',
'_KMS_ERP_REPORTS_INVOICE_SECOND_ADVICE'=>'',
'_KMS_ERP_REPORTS_INVOICE_CONTRACT_NUM'=>'Num. de contrato',
'_KMS_ERP_REPORTS_INVOICE_CONCEPT'=>'Concepto',
'_KMS_ERP_REPORTS_INVOICE_IMPORT'=>'Importe',
'_KMS_ERP_REPORTS_INVOICE_NOTES'=>'Notas',
'_KMS_ERP_REPORTS_INVOICE_PAYMENT_METHOD'=>'Forma de pago',
'_KMS_ERP_REPORTS_INVOICE_PAYMENT_DATE'=>'Vencimiento',
'_KMS_ERP_REPORTS_INVOICE_BANK_ACCOUNT'=>'Cuenta bancaria',
'_KMS_ERP_REPORTS_INVOICE_BASE'=>'Base imponible',
'_KMS_ERP_REPORTS_INVOICE_VAT'=>'% IVA',
'_KMS_ERP_REPORTS_INVOICE_TOTAL'=>'Total',
'_KMS_ERP_REPORTS_INVOICE_FOOTER'=>'"Intergrid, S.L, sociedad inscrita en el registro mercantil de Barcelona. Tomo 39.209, Folio 53, Hoja B-341613, Inscripci&oacute;n 1, CIF: B-64401508',
'_KMS_ERP_REPORTS_INVOICE_REBUT_DOMICILIAT'=>'Recibo domiciliado',
'_KMS_ERP_REPORTS_INVOICE_COMPTE_EMPRESA'=>'ES49 3025 0005 8014 3332 8418',
'_KMS_ERP_REPORTS_INVOICE_BANK_TRANSFER'=>'Transferencia bancaria en la cuenta',
'_KMS_ERP_PAYMENT_CC_INFO'=>' (Haga el pago a través del apartado Facturas del <a href=\"https://control.intergridnetwork.net/?lang=es">Panel del Control</a>)',
'_KMS_ERP_REPORTS_INVOICE_BANK_CHECK'=>'Cheque bancari',
'_KMS_ERP_REPORTS_INVOICE_EFECTIU'=>'Efectivo',
'_KMS_ERP_REPORTS_INVOICE_MAIL_INTRO'=>'Apreciado cliente,',
'_KMS_ERP_REPORTS_INVOICE_EURO'=>'Euros',
'_KMS_ERP_REPORTS_INVOICE_BUDGET_VALID_UNTIL'=>'Presupuesto v&acute;lido hasta el d&iacute;a',
'_KMS_ERP_REPORTS_INVOICE_BANK_CHARGES'=>'Recargo bancario',
'_KMS_ERP_REPORTS_INVOICE_TERM1_COMUNICATION1'=>'Le informamos que actualmente mantiene una deuda con INTERGRID S.L correspondiente a servicios contratados por su empresa. Le rogamos que regularice su situación procediendo a realizar el  pago de la siguiente factura:',
'_KMS_ERP_REPORTS_INVOICE_TERM2_COMUNICATION1'=>'Le informamos que actualmente mantiene una deuda con INTERGRID S.L correspondiente a servicios contratados por su empresa. Debido a que no hemos recibido ninguna notificación de pago por ssu parte nos volvemos a poner en contacto con ustedes para reclamarles que regularizen su situación procediendo a realizar el pago de la siguiente factura:',
'_KMS_ERP_REPORTS_INVOICE_RETURNED_PAYMENT_ACCOUNT'=>'Cuenta bancaria dónde realizar el pago',
'_KMS_ERP_REPORTS_INVOICE_PAYMENT_INSTRUCTIONS'=>'A fin de evitar los posibles perjuicios que la presente situaci&oacute;n pudiera generar, le rogamos que realice el pago de la factura mediante una de estas dos opciones:<br /><br /> 1. Mediante tarjeta de cr&eacute;dito o PayPal a trav&eacute;s del apartado Facturas del Panel de Control: <a href="http://www.intergrid.es/clientes">http://www.intergrid.es/clientes</a><br /><br /> 2. Mediante transferencia bancaria al n&uacute;mero de cuenta de [BANK_ACCOUNT] - [CC] con concepto: \'[FACT]\' y enviando el justificante bancario mediante correo electr&oacute;nico a gestion@intergrid.es<br /> <br /> Si en el momento de la recepci&oacute;n de esta comunicaci&oacute;n, usted hubiera procedido ya al pago de la deuda, rogamos deje sin efecto este escrito y lamentamos las molestias que le hubi&eacute;ramos podido ocasionar',
'_KMS_ERP_REPORTS_INVOICE_BANK_CHARGE'=>'Recargo por recibo devuelto',
'_KMS_ERP_REPORTS_INVOICE_RETURNED_TOTAL_PAY'=>'Total a pagar',
'_KMS_ERP_REPORTS_INVOICE_RETURNED_PAYMENT_DATE1'=>'Fecha límite de pago',
'_KMS_ERP_REPORTS_INVOICE_TERM2_COMUNICATION3'=>'Lamentamos comunicarle que, si en las próximas 48 horas no ha regularizado su situación, suspenderemos temporalmente el servicio que venimos prestándole y, si pasados 30 días, esta situu  aación persiste procederemos a la interrupción definitiva del servicio, así como a la correspondiente resolución del contrato.<br>',
'_KMS_ERP_REPORTS_INVOICE_MAIL_NOTES'=>'* Para visualizar la factura debera tener instalado un <a href=\"http://www.adobe.com/products/acrobat/readstep2_allversions.html\">programa lector de documentos PDF</a>.<br>',
'_KMS_ERP_REPORTS_INVOICE_CHARGE_NOTE'=>'* Por favor asegúrese de que hay suficiente saldo disponible en su cuenta en la fecha de vencimiento. La devolución por cualquier motivo de las domiciliaciones implicará un cargo adicional de   euros.'
);
$eu=$es;
$en=array(
'_KMS_ERP_REPORTS_INVOICE_BILLING_COMUNICATION'=>'An new invoice has been issued by INTERGRID.',
'_KMS_ERP_REPORTS_INVOICE_BILLING_VENCIMENT1'=>'',
'_KMS_ERP_REPORTS_INVOICE_BILLING_VENCIMENT2'=>'10 days after invoice was generated.',
'_KMS_ERP_REPORTS_INVOICE_BILLING_NOTES'=>'',
'_KMS_ERP_REPORTS_INVOICE_BILLING_NOTES_RETURN_PAYMENT'=>'* Returns for any reason will entail An additional charge of 12 euros for costs of return.',
'_KMS_ERP_REPORTS_INVOICE_BILLING_SIGNATURE'=>'Cordialmente,<br><br><pre class=\"moz-signature\" cols=\"72\">--<br><br>Intergrid S.L<br>Tel. +34 934426787 - Fax. +34 934439639<br><a class=\"moz-txt-link-abbreviated\" href=\"mailto:gestio@intergrid.cat\">gestio@intergrid.cat</a>| || <a class=\"moz-txt-link-abbreviated\" href=\"http://www.intergrid.es\">www.intergrid.cat</a></pre>',
'_KMS_ERP_REPORTS_INVOICE_BILLING_CLIENT'=>'Client',
'_KMS_ERP_REPORTS_INVOICE_BILLING_NIF'=>'ID Fiscal',
'_KMS_ERP_REPORTS_INVOICE_CREATION_DATE'=>'Date',
'_KMS_ERP_REPORTS_INVOICE_NUM'=>'Invoice #',
'_KMS_ERP_REPORTS_INVOICE_PROVIDERDATA'=>'INTERGRID SL<br /></span>Carrer d\'en Roig, 15 local - 08001 Barcelona<br>T. 93 442 6787<br>F. 93 443 9639<br><a href = \'http://www.intergrid.cat\' >www.intergrid.cat</ a>',
'_KMS_ERP_REPORTS_INVOICE_INVOICE'=>'Invoice',
'_KMS_ERP_REPORTS_INVOICE_FIRST_ADVICE'=>'',
'_KMS_ERP_REPORTS_INVOICE_SECOND_ADVICE'=>'',
'_KMS_ERP_REPORTS_INVOICE_CONTRACT_NUM'=>'Contract N.',
'_KMS_ERP_REPORTS_INVOICE_CONCEPT'=>'Concept',
'_KMS_ERP_REPORTS_INVOICE_IMPORT'=>'Total',
'_KMS_ERP_REPORTS_INVOICE_NOTES'=>'Notes',
'_KMS_ERP_REPORTS_INVOICE_PAYMENT_METHOD'=>'Payment method',
'_KMS_ERP_REPORTS_INVOICE_PAYMENT_DATE'=>'Payment date',
'_KMS_ERP_REPORTS_INVOICE_BANK_ACCOUNT'=>'Bank account',
'_KMS_ERP_REPORTS_INVOICE_BASE'=>'Base',
'_KMS_ERP_REPORTS_INVOICE_VAT'=>'VAT %',
'_KMS_ERP_REPORTS_INVOICE_TOTAL'=>'Total',
'_KMS_ERP_REPORTS_INVOICE_FOOTER'=>'Intergrid, SL, corporation registered in the Commercial Register of Barcelona. Volume 39.209, Folio 53, Sheet B-341613, Inscription 1, CIF: B-64401508',
'_KMS_ERP_REPORTS_INVOICE_REBUT_DOMICILIAT'=>'',
'_KMS_ERP_REPORTS_INVOICE_COMPTE_EMPRESA'=>'ES49 3025 0005 8014 3332 8418',
'_KMS_ERP_REPORTS_INVOICE_BANK_TRANSFER'=>'Bank transfer to account number ',
'_KMS_ERP_PAYMENT_CC_INFO'=>' (Please proceed with the payment logging into the <a href=\"https://control.intergridnetwork.net/?lang=en">Control Panel</a>, under the Invoices section)',
'_KMS_ERP_REPORTS_INVOICE_BANK_CHECK'=>'Bank Check',
'_KMS_ERP_REPORTS_INVOICE_EFECTIU'=>'Cash',
'_KMS_ERP_REPORTS_INVOICE_MAIL_INTRO'=>'Dear customer,',
'_KMS_ERP_REPORTS_INVOICE_EURO'=>'Euros',
'_KMS_ERP_REPORTS_INVOICE_BUDGET_VALID_UNTIL'=>'Budget valid until',
'_KMS_ERP_REPORTS_INVOICE_BANK_CHARGES'=>'Bank charges',
'_KMS_ERP_REPORTS_INVOICE_TERM1_COMUNICATION1'=>'Please note that you currently hold a debt with INTERGRID corresponding to contracted services for your business. Please proceed to regularize your situation making the payment of the following invoice:',
'_KMS_ERP_REPORTS_INVOICE_TERM2_COMUNICATION1'=>'Please note that you still hold a debt with INTERGRID corresponding to contracted services for your business. Because we have still not received any payment notification from you, we contact you again to remaind you that you should proceed to regularize your situation paying the following invoice:',
'_KMS_ERP_REPORTS_INVOICE_RETURNED_PAYMENT_ACCOUNT'=>'Bank Payment account',
'_KMS_ERP_REPORTS_INVOICE_PAYMENT_INSTRUCTIONS'=>'To prevent possible harm that this situation may cause, please make the payment using one of this payment options: <br /><br /> 1. Using the Control Panel, section Invoices. (Secure online payment)<br /><br /> 2. Transfer to the account number [BANK_ACCOUNT] - [CC] with the concept: Payment Invoice Number. [FACT]. Please notify your payment receipt sending to our billing department via email to gestio@intergrid.cat. <br /><br /> If upon receipt of this email, you have already processed the payment of debt, please rescind this communication and apologize for any inconvenience this may have caused.',
'_KMS_ERP_REPORTS_INVOICE_BANK_CHARGE'=>'Returned remittance bank charge',
'_KMS_ERP_REPORTS_INVOICE_RETURNED_TOTAL_PAY'=>'Total Payment',
'_KMS_ERP_REPORTS_INVOICE_RETURNED_PAYMENT_DATE1'=>'Limit date to pay',
'_KMS_ERP_REPORTS_INVOICE_TERM2_COMUNICATION3'=>'We regret to inform you that if in the next 48 hours you still have not regularized your debt, the service will be suspended temporarly, and if past 30 days, this situation persists, we will proceed to the final interruption of service, as well as the corresponding termination of the contract.',
'_KMS_ERP_REPORTS_INVOICE_MAIL_NOTES'=>'* To open this invoice you need <a href=\"http://www.adobe.com/products/acrobat/readstep2_allversions.html\">PDF reader</a> software.<br>',
'_KMS_ERP_REPORTS_INVOICE_CHARGE_NOTE'=>'* Please either make sure that there is enough credit available on your account and let us know, or transfer the amount to our bank account and forward us the banking transaction slip. Failed transactions will cause 12 euros of penalty.'
);
*/

include "/usr/local/kms/lib/dbi/db_localhost_connect.php";

$r=mysqli_query($dblink_local,"SELECT * from kms_sys_lang where const like '_KMS_ERP_%'");
while ($i=mysqli_fetch_assoc($r)) {
	$ca[$i['const']]=$i['ca'];
	$es[$i['const']]=$i['es'];
	$en[$i['const']]=$i['en'];
	$eu[$i['const']]=$i['eu'];

}
$idiomes["ct"]=$ca;
$idiomes["ca"]=$ca;
$idiomes["es"]=$es;
$idiomes["en"]=$en;
$template=$_GET['mod'];


$exit=0;
require_once '/usr/local/kms/mod/erp/reports/download.php';
require_once '/usr/local/kms/lib/mail/geekMail-1.0.php';

if (!function_exists(toup)) { function toup($s) { return htmlentities(strtoupper(html_entity_decode($s))); } }
switch ($_GET['mod']) {
    case "erp_invoices":
	$result = mysqli_query($dblink_local,"SELECT * FROM kms_erp_invoices WHERE id='".$_GET['id']."'");
	if (!$result) {echo "error ".mysqli_error();exit;}
	$document_data = mysqli_fetch_array($result);
	if ($document_data['creation_date']>="2024-04-01") $template="opengea";

	if ($document_data['sr_client']=="0") {
	                        // si no hi ha client associat a factura, error
                        echo "No es pot enviar la factura, factura sense client associat";
                        $geekMail = new geekMail();
                        $geekMail->setMailType('html');
                        $geekMail->from("sistemes@intergrid.cat",'KMS');
                        $geekMail->to("alertes@intergrid.cat");
                        $subject="[KMS ERP] No es pot enviar la factura ".$document_data['number']." - factura sense client associat";
                        $geekMail->subject($subject);
                        $geekMail->message($subject);
                        $geekMail->send();
			$exit=1;
        } else {

	$select = "SELECT * FROM kms_ent_clients t1 INNER JOIN (select * FROM kms_ent_contacts) t2 ON t1.sr_client=t2.id and t2.id='".$document_data['sr_client']."'";
        $result = mysqli_query($dblink_local,$select);
	if (!$result) {echo mysqli_error();exit;}
	$client_data = mysqli_fetch_array($result);
	$type = _KMS_ERP_INVOICE;
        $select =  "select * from kms_ent_contacts where id=".$document_data['sr_client'];
        $result = mysqli_query($dblink_local,$select);
        $entity = mysqli_fetch_array($result);

	if ($client_data['id']=="") {
			echo ("No hi ha contacte associat al client ".$document_data['sr_client']." ({$select}). Assegureu-vos de que estigui donat d\'alta.<br><br>Entitat: <b>".$entity['name'].'</b>');
			}
	$select = "select id from kms_ent_clients where sr_client=".$client_data['id'];
	$result = mysqli_query($dblink_local,$select);
	$client = mysqli_fetch_array($result);
	$client_data['id']=$document_data['sr_client'];
	}
	break;
    case "isp_invoices":
        $result = mysqli_query($dblink_local,"SELECT * FROM kms_erp_invoices WHERE id='".$_GET['id']."'");
        if (!$result) {echo mysqli_error();exit;}
        $document_data = mysqli_fetch_array($result);
	if ($document_data['sr_client']=="0") {
                                // si no hi ha client associat a factura, error
                        echo "No es pot enviar la factura, factura sense client associat";
                        $geekMail = new geekMail();
                        $geekMail->setMailType('html');
                        $geekMail->from("sistemes@intergrid.cat",'KMS');
                        $geekMail->to("alertes@intergrid.cat");
                        $subject="[KMS ERP] No es pot enviar la factura ".$document_data['number']." - factura sense client associat";
                        $geekMail->subject($subject);
                        $geekMail->message($subject);
                        $geekMail->send();
                        $exit=1;
        } else {

        $select = "SELECT * FROM kms_ent_clients t1 INNER JOIN (select * FROM kms_ent_contacts) t2 ON t1.sr_client=t2.id and t2.id='".$document_data['sr_client']."'";
        $result = mysqli_query($dblink_local,$select);
        if (!$result) {echo mysqli_error();exit;}
        $client_data = mysqli_fetch_array($result);
        $type = _KMS_ERP_INVOICE;
        if ($client_data['id']=="") {
                        $select =  "select * from kms_ent_contacts where id=".$document_data['sr_client'];
                        $result = mysqli_query($dblink_local,$select);
                        $entity = mysqli_fetch_array($result);
                        echo ('No hi ha client associat a aquesta entitat ('.$select.'). Assegureu-vos de que estigui donat d\'alta.<br><br>Entitat: <b>'.$entity['name'].'</b>');
                        }
        $select = "select id from kms_ent_clients where sr_client=".$client_data['id'];
        $result = mysqli_query($dblink_local,$select);
        $client = mysqli_fetch_array($result);
        $client_data['id']=$document_data['sr_client'];
	}
        break;

    case "ecom_budgets":
    	$result = mysqli_query($dblink_local,"SELECT * FROM kms_ecom_budgets WHERE id='".$_GET['id']."'");
        if (!$result) {echo mysqli_error();exit;}
        $document_data = mysqli_fetch_array($result);
        $result = mysqli_query($dblink_local,"SELECT * FROM kms_ent_clients t1 INNER JOIN (select * FROM kms_ent_contacts) t2 ON t1.sr_client=t2.id and t1.sr_client='".$document_data['sr_client']."'");
        if (!$result) {echo mysqli_error();exit;}
        $client_data = mysqli_fetch_array($result);
        $type = _KMS_ERP_BUDGET;
        break;
    default:
	die ("Report type '".$_GET['mod']."' not valid or not defined");
}

$case=false;
if ($client_data['language']=="ct"||$client_data['language']=="") $client_data['language']="ca";
$cl=$client_data['language']; //abreviat
include "/usr/local/kms/lang/".strtolower($client_data['language']).".php"; //no es efectiu, no es poden redefinir constants

// recuperem dades d'empresa propia
$result = mysqli_query($dblink_local,"SELECT * FROM kms_ent_clients where id='1'");
if (!$result) {echo mysqli_error();exit;}
$self_data = mysqli_fetch_array($result);
// recuperem metode de pagament
$result = mysqli_query($dblink_local,"SELECT payment_name,bank_charges FROM kms_ecom_payment_methods where id='".$document_data['payment_method']."'");if (!$result) {echo mysqli_error();exit;} $payment_method_name = mysqli_fetch_array($result);

// determinem email destinatari
if ($client_data['billing_email']!="") { $email_address = $client_data['billing_email']; 
				       } else {  $email_address =  $client_data['email']; }

include "/usr/local/kms/mod/erp/reports/lang/".strtolower($client_data['language']).'.php';

$top_headers="<link REL=\"STYLESHEET\" TYPE=\"text/css\" HREF=\"https://intranet.intergrid.cat/kms/mod/erp/reports/report2.css?k=".date('YmdHis')."\" Title=\"css\">";

error_reporting(0);
ini_set('display_errors', 0);

function chmod_r($path, $mode) {
    if (!is_dir($path)) {
        return chmod($path, $mode);
    }

    $dir = new DirectoryIterator($path);
    foreach ($dir as $file) {
        if ($file->isFile()) {
            chmod($file->getPathname(), $mode);
        } elseif (!$file->isDot() && $file->isDir()) {
            chmod_r($file->getPathname(), $mode);
        }
    }
    return chmod($path, $mode);
}

function formatMonetari($amount) {
    return number_format($amount, 2, ',', '.');
}

// preparem factura pe enviar o descarregar en PDF
if ($_GET['action']=="get_pdf"||$_GET['action']=="email_invoice") {
	ob_start();
	eval('?>' . file_get_contents('/usr/local/kms/mod/erp/reports/tpl/headers.php') . '<?');

	$headers = ob_get_contents();
	ob_end_clean();
	ob_start();
	eval('?>' . file_get_contents('/usr/local/kms/mod/erp/reports/tpl/'.$template.'.php') . '<?');

	$report = ob_get_contents();
	ob_end_clean();
	$rpt = $top_headers.$report;
	$save_path="/tmp/";
	$save_path="/var/www/vhosts/intergrid.cat/subdomains/data/httpdocs/files/tmp/invoices/";
/*if (chmod_r($save_path, 0777)) {
    echo "Els permisos s'han canviat correctament.";
} else {
    echo "Hi ha hagut un problema en canviar els permisos.";
}*/

//	echo $save_path.$document_data['number'].'.html';
	$fp = fopen($save_path.$document_data['number'].'.html', 'w');
	if (!$fp) die ("[report.php] Error: Can't write on ".$save_path);

	$result_fp=fwrite($fp, $rpt);
	if (!$result_fp||!file_exists($save_path.$document_data['number'].'.html')) die ("Can not write to ".$save_path); 
	if ($result_fp) {

	$out= exec('/usr/bin/wkhtmltopdf -s A4 --margin-left 0 --margin-right 0 --margin-top 0 --zoom 2.9 '.$save_path.$document_data['number'].'.html '.$save_path.$document_data['number'].'.pdf  2>&1');
	//if ($out!="[> ] Done")  echo "<br>{$out}<br>";
	set_time_limit(0);
	$file_path=$save_path.$document_data['number'].'.pdf';
	if(!is_readable($file_path)) die('[report.php] File '.$file_path.' not found or inaccessible!');
	if ($_GET['action']=="get_pdf") {
		
	// descarreguem factura
	// output_file($file_path,$document_data['number'].'.pdf'); //enviem fitxer per descarregar
	echo "<iframe width=200 height=20 frameborder=0 src='/kms/mod/erp/reports/direct_download.php?file=".$file_path."&name=".$document_data['number'].".pdf'></iframe>";

	} else {

	//enviem per email
/*	if ($document_data['payment_method']=="3"&&$client_data["bank_accountNumber"]=="") {
			// si no hi ha compte bancari, enviem alerta 
			echo "No es pot enviar la factura '".$document_data['number']."' mp:".$document_data['payment_method'].", client sense compte bancari definit"; 
			$exit=1;
			$subject="[KMS ERP] No es pot enviar la factura '".$document_data['number']."' ".$document_data['payment_method']." - compte bancari no definit";
			$from="sistemes@intergrid.cat";
			$headers = "Date: ".date('r')."\nFrom: <".$from.">\nMIME-
			Version: 1.0\nContent-type: text/html; charset=UTF-8\n";
			$to="alertes@intergrid.cat";
			$body=$subject;
			$sent = mail($to,$subject,utf8_encode(html_entity_decode(htmlentities($body))),$headers);
	}	
*/
	if ($exit!=1) {
	
	// seleccio de destinatari
	if (($_POST['checksendmail2']=="") and ($_POST['checksendcc2'] =="")) {
	print_r('<br><hr><br>No hi ha seleccionat cap destinatari ');print_r('<br><br>');
	print_r('<a href="#" onClick="window.history.go(-2)>Clic aqu&iacute; per tornar</a>');
	exit; 
	}

	if ($_POST['destiny']=="") { $destiny=$_POST['destiny']=$email_address; }
       	if (($_POST['checksendmail2'] !="") and ($_POST['destiny'] !="")) { $destiny=($_POST['destiny']); }
	$destinycc=($_POST['destiny_cc']);

	ob_start(); //email template
	eval('?>' . file_get_contents('/usr/local/kms/mod/erp/reports/tpl/email_'.$template.'.php') . '<?');
	$bodymes = ob_get_contents();
	ob_end_clean();

	//substituim variables en el cos del missatge
	$self_data['bank_accountNumber']=implode(' ',str_split($self_data['bank_accountNumber'],4));

	$search_strings = array("[BANK_ACCOUNT]","[CC]","[DATE]","[FACT]");
	$replace_strings = array($self_data['bank_name'],$self_data['bank_accountNumber'],date('d-m-Y'),$document_data['number']);	   
	$bodymes = str_replace($search_strings,$replace_strings,$bodymes);	
	$bodymes = str_replace("[CUSTOM_MSG]",$_POST['emailBody']."<br><br>",$bodymes);

// cos de l'email
/*
if ($_POST['type']=="invoice")  {
	//seleccionem plantilla
	if (($document_data['payment_method']!="11"&&$document_data['payment_method']!="3")) {
	        $placeholder="_KMS_NEW_INVOICE_BODY_".strtoupper($document_data['logo'])."_TRANSFER";
	} else {
		$placeholder="_KMS_NEW_INVOICE_BODY_".strtoupper($document_data['logo']);
	}
	$bodymes = constant($placeholder);
}
*/
if ($entity['contacts']) $customer=$entity['contacts']; else $customer=$entity['name'];


$bodymes = str_replace("[CUSTOMER]",$customer,$bodymes);
$bodymes = str_replace("[INVOICEID]",$document_data['number'],$bodymes);
$bodymes = str_replace("[AMOUNT]",formatMonetari($document_data['total']),$bodymes);

if ($document_data['payment_method']=="11") $pm=_KMS_ERP_PAYMENTM_CREDITCARD;
else if ($document_data['payment_method']=="3") $pm=_KMS_ERP_PAYMENTM_DOMICILIACIO;
else { 
	$pm=_KMS_ERP_PAYMENTM_TRANSFER;
}
$bodymes = str_replace("[PAYMENT_METHOD]",$pm,$bodymes);
//	if (!$silent) echo $bodymes;
	$geekMail = new geekMail();
	$geekMail->setMailType('html');
	$fact="Factura";
	if ($client_data['language']=="es") $from_email = "gestion@intergrid.es"; else $from_email = "gestio@intergrid.cat";
	$name_from="Intergrid";
	if ($client_data['language']=="en") { $fact="Invoice"; } 

	if ($document_data['logo']=="opengea") { $from_email="oficina@opengea.org"; $name_from="Opengea SCCL"; }
	
	$geekMail->from($from_email,$name_from); // agafar l'email i el nom d'usuari de la sessió?

 	$destinataris=explode(",",$destiny);
//	$geekMail->to($destiny);
	$n_=0;
	foreach ($destinataris as $destinatari) {
		if ($n_==0) $geekMail->to(trim($destinataris[0])); else $geekMail->cc(trim($destinataris[$n_])); 
		$n_++;
	}
//	if ($destinycc!="") { $geekMail->cc($destiny_cc); }
	if (defined($type)) $type=constant($type);
	if ($_POST['subject']=="") $_POST['subject']=$subject=$name_from." - ".$fact." Num. ".$document_data['number'];
	$geekMail->subject($_POST['subject']);
	// $geekMail->message($_POST['emailBody']); //html?
	$geekMail->message($bodymes);
	$geekMail->attach($file_path);
date_default_timezone_set('Europe/Brussels');
//error_reporting( E_ALL );
	if (!$geekMail->send())
	{
	  $errors = $geekMail->getDebugger();
	  print_r($errors);
	}

	if (!$silent) echo "<br><hr><br>";
	$_POST['subject']="";$_POST['destiny']=""; //inicialitzem pel seguent
        print_r('Email enviat correctament a '.$destiny);
        if (isset($destinycc)) { print_r(' amb copia a '.$destinycc); $sendedto=$destiny.",".$destinycc; }
        else { $sendedto=$destiny; }
        if (!$silent) { echo '<br><a href="#" onClick=self.close()>Clic aqu&iacute; per tancar la finestra</a><br><br>'; }

        //esborrem fitxers temporals
        //exec('/bin/rm /tmp/'.$document_data['number'].'.html');
        //exec('/bin/rm /tmp/'.$document_data['number'].'.pdf');

                switch ($_POST['type'])
                {
                case "invoice":
                $tipus="1";
		$add_update="";
                break;

                case "terminator1":
                $tipus="2";
		$add_update=",status='impagada'";
                break;

                case "terminator2":
                $tipus="3";
		$add_update=",status='impagada'";
                break;

                case "pending_pm":
                $tipus="4";
                $add_update="";
                break;

                }


        // modifiquem data i email d'enviament a la base de dades de factures
        $result = mysqli_query($dblink_local,"UPDATE kms_".$_GET['mod']." SET sent_email='".$sendedto."',sent_date='".date('Y-m-d H:i:s')."',check_sent=1{$add_update} WHERE id='".$_GET['id']."'");
        if (!$result) {echo mysqli_error();exit;}

        // afegim al log d'enviaments

        $result = mysqli_query($dblink_local,"INSERT into kms_erp_invoices_sending_log (type,sent_to,sent_cc,sent_date,sr_client,sr_invoice,number,total,payment_method,payment_date) values ('".$tipus."','".$destiny."','".$destinycc."','".date('Y-m-d H:i:s')."','".$document_data['sr_client']."','".$document_data['id']."','".$document_data['number']."','".$document_data['total']."','".$document_data['payment_method']."','".$document_data['payment_date']."')");
        if (!$result) {echo mysqli_error();exit;}


	} // if !exit

	} // enviem per email
	
	} // if fwrite

} // pdf generat


if (!$silent) { 
echo $top_headers;
        $name_from="Intergrid";
        if ($document_data['logo']=="opengea") { $from_email="oficina@opengea.org"; $name_from="Opengea SCCL"; }

?>
<div>
<div class="rpt_controller" id="rpt_controller">
<div class="rpt_controller_form" id="rpt_controller_form" style="display:none">
<form action="/?_=f&id=<?=$_GET['id']?>&app=accounting&mod=<?=$_GET['mod']?>&action=email_invoice" method="post"  name="sendMailForm" target="_self" class="sendMailForm" id="sendMailForm" dir="ltr" lang="<?=$client_data['language']?>">
<input type="hidden" name="type" value="invoice"> 
<table class="rpt_form_table" id="report_form_table">
<tr>
    <td colspan="6"><b>Introduir dades d'enviament</b></td>
  </tr>
  <tr>
    <td>Tipus:</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<select name="type" id="type" onChange="updateSubject(this.value)">
      <option value="invoice">Notificaci&oacute; factura</option>
      <option value="terminator1">1er Terminator</option>
      <option value="terminator2">2on Terminator</option>
      <option value="pending_pm">Requerit ajustament mètode de pagament</option>
    </select></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Destinatari:</td>
    <td><input type="checkbox" name="checksendmail2" id="checksendmail2" checked="checked">
&nbsp;
<input type="text" name="destiny" id="destiny" value="<?=$email_address?>"></td>
    <td>Assumpte:</td>
<? $subject=$name_from." - ".$fact." Num. ".$document_data['number'];?>  
  <td><input type="text" size="45" name="subject" id="subject" value="<?=$subject?>"></td>
    <td>&Uacute;ltim enviament a:</td>
    <td><?=$document_data['sent_email']?></td>
  </tr>
  <tr>
    <td>Enviar co&ograve;pia a:</td>
    <td><input type="checkbox" name="checksendcc2" id="checksendcc2">
&nbsp;
<input type="text" name="destiny_cc" id="destiny_cc" value="gestio@intergrid.cat"></td>
    <td>Cos de missatge:</td>
    <td><textarea name="emailBody" id="emailBody" cols="40" rows="4"></textarea></td>
    <td>Amb data:</td>
    <td><?if (date('Y',strtotime($document_data['sent_date']))!="1999") {
		 echo date('d-m-Y',strtotime($document_data['sent_date']))?> a les&nbsp; <?=date('H:i:s',strtotime($document_data['sent_date']));
	}?>
    </td>
  </tr>
  <tr>
    <td><input class="customButton highlight big" type="submit" name="submit" id="submit" value="Enviar"></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</form>
<hr></div>
<div class="rpt_controller_buttons" id="rpt_controller_buttons">
<a href="#" onclick="$('#rpt_controller_form').toggle();refreshUI();"><img src="/kms/mod/erp/reports/img/email.png" width="35" height="35" border="0" title=<?=_KMS_ERP_RPT_SENDMAIL?>></a>&nbsp;<a href="/?_=f&id=<?=$_GET['id']?>&app=accounting&mod=<?=$_GET['mod']?>&action=get_pdf"><img src="/kms/mod/erp/reports/img/pdf.png" width="35" height=35 border="0" title="<?=_KMS_ERP_RPT_GENERATEPDF?>" widht=50></a>
</div>
</div>
<?
$pages_processed="";
$last_line=0;
$template=$_GET['mod'];
if ($document_data['creation_date']>="2024-04-01") $template="opengea";

$file='/usr/local/kms/mod/erp/reports/tpl/'.$template.'.php';
if (!file_exists($file)) die ("Template not found : ".$file);
ob_start();
eval('?>' . file_get_contents($file) . '<?');
$report = ob_get_contents();
ob_end_clean();
echo utf8_encode($report);
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
	document.sendMailForm.subject.value = "Intergrid - <?=$type?> <?=_KMS_GL_NUM?> <?=$document_data['number']?>"
	break;
	case 'terminator1':
	document.sendMailForm.subject.value = "<?=html_entity_decode(_KMS_ISP_TERMINATOR_1)?> - <?=$type?> <?=html_entity_decode(_KMS_GL_NUM)?> <?=$document_data['number']?>"
	break;
	case 'terminator2':
	document.sendMailForm.subject.value = "<?=html_entity_decode(_KMS_ISP_TERMINATOR_2)?> - <?=$type?> <?=html_entity_decode(_KMS_GL_NUM)?> <?=$document_data['number']?>"
	break;
        case 'pending_pm':
	document.sendMailForm.subject.value = "<?=html_entity_decode(_KMS_ISP_PENDING_PM)?>"
	break;
	}
}
</script>
</div>
</body>
<? } // if !silent ?>
