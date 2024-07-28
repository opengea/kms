<?
if ($this->dm->data[$id]['reply_status']=="1") $out="<img src='/kms/css/aqua/img/icons/mail_answered.png'>"; else $out="";
       // $out="<div class='spaceicon'><img src='/kms/css/aqua/img/icons/mail_answered.png'></div>";
$addr=$this->dm->data[$id][$this->field];
$addr_email=str_replace(">","",str_replace("<","",substr($addr,strpos($addr," <"))));
$addr=str_replace('"','',substr($addr,0,strpos($addr," <")));
$addr=str_replace("'","",$addr);
$title=" title=\"".$addr_email."\"";
if ($addr=="") { $addr=$addr_email;$title=""; } 

$out.="<a href='#'{$title}>$addr</a>";
if ($this->dm->data[$id]['status']=="0") $out="<b>{$out}</b>";
?>
