<?php

date_default_timezone_set('Europe/Brussels');
include "../config/setup.php";
include "../config/scart.php";

//Open log
define("LOG_FILE", "../logs/scart.log");
$fp_log = fopen(LOG_FILE,"a");
fwrite($fp_log,"[".date('Y-m-d H:i')."] ajax call to scart_item_update !\n");

include "dbconnect.php";

//get value
$sel="select * from kms_cat_sales where id=".$_POST['item_id'];
$res=mysqli_query($dblink,$sel);
$item=mysqli_fetch_assoc($res);

$subtotal=$item['price']*$_POST['quantity'];

//update line
$update="UPDATE kms_cat_sales set quantity='".$_POST['quantity']."',subtotal='".$subtotal."' where id=".$_POST['item_id'];
$res=mysqli_query($dblink,$update);
fwrite($fp_log,"[".date('Y-m-d H:i')."] ".$update."\n");

//update order
$sel="select * from kms_cat_sales where operation=".$_POST['order_id'];
$res=mysqli_query($dblink,$sel);
$base=$total=$iva=0;
while ($row=mysqli_fetch_assoc($res)) {
	$base+=$row['subtotal'];	
}
$iva=round((($base*$scart['iva_pc'])/100)*100)/100;
$total=round(($base+$iva)*100)/100;
$update="UPDATE kms_cat_comandes set base='{$base}',iva='{$iva}',total='{$total}' where id=".$_POST['order_id'];
$res=mysqli_query($dblink,$update);
fwrite($fp_log,"[".date('Y-m-d H:i')."] ".$update."\n");

fclose($fp_log);
?>
