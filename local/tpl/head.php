<?
//include "/usr/local/kms/lib/constants.php";
//require "/usr/local/kms/lib/globals.php";

//SERVER_NAME 
/*
if (isset($_SERVER['SERVER_NAME'])) $server = $_SERVER['SERVER_NAME']; else $server = $_SERVER['HTTP_HOST'];
$first = strpos($server, '.');
$last = strrpos($server, '.');
if ($first!=$last) { 
        $current_subdomain = substr($server,0,$first);
        $current_domain = substr($server,$first+1,strlen($server));
} else {
        $current_domain = substr($_SERVER['SERVER_NAME'],0,strlen($server));
}
*/
include "/usr/local/kms/tpl/interfaces/headers/".$this->extranet['header_style'].".php";
?>

