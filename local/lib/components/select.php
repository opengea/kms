<?php
/**
 * required params:
 *
 * values (array) - array of options
 */


class select {

    function select($field,$params,&$dm) {
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
        foreach ($this->values as $_value=>$_text) {
            $sel = ($_value==$value ? "selected" : "");
//	    include_once("/usr/share/kms/lib/conf/getlang.php");
 	    if (substr($_text,0,1)=="_") $_text=constant($_text); //"X".$lang[$_text];
            $s .= "\t<option value=\"{$_value}\" {$sel}>{$_text}</option>\n";
        }
        $s .= "</select>\n";
	if ($this->dm->comments[$this->field]!="") $s .="<span id='comment_".$this->field."'>".$this->dm->comments[$this->field]."</span>\n";

	return $s;
    }

}

?>
