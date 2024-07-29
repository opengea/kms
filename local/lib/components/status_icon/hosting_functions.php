<?

function calculate_vhost_size($vhost,$field,$mod) { 

	$resultat=array();
	$resultat['total']=0;
	// get current value from API
/*	$sel = "SELECT hostname from kms_isp_servers where id=".$vhost['webserver_id'];
	$res=mysql_query($sel);
        $server=mysql_fetch_assoc($res);
	$api_url=trim("http://".$server['hostname'].":7475/api/v1/vhosts/disk-usage/single/".str_replace(".","-dot-",$vhost['name']));
	$json = file_get_contents($api_url);
	$api = json_decode($json);
	if ($api==""&&$_SERVER['REMOTE_ADDR']=='81.0.57.125') echo "API CALL ERROR: ".print_r($json)."<br>".$api_url;
	if ($vhost['total_used_space']!=$api->data->total_size) {
			$vhost['total_used_space']=$api->data->total_size;
			$update="update kms_isp_hostings_vhosts set total_used_space='".$vhost['total_used_space']."' where id=".$id;
			$res=mysql_query($update);
	}
*/
	// espai

	if ($field=="total_used_space") { if ($vhost['total_used_space']>=$vhost['max_space']) $space_color="red"; else $space_color="green";  }

	if ($vhost['total_used_space']>$vhost['max_space']) {
		$space_pc = round(($vhost['total_used_space']*100)/$vhost['total_used_space']);
	} else {
	$space_pc = round(($vhost['total_used_space']*100)/$vhost['max_space']);
	}

	//20000 (20K) es el tamany maxim que pot tenir una carpeta redirigida
	if ($vhost['total_used_space']>20000)  {

        if ($vhost['hosting_id']!=0) { 
	$alert_sign='<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 20 20">
  <title>Límite hosting excedido</title>
  <style type="text/css">* { fill: #ff5d00 }</style>
  <path d="M19.64 16.36L11.53 2.3A1.85 1.85 0 0 0 10 1.21 1.85 1.85 0 0 0 8.48 2.3L.36 16.36C-.48 17.81.21 19 1.88 19h16.24c1.67 0 2.36-1.19 1.52-2.64zM11 16H9v-2h2zm0-4H9V6h2z"/>
</svg>';

if ($mod=="isp_hostings_vhosts") {
	if ($space_pc>=100) {
		 $add="<a style='position:relative;top:2px' href='https://control.intergridnetwork.net/?app=".$_GET['app']."&mod=isp_hostings'>".$alert_sign."</a> ";
		$out.="<div class='limits' style='color:#FF5D00'>".$add.bytes($vhost[$field]);

	} else {
		$out.="<div class='limits'>".bytes($vhost[$field]);

	}
}

if ($field=="total_used_space") {
 //tooltip
 if ($mod=="isp_hostings_vhosts") {
 $out.="<div class='tooltip'><b>".strtoupper($vhost['name'])."</b>:<br><table cellpadding=0 cellspacing=0><tr><td>Web:</td><td>".bytes($vhost['used_space_httpdocs'])."</td></tr><tr><td>Databases:</td><td>".bytes($vhost['used_space_databases'])."</td></tr><tr class='last'><td>Email:</td><td>".bytes($vhost['used_space_mailboxes'])."</td></tr><tr class='total'><td><b>TOTAL</b>:</td><td><b>".bytes($vhost[$field])."</b></td></tr></table></div></div>";
 } else { 

$out.="<tr><td style='padding-right:5px'>".$vhost['name']."</td><td>".bytes($vhost[$field])."</td></tr>";
$resultat['total']=$vhost[$field];

 }
}

	}
	$label="x";	
	$action="manage";
	$title="Limits del domini";

	

}
//       $out="<div style='float:left'><a href=\"?action=$action\" title=\"".$title."\"><img src=\"/kms/css/aqua/img/small/$icon\"></a></div><div style='float:left;padding-left:5px;padding-top:2px;'>$label</div>";
	
$title="none";	

$resultat['out']=$out;
return $resultat;

}

?>
