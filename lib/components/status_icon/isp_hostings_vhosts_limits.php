<?

$t=0;
	$sel = "SELECT * from kms_isp_hostings_vhosts where id=".$id;
        $res=mysqli_query($this->dm->dblinks['client'],$sel);
        $vhost=mysqli_fetch_array($res);

	// espai
	if ($vhost['total_used_space']>=$vhost['max_space']) $space_color="red"; else $space_color="green";
	if ($vhost['total_used_transfer']>=$vhost['max_transfer']) $transfer_color="red"; else $transfer_color="green";

	$space_pc = round(($vhost['total_used_space']*100)/$vhost['max_space']);
	$transfer_pc = round(($vhost['total_used_transfer']*100)/$vhost['max_transfer']);

/*$suma=$vhost['used_space_transfer']+$vhost['used_space_httpdocs']+$vhost['used_space_httpsdocs']+$vhost['used_space_ftps']+$vhost['used_space_logs']+$vhost['used_space_databases']+$vhost['used_space_mailboxes'];
$update="update kms_isp_hostings_vhosts set total_used_space=".$suma." where id=".$id;
mysqli_query($this->dm->dblinks['client'],$update);
*/

//20000 (20K) es el tamany maxim que pot tenir una carpeta redirigida

if ($vhost['total_used_space']>20000||$vhost['total_used_transfer']!=0) {

//	if ($vhost['max_space']==0) $note1="!"; else $note1="";
//	if ($vhost['max_transfer']==0) $note2="!"; else $note2="";

        if ($vhost['hosting_id']!=0) { 
//	$out="<div style='float:left'>SPACE: </div><div style='float:left;' id='sbar_$id'></div><font style='color:$space_color'>$space_pc%</font> ] TRANSFER: [  <div id='tbar_$id'></div><span style='color:$transfer_color'>$transfer_pc%</font> ]";
	$out.="<div class='limits'><div class='$space_color' title='"._KMS_ISP_HOSTINGS_SPACE." ".bytes($vhost['total_used_space'])."/".bytes($vhost['max_space'])."'><div class='info'>$space_pc%</div><div class='progress_bar' id='sbar_$id'></div>$note1</div>";
	$out.="<div class='$transfer_color' title='"._KMS_ISP_HOSTINGS_TRANSFER." ".bytes($vhost['total_used_transfer'])."/".bytes($vhost['max_transfer'])."'><div class='info'>$transfer_pc% </div><div class='progress_bar' id='tbar_$id'></div>$note2</div></div>";

	$out.="<script>$(\"#sbar_$id\").progressbar({ value: $space_pc });$(\"#tbar_$id\").progressbar({ value: $transfer_pc });</script>";
	}
	$label="x";	
	$action="manage";
	$title="Limits del domini";

}

//       $out="<div style='float:left'><a href=\"?action=$action\" title=\"".$title."\"><img src=\"/kms/css/aqua/img/small/$icon\"></a></div><div style='float:left;padding-left:5px;padding-top:2px;'>$label</div>";
		
?>
