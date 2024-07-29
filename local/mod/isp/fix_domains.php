#!/usr/bin/php -q
<?
error_reporting(0);
include "/usr/local/kms/lib/ssh2_exec.php";
include '/usr/local/kms/lib/mail/email.class.php';

include "/usr/local/kms/lib/dbi/db_localhost_connect.php";
$select="select * from kms_isp_domains";
$result=mysqli_query($link,$select);
if (!$result) die('error selecting : '.mysqli_error($result).$select);
$now=date('Y-m-d');
$n=0;
while ($dom=mysqli_fetch_array($result)) {
	
	$sel="select * from kms_erp_contracts where id=".$dom['sr_contract'];$res=mysqli_query($link,$sel);$contract=mysqli_fetch_array($res);

	$sel="select * from kms_ecom_services where id=".$contract['sr_ecom_service'];$res=mysqli_query($link,$sel);$service=mysqli_fetch_array($res);


	if ($service['family']!="1") { // no es domini! 
		 echo "\n".$dom['name']." contracte:".$dom['sr_contract']." -> ";
		$sel  ="select * from kms_erp_contracts where description='".$dom['name']."' and sr_ecom_service in (select id from kms_ecom_services where family=1)";	
		$res=mysqli_query($link,$sel);
		$contracte_ok = mysqli_fetch_array($res);
		if ($contracte_ok['id']) { echo $contracte_ok['id']; 
			//fix
		$update="update kms_isp_domains set sr_contract=".$contracte_ok['id']." where name='".$dom['name']."'";
		$res2=mysqli_query($link,$update);

		} else echo "NOT FOUND ".$sel;
	}
	$n++;
}


?>
