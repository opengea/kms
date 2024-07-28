<?php
include "setup.php";

echo "create today records...\n";
run($dblink_cp);
mysqli_close($dblink_cp);
echo "...CP 100%\n";
run($dblink_erp);
mysqli_close($dblink);
echo "...TARTARUS 100%\n";


function run($dblink) {

	$logfile="/var/log/kms/cron/isp/isp_space_used_vhosts.log";$logtype="vhosts";
	if (!file_exists($logfile)) {$logfile="/var/log/kms/cron/isp_space_used_mailboxes.log"; $logtype="vmail"; }
	if (!file_exists($logfile)) die('Log not found '.$logfile);
	echo "Using ".$logfile."\n";
	$file=fopen($logfile,"r");
	$yesterday_skip=$today_skip=false;
	while(!feof($file))
	  {


                $s=fgets($file);

		if ($logtype=="vhosts") {
                $s=str_replace("/var/www/vhosts/","",$s);
                $bytes = substr($s,0,strpos($s,"\t"));
                $s = substr($s,strpos($s,"\t")+1);
                $vhost = substr($s,0,strpos($s,"/"));
                $folder = substr($s,strpos($s,"/")+1);
                $folder = substr($folder,0,strlen($folder)-1);
		} else if ($logtype=="vmail") {
		$s=str_replace("/var/vmail/","",$s);
		$bytes = substr($s,0,strpos($s,"\t"));
		$s = substr($s,strpos($s,"\t")+1);
		$vhost = trim($s);
		$folder="httpdocs";	
		}

		if ($vhost!=""&&$folder=="httpdocs") {
		// YESTERDAY RECORDS
		if (!$yesterday_skip) {
			//check if yesterday record exists
			$select ="select domain from kms_isp_hostings_vhosts_log where `date`='".date('Y-m-d', strtotime("-1 days"))."' and domain='{$vhost}' limit 1";
			$res=mysqli_query($dblink,$select);
			$row=mysqli_fetch_array($res);
			if ($row['domain']=="") { 
				$insert = "INSERT INTO kms_isp_hostings_vhosts_log (domain,date) VALUES ('{$vhost}', '".date('Y-m-d', strtotime("-1 days"))."')";
				$result=mysqli_query($dblink,$insert);
echo $insert;
				} else {
				$yesterday_skip=true; 
				}
		}

		// TODAY RECORDS
		if (!$today_skip) {
			
			//check if today record exists
			$select ="select domain from kms_isp_hostings_vhosts_log where `date`='".date('Y-m-d')."' and domain='{$vhost}' limit 1";
			$res=mysqli_query($dblink,$select);
			$row=mysqli_fetch_array($res);
			if ($row['domain']=="") {
				$insert = "INSERT INTO kms_isp_hostings_vhosts_log (domain,date) VALUES ('{$vhost}', '".date('Y-m-d')."')";
				$result=mysqli_query($dblink,$insert);
echo $insert;
				} else {
//				$today_skip=true;
				}
		}
		}
	}
	fclose($file);
}
	
?>
