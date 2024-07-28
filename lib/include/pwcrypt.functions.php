<?php
$key = '<W(574KX3-s-7EI-8dQq[XoHamFk,V';


function encrypt($string) {
	$key = '<W(574KX3-s-7EI-8dQq[XoHamFk,V';
        $iv = mcrypt_create_iv(
            mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC),
            MCRYPT_DEV_URANDOM
        );

        $encrypted = base64_encode(
            $iv .
            mcrypt_encrypt(
                MCRYPT_RIJNDAEL_128,
                        hash('sha256', $key, true),
                $string,
                MCRYPT_MODE_CBC,
                $iv
            )
        );

        return $encrypted;
}

function decrypt($encrypted) {
	$key = '<W(574KX3-s-7EI-8dQq[XoHamFk,V';
        $data = base64_decode($encrypted);
        $iv = substr($data, 0, mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC));

        $decrypted = rtrim(
            mcrypt_decrypt(
                MCRYPT_RIJNDAEL_128,
                hash('sha256', $key, true),
                substr($data, mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC)),
                MCRYPT_MODE_CBC,
                $iv
            ),
            "\0"
        );
        return $decrypted;
}

/*$_GET['action']="encrypt";
$_GET['s']="HecaBat44";

if ($_GET['action']=="encrypt") {
echo encrypt($_GET['s']);
} else if ($_GET['action']=="decrypt") {
echo decrypt($_GET['s']);
}

*/
