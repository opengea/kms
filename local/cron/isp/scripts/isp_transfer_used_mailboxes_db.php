<?php
#script desestimat perque la transferencia d'enviats i rebuts s'hauria de sumar i apart
#amb pflogsumm apareixen mesclats dominis externs i es una mica embolicat

#soc partidari de no cobrar la transferncia del email
#i en tot cas en el futur, si tot el email funciona via web, comptar la transferencia 
#que quedi comptabilitzada en els logs d'apache del webmail
die();
#transfer used back processing
include "setup.php";

echo "...cp ";
update($dblink_cp);
echo "100%....tartarus";
update($dblink_erp);
echo "100%";

function update($dblink) {
	$file=fopen("/var/log/kms/cron/isp_transfer_used.log","r");
	$current_vhost="";
	$running=false;
	while(!feof($file))
	  {
	        $s=fgets($file);
		if (substr($s,0,37)=="Host/Domain Summary: Message Delivery") {
			$s=fgets($file); //skip table header
			$s=fgets($file); //skip lines
			$s=fgets($file); //get first record
			$running=true;
		}
		if ($running&&strlen($s)==1) {
			$running=false; 
		}
		if ($running) {

		$part=substr($s,0,strpos($s,'k'));
		$first=strrpos($part,' ');
		$bytes=substr($part,$first+1,strlen($part)-1);
		$part=substr($s,strrpos($s,' ')+1);
		$vhost=substr($part,0,strlen($part)-1);

	        if ($vhost!=""&&$bytes!="") {
	        	$update = "UPDATE kms_isp_hostings_vhosts_log SET used_transfer_mailboxes='{$bytes}' WHERE domain='$vhost' and date='".date('Y-m-d', strtotime("-1 day"))."'";
#		        $result=mysqli_query($dblink,$update);
#		        if (!$result) die('error '.$update);
			echo $update."\n";
	        }

		}

	}
	fclose($file);
}

?>

