<? 
//echo "/usr/local/kms/lang/".strtolower($client_data['language']).".php";
require "/usr/local/kms/lang/".strtolower($client_data['country']).'.php';

$iva=$document_data['tax_percent'];


?>
<div class="invoice" id="invoice">
  <div class="header" id="header">
    <table class="rptTable" width="100%" border="0" cellpadding="0" cellspacing="0" id="header">
      <tr>
<!--        <td style="vertical-align:top;padding-left:0px;width:400px;font-size:12px"><span style="font-weight: bold"><img src="http://intranet.intergrid.cat/kms/mod/erp/reports/invoice_logo.png" alt="Intergrid" width="125" /><br />-->
        <td style="vertical-align:top;padding-left:15px;width:400px;font-size:12px"><span style="font-weight: bold"><img src="http://intranet.intergrid.cat/kms/tpl/extranet/styles/simple/img/logos/logo_intergrid500.png" alt="Intergrid" width="155" /><br />
<div style="padding-left:5px"><br>
<font color="#777777" style="font-weight:normal">
          <?=_KMS_ERP_REPORTS_INVOICE_PROVIDERDATA?>
</font>
</div>
</td>
        <td id="header_right" style="vertical-align:top;padding-right:15px"><p id="header_right">

          <?=_KMS_ERP_INVOICE?>
	<table><tr><td style="padding-top:20px;text-align:left;font-size:13px;vertical-align:top;white-space:normal">
	<b><?=toup($client_data['name']);?></b><br>
            <?=$client_data['cif'];?><br>
            <?=htmlentities($client_data['address'])."<br>".htmlentities($client_data['zipcode'])." ".htmlentities($client_data['location'])."<br>".htmlentities($client_data['province'])." (".htmlentities($client_data['country']).")";
	    ?>
	</td></tr></table>
	</td>
      </tr>
    </table>
  </div>
<div class="rpt_info" id="rpt_info">
      <table class="rptTable" width="400px" border="0" cellpadding="0" cellspacing="0" id="bodyheader">
        <tr>
	 <td class="header" style="text-align:center;font-size:11px" width="95px"><b><?=toup(constant('_KMS_ERP_REPORTS_INVOICE_NUM'))?></b></td>
	  <td class="header" style="text-align:center;font-size:11px" width="140px"><b><?=toup(constant('_KMS_ERP_REPORTS_INVOICE_CREATION_DATE'))?></b></td>
	  <td class="header" style="text-align:center;padding-right:11px" width="115px"><b><?=toup(constant('_KMS_ERP_INVOICES_RPT_CLIENTID'))?></b></td>
        </tr>
          <td valign="top" style="padding-top:5px;text-align:center"><?=$document_data['number']?><?//$document_data['serie']?></td>
	  <td valign="top" style="padding-top:5px;text-align:center"><?=date( "d-m-Y", strtotime($document_data['creation_date']));?></td>
	  <td valign="top" style="padding-top:5px;text-align:center"><?=$document_data['sr_client']?></td>
        </tr>
      </table>
      <div class="rpt_content" id="rpt_content">
        <table class="rptTable" width="100%" border="0" cellpadding="0" cellspacing="0" id="body_detail">
          <tr>
            <td class="header" style="padding-left:15px"><b><?=toup(constant('_KMS_ERP_REPORTS_INVOICE_CONCEPT'))?></b></td>
            <td width="100" class="header" style="text-align: center"><b><?=toup(constant('_KMS_ERP_REPORTS_INVOICE_IMPORT'))?></b></td>
          </tr>
          <tr>
            <td colspan="4"><br></td>
          </tr>
	    <? $encoding=mb_detect_encoding($document_data['concept']); 
//		if ($encoding=="UTF-8") $document_data['concept']=utf8_decode($document_data['concept']);
	   $concepts = explode("//",htmlentities($document_data['concept']));
	   $prices = explode("//",$document_data['price_values']);

	   for ($i=0;$i<count($concepts);$i++) {
		?>
		<tr style="line-height:20px">
		<td style="vertical-align:top;padding-left:20px"><?=$concepts[$i]?></td>
	                <? $prices[$i]=str_replace("~B�","",$prices[$i]);?>
                <td style="text-align: right; padding-right:30px;vertical-align:top"><?=$prices[$i]?></td>
		</tr>
                <?

	    }

