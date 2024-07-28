<?

$t=0;

	$sel= "SELECT hosting_id,status,name,mailserver_id from kms_isp_hostings_vhosts where id=".$id;
	$res=mysqli_query($this->dm->dblinks['client'],$sel);
        $vhost=mysqli_fetch_assoc($res);

	$sel = "SELECT status,sr_ecom_service from kms_isp_hostings where id=".$vhost['hosting_id'];
        $res=mysqli_query($this->dm->dblinks['client'],$sel);
        $hosting=mysqli_fetch_assoc($res);

if (($hosting['status']=="blocked"||$vhost['status']=="blocked")&&($_SERVER['HTTP_HOST']!="intranet.intergrid.cat")) { 

	$out="";

} else {

	$sel = "SELECT family from kms_ecom_services where id=".$hosting['sr_ecom_service'];
        $res=mysqli_query($this->dm->dblinks['client'],$sel);
        $service=mysqli_fetch_assoc($res);

	$sel = "SELECT modules from kms_isp_extranets where status='online' and hosting_id=".$vhost['hosting_id']." and domain='".$vhost['name']."'";
	$res=mysqli_query($this->dm->dblinks['client'],$sel);
        $extranet=mysqli_fetch_assoc($res);
	$s=array();

	//file manager
	$k1="djj38ecjDh2d82d";$k2="DJW4y73823hdDJDdd923889hd";
	$key=md5($k1.$vhost['name'].date('Ymd').$k2);
	array_push($s,array("http://www.".$vhost['name']."/kms/lib/fileman/?key=".$key."&lang=".$_SESSION['lang'],"filemanager.png","Filemanager","File manager"));

        if (($service['family']==2||$service['family']==3)&&($vhost['mailserver_id']!=0)) { //MAIL (tots els hostings o aplicacions)
		array_push($s,array("from=isp_hostings_vhosts&mod=isp_mailboxes&xid=$id","mail1.png","Correu",_KMS_TY_ISP_MAILBOXES.". "._KMS_GL_SERVEI_ACTIVAT));
	} else {
		array_push($s,array("from=isp_hostings_vhosts&mod=isp_mailboxes&xid=$id","mail0.png","Correu",_KMS_TY_ISP_MAILBOXES.". "._KMS_GL_SERVEI_DESACTIVAT));
	}
	$extranet['modules']=str_replace(",","|",$extranet['modules']);
	$modules=explode("|",$extranet['modules']);
	if (in_array("imark",$modules)) { // MAILING
                array_push($s,array("http://extranet.".$vhost['name'],"mailing1.png","Mailing",_KMS_TY_ISP_MAILING.". "._KMS_GL_SERVEI_ACTIVAT));
        } else {
                array_push($s,array("mod=isp_hostings_vhosts&_=f&action=kms_mailing&id=$id","mailing0.png","Mailing",_KMS_TY_ISP_MAILING.". "._KMS_GL_SERVEI_DESACTIVAT));
        }
	if (in_array("sites",$modules)) { // SITES
                array_push($s,array("mod=isp_hostings_vhosts&_=f&action=kms_sites&id=$id","sites1.png","Web",_KMS_TY_ISP_SITES.". "._KMS_GL_SERVEI_ACTIVAT));
        } else {
                array_push($s,array("mod=isp_hostings_vhosts&_=f&action=kms_sites&id=$id","sites0.png","Web",_KMS_TY_ISP_SITES.". "._KMS_GL_SERVEI_DESACTIVAT));
        }
/*	if ($service['family']==3&&$service['subfamily']==7) { // ERP
                array_push($s,array("manage","erp1.png","ERP",""));
        } else {
                array_push($s,array("manage","erp0.png","ERP",""));
        } */
	if (in_array("imark",$modules)||in_array("sites",$modules)||in_array("ecom",$modules)||in_array("erp",$modules)) { // EXTRANET
                array_push($s,array("http://extranet.".$vhost['name'],"extranet1.png","Extranet",_KMS_TY_ISP_EXTRANET.". "._KMS_GL_SERVEI_ACTIVAT));
        } else {
                array_push($s,array("mod=isp_hostings_vhosts&_=f&action=kms_extranet&id=$id","extranet0.png","Extranet",_KMS_TY_ISP_EXTRANET.". "._KMS_GL_SERVEI_DESACTIVAT));
        }
        if ($vhost['hosting_id']!=0) {
		array_push($s,array("from=isp_hostings_vhosts&mod=isp_backups&xid=$id","backup.png","Backup",_KMS_TY_ISP_BACKUP));
                array_push($s,array("from=isp_hostings_vhosts&manage&_=d&tpl=stats&id=$id","stats.png","Domain statistics",_KMS_TY_ISP_STATS));
	}

	//advanced
	array_push($s,array("from=isp_hostings_vhosts&mod=isp_hostings_vhosts_adv&id=$id&xid=".$vhost['id'],"advanced.png","Advanced configuration",_KMS_ISP_HOSTINGS_VHOSTS_ADV));

	foreach ($s as $service) {
		if (substr($service[0],0,7)!="http://") { $add=""; $url="http://".$_SERVER['SERVER_NAME']."/?app=".$_GET['app']."&".$service[0]; }  else { $add="target=\"_blank\";"; $url=$service[0]; }
		$out.="<div style='float:left'><a href=\"".$url."\" title=\"".$service[3]."\" {$add}><img src=\"/kms/css/aqua/img/small/".$service[1]."\"></a></div><div style='float:left;padding-left:5px;padding-top:2px;'></div>";

	}

	
}	
?>
