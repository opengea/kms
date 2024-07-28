<?
$t=0;
	$sel = "SELECT * from kms_isp_hostings where id=".$id;
        $res=mysqli_query($this->dm->dblinks['client'],$sel);
        $hosting=mysqli_fetch_array($res);


	// espai
	if ($hosting['used_space']>=$hosting['max_space']) $space_color="red"; else $space_color="green";

	$space_pc = round(($hosting['used_space']*100)/$hosting['max_space']);

//if ($hosting['total_used_space']!=0||$hosting['total_used_transfer']!=0) {
	if ($hosting['max_space']==0) $note1="!"; else $note1="";
	$out="";
	if ($hosting['type']!="redirect_frm"&&$hosting['type']!="redirect_std") {
	$out.="<div class='limits'><div class='$space_color' style='display: -webkit-inline-flex' title='"._KMS_ISP_HOSTINGS_SPACE." ".bytes($hosting['used_space'])."/".bytes($hosting['max_space'])."'><div class='info'>$space_pc%</div><div class='progress_bar' id='sbar_$id'></div>$note1</div></div>";

	$out.="<script>$(\"#sbar_$id\").progressbar({ value: $space_pc });</script>";
	}
	$label="x";
	$action="manage";
	$title="Limits del domini";

//}

//       $out="<div style='float:left'><a href=\"?action=$action\" title=\"".$title."\"><img src=\"/kms/css/aqua/img/small/$icon\"></a></div><div style='float:left;padding-left:5px;padding-top:2px;'>$label</div>";
		
?>
