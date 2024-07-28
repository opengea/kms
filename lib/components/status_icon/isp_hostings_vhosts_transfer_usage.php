<?

$t=0;
	$sel = "SELECT total_used_transfer,max_transfer,hosting_id from kms_isp_hostings_vhosts where id=".$id;
        $res=mysqli_query($this->dm->dblinks['client'],$sel);
        $vhost=mysqli_fetch_array($res);

	// transferencia
	if ($vhost['total_used_transfer']>=$vhost['max_transfer']) $transfer_color="red"; else $transfer_color="green";
	$transfer_pc = round(($vhost['total_used_transfer']*100)/$vhost['max_transfer']);

	if ($vhost['total_used_transfer']!=0) {

        if ($vhost['hosting_id']!=0) { 
	$out.="<div class='limits'>";
	$out.="<div class='$transfer_color' title='"._KMS_ISP_HOSTINGS_TRANSFER." ".bytes($vhost['total_used_transfer'])."/".bytes($vhost['max_transfer'])."'><div class='info'>$transfer_pc% </div><div class='progress_bar' id='tbar_$id'></div>$note2</div>";
	$out.="</div>";
	$out.="<script>$(\"#tbar_$id\").progressbar({ value: $transfer_pc });</script>";
	}
	$label="x";	
	$action="manage";
	$title="Limits del domini";

}

?>
