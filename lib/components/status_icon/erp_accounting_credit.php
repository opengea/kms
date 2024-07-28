<?
include_once "erp_functions.php";
$select="SELECT * FROM kms_erp_accounting WHERE id={$id}";
$res=mysqli_query($this->dm->dblinks['client'],$select);
$account=mysqli_fetch_array($res);
$select="SELECT SUM(credit) FROM kms_erp_accounting_bookentries WHERE account_id like '".$account['account']."%'  and creation_date like '".$_SESSION['erp_accounting_exercici']."%'";
$res=mysqli_query($this->dm->dblinks['client'],$select);
$row=mysqli_fetch_array($res);
$out=money($row[0])." &euro;";
?>

