<?php
include "setup.php";
run($dblink_cp);
mysqli_close($dblink);
//echo "...cp 100%...tartarus ";
//run($dblink_erp);
//mysqli_close($dblink);


function run($dblink) {


	$sel="select id,name,webserver_id,mailserver_id from kms_isp_hostings_vhosts";
	$res=mysqli_query($dblink,$sel);
	while ($vhost=mysqli_fetch_assoc($res)) {


		echo "processing domain ".$vhost['name']."...\n";

                $sel="select hostname from kms_isp_servers where id=".$vhost['webserver_id'];
                $res2=mysqli_query($dblink,$sel);
                $webserver=mysqli_fetch_assoc($res2);

                $sel="select hostname from kms_isp_servers where id=".$vhost['mailserver_id'];
                $res2=mysqli_query($dblink,$sel);
                $mailserver=mysqli_fetch_assoc($res2);

		$sel="select name from kms_isp_databases where vhost_id=".$vhost['id'];
		$res2=mysqli_query($dblink,$sel);

	        //tamanys vhosts api
//        	$json = file_get_contents('http://'.$webserver['hostname'].':7475/api/v1/vhosts/disk-usage/single/'.str_replace(".","-dot-",$vhost['name']));
		$json = file_get_contents('https://'.$webserver['hostname'].':7475/api/v1/vhosts/disk-usage/single/'.$vhost['name']);

	        $vhosts_du = json_decode($json);

		//tamanys databases api
		 $databases_du_total=0;
		while ($database=mysqli_fetch_assoc($res2)) {
//		$json = file_get_contents('http://'.$webserver['hostname'].':7475/api/v1/database/disk-usage/single/'.str_replace(".","-dot-",$database['name']));
		 $json = file_get_contents('https://'.$webserver['hostname'].':7475/api/v1/database/disk-usage/single/'.$database['name']);

                $database_du = json_decode($json);
		if ($database_du->status=="success") $databases_du_total+=$database_du->data['size']; else echo "ERROR: ".$database_du->data->title;
		}

                //tamanys busties api
//                $json = file_get_contents('http://'.$mailserver['hostname'].':7475/api/v1/email/disk-usage/single/'.str_replace(".","-dot-",$vhost['name']));
		$json = file_get_contents('https://'.$mailserver['hostname'].':7475/api/v1/email/disk-usage/single/'.$vhost['name']);
                $mailboxes_du = json_decode($json);
		$mailboxes_du_total = $mailboxes_du->data['total_size'];	

        	if ($vhosts_du->status=="success") {

		$today=date('Y-m-d');

		//update daily log
		$sel="SELECT date from kms_isp_hostings_vhosts_log WHERE  domain='$current_vhost' and date='".$today."'";
		$res2=mysqli_query($dblink,$sel);
		$check=mysqli_fetch_assoc($res2);
		if ($check['date']!=$today) { 
			$query="INSERT INTO kms_isp_hostings_vhosts_log (domain,date,used_space_httpdocs,used_space_ftps,used_space_subdomains,used_space_logs,used_space_mailboxes,used_space_databases) VALUES ('".$vhost['name']."','".$today."','".$vhosts_du->data->total_httpdocs."','".$vhosts_du->data->total_webusers."','".$vhosts_du->data->total_subdomains."','".$vhosts_du->data->total_stats."',".$mailboxes_du_total."','".$databases_du_total."')";
		} else {
			$query = "UPDATE kms_isp_hostings_vhosts_log SET used_space_httpdocs='{$vhosts_du->data->total_httpdocs}',used_space_ftps='{$vhosts_du->data->total_webusers}',used_space_subdomains='{$vhosts_du->data->total_subdomains}',used_space_logs='{$vhosts_du->data->total_stats}',used_space_mailboxes='".$mailboxes_du_total."',used_space_databases='".$databases_du_total."' WHERE domain='".$vhost['name']."' and date='".date('Y-m-d')."'";
echo $update."\n";
		}
		echo $query."\n";
		$result=mysqli_query($dblink,$query);
		if (!$result) die('error updating database '.$query);


		//update vhost disk_used
		$query="UPDATE kms_isp_hostings_vhosts SET total_used_space='".$vhosts_du['total_size']."',used_space_httpdocs='".$vhosts_du['total_httpdocs']."',used_space_subdomains='".$vhosts_du['total_subdomains']."',used_space_ftps='".$vhosts_du['total_webusers']."',used_space_logs='".$vhosts_du['total_stats']."' WHERE id=".$vhost['id'];
		$result=mysqli_query($dblink,$query);

		}

	}
}
	


?>
