<?$out="<input id=\"disable{$id}\" type=\"checkbox\" value=\"".$data."\" ";
if ($data=="1") $out.=" checked=checked ";+
$out.="onchange=\"if (this.checked) val=1; else val=0; $(this).attr('value',val);  updateObject({$id},'".$_GET['app']."','".$_GET['mod']."','disable{$id}','disable','".$_GET['view']."');d=$('#disable{$id}').closest('tr'); d.attr('onmouseover','');d.attr('onmouseout',''); \">";return $out; ?>
