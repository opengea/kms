<? 
// PLANTILLA DE LA FACTURA

//echo "/usr/local/kms/lang/".strtolower($client_data['language']).".php";
require "/usr/local/kms/lang/".strtolower($client_data['language']).'.php';
$iva=$document_data['tax_percent'];
$fontsize1="17px";
$fontsize2="19px";
$fontsize3="19px";
$fontsize4="23px";


if ($document_data['currency']=="USD") $currency="$"; else $currency="&euro;"; 
?>
<div class="invoice" id="invoice" style="padding:0px;width:1350px;height:auto;margin:0px 0px 0px 0px">
<div class="franja" style="padding:0px;margin:0px;width:1350px;height:10px;background-color:#0e99d8"></div>
<div class="marge" style="padding:50px">

  <div class="header" id="header-invoice">
    <table class="rptTable" style="padding-left:0px !important" width="100%" border="0" cellpadding="0" cellspacing="0" id="header">
      <tr>
<!--        <td style="vertical-align:top;padding-left:0px;width:400px;font-size:12px"><span style="font-weight: bold"><img src="http://intranet.intergrid.cat/kms/mod/erp/reports/invoice_logo.png" alt="Intergrid" width="125" /><br />-->

        <td style="vertical-align:top;padding-left:15px;width:500px;font-size:<?=$fontsize1?>">
<span style="font-weight:normal;font-size:40px">
<?=_KMS_ERP_INVOICE?> <?if ($document_data['proforma']=='1') echo "Proforma"; ?>
</span>
<br><br><br><div>

<div class="rpt_info" id="rpt_info">
      <table class="rptTable" style="padding-left:0px !important" width="300px" border="0" cellpadding="0" cellspacing="0" id="bodyheader">
        <tr>
         <td style="font-size:<?=$fontsize2?>"><b><?=utf8_decode(constant('_KMS_ERP_REPORTS_INVOICE_NUM'))?></b></td>
	 <td valign="top" style="font-size:<?=$fontsize2?>;padding-top:5px"><?=$document_data['number']?><?//$document_data['serie']?></td>
	</tr>
	<tr>
	<td style="font-size:<?=$fontsize2?>"><b><?=htmlentities(constant('_KMS_ERP_REPORTS_INVOICE_CREATION_DATE'))?></b></td>
	<td valign="top" style="font-size:<?=$fontsize2?>;padding-top:5px"><?=date( "d-m-Y", strtotime($document_data['creation_date']));?></td>
	</tr>
	<tr>
	<td  style="font-size:<?=$fontsize2?>"><b><?=utf8_decode(constant('_KMS_ERP_INVOICES_RPT_CLIENTID'))?></b></td>
	 <td valign="top" style="font-size:<?=$fontsize2?>;padding-top:5px"><?=$client['id']?></td>
        </tr>
      </table>	
</div>

<div class="rpt_info" id="rpt_info">
<table class="rptTable" style="margin-top:30px;padding-left:0px !important" width="800" border="0" cellpadding="0" cellspacing="0" id="bodyheader">
	<tr><td style="width:450px"><font color="#000" style="line-height:126%;font-weight:normal;font-size:<?=$fontsize2?>"><?=_KMS_ERP_REPORTS_INVOICE_PROVIDERDATA?></font></td>
<td style="text-align:left;font-size:<?=$fontsize2?>;line-height:126%;vertical-align:top;white-space:normal">
<b><?=_KMS_ERP_REPORTS_BILL_TO?>:</b><br>
        <?
                if ($document_data['pre_client']!="") { echo str_replace("//","<br>",htmlentities(utf8_decode($document_data['pre_client'])))."<br>"; }

?><? /* <b><?=strtoupper_accents(htmlentities(utf8_decode($client_data['name'])));?></b><br>*/?>
        <?=strtoupper_accents(htmlentities($client_data['name']));?><br>

 <?
     if ($document_data['post_client']!="") { echo strtoupper($document_data['post_client'])."<br>"; } ?>

            <?=$client_data['cif'];?><br>
            <?=htmlentities($client_data['address'])."<br>".htmlentities($client_data['zipcode'])." ".htmlentities(utf8_decode($client_data['location']))."<br>".htmlentities(utf8_decode($client_data['province']))." (".htmlentities(utf8_decode($client_data['country'])).")";
