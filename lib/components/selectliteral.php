<?php
/**
 * required params:
 *
 * values (array) - array of options
 */


class selectliteral {

    function selectliteral($field,$params,&$dm) {
        $this->field = $field;
        $this->values = $params;
        $this->dm =& $dm;
    }

    function output_filter($data) {
        return $this->values[$data];
    }

    function search_filter($search_value,$queryop,$search_options) {
        return $search_options;
    }

    function display_component($value,$add) {
	$this->dm->fieldChange_events[$this->field];
	if (is_array($this->dm->fieldChange_events[$this->field])) $add.=" onChange=\"javascript:".$this->dm->fieldChange_events[$this->field]['action']."\""; 
	$helptip=constant(strtoupper("_".$this->dm->table."_".$this->field."_HT"));
        $s = "<select title=\"{$helptip}\" id=\"{$this->field}\" name=\"{$this->field}\"{$add}>\n";
	$num=count($this->values);
	for ($i=0;$i<$num;$i++) {
		$_text=strip_tags($this->values[$i]);
            $sel = ($_text==$value ? "selected" : "");
            if (substr($_text,0,1)=="_") $_text=constant($_text); //"X".$lang[$_text];
	    if ($_text!="") $s .= "\t<option value=\"{$_text}\" {$sel}>{$_text}</option>\n";

	}
        $s .= "</select>\n";
	if ($this->dm->comments[$this->field]!="") $s .="<span id='comment_".$this->field."'>".$this->dm->comments[$this->field]."</span>\n";

	return $s;
    }

}

?>
