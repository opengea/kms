<?

$t="Laura.san.miguel@disney.com".chr(255);
$t=trim($t, "\x00..\x2F");
$t=trim($t, "\x3A..\x3F");
$t=trim($t, "\x5B..\x60");
$t=trim($t, "\x7B..\xFF");


?>
