#!/usr/bin/php -q
<?php
error_reporting(0);
include "/usr/local/kms/lib/dbi/db_localhost_connect.php";
include "/usr/local/kms/mod/erp/erp_options.php";
include_once "/usr/local/kms/lib/include/functions.php";
//$today=10;

	$select = "SELECT name from kms_ent_contacts where id=729";
	$res2=mysqli_query($dblink_local,$select);
	$contact=mysqli_fetch_assoc($res2);
	
	$select = "SELECT * from kms_erp_invoices WHERE sr_client=729 and (status='pendent' or status='impagada')";
	$res_=mysqli_query($dblink_local,$select);
	$invoices="";
	$sent_to="";
	$concept="";
	while ($invoice=mysqli_fetch_assoc($res_)) {
		$invoices.=$invoice['number'].",";
		$sum+=$invoice['total'];

                $select = "select sr_client,number,sent_date,sent_to from kms_erp_invoices_sending_log where number='{$invoice['number']}'";
		$res2=mysqli_query($dblink_local,$select);
	        $log=mysqli_fetch_assoc($res2);
		$sent_to=$log['sent_to'];
		$concept.=str_replace(";"," ",$invoice['concept'])." ";


		echo $invoice['number'].";".$invoice['creation_date'].";".$invoice['concept'].";".str_replace(".",",",$invoice['total']).";".$sent_to."\n";
	}
mysqli_close();
?>
