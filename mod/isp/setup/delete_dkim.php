#!/bin/php
<?php
error_reporting(E_ALL);
$domain=$argv[1];
$host=$argv[2];
if ($host=="") $host="mx3.intergridnetwork.net";
if ($domain=="") die('Missing domain name\nUsage: delete_dkim.php domain mailserver');
$url="https://".$host.":7475/api/v1/email/dkim/remove/".$domain;
$arrContextOptions=array("ssl"=>array("verify_peer"=>false,"verify_peer_name"=>false));
$result = file_get_contents($url,false,stream_context_create($arrContextOptions));
if ($result) echo $result."\n";
$json=json_decode($result);

print_r($json,true);
?>
