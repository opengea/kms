<?
$t=0;

	//hosting

	$sel = "SELECT * from kms_isp_hostings where id=".$id;
        $res=mysqli_query($this->dm->dblinks['client'],$sel);
        $hosting=mysqli_fetch_array($res);

	$sel = "SELECT * from kms_ecom_services where id=".$hosting['sr_ecom_service'];
        $res=mysqli_query($this->dm->dblinks['client'],$sel);
        $service=mysqli_fetch_array($res);

	$sel = "SELECT id from kms_isp_hostings_vhosts where hosting_id=".$id;
	$res=mysqli_query($this->dm->dblinks['client'],$sel);
        $vhosts=mysqli_fetch_array($res);
	if ($vhosts['id']!="") $service_exists=true; else $service_exists=false;

	$label="";//Aquest domini no disposa de hosting";
//echo ":".$service['subfamily'];
	$action="manage";
	if ($service['subfamily']==1) { 
		//cloud hosting
		 $icon="ch1.png"; $label=_KMS_ISP_HOSTING_CH; $title=_KMS_ISP_HOSTINGS_CH_MANAGE_1;
if ($service['id']==13||$service['id']==14) { $icon="ch1.png"; $label=_KMS_ISP_HOSTING_CH; $title=$service['description_'.$_SESSION['lang']].".\n"._KMS_ISP_HOSTINGS_VHOSTS_MANAGE; }
                else if ($service['id']==15) { $icon="ch2.png"; $label=_KMS_ISP_HOSTING_CH; $title=$service['description_'.$_SESSION['lang']].".\n"._KMS_ISP_HOSTINGS_VHOSTS_MANAGE; }
                else if ($service['id']==16||$service['id']==17) { $icon="ch3.png";  $label=_KMS_ISP_HOSTING_CH; $title=$service['description_'.$_SESSION['lang']].".\n"._KMS_ISP_HOSTINGS_VHOSTS_MANAGE; }
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
	} else if ($service['subfamily']==20) {
		//serveis afegits
		if ($service['id']==47)  { $icon="redirect.png"; }
	}

	$label=$service['name_'.$_SESSION['lang']];
//	$title=$title." (#".$hosting['sr_contract'].")";
//$title=$service['description'].". ".$title;
	$link="/?app=".$_GET['app']."&mod=isp_hostings_vhosts&queryfield=hosting_id&query={$id}&queryop=equal";
//	if ($this->show_label) $label="<a href=\"{$link}\" title=\"".$title."\" style=\"color:#142A3B\">{$label}</a>";
       $out="<div class='icon_status'><a href=\"{$link}\" title=\"".$title."\"><img src=\"/kms/css/aqua/img/small/$icon\" alt=\"{$label}\"></a></div><div style='text-overflow:ellipsis;float:left;padding-top:2px;'>";


//	if ($this->show_label) $out.="<a href=\"{$link}\" title=\"".$title."\" style=\"color:#142A3B\">{$label}</a>";
	$out.="</div><div style='float:left;padding-top:4px;padding-left:5px'><a title='contracte C-{$hosting['sr_contract']}' href='http://intranet.intergrid.cat/?app=erp&mod=erp_contracts&op=like&_=e&id={$hosting['sr_contract']}'>C-{$hosting['sr_contract']}</a></div>";
	

    $link="/?app=".$_GET['app']."&mod=isp_hostings_vhosts&queryfield=hosting_id&query={$hosting['id']}&queryop=equal";
       $out.=" <div style='float:left;padding:2px 5px'><div style='text-overflow:ellipsis;float:inherit;padding-top:2px;'>";

        if ($this->show_label&&$service_exists) $out.="<a href=\"{$link}\" title=\"".$title."\" style=\"\">→Serveis</a>";
        $out.="</div>";
	
?>
