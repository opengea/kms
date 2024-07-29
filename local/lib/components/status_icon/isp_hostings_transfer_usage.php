<?
$t=0;
	$sel = "SELECT * from kms_isp_hostings where id=".$id;
        $res=mysqli_query($this->dm->dblinks['client'],$sel);
        $hosting=mysqli_fetch_array($res);


	// espai
	if ($hosting['used_transfer']>=$hosting['max_transfer']) $transfer_color="red"; else $transfer_color="green";

	$transfer_pc = round(($hosting['used_transfer']*100)/$hosting['max_transfer']);

	if ($hosting['max_transfer']==0) $note2="!"; else $note2="";
	$out="";
	if ($hosting['type']!="redirect_frm"&&$hosting['type']!="redirect_std") {
	$out.="<div class='limits'><div class='$transfer_color' title='"._KMS_ISP_HOSTINGS_TRANSFER." ".bytes($hosting['used_transfer'])."/".bytes($hosting['max_transfer'])."'><div class='info'>$transfer_pc% </div><div class='progress_bar' id='tbar_$id'></div>$note2</div></div>";

	$out.="<script>$(\"#tbar_$id\").progressbar({ value: $transfer_pc });</script>";
	}
	$label="x";
	$action="manage";
	$title="Limits del domini";

//}

//       $out="<div style='float:left'><a href=\"?action=$action\" title=\"".$title."\"><img src=\"/kms/css/aqua/img/small/$icon\"></a></div><div style='float:left;padding-left:5px;padding-top:2px;'>$label</div>";
		
?>
