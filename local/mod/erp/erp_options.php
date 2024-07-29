<?
// Fetch KMS ERP Configuration
$erp=Array();                
$sel="SELECT name,value FROM kms_sys_conf WHERE family='erp' or family='ecom'";
$result = mysqli_query($dblink_local,$sel);
while ($param = mysqli_fetch_array($result)) {
	$erp[$param['name']]=$param['value'];
}
//print_r($erp);
$iva_aplicable=$erp['ecom_def_vat'];
$venciment_day=$erp['ecom_def_payment_month_day'];
$mda=$erp['erp_accounts_max_digits']; //max digits for accounts (BIGINT)
$current_plan=$erp['erp_current_accounting_plan'];

?>
