#!/usr/bin/php -q
<?
error_reporting(0);
include "/usr/local/kms/lib/ssh2_exec.php";
include '/usr/local/kms/lib/mail/email.class.php';


function delete_hosting($id,$domain,$dblink) {

	$sel="select * from kms_isp_hostings where sr_contract=".$id; 
	$res=mysqli_query($dblink,$sel); $hosting=mysqli_fetch_array($res);
	if ($hosting['id']=="") return false;

        // ELIMINACIO FISICA
        // server
        $sel="select * from kms_isp_servers where id=".$hosting['webserver_id'];$res=mysqli_query($dblink,$sel);$webserver=mysqli_fetch_array($res);
        $sel="select * from kms_isp_servers where id=".$hosting['mailserver_id'];$res=mysqli_query($dblink,$sel);$mailserver=mysqli_fetch_array($res);
        //hosting 
        $command="ssh -i /root/.ssh/id_rsa root@".$webserver['hostname']." '/usr/local/kms/mod/isp/setup/delete_vhost.sh ".$domain." ".$domain."'";
        $result=ssh_exec("localhost",$command,"JADF7320cSJdcj3750492x42dj244");
	//emails
        $command="ssh -i /root/.ssh/id_rsa root@".$mailserver['hostname']." '/usr/local/kms/mod/isp/setup/delete_all_mailboxes.sh ".$domain."'";
        $result=ssh_exec("localhost",$command,"JADF7320cSJdcj3750492x42dj244");

        //base de dades
	$sel="select * from kms_isp_databases where vhost_id=".$vhost['id'];$res=mysqli_query($dblink,$sel);
	while ($database=mysqli_fetch_array($res)) {
        $command="ssh -i /root/.ssh/id_rsa root@".$webserver['hostname']." '/usr/local/kms/mod/isp/setup/delete_database.sh ".$database['name']." ".$database['login']."'";
        $result=ssh_exec("localhost",$command,"JADF7320cSJdcj3750492x42dj244");
	}
        //ftps (ftp user only, files are already deleted at this point)
	$sel="select * from kms_isp_ftps where vhost_id=".$vhost['id'];$res=mysqli_query($dblink,$sel);
        while ($ftp=mysqli_fetch_array($res)) {
        $command="ssh -i /root/.ssh/id_rsa root@".$webserver['hostname']." 'userdel ".$ftp['login']."'";
        $result=ssh_exec("localhost",$command,"JADF7320cSJdcj3750492x42dj244");
        }
	//webstats
	$command="ssh -i /root/.ssh/id_rsa root@".$webserver['hostname']." '/usr/local/kms/mod/isp/setup/delete_webstats.sh ".$domain."'";
        $result=ssh_exec("localhost",$command,"JADF7320cSJdcj3750492x42dj244");

	// ELIMINACIO A LA BASE DE DADES KMS ISP

        if ($hosting['id']!="") {
		$update="update kms_isp_domains set hosting_id=0 where hosting_id=".$hosting['id']." and sr_contract=".$id; 
		mysqli_query($dblink,$update);
		$delete="delete from kms_isp_hostings where sr_contract=".$id; mysqli_query($dblink,$delete);
	
		//eliminem tots els objectes dels vhosts
		$sel="select * from kms_isp_hostings_vhosts where hosting_id=".$hosting['id']; $res=mysqli_query($dblink,$sel);
		while ($vhost=mysqli_fetch_array($res)) {
			$delete="delete from kms_isp_mailboxes where vhost_id=".$vhost['id']; mysqli_query($dblink,$delete);
			$delete="delete from kms_isp_crontables where vhost_id=".$vhost['id']; mysqli_query($dblink,$delete);
			$delete="delete from kms_isp_databases where vhost_id=".$vhost['id']; mysqli_query($dblink,$delete);
			$delete="delete from kms_isp_ftps where vhost_id=".$vhost['id']; mysqli_query($dblink,$delete);
		}
		$delete="delete from kms_isp_hostings_vhosts where hosting_id=".$hosting['id']; mysqli_query($dblink,$delete);
	} else {
		echo "OPS!, no hosting found for contract ".$id."\n";
	}
	// en cas que el domini no tingui ja assignat un altre hosting
	$select = "select * from kms_isp_domains where name='".$domain."'"; $res=mysqli_query($dblink,$sel); 
	$domini=mysqli_fetch_array($res);
	if ($domini['hosting_id']==0) {
	//eliminem tambe zones dns
	$sel="select id from kms_isp_dns_zones where name='".$domain."'"; $r=mysqli_query($dblink,$sel);$zone=mysqli_fetch_array($r);
	$delete="delete from kms_isp_dns_zones where name='".$domain."'";mysqli_query($dblink,$delete);
	$delete="delete from kms_isp_dns_recs where zone_id=".$zone['id'];mysqli_query($dblink,$delete);
	}
	// en cas que hi hagi extranet
	$delete="delete from kms_isp_extranets where hosting_id=".$hosting['id'];mysqli_query($dblink,$delete);

}

