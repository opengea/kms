<?php
// intergridKMS - data browser / editor
/**
 * A rich-text html editor component.  Useful for textarea fields.
 */
class wysiwyg {

    var $allowed_tags = "<a><p><em><tt><span><center><b><strong><div><h1><h2><h3><h4><h5><h6><font><pre><br><hr><ul><ol><li>";

    function wysiwyg($field,$params,&$dm) {
        $this->field = $field;
        $this->params = $params; // not used
        $this->dm =& $dm;
    }

    function input_filter($value) {
        $value = str_ireplace("'", "\'", $value);
        $value = str_ireplace('"', '\"', $value);
        return stripslashes($value);
    }

    function output_filter($value) {
        return strip_tags($value,$this->allowed_tags);
    }

    function display_component($value) {

	return "<textarea id=\"".$this->field."\" name=\"".$this->field."\" class=\"ckeditor\" rows=\"15\" cols=\"80\" style=\"width: 80%\">".$this->rtesafe($value)."</textarea>";

    }

    function rtesafe($strText) {
    	//returns safe code for preloading in the RTE
	$tmpString = trim($strText);

    	//convert all types of single quotes
    	$tmpString = str_replace(chr(145), chr(39), $tmpString);
    	$tmpString = str_replace(chr(146), chr(39), $tmpString);
    	$tmpString = str_replace("'", "&#39;", $tmpString);

	for ($c=0;$c<31;$c++) {
	$tmpString = str_replace($c,'',$tmpString);
	}
	
    	//convert all types of double quotes
    	$tmpString = str_replace(chr(147), chr(34), $tmpString);
    	$tmpString = str_replace(chr(148), chr(34), $tmpString);
      //$tmpString = str_replace("\"", "\"", $tmpString);
	
    	//replace carriage returns & line feeds
    	$tmpString = str_replace(chr(10), "", $tmpString);
    	$tmpString = str_replace(chr(13), "", $tmpString);

	$tmpString = str_replace('<strong>', "<b>", $tmpString);
	$tmpString = str_replace('</strong>', "</b>", $tmpString);
	
    	return $tmpString;
    }

}

?>
