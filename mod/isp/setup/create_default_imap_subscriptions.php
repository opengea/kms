<?

$e=$argv[1];
$n=substr($e,0,strpos($e,"@"));
$d=substr($e,strpos($e,"@")+1);

$fp=fopen ("/var/qmail/mailnames/{$d}/{$n}/Maildir/subscriptions","w");
$txt="Sent\nDrafts\nTrash\nJunk";
fwrite($fp, $txt);
fclose($fp);
mkdir("/var/qmail/mailnames/{$d}/{$n}/Maildir/.Sent");
mkdir("/var/qmail/mailnames/{$d}/{$n}/Maildir/.Trash");
mkdir("/var/qmail/mailnames/{$d}/{$n}/Maildir/.Junk");
mkdir("/var/qmail/mailnames/{$d}/{$n}/Maildir/.Drafts");
chown("/var/qmail/mailnames/{$d}/{$n}/Maildir/subscriptions",110);
chgrp("/var/qmail/mailnames/{$d}/{$n}/Maildir/subscriptions",31);
chown("/var/qmail/mailnames/{$d}/{$n}/Maildir/.Sent",110);
chgrp("/var/qmail/mailnames/{$d}/{$n}/Maildir/.Sent",31);
chown("/var/qmail/mailnames/{$d}/{$n}/Maildir/.Trash",110);
chgrp("/var/qmail/mailnames/{$d}/{$n}/Maildir/.Trash",31);
chown("/var/qmail/mailnames/{$d}/{$n}/Maildir/.Drafts",110);
chgrp("/var/qmail/mailnames/{$d}/{$n}/Maildir/.Drafts",31);
chown("/var/qmail/mailnames/{$d}/{$n}/Maildir/.Junk",110);
chgrp("/var/qmail/mailnames/{$d}/{$n}/Maildir/.Junk",31);
?>
