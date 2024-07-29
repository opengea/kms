<?
$sel="select * from kms_isp_hostings_vhosts where id=".$_GET['id'];
$res=mysqli_query($dblink_cp,$sel);
$vhost=mysqli_fetch_array($res);

$sel="select * from kms_isp_domains where name='".$vhost['name']."'";
$res=mysqli_query($dblink_cp,$sel);
$domain=mysqli_fetch_array($res);

$sel="select * from kms_isp_clients where sr_client=".$vhost['sr_client'];
$res=mysqli_query($dblink_cp,$sel);
$client=mysqli_fetch_array($res);
?>
