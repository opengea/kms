<? 
$iva=21;
function toup($s) {
	return htmlentities(strtoupper(html_entity_decode($s)));
}

?>
<div class="budget" id="invoice">
  <div class="header" id="header">
    <table class="rptTable" width="100%" border="0" cellpadding="0" cellspacing="0" id="header">
      <tr>
        <td style="vertical-align:top;padding-left:15px;width:500px;font-size:12px"><span style="font-weight: bold"><img src="http://intranet.intergrid.cat/kms/tpl/extranet/styles/simple/img/logos/logo_intergrid500.png" alt="Intergrid" width="155" /><br />
</td>
        <td id="header_right" style="text-align:right;vertical-align:top;padding-right:15px;font-size:11px">
          <?=report_providerdata?>
</td></tr></table>

<table class="rptTable" width="100%" border="0" cellpadding="0" cellspacing="0" id="header">
<tr><td valign="top"><div style="padding-left:15px"><br>
<font color="#000000" style="font-weight:bold;font-size:19px">
<?=_KMS_ERP_BUDGETS_TITLE?>
</font>
<table><tr><td width="300">
<b><?=report_num?> <?=toup(constant('_KMS_ERP_BUDGET'))?></b> : <?=$document_data['number']?></td>
<td><b><?=report_dataemissio?></b> <?=date( "d-m-Y", strtotime($document_data['creation_date']));?></td></tr>
<tr><td><b><?=constant('_KMS_ERP_BUDGETS_CLIENT')?> <?=toup($client_data['name']);?></b><br>
            <?=$client_data['cif'];?><br>

</td><td>...</td></tr></table>
	</td></tr></table>
	</td>
      </tr>
    </table>
  </div>
<p style="page-break-after:always"></p>

<div class="rpt_info" id="rpt_info">
      <table class="rptTable" width="380px" border="0" cellpadding="0" cellspacing="0" id="bodyheader">
        <tr>
	  
          <td class="header" style="text-align:center" width="95px"><b><?=report_num?> <?=toup(constant('_KMS_ERP_BUDGET'))?></b></td>
	  <td class="header" style="text-align:center" width="115px"><b><?=report_dataemissio?></b></td>
	  <td class="header" style="text-align:center;padding-right:10px" width="95px"><b><?=report_contractnum?></b></td>
        </tr>
        <tr>
          <td valign="top" style="padding-top:5px;text-align:center"><?=$document_data['number']?><?//$document_data['serie']?></td>
	  <td valign="top" style="padding-top:5px;text-align:center"><?=date( "d-m-Y", strtotime($document_data['creation_date']));?></td>
	  <td valign="top" style="padding-top:5px;text-align:center"><?=$client_data['id']?></td>
        </tr>
      </table>
      <div class="rpt_content" id="rpt_content">
        <table class="rptTable" width="100%" border="0" cellpadding="0" cellspacing="0" id="body_detail">
          <tr>
            <td class="header" style="padding-left:15px"><b><?=report_concept?></b></td>
            <td width="100" class="header" style="text-align: center"><b><?=report_import?></b></td>
          </tr>
          <tr>
            <td colspan="4"><br></td>
          </tr>
          <tr style="line-height:20px">
            <td style="vertical-align:top;padding-left:20px"> <?=str_replace('//','<br>',htmlentities($document_data['concept']));?></td>
            <td style="text-align: right; padding-right:30px;vertical-align:top"><?=str_replace('//','<br>',$document_data['price_values']);?></td>
          </tr>
        </table>
        <br />
      </div>
      <div class="rpt_aditionals" id="rpt_additionals">
        <table width="100%" border="0" cellpadding="0" cellspacing="0" id="additionals">
          <tr>
            <td style="padding-left:15px"><?=report_notes?></td>
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
            <tr><td><b><?=report_budgets_validuntil?></b></td><td><?=date( "d-m-Y", strtotime($document_data['payment_date']));?></td></tr>
<? $payment_method = htmlentities(str_replace(" ","_",$document_data['payment_method']));

$add_account="";
if ($payment_method=="transfer&egrave;ncia_bancaria") {
	if ($document_data['type']=="abonament") $add_account=$client_data["bank_accountNumber"]; else $add_account=constant('compte_empresa'); 
}

?>
            <tr><td style="vertical-align:top"><b><?=report_paymentmethod?></b></td><td><?=toup($document_data['payment_method']).$add_account;?></td></tr>
<!--            <tr><td><b><?=report_bankcharges?></b></td><td><?=$document_data['bank_charges'];?></td></tr>-->
		<!-- Rec&agrave;rrecs bancaris
            : <?=$document_data['bank_charges'];?><br />-->
<!--            Entitat banc&agrave;ria
            : <?=$document_data['bank'];?><br />-->
	   <tr><td><b><?//=report_bankaccount?></b></td><td><?=$document_data['bank_account_nu'];?></td></tr>
	   </table>
	  </td>
	  <td>
	  <table cellpadding="0" cellspacing="0" width="100%" style="border-left:1px solid #ccc;margin-left:10px;padding:5px">
          <tr><td width="200" class="detail_columns" style="text-align:left;padding-left:15px;"><?=report_base?></td><td style="height:25px;text-align:right; padding-right:33px;font-size:13px; vertical-align:top"><b><?=$document_data['base'];?>&nbsp;&euro;</b></td></tr>
          <tr><td width="100" class="detail_columns" style="text-align:left;padding-left:15px;"><?=$iva?><?=report_pcvat?></td><td style="height:25px;text-align:right;padding-right:33px; font-size:13px; vertical-align:top"><b><?=$document_data['total_tax'];?>&nbsp;&euro;</b></td></tr>
          <tr style="padding:0px;border-top:1px solid #ccc;"><td width="100" class="detail_columns" style="text-align:left;padding-left:15px;height:30px;vertical-align:bottom;border-top:1px solid #ccc;"><?=report_total?></td><td style="height:30px;vertical-align:middle;text-align:right; font-size:17px; vertical-align:bottom;border-top:1px solid #ccc;padding-right:33px;"><b><?=$document_data['total'];?>&nbsp;&euro;</b></td></tr>
	  </table>
        </tr>

      </table>
  </div>
 <div class="rpt_footer" id="rpt_footer">
      <table width="100%" border="0" cellpadding="0" cellspacing="0" id="footer">
        <tr>
          <td valign="top"><p><img src="http://intranet.intergrid.cat/kms/mod/erp/reports/minilogos.png" alt="tecnologies" height="40"><br><?=report_footer?>
</p></td>
        </tr>
    </table>
  </div>   
</div>
