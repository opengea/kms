<?
$t=0;
        $sel = "SELECT * from kms_isp_domains where id=".$id;
        $res=mysqli_query($this->dm->dblinks['client'],$sel);
        $domain=mysqli_fetch_array($res);

/*        $sel = "SELECT * from kms_isp_dns_hostings where id=".$domain['hosting_id'];
        $res=mysqli_query($this->dm->dblinks['client'],$sel);
        $hosting=mysqli_fetch_array($res);
        $sel = "SELECT * from kms_ecom_services where id=".$hosting['sr_ecom_service'];
        $res=mysqli_query($this->dm->dblinks['client'],$sel);
        $service=mysqli_fetch_array($res);
*/
	if ($domain['nameserver1']=="") $domain['nameserver1']="?";
	if ($domain['nameserver2']=="") $domain['nameserver2']="?";

	if (strpos($domain['nameserver1'],"intergridnetwork.net")) { $icon="dns_on.png"; $label="OK"; } else { $icon="dns_off.png"; $label="external"; }
	$title = $domain['nameserver1'].", ".$domain['nameserver2'];
	$action="/?app=".$_GET['app']."&mod=isp_domains&_=e&id=".$id;
       $out="<div style='float:left'><a href=\"$action\" title=\"".$title."\"><img src=\"/kms/css/aqua/img/small/$icon\"></a></div><div style='float:left;padding-left:5px;padding-top:2px;'>";
        if ($this->show_label) $out.=$label;
        $out.="</div>";


?>