echo "Initiation autocancellations for ".date('d-m-Y')."...\n";
include "/usr/local/kms/lib/dbi/db_localhost_connect.php";
$select="select * from kms_erp_contracts WHERE status!='finalitzat' and end_date<'".date('Y-m-d')."' and initial_date!=end_date and auto_renov='0'";
$result=mysqli_query($link,$select);
if (!$result) die('error selecting : '.mysqli_error($result).$select);
$now=date('Y-m-d');
$n=0;
while ($contract=mysqli_fetch_array($result)) {
	
	$sel="select * from kms_ecom_services where id=".$contract['sr_ecom_service'];$res=mysqli_query($link,$sel);$service=mysqli_fetch_array($res);

	echo "Performing automatic cancellation of contract #".$contract['id']." ".$contract['name']."\n";

	if ($service['family']==1) { // DOMINIS
		$delete="delete from kms_isp_domains where sr_contract=".$contract['id']; // and name='".$contract['domain']."'"
		include "/usr/local/kms/lib/dbi/db_localhost_connect.php";
		mysqli_query($link,$delete);
		include "/usr/local/kms/lib/dbi/db_master_connect.php";
		mysqli_query($link,$delete);
		// Eliminem el vhost nomes en cas que sigui un VHOST sense hosting (hosting_id=0) (inclou els serveis de redireccio, etc.)
		$sel="delete * from kms_isp_hostings_vhosts where hosting_id=0 and name='".$contract['domain']."'"; 
		$res=mysqli_query($link,$sel);

	} else if ($service['family']==2||$service['family']==3) { // HOSTING (TOT TIPUS)
		include "/usr/local/kms/lib/dbi/db_localhost_connect.php";
		delete_hosting($contract['id'],$contract['domain'],$link);
		include "/usr/local/kms/lib/dbi/db_master_connect.php";		
		delete_hosting($contract['id'],$contract['domain'],$link);
	} 
	include "/usr/local/kms/lib/dbi/db_localhost_connect.php";
	// DELETE PHISICAL VHOST FORWARDING  (Tant si es domini com hosting ho pot tenir activat)
	if ($hosting['webserver_id']==0) $hosting['webserver_id']=22; //servidor de forwardings per defecte
        $sel="select * from kms_isp_servers where id=".$hosting['webserver_id'];$res=mysqli_query($link,$sel);$webserver=mysqli_fetch_array($res);
	$command="ssh -i /root/.ssh/id_rsa root@".$webserver['hostname']." '/usr/local/kms/mod/isp/setup/delete_vhost_forwarding.sh ".$contract['domain']."'";
        $result_exec=ssh_exec("localhost",$command,"JADF7320cSJdcj3750492x42dj244");
	
        //mark contract as cancelled
        $update="update kms_erp_contracts SET status='finalitzat' where id=".$contract['id']; //end_date<'".date('Y-m-d')."'";
        $res=mysqli_query($link,$update);
        if (!$res) die(mysqli_error($res)."\n.".$update);

	$sel="select name from kms_ent_contacts where id=".$contract['sr_client'];
	$res2=mysqli_query($link,$sel);
	$entity=mysqli_fetch_array($res2);

	//ENVIEM TASCA MANUAL PER DONAR DE BAIXA DEDICATS I VIRTUALS
	if ($service['subfamily']==4) { //dedicats i virtuals
		$body="Cancel.lar el SERVIDOR DEDICAT associat al contracte #".$contract['id']." del client ".$entity['name'];
	} else if ($service['subfamily']==3) {
		$body="Cancel.lar el SERVIDOR VIRTUAL associat al contracte #".$contract['id']." del client ".$entity['name'];
	} else {
		 $body="Cancel.lar els serveis associats al contracte #".$contract['id']." del client ".$entity['name'];
	}
	if ($service['family']==1||($service['family']==2&&($service['subfamily']!=3&&$service['subfamily']!=4))) {
		//baixa de domini o cloud hosting normal, no cal crear tasca
	} else {
	$insert="insert into kms_planner_tasks (status,priority,creation_date,category,assigned,description,sr_client,start_date,final_date) VALUES ('pendent','1','{$now}','Sistemes','3','".$body."','{$contract['sr_client']}','{$now}','{$now}')";
	$result2=mysqli_query($link,$insert);  
        if (!$result2) die(mysqli_error($result2).$insert);
	}

	// NOTIFICACIO
	if ($service['family']==1) {
		$subject = "[KMS ISP] Executada baixa automatica de domini ".$contract['domain']; 
		$body = "Contracte #:".$contract['id']."\n\nIntergrid KMS";
	} else if ($service['family']==2&&($service['subfamily']==1||$service['subfamily']==10)) {
		$subject = "[KMS ISP] Executada baixa automatica de cloud hosting ".$contract['domain']." (".$contract['description'].")";
		$body = "Contracte #:".$contract['id']."\n\nIntergrid KMS";
        } else if ($service['family']==2&&($service['subfamily']==3||$service['subfamily']==4)) {
                $subject = "[KMS ISP] Executada baixa automatica de hosting dedicat "." (".$contract['description'].")";
                $body = "Contracte #:".$contract['id']."\n\nSi us plau doneu de baixa el servidor corresponent.\n\nIntergrid KMS";
	} else {
		$subject = "[KMS ISP] Notificacio de baixa automatica d'altres serveis "." (".$contract['description'].")";
		$body = "Contracte #:".$contract['id']."\n\nIntergrid KMS";
	}
	$email = new Email("kms@intergrid.cat", "sistemes@intergrid.cat", $subject, $body, 0);
	$goodemail = $email->send();
	if (!$goodemail) echo "[auto_cancellations] Email notification failed";
	$n++;
}


if ($n==0) echo "nothing to do.\n\n"; else echo $n." contracts cancelled.\n\n";
?>
