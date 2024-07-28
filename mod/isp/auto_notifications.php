#!/usr/bin/php -q
<?php
// Avisa als clients que tenen factures pendents, envia terminators automatics ...
exit;

include "/usr/local/kms/lib/dbi/db_localhost_connect.php";
include "/usr/local/kms/lib/include/functions.php";
include '/usr/local/kms/lib/mail/email.class.php';

$now=date('Y-m-d H:i:s');
echo "Initiation auto notifications on ".date('d-m-Y H:i:s')."...\n";

                
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
$headers .= 'From: Intergrid SL <support@intergrid.cat>' . "\r\n";

// OVER QUOTA --------------------------------
/*
$select="SELECT * FROM kms_isp_hostings_vhosts WHERE total_used_space>max_space";
$result_=mysqli_query($link,$select);
if (!$result_) die(mysqli_error($result_).$select);
$subject="Dominis per sobre de limits";
while ($vhost=mysqli_fetch_array($result_)) {
$body.=$vhost['name']."\n";

}
$email = new Email("kms@intergrid.cat", "alertes@intergrid.cat", $subject, $body, 0);
$goodemail = $email->send();
if (!$goodemail) echo "[auto_notifications] Email notification failed";
*/
// factures que fa mes de 4 dies que estan pendents de pagament i no estan marcades com impagades
//$select="SELECT * FROM kms_erp_invoices WHERE (status='pendent' or status='impagada') and payment_date>'".date('Y-m-d',strtotime('-20 days'))."' and payment_date<'".date('Y-m-d',strtotime('-4 days'))."'";
$select="SELECT * FROM kms_erp_invoices WHERE (status='pendent' or status='impagada') and payment_date<'".date('Y-m-d',strtotime('-4 days'))."' and order by payment_date desc";
$result_=mysqli_query($link,$select);
if (!$result_) {echo "ERROR ".mysqli_error().$select; exit; }
while ($invoice=mysqli_fetch_array($result_)) {
        $sel="select * from kms_ent_clients where sr_client=".$invoice['sr_client'];
        $res=mysqli_query($link,$sel);
        $client=mysqli_fetch_array($res);
        $sel="select * from kms_ent_contacts where id=".$invoice['sr_client'];
        $res=mysqli_query($link,$sel);
        $contact=mysqli_fetch_array($res);
        $language=strtolower($contact['language']);
        if ($language=="ct") $language="ca";

        $name=$contact['contacts'];
        if ($language=="ca") {
        $body="Benvolgut client,<br><br>Us notifiquem que recentment, el dia ".date('d-m-Y',strtotime($invoice['payment_date'])).", va v&egrave;ncer el pla&ccedil; de pagament de la factura ".$invoice['number']." per import <b>".$invoice['total']."&euro;</b> i no ens consta haver rebut el pagament corresponent. Aix&iacute; doncs, us preguem que regularitzeu la vostra situaci&oacute; procedint a realitzar el pagament de la seg&uuml;ent factura: <br><br>Factura: <strong>".$invoice['number']."</strong><br>Client: <strong>".$contact['name']."</strong><br>Data d'emissi&oacute;: <strong>".date('d-m-Y',strtotime($invoice['creation_date']))."</strong><br>Venciment: <strong>".date('d-m-Y',strtotime($invoice['payment_date']))."</strong><br>Import total: <strong>".$invoice['total']." &euro;</strong><br><br>Per tal d'evitar possibles perjudicis que la present situació pugui ocasionar, preguem feu el pagament de l'import pendent el m&eacute;s aviat possible mitjan&ccedil;ant qualsevol d'aquestes opcions:<br><br>1. Mitjan&ccedil;ant pagament segur amb targeta de cr&egrave;dit o PayPal des de l'apartat Factures de l'&Agrave;rea de Client <a href='https://www.intergrid.cat/clients'>https://www.intergrid.cat/clients</a><br>2. Mitjan&ccedil;ant transfer&egrave;ncia banc&agrave;ria al n&uacute;mero de compte <strong>ES48 2100 3264 0122 0011 9765</strong> amb el concepte: '<strong>".$invoice['number']."</strong>' i enviant el justificant a gestio@intergrid.cat<br><br>Si en el moment de la recepci&oacute; d'aquest comunicat, hagu&eacute;ssiu processat ja el pagament del deute, preguem deixeu sense efecte aquest comunicat.<br><br>Tamb&eacute; us recordem que podeu canviar la forma de pagament des de l'apartat dades de client.<br><br>Ben cordialment,<br><br>Intergrid SL<br>gestio@intergrid.cat<br>Facturaci&oacute; i comptabilitat<br>Tel. +34 934 426 787<br><a href='https://www.intergrid.cat'>www.intergrid.cat</a>";
        $subject="Factura pendent ".$invoice['number']." recordatori";
        $from="gestio@intergrid.cat";
        } else if ($language=="es") {
        $body="Apreciado cliente,<br><br>Le notificamos que recientemente, el d&iacute;a ".date('d-m-Y',strtotime($invoice['payment_date'])).", finaliz&oacute; el plazo de pago de la factura <b>".$invoice['number']."</b> de importe <b>".$invoice['total']."&euro;</b> y no nos consta su pago correspondiente. En consecuencia, les rogamos que regularizen su situaci&oacute;n procediendo a realizar el pago de la factura:<br><br>Factura: <strong>".$invoice['number']."</strong><br>Cliente: <strong>".$contact['name']."</strong><br>Fecha de emisi&oacute;n: <strong>".date('d-m-Y',strtotime($invoice['creation_date']))."</strong><br>Vencimiento: <strong>".date('d-m-Y',strtotime($invoice['payment_date']))."</strong><br>Importe total: <strong>".$invoice['total']." &euro;</strong><br><br>A fin de evitar posibles perjuicios que la presente situaci&oacute;n pudiera generar, le rogamos que realicen el pago lo antes posible mediante una de estas opciones:<br /><br /> 1. Mediante pago seguro por tarjeta de cr&eacute;dito o PayPal a trav&eacute;s del apartado Facturas del &Aacute;rea de Cliente: <a href='https://www.intergrid.es/clientes'>www.intergrid.es/clientes</a><br /><br /> 2. Mediante transferencia bancaria al n&uacute;mero de cuenta <strong>ES48 2100 3264 0122 0011 9765</strong>  indicando como concepto '<strong>".$invoice['number']."</strong>' y enviando el justificante bancario a gestion@intergrid.es<br /> <br /> Si en el momento de la presente comunicaci&oacute;n, usted ya hubiera procedido al pago de la deuda, rogamos deje sin efecto este escrito.<br><br>Tambi&eacute;n les recordamos que pueden escoger una forma de pago alternativa desde el apartado 'datos de cliente' del &Aacute;rea de Cliente. <br><br>Cordialmente,<br><br>Intergrid SL<br>gestion@intergrid.es<br>Facturaci&oacute;n y contabilidad<br>Tel. +34 934 426 787<br><a href='https://www.intergrid.es'>www.intergrid.es</a>";
        $subject="Factura pendiente ".$invoice['number']." recordatorio";
        $from="gestion@intergrid.es";
        } else {
        $body="Dear customer,<br><br>The invoice <b>".$invoice['number']."</b> for <b>".$invoice['total']."&euro;</b> recently (".date('Y-m-d',strtotime($invoice['payment_date'])).") become overdue for payment.  As such, we would appreciate you making this payment as soon as possible.<br><br>To proceed with payment please log into the <a href='https://control.intergridnetwork.net/?lang=en'>Intergrid Client Area</a> and under the invoices tab, click over the payment option icon next to the open invoices.<br><br>Alternatively you can make a wire transfer to our bank account ES4821003264012200119765 specifiing ".$invoice['number']." as reference. If there is an error on our part and payment has been made, please contact us immediately so that the matter can be rectified.<br><br>if you want to change the payment method, we're happy to discuss an alternative solution for payment so that we can prevent this from happening in future.<br><br>Yours sincerely,<br><br>Intergrid SL<br>support@intergrid.cat<br>Accounting<br><a href='www.intergrid.cat/en'>www.intergrid.cat</a>";
        $subject="Open invoice ".$invoice['number']." reminder";
        $from="support@intergrid.cat";
        }
        $to=trim($client['email']);
        if ($to=="") $to=trim($client['billing_email']);
        $to_=$to;
        $from="support@intergrid.cat";
        $to="alertes@intergrid.cat";
        $subject.=" ".$to_;
        echo $subject."\n";
        $body="<span style='font-family:monospace;font-size:12px'>".$body."</span>";
        mail($to, $subject, $body, $headers, "-f {$from}");

	//if not rebut no enviat	
	if ($invoice['payment_method']!='3'&&$invoice['payment_method']!='4'&&$invoice['payment_method']!='5'&&$invoice['payment_method']!='6'&&$invoice['payment_method']!='7'&&$invoice['payment_method']!='9'&&$invoice['sr_remittance']!='0') {
        $update="update kms_erp_invoices set status='impagada' where id=".$invoice['id'];
        $res=mysqli_query($link,$update);
	}

}

