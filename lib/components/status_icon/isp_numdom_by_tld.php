<?
$sel = "SELECT * from kms_ecom_services where id=".$id;
$res=mysqli_query($this->dm->dblinks['client'],$sel);
$tld=mysqli_fetch_array($res);
$sel = "SELECT COUNT(*) from kms_isp_domains WHERE name like '%".$tld['name']."'";
$res=mysqli_query($this->dm->dblinks['client'],$sel);
$count=mysqli_fetch_array($res);
$out=trim($count[0]);
?>
