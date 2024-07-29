<?
$t=0;
if ($_GET['mod']=="isp_domains") {
	$sel = "SELECT id,status,name from kms_isp_domains where id=".$id;
	$res=mysqli_query($this->dm->dblinks['client'],$sel);
	$domain=mysqli_fetch_assoc($res);

	$sel = "SELECT name,dns_zone_id from kms_isp_hostings_vhosts where name='".$domain['name']."'";
	$res=mysqli_query($this->dm->dblinks['client'],$sel);
	$vhost=mysqli_fetch_assoc($res);

} else if ($_GET['mod']=="isp_hostings_vhosts") {
	$sel = "SELECT  name,dns_zone_id from kms_isp_hostings_vhosts where id=".$id;
	$res=mysqli_query($this->dm->dblinks['client'],$sel);
        $vhost=mysqli_fetch_assoc($res);
	$sel = "SELECT id,status,name from kms_isp_domains where name='".$vhost['name']."'";
	$res=mysqli_query($this->dm->dblinks['client'],$sel);
	$domain=mysqli_fetch_assoc($res);
}


if ($domain['status']=="LOCK"||$domain['status']=="ACTIVE") { $icon="r-blue.png"; $action="/?app=".$_GET['app']."&mod=isp_domains&_=e&id=".$domain['id']; $title=_KMS_ISP_DOMAIN_ACTIVE_ACTION;}
else if ($domain['status']=="PENDING") { $icon="r-grey.png";$action="/?_=f&id=&app=".$_GET['app']."&mod=isp_domains&action=add_domain&query=".$domain['name']."&tld="; $title=_KMS_ISP_DOMAIN_PENDING_ACTION; }
else if ($domain['status']=="EXPIRED") { $icon="r-red.png";$action="/?_=f&id=&app=".$_GET['app']."&mod=isp_domains&action=add_domain&query=".$domain['name']."&tld="; $title=_KMS_ISP_DOMAIN_EXPIRED_ACTION; }
else if ($domain['status']=="DELETE") { $icon="r-blue_delete.png";$action="/?_=f&id=&app=".$_GET['app']."&mod=isp_domains&action=add_domain&query=".$domain['name']."&tld="; $title=_KMS_ISP_DOMAIN_DELETE_ACTION; }
else if ($domain['status']=="") { $domain['name']=$vhost['name']; $icon="r-green.png";$action="/?_=f&id=&app=".$_GET['app']."&mod=isp_domains&action=add_domain&query=".$domain['name']."&tld="; $title=_KMS_ISP_DOMAIN_EXT_REG_ACTION; }
	
$sel = "SELECT status from kms_isp_dns_zones where id=".$vhost['dns_zone_id'];
$res=mysqli_query($this->dm->dblinks['client'],$sel);
$dns=mysqli_fetch_array($res);

//if ($vhost['dns_zone_id']==0&&$domain['nameserver1']=="ns3.intergridnetwork.net"&&$domain['status']!="PENDING") { $icon="r-orange.png"; $title="1."._KMS_ISP_DOMAIN_DNS_CONFLICT_ACTION." ".$title; }

//if ($vhost['dns_zone_id']!=0&&$dns['status']==0) { $icon="r-orange.png"; $title="2."._KMS_ISP_DOMAIN_DNS_CONFLICT_ACTION." ".$title; }
//if ($vhost['dns_zone_id']==0) { $icon="r-orange.png"; $title="2."._KMS_ISP_DOMAIN_DNS_CONFLICT_ACTION." ".$title; }

$out="<div class='icon_status'><a href=\"".$action."\" title=\"".$title."\"><img src=\"/kms/css/aqua/img/small/$icon\"></a></div><div style='float:inherit;padding-top:2px;'>".$domain['name']."</div>";
	
?>