//set old pending invoices to impagades
$update="update kms_erp_invoices set status='impagada' where status='pendent' and payment_date<'".date('Y-m-d',strtotime('-20 days'))."'";
$res=mysqli_query($link,$update);

// T-1 a GESTIO --------------------------------
echo "AVIS TERMINATOR 2...\n";
// factures impagades desde fa 10 dies
$select="select * from kms_erp_invoices WHERE (status='impagada') AND status_terminator=0 AND NOW() BETWEEN DATE_ADD(payment_date,INTERVAL 30 DAY) AND NOW() order by sr_client";

$select="SELECT * FROM kms_erp_invoices WHERE (status='impagada') and status_terminator!=0 order by sr_client";

$result_=mysqli_query($link,$select);
if (!$result_) die(mysqli_error($result_).$select);
$resum="";
while ($invoice=mysqli_fetch_array($result_)) {
        //send notificacio per terminator 1
        $sel="select * from kms_ent_clients where sr_client=".$invoice['sr_client'];
        $res=mysqli_query($link,$sel);
        $client=mysqli_fetch_array($res);        
	$sel="select * from kms_ent_contacts where id=".$invoice['sr_client'];
        $res=mysqli_query($link,$sel);
        $contact=mysqli_fetch_array($res);

        if (!$res) die(mysqli_error($res));
        $subject="Enviar Terminator a ".$contact['name']." (Factura ".$invoice['number'].")";
	echo $subject."\n";
        $assigned="2"; // gestio
/*        //comprovem que no haguem enviat ja la tasca
        $tmp_sel="select * from kms_planner_tasks where description=\"{$subject}\" and assigned=\"{$assigned}\"";
        $tmp_res=mysqli_query($link,$tmp_sel);
        $tmp_job=mysqli_fetch_array($tmp_res);
        if ($tmp_job['description']=="") {
        $notes="Em sembla que cal enviar un Terminator 1 per la factura ".$invoice['number']." del client #".$invoice['sr_client']."<br><br><br>--Intergrid KMS<br>www.intergrid.cat";
        $insert="insert into kms_planner_tasks (origin,status,priority,creation_date,category,assigned,description,notes,sr_client,start_date,final_date) VALUES ('Terminator','pendent',1,'{$now}','4-gestio','{$assigned}','".$subject."','".$notes."','{$invoice['sr_client']}','{$now}','{$now}')";
        $result2=mysqli_query($link,$insert);
        if (!$result2) die(mysqli_error($result2).$insert);
        }*/
	$body=$invoice['number']." (".$invoice['payment_date'].")<br><br><br><br><br>Intergrid SL<br>gestio@intergrid.cat<br>Facturaci&oacute; i comptabilitat<br>Tel. +34 934 426 787<br><a href='https://www.intergrid.cat'>www.intergrid.cat</a>";
	$to=trim($client['email']);
        if ($to=="") $to=trim($client['billing_email']);
        $to_=$to;
        $from="gestio@intergrid.cat";
        $to="alertes@intergrid.cat";
        $resum.="<strong>".$contact['name']."</strong> Factura ".$invoice['number']." <strong>".$invoice['total']."&euro; </strong>(".$invoice['payment_date'].") <a href='mailto:".$to_."'>{$to_}</a> Tel. ".$client['phone']."<br>\n";
	$body="<span style='font-family:monospace;font-size:12px'>".$body."</span>";
//        mail($to, $subject, $body, $headers, "-f {$from}");
}
$resum="<span style='font-family:monospace;font-size:12px'>".$resum."</span>";
mail($to, "*** RESUM IMPAGATS A RECLAMAR ***",$resum, $headers, "-f {$from}");

