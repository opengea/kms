<?php
echo "[isp_update_totals.php]\n";
include "setup.php";

// UPDATE VHOSTS TOTALS 
$res=mysqli_query("select * from kms_isp_servers where hostname='".gethostname()."'",$dblink_cp);
if (!$res) die(mysqli_error($res));
$current_server=mysqli_fetch_array($res);

echo "1/2 updating vhosts totals ...\n";
echo "CP:\n";
update_vhosts_totals($dblink_cp,$current_server);
echo " 100%\nTartarus: ";
update_vhosts_totals($dblink_erp,$current_server);
echo " 100%\n";
// UPDATE HOSTINGS
echo "2/2 updating hostings totals ... \n";
echo "CP:\n";

update_hostings_totals($dblink_cp,$current_server);
echo " 100%\nTartarus: ";
update_hostings_totals($dblink_erp,$current_server);
echo " 100%\n";


function update_vhosts_totals($dblink,$current_server) {

	// TOTAL SPACE (today values)
	$date=date('Y-m-d');
-
//	$sel="select * from kms_isp_hostings_vhosts_log WHERE date='".$date."'"; //avui (ahir)
	$sel="SELECT l.domain,l.date,l.used_space_httpdocs,l.used_space_mailboxes,l.used_space_extranet,l.used_space_databases,l.used_space_subdomains,l.used_space_ftps,l.used_space_backups,l.used_space_logs,l.used_transfer_web,l.used_transfer_mailboxes,l.used_transfer_webmail FROM kms_isp_hostings_vhosts_log as l,kms_isp_hostings_vhosts,kms_isp_hostings WHERE kms_isp_hostings_vhosts.name=l.domain AND kms_isp_hostings_vhosts.hosting_id=kms_isp_hostings.id AND (kms_isp_hostings_vhosts.webserver_id=".$current_server['id']." or kms_isp_hostings_vhosts.mailserver_id=".$current_server['id'].") AND date='".$date."' order by hosting_id";
//echo $sel;
        $usage = array();
        $res=mysqli_query($dblink,$sel);
        $n=0;
        while ($log=mysqli_fetch_array($res)) {
//                $total_used_space=$log['used_space_httpdocs']+$log['used_space_subdomains']+$log['used_space_ftps']+$log['used_space_logs']+$log['used_space_databases']+$log['used_space_mailboxes']+$log['used_space_extranet']+$log['used_space_backups'];
		$total_used_space=$log['used_space_httpdocs']+$log['used_space_subdomains']+$log['used_space_ftps']+$log['used_space_logs']+$log['used_space_databases']+$log['used_space_mailboxes']+$log['used_space_extranet'];

                $update ="update kms_isp_hostings_vhosts set total_used_space='".$total_used_space."',used_space_httpdocs='".$log['used_space_httpdocs']."',used_space_backups='".$log['used_space_backups']."',used_space_extranet='".$log['used_space_extranet']."',used_space_ftps='".$log['used_space_ftps']."',used_space_subdomains='".$log['used_space_subdomains']."',used_space_logs='".$log['used_space_logs']."',used_space_databases='".$log['used_space_databases']."',used_space_mailboxes='".$log['used_space_mailboxes']."' where name='".$log['domain']."'";
//		echo $update."\n";
		echo "\nUpdating total space ".$log['domain']." ...";
                $res2=mysqli_query($dblink,$update);
		if (!$res2) die('error '.mysqli_error($res2).' '.$update);
		$n++;
        }
	echo "\n(space updated {$n} domains)";

        // TOTAL MONTHLY TRANSFER (LAST 30 DAYS!!)

//	$sel="select domain from kms_isp_hostings_vhosts_log WHERE date>'".date('Y-m-d', strtotime("-31 day"))."' and date<'".date('Y-m-d')."' GROUP BY domain";
	 $sel="select domain FROM kms_isp_hostings_vhosts_log,kms_isp_hostings,kms_isp_hostings_vhosts WHERE date>'".date('Y-m-d', strtotime("-31 day"))."' and date<'".date('Y-m-d')."' AND kms_isp_hostings_vhosts.name=kms_isp_hostings_vhosts_log.domain AND kms_isp_hostings_vhosts.hosting_id=kms_isp_hostings.id AND (kms_isp_hostings_vhosts.webserver_id=".$current_server['id']." or kms_isp_hostings_vhosts.mailserver_id=".$current_server['id'].") GROUP BY domain";
	$res=mysqli_query($dblink,$sel);
	if (!$res) die ('error:'. $sel);
        $n=0;
        while ($domain=mysqli_fetch_array($res)) {
	        $sel="select * from kms_isp_hostings_vhosts_log WHERE domain='".$domain['domain']."' AND date>'".date('Y-m-d', strtotime("-31 day"))."' and date<'".date('Y-m-d')."'";
	        $res2=mysqli_query($dblink,$sel);
		$total_transfer=0;
	        while ($log=mysqli_fetch_array($res2)) {
	                $total_transfer+=$log['used_transfer_web']+$log['used_transfer_mailboxes']+$log['used_transfer_webmail'];
	        }
		$update ="update kms_isp_hostings_vhosts set total_used_transfer='{$total_transfer}' where name='".$domain['domain']."'";
                echo "\nUpdating total transfer ".$domain['domain']." {$total_transfer}...";
                $res3=mysqli_query($dblink,$update);
                if (!$res3) die('error '.mysqli_error($res3).' '.$update);
		$n++;
	}
	echo "\n(transfer updated {$n} domains)";
}

