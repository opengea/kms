<? 
//echo "/usr/local/kms/lang/".strtolower($client_data['language']).".php";
include_once "/usr/local/kms/lib/include/functions.php";
require "/usr/local/kms/lang/".strtolower($client_data['language']).'.php';
$iva=$document_data['tax_percent'];
if ($document_data['currency']=="USD") $currency="$"; else $currency="&euro;";

?>
<div class="invoice" id="invoice" style="height:1170px;margin-bottom:40px">
  <div class="header" id="header">
    <table class="rptTable" width="100%" border="0" cellpadding="0" cellspacing="0" id="header">
      <tr>
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
	 <? if ($document_data['pre_client']!="") { echo "<b>".$document_data['pre_client']."</b><br>";
        } else { echo "<b>"; } ?>
        <?=strtoupper_accents(htmlentities(utf8_decode($client_data['name'])));?></b><br>
            <?=$client_data['cif'];?><br>
            <?=htmlentities(utf8_decode($client_data['address']))."<br>".htmlentities($client_data['zipcode'])." ".htmlentities(utf8_decode($client_data['location']))."<br>".htmlentities(utf8_decode($client_data['province']))." (".htmlentities(utf8_decode($client_data['country'])).")";
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
          <td class="header" style="text-align:center;font-size:11px" width="140px"><b><?=strtoupper_accents(constant('_KMS_ERP_REPORTS_INVOICE_CREATION_DATE'))?></b></td>
	  <td class="header" style="text-align:center;font-size:11px;padding-right:11px" width="115px"><b><?=toup(constant('_KMS_ERP_INVOICES_RPT_CLIENTID'))?></b></td>
        </tr>
          <td valign="top" style="padding-top:5px;text-align:center"><?=$document_data['number']?><?//$document_data['serie']?></td>
	  <td valign="top" style="padding-top:5px;text-align:center"><?=date( "d-m-Y", strtotime($document_data['creation_date']));?></td>
	  <td valign="top" style="padding-top:5px;text-align:center"><?=$client_data['sr_client']?></td>
        </tr>
      </table>
      <div class="rpt_content" id="rpt_content">
        <table class="rptTable" width="100%" border="0" cellpadding="0" cellspacing="0" id="body_detail">
          <tr>
            <td class="header" style="padding-left:15px"><b><?=toup(constant('_KMS_ERP_REPORTS_INVOICE_CONCEPT'))?></b></td>
            <td width="80" class="header" style="text-align: center"><b><?=toup(constant('_KMS_ERP_REPORTS_INVOICE_IMPORT'))?></b></td>
          </tr>
          <tr>
            <td colspan="4"><br></td>
          </tr>
	   <? $encoding=mb_detect_encoding($document_data['concept']); 
           // if ($encoding=="UTF-8") $document_data['concept']=utf8_decode($document_data['concept']);
	   $concepts = explode("//",htmlentities(utf8_decode($document_data['concept'])));
           $prices = $document_data['price_values'];
           $prices= str_replace($currency,"",$prices);
           $prices = explode("//",$prices);
	   $max_invoice_lines=38;
           $max_invoice_lines_last_page=27;
           $pages=ceil((count($concepts)-($max_invoice_lines-$max_invoice_lines_last_page))/$max_invoice_lines);
           if ($pages==0) $pages=1;
           if ($pages==1&&count($concepts)>$max_invoice_lines_last_page) $pages=2; // cas especial
           if ($pages_processed==$pages-1) $max_lines=$max_invoice_lines_last_page; else $max_lines=$max_invoice_lines;
           if ($pages_processed=="") { $pages_processed=0; $last_line=0; }
	   $last_line=0;
	   $pages_processed=0;
	   //first page
	    for ($i=$last_line;$i<count($concepts)&&$i<=($max_lines+$last_line);$i++) {
                ?>
                <tr style="line-height:20px">

                <? $max_chars_per_line=90;
                   if ((substr($concepts[$i],0,7)=="Mailing")&&(strlen($concepts[$i])>$max_chars_per_line)) $concepte_ok=substr($concepts[$i],0,$max_chars_per_line)."..."; else $concepte_ok=$concepts[$i];

                ?>
                <td style="vertical-align:top;padding-left:20px;white-space:normal"><?=$concepte_ok?></td>
                <?
                ?>
                <? $prices[$i]=str_replace("~B�","",$prices[$i]);?>
                <td style="text-align: right; padding-right:30px;vertical-align:top"><?=trim($prices[$i])?><?if ($prices[$i]!="") echo ""?></td>
                </tr>
                <?
           }
        $last_line=$i;
        $pages_processed++;

?>
        </table>
        <br />
        <br />
<? if ($pages_processed<$pages) { ?> <div style="float:right;padding-top:30px"><?=$pages_processed?>/<?=$pages?></div><? } ?>
     </div>