?>


</td></tr>
</table>
</div>




        <td id="header_right" style="vertical-align:top;padding-right:15px"><p id="header_right">
<? $logo="logo_".$document_data['logo']."_squared.png"; ?>
<span style="font-weight: bold"><img src="http://intranet.intergrid.cat/kms/tpl/intranet/styles/simple/img/logos/<?=$logo?>" alt="Opengea" width="160" /><br />


    </table>
  </div>
<div class="rpt_info" id="rpt_info">

      <div class="rpt_content" id="rpt_content">
        <table class="rptTable" style="padding-left:0px !important;padding-bottom:10px;" width="100%" border="0" cellpadding="0" cellspacing="0" id="body_detail">
          <tr>
            <td class="header_" style="font-size:<?=$fontsize1?>;padding-left:15px"><?=constant('_KMS_ERP_REPORTS_INVOICE_CONCEPT')?></td>
            <td width="150" class="header_" style="font-size:<?=$fontsize1?>;text-align: right;padding-right:20px"><?=constant('_KMS_ERP_REPORTS_INVOICE_IMPORT')?></td>
          </tr>
	</table>
       <div style="width:98%;margin:0px 20px 0px 15px;border-bottom:1px solid #000" ></div> 
	<table class="rptTable" style="padding-left:0px !important" width="100%" border="0" cellpadding="0" cellspacing="0" id="body_detail">
          <tr>
            <td colspan="4"><br></td>
          </tr>
	   <? $encoding=mb_detect_encoding($document_data['concept']); 
	   // if ($encoding=="UTF-8") $document_data['concept']=utf8_decode($document_data['concept']);
//	   $concepts = explode("//",htmlentities(utf8_decode($document_data['concept'])));
	   $concepts = explode("//",utf8_decode($document_data['concept']));
	   // remove last //
	   if (substr($document_data['price_values'],strlen($document_data['price_values'])-4,2)=="//") {
				$document_data['price_values']=substr($document_data['price_values'],0,strlen($document_data['price_values'])-4);
	   }
	   $prices = htmlentities($document_data['price_values']);
//	   $prices= str_replace($currency,"",$prices);
	   $prices = explode("//",$prices);
	   $max_invoice_lines=38;
	   $max_invoice_lines_last_page=27;
	   $pages=ceil((count($concepts)-($max_invoice_lines-$max_invoice_lines_last_page))/$max_invoice_lines);
	   if ($pages==0) $pages=1;
	   if ($pages==1&&count($concepts)>$max_invoice_lines_last_page) $pages=2; // cas especial
	   if ($pages_processed==$pages-1) $max_lines=$max_invoice_lines_last_page; else $max_lines=$max_invoice_lines;
	   if ($pages_processed=="") { $pages_processed=0; $last_line=0; } 

	   //first page
	   for ($i=$last_line;$i<count($concepts)&&$i<=($max_lines+$last_line);$i++) {
		?>
		<tr style="line-height:30px">

		<? $max_chars_per_line=90;
		   if ((substr($concepts[$i],0,7)=="Mailing")&&(strlen($concepts[$i])>$max_chars_per_line)) $concepte_ok=substr($concepts[$i],0,$max_chars_per_line)."..."; else $concepte_ok=$concepts[$i];

		?>
		<td style="font-size:<?=$fontsize2?>;vertical-align:top;padding-left:20px;white-space:normal"><?=$concepte_ok?></td>
		<?
                ?>
		<? $prices[$i]=str_replace("€","",$prices[$i]);?>
		<? $prices[$i]=str_replace("\n","",$prices[$i]);?>
		<? $prices[$i]=str_replace("\r","",$prices[$i]);?>
		<? $prices[$i]=str_replace("<br>","",html_entity_decode($prices[$i]));
		?>

                <td style="font-size:<?=$fontsize2?>;text-align: right; padding-right:15px;vertical-align:top"><? 
if (trim($prices[$i])!="") echo str_replace("&euro;","",$prices[$i])." ".$currency?></td>
		</tr>
                <?
	   }
	$last_line=$i;
	$pages_processed++;
