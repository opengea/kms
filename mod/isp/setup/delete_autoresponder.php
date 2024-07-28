<?
include "db_connect_plesk.php";
include "includes.php";

//$params = urldecode($argv[1]);

$e=$argv[1];
exec_cmd("ssh root@mail1.intergridnetwork.net 'rm /var/spool/autoresponse/responses/{$e}'");
?>
