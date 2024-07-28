<?
//$this->dm->rebuildDNS("full");
//$this->tab[0]->mod[1]->rebuildDNS("full");
//print_r($this);
$dns=new isp_dns($this->client_account,$this->user_account,$this->dm,1);
$result=$dns->rebuildDNS("full");
if (!$result) die('aborted');
?>
<script>document.location="/?app=<?=$_GET['app']?>&mod=<?=$_GET['mod']?>&_=b&xid=<?=$_GET['xid']?>&from=<?=$_GET['from']?>&panelmod=<?=$_GET['panelmod']?>";</script>
