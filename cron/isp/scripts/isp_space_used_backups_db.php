<?php
include "setup.php";

$res=mysqli_query($dblink_cp,"select * from kms_isp_servers where hostname='".gethostname()."'");
if (!$res) die(mysqli_error($res));
$current_server=mysqli_fetch_array($res);

$select="SELECT * FROM kms_isp_backups,kms_isp_hostings_vhosts where kms_isp_backups.vhost_id=kms_isp_hostings_vhosts.id AND (kms_isp_hostings_vhosts.webserver_id=".$current_server['id']." or kms_isp_hostings_vhosts.mailserver_id=".$current_server['id'].") order by vhost_id";

$res=mysqli_query($select,$dblink_cp);
if (!$res) die(mysqli_error($res));
$current_vhost=0;
$n=0;
echo "starting...\n\n";
while($backup=mysqli_fetch_array($res)) {
	if ($current_vhost!=$backup['vhost_id']) { 

		if ($current_vhost!=0) {
			echo "updating ".$vhost['name']."...\n";
			$update="UPDATE kms_isp_hostings_vhosts_log SET used_space_backups='".$total."' WHERE domain='".$vhost['name']."' AND date='".date('Y-m-d')."'";
		        $res_update=mysqli_query($dblink_cp,$update);
			$res_update=mysqli_query($dblink_erp,$update);
			$n++;
		}
		$current_vhost=$backup['vhost_id']; $total=0; 
		$sel2="select name from kms_isp_hostings_vhosts where id=".$current_vhost;
		$res2=mysqli_query($sel2,$dblink_cp);
		$vhost=mysqli_fetch_array($res2);
	}
	$total+=$backup['bytes'];
}
echo "updating ".$vhost['name']."...\n";
$update="UPDATE kms_isp_hostings_vhosts_log SET used_space_backups='".$total."' WHERE domain='".$vhost['name']."' AND date='".date('Y-m-d')."'";
$res_update=mysqli_query($dblink_cp,$update);
$res_update=mysqli_query($dblink_erp,$update);
$n++;

echo $n." vhosts processed.\n";



?>