?>
<? /*            <td style="vertical-align:top;padding-left:20px"> <?=str_replace('//','<br>',htmlentities($document_data['concept']));?></td>
            <td style="text-align: right; padding-right:30px;vertical-align:top"><?=str_replace('//','<br>',$document_data['price_values']);?></td>
*/?>
        </table>
        <br />
<? if ($pages_processed<$pages) { ?> <div style="float:right;padding-top:30px"><?=$pages_processed?>/<?=$pages?></div><? } ?>
     </div>
<? if ($pages_processed==$pages) { //last page!  ?>
      <div class="rpt_aditionals" id="rpt_additionals">
        <table width="100%" border="0" cellpadding="0" cellspacing="0" id="additionals">
          <tr>
            <td style="font-size:<?=$fontsize1?>;padding-left:15px"><?=strtoupper_accents(html_entity_decode(_KMS_ERP_REPORTS_INVOICE_NOTES))?></td>
          </tr>
          <tr>
            <td style="font-size:<?=$fontsize1?>;padding-left:15px;padding-top:15px;white-space:normal"><?=htmlentities($document_data['notes']);?></td>
          </tr>
        </table>
        <br />
      </div>
      <br />
  </div>
 <div class="rpt_totals" id="rpt_totals">
      <table width="100%" border="0" cellpadding="0" cellspacing="0" id="totals">
        <tr>
          <td width="800">
	    <table width="100%" style="font-size:<?=$fontsize1?> !important;line-height:150%;background-color:#eee;padding:15px" cellspacing=3 border=0>
            <tr  style="font-size:<?=$fontsize1?> !important;line-height:150%"><td style="font-size:<?=$fontsize1?> !important;"><b><?=strtoupper_accents(html_entity_decode(_KMS_ERP_REPORTS_INVOICE_PAYMENT_DATE))?></b></td><td  style="font-size:<?=$fontsize1?> !important"><?=date( "d-m-Y", strtotime($document_data['payment_date']));?></td></tr>

<? if ($document_data['payment_date']<date("2010-07-01")) $iva=$document_data['tax_percent']; ?>
<? $payment_method = str_replace(" ","_",$document_data['payment_method']);

$add_account="";
if ($payment_method=="1") {
//	if ($document_data['type']=="abonament") $add_account=$client_data["bank_accountNumber"]; else $add_account=_KMS_ERP_REPORTS_INVOICE_COMPTE_EMPRESA;//constant('compte_empresa'); 
}

$mp=$payment_method_name['payment_name'];
if (constant($mp)!="") $mp=constant($mp);
?>
        <? if (strpos(strtoupper($payment_method_name['payment_name']),"REBUT")&&$client_data['default_pm']) $mp.="<br>"._KMS_ERP_PAYMENTM_REBUT_LASTDIGITS." ".substr($client_data["bank_accountNumber"],strlen($client_data["bank_accountNumber"])-4); 
	   if (!$client_data['default_pm']) $mp = "<div style='max-width:350px;white-space:pre-wrap'>"._KMS_ERP_REPORTS_INVOICE_BANK_TRANSFER." "._KMS_ERP_REPORTS_INVOICE_COMPTE_EMPRESA."</div>";
?>

            <tr><td style="font-size:<?=$fontsize1?> !important;vertical-align:top;padding-right:20px"><b><?=strtoupper_accents(html_entity_decode(_KMS_ERP_REPORTS_INVOICE_PAYMENT_METHOD))?></b></td><td  style="font-size:<?=$fontsize1?> !important"><?=utf8_decode($mp)?> <? if ($add_account) echo "<br>".$add_account;?></td></tr>
<!--            <tr><td><b><?=strtoupper_accents(html_entity_decode(_KMS_ERP_REPORTS_INVOICE_BANK_CHARGES))?></b></td><td><?=$document_data['bank_charges'];?></td></tr>-->
		<!-- Rec&agrave;rrecs bancaris
            : <?=$document_data['bank_charges'];?><br />-->
<!--            Entitat banc&agrave;ria
            : <?=$document_data['bank'];?><br />-->
	  <!-- <tr><td><b><?//=report_bankaccount?></b></td><td><?//=$document_data['bank_account_nu'];?></td></tr> -->
	   </table>
	  </td>
	  <td>
	  <table cellpadding="0" cellspacing="0" width="100%" style="padding:5px">
	  <tr><td style="width:10px;border-right:1px solid #ccc"></td>
<?
//discount
 if ($document_data['discount']!=0) {
	$discount_euro=($document_data['base']*$document_data['discount']/100);
        $discount_euro=round($discount_euro,2);
	$document_data['base']=round($document_data['base'],2)-$discount_euro;
?>
	<td width="100" class="detail_columns" style="font-size:<?=$fontsize1?>;line-height:150%;text-align:left;padding-left:15px;"><?=_KMS_INVOICES_DISCOUNT?> <?=$document_data['discount']?>%</td><td style="height:25px;text-align:right;padding-right:33px; font-size:<?=$fontsize3?>; vertical-align:top"><b>- <?=$discount_euro;?>&nbsp;<?=$currency?></b></td></tr>
<?
}?>

<? $document_data['base']=str_replace($currency,"",$document_data['base']);?>
          <tr><td width="150" class="detail_columns" style="font-size:<?=$fontsize1?>;line-height:200%;text-align:left;padding-left:15px;"><?=_KMS_ERP_REPORTS_INVOICE_BASE?></td><td style="height:25px;text-align:right; padding-right:33px;font-size:<?=$fontsize3?>; vertical-align:top"><b><?=$document_data['base'];?>&nbsp;<?=$currency?></b></td></tr>

          <tr><td width="100" class="detail_columns" style="font-size:<?=$fontsize1?>;text-align:left;line-height:200%;padding-left:15px;"><?=$iva?><?="&nbsp;"?><?=_KMS_ERP_REPORTS_INVOICE_VAT?></td><td style="height:25px;text-align:right;padding-right:33px; font-size:<?=$fontsize3?>; vertical-align:top"><b><?=$document_data['total_tax'];?>&nbsp;<?=$currency?></b></td></tr>

<? if ($document_data['bank_charges']!="") { ?>

<tr><td width="100" class="detail_columns" style="font-size:<?=$fontsize1?>;text-align:left;padding-left:15px;"><?=htmlentities(_KMS_ERP_REPORTS_INVOICE_RECARREC)?></td><td style="height:25px;text-align:right;padding-right:33px; font-size:<?=$fontsize3?>; vertical-align:top"><?=$document_data['bank_charges'];?>&nbsp;<?=$currency?></td></tr>

<? 

$document_data['total']+=$document_data['bank_charges'];

} ?>


          <tr style="padding:0px;border-top:1px solid #ccc;"><td width="100" class="detail_columns" style="font-size:<?=$fontsize4?>;text-align:left;line-height:200%;padding-left:15px;height:30px;vertical-align:bottom;border-top:1px solid #ccc;"><?=_KMS_ERP_REPORTS_INVOICE_TOTAL?></td><td style="line-height:200%;height:30px;vertical-align:middle;text-align:right; font-size:<?=$fontsize4?>; vertical-align:bottom;border-top:1px solid #ccc;padding-right:33px;width:150px"><b><?=$document_data['total'];?>&nbsp;<?=$currency?></b></td></tr>
	  </table>
        </tr>

      </table>
  </div>

 <div class="rpt_footer" id="rpt_footer">
      <table width="100%" border="0" cellpadding="0" cellspacing="0" id="footer">
        <tr>
          <td valign="top" style="margin-top:10px"><br><p><img src="http://intranet.intergrid.cat/kms/mod/erp/reports/minilogos.png" alt="tecnologies" height="70"><div id="footer_text">
<?=utf8_decode(_KMS_ERP_REPORTS_INVOICE_FOOTER)?> 
<div style="float:right;font-size:<?=$fontsize2?>;font-size:arial"><? if ($pages_processed!=1&&$pages!=1) { echo $pages_processed; ?>/<?echo $pages; }?></div></div>
</p>
</td>
        </tr>
    </table>
<? } //details last page ?>

  </div>   
</div>
</div>

<?
if ($pages_processed<$pages) { echo "<br><br><br>"; include "/usr/local/kms/mod/erp/reports/tpl/erp_invoices.php"; } 
$pages_processed="";
?>
