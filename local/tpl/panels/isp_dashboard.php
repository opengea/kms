<?
// Control Panel Dashboard

$s =_KMS_ISP_CP_WELCOME;
$s.="<br><br>";

//get data
$sel="SELECT * FROM kms_isp_clients where sr_user=".$user_account['id'];

$result=mysqli_query($this->dblinks['client'],$sel);
$client=mysqli_fetch_array($result);

if ($_GET['app']!="cp-admin"&&$_GET['app']!="sysadmin") $sel_add="WHERE sr_client='".$client['sr_client']."'";
if ($_GET['app']=="cp-reseller") $sel_add="WHERE kms_isp_hostings_vhosts.sr_client in (select kms_isp_clients.sr_client from kms_isp_clients where kms_isp_clients.sr_provider=".$client['sr_client'].")";

$sel ="SELECT count(*) from kms_isp_hostings_vhosts $sel_add";
$result=mysqli_query($this->dblinks['client'],$sel);
$num_vhosts=mysqli_fetch_array($result);

if ($_GET['app']=="cp-reseller") $sel_add="WHERE kms_isp_domains.sr_client in (select kms_isp_clients.sr_client from kms_isp_clients where kms_isp_clients.sr_provider=".$client['sr_client'].")";

$sel ="SELECT count(*) from kms_isp_domains $sel_add";
$result=mysqli_query($this->dblinks['client'],$sel);
$domains=mysqli_fetch_array($result);

if ($_GET['app']=="cp-reseller") $sel_add="WHERE isp_client_id in (select id from kms_isp_clients where sr_provider=".$client['sr_client'].")";

$sel ="SELECT count(*) from kms_isp_hostings $sel_add AND `type`!='Dedicated Server'";
$result=mysqli_query($this->dblinks['client'],$sel);
$hostings=mysqli_fetch_array($result);
$sel ="SELECT count(*) from kms_isp_hostings $sel_add AND `type`='Dedicated Server'";
$result=mysqli_query($this->dblinks['client'],$sel);
$dedicated=mysqli_fetch_array($result);

if ($_GET['app']=="cp-reseller") $sel_add="WHERE kms_isp_invoices.sr_client in (select sr_client from kms_isp_clients where sr_provider=".$client['sr_client'].")";

$sel_add=str_replace("WHERE ","AND ",$sel_add);
$sel ="SELECT count(*) from kms_isp_invoices WHERE (status='pendent' or status='impagada' or status='retornat') $sel_add";
$result=mysqli_query($this->dblinks['client'],$sel);
$invoices=mysqli_fetch_array($result);

$content=_KMS_ISP_REGISTERED_DOMAINS.": ".$domains[0];
$buttons=array(_KMS_ISP_MANAGE=>"/?app=".$_GET['app']."&mod=isp_domains",_KMS_ISP_NEW_DOMAIN=>"/?app=cp&mod=isp_domains&_=f&action=add_domain&id=");
$s.=widget("isp_domains",_KMS_TY_ISP_DOMAINS,$content,"/?app=".$_GET['app']."&mod=isp_domains",$buttons);

$content="<select name='mailbox_vhost' style=\"width:181px\" onchange=\"if (this.value!='') $('input#bt_isp_mailboxes').attr('onclick','document.location=\'/?app=".$_GET['app']."&mod=isp_mailboxes&xid='+this.value+'\''); else  $('input#bt_isp_mailboxes').attr('onclick','document.location=\'#\''); \">";
$content.="<option value=''>"._KMS_ISP_SELECT_DOMAIN.":</option>";
if ($_GET['app']=="cp-reseller") $sel_add="AND kms_isp_hostings_vhosts.sr_client in (select sr_client from kms_isp_clients where sr_provider=".$client['sr_client'].")";
$sel ="SELECT * from kms_isp_hostings_vhosts where status='active' and mailserver_id!=0 $sel_add order by name";
$result=mysqli_query($this->dblinks['client'],$sel); while ($vhost=mysqli_fetch_array($result)) { $content.="<option value='".$vhost['id']."'>".$vhost['name']."</option>"; }
$content.="</select>";
$buttons=array(_KMS_ISP_MANAGE=>"#");//,_KMS_ISP_HOSTINGS_ADD=>"/?_=f&id=&app=cp&mod=isp_mailboxes&xid=".$xid."&_=i");
//$s.=widget("isp_mailboxes",_KMS_TY_ISP_MAILBOXES,$content,"/?app=".$_GET['app']."&mod=isp_mailboxes",$buttons);
$s.=widget("isp_mailboxes",_KMS_TY_ISP_MAILBOXES,$content,"#",$buttons);

