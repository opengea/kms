<?php
include "setup.php";
run($dblink_cp);
mysqli_close($dblink);
echo "...cp 100%...tartarus ";
run($dblink_erp);
mysqli_close($dblink);
echo "100%\n";


function run($dblink) {

	$file=fopen("/var/log/kms/cron/isp/isp_space_used_vhosts.log","r");
	if ($file) {

	while(!feof($file))
	  {
		
		$s=fgets($file);
		$s=str_replace("/var/www/vhosts/","",$s);
		$bytes = substr($s,0,strpos($s,"\t"));
		$s = substr($s,strpos($s,"\t")+1);
		$vhost = substr($s,0,strpos($s,"/"));
		$folder = substr($s,strpos($s,"/")+1);
		$folder = substr($folder,0,strlen($folder)-1);

//		$date=date('Y-m-d', strtotime("-1 days"));
		$date=date('Y-m-d');

		if ($current_vhost=="") $current_vhost=$vhost;
		if ($vhost!=$current_vhost&&$vhost!="") {
		$update = "UPDATE kms_isp_hostings_vhosts_log SET used_space_httpdocs='{$used_space_httpdocs}',used_space_ftps='{$used_space_ftps}',used_space_subdomains='{$used_space_subdomains}',used_space_logs='{$used_space_logs}' WHERE domain='$current_vhost' and date='".$date."'";
echo $update."\n";
		$result=mysqli_query($dblink,$update);
		if (!$result) die('error updating database '.$update);
		$current_vhost=$vhost;
		//echo "updating ".$vhost." ...\n";
		}

		if ($folder=="httpdocs") $used_space_httpdocs=$bytes;
                else if ($folder=="web_users") $used_space_ftps=$bytes;
                else if ($folder=="subdomains") $used_space_subdomains=$bytes;
                else if ($folder=="statistics") $used_space_logs=$bytes;
	}
	fclose($file);
	}
}
	


?>
