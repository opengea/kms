<?php


$fp = fopen("tmp/emails_brute", "w");

$o = $_POST['out'];
foreach ($o as $i => $valor) {
    echo($matriz[$i]);
}

 fwrite($fp, $o);

 fclose($fp);

$salida = shell_exec('sort emailing/robomail/tmp/emails_brute | uniq > emailing/robomail/tmp/emails_ok');
echo "<pre>$salida</pre>";
?> 

