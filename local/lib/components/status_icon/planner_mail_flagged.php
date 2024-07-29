<?
$out="";
if ($this->dm->data[$id]['flagged']=="1")
        $out.="<div class='spaceicon' style='padding-left:10px'><img src='/kms/css/aqua/img/icons/mail_flagged.png'></div>";
   else $out.="<div class='spaceicon'></div>";
?>
