#!/usr/bin/php -q
<?
//include "/usr/local/kms/lib/ssh2_exec.php";
//include '/usr/local/kms/lib/mail/email.class.php';

echo "creating new hostings_log entries for yesterday...\n";

include "/usr/local/kms/lib/dbi/db_master_connect.php";
include "/usr/local/kms/lib/dbi/db_localhost_connect.php";

$yesterday=date('Y-m-d',strtotime('-1 day'));
//for ($i=1;$i<=13;$i++) {
//$yesterday="2012-11-".$i;
$debug=false; //true;
$select="select * from kms_isp_hostings_vhosts WHERE status='active' ORDER BY hosting_id";
$result=mysql_query($select,$dblink_local);
//if (!$result) die(mysql_error($result).$select);
$n=0;
$sum=array();
$hosting_id=0;
$sum['used_vhosts']=$sum['used_mailboxes']=0;
while ($vhost=mysql_fetch_array($result)) {

	if ($vhost['hosting_id']!=$hosting_id) {
		if ($hosting_id!=0) {
		        $select3="select * from kms_isp_hostings where id=".$hosting_id;
			$result3=mysql_query($select3,$dblink_local);
			$hosting=mysql_fetch_array($result3);
		        $insert="INSERT INTO kms_isp_hostings_log (date,type,hosting_id,used_space,used_transfer,used_vhosts,used_mailboxes,max_space,max_transfer,max_vhosts,max_mailboxes) VALUES ('".$yesterday."','summary','{$hosting_id}','{$sum['used_space']}','{$sum['used_transfer']}','{$sum['used_vhosts']}','{$sum['used_mailboxes']}','{$hosting['max_space']}','{$hosting['max_transfer']}','{$hosting['max_vhosts']}','{$hosting['max_mailboxes']}')";
// 			echo $insert."\n";
			if (!$debug) $result3=mysql_query($insert,$dblink_local);// else echo $insert."\n";
			if (!$debug) $result3=mysql_query($insert,$dblink_cp);
		//	if (!$result3) die (mysql_error());
			$sum=array();
			$sum['used_space']=$sum['used_transfer']=$sum['used_vhosts']=$sum['used_mailboxes']=0;
		}
		$hosting_id=$vhost['hosting_id']; // next 
	}
//	if ($debug) echo "Preparant ".$vhost['name']."...\n";
	$select2="select * from kms_isp_hostings_vhosts_log WHERE domain='".$vhost['name']."' AND date='{$yesterday}'";
	$result2=mysql_query($select2,$dblink_local);
	$log=mysql_fetch_array($result2);
	$sum['used_space']+=$log['used_space_httpdocs']+$log['used_space_mailboxes']+$log['used_space_extranet']+$log['used_space_databases']+$log['used_space_subdomains']+$log['used_space_ftps']+$log['used_space_backups']+$log['used_space_logs'];
	$sum['used_transfer']+=$log['used_transfer_web']+$log['used_transfer_mailboxes']+$log['used_transfer_webmail'];
	$sum['used_vhosts']++;
	$select3="select count(*) from kms_isp_mailboxes where vhost_id=".$vhost['id'];
	$result3=mysql_query($select3,$dblink_local);
	$count=mysql_fetch_array($result3);
	$sum['used_mailboxes']+=$count[0];
	
}
//ultim registre
if ($hosting_id!=0) {
                        $select3="select * from kms_isp_hostings where id=".$hosting_id;
                        $result3=mysql_query($select3,$dblink_local);
                        $hosting=mysql_fetch_array($result3);
                        $insert="INSERT INTO kms_isp_hostings_log (date,type,hosting_id,used_space,used_transfer,used_vhosts,used_mailboxes,max_space,max_transfer,max_vhosts,max_mailboxes) VALUES ('".$yesterday."','summary','{$hosting_id}','{$sum['used_space']}','{$sum['used_transfer']}','{$sum['used_vhosts']}','{$sum['used_mailboxes']}','{$hosting['max_space']}','{$hosting['max_transfer']}','{$hosting['max_vhosts']}','{$hosting['max_mailboxes']}')";
                       // echo $insert."\n";
                        if (!$debug) $result3=mysql_query($insert,$dblink_local); else echo $insert."\n";
			if (!$debug) $result3=mysql_query($insert,$dblink_cp); else echo $insert."\n";
                //      if (!$result3) die (mysql_error());
                        $sum=array();
                        $sum['used_space']=$sum['used_transfer']=$sum['used_vhosts']=$sum['used_mailboxes']=0;
                }


//} //for 
echo "done.\n\n";
?>
