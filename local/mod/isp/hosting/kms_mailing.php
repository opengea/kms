<div style="padding:20px;padding-top:0px;">
<h2>KMS Mailing</h2>
<?

include_once "/usr/local/kms/lib/include/functions.php";
include "/usr/local/kms/lib/mod/shared/db_links.php";

function explain_feature($feature,$colors) {
        switch ($feature) {
        case 'monthlyPrice':
                $add="<span style='font-size:14px'> &euro;/".strtolower(_KMS_GL_MONTH)."*</span>";
                break;
        case 'setupPrice':
                $add=" &euro;*";
                break;
        }
        $res=mysqli_query($sel);
        $n=0; $out="";//<table width=550 cellpadding=0 cellspacing=0><tr>";
        while ($product=mysqli_fetch_array($res)) {
                        if ($feature=="monthlyPrice") $add="<span style='font-size:14px'> &euro;/".strtolower(_KMS_GL_MONTH)."*</span>"; //<br><span style='font-size:12px'>"._KMS_SERVICES_SETUPPRICE." ".$product['setupPrice']." &euro;</span>";     
                if (is_array($colors)) {
                                $css_add="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius: 0px;";
                                $out.="<td style='color:#fff;font-size:21px;padding:0px;font-family: openSansCond;$css_add; background-color:".$colors[$n].";text-align:center;line-height:100%'>".$product[$feature].$add."</td>";
                        } else {
                                $out.="<td class='col$n' style='border-bottom:1px solid #ccc;border-left:1px solid #ccc;-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius: 0px; background-color:".$color.";text-align:center'>".$product[$feature].$add."</td>";
                        }
                $n++;
        }
//      $out.="</tr></table>";
        return $out;
}

function explain_all($value,$n) {
        $out="";
        if ($value=="OK") $value="<img src='/kms/css/aqua/img/small/accept.png'>";
        for ($i=0;$i<$n;$i++) {
                $out.="<td class='col$i' style='border-bottom:1px solid #ccc;border-left:1px solid #ccc;-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius: 0px; ;text-align:center'>".$value."</td>";
        }
        return $out;

}

function explain_span($value,$n) {
        $out="";
        if ($value=="OK") $value="<img src='/kms/css/aqua/img/small/accept.png'>";
        $out.="<td class=\"common\" colspan=\"$n\" style='border-bottom:1px solid #ccc;border-left:1px solid #ccc;-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius: 0px; ;text-align:center'>".$value."</td>";
        return $out;

}

function contract_buttons($n) {
        $out="";

        for ($i=0;$i<$n;$i++) {
                $out.="<td class='col{$i}' style='text-align:center;border-bottom:1px solid #ccc;border-left:1px solid #ccc'><input class='order' type='button' onclick=\"submitform(); \" value='".strtolower(_KMS_ECOM_ORDERNOW)."'></td>";
        }
        return $out;

}

function htip($value) {
        return "<div class=\"htip\" title=\"".$value."\"></div>";
}


