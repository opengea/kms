<?


$t=0;
	$sel = "SELECT name,total_used_space,max_space,hosting_id,webserver_id from kms_isp_hostings_vhosts where id=".$id;
        $res=mysqli_query($this->dm->dblinks['client'],$sel);
        $vhost=mysqli_fetch_assoc($res);

	// espai
	if ($vhost['total_used_space']>=$vhost['max_space']) $space_color="red"; else $space_color="green";

	$space_pc = round(($vhost['total_used_space']*100)/$vhost['max_space']);

//20000 (20K) es el tamany maxim que pot tenir una carpeta redirigida
if ($vhost['total_used_space']>20000)  {

        if ($vhost['hosting_id']!=0) { 
	$out.="<div class='limits'><div class='$space_color' title='"._KMS_ISP_HOSTINGS_SPACE." ".bytes($vhost['total_used_space'])."/".bytes($vhost['max_space'])."'><div class='info'>$space_pc%</div><div class='progress_bar' id='sbar_$id'></div>$note1</div></div>";

	$out.="<script>$(\"#sbar_$id\").progressbar({ value: $space_pc });</script>";
	}
	$label="x";	
	$action="manage";
	$title="Limits del domini";

}

//       $out="<div style='float:left'><a href=\"?action=$action\" title=\"".$title."\"><img src=\"/kms/css/aqua/img/small/$icon\"></a></div><div style='float:left;padding-left:5px;padding-top:2px;'>$label</div>";
		
?>
