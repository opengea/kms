<?
if ($_POST['exercici']!="") {

	$_SESSION['erp_accounting_exercici']=$_POST['exercici'];
	include "/usr/local/kms/lib/dbi/db_localhost_connect.php";
	$sel="select * from kms_erp_accounting";// where exercici='".$_SESSION['erp_accounting_exercici']."'";
	$res=mysqli_query($dblink_local,$sel);
	while ($account=mysqli_fetch_array($res)) {
	
	        $select="SELECT SUM(credit) FROM kms_erp_accounting_bookentries WHERE account_id like '".$account['account']."%' and exercici='".$_SESSION['erp_accounting_exercici']."'"; //creation_date like '".$_SESSION['erp_accounting_exercici']."%'";
	        $res2=mysqli_query($dblink_local,$select);
	        $row=mysqli_fetch_array($res2);
	        if ($row[0]==0) {
	                $update="UPDATE kms_erp_accounting SET status=0 where account='".$account['account']."'";
	        } else {
	                $update="UPDATE kms_erp_accounting SET status=1 where account='".$account['account']."'";
	
	        }
	$res3=mysqli_query($dblink_local,$update);
	
	}
echo "Exercici canviat a ".$_SESSION['erp_accounting_exercici']."<br><br>";;
}
?>
<form method="post">
Exercici actual:
<input name="exercici" value="<?=$_SESSION['erp_accounting_exercici']?>">
<input class="customButton highlight" type="submit" value="Canviar">
</form>


