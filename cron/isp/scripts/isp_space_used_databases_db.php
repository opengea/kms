<?php
$file=fopen("/var/log/kms/cron/isp/isp_space_used_databases.log","r");

include "setup.php";

$used_space=array();

while(!feof($file))
  {
	$s=fgets($file);
	$s=str_replace("/var/lib/mysql/","",$s);
	$bytes = substr($s,0,strpos($s,"\t"));
	$db = substr($s,strpos($s,"\t"));
	$db = substr($db,1,strlen($db)-2);

	if (substr($db,0,5)!="mysql"&&$db!=""&&$db!="psa"&&(substr($db,0,10)!="ib_logfile")&&$db!="ibdata1"&&substr($db,strlen($db)-4)!=".err") {
//echo $db."\n";

	// localitzem el propietari de la base de dades i anem posant en array.. 
	$select="select vhost_id from kms_isp_databases where name='$db'";
	$res=mysqli_query($dblink_cp,$select);
	$database=mysqli_fetch_array($res);
	if ($database['vhost_id']=="") echo 'vhost_id not found: '.$select."\n";
	$select="select name from kms_isp_hostings_vhosts where id='".$database['vhost_id']."'";
	$res=mysqli_query($dblink_cp,$select);
        $vhost=mysqli_fetch_array($res);
	$used_space[$vhost['name']]+=$bytes;

	}
  }
fclose($file);
foreach ($used_space as $vhost=>$bytes) {
	if ($vhost!="") {
	$update = "UPDATE kms_isp_hostings_vhosts_log SET used_space_databases='{$bytes}' WHERE domain='$vhost' and date='".date('Y-m-d')."'";
	$result=mysqli_query($dblink_cp,$update);
	if (!$result) die('error updating database '.$update);
	}
}
echo "...CP 100%...tartarus \n";
// replicate to tartarus
foreach ($used_space as $vhost=>$bytes) {
	if ($vhost!="") {
	$update = "UPDATE kms_isp_hostings_vhosts_log SET used_space_databases='{$bytes}' WHERE domain='$vhost' and date='".date('Y-m-d')."'";
        $result=mysqli_query($dblink_erp,$update);
        if (!$result) die('error updating database '.$update);
	}
}
echo "100%\n";



?>
