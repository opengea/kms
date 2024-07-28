<?php
/*
 * required params:
 *
 * type (string) - must be either MD5 or MCRYPT
 */
class domain_name {

    function domain_name($field,$type="L",&$dm) {
        $this->field = $field;
        $this->type = strtoupper($type);
        $this->dm =& $dm;
    }

    function output_filter($data) {
		return idn_to_utf8($data);
	}

    function input_filter($data) {
	// hi podem afegir el codi del contacte
            return "".idn_to_utf8($data);
    }

    function display_component($value) {
        // shows in dataEditor
	$human_value=$this->output_filter($value);
	echo "<input type='text' maxlength='{$this->dm->maxlengths[$this->field]}' pattern=\"[A-Za-z]{3}\" onchange=\"this.value=this.value.replace(/[^a-z_\d]/, '');\" name='{$this->field}' value='{$value}'> $human_value";
	

    }

}

?>
