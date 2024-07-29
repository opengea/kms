<?
if ($_GET['xid']!="") {
$select="select * from kms_isp_hostings_vhosts where id=".$_GET['xid'];
//echo $select;
if ($_GET['panelmod']=="isp_hostings_vhosts"&&$this->where!="") $select.=" AND ".$this->where;
$res=mysql_query($select);
$vhost=mysql_fetch_array($res);

//if ($vhost['hosting_id']!="") {
$sel="select * from kms_isp_hostings where id=".$vhost['hosting_id'];
$res2=mysql_query($sel);
$hosting=mysql_fetch_array($res2);
//} else {
//	$this->_error("",_KMS_WEB_SEARCH_NORESULTS);
//}

}

$buttons=array();

$urlbase="/?app=".$_GET['app'];
//$add=array(_KMS_TY_ISP_LIMITS,array("mod"=>"isp_hostings_vhosts","icon"=>"isp_limits.png","title"=>_KMS_ISP_HOSTING_LIMITS,"order"=>1,"action"=>$urlbase."&mod=isp_hostings_vhosts")); array_push($buttons,$add);
	$add=array(_KMS_TY_ISP_REDIRECT,array("mod"=>"isp_hostings_vhosts","icon"=>"isp_redirect.png","title"=>_KMS_ISP_HOSTING_REDIRECT,"order"=>1,"action"=>$urlbase."&mod=isp_hostings_vhosts&_=e&id=".$_GET['xid']."&action=redirect")); array_push($buttons,$add);

if ($vhost['hosting_id']!=0) {
	$add=array(_KMS_TY_ISP_SUBDOMAINS,array("mod"=>"isp_subdomains","icon"=>"isp_subdomains.png","title"=>_KMS_ISP_HOSTING_SUBDOMAINS,"order"=>1,"action"=>$urlbase."&mod=isp_hostings_vhosts")); array_push($buttons,$add);
	$add=array(_KMS_TY_ISP_FTPS,array("mod"=>"isp_ftps","icon"=>"isp_ftps.png","title"=>_KMS_ISP_HOSTING_FTPS,"order"=>1,"action"=>$urlbase."&mod=isp_hostings_vhosts")); array_push($buttons,$add);
}

if ($vhost['dns_zone_id']==0) {
	$add=array(_KMS_TY_ISP_DNS,array("mod"=>"isp_dns","icon"=>"isp_dns_disabled.png","title"=>_KMS_ISP_HOSTING_DNS,"order"=>1,"action"=>$urlbase."&mod=isp_hostings_vhosts","info"=>_KMS_ISP_HOSTING_DNS_NULL)); array_push($buttons,$add);
} else { 
	$add=array(_KMS_TY_ISP_DNS,array("mod"=>"isp_dns","icon"=>"isp_dns.png","title"=>_KMS_ISP_HOSTING_DNS,"order"=>1,"action"=>$urlbase."&mod=isp_hostings_vhosts")); array_push($buttons,$add);

}
if ($vhost['hosting_id']!=0) {
	$add=array(_KMS_TY_ISP_DATABASES,array("mod"=>"isp_databases","icon"=>"isp_databases.png","title"=>_KMS_ISP_HOSTING_DATABASES,"order"=>1,"action"=>$urlbase."&mod=isp_hostings_vhosts")); array_push($buttons,$add);
	$add=array(_KMS_TY_ISP_CERTIFICATES,array("mod"=>"isp_certificates","icon"=>"isp_ssl.png","title"=>_KMS_ISP_HOSTING_CERTIFICATES,"order"=>1,"action"=>$urlbase."&mod=isp_hostings_vhosts")); array_push($buttons,$add);
	$add=array(_KMS_TY_ISP_CRONTABLE,array("mod"=>"isp_crontables","icon"=>"isp_cron.png","title"=>_KMS_ISP_HOSTING_CRONTABLE,"order"=>1,"action"=>$urlbase."&mod=isp_hostings_vhosts")); array_push($buttons,$add);
	if ($hosting['service_ssh']=="1") {
	$add=array(_KMS_TY_ISP_SSH,array("mod"=>"isp_hostings_vhosts","icon"=>"isp_ssh.png","title"=>_KMS_ISP_HOSTING_SSH,"order"=>1,"action"=>"/?app=".$_GET['app']."&mod=isp_hostings_vhosts&from=isp_hostings_vhosts&panelmod=isp_ssh&_=f&action=ssh&xid=".$_GET['xid'],"target"=>"_self")); array_push($buttons,$add);
	}
	if ($hosting['service_mailman']=="1") {
	$add=array(_KMS_ISP_HOSTINGS_SERVICE_MAILMAN,array("mod"=>"isp_hostings_vhosts","icon"=>"mailman.png","title"=>_KMS_ISP_HOSTING_SERVICE_MAILMAN,"order"=>1,"action"=>"http://lists.".$vhost['name']."/mailman/admin/","target"=>"new")); array_push($buttons,$add);
	}
        $add=array(_KMS_ISP_HOSTINGS_RESTORE_PERM,array("mod"=>"isp_hostings_vhosts","icon"=>"restore_perm.png","title"=>_KMS_ISP_HOSTING_RESTORE_PERM,"order"=>1,"action"=>"/?app=".$_GET['app']."&mod=isp_hostings_vhosts&from=isp_hostings_vhosts&_=f&action=restore_perm&xid=".$_GET['xid'],"target"=>"new")); array_push($buttons,$add);

}
//$add=array(_KMS_ISP_HOSTING_DELETE,array("mod"=>"isp_hostings_vhosts","icon"=>"isp_cancel.png","title"=>_KMS_ISP_HOSTING_DELETE,"order"=>1,"action"=>$urlbase."&mod=isp_hostings_vhosts")); array_push($buttons,$add);

