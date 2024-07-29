<?php
// intergridKMS - data browser / editor
/**
 * A rich-text html editor component.  Useful for textarea fields.
 */
class json {

    function json($field,$params,&$dm) {
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
        return $value;
    }

    function display_component($value) {

	$out="  <link href=\"/kms/lib/node_modules/jsoneditor/dist/jsoneditor.css\" rel=\"stylesheet\" type=\"text/css\">
  <script src=\"/kms/lib/node_modules/jsoneditor/dist/jsoneditor.js\"></script>

  <style type=\"text/css\">
    .jsoneditor {
      width: 500px;
      height: 500px;
      border:0px !important;
      padding:0px !important;
    }
    .jsoneditor-menu { border-bottom:0px !important; }
.jsoneditor-navigation-bar {    width: 99% !important;}
    #jsoneditor_".$this->field." {
      border: thin solid #ccc !important;
    }
.jsoneditor-search input { margin:0px !important; }
	.jsoneditor-menu { background-color:#6c7a82}
  </style>
<div id=\"jsoneditor_".$this->field."\" class=\"jsoneditor\"></div>
<textarea id=\"".$this->field."\" name=\"".$this->field."\" style=\"display:none\">".$value."</textarea>
<script>
  const container = document.getElementById('jsoneditor_".$this->field."')
  const options = {
	onChange: function() {
   		const json = jsoneditor_".$this->field.".get();
  		$('#".$this->field."').val(JSON.stringify(json, null, 2));
	}
  }
  const jsoneditor_".$this->field." = new JSONEditor(container, options)
  const json = ".$value."
  jsoneditor_".$this->field.".set(json)
</script>
";

return $out;
    }
}
?>
