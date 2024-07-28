<?
$date=$this->dm->data[$id][$this->field];
$out=str_replace(date('d/m/y'),'',date('d/m/y H:i',strtotime($date)));
if ($this->dm->data[$id]['status']=="0") $out="<b>{$out}</b>";
?>
