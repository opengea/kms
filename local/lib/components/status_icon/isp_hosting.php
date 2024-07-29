<?
$t=0;
        $sel = "SELECT * from kms_isp_domains where id=".$id;
	$res=mysqli_query($this->dm->dblinks['client'],$sel);
	$data=mysqli_fetch_array($res);
	$sel = "SELECT * from kms_isp_hostings where id=".$data['hosting_id'];
        $res=mysqli_query($this->dm->dblinks['client'],$sel);
        $hosting=mysqli_fetch_array($res);

	$sel = "SELECT * from kms_ecom_services where id=".$hosting['sr_ecom_service'];
        $res=mysqli_query($this->dm->dblinks['client'],$sel);
        $service=mysqli_fetch_array($res);

	$label="";//Aquest domini no disposa de hosting";
	$action="manage";
	$title=_KMS_ISP_HOSTINGS_NONE." "._KMS_ECOM_CLICK_CONTRACT;
	$icon="h0.png";
	if ($service['subfamily']==1) { 
		//cloud hosting
		if ($service['id']==34||$service['id']==36) { $icon="ch1.png"; $label=_KMS_ISP_HOSTING_CH; $title=_KMS_ISP_HOSTINGS_CH_MANAGE_1; }
		else if ($service['id']==5) { $icon="ch2.png"; $label=_KMS_ISP_HOSTING_CH; $title=_KMS_ISP_HOSTINGS_CH_MANAGE_2; }
		else if ($service['id']==6) { $icon="ch3.png";  $label=_KMS_ISP_HOSTING_CH; $title=_KMS_ISP_HOSTINGS_CH_MANAGE_3; }
	} else if ($service['subfamily']==3) {
		// virtual servers
		if ($service['id']==74||$service['id']==24)  { $icon="vh1.png";$label=_KMS_ISP_HOSTING_VH; $title=_KMS_ISP_HOSTINGS_VH_MANAGE_1; }
		else if ($service['id']==73)  { $icon="vh2.png"; $label=_KMS_ISP_HOSTING_VH;$title=_KMS_ISP_HOSTINGS_VH_MANAGE_2; }
		else if ($service['id']==9||$service['id']==8||$service['id']==42)  { $icon="vh3.png";$label=_KMS_ISP_HOSTING_VH; $title=_KMS_ISP_HOSTINGS_VH_MANAGE_3; }
	} else if ($service['subfamily']==4) {
		 if ($service['id']==44) { $icon="dh1.png"; $label=_KMS_ISP_HOSTING_DH;$title=_KMS_ISP_HOSTINGS_DH_MANAGE_1; } 	
		 else if ($service['id']==45) { $icon="dh2.png"; $label=_KMS_ISP_HOSTING_DH;$title=_KMS_ISP_HOSTINGS_DH_MANAGE_2; }
		 else if ($service['id']==46) { $icon="dh3.png"; $label=_KMS_ISP_HOSTING_DH;$title=_KMS_ISP_HOSTINGS_DH_MANAGE_3; }
	} else if ($service['subfamily']==5||$service['subfamily']==6||$service['subfamily']==7||$service['subfamily']==8||$service['subfamily']==9) {
		// KMS
		if ($service['id']==78) { $icon="ch1.png"; $label=_KMS_ISP_HOSTING_CH;$title=_KMS_ISP_HOSTINGS_CH_MANAGE_1; } //kms sites basic
                else if ($service['id']==30) { $icon="ch2.png"; $label=_KMS_ISP_HOSTING_CH;$title=_KMS_ISP_HOSTINGS_CH_MANAGE_2; }
                else if ($service['id']==79) { $icon="ch3.png"; $label=_KMS_ISP_HOSTING_CH;$title=_KMS_ISP_HOSTINGS_CH_MANAGE_3; }
	} else if ($service['subfamily']==18) {
		// Multidomain Cloud Hosting
		 if ($service['id']==37) { $icon="ch1.png"; $label=_KMS_ISP_HOSTING_CH;$title=_KMS_ISP_HOSTINGS_MCH_MANAGE_1; } 
                else if ($service['id']==81) { $icon="ch2.png"; $label=_KMS_ISP_HOSTING_CH;$title=_KMS_ISP_HOSTINGS_MCH_MANAGE_2; }
                else if ($service['id']==80||$service['id']==83) { $icon="ch3.png"; $label=_KMS_ISP_HOSTING_CH;$title=_KMS_ISP_HOSTINGS_MCH_MANAGE_3; }
	}




       $out="<div style='float:left'><a href=\"?action=$action\" title=\"".$title."\"><img src=\"/kms/css/aqua/img/small/$icon\"></a></div><div style='float:left;padding-left:5px;padding-top:2px;'>";
	if ($this->show_label) $out.=$label;
	$out.="</div>";

		
?>
