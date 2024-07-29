<?php
/*
 * required params:
 *
 * type (string) - must be either MD5 or MCRYPT
 */
class money {

    function money($field,$opt,&$dm) {
        $this->field = $field;
        $this->opt = $opt;
        $this->dm =& $dm;
    }

    function output_filter($data,$id) {
	// databrowser
	   $add="";
	   if ($this->opt['show_euro']) $add=" &euro;";
	   if ($data < 0) {
	        return "<span style='color:#C00'>{$data}{$add}</span>";
	    } else {
	        return $data.$add;
	    }	
	}

    function input_filter($data) {
	// hi podem afegir el codi del contacte
            return "".$data;
    }

    function display_component($value) {
        // shows in dataEditor
	$human_value=$this->output_filter($value);
	$extra_attributes=$this->dm->dm->extraAttributes($this->field);
	return "<input type='text' id='{$this->field}'  name='{$this->field}' value='{$value}' {$extra_attributes}> $human_value";
    }

}

?>
