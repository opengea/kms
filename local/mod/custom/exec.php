<?
include "/usr/local/kms/lib/mod/shared/db_links.php";
include "getdata.php";
$sel="select * from kms_".$_GET['mod']." WHERE id=".$_GET['id'];
//$exec=$this->dbi->get_record("select * from kms_".$_GET['mod']." WHERE id=".$_GET['id'],$dblink_cp);
$res=mysql_query($sel);
$row=mysql_fetch_array($res);
//print_r($row);
//include "/usr/local/kms/mod/sites/links/".$row['url'];

//if ($row['type']=="url"

?>
<iframe src="<?=$row['url']?>" width="100%" height="100%" frameborder="0"></iframe>
