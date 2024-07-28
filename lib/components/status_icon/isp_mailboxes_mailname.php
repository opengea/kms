<?
        $sel = "SELECT * from kms_isp_mailboxes where id=".$id;
        $res=mysqli_query($this->dm->dblinks['client'],$sel);
        $mailbox=mysqli_fetch_array($res);
	$select ="select name from kms_isp_hostings_vhosts where id=".$mailbox['vhost_id'];
	$result=mysqli_query($this->dm->dblinks['client'],$select);
	$vhost=mysqli_fetch_array($result);

        $out=$mailbox['mailname']."@".$vhost['name'];
?>