function update_hostings_totals($dblink,$current_server) {

       // $sel="select * from kms_isp_hostings_vhosts";
	$sel="SELECT * FROM kms_isp_hostings_vhosts WHERE (kms_isp_hostings_vhosts.webserver_id=".$current_server['id']." or kms_isp_hostings_vhosts.mailserver_id=".$current_server['id'].")";
        $usage = array();
        $res=mysqli_query($dblink,$sel);
	if (!$res) die(mysqli_error($res)." ".$sel);
        $n=0;
	//sumem totals de cada vhost
	$s=array();
	$t=array();
	$v=array();
        while ($vhost=mysqli_fetch_array($res)) {
		if (!isset($s[$vhost['hosting_id']])) $s[$vhost['hosting_id']]=0;
		if (!isset($t[$vhost['hosting_id']])) $t[$vhost['hosting_id']]=0;
		if (!isset($v[$vhost['hosting_id']])) $v[$vhost['hosting_id']]=0;	
                $s[$vhost['hosting_id']]=$s[$vhost['hosting_id']]+$vhost['total_used_space'];
                $t[$vhost['hosting_id']]=$t[$vhost['hosting_id']]+$vhost['total_used_transfer'];
		$v[$vhost['hosting_id']]=$v[$vhost['hosting_id']]+1;//used vhosts
		$n++;
        }
	$n=0;
        foreach ($s as $hosting_id => $space) {
		if ($hosting_id!="") {
                $update ="update kms_isp_hostings set used_space=".$s[$hosting_id].",used_transfer=".$t[$hosting_id].",used_vhosts=".$v[$hosting_id]." where id=$hosting_id";
		//echo $update."\n";
                $res2=mysqli_query($dblink,$update);
		if (!$res2) die('error : '.mysqli_error($res2).' '.$update);
		}
        }
	
        // Automatic update of max_space & max_transfer of vhosts.
        // In multihosts the max_space and max_transfer will automaticaly change according the free space of the hosting plan.
        echo "\nAutomatic update of max_space / max_transfer for vhosts\n\n";

       // $sel="select * from kms_isp_hostings_vhosts";
	$sel="SELECT * FROM kms_isp_hostings_vhosts WHERE (kms_isp_hostings_vhosts.webserver_id=".$current_server['id']." or kms_isp_hostings_vhosts.mailserver_id=".$current_server['id'].")";
        
        $usage = array();
        $res=mysqli_query($dblink,$sel);
        $n=0;
	
        while ($vhost=mysqli_fetch_array($res)) {

                $sel="select * from kms_isp_hostings where id='".$vhost['hosting_id']."'";
                $res2=mysqli_query($dblink,$sel);
                $hosting=mysqli_fetch_array($res2);
		//	echo $vhost['name']." : max_space=(".$hosting['max_space']."-".$hosting['used_space'].")+".$vhost['total_used_space']."\n";
                $max_space=($hosting['max_space']-$hosting['used_space'])+$vhost['total_used_space'];
                $max_transfer=($hosting['max_transfer']-$hosting['used_transfer'])+$vhost['total_used_transfer'];
                $update = "update kms_isp_hostings_vhosts set max_space='{$max_space}',max_transfer='{$max_transfer}' where id=".$vhost['id'];
		// echo $update."\n";
                $res2=mysqli_query($dblink,$update);
		if (!$res2) die('error : '.mysqli_error($res2).' '.$update);
        }

}

?>
