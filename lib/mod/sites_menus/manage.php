<?php
//$this->uid=$this-key;
//$this->rowclick = "drag"; //"edit"; //need $this->uid=$this-key; on setup(), and orderby="sort_order"
//$this->orderby="sort_order";

$link_client_extranet = mysqli_connect($client_account['dbhost'],$client_account['dbuser'],$client_account['dbpasswd'],$client_account['dbname']);
$sel="select * from kms_sites_menus_options where menu_id=".$id;
$res=mysqli_query($link_client_extranet,$sel);
//print_r($this->dm->dblinks['client']);
$row=mysqli_fetch_assoc($res);
print_r($row);
$out="<a href='http://extranet.".$this->dm->current_domain."/?app=db&mod=sites_menus_options&app=sites&menu=1&_=b&queryfield=menu_id&query=".$id."'>Veure el detall</a>";
?>
