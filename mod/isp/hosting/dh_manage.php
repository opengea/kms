<?
// ----------------------------------------------
// Intergrid KMS Dedicated Hosting Selector
// By Jordi Berenguer <j.berenguer@intergrid.cat>
// www.intergrid.cat
// ----------------------------------------------
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
        $sel="SELECT * FROM intergrid_kms_erp.kms_ecom_services inner join kms_ecom_products on kms_ecom_services.product_id=kms_ecom_products.id and kms_ecom_services.subfamily=4 and kms_ecom_services.family=2 where  kms_ecom_products.status='active' order by kms_ecom_products.id asc";
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

        $sel="SELECT * FROM intergrid_kms_erp.kms_ecom_services where status='active' and kms_ecom_services.subfamily=4 and kms_ecom_services.family=2 order by id asc";
        $res=mysqli_query($sel);
        $n=0; $out="";
        while ($product=mysqli_fetch_array($res)) {
                $out.="<td class='col{$n}' style='text-align:center;border-bottom:1px solid #ccc;border-left:1px solid #ccc'><input class='order' type='button' onclick=\"submitform('{$product['id']}'); \" value='".strtolower(_KMS_ECOM_ORDERNOW)."'></td>";
                $n++;
        }
        return $out;

}

function htip($value) {
        return "<div class=\"htip\" title=\"".$value."\"></div>";
}


