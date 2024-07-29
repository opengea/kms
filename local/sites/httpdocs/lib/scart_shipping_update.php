<?php

date_default_timezone_set('Europe/Brussels');
include "../config/setup.php";
include "../config/scart.php";

//Open log
define("LOG_FILE", "../logs/scart.log");
$fp_log = fopen(LOG_FILE,"a");
fwrite($fp_log,"[".date('Y-m-d H:i')."] ajax call to scart_shipping_update !\n");

include "dbconnect.php";

$sel="select * from kms_cat_comandes where id=".$_POST['order_id'];
$res=mysqli_query($dblink,$sel);
$item=mysqli_fetch_assoc($res);
$total=$item['base']+$item['iva']+$_POST['shipping'];
$update="UPDATE kms_cat_comandes set shipping='{$_POST['shipping']}',total='{$total}' where id=".$_POST['order_id'];
$res=mysqli_query($dblink,$update);
fwrite($fp_log,"[".date('Y-m-d H:i')."] ".$update."\n");

fclose($fp_log);
?>
