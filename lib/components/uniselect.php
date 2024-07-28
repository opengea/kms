<?php

/**
 * required params:
 *
 * fixed (bool) - Fixed select, cannot add to it.
 */


class uniselect {

    function uniselect($field,$fixed,&$dm) {
        $this->field = $field;
        $this->fixed = $fixed;
        $this->dm =& $dm;
    }

    function search_filter($search_value,$queryop,$search_options) {
        if ($queryop=="equal") {$queryop="=";$search_options['where']=$this->field." ".$queryop." '{$search_value}'";}
        else {$search_options['where']=$this->field." ".$queryop." '%{$search_value}%'";}
        return $search_options;
    }

    function output_filter($data) {
        return $data;
    }

    function display_component($value) {

	// lang de client
//	include '/usr/share/kms/lib/conf/getlang.php';

        $sql = "SELECT DISTINCT {$this->field} FROM {$this->dm->table} ";
        $sql .= "ORDER BY {$this->field}";
        $result = $this->dm->dbi->query($sql);
        $nrows  = $this->dm->dbi->num_rows($result);

//        print "<input type=\"hidden\" name=\"{$this->field}\" value=\"{$value}\" />\n";

        $s="<div class=\"uniselect\" style=\"float:left\"><div style=\"padding:0px;float:left\"><select name=\"{$this->field}_uniselect\" onchange=\"document.dm.{$this->field}.value = document.dm.{$this->field}_uniselect.options[document.dm.{$this->field}_uniselect.selectedIndex].value;document.dm.{$this->field}_open.value = document.dm.{$this->field}_uniselect.options[document.dm.{$this->field}_uniselect.selectedIndex].text;\">\n";

        for ($k=0;$k<$nrows;$k++) {
            $A  = $this->dm->dbi->fetch_array($result);
	    if ((($A[$this->field]==$value)&&($defvalue==''))) { $sel = "selected"; $value=$A[$this->field]; 
			if (substr($A[$this->field],0,1)=="_") $show_open=constant($A[$this->field]); else $show_open=$A[$this->field];
	    } else { $sel=""; }
	    if (substr($A[$this->field],0,1)=="_") $show=constant($A[$this->field]); else $show=$A[$this->field];
            $s.= "\t<option {$sel} value=\"{$A[$this->field]}\">{$show}</option>\n";
	    if ($first_value=="") $first_value=$A[$this->field];

        }
        $s.= "</select>";
	$s.= "</div><div style=\"float:left\">";
	if (!$this->fixed) $s.= "<input type=\"text\" name=\"{$this->field}_open\" value=\"{$show_open}\" onchange=\"document.dm.{$this->field}.value =document.dm.{$this->field}_open.value;\"/>";
	$s.= "</div></div>\n";
        if ($show_open!=""&&$value=="") $s.= "<input type=\"hidden\" name=\"{$this->field}\" value=\"{$first_value}\" />\n"; else $s.= "<input type=\"hidden\" name=\"{$this->field}\" value=\"{$value}\" />\n";

	if ($this->dm->comments[$this->field]!="") $s .="<div class='comment' style='float:left;color:#444;font-size: 13px;'><span id='comment_".$this->field."'>".$this->dm->comments[$this->field]."</span></div>\n";

	return $s;
    }

}

?>
