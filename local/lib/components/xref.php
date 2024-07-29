<?php

/**
 * required params:
 *
 * xkey - foreign key from related table
 * xfield - thw cross-referenced field name 
 * xtable - the cross-referenced table name
 * xvalue ??- the cross-referenced...?
 *
 */
class xref {

    var $xrefstack = array(); // this component is expensive, this is used for cacheing

    function xref($field,$params,&$dm) {
        $this->field = $field;
        $this->xkey = $params[0];
        $this->xfield = $params[1];
        $this->xtable = $params[2];
	$this->xvalue = $params[3];
        $this->dm =& $dm;
    }

    function output_filter($xkey) {
        if (!$this->xrefstack[$data] && !empty($xkey)) {
            $sql = "SELECT {$this->xfield} FROM {$this->xtable} WHERE {$this->xkey} = '{$xkey}'";
            $result = $this->dm->dbi->query($sql);
            $row  = $this->dm->dbi->fetch_array($result);
            $this->xrefstack[$xkey] = $row[$this->xfield];
        }
        return $this->xrefstack[$xkey];
    }

    function search_filter($query) {
        if (!$this->xrefstack[$data] && !empty($query)) {
            $sql = "SELECT {$this->xkey},{$this->xfield} FROM {$this->xtable} WHERE {$this->xfield} = '{$query}'";
            $result = $this->dm->dbi->query($sql);  
            $row = $this->dm->dbi->fetch_array($result);
            $this->xrefstack[$query] = $row[$this->xkey];
        }
        return $this->xrefstack[$query];
    }

    function display_component($value,$add) {
/*        $sql = "SELECT DISTINCT `{$this->xkey}`, `{$this->xfield}` ";
        $sql .= "FROM `{$this->xtable}` ";
        $sql .= "ORDER BY `{$this->xfield}`";
        $result = $this->dm->dbi->query($sql);
        $nrows	= $this->dm->dbi->num_rows($result);
echo $select;
        $out= "<select name=\"{$this->field}\">\n";
        for ($k=0;$k<$nrows;$k++) {
            $A  = $this->dm->dbi->fetch_array($result);
            $sel = ($A[$this->xkey] == $value ? "selected" : "");
            $out.= "\t<option {$sel} value=\"{$A[$this->xkey]}\">{$A[$this->xfield]}</option>\n";
        }
        $out.= "</select>\n";
*/
	//combo aixo es el que fa multixref? 
	$sql = "SELECT `{$this->xkey}`, `{$this->xfield}` FROM `{$this->xtable}` WHERE `{$this->xkey}`=' $value'";
        $result = $this->dm->dbi->query($sql);
	$user  = $this->dm->dbi->fetch_array($result);
	$out= "<select name=\"{$this->field}\">\n";
	$out.= "\t<option {$sel} value=\"{$A[$this->xkey]}\" selected>{$user[$this->xfield]}</option>\n";
	$out.= "</select>\n";
	return $out;

    }

    function input_filter($data) {
	//saves data to cross table!
    }
}

?>
