<?php
include "setup.php";

echo "...updating transfer cp ";
run($dblink_cp);
echo "100%...tartarus ";
run($dblink_erp);
echo "100%\n";

function run($dblink) {
	//yesterday transfer
	$file=fopen("/var/log/kms/cron/isp/isp_transfer_used.log","r");
	while(!feof($file)) 
	  {
		$s=fgets($file);
		$vhost = strtolower(substr($s,0,strpos($s," ")));
		$bytes = substr($s,strpos($s," ")+1);
		$bytes = substr($bytes,0,strlen($bytes)-1);	
		if ($vhost!="") {
//			echo "updating yesterday transfer of ".$vhost." ...\n";
	//		$select = "SELECT total_used_transfer FROM kms_isp_hostings_vhosts WHERE name='$vhost'";
	//		$result=mysqli_query($select);
	//		$transfer=mysqli_fetch_array($result);
	//		if ($transfer['total_used_transfer']!="") {
	//		$sum=$transfer['total_used_transfer']+$bytes;
	//		$update = "UPDATE kms_isp_hostings_vhosts SET total_used_transfer=$sum WHERE name='$vhost'";
			$update = "UPDATE kms_isp_hostings_vhosts_log SET used_transfer_web='$bytes' WHERE domain='$vhost' and date='".date('Y-m-d', strtotime("-1 day"))."'";
//		echo $update."\n";
			$result=mysqli_query($dblink,$update);
			if (!$result) die('error updating database '.$update);
	//		}
		} 
	}
fclose($file);
}
?>
