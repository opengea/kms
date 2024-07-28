<?php
include "setup.php";
//UPDATE CP
echo "isp space used totals\n";
echo "updating vhosts totals ...\n...cp ";
update($dblink_cp);
//UPDATE TARTARUS
echo "100\n...tartarus ";
update($dblink_erp);
echo "100%\n";


function update($dblink) {
        // TOTAL SPACE (today values)
	$res=mysqli_query($dblink,"select * from kms_isp_servers where hostname='".gethostname()."'");
	if (!$res) die(mysqli_error($res));
	$current_server=mysqli_fetch_array($res);

	//tots els vhosts del log del servidor actual
        $sel="SELECT * FROM kms_isp_hostings_vhosts_log,kms_isp_hostings_vhosts,kms_isp_hostings WHERE kms_isp_hostings_vhosts_log.date='".date('Y-m-d')."' and kms_isp_hostings_vhosts_log.domain=kms_isp_hostings_vhosts.name and kms_isp_hostings_vhosts.hosting_id=kms_isp_hostings.id and (kms_isp_hostings.webserver_id=".$current_server['id']." or kms_isp_hostings.mailserver_id=".$current_server['id'].")"; 
        $usage = array();
        $res=mysqli_query($dblink,$sel);
        $n=0;
        while ($log=mysqli_fetch_array($res)) {
                $total_used_space=$log['used_space_httpdocs']+$log['used_space_subdomains']+$log['used_space_ftps']+$log['used_space_logs']+$log['used_space_databases']+$log['used_space_mailboxes'];

                $update ="update kms_isp_hostings_vhosts set total_used_space='".$total_used_space."',used_space_httpdocs='".$log['used_space_httpdocs']."',used_space_ftps='".$log['used_space_ftps']."',used_space_subdomains='".$log['used_space_subdomains']."',used_space_logs='".$log['used_space_logs']."',used_space_databases='".$log['used_space_databases']."',used_space_mailboxes='".$log['used_space_mailboxes']."' where name=".$log['domain'];
                #echo "updating ".$log['domain']."...\n";
                mysqli_query($dblink,$update);
        }

        // TOTAL CURRENT MONTH TRANSFER !! 
        $sel="select * from kms_isp_hostings_vhosts_log WHERE date BETWEEN '".date('Y-m-01')."' AND '".date('Y-m-d', strtotime("-1 day"))."' order by domain";
        $res=mysqli_query($dblink,$sel);
        $n=0;
	$current_domain="";
	$current_month_transfer=0;
        while ($log=mysqli_fetch_array($res)) {
		if ($current_domain=="") $current_domain=$log['domain'];
		if ($log['domain']!=$current_domain&&$current_domain!="") {
                $update ="update kms_isp_hostings_vhosts set total_used_transfer='{$current_month_transfer}' where name=".$log['domain'];
                mysqli_query($dblink,$update);
		$current_domain=$log['domain'];
		} 
		$one_day_transfer=$log['used_transfer_web']+$log['used_transfer_mailboxes']+$log['used_transfer_webmail'];
		$current_month_transfer+=$one_day_transfer;
        }
}


?>