// COUNT
$sel="select id from kms_isp_domains where name='".$vhost['name']."'";
$res=mysql_query($sel);
$domain=mysql_fetch_array($res);

$sel="select id from kms_isp_databases where domain_id=".$domain[0];
$res=mysql_query($sel);
$bd_count = mysql_num_rows($res);

$sel="select id from kms_isp_ftps where hplan_id=".$vhost['hplan_id'];
$res=mysql_query($sel);
$ftp_count = mysql_num_rows($res);

$sel="select id from kms_isp_subdomains where domain_id=".$domain[0];
$res=mysql_query($sel);
$subdom_count = mysql_num_rows($res);

$sel="select id from kms_isp_crontables where domain_id=".$domain[0];
$res=mysql_query($sel);
$cron_count = mysql_num_rows($res);

$infotable=array(_KMS_GL_CREATION_DATE=>$vhost['creation_date'],_KMS_ISP_HOSTINGS_USED_SPACE=>bytes($vhost['total_used_space'])." / ".bytes($vhost['max_space']),_KMS_ISP_HOSTINGS_USED_TRANSFER=>bytes($vhost['total_used_transfer'])." / ".bytes($vhost['max_transfer']),_KMS_SERVICES_DB=>$bd_count,_KMS_TY_ISP_FTPS=>$ftp_count,_KMS_TY_ISP_SUBDOMAINS=>$subdom_count,_KMS_ISP_HOSTING_FEATURE_CRONTABLES=>$cron_count,_KMS_TY_ISP_CERTIFICATES=>"",_KMS_TY_ISP_SSH=>"");

$sel="select name from kms_isp_hostings_vhosts where id=".$_GET['xid'];
$res=mysql_query($sel);
$vhost=mysql_fetch_array($res);
$this->title=$this->_get_title($_GET['mod'])." "._KMS_GL_DEL_DOMINI." ".$vhost['name'];

//$content="<div class=\"mod_header\"><div style=\"float:left\"><img src=\"/kms/css/aqua/img/apps/isp_mailboxes.png\"></div>";
//$content.="<div style=\"float:left;padding-left:10px\"><h2>"._KMS_TY_ISP_HOSTINGS_VHOSTS_ADV." "._KMS_GL_DEL_DOMINI." ".$vhost['name']."</h2></div></div>";

$params=array("title"=>_KMS_TY_ISP_ADV." "._KMS_GL_DEL_DOMINI." ".$vhost['name'],"height"=>"220px","buttons"=>$buttons,"content"=>$content,"defaultMod"=>"","infotable"=>$infotable,"hide_databrowser"=>$hide_databrowser,"table_title"=>$this->table_title,"hide_table_title"=>false);
$this->setPanel($params);

?>
