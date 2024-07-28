<?php
# actualitzador de tots els hostings de tots els servidors
# accepts parameters:  ID hosting

include "/usr/local/kms/lib/dbi/db_localhost_connect.php";

$dblink_cp = mysqli_connect($conf['auth_server'], $conf['master_db_user'], $conf['master_db_pass'],$conf['auth_db_name']);
mysqli_query($dblink_cp,"SET NAMES 'utf8'");
if (!$link) die('Could not connect to CP'.mysqli_error());

$sel="select * from kms_isp_hostings where status='active'";
if (isset($argv[1]))  $sel.=" and id=".$argv[1];
$res=mysqli_query($dblink_local,$sel);
$log="";
$i=0;
$yesterday=date('Y-m-d', strtotime("-1 days"));

while ($hosting=mysqli_fetch_assoc($res)) {

	//updating used mailboxes
	$update="update kms_isp_hostings set used_mailboxes=(select count(*) from kms_isp_mailboxes where vhost_id in (select id from kms_isp_hostings_vhosts where hosting_id=kms_isp_hostings.id))";
	$res2=mysqli_query($dblink_local,$update);
	if (!$res2) { echo "ERROR updating used mailboxes on ERP database: ".$update."\n"; $log.="ERROR updateing used mailboxes on ERP database ".$update."<br>"; }
	$res2=mysqli_query($dblink_cp,$update);
	if (!$res2) { echo "ERROR updating used mailboxes on CP database: ".$update."\n"; $log.="ERROR updateing used mailboxes on CP database ".$update."<br>"; }

	echo "****** Hosting ".$hosting['description']." (".$hosting['id'].") ********\n";
	$log.="****** Hosting ".$hosting['description']." (".$hosting['id'].") ********<br>";

	$total_space_hosting=0;
	$total_transfer_hosting=0;

	$sel="select * from kms_isp_hostings_vhosts where hosting_id=".$hosting['id']; //" and `type`!='redirect_301'; // and `type` not like 'redirect%'";
	$res2=mysqli_query($dblink_local,$sel);

	while ($vhost=mysqli_fetch_assoc($res2)) {

		$usage=array();
		$usage['vhost']=$usage['db']=$usage['mail']=$usage['transfer']=0;
		echo "Vhost ".$vhost['name']."\n";
		$log.="Vhost ".$vhost['name']."<br>";

	        $sel = "SELECT hostname from kms_isp_servers where id=".$vhost['mailserver_id'];
        	$res3=mysqli_query($dblink_local,$sel);
		if (!$res3) die(mysqli_error($res3));
	        $mailserver=mysqli_fetch_assoc($res3);

		$sel = "SELECT hostname from kms_isp_servers where id=".$vhost['webserver_id'];
	        $res3=mysqli_query($dblink_local,$sel);
	        $webserver=mysqli_fetch_assoc($res3);
	
		//Vhost disk usage
		if ($webserver['hostname']&&$vhost['type']!="redirect_301") {
		//$api_url=trim("http://".$webserver['hostname'].":7475/api/v1/vhosts/disk-usage/single/".str_replace(".","-dot-",$vhost['name']));
		$api_url=trim("https://".$webserver['hostname'].":7475/api/v1/vhosts/disk-usage/single/".$vhost['name']);
echo $api_url."\n";
		$json = file_get_contents($api_url);
	        $vhost_disk_usage = json_decode($json);
        	if ($vhost_disk_usage=="") echo "API CALL ERROR: ".print_r($json)."<br>";
                if ($vhost_disk_usage->status=="error") {
				$log.="<b>ERROR: ".$vhost_disk_usage->data->title."</b><br>".$api_url."<br><br>";
				} else $usage['vhost']=$vhost_disk_usage->data->total_size;
		} else { $usage['vhost']=0; }

                //Mail disk usage

		if ($mailserver['hostname']) {
                //$api_url=trim("http://".$mailserver['hostname'].":7475/api/v1/email/disk-usage/single/".str_replace(".","-dot-",$vhost['name']));
		$api_url=trim("https://".$mailserver['hostname'].":7475/api/v1/email/disk-usage/single/".$vhost['name']);
echo $api_url."\n";
                $json = file_get_contents($api_url);
                $mail_disk_usage = json_decode($json);
                if ($mail_disk_usage=="") echo "API CALL ERROR: ".print_r($json)."<br>";
		    if ($mail_disk_usage->status=="error") { 
				if (strpos($mail_disk_usage->data->title,"doesn't exist")) $usage['mail']=0; 
				else $log.="<b>ERROR ".$mail_disk_usage->data->title."</b><br>".$api_url."<br><br>";
                   } else $usage['mail']=$mail_disk_usage->data->total_size;

		} else { $usage['mail']=0; }


                //Database disk usage

		$sel = "SELECT name,db_server FROM kms_isp_databases where vhost_id=".$vhost['id'];
		$res3= mysqli_query($dblink_local,$sel);
		$total_db=0;
		$num_db=0;
		while ($db=mysqli_fetch_assoc($res3)) {

			if ($db['db_server']!=$webserver['hostname']) $log.="<b>Database ".$db['name']." inconsistency db server ".$db['db_server']."!= webserver ".$webserver['hostname']."</b><br>";
               // 	$api_url=trim("http://".$webserver['hostname'].":7475/api/v1/database/disk-usage/single/".str_replace(".","-dot-",$db['name']));
			$api_url=trim("https://".$webserver['hostname'].":7475/api/v1/database/disk-usage/single/".$db['name']);
echo $api_url."\n";
	                $json = file_get_contents($api_url);
	                $db_disk_usage = json_decode($json);
	                if ($db_disk_usage=="") echo "API CALL ERROR: ".print_r($json)."<br>";
	                if ($db_disk_usage->status=="error") {
	                                $log.="<b>ERROR ".$db_disk_usage->data->title."</b><br>".$api_url."<br><br>";
                                } else $usage['db']=$db_disk_usage->data->size;
			$num_db++;
		}

		//Vhost transfer
//		$api_url=trim("http://".$webserver['hostname'].":7475/api/v1/vhosts/transfer-usage/single/".str_replace(".","-dot-",$vhost['name']))."/".$yesterday;
		$api_url=trim("https://".$webserver['hostname'].":7475/api/v1/vhosts/transfer-usage/single/".$vhost['name'])."/".$yesterday;
echo $api_url."\n";
                $json = file_get_contents($api_url);
                $vhost_transfer_usage = json_decode($json);
		if ($vhost_transfer_usage==""&&$_SERVER['REMOTE_ADDR']=='81.0.57.125') echo "API CALL ERROR: ".print_r($json)."<br>";
                if ($vhost_transfer_usage->status=="error") echo "API ERROR: (vhost_transfer_usage) (server=".$webserver['hostname'].") ".$vhost_transfer_usage->data->title."\n"; else { $usage['transfer']=$vhost_transfer_usage->data->traffic; }


//		 echo "\tDB_disk_usage=".$db_disk_usage->data->total_size;	
	
/*
        if ($mailbox['used_space']!=$api->data->total_size&&$api->data->total_size!=0) {
                        $mailbox['used_space']=$api->data->total_size;
                        $update="update kms_isp_mailboxes set total_used_space='".$mailbox['used_space']."' where id=".$id;
                 //       $res=mysqli_query($update);
        }
*/

		$total_vhost=$usage['vhost']+$usage['db']+$usage['mail'];
		$total_space_hosting+=$total_vhost;
		
		//updates

		$sel="select used_transfer_web from kms_isp_hostings_vhosts_log where domain='".$vhost['name']."' and date>='".date('Y-m-d', strtotime("-30 days"))."' and date<'".date('Y-m-d')."'";
		$res3=mysqli_query($dblink_local,$sel);
                if (!$res3) { echo "ERROR retreiving transfer from vhosts log: ".$sel."\n"; $log.="ERROR retreiving transfer from vhosts log:  ".$sel."<br>"; }
		$monthly_transfer=0;
		while ($row=mysqli_fetch_assoc($res3)) {
			$monthly_transfer+=$row['used_transfer_web'];
		}
		if ($monthly_transfer<$usage['transfer']) $monthly_transfer=$usage['transfer']*29; // estimem transferencia mensual
		$monthly_transfer+=$usage['transfer']; //we add the last one

		$total_transfer_hosting+=$monthly_transfer;

		$update="update kms_isp_hostings_vhosts set total_used_space='".$total_vhost."',
							    used_space_httpdocs='".$usage['vhost']."',
							    used_space_mailboxes='".$usage['mail']."',
							    used_space_databases='".$usage['db']."',
							    total_used_transfer='".$monthly_transfer."'
							    where id=".$vhost['id'];
		// total_used_transfer 
echo $update."\n";
		$res3=mysqli_query($dblink_local,$update);
		if (!$res) { echo "ERROR updating ERP database: ".$update."\n"; $log.="ERROR updating ERP database ".$update."<br>"; }
		$res3=mysqli_query($dblink_cp,$update);
                if (!$res) { echo "ERROR updating CP database: ".$update."\n"; $log.="ERROR updating CP database".$update."<br>"; }

		// update log

		$sel="select id from kms_isp_hostings_vhosts_log where domain='".$vhost['name']."' and date='".$yesterday."'";
		$res3=mysqli_query($dblink_local,$sel);
		$exists=mysqli_fetch_assoc($res3);
		if ($exists['id']=="") {

		$insert="insert into kms_isp_hostings_vhosts_log (domain,date) values ('".$vhost['name']."','".$yesterday."')";
		$res3=mysqli_query($dblink_local,$insert);
                if (!$res) { echo "ERROR inserting log ERP database: ".$insert."\n"; $log.="ERROR inserting ERP database ".$insert."<br>"; }
                $res3=mysqli_query($dblink_cp,$insert);
                if (!$res) { echo "ERROR inserting  log CP database: ".$insert."\n"; $log.="ERROR inserting CP database ".$insert."<br>"; }

		}

		$update="update kms_isp_hostings_vhosts_log set 
								used_space_httpdocs='".$usage['vhost']."',
								used_space_mailboxes='".$usage['mail']."',
								used_space_databases='".$usage['db']."',
								used_transfer_web='".$usage['transfer']."' 
								where domain='".$vhost['name']."' and date='".$yesterday."'";
		$res3=mysqli_query($dblink_local,$update);
                if (!$res) { echo "ERROR updating log ERP database: ".$update."\n"; $log.="ERROR updating ERP database ".$update."<br>"; }
                $res3=mysqli_query($dblink_cp,$update);
                if (!$res) { echo "ERROR updating log CP database: ".$update."\n"; $log.="ERROR updating CP database".$update."<br>"; }
		echo $update."\n";


	}
	echo "\n\nTOTAL SPACE HOSTING=".$total_space_hosting."\n";
        echo "\n\nTOTAL TRANSFER HOSTING=".$total_transfer_hosting."\n";

                $update="update kms_isp_hostings set used_space='".$total_space_hosting."',used_transfer='".$total_transfer_hosting."' where id=".$hosting['id'];
                //,used_transfer,
                $res3=mysqli_query($dblink_local,$update);
		if (!$res) { echo "ERROR updating ERP database: ".$update."\n"; $log.="ERROR updating ERP database: ".$update."<br>"; }
		$res3=mysqli_query($dblink_cp,$update);
                if (!$res) { echo "ERROR updating CP database: ".$update."\n"; $log.="ERROR updating CP database ".$update."<br>"; }

echo $update."\n";

		//update hosting log
		$sel="select id from kms_isp_hostings_log where hosting_id='".$hosting['id']."' and date='".$yesterday."'";
                $res3=mysqli_query($dblink_local,$sel);
                $exists=mysqli_fetch_assoc($res3);
                if ($exists['id']=="") {

                $insert="insert into kms_isp_hostings_log (hosting_id,date,type) values ('".$hosting['id']."','".$yesterday."','summary')";
                $res3=mysqli_query($dblink_local,$insert);
                if (!$res) { echo "ERROR inserting log ERP database: ".$insert."\n"; $log.="ERROR inserting ERP database ".$insert."<br>"; }
                $res3=mysqli_query($dblink_cp,$insert);
                if (!$res) { echo "ERROR inserting  log CP database: ".$insert."\n"; $log.="ERROR inserting CP database ".$insert."<br>"; }

		}

		$update="update kms_isp_hostings_log set 
							 used_space='".$total_space_hosting."',	
							 used_transfer='".$total_transfer_hosting."',
							 used_vhosts='".$hosting['used_vhosts']."',
							 used_mailboxes='".$hosting['used_mailboxes']."',
							 max_space='".$hosting['max_space']."',
							 max_transfer='".$hosting['max_transfer']."',
							 max_vhosts='".$hosting['max_vhosts']."',
							 max_mailboxes='".$hosting['max_mailboxes']."'
							 where hosting_id='".$hosting['id']."' and date='".$yesterday."'";
echo $update."\n";
                $res3=mysqli_query($dblink_local,$update);
                if (!$res) { echo "ERROR updating log ERP database: ".$update."\n"; $log.="ERROR updating ERP database: ".$update."<br>"; }
                $res3=mysqli_query($dblink_cp,$update);
                if (!$res) { echo "ERROR updating log CP database: ".$update."\n"; $log.="ERROR updating CP database ".$update."<br>"; }
					 

//if ($i==10) break;

$i++;

}


$from_name="KMS";
$from="g1@intergridnetwork.net";
$to="sistemes@intergrid.cat";
$subject="[KMS.ISP] Global Daily Hosting Report";
$body="Log from /usr/local/kms/mod/isp/hosting/global_daily_resouces_check.php<br><br>".$log;
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
$headers .= 'From: '.$from_name.' <'.$from.'>' . "\r\n";
$body="<span style='font-family:monospace;font-size:12px'>".$body."</span>";
mail($to, $subject, $body, $headers, "-f {$from}");