if ($_GET['id']=="") $new=1; else $new=0;
if ($_POST['contractar']=="1") {
	//submit new server
	//if ($this->user_account['id']==1) die("option not available for admin");
	if ($_GET['app']!="sysadmin"&&$_GET['app']!="cp-admin") { 
		$select="SELECT * FROM kms_isp_clients where sr_user=".$this->user_account['id'];
		$result=mysqli_query($select);
		if (!$result) die(mysqli_error($result));
		$client=mysqli_fetch_array($result);
		$addcheck=" AND sr_client=".$client['id']; // no es sr_client??
		 $client=$this->dbi->get_record("SELECT * FROM kms_isp_clients where sr_user=".$this->user_account['id'],$dblink_cp);
	} else {
		$addcheck="";
	}

	// -------------- NEW MAILING -------------------
	$vhost=$this->dbi->get_record("SELECT * FROM kms_isp_hostings_vhosts where id=".$_GET['id'],$dblink_cp);
	$body="Client : ".$client['sr_client']."(user account ".$this->user_account['id'].")<br>Domini : ".$vhost['name'];
        $this->emailNotify("Peticio d'alta de KMS Mailing",$body);
	//redirect to hostings...
	echo "<br><br>"._KMS_WEB_ECOM_NEWPURCHASE."<br><br><br><input type='button' onclick=\"document.location='/?app=".$_GET['app']."&mod=isp_hostings';\" value=\""._KMS_GL_CONTINUE."\">";
	die();
} else {

$vhost=$this->dbi->get_record("SELECT * FROM kms_isp_hostings_vhosts where id=".$_GET['id'],$dblink_cp);
echo 
$extranet=$this->dbi->get_record("SELECT * from kms_isp_extranets where hosting_id=".$vhost['hosting_id']." and domain='".$vhost['name']."'",$dblink_cp);
$extranet['modules']=str_replace(",","|",$extranet['modules']);
$modules=explode("|",$extranet['modules']);
        if (in_array("KMS Mailing",$modules)) {

	echo str_replace("[DOMAIN]","<b>".$vhost['name']."</b>",_KMS_ISP_MAILING_ALREADYACTIVE);
	?><br><br><br><input type='button' onclick="document.location='/?app=<?=$_GET['app']?>&mod=isp_hostings'" value="<?=_KMS_GL_CONTINUE?>">
<?	exit;
}
// ----------------- FORMULARI ALTA ----------------------
$n=1;
?>
<div style="width:650px"><span style="font-size:13px"><?=_KMS_MAILING_EXPLAIN?></span><br><br></div>
<?=contract_buttons($n)?>
<br>
<br>
<h3 style='margin-bottom:5px;color:#000'><?=_KMS_ISP_MAILING_FEATURES?></h3>
<form action="/?_=f&id=<?=$_GET['id']?>&app=<?=$_GET['app']?>&mod=<?=$_GET['mod']?>&action=<?=$_GET['action']?>" id="formkms" name="manage" method="post">

<table width=650 class="limits" cellspacing="0" cellpadding="0">
<tr><td colspan="<?=$n+1?>" style="height:10px"></td></tr>
<tr class="group"><td colspan="<?=$n+1?>" onclick="toggleFeatures('tr1')"><?=_KMS_ISP_MAILING_SERVICE?><div id="ctr1" class="ctr"><?=_KMS_GL_HIDE?></div></td></tr>
</table>
<div id="tr1">
<table width=650 class="limits" cellspacing="0" cellpadding="0">
<tr class="feature"><td class="f3"><?=_KMS_ISP_MAILING_FEATURE_CLOUDBASED?><?=htip(_KMS_ISP_MAILING_FEATURE_CLOUDBASED_EXPLAIN)?></td><?=explain_all("OK",$n)?></tr>
<tr class="feature"><td class="f3"><?=_KMS_ISP_MAILING_FEATURE_SENDLIMIT?></td><?=explain_all(_KMS_GL_NOLIMITS,$n)?></tr>
<tr class="feature"><td class="f3"><?=_KMS_ISP_MAILING_FEATURE_DELIVERSPEED?><?=htip(_KMS_ISP_MAILING_FEATURE_DELIVERSPEED_HELPTIP)?></td><?=explain_all(_KMS_ISP_MAILING_FEATURE_DELIVERSPEED_EXPLAIN,$n)?>
<tr class="feature"><td class="f3"><?=_KMS_ISP_MAILING_FEATURE_CLOUDSPACE?><?=htip(_KMS_ISP_MAILING_FEATURE_CLOUDSPACE_EXPLAIN)?></td><?=explain_all("5 GB",$n)?></tr>
<tr class="feature"><td class="f3"><?=_KMS_ISP_MAILING_FEATURE_DOMAINSPF?><?=htip(_KMS_ISP_MAILING_FEATURE_DOMAINSPF_EXPLAIN)?></td><?=explain_all("OK",$n)?></tr>
  <tr class="feature"><td class="f3"><?=_KMS_ISP_MAILING_FEATURE_BACKUPS?><?=htip(_KMS_ISP_MAILING_FEATURE_BACKUPS_EXPLAIN)?></td><?=explain_all("OK",$n)?></tr>
</table>
</div>

<table width=650 class="limits" cellspacing="0" cellpadding="0">
<tr><td colspan="<?=$n+1?>" style="height:10px"></td></tr>
<tr class="group"><td colspan="<?=$n+1?>" onclick="toggleFeatures('tr2')"><?=_KMS_ISP_MAILING_MANAGEMENT?><div id="ctr2" class="ctr"><?=_KMS_GL_HIDE?></div></td></tr>
</table>

  <div id="tr2">
  <table width=650 class="limits" cellspacing="0" cellpadding="0">
  <tr class="feature"><td class="f3"><?=_KMS_ISP_MAILING_FEATURE_CONTACTSMAN?><?=htip(_KMS_ISP_MAILING_FEATURE_CONTACTSMAN_EXPLAIN)?></td><?=explain_all("OK",$n)?></tr>
  <tr class="feature"><td class="f3"><?=_KMS_ISP_MAILING_FEATURE_IMPORTEXPORT?><?=htip(_KMS_ISP_MAILING_FEATURE_IMPORTEXPORT_EXPLAIN)?></td><?=explain_all("OK",$n)?></td></tr>
  <tr class="feature"><td class="f3"><?=_KMS_ISP_MAILING_FEATURE_SEGMENTATION?><?=htip(_KMS_ISP_MAILING_FEATURE_SEGMENTATION_EXPLAIN)?></td><?=explain_all("OK",$n)?></td></tr>
  <tr class="feature"><td class="f3"><?=_KMS_ISP_MAILING_FEATURE_AUTOMATIC?><?=htip(_KMS_ISP_MAILING_FEATURE_AUTOMATIC_EXPLAIN)?></td><?=explain_all("OK",$n)?></td></tr>
  <tr class="feature"><td class="f3"><?=_KMS_ISP_MAILING_FEATURE_INTERACTIVE?><?=htip(_KMS_ISP_MAILING_FEATURE_INTERACTIVE_EXPLAIN)?></td><?=explain_all("OK",$n)?></td></tr>
  <tr class="feature"><td class="f3"><?=_KMS_ISP_MAILING_FEATURE_LOPD?><?=htip(_KMS_ISP_MAILING_FEATURE_LOPD_EXPLAIN)?></td><?=explain_all("OK",$n)?></td></tr>

  </table>
  </div>

<table width=650 class="limits" cellspacing="0" cellpadding="0">
  <tr><td colspan="<?=$n+1?>" style="height:10px"></td></tr>
  <tr class="group"><td colspan="<?=$n+1?>" onclick="toggleFeatures('tr3')"><?=_KMS_ISP_MAILING_DESIGN?><div id="ctr3" class="ctr"><?=_KMS_GL_SHOW?></div></td></tr>
</table>
  <div id="tr3" style="display:none">
  <table width=650 class="limits" cellspacing="0" cellpadding="0">
  <tr class="feature"><td class="f3"><?=_KMS_ISP_MAILING_FEATURE_TEMPLATES?><?=htip(_KMS_ISP_MAILING_FEATURE_TEMPLATES_EXPLAIN)?></td><?=explain_all("OK",$n)?></tr>
  <tr class="feature"><td class="f3"><?=_KMS_ISP_MAILING_FEATURE_URLLOAD?><?=htip(_KMS_ISP_MAILING_FEATURE_URLLOAD_EXPLAIN)?></td><?=explain_all("OK",$n)?></td></tr>
  <tr class="feature"><td class="f3"><?=_KMS_ISP_MAILING_FEATURE_TEMPLATE_LANG?><?=htip(_KMS_ISP_MAILING_FEATURE_TEMPLATE_LANG_EXPLAIN)?></td><?=explain_all("OK",$n)?></tr>
  <tr class="feature"><td class="f3"><?=_KMS_ISP_MAILING_FEATURE_DYNAMIC?><?=htip(_KMS_ISP_MAILING_FEATURE_DYNAMIC_EXPLAIN)?></td><?=explain_all("OK",$n)?></td></tr>
  <tr class="feature"><td class="f3"><?=_KMS_ISP_MAILING_FEATURE_CODEBARS?><?=htip(_KMS_ISP_MAILING_FEATURE_CODEBARS_EXPLAIN)?></td><?=explain_all("OK",$n)?></td></tr>

</table>
</div>

<table width=650 class="limits" cellspacing="0" cellpadding="0">
  <tr><td colspan="<?=$n+1?>" style="height:10px"></td></tr>
  <tr class="group"><td colspan="<?=$n+1?>" onclick="toggleFeatures('tr4')"><?=_KMS_ISP_MAILING_ANALYTICS?><div id="ctr4" class="ctr"><?=_KMS_GL_SHOW?></div></td></tr>
</table>
  <div id="tr4" style="display:none">
  <table width=650 class="limits" cellspacing="0" cellpadding="0">
  <tr class="feature"><td class="f3"><?=_KMS_ISP_MAILING_FEATURE_FULLSTATS?><?=htip(_KMS_ISP_MAILING_FEATURE_FULLSTATS_EXPLAIN)?></td><?=explain_all("OK",$n)?></td></tr>
  <tr class="feature"><td class="f3"><?=_KMS_ISP_MAILING_FEATURE_GEO?><?=htip(_KMS_ISP_MAILING_FEATURE_GEO_EXPLAIN)?></td><?=explain_all("OK",$n)?></tr>
  <tr class="feature"><td class="f3"><?=_KMS_ISP_MAILING_FEATURE_TRACKING?><?=htip(_KMS_ISP_MAILING_FEATURE_TRACKING_EXPLAIN)?></td><?=explain_all("OK",$n)?></tr>
  <tr class="feature"><td class="f3"><?=_KMS_ISP_MAILING_FEATURE_XLSREPORT?><?=htip(_KMS_ISP_MAILING_FEATURE_XLSREPORT_EXPLAIN)?></td><?=explain_all("OK",$n)?></tr>
</table>
</div>


<table width=650 class="limits" cellspacing="0" cellpadding="0">
  <tr><td colspan="<?=$n+1?>" style="height:10px"></td></tr>
  <tr class="group"><td colspan="<?=$n+1?>" onclick="toggleFeatures('tr6')"><?=_KMS_ISP_MAILING_INTEGRATION?><div id="ctr6" class="ctr"><?=_KMS_GL_SHOW?></div></td></tr>
</table>
  <div id="tr6" style="display:none">
  <table width=650 class="limits" cellspacing="0" cellpadding="0">
  <tr class="feature"><td class="f3"><?=_KMS_ISP_MAILING_FEATURE_KMSINTEGRATION?><?=htip(_KMS_ISP_MAILING_FEATURE_KMSINTEGRATION_EXPLAIN)?></td><?=explain_all("OK",$n)?></td></tr>
  <tr class="feature"><td class="f3"><?=_KMS_ISP_MAILING_FEATURE_WEBINTEGRATION?><?=htip(_KMS_ISP_MAILING_FEATURE_WEBINTEGRATION_EXPLAIN)?></td><?=explain_all("OK",$n)?></td></tr>
  <tr class="feature"><td class="f3"><?=_KMS_ISP_MAILING_FEATURE_FBINTEGRATION?><?=htip(_KMS_ISP_MAILING_FEATURE_WEBINTEGRATION_EXPLAIN)?></td><?=explain_all("OK",$n)?></td></tr>
  <tr class="feature"><td class="f3"><?=_KMS_ISP_MAILING_FEATURE_APIINTEGRATION?><?=htip(_KMS_ISP_MAILING_FEATURE_WEBINTEGRATION_EXPLAIN)?></td><?=explain_all("OK",$n)?></td></tr>


</table>
</div>

<table width=650 class="limits" cellspacing="0" cellpadding="0">
<tr><td colspan="<?=$n+1?>" style="height:10px"></td></tr>
<tr class="group"><td colspan="<?=$n+1?>" onclick="toggleFeatures('tr7')"><?=_KMS_ISP_MAILING_SUPPORT?><div id="ctr7" class="ctr"><?=_KMS_GL_SHOW?></div></td></tr>
</table>

<div id="tr7" style="display:none">
<table width=650 class="limits" cellspacing="0" cellpadding="0">
<tr class="feature"><td class="f3"><?=_KMS_ISP_HOSTING_FEATURE_SUPPORT_PHONE?></td><?=explain_all("OK",$n)?></tr>
<tr class="feature"><td class="f3"><?=_KMS_ISP_HOSTING_FEATURE_SUPPORT_EMAIL?></td><?=explain_all("OK",$n)?></tr>

</table>
</div>


<table width=650 class="limits" cellspacing="0" cellpadding="0">
  <tr><td colspan="<?=$n+1?>" style="height:10px"></td></tr>
  <tr class="group"><td colspan="<?=$n+1?>" onclick="toggleFeatures('tr8')"><?=_KMS_ISP_HOSTINGS_F_TERMS?><div id="ctr8" class="ctr"><?=_KMS_GL_SHOW?></div></td></tr>
</table>
  <div id="tr8" style="display:none">
  <table width=650 class="limits" cellspacing="0" cellpadding="0">
<tr class="feature"><td class="f3"><?=_KMS_SERVICES_SETUPPRICE?></td><?=explain_all("0 &euro;",$n)?></tr>
<tr class="feature"><td class="f3"><?=_KMS_ISP_MAILING_TARIFICACIO?></td><?=explain_all(_KMS_GL_MONTHLY,$n)?></tr>
  <tr class="feature"><td class="f3"><?=_KMS_ISP_HOSTING_FEATURE_TERMS_PAYMENTM?></td><?=explain_all(_KMS_GL_OPTIONAL,$n)?></tr>
  <tr class="feature"><td class="f3"><?=_KMS_ISP_HOSTING_FEATURE_TERMS_MINPERIOD?></td><?=explain_all(_KMS_GL_NONE,$n)?></tr>
</table>
</div>

<table width=650 class="limits" cellspacing="0" cellpadding="0">
  <tr><td colspan="<?=$n+1?>" style="height:10px"></td></tr>
  <tr class="group"><td colspan="<?=$n+1?>" onclick="toggleFeatures('tr9')"><?=_KMS_ISP_MAILING_PRICING?><div id="ctr9" class="ctr"><?=_KMS_GL_SHOW?></div></td></tr>
</table>
  <div id="tr9" style="display:none">
  <table width=650 class="limits" cellspacing="0" cellpadding="0">
<? $sel="select * from kms_ecom_services_limits where service=19 order by ABS(price) asc";
   $res=mysqli_query($sel);
   while ($tarifa=mysqli_fetch_array($res)) {?>
  <tr class="feature"><td class="f3" style='text-align:right;padding-right:20px;width:280px'><?=$tarifa['from_value']." "._KMS_GL_TO." ".$tarifa['to_value']." emails/".strtolower(_KMS_GL_MONTH)?></td><?=explain_all($tarifa['price']." &euro;",$n)?></tr>
  <? } ?>

</table>
</div>
<table width=650 class="limits" cellspacing="0" cellpadding="0">
  <tr><td colspan="<?=$n+1?>" style="height:10px"></td></tr>
  <tr class="group"><td colspan="<?=$n+1?>" onclick="toggleFeatures('tr10')"><?=_KMS_ISP_HOSTING_EXTRA_SERVICES?><div id="ctr10" class="ctr"><?=_KMS_GL_SHOW?></div></td></tr>
</table>
  <div id="tr10" style="display:none">
  <table width=650 class="limits" cellspacing="0" cellpadding="0">
  <tr class="feature"><td class="f3"><?=_KMS_ISP_HOSTING_FEATURE_BRANDING?><?=htip(_KMS_ISP_MAILING_FEATURE_BRANDING_EXPLAIN)?></td><?=explain_all("OK",$n)?></tr>
  <tr class="feature"><td class="f3"><?=_KMS_ISP_HOSTING_FEATURE_DIP?></td><?=explain_all("15 &euro;/".strtolower(_KMS_GL_MONTHLY_U),$n)?></tr>
  <tr class="feature"><td class="f3"><?=_KMS_ISP_HOSTING_FEATURE_SPACE?></td><?=explain_all("5 &euro;/GB/".strtolower(_KMS_GL_YEAR_U),$n)?></tr>
  <tr class="feature"><td class="f3"><?=_KMS_ISP_HOSTING_FEATURE_CERT?></td><?=explain_all(str_replace("?","&euro;",_KMS_ISP_HOSTING_FEATURE_CERT_EXPLAIN),$n)?></tr>
  <tr class="feature"><td class="f3"><?=_KMS_ISP_MAILING_FEATURE_CUSTOMDESIGN?></td><?=explain_all("OK",$n)?></tr>
  <tr class="feature"><td class="f3"><?=_KMS_ISP_MAILING_FEATURE_CUSTOMDB?></td><?=explain_all("OK",$n)?></tr>
  <tr class="feature"><td class="f3"><?=_KMS_ISP_MAILING_FEATURE_BOOKING?><?=htip(_KMS_ISP_MAILING_FEATURE_BOOKING_EXPLAIN)?></td><?=explain_all("OK",$n)?></td></tr>
</table>
</div>

<br><?=contract_buttons($n)?>
<br>
<br>

      </td>
      <td></td>
</tr>
<tr class="sep2">
<td></td>
<td width=500 style="padding:0px">
<input type="hidden" name="activate" id="activate" value=1>
<input type="hidden" name="type" id="type" value="<?=$_POST['type']?>">
<input type="hidden" name="contractar" value="1">
<div id="conditions" style="display:none">
<div style="padding-left:35px;padding-bottom:4px;"><h3><?=_KMS_ISP_HOSTINGS_TERMS_TITLE?></h3></div>
<?=_KMS_ISP_HOSTINGS_SERVERS_TERMS?>
<center><br><br><input type="button" class="customButton" value="<?=_KMS_GL_CLOSE?>" onclick="closePopup()"></center>
</div>
<? /*
<div style="float:left"><input type="checkbox" id="accept" name="accept" style="margin:0px;padding:0px;width:auto"></div>
<div style="float:left;padding-left:5px;padding-top:3px">
<?
$link="<a href=\"#\" style=\"font-size:13px\" onclick=\"openPopup('text',$('#conditions').html(),650,410)\">"._KMS_ECOM_CONTRACTS_CONDITIONS."</a>";

 if (!$new) {
 	if ($_SESSION['lang']=="ct") $condicions=str_replace("condicions del contracte",$link,strip_tags(_KMS_ISP_HOSTING_ACCEPT_CHANGES));
	else if ($_SESSION['lang']=="es") $condicions=str_replace("condiciones del contrato",$link,strip_tags(_KMS_ISP_HOSTING_ACCEPT_CHANGES));
	else if  ($_SESSION['lang']=="en") $condicions=str_replace("contract conditions",$link,strip_tags(_KMS_ISP_HOSTING_ACCEPT_CHANGES));
	else if ($_SESSION['lang']=="eu") $condicions=str_replace("condiciones del contrato",$link,strip_tags(_KMS_ISP_HOSTING_ACCEPT_CHANGES));
	echo $condicions;
  } else {
	if ($_SESSION['lang']=="ct") $condicions2=str_replace("condicions",$link,strip_tags(_KMS_ISP_HOSTING_ACCEPT));
	else if ($_SESSION['lang']=="es") $condicions2=str_replace("condiciones",$link,strip_tags(_KMS_ISP_HOSTING_ACCEPT));
	else if  ($_SESSION['lang']=="en") $condicions2=str_replace("terms and conditions",$link,strip_tags(_KMS_ISP_HOSTING_ACCEPT));
	else if ($_SESSION['lang']=="eu") $condicions2=str_replace("condiciones",$link,strip_tags(_KMS_ISP_HOSTING_ACCEPT));
	echo $condicions2;
  } 
*/?>
</div>
<br><br><br>
&nbsp;
<input class="customButton big" type="button" value="<?=_404_RTS?>" style="cursor:pointer;cursor:hand;width:100px;text-align:center" onclick="history.back()">
</form>
</td>
<td></td>
</tr>
</table>
<script language="javascript">
function submitform(v) {
	$('#formkms').submit(); return true; 
	//if ($('#accept').attr('checked')) { $('#formkms').submit(); return true; }  else  {  alert(unescape("<?=alert_accents(_KMS_WEB_USER_MUSTACCEPTCONDITIONS)?>"));return false;  }
};

function changeplan(plan) {
	color0="#eee";
	color1="#f7f7f7";
	$('td.col0').css('background-color',color0);
	$('td.col1').css('background-color',color0);
	$('td.col2').css('background-color',color0);
	$('td.col3').css('background-color',color0);
	$('td.col4').css('background-color',color0);
	$('td.col5').css('background-color',color0);
	$('td.common').css('background-color',color1);	
	$('td.col'+plan).css('background-color',color1);

}
function toggleFeatures(tr) {
	$('div#'+tr).slideToggle('fast');
	if ($('div#c'+tr).html()=='<?=_KMS_GL_SHOW?>') $('div#c'+tr).html('<?=_KMS_GL_HIDE?>'); else $('div#c'+tr).html('<?=_KMS_GL_SHOW?>');
        setTimeout('refreshUI()',200);
}

</script>
<? } ?>
