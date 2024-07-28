<?php
/*
 * required params:
 *
 * type (string) - must be either MD5 or MCRYPT
 */
class bytes {

    function bytes($field,$type="L",&$dm) {
        $this->field = $field;
        $this->type = strtoupper($type);
        $this->dm =& $dm;
    }

    function output_filter($data,$id) {
	// databrowser
	    if ($data < 1024) {
	        return $data .' B';
	    } elseif ($data < 1048576) {
	        return round($data / 1024, 2) .' KB';
	    } elseif ($data < 1073741824) {
	        return round($data / 1048576, 2) . ' MB';
	    } elseif ($data < 1099511627776) {
	        return round($data / 1073741824, 2) . ' GB';
	    } elseif ($data < 1125899906842624) {
	        return round($data / 1099511627776, 2) .' TB';
	    } elseif ($data < 1152921504606846976) {
	        return round($data / 1125899906842624, 2) .' PB';
	    } elseif ($data < 1180591620717411303424) {
	        return round($data / 1152921504606846976, 2) .' EB';
	    } elseif ($data < 1208925819614629174706176) {
	        return round($data / 1180591620717411303424, 2) .' ZB';
	    } else {
	        return round($data / 1208925819614629174706176, 2) .' YB';
	    }	
	}

    function input_filter($data) {
	// hi podem afegir el codi del contacte
            return "".$data;
    }

    function display_component($value) {
        // shows in dataEditor
	$human_value=$this->output_filter($value);
	return "<input type='text' name='{$this->field}' value='{$value}'> $human_value";
	

    }

}

?>
