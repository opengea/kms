<?php
/*
 * required params:
 *
 * type (string) - must be either MD5 or MCRYPT
 */
class random {

    function random($field,$type="L",&$dm) {
        $this->field = $field;
        $this->type = strtoupper($type);
        $this->dm =& $dm;
    }

    function output_filter($data) {
	// databrowser
		 if ($data=="") return $this->createRandomPassword(7); else return $data;
		return $data;
	}

    function input_filter($data) {
	// hi podem afegir el codi del contacte
		if ($data=="") return $this->createRandomPassword(7); else return $data;
    }

    function display_component($value) {
        // shows in dataEditor
	if ($value=="") { $value=$this->createRandomPassword(7); $gen="<span style='color:#999;font-style:italic'> -> password generated automaticaly</span>"; }
	$out= "<input style=\"background-color:#fee\" type=\"text\" name='{$this->field}' value='{$value}'></input>".$gen;
	return $out;

    }

    function createRandomPassword($n) {
            $chars = "abcdefghijkmnopqrstuvwxyz023456789ABCDEFGHJKLMNPQRSTUVWXYZ";
            srand((double)microtime()*1000000);
            $i = 0;
            $pass = '' ;
            while ($i <= $n) {
                $num = rand() % strlen($chars);
                $tmp = substr($chars, $num, 1);
                $pass = $pass . $tmp;
                $i++;
            }
            return $pass;
   }

}

?>
