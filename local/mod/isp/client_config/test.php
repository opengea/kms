<?
$from="test@intergrid.cat";
$headers = "Date: ".date('r')."\nFrom: <".$from.">\nMIME-
Version: 1.0\nContent-type: text/html; charset=UTF-8\n";
$to="j.berenguer@intergrid.cat";
$subject="xtestx intergrid";
$body="test intergrid bloqueig";
$sent = mail($to,$subject,utf8_encode(html_entity_decode(htmlentities($body))),$headers);
echo $sent;
?>
