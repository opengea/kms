<?
//include_once "erp_functions.php";
if ($_GET['mod']=="erp_contracts") {
	$select="SELECT sr_client FROM kms_erp_contracts WHERE id={$id}";
	$res=mysqli_query($this->dm->dblinks['client'],$select);
	$contract=mysqli_fetch_assoc($res);
	
	$select="SELECT * FROM kms_ent_contacts WHERE id={$contract['sr_client']}";
	$res=mysqli_query($this->dm->dblinks['client'],$select);
	$client=mysqli_fetch_assoc($res);

} else if ($_GET['mod']=="ent_clients") {
	$client=array("id"=>$id);	
}



$select="SELECT * FROM kms_ent_contacts WHERE id={$client['id']}";
$res=mysqli_query($this->dm->dblinks['client'],$select);
$client=mysqli_fetch_assoc($res);

$select="select count(*) as n from kms_erp_invoices where sr_client=".$client['id']." and (status='pedent' or status='retornat' or status='impagada')";
$res=mysqli_query($this->dm->dblinks['client'],$select);
$pending_invoices=mysqli_fetch_assoc($res);
if ($pending_invoices['n']>0) $out="<a href='/?app=erp&mod=erp_invoices&query_field=sr_client&query=".$client['name']."' style='color:red'>".$client['name']."</a>"; else $out=$client['name'];

?>