?>
<? /*            <td style="vertical-align:top;padding-left:20px"> <?=str_replace('//','<br>',htmlentities($document_data['concept']));?></td>
            <td style="text-align: right; padding-right:30px;vertical-align:top"><?=str_replace('//','<br>',$document_data['price_values']);?></td>
*/?>
        </table>
        <br />
      </div>
      <div class="rpt_aditionals" id="rpt_additionals">
        <table width="100%" border="0" cellpadding="0" cellspacing="0" id="additionals">
          <tr>
            <td style="padding-left:15px"><?=strtoupper(html_entity_decode(_KMS_ERP_REPORTS_INVOICE_NOTES))?></td>
          </tr>
          <tr>
            <td style="padding-left:15px;padding-top:15px"><?=$document_data['notes'];?></td>
          </tr>
        </table>
        <br />
      </div>
      <br />
  </div>
 <div class="rpt_totals" id="rpt_totals">
      <table width="100%" border="0" cellpadding="0" cellspacing="0" id="totals">
        <tr>
          <td width="450">
	    <table width="100%" style="background-color:#eee;padding:15px" cellspacing=3 border=0>
            <tr><td><b><?=strtoupper(html_entity_decode(_KMS_ERP_REPORTS_INVOICE_PAYMENT_DATE))?></b></td><td><?=date( "d-m-Y", strtotime($document_data['payment_date']));?></td></tr>

<? if ($document_data['payment_date']<date("2010-07-01")) $iva=18; ?>
<? $payment_method = htmlentities(str_replace(" ","_",$document_data['payment_method']));

$add_account="";
if ($payment_method=="1") {
	if ($document_data['type']=="abonament") $add_account=$client_data["bank_accountNumber"]; else $add_account=constant('compte_empresa'); 
}

?>
            <tr><td style="vertical-align:top"><b><?=strtoupper(html_entity_decode(_KMS_ERP_REPORTS_INVOICE_PAYMENT_METHOD))?></b></td><td><?=constant($payment_method_name['payment_name'])."<br>".$add_account;?></td></tr>
<!--            <tr><td><b><?=strtoupper(html_entity_decode(_KMS_ERP_REPORTS_INVOICE_BANK_CHARGES))?></b></td><td><?=$document_data['bank_charges'];?></td></tr>-->
		<!-- Rec&agrave;rrecs bancaris
            : <?=$document_data['bank_charges'];?><br />-->
<!--            Entitat banc&agrave;ria
            : <?=$document_data['bank'];?><br />-->
	   <tr><td><b><?//=report_bankaccount?></b></td><td><?=$document_data['bank_account_nu'];?></td></tr>
	   </table>
	  </td>
	  <td>
	  <table cellpadding="0" cellspacing="0" width="100%" style="border-left:1px solid #ccc;margin-left:10px;padding:5px">
          <tr><td width="200" class="detail_columns" style="text-align:left;padding-left:15px;"><?=_KMS_ERP_REPORTS_INVOICE_BASE?></td><td style="height:25px;text-align:right; padding-right:33px;font-size:13px; vertical-align:top"><b><?=$document_data['base'];?>&nbsp;&euro;</b></td></tr>
          <tr><td width="100" class="detail_columns" style="text-align:left;padding-left:15px;"><?=$iva?><?="&nbsp;"?><?=_KMS_ERP_REPORTS_INVOICE_VAT?></td><td style="height:25px;text-align:right;padding-right:33px; font-size:13px; vertical-align:top"><b><?=$document_data['total_tax'];?>&nbsp;&euro;</b></td></tr>
          <tr style="padding:0px;border-top:1px solid #ccc;"><td width="100" class="detail_columns" style="text-align:left;padding-left:15px;height:30px;vertical-align:bottom;border-top:1px solid #ccc;"><?=_KMS_ERP_REPORTS_INVOICE_TOTAL?></td><td style="height:30px;vertical-align:middle;text-align:right; font-size:17px; vertical-align:bottom;border-top:1px solid #ccc;padding-right:33px;width:150px"><b><?=$document_data['total'];?>&nbsp;&euro;</b></td></tr>
	  </table>
        </tr>

      </table>
  </div>
 <div class="rpt_footer" id="rpt_footer">
      <table width="100%" border="0" cellpadding="0" cellspacing="0" id="footer">
        <tr>
          <td valign="top"><p><img src="http://intranet.intergrid.cat/kms/mod/erp/reports/minilogos.png" alt="tecnologies" height="40"><div id="footer_text"><?=_KMS_ERP_REPORTS_INVOICE_FOOTER?></div>
</p></td>
        </tr>
    </table>
  </div>   
</div>
