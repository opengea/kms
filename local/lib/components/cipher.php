<?php
/*
 * required params:
 *
 * type (string) - must be either MD5 or MCRYPT
 */
class cipher {

    function cipher($field,$type,&$dm) {
        $this->field = $field;
        $this->type = strtoupper($type);
        $this->dm =& $dm;
    }

    function output_filter($data) {
        if ($this->type == "MCRYPT") {
            return $this->decrypt($data);
        } else if ($this->type=="MD5"||$this->type == "PLAIN"||$this->type=="PROTECTED") {
            return $data;
        }
    }

    function input_filter($data) {
        if ($this->type == "MCRYPT") { 
            return $this->encrypt($data);
        } elseif($this->type == "MD5") {
            return md5($data);
	} else if ($this->type == "PLAIN"||$this->type=="PROTECTED") {
		return $data;
        } else {
		return $data;
	}
    }

    function display_component($value) {
	$out="";
        if ($this->type == "MCRYPT") {
            $value = $this->decrypt($value);
            print "<input type=\"text\" name=\"{$this->field}\" value=\"{$value}\" />\n";
        }
        else if ($this->type == "MCRYPT"||$this->type == "PLAIN") {
		
            $out.= "<input type=\"password\" autocomplete=\"off\" name=\"{$this->field}\" id=\"{$this->field}\" value=\"{$value}\" onchange=\"validatePasswd($('input#{$this->field}').val(),'{$this->field}')\"/> <span id=\"showpasswd\" style=\"color:#555;font-style:italic\"><a href=\"#\" onclick=\"show_pw();\">"._KMS_GL_PASSWORD_SHOW."</a></span> <span id=\"hidepass\" style=\"color:#555;font-style:italic;display:none\"><a href=\"#\" onclick=\"hide_pw();\">"._KMS_GL_PASSWORD_HIDE."</a></span><br><span id=\"invalidpasswd\" style=\"color:#888;font-size:11px;font-weight:normal;display:none\"> "._KMS_GL_PASSWORD_INVALID."</span>\n";
	    $out.= "</div>";
		$out.= "</div></div><div class='row' id='tr_password_confirm'><div class='wrap'><div class='cell clear Label ROW1'><div class='middle'>";
//		$out.= "<div align=\"right\" class=\"Label ROW1\">"
		$out.= "<b>"._KMS_GL_PASSWORD_CONFIRM."</b></div></div><div class='cell ROW1' style='width:10px'><div class='middle'>:</div></div><div class='cell ROW0'><input type=\"password\" autocomplete=\"off\" name=\"{$this->field}_check\"  id=\"{$this->field}_check\" value=\"{$value}\" onchange=\"if ($('input#{$this->field}').val()!=$('input#{$this->field}_check').val()) $('#notmatch').show(); else $('#notmatch').hide();\"/><span id=\"notmatch\" style=\"font-weight:bold;color:#e00;display:none\"> "._KMS_GL_PASSWORD_NOTMATCH."</span>\n";
		$out.= "<script language=\"javascript\">
		function show_pw() { $('input#{$this->field}').clone().attr('type','text').insertAfter('input#{$this->field}').prev().remove(); $('#showpasswd').hide(); $('#hidepass').show(); $('input#{$this->field}').attr('onchange',\"validatePasswd(this.value,'{$this->field}')\");  } 
		function hide_pw() { $('input#{$this->field}').clone().attr('type','password').insertAfter('input#{$this->field}').prev().remove(); $('#showpasswd').show(); $('#hidepass').hide(); }; validatePasswd($('input#{$this->field}').val(),'{$this->field}'); $('input#{$this->field}').attr('onchange',\"validatePasswd(this.value,'{$this->field}')\");  </script>";
        } else if ($this->type=="PROTECTED") {
		$out.= "<input type=\"password\" autocomplete=\"off\" name=\"{$this->field}\" id=\"{$this->field}\" value=\"{$value}\" onchange=\"validatePasswd($('input#{$this->field}').val(),'{$this->field}')\"/> <span id=\"invalidpasswd\" style=\"color:#888;font-size:11px;font-weight:normal;display:none\">"._KMS_GL_PASSWORD_INVALID."</span>\n";
            	$out.= "</div><div align=\"right\" style=\"width:auto\" class=\"Label ROW1\"><div class=\"middle\" style='margin-top:5px'><b>"._KMS_GL_PASSWORD_CONFIRM."</b></div></div><div><div class=\"middle\" style='margin-top:5px'> : </div></div><div><input autocomplete=\"off\" type=\"password\" name=\"{$this->field}_check\"  id=\"{$this->field}_check\" value=\"{$value}\" onchange=\"if ($('input#{$this->field}').val()!=$('input#{$this->field}_check').val()) $('#notmatch').show(); else $('#notmatch').hide();\"/><span id=\"notmatch\" style=\"font-weight:bold;color:#e00;display:none\"> "._KMS_GL_PASSWORD_NOTMATCH."</span>\n";
	}
	return $out;
    }

    function encrypt($data) {
        if (!$td = @mcrypt_module_open(MCRYPT_TripleDES, "", MCRYPT_MODE_ECB, "")) {
            $this->dm->_error("MCrypt Error","TripleDES encryption not supported on this platform.");
        }
        $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size ($td), MCRYPT_RAND);
        $encdata = mcrypt_ecb(MCRYPT_TripleDES, $this->dm->table, $data, MCRYPT_ENCRYPT, $iv);
        $hextext=bin2hex($encdata);
        return $hextext;
    }

    function decrypt($data) {
        if (!$td = @mcrypt_module_open(MCRYPT_TripleDES, "", MCRYPT_MODE_ECB, "")) {
            $this->dm->_error("MCrypt Error","TripleDES encryption not supported on this platform.");
        }
        $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size ($td), MCRYPT_RAND);
        $dectext = mcrypt_ecb(MCRYPT_TripleDES, $this->dm->table, $this->hex2bin($data), MCRYPT_DECRYPT,$iv);
        return $dectext;
    }

    function hex2bin($data) {
        return pack("H" . strlen($data), $data);
    }

}

?>
