<?php
/*
 * password
 */

class password  {

        var $key                = '<W(574KX3-s-7EI-8dQq[XoHamFk,V';

    function password($field,$type,&$dm) {
        $this->field = $field;
        $this->dm =& $dm;
    }

        function encrypt($string) {

                $iv = mcrypt_create_iv(
                    mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC),
                    MCRYPT_DEV_URANDOM
                );

                $encrypted = base64_encode(
                    $iv .
                    mcrypt_encrypt(
                        MCRYPT_RIJNDAEL_128,
                                hash('sha256', $this->key, true),
                        $string,
                        MCRYPT_MODE_CBC,
                        $iv
                    )
                );

                return $encrypted;
        }

        function decrypt($encrypted) {
                $data = base64_decode($encrypted);
                $iv = substr($data, 0, mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC));

                $decrypted = rtrim(
                    mcrypt_decrypt(
                        MCRYPT_RIJNDAEL_128,
                        hash('sha256', $this->key, true),
                        substr($data, mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC)),
                        MCRYPT_MODE_CBC,
                        $iv
                            ),
                    "\0"
                );

                return $decrypted;
        }


    function output_filter($data) {
            return $this->decrypt($data);
    }

    function input_filter($data) {
            return $this->encrypt($data);
    }

    function display_component($value) {
	$out="";
            $value = $this->decrypt($value);
            print "<input type=\"text\" name=\"{$this->field}\" value=\"{$value}\" />\n";
		
            $out.= "<input type=\"password\" autocomplete=\"off\" name=\"{$this->field}\" id=\"{$this->field}\" value=\"{$value}\" onchange=\"validatePasswd($('input#{$this->field}').val(),'{$this->field}')\"/> <span id=\"showpasswd\" style=\"color:#555;font-style:italic\"><a href=\"#\" onclick=\"show_pw();\">"._KMS_GL_PASSWORD_SHOW."</a></span> <span id=\"hidepass\" style=\"color:#555;font-style:italic;display:none\"><a href=\"#\" onclick=\"hide_pw();\">"._KMS_GL_PASSWORD_HIDE."</a></span><br><span id=\"invalidpasswd\" style=\"color:#e00;font-weight:normal;display:none\"> "._KMS_GL_PASSWORD_INVALID."</span>\n";
	    $out.= "</div>";
		$out.= "</div></div><div class='row' id='tr_password_confirm'><div class='wrap'><div class='cell clear Label ROW1'><div class='middle'>";
//		$out.= "<div align=\"right\" class=\"Label ROW1\">"
		$out.= "<b>"._KMS_GL_PASSWORD_CONFIRM."</b></div></div><div class='cell ROW1' style='width:10px'><div class='middle'>:</div></div><div class='cell ROW0'><input type=\"password\" autocomplete=\"off\" name=\"{$this->field}_check\"  id=\"{$this->field}_check\" value=\"{$value}\" onchange=\"if ($('input#{$this->field}').val()!=$('input#{$this->field}_check').val()) $('#notmatch').show(); else $('#notmatch').hide();\"/><span id=\"notmatch\" style=\"font-weight:bold;color:#e00;display:none\"> "._KMS_GL_PASSWORD_NOTMATCH."</span>\n";
		$out.= "<script language=\"javascript\">
		function show_pw() { $('input#{$this->field}').clone().attr('type','text').insertAfter('input#{$this->field}').prev().remove(); $('#showpasswd').hide(); $('#hidepass').show(); $('input#{$this->field}').attr('onchange',\"validatePasswd(this.value,'{$this->field}')\");  } 
		function hide_pw() { $('input#{$this->field}').clone().attr('type','password').insertAfter('input#{$this->field}').prev().remove(); $('#showpasswd').show(); $('#hidepass').hide(); }; validatePasswd($('input#{$this->field}').val(),'{$this->field}'); $('input#{$this->field}').attr('onchange',\"validatePasswd(this.value,'{$this->field}')\");  </script>";
	return $out;
    }

    function hex2bin($data) {
        return pack("H" . strlen($data), $data);
    }

}

?>
