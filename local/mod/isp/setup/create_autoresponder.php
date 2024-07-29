<?
include "db_connect_plesk.php";
include "includes.php";

//$params = urldecode($argv[1]);

$e=$argv[1];
$n=substr($e,0,strpos($e,"@"));
$d=substr($e,strpos($e,"@")+1);

$query="SELECT subject,text,resp_on FROM mail_resp WHERE mn_id=(SELECT id FROM mail where mail_name='".$n."' and dom_id=(SELECT id FROM domains WHERE name='".$d."'))"; 
$result = mysqli_query($query);
$auto_r = mysqli_fetch_array($result);

if ($auto_r['resp_on']=="true") {

$auto="From: {$e}\nTo: THIS GETS REPLACED\nSubject: ".$auto_r['subject']."\n\n".$auto_r['text'];
$tmp="/tmp/autoresp_".$e.".txt";
$fp=fopen ($tmp,"w");
fwrite($fp, $auto);
fclose($fp);

//echo "scp {$tmp} root@mail1.intergridnetwork.net:/var/spool/autoresponse/responses/".$e;
exec_cmd("scp {$tmp} root@mail1.intergridnetwork.net:/var/spool/autoresponse/responses/".$e);
unlink ($tmp);

} else {
// delete autoresponder
exec_cmd("ssh root@mail1.intergridnetwork.net 'rm /var/spool/autoresponse/responses/".$e."'");

}

?>