exit;


// ------------------------------
/*
echo "Sending Terminators 2 to morosos...<br>";

$select="select * from kms_erp_invoices WHERE status!='cobrat' AND status!='anulat' AND status_terminator=1 AND NOW() BETWEEN DATE_ADD(sent_date, INTERVAL 5 DAY) AND NOW()";
$result_=mysqli_query($link,$select);
if (!$result_) die(mysqli_error($result_).$select);
while ($invoice=mysqli_fetch_array($result_)) {
	//send terminator 2
	$sel="select * from kms_isp_clients where sr_client=".$invoice['sr_client'];
	$res=mysqli_query($link,$sel);
	$client=mysqli_fetch_array($res);
	echo "Sending T2 to client ".$invoice['sr_client']." (invoice ".$invoice['number'].")\n";
	$_GET['mod']="erp_invoices";
	$_GET['id']=$invoice['id'];
	$_GET['action']="email_invoice";
	$_POST['type']="terminator1";
	if ($client['language']=="ct") $client['language']="ca";
	$sel = "SELECT ".$client['language']." FROM kms_sys_lang WHERE const='_KMS_ISP_TERMINATOR_2'";
	$res2=mysqli_query($link,$sel);
	$txt=mysqli_fetch_array($res2);
	$_POST['subject']=$txt[0];
	$_POST['destiny']=$client['email'];
	$_POST['destiny_cc']="gestio@intergrid.cat";
	$_POST['checksendmail2']=$client['email'];
	$_POST['checksendcc2'] ="gestio@intergrid.cat";
	$update="update  kms_erp_invoices SET status_terminator=2 WHERE id=".$invoice['id'];
        mysqli_query($link,$update);
	include "/usr/local/kms/mod/erp/reports/report.php";
}
*/

