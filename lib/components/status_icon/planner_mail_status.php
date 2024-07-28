<?
$out="";
if ($this->dm->data[$id]['status']=="0") 
	$out.="<div class='spaceicon'><img src='/kms/css/aqua/img/icons/mail_new.png'></div>";
   else $out.="<div class='spaceicon'><img src='/kms/css/aqua/img/icons/mail_readbut.png'></div>";
//$out=$this->dm->data[$id]['reply_status'];
//$out=$this->dm->data[$id][$this->field];//$this->dm->_data['creation_date'];//$id;
/*                        if ($o->deleted)  $deleted=1; else $deleted=0;
                        if ($o->draft) $draft=1; else $draft=0;
                        if ($o->flagged) echo "<img src='/kms/css/aqua/img/icons/mail_flagged.png'>";
*/		
?>
