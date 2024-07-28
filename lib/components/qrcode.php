<?php
/*
 * required params:
 *
 * type (string) - must be either MD5 or MCRYPT
 */
class qrcode {

    function qrcode($field,$type="L",&$dm) {
        $this->field = $field;
        $this->type = strtoupper($type);
        $this->dm =& $dm;
    }

    function output_filter($data,$id) {
	// databrowser
		$size="30x30";
            return "<div style='float:left'><div style='text-align:center'><img src=\"http://chart.apis.google.com/chart?chs=$size&cht=qr&chl=$data\"></div><div style='text-align:center;font-size:9px;'>$data</div></div>";
    }

    function input_filter($data) {
	// hi podem afegir el codi del contacte
            return "".$data;
    }

    function display_component($value) {
        // shows in dataEditor
	$size="100x100";
	$out="";
	if ($value!="") {
        if ($this->type == "L") {
		$out.="$data<img src=\"http://chart.apis.google.com/chart?chs=$size&cht=qr&chld=L&chl=$data\">";
        } else if ($this->type == "M") {
		$out.= "<img src=\"http://chart.apis.google.com/chart?chs=$size&cht=qr&chld=M&chl=$data\">";
	}else if ($this->type == "Q") {
                $out.="<img src=\"http://chart.apis.google.com/chart?chs=$size&cht=qr&chld=Q&chl=$data\">";
        }else if ($this->type == "H") {
                $out.="<img src=\"http://chart.apis.google.com/chart?chs=$size&cht=qr&chld=H&chl=$data\">";
        }else { 
		$out.="$data<img src=\"http://chart.apis.google.com/chart?chs=$size&cht=qr&chl=$data\">";
	}
	}
	$out.="<br><input style='text' name='{$this->field}' value='{$value}'></input>";
	return $out;
	

    }

}

?>
