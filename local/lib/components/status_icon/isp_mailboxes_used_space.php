<?

        $sel = "select count(*) from kms_isp_mailboxes where vhost_id=".$_GET['xid'];
        $res=mysqli_query($this->dm->dblinks['client'],$sel);
        $num_mailboxes=mysqli_fetch_array($res);
	$sel = "select * from kms_isp_hostings_vhosts where id=".$_GET['xid'];
	$res=mysqli_query($this->dm->dblinks['client'],$sel);
	$vhost=mysqli_fetch_array($res);
        $mailbox_quota=($vhost['max_space']-$vhost['total_used_space'])/$num_mailboxes[0];


$t=0;
	$sel = "SELECT * from kms_isp_mailboxes where id=".$id;
        $res=mysqli_query($this->dm->dblinks['client'],$sel);
        $mailbox=mysqli_fetch_array($res);
	if ($mailbox['used_space']=="") $mailbox['used_space']=0;
//	$mailbox_quota=5368709120; // 5G


	// espai
	if ($mailbox['used_space']>=$mailbox_quota) $space_color="red"; else $space_color="green";
	$space_pc = round(($mailbox['used_space']*100)/$mailbox_quota);

	$out.="<div class='limits'><div class='$space_color' title='".bytes($mailbox['used_space'])."/".bytes($mailbox_quota)."'><div class='info'>{$space_pc}%</div><div class='progress_bar' id='sbar_{$id}'></div>{$note1}</div></div>";

	$out.="<script>$(\"#sbar_$id\").progressbar({ value: $space_pc });</script>";
	$label="x";	
	$action="manage";
	$title="L&iacute;mits de b&uacute;stia";


//       $out="<div style='float:left'><a href=\"?action=$action\" title=\"".$title."\"><img src=\"/kms/css/aqua/img/small/$icon\"></a></div><div style='float:left;padding-left:5px;padding-top:2px;'>$label</div>";
		
?>
