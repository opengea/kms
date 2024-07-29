<?php
$ftp=$this->dbi->get_record("select * from kms_isp_ftps where vhost_id=".$_GET['xid'],$dblink_cp);
$vhost=$this->dbi->get_record("select * from kms_isp_hostings_vhosts where id=".$ftp['vhost_id'],$dblink_cp);
$server=$this->dbi->get_record("select * from kms_isp_servers where id=".$vhost['webserver_id'],$dblink_cp);

$sel="select * from kms_isp_ftps where vhost_id=".$_GET['xid'];
$res=mysql_query($sel);

$command = "ssh -i /root/.ssh/id_rsa root@".$server['hostname']." 'chmod root:root ".$ftp['home']."'";
$this->ssh_exec("localhost",$command,"JADF7320cSJdcj3750492x42dj244");

while ($ftp=mysql_fetch_assoc($res)) {

	echo _KMS_ISP_HOSTINGS_RESTORING_PERM." ".$ftp['home']."<br>";
        ob_flush();
        flush();

	$command = "ssh -i /root/.ssh/id_rsa root@".$server['hostname']." 'chown -R ".$ftp['login'].":kms ".$ftp['home']."/*'";
	$this->ssh_exec("localhost",$command,"JADF7320cSJdcj3750492x42dj244");
	$command = "ssh -i /root/.ssh/id_rsa root@".$server['hostname']." 'find ".$ftp['home']." -type f -exec chmod 640 {} \; '";
	$this->ssh_exec("localhost",$command,"JADF7320cSJdcj3750492x42dj244");
	$command = "ssh -i /root/.ssh/id_rsa root@".$server['hostname']." 'find ".$ftp['home']." -type d -exec chmod 750 {} \; '";
	$this->ssh_exec("localhost",$command,"JADF7320cSJdcj3750492x42dj244");
        $command = "ssh -i /root/.ssh/id_rsa root@".$server['hostname']." 'find ".$ftp['home']." -name wp-content -type d -exec chmod 775 {} \; '";
	$this->ssh_exec("localhost",$command,"JADF7320cSJdcj3750492x42dj244");
	$command = "ssh -i /root/.ssh/id_rsa root@".$server['hostname']." 'chown root:root ".$ftp['home']."/conf -R'";
	$this->ssh_exec("localhost",$command,"JADF7320cSJdcj3750492x42dj244");
	$command = "ssh -i /root/.ssh/id_rsa root@".$server['hostname']." 'chown root:root ".$ftp['home']." -R'";
        $this->ssh_exec("localhost",$command,"JADF7320cSJdcj3750492x42dj244");

}
echo "<br>";
echo "<b>"._KMS_ISP_HOSTINGS_RESTORE_PERM_OK."</b>";

?>
<br>
<br>
<a href="https://control.intergridnetwork.net/?app=cp&from=isp_hostings_vhosts&mod=isp_hostings_vhosts_adv&id=<?=$_GET['xid']?>&xid=<?=$_GET['xid']?>">< <?=_KMS_GL_BACK_BUT?></a>
