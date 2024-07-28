<?
// ---- http headers ----
//define('MP_BOUNDARY', '--'.sha1(microtime(true)));
//header('Content-Type: multipart/x-mixed-replace; boundary="'.MP_BOUNDARY.'"');
//header('Content-Type: multipart/x-mixed-replace; boundary="'.MP_BOUNDARY.'"');
//flush();
header('Content-Type: text/html; charset=utf-8');

ini_set('default_charset','UTF-8');
ini_set('session.name', 'kms_sessid');
ini_set('session.use_cookies', 1);
ini_set('session.gc_maxlifetime', 21600);
ini_set('session.gc_divisor', 500);
// increase maximum execution time for php scripts
// (does not work in safe mode)
//if (!ini_get('safe_mode')) @set_time_limit(120);
// use gzip compression if supported
        if (function_exists('ob_gzhandler') && ini_get('zlib.output_compression'))
        if (extension_loaded('zlib')) {
                        $do_gzip_compress = TRUE;
                        ob_start();
                        ob_implicit_flush(0);
                        //header('Content-Encoding: gzip');
        }
//      ob_start('ob_gzhandler');
        else
        ob_start();

ini_set('register_globals',0);
?>
