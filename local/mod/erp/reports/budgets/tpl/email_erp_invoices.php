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
        $result = mysqli_query($dblink_local,$select);
	$payment_name = mysqli_fetch_array($result);
	?>
	<?=$idiomes[$cl]["_KMS_ERP_REPORTS_INVOICE_MAIL_INTRO"]?><br><br>
	<?=$idiomes[$cl]["_KMS_ERP_REPORTS_INVOICE_BILLING_COMUNICATION"]?><br>
	<? if ($_POST['emailBody']!="") { echo "<br><br>".htmlentities(utf8_decode($_POST['emailBody']))."<br>"; }  //text afegit opcional ?> 
	<br>
	<?=$idiomes[$cl]["_KMS_ERP_REPORTS_INVOICE_INVOICE"]?>: <?=$document_data['number']?><br>
        <?=$idiomes[$cl]["_KMS_ERP_REPORTS_INVOICE_BILLING_CLIENT"]?>&nbsp;:&nbsp;<?=htmlentities(utf8_decode($client_data['name']))?> (<?=$client_data['cif']?>)<br>
	<?=$idiomes[$cl]["_KMS_ERP_REPORTS_INVOICE_CREATION_DATE"]?>: <?=date( "d-m-Y", strtotime($document_data['creation_date']))?><br>
	<?=$idiomes[$cl]["_KMS_ERP_REPORTS_INVOICE_PAYMENT_DATE"]?>: <?=date( "d-m-Y", strtotime($document_data['payment_date']))?><br>
	<?=$idiomes[$cl]["_KMS_ERP_REPORTS_INVOICE_TOTAL"]?>: <?=$document_data['total']?>&nbsp;<?=$idiomes[$cl]["_KMS_ERP_REPORTS_INVOICE_EURO"]?> <?=$idiomes[$cl]["_KMS_WEB_ECOM_TAXINCLUDED"]?><br>
        <? if (substr($payment_name['payment_name'],0,1)=="_") $mp=$payment_name['payment_name']; else $mp=trim("_KMS_ERP_PAYMENTM_".strtoupper(str_replace(" ","_",str_replace("(","",str_replace(")","",$payment_name['payment_name'])))));
           if (constant($mp)!="") $mp=constant($mp);?>
        <?=$idiomes[$cl]["_KMS_ERP_REPORTS_INVOICE_PAYMENT_METHOD"]?>: <?=$mp?><br>
	<br>
	<? if ($document_data['payment_method']=="1") { // transferencia
		echo $idiomes[$cl]["_KMS_ERP_PAYMENT_TRANSFER_INFO"]."<br><br>";
	} else if ($document_data['payment_method']=="3") {
		 echo $idiomes[$cl]["_KMS_ERP_REPORTS_INVOICE_BILLING_VENCIMENT1"]."&nbsp;XXXX-XXXX-XX-XXXXXX".substr($client_data['bank_accountNumber'],-4)."&nbsp;".$idiomes[$cl]["_KMS_ERP_REPORTS_INVOICE_BILLING_VENCIMENT2"].date('d-m-Y',strtotime($document_data['payment_date']));
	        echo "<br><br>".$idiomes[$cl]["_KMS_ERP_REPORTS_INVOICE_CHARGE_NOTE"];
	} ?>
	<br> <br>
	<? // } ?>
	<?=$idiomes[$cl]["_KMS_ERP_REPORTS_INVOICE_MAIL_NOTES"]?><br>
        <br>
        <?=$idiomes[$cl]["_KMS_ERP_BILLING_SIGNATURE"]?>
	<?
	break;
	
	case "terminator1":
	// Avis d'impagament ---------------------------------
	
        //recuperem metode de pagament
        $select = "SELECT payment_name FROM kms_ecom_payment_methods WHERE id='".$document_data['payment_method']."'";
        $result = mysqli_query($dblink_local,$select);
        $payment_name = mysqli_fetch_array($result);
        ?>
        <? if ($_POST['emailBody']!="") { echo htmlentities($_POST['emailBody'])."<br><br>"; } else { ?>
        <?=$idiomes[$cl]["_KMS_ERP_REPORTS_INVOICE_MAIL_INTRO"]?><br><br>
        <?=$idiomes[$cl]["_KMS_ERP_REPORTS_INVOICE_TERM1_COMUNICATION1"]?><br><br>
        <?=$idiomes[$cl]["_KMS_ERP_REPORTS_INVOICE_INVOICE"]?>&nbsp;: <?=$document_data['number']?><br>
        <?=$idiomes[$cl]["_KMS_ERP_REPORTS_INVOICE_BILLING_CLIENT"]?>&nbsp;:&nbsp;<?=htmlentities(utf8_decode($client_data['name']))?><br>
	<?=$idiomes[$cl]["_KMS_ERP_REPORTS_INVOICE_BILLING_NIF"]?>&nbsp;:&nbsp;<?=$client_data['cif']?><br>
	<?=$idiomes[$cl]["_KMS_ERP_REPORTS_INVOICE_CREATION_DATE"]?>: <?=date( "d-m-Y", strtotime($document_data['creation_date']))?><br>
        <?=$idiomes[$cl]["_KMS_ERP_REPORTS_INVOICE_TOTAL"]?>: <?=$document_data['total']?> &nbsp;<?=$idiomes[$cl]["_KMS_ERP_REPORTS_INVOICE_EURO"]?> <?=$idiomes[$cl]["_KMS_WEB_ECOM_TAXINCLUDED"]?><br>
        <? if (substr($payment_name['payment_name'],0,1)=="_") $mp=$payment_name['payment_name']; else $mp=trim("_KMS_ERP_PAYMENTM_".strtoupper(str_replace(" ","_",str_replace("(","",str_replace(")","",$payment_name['payment_name'])))));
           if (constant($mp)!="") $mp=constant($mp);
	   if (substr($mp,0,1)=="_") $mp="";
	?>
        <?=$idiomes[$cl]["_KMS_ERP_REPORTS_INVOICE_PAYMENT_METHOD"]?>: <?=$mp?><br>
        <?=$idiomes[$cl]["_KMS_ERP_REPORTS_INVOICE_PAYMENT_DATE"]?>: <?=date( "d-m-Y", strtotime($document_data['payment_date']))?><br>
	<br>
	<?  if ($payment_method_name['bank_charges']!="0") { ?>
	<?=$idiomes[$cl]["_KMS_ERP_REPORTS_INVOICE_BANK_CHARGE"]?>: <strong><?=$payment_method_name['bank_charges']?> <?=$idiomes[$cl]["_KMS_ERP_REPORTS_INVOICE_EURO"]?></strong><br>
	<? } ?>
	<?=$idiomes[$cl]["_KMS_ERP_REPORTS_INVOICE_RETURNED_PAYMENT_DATE1"]?>: <strong><?=date("d-m-Y", strtotime("+5 days"))?></strong><br>
	<?=$idiomes[$cl]["_KMS_ERP_REPORTS_INVOICE_RETURNED_TOTAL_PAY"]?>: <strong><? echo $document_data['total']+$payment_method_name['bank_charges']?> <?=$idiomes[$cl]["_KMS_ERP_REPORTS_INVOICE_EURO"]?> <?=$idiomes[$cl]["_KMS_WEB_ECOM_TAXINCLUDED"]?></strong><br>
	<?=$idiomes[$cl]["_KMS_ERP_REPORTS_INVOICE_RETURNED_PAYMENT_ACCOUNT"]?>:<strong> [CC] </strong>
	<br>
	<br>
	<?=$idiomes[$cl]["_KMS_ERP_REPORTS_INVOICE_PAYMENT_INSTRUCTIONS"]?>
	<br>
        <br>
        <? } ?>
        <?=$idiomes[$cl]["_KMS_ERP_REPORTS_INVOICE_MAIL_NOTES"]?>
        <br>
        <br>
        <?=$idiomes[$cl]["_KMS_ERP_BILLING_SIGNATURE"]?>
        <?
	
	break;
	
	case "terminator2":

	// 2on Avis, notificacio de cancel.lacio de servei

	 //recuperem metode de pagament
        $select = "SELECT payment_name FROM kms_ecom_payment_methods WHERE id='".$document_data['payment_method']."'";
        $result = mysqli_query($dblink_local,$select);
        $payment_name = mysqli_fetch_array($result);
        ?>
        <?=$idiomes[$cl]["_KMS_ERP_REPORTS_INVOICE_MAIL_INTRO"]?><br><br>
	<?if ($_POST['emailBody']!="") { echo htmlentities($_POST['emailBody'])."<br><br>"; } ?>
        <?=$idiomes[$cl]["_KMS_ERP_REPORTS_INVOICE_TERM2_COMUNICATION1"]?><br><br>
        <?=$idiomes[$cl]["_KMS_ERP_REPORTS_INVOICE_INVOICE"]?>&nbsp;<?=$idiomes[$cl]["_KMS_ERP_REPORTS_INVOICE_NUM"]?>: <?=$document_data['number']?><br>
        <?=$idiomes[$cl]["_KMS_ERP_REPORTS_INVOICE_BILLING_CLIENT"]?>&nbsp;:&nbsp;<?=htmlentities(utf8_decode($client_data['name']))?> (<?=$client_data['cif']?>)<br>
        <?=$idiomes[$cl]["_KMS_ERP_REPORTS_INVOICE_CREATION_DATE"]?>: <?=date( "d-m-Y", strtotime($document_data['creation_date']))?><br>
	<?=$idiomes[$cl]["_KMS_ERP_REPORTS_INVOICE_PAYMENT_DATE"]?>: <?=date( "d-m-Y", strtotime($document_data['payment_date']))?><br>
        <?=$idiomes[$cl]["_KMS_ERP_REPORTS_INVOICE_TOTAL"]?>: <?=$document_data['total']?>&nbsp;<?=$idiomes[$cl]["_KMS_ERP_REPORTS_INVOICE_EURO"]?> <?=$idiomes[$cl]["_KMS_WEB_ECOM_TAXINCLUDED"]?><br>
        <? if (substr($payment_name['payment_name'],0,1)=="_") $mp=$payment_name['payment_name']; else $mp=trim("_KMS_ERP_PAYMENTM_".strtoupper(str_replace(" ","_",str_replace("(","",str_replace(")","",$payment_name['payment_name'])))));
        if (constant($mp)!="") $mp=constant($mp);?>
        <?=$idiomes[$cl]["_KMS_ERP_REPORTS_INVOICE_PAYMENT_METHOD"]?>: <?=$mp?><br>
        <br>
	<?if ($payment_method_name['bank_charges']!="0") { ?>
	<?=$idiomes[$cl]["_KMS_ERP_REPORTS_INVOICE_BANK_CHARGE"]?>: <?=$payment_method_name['bank_charges']?> <?=$idiomes[$cl]["_KMS_ERP_REPORTS_INVOICE_EURO"]?><br>
        <?=$idiomes[$cl]["_KMS_ERP_REPORTS_INVOICE_RETURNED_PAYMENT_DATE1"]?>: <strong><?=date("d-m-Y", strtotime("+2 days"))?></strong><br>
        <?=$idiomes[$cl]["_KMS_ERP_REPORTS_INVOICE_RETURNED_TOTAL_PAY"]?>: <strong><? echo $document_data['total']+$payment_method_name['bank_charges']?> <?=$idiomes[$cl]["_KMS_ERP_REPORTS_INVOICE_EURO"]?> <?=$idiomes[$cl]["_KMS_WEB_ECOM_TAXINCLUDED"]?></strong><br>
        <? /* =$idiomes[$cl]["_KMS_ERP_REPORTS_INVOICE_RETURNED_PAYMENT_ACCOUNT"]?>: [<?=$idiomes[$cl]["BANK_ACCOUNT"]?>] - [<?=$idiomes[$cl]["CC"]?>] */?>
	<?=$idiomes[$cl]["_KMS_ERP_REPORTS_INVOICE_RETURNED_PAYMENT_ACCOUNT"]?>: <strong>[CC]</strong><br>
        <br><?} ?>
        <?=$idiomes[$cl]["_KMS_ERP_REPORTS_INVOICE_PAYMENT_INSTRUCTIONS"]?>
	<br><br>
        <?=$idiomes[$cl]["_KMS_ERP_REPORTS_INVOICE_TERM2_COMUNICATION3"]?>
	<br><br><br>
        <?=$idiomes[$cl]["_KMS_ERP_REPORTS_INVOICE_MAIL_NOTES"]?>
        <br><br>
        <?=$idiomes[$cl]["_KMS_ERP_BILLING_SIGNATURE"]?>
        <?
        break;
}
?>
</font>
</div>
</body>
</html>
