<?php
/*
 * required params:
 *
 * values (array) - array of options
 */
class checklist {

    function checklist($field,$params,&$dm) {
        $this->field = $field;
        $this->values = $params;
        $this->dm =& $dm;
    }

    function output_filter($data,$id) {
        if ($data=='1') return "<img src=\"/kms/css/aqua/img/small/check2.gif\">"; 
	else if ($data=='0') return "<img src=\"/kms/css/aqua/img/small/unchecked.gif\">";
	else return "<img src=\"/kms/css/aqua/img/small/unchecked.gif\">";
/*
        $_arr = explode($this->dm->delimiter,$data);
        $tmp = array();
        foreach ($_arr as $key=>$value) {
            $tmp[] = $this->values[$value];
        }
        return @join(", ",$tmp);
*/
    }

    function input_filter($data) {
	return $data;
//      $_arr = @array_values($data);
        //return @join($this->dm->delimiter,$_arr);
    }

    function display_component($value) {
        $i=0;
	$s="<div class='checkbox'>";
        foreach ($this->values as $_value=>$_text) {
            $i++;
            $_arr = explode($this->dm->delimiter,$_value);
            //$chk = in_array($value,$_arr) ? "checked" : "";
	    //if ($chk = in_array($value,$_arr)) { $chk="checked";$_value="1"; } else { $chk="";$_value="0"; }	
	     if ($value=="1") {$_value="1";$chk="checked"; } else { $_value="0"; $chk="";}
  	    if (is_array($this->dm->fieldChange_events[$this->field])) $onChange=$this->dm->fieldChange_events[$this->field]['action']."\""; else $onChange="";
	   $onChange=" onchange=\"if (this.checked) \$('input#{$this->field}').attr('value','1'); else \$('input#{$this->field}').attr('value','0');{$onChange}\"";
//            print "\n<input id=\"{$this->field}_{$i}\" type=\"checkbox\" name=\"{$this->field}[]\" value=\"{$_value}\" {$chk}{$onChange}> ";
	    $s.= "\n<input id=\"{$this->field}_{$i}\" type=\"checkbox\" value=\"{$_value}\" {$chk}{$onChange}> ";
	    $s.="\n<input id=\"{$this->field}\" name=\"{$this->field}\" type=\"hidden\" value=\"{$_value}\">";
            $s.= "<label for=\"{$this->field}_{$i}\">{$_text}</label>";
        }
	if ($this->dm->comments[$this->field]!="") $s .="<span id='comment_".$this->field."'>".$this->dm->comments[$this->field]."</span>\n";
	$s.="</div>";
	return $s;
    }

}

?>
