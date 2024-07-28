<?
	if (!isset($field)) die('missing field');
	include_once "hosting_functions.php";
	
	$t=0;
	
	$select_base = "SELECT webserver_id,name,total_used_space,used_space_httpdocs,used_space_mailboxes,used_space_databases,max_space,hosting_id from kms_isp_hostings_vhosts";
	
	if ($mod=="isp_hostings_vhosts") {
		$sel = $select_base." where id=".$id;
	} else if ($mod=="isp_hostings") {
		 $sel = $select_base." where hosting_id=".$id;
	}
        $res=mysqli_query($this->dm->dblinks['client'],$sel);
	$out="";
	$total=0;
	while ($vhost=mysqli_fetch_assoc($res)) {
		
		$resultat=calculate_vhost_size($vhost,$field,$mod);
		$out.=$resultat['out'];
		$total+=$resultat['total'];
	}

	if ($mod=="isp_hostings") $out="<div class='limits'>".bytes($total)."<div class='tooltip'><table cellpadding=0 cellspacing=0>".$out."</table></div></div>";
?>
