<?
$s="<div class=\"mod_header\"><div style=\"float:left\"><img src=\"/kms/css/aqua/img/apps/isp_mailboxes.png\"></div>";
$s.="<div style=\"float:left;padding-left:10px\"><h2>"._KMS_TY_ISP_MAILBOXES." "._KMS_GL_DEL_DOMINI." ".$vhost['name']."</h2></div></div>";
$params=array("title"=>_KMS_TY_ISP_MAILBOXES,"height"=>"60px","buttons"=>"","content"=>$s,"defaultMod"=>"","infotable"=>"","hide_table_title"=>true);
$this->setPanel($params);
?>
