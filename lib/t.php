<?
$delete_date=date('Y-m-d',strtotime("-90 days",strtotime(date('Y-m-d'))));
$select="SELECT * FROM kms_isp_domains WHERE auto_renew=0 AND status='EXPIRED' AND expiration_date<='".$delete_date."'";
echo $select;
?>