$content=_KMS_ISP_HOSTING_PLANS.": ".$hostings[0]."<br>"._KMS_TY_ISP_SERVERS.": ".$dedicated[0];
$buttons=array(_KMS_ISP_MANAGE=>"/?app=".$_GET['app']."&mod=isp_hostings",_KMS_ISP_HOSTINGS_ADD=>"/?_=f&id=&app=cp&mod=isp_hostings&action=new_hosting");
$s.=widget("isp_hostings",_KMS_TY_ISP_HOSTINGS,$content,"/?app=".$_GET['app']."&mod=isp_hostings",$buttons);

$content=_KMS_ISP_DOMAIN_SERVICES.": ".$num_vhosts[0];
$buttons=array(_KMS_ISP_MANAGE=>"/?app=".$_GET['app']."&mod=isp_hostings_vhosts");
$s.=widget("isp_hostings_vhosts",_KMS_TY_ISP_HOSTINGS_VHOSTS,$content,"/?app=".$_GET['app']."&mod=isp_hostings_vhosts",$buttons);

$content=_KMS_ISP_CLIENTS_COMPLETED_DATA.": 90%";
$buttons=array(_KMS_ISP_MANAGE=>"/?app=".$_GET['app']."&mod=isp_clients");
$s.=widget("contacts_clients",_KMS_TY_ISP_CLIENTS,$content,"/?app=".$_GET['app']."&mod=isp_clients&action=edit_client",$buttons);

if ($invoices[0]>0) $content="<span style='color:#e00'>"._KMS_ISP_INVOICES_PENDING.": ".$invoices[0]."</span>"; else $content=_KMS_ISP_INVOICES_PENDING.": ".$invoices[0];
$buttons=array(_KMS_ISP_VIEW_INVOICES=>"/?app=".$_GET['app']."&mod=isp_invoices");
$s.=widget("isp_invoices",_KMS_TY_ISP_INVOICES,$content,"/?app=".$_GET['app']."&mod=isp_invoices",$buttons);

$content=_KMS_ISP_MESSAGES_SERVICE_UPDATES.": 0<br>"._KMS_ISP_MESSAGES_WARNINGS.": 0";
$buttons=array();
$s.=widget("isp_messages",_KMS_TY_ISP_MESSAGES,$content,"/?app=".$_GET['app']."&mod=isp_messages",$buttons);

$content=_KMS_ISP_SUPPORT_PENDING_TICKETS.": 0";
$buttons=array(_KMS_ISP_NEW_SUPPORT=>"/?app=".$_GET['app']."&mod=isp_support");
$s.=widget("isp_support",_KMS_TY_ISP_SUPPORT,$content,"/?app=".$_GET['app']."&mod=isp_support",$buttons);
$sel="SELECT * from kms_isp_offers WHERE end_date>'".date('Y-m-d')."' and status='active' limit 1";
$result_offers=mysqli_query($this->dblinks['client'],$sel);
$content="<ul>";
if ($_SESSION['lang']=="eu") $lang="es"; else $lang=$_SESSION['lang'];
while ($offer=mysqli_fetch_array($result_offers)) {
	$content.="<li><a href=\"".$offer['link_'.$_SESSION['lang']]."\">".$offer['title_'.$lang]."</a></li>";
}
$content.="</ul>";
$buttons=array();
$s.=widget("isp_offers",_KMS_TY_ISP_OFFERS,$content,"",$buttons);

function widget($ico,$title,$content,$link,$buttons) {
	$buttons_html="";
	foreach ($buttons as $name=>$blink) {
		$buttons_html.="<input id=\"bt_{$ico}\" type='button' onclick=\"document.location='$blink'\" value=\"$name\">";
	}
	$s="<div class='widget'><a href='{$link}'><div style='margin-bottom:3px;margin-left:-3px'><img src='/kms/css/aqua/img/apps/{$ico}.png'></div><strong>{$title}</strong></a><div class='details'>{$content}</div>{$buttons_html}</div>";

	return $s; 
}



$params=array("title"=>_KMS_SERVICES_CP,"height"=>"220px","buttons"=>"","content"=>$s,"defaultMod"=>"","infotable"=>"","hide_databrowser"=>true);
$this->setPanel($params);
?>
