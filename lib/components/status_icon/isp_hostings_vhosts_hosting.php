<?
$t=0;


        $sel = "SELECT type,redirect_url,hosting_id from kms_isp_hostings_vhosts where id=".$id;
        $res=mysqli_query($this->dm->dblinks['client'],$sel);
        $vhost=mysqli_fetch_assoc($res);

if ($vhost['type']=="redirect_301"||$vhost['type']=="redirect_307"||$vhost['type']=="redirect_frm") {
	//redireccio
        $icon="redirect.png";
        $label=_KMS_ISP_HOSTING_REDIRECT." ".$vhost['redirect_url'];
        $title=_KMS_GL_SERVEI_ACTIVAT;
} else if ($vhost['hosting_id']==0) {
	// no hosting
	$icon="h0.png";
        $label=_KMS_ISP_HOSTINGS_NONE;
        $title=_KMS_ECOM_CLICK_CONTRACT;
} else {
	//hosting

	$sel = "SELECT id,sr_ecom_service from kms_isp_hostings where id=".$vhost['hosting_id'];
        $res=mysqli_query($this->dm->dblinks['client'],$sel);
        $hosting=mysqli_fetch_assoc($res);
	if ($hosting['id']=="") { $icon="error.png"; $label="Error";$title="Error";
	$out="<div class='icon_status' ><a href=\"/?_=f&id=&app=".$_GET['app']."&mod=isp_hostings_vhosts&action=setup_hosting&id=".$id."\" title=\"".$title."\"><img src=\"/kms/css/aqua/img/small/$icon\"></a></div><div style='float:left;padding-left:5px;padding-top:2px;'>";
        if ($this->show_label) $out.=$label;
        $out.="</div>";
	return $out;
} 
	

	$sel = "SELECT id,subfamily,description_".$_SESSION['lang']." from kms_ecom_services where id=".$hosting['sr_ecom_service'];
        $res=mysqli_query($this->dm->dblinks['client'],$sel);
        $service=mysqli_fetch_assoc($res);

	$action="manage";
	if ($service['subfamily']==1) { 
		//cloud hosting
		 $icon="ch1.png"; $label=_KMS_ISP_HOSTING_CH; $title=_KMS_ISP_HOSTINGS_CH_MANAGE_1;
		if ($service['id']==13||$service['id']==14) { $icon="ch1.png"; $label=_KMS_ISP_HOSTING_CH; $title=$service['description_'.$_SESSION['lang']].".\n"._KMS_ISP_HOSTINGS_CLICK_MANAGE; }
		else if ($service['id']==15) { $icon="ch2.png"; $label=_KMS_ISP_HOSTING_CH; $title=$service['description_'.$_SESSION['lang']].".\n"._KMS_ISP_HOSTINGS_CLICK_MANAGE; }
		else if ($service['id']==16||$service['id']==17) { $icon="ch3.png";  $label=_KMS_ISP_HOSTING_CH; $title=$service['description_'.$_SESSION['lang']].".\n"._KMS_ISP_HOSTINGS_CLICK_MANAGE; }
	} else if ($service['subfamily']==3) {
		$icon="vh1.png";$label=_KMS_ISP_HOSTING_VH; $title=_KMS_ISP_HOSTINGS_VH_MANAGE_1;
		// virtual servers
		if ($service['id']==74||$service['id']==24)  { $icon="vh1.png";$label=_KMS_ISP_HOSTING_VH; $title=_KMS_ISP_HOSTINGS_VH_MANAGE_1; }
		else if ($service['id']==73)  { $icon="vh2.png"; $label=_KMS_ISP_HOSTING_VH;$title=_KMS_ISP_HOSTINGS_VH_MANAGE_2; }
		else if ($service['id']==9||$service['id']==8||$service['id']==42)  { $icon="vh3.png";$label=_KMS_ISP_HOSTING_VH; $title=_KMS_ISP_HOSTINGS_VH_MANAGE_3; }
	} else if ($service['subfamily']==4) {
		$icon="dh1.png"; $label=_KMS_ISP_HOSTING_DH;$title=_KMS_ISP_HOSTINGS_DH_MANAGE_1;
		 if ($service['id']==44) { $icon="dh1.png"; $label=_KMS_ISP_HOSTING_DH;$title=_KMS_ISP_HOSTINGS_DH_MANAGE_1; } 	
		 else if ($service['id']==45) { $icon="dh2.png"; $label=_KMS_ISP_HOSTING_DH;$title=_KMS_ISP_HOSTINGS_DH_MANAGE_2; }
		 else if ($service['id']==46) { $icon="dh3.png"; $label=_KMS_ISP_HOSTING_DH;$title=_KMS_ISP_HOSTINGS_DH_MANAGE_3; }
	} else if ($service['subfamily']==5||$service['subfamily']==6||$service['subfamily']==7||$service['subfamily']==8||$service['subfamily']==9) {
		// KMS
		$icon="ch1.png"; $label=_KMS_ISP_HOSTING_CH;$title=_KMS_ISP_HOSTINGS_CH_MANAGE_1;
		if ($service['id']==78) { $icon="ch1.png"; $label=_KMS_ISP_HOSTING_CH;$title=_KMS_ISP_HOSTINGS_CH_MANAGE_1; } //kms sites basic
                else if ($service['id']==30) { $icon="ch2.png"; $label=_KMS_ISP_HOSTING_CH;$title=_KMS_ISP_HOSTINGS_CH_MANAGE_2; }
                else if ($service['id']==79) { $icon="ch3.png"; $label=_KMS_ISP_HOSTING_CH;$title=_KMS_ISP_HOSTINGS_CH_MANAGE_3; }
	} else if ($service['subfamily']==10) {
		 $icon="ch1.png"; $label=_KMS_ISP_HOSTING_CH;$title=_KMS_ISP_HOSTINGS_MCH_MANAGE_1;
		// Multidomain Cloud Hosting
		 if ($service['id']==37) { $icon="ch1.png"; $label=_KMS_ISP_HOSTING_CH;$title=_KMS_ISP_HOSTINGS_MCH_MANAGE_1; } 
                else if ($service['id']==81) { $icon="ch2.png"; $label=_KMS_ISP_HOSTING_CH;$title=_KMS_ISP_HOSTINGS_MCH_MANAGE_2; }
                else if ($service['id']==80||$service['id']==83) { $icon="ch3.png"; $label=_KMS_ISP_HOSTING_CH;$title=_KMS_ISP_HOSTINGS_MCH_MANAGE_3; }
	}

}

//$title=$service['description'].". ".$title;
	if ($icon=="h0.png") {
		$action="/?_=f&id=&app=".$_GET['app']."&mod=isp_hostings_vhosts&action=setup_hosting&id=".$id;
	} else {
		$action="/?_=f&id=".$hosting['id']."&app=".$_GET['app']."&mod=isp_hostings&action=hosting_manage";
	}

	$out="<div class='icon_status'><a href=\"".$action."\" title=\"".$title."\"><img src=\"/kms/css/aqua/img/small/$icon\"></a></div><div style='float:left;padding-left:5px;padding-top:2px;'>"; 
	if ($this->show_label) $out.=$label;
	$out.="</div>";

		
?>
