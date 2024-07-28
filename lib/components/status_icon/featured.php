<?$out="<input id=\"featured{$id}\" type=\"checkbox\" value=\"".$data."\" ";
if ($data=="1") $out.=" checked=checked ";+
$out.="onchange=\"if (this.checked) val=1; else val=0; $(this).attr('value',val);  updateObject({$id},'".$_GET['app']."','".$_GET['mod']."','featured{$id}','featured','".$_GET['view']."');o=$('#featured{$id}').closest('tr'); o.attr('onmouseover','');o.attr('onmouseout',''); if (val) o.css('font-weight','normal'); else o.css('font-weight','bold');\">";return $out; ?>
