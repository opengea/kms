<?php
$hosting=$this->dbi->get_record("select * from kms_isp_hostings WHERE id=".$_GET['id'],$dblink_cp);

if ($_GET['id']!="") {
	$hosting=$this->dbi->get_record("select * from kms_isp_hostings WHERE id=".$_GET['id'],$dblink_cp);
	$service=$this->dbi->get_record("select * from kms_ecom_services WHERE id=".$hosting['sr_ecom_service'],$dblink_cp);
	$contract=$this->dbi->get_record("select * from kms_erp_contracts where id=".$hosting['sr_contract'],$dblink_erp);
	$type=$hosting['type'];
} else {
	$type=$_POST['type'];
}

if ($hosting['status']!="active") {

	echo _KMS_GL_STATUS_BLOCKED;
	
} else if (($type=="Cloud Hosting"||$type=="Multidomain Cloud Hosting"||$type=="ch")) {
	if ($this->user_account['id']!=1&&$service['id']!=13&&$service['id']!=14&&$service['id']!=15&&$service['id']!=16&&$service['id']!=17) {
	//only flexible cloud plans can manage
        $this->_error("",_KMS_ISP_HOSTINGS_MANAGE_NOTCLOUD,"fatal");
	}
        include "ch_manage.php";
        } else if ($type=="Virtual Private Server (VPS)"||$type=="vh") {
        $this->_error("",_KMS_GL_UNDER_CONSTRUCTION,"fatal");
        include "vh_manage.php";
        } else if ($type=="Dedicated Server"||$type=="dh") {
        //$this->_error("",_KMS_GL_UNDER_CONSTRUCTION,"fatal");
        echo "DEDICATED HOSTING";//exit;include "dh_manage.php";
}
?>