if ($_GET['id']=="") $new=1; else $new=0;
if ($_POST['sr_ecom_service']!="") {
	//submit new server

	if ($this->user_account['id']==1) die("option not available for admin");
	if ($_GET['app']!="sysadmin"&&$_GET['app']!="cp-admin") { 
		$select="SELECT * FROM kms_isp_clients where sr_user=".$this->user_account['id'];
		$result=mysqli_query($select);
		if (!$result) die(mysqli_error($result));
		$client=mysqli_fetch_array($result);
		$addcheck=" AND sr_client=".$client['id']; // no es sr_client??
	} else {
		$addcheck="";
	}

	// -------------- NEW HOSTING -------------------
	$client=$this->dbi->get_record("SELECT * FROM kms_isp_clients where sr_user=".$this->user_account['id'],$dblink_cp);
	$contract=array("creation_date"=>date('Y-m-d H:i:s'),"status"=>"pending","sr_client"=>$client['sr_client'],"sr_ecom_service"=>$_POST['sr_ecom_service'],"initial_date"=>date('Y-m-d H:i:s'),"end_date"=>date('Y-m-d H:i:s'),"billing_period"=>"1M","auto_renov"=>1,"alta"=>0,"price"=>$quota_show,"payment_method"=>$client['sr_payment_method'],"invoice_pending"=>1);
	$contract['id']=$this->dbi->insert_record("kms_erp_contracts",$contract,$dblink_erp);
	$contracts = new erp_contracts($this->client_account,$this->user_account,$this->dm);
	$contract['isp_client_id']=$client['id'];
	$contracts->onInsert($contract,$contract['id']);
	//redirect to hostings...
        echo "<br><br>"._KMS_WEB_ECOM_NEWPURCHASE."<br><br><br><input type='button' onclick=\"document.location='/?app=".$_GET['app']."&mod=isp_hostings';\" value=\""._KMS_GL_CONTINUE."\">";
//	echo "<script language='javascript'>document.location='/?app=".$_GET['app']."&mod=isp_hostings';</script>";

} else {
// ----------------- MANAGE ----------------------

if ($_GET['id']!="") {
        $hosting=$this->dbi->get_record("select * from kms_isp_hostings WHERE id=".$_GET['id'],$dblink_cp);
	$contract=$this->dbi->get_record("select * from kms_erp_contracts WHERE id=".$hosting['sr_contract'],$dblink_erp);
	echo "manage existing hosting";

} else {
	// new dedicated server form

	$sel="select * from kms_ecom_products where status='active' and family=2 and subfamily=4 order by id";
	$res=mysqli_query($sel);
}
?>
<form action="/?_=f&id=<?=$_GET['id']?>&app=<?=$_GET['app']?>&mod=<?=$_GET['mod']?>&action=<?=$_GET['action']?>" id="formdh" name="manage" method="post">
<table width=600>
<tr>
    <td width=0></td>
    <td>
	<h2><?
	if ($_REQUEST['type']!="") {
		echo _KMS_ISP_SELECT_SERVER;
	} else echo _KMS_ISP_HOSTING_MANAGE." : ".$hosting['domain'];
	?></h2>
	<span style="line-height:150%;color:#444;font-size:12px"><?echo _KMS_ISP_SELECT_SERVER_EXPLAIN?></span><br><br>
<br><br>
    </td>
    <td></td>
</tr>
</table>
<br>
<table width=960 class="limits" cellspacing="0" cellpadding="0">
<tr>
    <td class="slider_name" style="width:60px;padding-bottom:0px;height:40px"></td>

<? 
$colors=array("#B7E2F3","#83CAFF","#3494E7","#0066CC","#0D549E","#184475");
$colors=array("#598ACA","#477DBB","#336DAA","#2864A0","#11538D","#054A83");
$n=0; while ($product=mysqli_fetch_array($res)) {
if ($n==0) $css_add="-webkit-border-radius: 5px 0px 0px 0px; -moz-border-radius: 5px 0px 0px 0px; border-radius: 5px 0px 0px 0px;";
                                else if ($n==5) $css_add="-webkit-border-radius: 0px 5px 0px 0px; -moz-border-radius: 5px; border-radius: 0px 5px 0px 0px;";
                                else $css_add="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius: 0px;";
?>
<td style="background-color:<?=$colors[$n]?>;width:90px;padding-left:20px;<?=$css_add?>;padding-bottom:0px"><div style="float:left"><input id="pla<?=$n?>" type="radio" value="start" name="pla" onchange="changeplan(<?=$n?>)"<? if ($client_plan=="start") echo " checked"?>></div><div class="plan"><div style="position:absolute;margin-top:-35px;margin-left:-10px"><a href="#" onclick="$('input#pla<?=$n?>').click()"><img src="/kms/css/aqua/img/big/dedicated-servers_ico.png" width=50></a></div><a href="#" onclick="$('input#pla<?=$n?>').click()"><?=$product['ref']?></a></div></td>
<? 
$n++;
} ?>
</tr>
<tr class="feature"><td class="f2"><?=_KMS_SERVICES_MONTHLYPRICE?></td><?=explain_feature("monthlyPrice",$colors)?></tr>
<tr class="feature"><td class="f2"><?=_KMS_SERVICES_SETUPPRICE?></td><?=explain_feature("setupPrice")?></tr>
<tr class="feature"><td class="f2"><?=_KMS_WEB_ECOM_TAXNOTINCLUDED?></td><?=contract_buttons($n)?></tr>
<tr class="feature"><td class="f2"><?=_KMS_ISP_SERVERS_CPUS?></td><?=explain_feature("cpu")?></tr>
<tr class="feature"><td class="f2"><?=_KMS_ISP_SERVERS_CPU_VIRT?><?=htip(_KMS_ISP_SERVERS_CPU_VIRT_EXPLAIN)?></td><?=explain_all("OK",$n)?></tr>
<tr class="feature"><td class="f2"><?=_KMS_ISP_SERVERS_RAM?></td><?=explain_feature("ram")?></tr>
<tr class="feature"><td class="f2"><?=_KMS_ISP_SERVERS_DISK?></td><?=explain_feature("hd")?></tr>
<tr class="feature"><td class="f2"><?=_KMS_ISP_SERVERS_NIC?></td><?=explain_span(_KMS_ISP_SERVERS_NIC_EXPLAIN,$n)?></tr>
<tr class="feature"><td class="f2"><?=_KMS_ISP_HOSTINGS_TRANSFER?></td><?=explain_all(_KMS_GL_UNLIMITED4,$n)?></tr>
<tr class="feature"><td class="f2"><?=_KMS_ISP_HOSTING_FEATURE_DIP?></td><?=explain_all("1",$n)?></tr>
<tr class="feature"><td class="f2"><?=_KMS_GL_DELIVERY?></td><?=explain_all(_KMS_ISP_HOSTING_FEATURE_DELIVERY_EXPLAIN,$n)?></tr>

<table width=960 class="limits" cellspacing="0" cellpadding="0">
<tr><td colspan="<?=$n+1?>" style="height:10px"></td></tr>
<tr class="group"><td colspan="<?=$n+1?>" onclick="toggleFeatures('tr1')"><?=_KMS_ISP_HOSTINGS_F_ADMIN?><div id="ctr1" class="ctr"><?=_KMS_GL_HIDE?></div></td></tr>
</table>

  <div id="tr1">
  <table width=960 class="limits" cellspacing="0" cellpadding="0">
  <tr class="feature"><td class="f2"><?=_KMS_ISP_HOSTING_FEATURE_ADMIN?><?=htip(_KMS_ISP_HOSTING_FEATURE_ADMIN_EXPLAIN)?></td><?=explain_all("OK",$n)?></tr>
  <tr class="feature"><td class="f2"><?=_KMS_ISP_HOSTING_FEATURE_CONTROLPANEL?><?=htip(_KMS_ISP_HOSTING_FEATURE_CP_EXPLAIN)?></td><?=explain_all("OK",$n)?></tr>
  <tr class="feature"><td class="f2"><?=_KMS_ISP_HOSTING_FEATURE_CP_DOMAINROBOT?><?=htip(_KMS_ISP_HOSTING_FEATURE_CP_DOMAINROBOT_EXPLAIN)?></td><?=explain_all("OK",$n)?></td></tr>
  <tr class="feature"><td class="f2"><?=_KMS_ISP_HOSTING_FEATURE_DNS?></td><?=explain_all("OK",$n)?></tr>
  <tr class="feature"><td class="f2"><?=_KMS_ISP_HOSTING_FEATURE_REVERSEDNS?></td><?=explain_all("OK",$n)?></tr>
  <tr class="feature"><td class="f2"><?=_KMS_ISP_HOSTING_FEATURE_SSH?><?=htip(_KMS_ISP_HOSTING_FEATURE_SSH_EXPLAIN)?></td><?=explain_all("OK",$n)?></tr>
  <tr class="feature"><td class="f2"><?=_KMS_ISP_HOSTING_FEATURE_ALERTS?><?=htip(_KMS_ISP_HOSTING_FEATURE_ALERTS_EXPLAIN)?></td><?=explain_all("OK",$n)?></tr>
  </table>
  </div>

<table width=960 class="limits" cellspacing="0" cellpadding="0">
<tr><td colspan="<?=$n+1?>" style="height:10px"></td></tr>
<tr class="group"><td colspan="<?=$n+1?>" onclick="toggleFeatures('tr3')"><?=_KMS_ISP_HOSTINGS_F_DATACENTER?><div id="ctr3" class="ctr"><?=_KMS_GL_SHOW?></div></td></tr>
</table>
<div id="tr3" style="display:none">
<table width=960 class="limits" cellspacing="0" cellpadding="0">
<tr class="feature"><td class="f2"><?=_KMS_ISP_HOSTING_FEATURE_BANDWIDTH?></td><?=explain_all(_KMS_ISP_HOSTING_FEATURE_BANDWIDTH_EXPLAIN,$n)?></tr>
<tr class="feature"><td class="f2"><?=_KMS_ISP_HOSTING_FEATURE_AVAIL?></td><?=explain_span(_KMS_ISP_HOSTING_FEATURE_SLA_EXPLAIN,$n)?></tr>
<tr class="feature"><td class="f2"><?=_KMS_ISP_HOSTING_FEATURE_MONITORING?></td><?=explain_all("OK",$n)?></tr>
<tr class="feature"><td class="f2"><?=_KMS_TY_ISP_DATACENTER_TIER3?></td><?=explain_all("OK",$n)?></tr>
<tr class="feature"><td class="f2"><?=_KMS_TY_ISP_DATACENTER_LOCATION?></td><?=explain_all(_KMS_TY_ISP_DATACENTER_LOCATION_EXPLAIN,$n)?></tr>
<tr class="feature"><td class="f2"><?=_KMS_ISP_HOSTING_FEATURE_DC_CERT?></td><?=explain_all(_KMS_ISP_HOSTING_FEATURE_DC_CERT_EXPLAIN,$n)?></tr>
<tr class="feature"><td class="f2"><?=_KMS_ISP_HOSTING_FEATURE_NETWORK?></td><?=explain_span(_KMS_ISP_HOSTING_FEATURE_NETWORK_EXPLAIN,$n)?></tr>
</table>
</div>

<table width=960 class="limits" cellspacing="0" cellpadding="0">
<tr><td colspan="<?=$n+1?>" style="height:10px"></td></tr>
<tr class="group"><td colspan="<?=$n+1?>" onclick="toggleFeatures('tr2')"><?=_KMS_ISP_HOSTINGS_F_WARANTY?><div id="ctr2" class="ctr"><?=_KMS_GL_SHOW?></div></td></tr>
</table>
<div id="tr2" style="display:none">
<table width=960 class="limits" cellspacing="0" cellpadding="0">
<tr class="feature"><td class="f2"><?=_KMS_ISP_HOSTING_FEATURE_SLA?></td><?=explain_all("OK",$n)?></td></tr>
<tr class="feature"><td class="f2"><?=_KMS_ISP_HOSTING_FEATURE_SUPPORT_PHONE?></td><?=explain_all("OK",$n)?></tr>
<tr class="feature"><td class="f2"><?=_KMS_ISP_HOSTING_FEATURE_SUPPORT_EMAIL?></td><?=explain_all("OK",$n)?></tr>
<tr class="feature"><td class="f2"><?=_KMS_ISP_HOSTING_FEATURE_SUPPORT_SYS?></td><?=explain_all("OK",$n)?></tr>
<tr class="feature"><td class="f2"><?=_KMS_ISP_HOSTING_FEATURE_30DAYSW?></td><?=explain_all("OK",$n)?></tr>
</table>
</div>

<table width=960 class="limits" cellspacing="0" cellpadding="0">
<tr><td colspan="<?=$n+1?>" style="height:10px"></td></tr>
<tr class="group sep2"><td colspan="<?=$n+1?>" onclick="toggleFeatures('tr4')"><?=_KMS_ISP_HOSTING_SOFTWARE?><div id="ctr4" class="ctr"><?=_KMS_GL_SHOW?></div></td></tr>
</table>
<div id="tr4" style="display:none">
<table width=960 class="limits" cellspacing="0" cellpadding="0">
<tr class="feature"><td class="f2"><?=_KMS_ISP_HOSTING_FEATURE_OS?><?=htip(_KMS_ISP_HOSTING_FEATURE_OS_EXPLAIN)?></td><?=explain_all(_KMS_ISP_HOSTING_FEATURE_OS_EXPLAIN,$n)?></td></tr>
<tr class="feature"><td class="f2"><?=_KMS_ISP_HOSTING_FEATURE_WEBSERVER?><?=htip(_KMS_ISP_HOSTING_FEATURE_WEBSERVER_EXPLAIN)?></td><?=explain_all("OK",$n)?></tr>
<tr class="feature"><td class="f2"><?=_KMS_ISP_HOSTING_FEATURE_MYSQL?><?=htip(_KMS_ISP_HOSTING_FEATURE_MYSQL_EXPLAIN)?></td><?=explain_all("OK",$n)?></tr>
<tr class="feature"><td class="f2"><?=_KMS_ISP_HOSTING_FEATURE_MAIL?><?=htip(_KMS_ISP_HOSTING_FEATURE_MAIL_EXPLAIN)?></td><?=explain_all("OK",$n)?></tr>
<tr class="feature"><td class="f2"><?=_KMS_ISP_HOSTING_FEATURE_DNSSERVER?><?=htip(_KMS_ISP_HOSTING_FEATURE_DNSSERVER_EXPLAIN)?></td><?=explain_all("OK",$n)?></tr>
</table>
</div>

<table width=960 class="limits" cellspacing="0" cellpadding="0">
<tr><td colspan="<?=$n+1?>" style="height:10px"></td></tr>
<tr class="group"><td colspan="<?=$n+1?>" onclick="toggleFeatures('tr5')"><?=_KMS_ISP_HOSTINGS_F_SECURITY?><div id="ctr5" class="ctr"><?=_KMS_GL_SHOW?></div></td></tr>
</table>

  <div id="tr5" style="display:none">
  <table width=960 class="limits" cellspacing="0" cellpadding="0">
  <tr class="feature"><td class="f2"><?=_KMS_ISP_HOSTING_FEATURE_FIREWALL?></td><?=explain_all("OK",$n)?></tr>
  <tr class="feature"><td class="f2"><?=_KMS_ISP_HOSTING_FEATURE_BACKUPS?><?=htip(_KMS_ISP_HOSTING_FEATURE_BACKUPS_EXPLAIN)?></td><?=explain_all("100 GB",$n)?></tr>
  <tr class="feature"><td class="f2"><?=_KMS_ISP_HOSTING_FEATURE_DIRPERM?></td><?=explain_all("OK",$n)?></tr>
  <tr class="feature"><td class="f2"><?=_KMS_ISP_HOSTING_FEATURE_DIRPROT?></td><?=explain_all("OK",$n)?></tr>
  <tr class="feature"><td class="f2"><?=_KMS_ISP_HOSTING_FEATURE_CERT?></td><?=explain_all(_KMS_GL_OPTIONAL,$n)?></tr>
  </table>
  </div>

<table width=960 class="limits" cellspacing="0" cellpadding="0">
  <tr><td colspan="<?=$n+1?>" style="height:10px"></td></tr>
  <tr class="group"><td colspan="<?=$n+1?>" onclick="toggleFeatures('tr6')"><?=_KMS_ISP_HOSTINGS_F_EMAIL?><div id="ctr6" class="ctr"><?=_KMS_GL_SHOW?></div></td></tr>
</table>

  <div id="tr6" style="display:none">
  <table width=960 class="limits" cellspacing="0" cellpadding="0">
  <tr class="feature"><td class="f2"><?=_KMS_TY_ISP_MAILBOXES?></td><?=explain_all(_KMS_GL_UNLIMITED3,$n)?></tr>
  <tr class="feature"><td class="f2"><?=_KMS_ISP_HOSTING_FEATURE_WEBMAIL?></td><?=explain_all("OK",$n)?></tr>
  <tr class="feature"><td class="f2"><?=_KMS_ISP_HOSTING_FEATURE_EMAIL_ALIAS?></td><?=explain_all("OK",$n)?></tr>
  <tr class="feature"><td class="f2"><?=_KMS_ISP_HOSTING_FEATURE_EMAIL_AUTORESPONDER?></td><?=explain_all("OK",$n)?></tr>
  <tr class="feature"><td class="f2"><?=_KMS_ISP_HOSTING_FEATURE_ANTISPAM?><?=htip(_KMS_ISP_MAILBOXES_SPAMFILTER_EXPLAIN)?></td><?=explain_all("OK",$n)?></tr>
  </table>
  </div>

<table width=960 class="limits" cellspacing="0" cellpadding="0">
  <tr><td colspan="<?=$n+1?>" style="height:10px"></td></tr>
  <tr class="group"><td colspan="<?=$n+1?>" onclick="toggleFeatures('tr7')"><?=_KMS_ISP_HOSTINGS_F_WEBSPACE?><div id="ctr7" class="ctr"><?=_KMS_GL_SHOW?></div></td></tr>
</table>

  <div id="tr7" style="display:none">
  <table width=960 class="limits" cellspacing="0" cellpadding="0">
  <tr class="feature"><td class="f2"><?=_KMS_TY_ISP_VHOSTS?></td><?=explain_all(_KMS_GL_UNLIMITED2,$n)?></tr>
  <tr class="feature"><td class="f2"><?=_KMS_ISP_HOSTING_FEATURE_FTPS?></td><?=explain_all(_KMS_ISP_HOSTING_FEATURE_FTPS_EXPLAIN,$n)?></tr>
  <tr class="feature"><td class="f2"><?=_KMS_ISP_HOSTING_FEATURE_SUBDOMAINS?></td><?=explain_all(_KMS_ISP_HOSTING_FEATURE_SUBDOMAINS_EXPLAIN,$n)?></tr>
  <tr class="feature"><td class="f2"><?=_KMS_ISP_HOSTING_FEATURE_FILEMANAGER?></td><?=explain_all("OK",$n)?></tr>
  <tr class="feature"><td class="f2"><?=_KMS_ISP_HOSTING_FEATURE_WEBSTATS?></td><?=explain_all("OK",$n)?></td></tr>
  </table>
  </div>

<table width=960 class="limits" cellspacing="0" cellpadding="0">
  <tr><td colspan="<?=$n+1?>" style="height:10px"></td></tr>
  <tr class="group"><td colspan="<?=$n+1?>" onclick="toggleFeatures('tr8')"><?=_KMS_ISP_HOSTINGS_F_PRO?><div id="ctr8" class="ctr"><?=_KMS_GL_SHOW?></div></td></tr>
</table>

  <div id="tr8" style="display:none">
  <table width=960 class="limits" cellspacing="0" cellpadding="0">
  <tr class="feature"><td class="f2"><?=_KMS_ISP_HOSTING_FEATURE_PROGRAMMING?></td><?=explain_all(_KMS_ISP_HOSTING_FEATURE_PROGRAMMING_EXPLAIN,$n)?></tr>
  <tr class="feature"><td class="f2"><?=_KMS_ISP_HOSTING_FEATURE_DATABASES?></td><?=explain_all(_KMS_GL_UNLIMITED3,$n)?></tr>
  <tr class="feature"><td class="f2"><?=_KMS_ISP_HOSTING_FEATURE_DDBB_SPACE?></td><?=explain_all(_KMS_GL_UNLIMITED,$n)?></tr>
  <tr class="feature"><td class="f2"><?=_KMS_ISP_HOSTING_FEATURE_CRONTABLES?></td><?=explain_all("OK",$n)?></tr>
  <tr class="feature"><td class="f2"><?=_KMS_ISP_HOSTING_FEATURE_ERRORPAGES?></td><?=explain_all("OK",$n)?></tr>
  <tr class="feature"><td class="f2"><?=_KMS_ISP_HOSTING_FEATURE_CMS_COMPATIBLE?></td><?=explain_all("OK",$n)?></tr>
  <tr class="feature"><td class="f2"><?=_KMS_ISP_HOSTING_FEATURE_DIRHTACCESS?></td><?=explain_all("OK",$n)?></tr>
  </table>
  </div>

<table width=960 class="limits" cellspacing="0" cellpadding="0">
  <tr><td colspan="<?=$n+1?>" style="height:10px"></td></tr>
  <tr class="group"><td colspan="<?=$n+1?>" onclick="toggleFeatures('tr9')"><?=_KMS_ISP_HOSTING_EXTRA_SERVICES?><div id="ctr9" class="ctr"><?=_KMS_GL_SHOW?></div></td></tr>
</table>
  <div id="tr9" style="display:none">
  <table width=960 class="limits" cellspacing="0" cellpadding="0">
  <tr class="feature"><td class="f2"><?=_KMS_ISP_HOSTING_FEATURE_SSD120?></td><?=explain_all(str_replace("?","&euro;",_KMS_ISP_HOSTING_FEATURE_SSD120_EXPLAIN),$n)?></tr>
  <tr class="feature"><td class="f2"><?=_KMS_ISP_HOSTING_FEATURE_SSD240?></td><?=explain_all(str_replace("?","&euro;",_KMS_ISP_HOSTING_FEATURE_SSD240_EXPLAIN),$n)?></tr>
  <tr class="feature"><td class="f2"><?=_KMS_ISP_HOSTING_FEATURE_IPV4?></td><?=explain_all(str_replace("?","&euro;",_KMS_ISP_HOSTING_FEATURE_IPV4_EXPLAIN),$n)?></tr>
<? /*  <tr class="feature"><td class="f2"><?=_KMS_ISP_HOSTING_FEATURE_SUBNET?></td><?=explain_all("OK",$n)?></tr>*/?>
  <tr class="feature"><td class="f2"><?=_KMS_ISP_HOSTING_FEATURE_CERT?></td><?=explain_all(str_replace("?","&euro;",_KMS_ISP_HOSTING_FEATURE_CERT_EXPLAIN),$n)?></tr>
  <tr class="feature"><td class="f2"><?=_KMS_ISP_HOSTING_FEATURE_KMS_MAILING?></td><?=explain_all("OK",$n)?></tr>
  <tr class="feature"><td class="f2"><?=_KMS_ISP_HOSTING_FEATURE_KMS_SITES?></td><?=explain_all("OK",$n)?></tr>
  <tr class="feature"><td class="f2"><?=_KMS_ISP_HOSTING_FEATURE_KMS_ECOM?></td><?=explain_all("OK",$n)?></tr>
</table>
</div>

<table width=960 class="limits" cellspacing="0" cellpadding="0">
  <tr><td colspan="<?=$n+1?>" style="height:10px"></td></tr>
  <tr class="group"><td colspan="<?=$n+1?>" onclick="toggleFeatures('tr10')"><?=_KMS_ISP_HOSTINGS_F_TERMS?><div id="ctr10" class="ctr"><?=_KMS_GL_SHOW?></div></td></tr>
</table>
  <div id="tr10" style="display:none">
  <table width=960 class="limits" cellspacing="0" cellpadding="0">
  <tr class="feature"><td class="f2"><?=_KMS_ISP_HOSTING_FEATURE_TERMS_PAYMENTM?></td><?=explain_all(_KMS_GL_OPTIONAL,$n)?></tr>
  <tr class="feature"><td class="f2"><?=_KMS_ISP_HOSTING_FEATURE_TERMS_MINPERIOD?></td><?=explain_all(_KMS_GL_NONE,$n)?></tr>
</table>
</div>
<br>

      </td>
      <td></td>
</tr>
<tr class="sep2">
<td></td>
<td width=500 style="padding:0px">
<input type="hidden" name="activate" id="activate" value=1>
<input type="hidden" name="type" id="type" value="<?=$_POST['type']?>">
<input type="hidden" name="sr_ecom_service" id="sr_ecom_service" value="">
<div id="conditions" style="display:none">
<div style="padding-left:35px;padding-bottom:4px;"><h3><?=_KMS_ISP_HOSTINGS_TERMS_TITLE?></h3></div>
<?=_KMS_ISP_HOSTINGS_SERVERS_TERMS?>
<center><br><br><input type="button" class="customButton" value="<?=_KMS_GL_CLOSE?>" onclick="closePopup()"></center>
</div>
<div style="float:left"><input type="checkbox" id="accept" name="accept" style="margin:0px;padding:0px;width:auto"></div>
<div style="float:left;padding-left:5px;padding-top:3px">
<?
$link="<a href=\"#\" style=\"font-size:13px\" onclick=\"openPopup('text',$('#conditions').html(),650,410)\">"._KMS_ECOM_CONTRACTS_CONDITIONS."</a>";

 if (!$new) {
 	if ($_SESSION['lang']=="ca") $condicions=str_replace("condicions del contracte",$link,strip_tags(_KMS_ISP_HOSTING_ACCEPT_CHANGES));
	else if ($_SESSION['lang']=="es") $condicions=str_replace("condiciones del contrato",$link,strip_tags(_KMS_ISP_HOSTING_ACCEPT_CHANGES));
	else if  ($_SESSION['lang']=="en") $condicions=str_replace("contract conditions",$link,strip_tags(_KMS_ISP_HOSTING_ACCEPT_CHANGES));
	else if ($_SESSION['lang']=="eu") $condicions=str_replace("condiciones del contrato",$link,strip_tags(_KMS_ISP_HOSTING_ACCEPT_CHANGES));
	echo $condicions;
  } else {
	if ($_SESSION['lang']=="ca") $condicions2=str_replace("condicions",$link,strip_tags(_KMS_ISP_HOSTING_ACCEPT));
	else if ($_SESSION['lang']=="es") $condicions2=str_replace("condiciones",$link,strip_tags(_KMS_ISP_HOSTING_ACCEPT));
	else if  ($_SESSION['lang']=="en") $condicions2=str_replace("terms and conditions",$link,strip_tags(_KMS_ISP_HOSTING_ACCEPT));
	else if ($_SESSION['lang']=="eu") $condicions2=str_replace("condiciones",$link,strip_tags(_KMS_ISP_HOSTING_ACCEPT));
	echo $condicions2;
  } 
?>
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
	$('input#sr_ecom_service').val(v);
        if ($('#accept').attr('checked')) { $('#formdh').submit(); return true; }  else  {  alert(unescape("<?=alert_accents(_KMS_WEB_USER_MUSTACCEPTCONDITIONS)?>"));return false;  }
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
