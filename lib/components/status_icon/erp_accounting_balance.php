<?
include_once "erp_functions.php";
$select="SELECT * FROM kms_erp_accounting WHERE id={$id}";
$res=mysqli_query($this->dm->dblinks['client'],$select);
$account=mysqli_fetch_array($res);
$select="SELECT SUM(credit) FROM kms_erp_accounting_bookentries WHERE account_id like '{$account['id']}%' and creation_date like '".$_SESSION['erp_accounting_exercici']."%'";
$res2=mysqli_query($this->dm->dblinks['client'],$select);
$row=mysqli_fetch_array($res);
$credit=$row[0];
$select="SELECT SUM(debit) FROM kms_erp_accounting_bookentries WHERE account_id like '{$account['id']}%' and creation_date like '".$_SESSION['erp_accounting_exercici']."%'";
$res2=mysqli_query($this->dm->dblinks['client'],$select);
$row=mysqli_fetch_array($res);
$debit=$row[0];
$out=money($credit-$debit)." &euro;";
?>

