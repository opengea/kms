<?
// adquirim domini
$extpos =  strpos($_SERVER['SERVER_NAME'], '.')+1;
$current_domain = substr($_SERVER['SERVER_NAME'],$extpos,strlen($_SERVER['SERVER_NAME']));

//print_r(http_parse_headers($headers));
//print_r(get_headers("http://es2.php.net/images/php.gif"));exit;

header ("Location: http://data.".$current_domain."/".$_GET['url']);

//flush;

?>
