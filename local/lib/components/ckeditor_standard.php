<?php
// intergridKMS - data browser / editor
/**
 * A rich-text html editor component.  Useful for textarea fields.
 */
class ckeditor_standard {

    function ckeditor_standard($field,$params,&$dm) {
        $this->field = $field;
        $this->params = $params; // not used
        $this->dm =& $dm;
    }

    function input_filter($value) {
/*        $value = str_ireplace("'", "\'", $value);
        $value = str_ireplace('"', '\"', $value);
        return stripslashes($value);*/
	return $value;
    }

    function output_filter($value) {
        return $value;
    }

    function display_component($value) {
	return "<textarea id=\"".$this->field."\" name=\"".$this->field."\" class=\"ckeditor\" rows=\"15\" cols=\"80\" style=\"width: 80%\">".$value."</textarea>";

    }


}

?>
