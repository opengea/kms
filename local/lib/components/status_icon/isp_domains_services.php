<?

$t=0;
        $sel = "SELECT * from kms_isp_domains where id=".$id;
	$res=mysqli_query($this->dm->dblinks['client'],$sel);
	$domain=mysqli_fetch_array($res);



	$sel = "SELECT * from kms_isp_hostings_vhosts where name='".$domain['name']."'";
        $res=mysqli_query($this->dm->dblinks['client'],$sel);
        $vhost=mysqli_fetch_array($res);

	$label="";//Aquest domini no disposa de hosting";
	$action="manage";
	$icon="h0.png";
//	if ($domain['hosting_id']!=0) $icon="led-green.gif"; else $icon="led-grey.gif";
	if ($vhost['id']!="") { 
		$title=_KMS_ISP_VHOSTS_SERVICES_ENABLED; 
		$icon="htype_active.png"; 
		$sel = "SELECT * from kms_isp_hostings_vhosts where name='".$domain['name']."'";
       		$res=mysqli_query($this->dm->dblinks['client'],$sel);
	        $vhost=mysqli_fetch_array($res);
		$action="/?app=".$_GET['app']."&mod=isp_hostings_vhosts&_=b&queryfield=id&query=".$vhost['id'];
		$action="/?app=".$_GET['app']."&from=isp_hostings_vhosts&mod=isp_hostings_vhosts_adv&id=".$vhost['id']."&xid=".$vhost['id'];
	} else { 
		$title=_KMS_ISP_VHOSTS_SERVICES_DISABLED; 
		$icon="htype_none.png";
		$action="/?_=f&id=&app=".$_GET['app']."&mod=isp_domains&action=enable_services&id=$id";
	}
        $out="<div style='float:left'><a href=\"$action\" title=\"".$title."\"><img src=\"/kms/css/aqua/img/small/$icon\"></a></div><div style='float:left;padding-left:5px;padding-top:2px;'>";
	if ($this->show_label) $out.=$label;
	$out.="</div>";

		
?>
