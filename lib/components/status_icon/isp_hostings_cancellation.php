<?
// Determines the customer hosting status

        $sel = "SELECT * from kms_isp_hostings where id=".$id;
        $res=mysqli_query($this->dm->dblinks['client'],$sel);
        $hosting=mysqli_fetch_array($res);
//include "/usr/local/kms/lib/dbi/kms_erp_dbconnect.php"; //disabled TOO SLOW
//	$sel="SELECT id,auto_renov,end_date from kms_erp_contracts where id=".$hosting['sr_contract']." and sr_client='".$hosting['sr_client']."'";
	// no mirem sr_client perque en cas de hostings de resellers no quadra
	$sel="SELECT id,auto_renov,end_date from kms_erp_contracts where id=".$hosting['sr_contract'];
//echo $sel."<br>";
//	$res=mysqli_query($this->dm->dblinks['client'],$sel);
	$res=mysqli_query($this->dm->dblinks['client'],$sel);
        $contract=mysqli_fetch_array($res);
	if ($contract['id']=="")  { 
		//no hi ha contracte associat, busquem hosting per reparar
		$sel="select kms_erp_contracts.id from kms_erp_contracts inner join kms_ecom_services on sr_ecom_service=kms_ecom_services.id where (domain='".$hosting['description']."' or description='".$hosting['description']."') and sr_client='".$hosting['sr_client']."' and kms_ecom_services.family=2 order by kms_erp_contracts.status";
		$res=mysqli_query($this->dm->dblinks['client'],$sel);
		$contracte=mysqli_fetch_array($res);
		if ($contracte['id']!="") {
			$update="update kms_isp_hostings set sr_contract=".$contracte['id']." where id=".$id;
			$res=mysqli_query($this->dm->dblinks['client'],$update);
			include "/usr/local/kms/lib/dbi/kms_erp_dbconnect.php";
			$res=mysqli_query($this->dm->dblinks['client'],$update);
		}
	}
	
	if ($hosting['status']=="active"&&$contract['auto_renov']=="1") $out="<span style='color:#00AA00;cursor:pointer;' title=\""._KMS_ERP_CONTRACTS_AUTO_RENOV.": ".date('d-m-Y',strtotime($contract['end_date']))."\">"._KMS_GL_STATUS_ACTIVE."</span>"; 
	else if ($hosting['status']=="blocked") $out="<span title=\""._KMS_GL_STATUS_BLOCKED."\"><img src=\"/kms/css/aqua/img/small/remove_fav.png\"></span>";
	else $out="<span title=\""._KMS_ERP_CONTRACTS_CANCELLATION." ".date('d-m-Y',strtotime($contract['end_date']))."\"><img src=\"/kms/css/aqua/img/small/remove_fav.png\"></span>";
//echo $id.":".$hosting['sr_contract'].":".$contract['auto_renov']."<br>";

?>
