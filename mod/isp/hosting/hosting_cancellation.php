<?
include_once "/usr/local/kms/lib/mod/shared/db_links.php"; 

if ($_POST['_auto_renov']!="") {
	//update hosting
	$hosting=$this->dbi->get_record("select sr_contract from kms_isp_hostings WHERE id=".$_GET['id'],$dblink_cp);
	$contract=$this->dbi->get_record("select id from kms_erp_contracts where id=".$hosting['sr_contract'],$dblink_erp);
	$updates=array("auto_renov"=>$_POST['_auto_renov']);
	$this->dbi->update_record('kms_erp_contracts',$updates,'id='.$contract['id'],$dblink_erp);
	$this->dbi->update_record('kms_erp_contracts',$updates,'id='.$contract['id'],$dblink_cp);
	echo "<script>document.location=\"https://control.intergridnetwork.net/?_=b&app=".$_GET['app']."&mod=isp_hostings\";</script>";

} else if ($_GET['id']!="") {
        $hosting=$this->dbi->get_record("select * from kms_isp_hostings WHERE id=".$_GET['id'],$dblink_cp);
        $service=$this->dbi->get_record("select * from kms_ecom_services WHERE id=".$hosting['sr_ecom_service'],$dblink_cp);
        $contract=$this->dbi->get_record("select auto_renov,end_date from kms_erp_contracts where id=".$hosting['sr_contract'],$dblink_erp);
        $type=$hosting['type'];
	if ($contract['auto_renov']=="1") $renew="SI"; else $renew="NO";
?>
<div style="margin:20px;color:#333;width:400px;margin-left:auto;margin-right:auto;border:1px solid #888;padding:10px;background-color:#f5f5f5">
<table width="100%" border=0 style="color:#333;font-size:14px !important" cellpadding=5>
<tr><td><?=_KMS_GL_TYPE?></td><td><b><?=$service['name_'.$_SESSION['lang']]?></b></td></tr>
<tr><td><?=_KMS_GL_DESCRIPTION?></td><td><b><?=$hosting['description']?></b></td></tr>
<tr><td><?=_KMS_TY_ISP_VHOSTS?></td><td><b><?=$hosting['used_vhosts']?></b></td></tr>
<tr><td><?=_KMS_GL_CURRENT_STATUS?></td><td><b><?=$hosting['status']?></b></td></tr>
<tr><td><?=_KMS_ERP_CONTRACTS_AUTO_RENOV?></td><td><b><?=$renew?></b></td></tr>
<tr><td><?=_KMS_ECOM_INVOICES_PAYMENT_DATE?></td><td><b><?=date('d-m-Y',strtotime($contract['end_date']))?></b></td></tr>
</table>
</div>
<form name="cancellation" method="post" action="/?_=f&app=<?=$_GET['app']?>&mod=isp_hostings&action=hosting_cancellation&id=<?=$_GET['id']?>">
<input type="hidden" name="_auto_renov" value="">
<div class="alert"><table width="100%" border="0"><tbody><tr><td></td><td class="msg"><span style="font-weight:normal"><?=str_replace("CANCELLATION_DATE",date('d-m-Y',strtotime($contract['end_date'])),_KMS_ISP_HOSTINGS_CANCELLATION_DESCRIPTION)?></span>
</td><td></td></tr></tbody></table><br><br><input type="button" class="delete" value="<?=_MB_CONFIRM_CANCELLATION?>" onclick="document.cancellation._auto_renov.value='0';document.cancellation.submit();"><input type="button" value="<?=_MB_NON_CANCELLATION?>" onclick="document.cancellation._auto_renov.value='1';document.cancellation.submit();"></div>
</form>
<?
}
?>
