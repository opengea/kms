<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<? // <meta http-equiv="content-type" content="text/html; charset=iso-8859-1">  ?>
</head>
<body bgcolor="#ffffff" text="#000000">
<font style="font-family:monospace;font-size:12" >
<div class="moz-text-html" lang="x-western">
<?

 switch ($_POST['type']) {
 case "invoice": ?>
	<? 
	// Enviament de factura per email --------------

	//recuperem metode de pagament
	$select = "SELECT payment_name FROM kms_ecom_payment_methods WHERE id='".$document_data['payment_method']."'";
        $result = mysql_query($select);
	$payment_name = mysql_fetch_array($result);
	?>
	<? if ($_POST['emailBody']!="") { echo "<br><br>".htmlentities($_POST['emailBody'])."<br><br>"; } //else { ?>
	<?=_KMS_ERP_REPORTS_INVOICE_BILLING_COMUNICATION?><br><br>
	<?=_KMS_ERP_REPORTS_INVOICE_INVOICE."&nbsp;"._KMS_ERP_REPORTS_INVOICE_NUM.": ".$document_data['number']?><br>
	<?=_KMS_ERP_REPORTS_INVOICE_BILLING_CLIENT."&nbsp;:&nbsp;".$client_data['name']?><br>
	<?=_KMS_ERP_REPORTS_INVOICE_BILLING_NIF."&nbsp;:&nbsp;".$client_data['cif']?><br>
	<?=_KMS_ERP_REPORTS_INVOICE_CREATION_DATE.": ".date( "d-m-Y", strtotime($document_data['creation_date']))?><br>
	<?=_KMS_ERP_REPORTS_INVOICE_TOTAL.": ".$document_data['total']."&nbsp;"._KMS_ERP_REPORTS_INVOICE_EURO." "._KMS_ERP_REPORTS_INVOICE_TAX_INCLUDED?><br>
	<?=_KMS_ERP_REPORTS_INVOICE_PAYMENT_METHOD.": ".constant($payment_name['payment_name'])?><br>
	<?=_KMS_ERP_REPORTS_INVOICE_PAYMENT_DATE.": ".date( "d-m-Y", strtotime($document_data['payment_date']))?><br><br>
	<br>
	<? if ($document_data['payment_method']=="3") echo _KMS_ERP_REPORTS_INVOICE_BILLING_VENCIMENT1."&nbsp;XXXX-XXXX-XX-XXXXXX".substr($client_data['bank_accountNumber'],-4)."&nbsp;"._KMS_ERP_REPORTS_INVOICE_BILLING_VENCIMENT2.date('d-m-Y',strtotime($document_data['payment_date']));?>
	 <? if ($document_data['payment_method']=="3") echo "<br>".report_mail_billing_nota_carrecrebut; ?>
	<br><br><br>
	<? // } ?>
	<?=report_mail_billing_notes?>
	<br>
	<br>
	<?=report_mail_billing_signature?>
	<?
	break;
	
	case "terminator1":
	// Avis d'impagament ---------------------------------
	
        //recuperem metode de pagament
        $select = "SELECT payment_name FROM kms_ecom_payment_methods WHERE id='".$document_data['payment_method']."'";
        $result = mysql_query($select);
        $payment_name = mysql_fetch_array($result);
        ?>
        <? if ($_POST['emailBody']!="") { echo htmlentities($_POST['emailBody'])."<br><br>"; } else { ?>
        <?=_KMS_ERP_REPORTS_INVOICE_MAIL_INTRO?><br><br>
        <?=_KMS_ERP_REPORTS_INVOICE_TERM1_COMUNICATION1?><br>
        <?=_KMS_ERP_REPORTS_INVOICE_INVOICE."&nbsp;"._KMS_ERP_REPORTS_INVOICE_NUM.": ".$document_data['number']?><br>
        <?=_KMS_ERP_REPORTS_INVOICE_BILLING_CLIENT."&nbsp;:&nbsp;".$client_data['name']?><br>
	<?=_KMS_ERP_REPORTS_INVOICE_BILLING_NIF."&nbsp;:&nbsp;".$client_data['cif']?><br>
	<?=_KMS_ERP_REPORTS_INVOICE_CREATION_DATE.": ".date( "d-m-Y", strtotime($document_data['creation_date']))?><br>
        <?=_KMS_ERP_REPORTS_INVOICE_TOTAL.": ".$document_data['total']."&nbsp;"._KMS_ERP_REPORTS_INVOICE_EURO." "._KMS_ERP_REPORTS_INVOICE_TAX_INCLUDED?><br>
        <?=_KMS_ERP_REPORTS_INVOICE_PAYMENT_METHOD.": ".constant($payment_name['payment_name'])?><br>
        <?=_KMS_ERP_REPORTS_INVOICE_PAYMENT_DATE.": ".date( "d-m-Y", strtotime($document_data['payment_date']))?><br>
	<br>
        <strong>
	<?  if ($payment_method_name['bank_charges']!="0") { ?>
	<?=_KMS_ERP_REPORTS_INVOICE_BANK_CHARGE.": ".$payment_method_name['bank_charges']." "._KMS_ERP_REPORTS_INVOICE_EURO?><br>
	<? } ?>
	<?=_KMS_ERP_REPORTS_INVOICE_RETURNED_PAYMENT_DATE1.": ".date("d-m-Y", strtotime("+5 days"))?><br>
	<?=_KMS_ERP_REPORTS_INVOICE_RETURNED_TOTAL_PAY.": ".($document_data['total']+$payment_method_name['bank_charges'])." "._KMS_ERP_REPORTS_INVOICE_EURO." "._KMS_ERP_REPORTS_INVOICE_TAX_INCLUDED?><br>
	<?=_KMS_ERP_REPORTS_INVOICE_RETURNED_PAYMENT_ACCOUNT.": [BANK_ACCOUNT] - [CC]"?>
	<br>
	</strong>
	<br>
	<?=_KMS_ERP_REPORTS_INVOICE_TERM1_COMUNICATION2?>
	<br><br><br>
        <br>
        <? } ?>
        <?=report_mail_billing_notes?>
        <br>
        <br>
        <?=report_mail_billing_signature?>
        <?
	
	break;
	
	case "terminator2":

	// 2on Avis, notificacio de cancel.lacio de servei

	 //recuperem metode de pagament
        $select = "SELECT payment_name FROM kms_ecom_payment_methods WHERE id='".$document_data['payment_method']."'";
        $result = mysql_query($select);
        $payment_name = mysql_fetch_array($result);
        ?>
        <? if ($_POST['emailBody']!="") { echo htmlentities($_POST['emailBody'])."<br><br>"; } else { ?>
        <?=_KMS_ERP_REPORTS_INVOICE_MAIL_INTRO?><br><br>
        <?=_KMS_ERP_REPORTS_INVOICE_TERM2_COMUNICATION1?><br>
        <?=_KMS_ERP_REPORTS_INVOICE_INVOICE."&nbsp;"._KMS_ERP_REPORTS_INVOICE_NUM.": ".$document_data['number']?><br>
        <?=_KMS_ERP_REPORTS_INVOICE_BILLING_CLIENT."&nbsp;:&nbsp;".$client_data['name']?><br>
        <?=_KMS_ERP_REPORTS_INVOICE_BILLING_NIF."&nbsp;:&nbsp;".$client_data['cif']?><br>
        <?=_KMS_ERP_REPORTS_INVOICE_CREATION_DATE.": ".date( "d-m-Y", strtotime($document_data['creation_date']))?><br>
        <?=_KMS_ERP_REPORTS_INVOICE_TOTAL.": ".$document_data['total']."&nbsp;"._KMS_ERP_REPORTS_INVOICE_EURO." "._KMS_ERP_REPORTS_INVOICE_TAX_INCLUDED?><br>
        <?=_KMS_ERP_REPORTS_INVOICE_PAYMENT_METHOD.": ".constant($payment_name['payment_name'])?><br>
        <?=_KMS_ERP_REPORTS_INVOICE_PAYMENT_DATE.": ".date( "d-m-Y", strtotime($document_data['payment_date']))?><br>
        <br>
        <strong>
	 <?  if ($payment_method_name['bank_charges']!="0") { ?>
	<?=_KMS_ERP_REPORTS_INVOICE_BANK_CHARGE.": ".$payment_method_name['bank_charges']." "._KMS_ERP_REPORTS_INVOICE_EURO?><br>
	<? } ?>
        <?=_KMS_ERP_REPORTS_INVOICE_RETURNED_PAYMENT_DATE1.": ".date("d-m-Y", strtotime("+2 days"))?><br>
        <?=_KMS_ERP_REPORTS_INVOICE_RETURNED_TOTAL_PAY.": ".($document_data['total']+$payment_method_name['bank_charges'])." "._KMS_ERP_REPORTS_INVOICE_EURO." "._KMS_ERP_REPORTS_INVOICE_TAX_INCLUDED?><br>
        <?=_KMS_ERP_REPORTS_INVOICE_RETURNED_PAYMENT_ACCOUNT.": [BANK_ACCOUNT] - [CC]"?>
        <br>
	</strong>        <br>
        <?=_KMS_ERP_REPORTS_INVOICE_TERM2_COMUNICATION2?>
	<br>
        <?=_KMS_ERP_REPORTS_INVOICE_TERM2_COMUNICATION3?>
	<br><br><br>
        <br> 
        <? } ?>
        <?=report_mail_billing_notes?>
        <br>
        <br>
        <?=report_mail_billing_signature?>
        <?

        break;

} 
?>
</font>
</div>
</body>
</html>
