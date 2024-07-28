<?php
// intergridKMS - htmledit field
class htmledit {

    var $allowed_tags = "<p><a><em><tt><span><center><b><strong><div><h1><h2><h3><h4><h5><h6><font><pre><br><hr><ul><ol><li><php>";

    function htmledit($field,$params,&$dm) {
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

$out="<button onclick=\"$('#codeview').toggle();$('#preview').html($('textarea#".$this->field."').val().replace('<style>','<style2 style=\'display:none\'>').replace('</style>','</style2>'));$('#preview').toggle();return false;\">Toggle preview</button>";
$out.="<div id='codeview'><textarea id=\"".$this->field."\" name=\"".$this->field."\" class=\"".$this->params['type']."\" rows=\"35\" cols=\"120\" style=\"width: 100%\">";
$out.=$value;
$out.="</textarea></div>";
$out.="<div id='preview' style='white-space: normal;overflow:scroll;border:1px solid #ccc;width:750px;height:450px;background-color:#fff;padding:10px;display:none'></div>";
return $out;
    }


}

?>