<? if ($pages_processed==$pages) { //last page!  ?>
      <div class="rpt_aditionals" id="rpt_additionals">
        <table width="100%" border="0" cellpadding="0" cellspacing="0" id="additionals">
          <tr>
            <td style="padding-left:15px"><?=strtoupper_accents(html_entity_decode(_KMS_ERP_REPORTS_INVOICE_NOTES))?></td>
          </tr>
          <tr>
            <td style="padding-left:15px;padding-top:15px;white-space:normal"><?=htmlentities($document_data['notes']);?></td>
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
            <tr><td><b><?=strtoupper_accents(html_entity_decode(_KMS_ERP_REPORTS_INVOICE_PAYMENT_DATE))?></b></td><td><?=date( "d-m-Y", strtotime($document_data['payment_date']));?></td></tr>

<? if ($document_data['payment_date']<date("2010-07-01")) $iva=$document_data['tax_percent']; ?>
<? $payment_method = htmlentities(str_replace(" ","_",$document_data['payment_method']));

$add_account="";
if ($payment_method=="1") {
        if ($document_data['type']=="abonament") $add_account=$client_data["bank_accountNumber"]; else $add_account=_KMS_ERP_REPORTS_INVOICE_COMPTE_EMPRESA;//constant('compte_empresa'); 
}

?>
            <tr><td style="vertical-align:top"><b><?=strtoupper_accents(html_entity_decode(_KMS_ERP_REPORTS_INVOICE_PAYMENT_METHOD))?></b></td><td><?=constant($payment_method_name['payment_name'])."<br>".$add_account;?></td></tr>
<!--            <tr><td><b><?=strtoupper_accents(html_entity_decode(_KMS_ERP_REPORTS_INVOICE_BANK_CHARGES))?></b></td><td><?=$document_data['bank_charges'];?></td></tr>-->
		<!-- Rec&agrave;rrecs bancaris
            : <?=$document_data['bank_charges'];?><br />-->
<!--            Entitat banc&agrave;ria
            : <?=$document_data['bank'];?><br />-->
	   <tr><td><b><?//=report_bankaccount?></b></td><td><?=$document_data['bank_account_nu'];?></td></tr>
	   </table>
	  </td>
	  <td>
	  <table cellpadding="0" cellspacing="0" width="100%" style="border-left:1px solid #ccc;margin-left:10px;padding:5px">

<?//discount
 if ($document_data['discount']!=0) {
        $discount_euro=($document_data['base']*$document_data['discount']/100);
        $discount_euro=round($discount_euro,2);
        $document_data['base']=round($document_data['base'],2)-$discount_euro;

?>
        <tr><td width="80" class="detail_columns" style="text-align:left;padding-left:15px;"><?=_KMS_INVOICES_DISCOUNT?> <?=$document_data['discount']?>%</td><td style="height:25px;text-align:right;padding-right:33px; font-size:13px; vertical-align:top"><b>- <?=$discount_euro;?>&nbsp;<?=$currency?></b></td></tr>
<?
}?>

<? $document_data['base']=str_replace($currency,"",$document_data['base']);?>
          <tr><td width="200" class="detail_columns" style="text-align:left;padding-left:15px;"><?=_KMS_ERP_REPORTS_INVOICE_BASE?></td><td style="height:25px;text-align:right; padding-right:33px;font-size:13px; vertical-align:top"><b><?=$document_data['base'];?>&nbsp;<?=$currency?></b></td></tr>
<?}?>

          <tr><td width="80" class="detail_columns" style="text-align:left;padding-left:15px;"><?=$iva?><?="&nbsp;"?><?=_KMS_ERP_REPORTS_INVOICE_VAT?></td><td style="height:25px;text-align:right;padding-right:33px; font-size:13px; vertical-align:top"><b><?=$document_data['total_tax'];?>&nbsp;<?=$currency?></b></td></tr>

<? if ($document_data['bank_charges']!="") { ?>
<tr><td width="100" class="detail_columns" style="font-size:<?=$fontsize1?>;text-align:left;padding-left:15px;"><?=htmlentities(_KMS_ERP_REPORTS_INVOICE_RECARREC)?></td><td style="height:25px;text-align:right;padding-right:33px; font-size:<?=$fontsize3?>; vertical-align:top"><?=$document_data['bank_charges'];?>&nbsp;<?=$currency?></td></tr>
<?
$document_data['total']+=$document_data['bank_charges'];
} ?>

          <tr style="padding:0px;border-top:1px solid #ccc;"><td width="80" class="detail_columns" style="text-align:left;padding-left:15px;height:30px;vertical-align:bottom;border-top:1px solid #ccc;"><?=_KMS_ERP_REPORTS_INVOICE_TOTAL?></td><td style="height:30px;vertical-align:middle;text-align:right; font-size:17px; vertical-align:bottom;border-top:1px solid #ccc;padding-right:33px;width:150px"><b><?=$document_data['total'];?>&nbsp;<?=$currency?></b></td></tr>
	  </table>
        </tr>

      </table>
  </div>

 <div class="rpt_footer" id="rpt_footer">
      <table width="100%" border="0" cellpadding="0" cellspacing="0" id="footer">
        <tr>
          <td valign="top"><p><img src="http://intranet.intergrid.cat/kms/mod/erp/reports/minilogos.png" alt="tecnologies" height="40"><div id="footer_text"><?=_KMS_ERP_REPORTS_INVOICE_FOOTER?><div style="float:right;font-size:11px;font-size:arial"><? if ($pages_processed!=1&&$pages!=1) { echo $pages_processed; ?>/<?echo $pages; }?></div></div>
</p>
</td>
        </tr>
    </table>
<? //} //details last page ?>

  </div>
</div>

<?
if ($pages_processed<$pages) { echo "<br><br><br>"; include "/usr/local/kms/mod/erp/reports/tpl/isp_invoices.php"; } ?>
