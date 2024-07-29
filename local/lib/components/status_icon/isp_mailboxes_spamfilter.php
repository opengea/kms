<?
        $sel = "SELECT * from kms_isp_mailboxes where id=".$id;
        $res=mysqli_query($this->dm->dblinks['client'],$sel);
        $mailbox=mysqli_fetch_array($res);

        if ($mailbox['postbox']) $icon="check2.gif"; else $icon="none.png";
	$action="/?app=".$_GET['app']."&mod=".$_GET['mod']."&from=".$_GET['from']."&xid=".$_GET['xid']."&_=e&id=$id";
        $out="<div style='float:left'><a href=\"$action\" title=\"".$title."\"><img src=\"/kms/css/aqua/img/small/$icon\"></a></div><div style='float:left;padding-left:5px;padding-top:2px;'>";
        if ($this->show_label) $out.=$label;
        $out.="</div>";
?>
