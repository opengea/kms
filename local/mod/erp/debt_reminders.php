#!/usr/bin/php -q
<?php
error_reporting(0);
include "/usr/local/kms/lib/dbi/db_localhost_connect.php";
include "/usr/local/kms/mod/erp/erp_options.php";
include_once "/usr/local/kms/lib/include/functions.php";
//$today=10;
$morosity=date('Y-m-d',strtotime("-2 months"));


$select = "SELECT distinct sr_client from kms_erp_invoices where (status='pendent' or status='impagada' or status='retornat')  and creation_date<'{$morosity}'";
$res=mysqli_query($dblink_local,$select);
while ($client=mysqli_fetch_assoc($res)) {

	$select = "SELECT name,email from kms_ent_contacts where id=".$client['sr_client'];
	$res2=mysqli_query($dblink_local,$select);
	$contact=mysqli_fetch_assoc($res2);
	
	$select = "SELECT * from kms_erp_invoices WHERE sr_client={$client['sr_client']} and (status='pendent' or status='impagada' or status='retornat') and creation_date<'{$morosity}'";
	$res_=mysqli_query($dblink_local,$select);
	$sum=0;
	$invoices="";
	$sent_to="";
	while ($invoice=mysqli_fetch_assoc($res_)) {
		$invoices.=$invoice['number'].",";
		$sum+=$invoice['total'];

                $select = "select sr_client,number,sent_date,sent_to from kms_erp_invoices_sending_log where number='{$invoice['number']}'";
		$res2=mysqli_query($dblink_local,$select);
	        $log=mysqli_fetch_assoc($res2);
		$sent_to=$log['sent_to'];
	}

	if ($sum>0) {
		echo $contact['name'].";".substr($invoices,0,strlen($invoices)-1).";".str_replace(".",",",$sum).";".$sent_to."\n";
	}

}
mysqli_close();
?>
