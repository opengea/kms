<?php
// intergridKMS - data browser / editor
/**
 * A rich-text html editor component.  Useful for textarea fields.
 */
class wysiwyg {

    var $allowed_tags = "<p><a><em><tt><span><center><b><strong><div><h1><h2><h3><h4><h5><h6><font><pre><br><hr><ul><ol><li><php>";

    function wysiwyg($field,$params,&$dm) {
        $this->field = $field;
        $this->params = $params; // not used
        $this->dm =& $dm;
    }

    function input_filter($value) {
        $value = str_ireplace("'", "\'", $value);
        $value = str_ireplace('"', '\"', $value);
//	$value=str_replace("<p>","",$value);
//	$value=str_replace("</p>","<br>",$value);

        return stripslashes($value);
    }

    function output_filter($value) {
//        $value=str_replace("<p>","",$value);
  //      $value=str_replace("</p>","<br>",$value);
        return strip_tags($value,$this->allowed_tags);
    }

    function display_component($value) {

if ($this->params['type']=="") $this->params['type']="full";
$out="<textarea id=\"".$this->field."\" name=\"".$this->field."\" class=\"rte_".$this->params['type']."\" rows=\"15\" cols=\"80\" style=\"width: 80%\">";
// =htmlentities(mb_convert_encoding($this->rtesafe($value), "HTML-ENTITIES", "UTF-8"));
// =htmlentities(utf8_decode($this->rtesafe($value)))
//=utf8_decode($this->rtesafe($value))
$out.=$value;
$out.="</textarea>";
//echo mb_detect_encoding($this->rtesafe($value));
return $out;
    }

    function rtesafe($strText) {
    	//returns safe code for preloading in the RTE
	$tmpString = trim($strText);

	
    	//replace carriage returns & line feeds
    	$tmpString = str_replace(chr(10), "", $tmpString);
    	$tmpString = str_replace(chr(13), "", $tmpString);
	
	$tmpString = str_replace('<strong><strong>','<strong>',$tmpString);
	$tmpString = str_replace('</strong></strong>','</strong>',$tmpString);

//      $tmpString=str_replace("<p>","",$tmpString);
//      $tmpString=str_replace("</p>","",$tmpString);
	$tmpString=trim($tmpString);
	
    	return $tmpString;
    }

}

?>