/*
// ------------------------------
echo "Blocking services to what still have not responded after T2...\n";

$select="select * from kms_erp_invoices WHERE status!='cobrat' AND status!='anulat' AND status_terminator=2 AND NOW() BETWEEN DATE_ADD(sent_date, INTERVAL 2 DAY) AND NOW()";    
$result_=mysqli_query($link,$select);
if (!$result_) die(mysqli_error($result_).$select);
while ($invoice=mysqli_fetch_array($result_)) {
	$update="update  kms_erp_invoices SET status_terminator=3 WHERE id=".$invoice['id'];
        mysqli_query($link,$update);
	$assigned="2"; // gestio
	$subject="Bloqueig de serveis associats a factura ".$invoice['number'];
	$notes="Bloquejar serveis associats a la factura ".$invoice['number']." del client #".$invoice['sr_client']."\n<br>Per fer-ho entreu al contracte o contractes corresponents i poseu-los en estat BLOQUEJAT<br><br>--Intergrid KMS<br>www.intergrid.cat";
//comprovem que no haguem enviat ja la tasca
        $tmp_sel="select * from kms_planner_tasks where description=\"{$subject}\" and assigned=\"{$assigned}\"";
        $tmp_res=mysqli_query($link,$tmp_sel);
        $tmp_job=mysqli_fetch_array($tmp_res);
        if ($tmp_job['description']=="") {
	echo "Creating task to block services of client ".$invoice['sr_client']." (invoice ".$invoice['number'].")<br>";
	$insert="insert into kms_planner_tasks (origin,status,priority,creation_date,category,assigned,description,notes,sr_client,start_date,final_date) VALUES ('Terminator','pendent','1','{$now}','4-gestio','{$assigned}','".$subject."','".$notes."','{$invoice['sr_client']}','{$now}','{$now}')";
	$result2=mysqli_query($link,$insert);
        if (!$result2) die(mysqli_error($result2).$insert);	
	}
}
*/

// ------------------------------
echo "Proceding to cancel services and contracts after 30 days...\n";

$select="select * from kms_erp_invoices WHERE status!='cobrat' AND status!='anulat' AND status_terminator=3 AND NOW() BETWEEN DATE_ADD(sent_date, INTERVAL 30 DAY) AND NOW()"; 
$result_=mysqli_query($link,$select);
if (!$result_) die(mysqli_error($result_).$select);
while ($invoice=mysqli_fetch_array($result_)) {
	$update="update  kms_erp_invoices SET status_terminator=4 WHERE id=".$invoice['id'];
	mysqli_query($link,$update);
        echo "Cancel services of client ".$invoice['sr_client']." (invoice ".$invoice['number'].")\n";
	$subject="Donar de baixa (eliminar) contractes de la factura ".$invoice['number'];
	$assigned="1"; // j.berenguer
	$notes="Donar de baixa serveis associats a la factura ".$invoice['number']." del client #".$invoice['sr_client']."<br><br>Per fer-ho entreu al contracte o contractes corresponents i poseu-los en estat FINALITZAT. Si es necessari completeu la baixa de serveis de forma manual.<br><br>--Intergrid KMS<br>www.intergrid.cat";

        $tmp_sel="select * from kms_planner_tasks where description=\"{$subject}\" and assigned=\"{$assigned}\"";
        $tmp_res=mysqli_query($link,$tmp_sel);
        $tmp_job=mysqli_fetch_array($tmp_res);
        if ($tmp_job['description']=="") {
	
        $insert="insert into kms_planner_tasks (origin,status,priority,creation_date,category,assigned,description,notes,sr_client,start_date,final_date) VALUES ('Terminator','pendent','1','{$now}','6-sysadmin','{$assigned}','".$subject."','".$notes."','{$invoice['sr_client']}','{$now}','{$now}')";
        $result2=mysqli_query($link,$insert);
        if (!$result2) die(mysqli_error($result2).$insert);

	}
}

echo "done.\n\n";

?>
