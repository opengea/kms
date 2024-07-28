<?
include_once "/usr/local/kms/lib/mod/shared/db_links.php";
include_once "/usr/local/kms/lib/mod/isp_servers.php";

if ($_POST['external_domain']!="") $domain=$_POST['external_domain']; else if ($_POST['domain']!="") $domain=$_POST['domain'];

if (($domain!="")&&$_POST['hosting']!="") {
	// SETUP NEW VHOST
	$hosting=$this->dbi->get_record("select * from kms_isp_hostings where id=".$_POST['hosting']);
	if ($hosting['sr_contract']==""||$hosting['sr_contract']==0) $this->_error("","[add_vhost] Hosting ".$_POST['hosting']." not found","fatal");
	$contract=$this->dbi->get_record("select * from kms_erp_contracts where id=".$hosting['sr_contract'],$dblink_erp);
	$contract['domain']=$domain;
	$hosting_id=$_POST['hosting'];
	if ($contract['sr_client']=="") $this->_error("","[add_vhost] sr_client not found on erp_contracts id=".$hosting['sr_contract'],"fatal");
	$isp_vhost=new isp_hostings_vhosts($this->client_account,$this->user_account,$this->dm,1);
	$isp_servers=new isp_servers($this->client_account,$this->user_account,$this->dm);
	$servers=$isp_servers->getInstallServers("",$hosting);
	if ($servers['webserver']==""&&$servers['mailserver']=="") { echo "No webserver and mailserver assigned to this hosting!"; print_r($hosting); die('error'); }
	$isp_vhost->setupVhost($contract,$hosting_id,$servers,"DNS,WEB,DB,MAIL,CP,FTP");
	echo "<script language=\"javascript\">redirect('/?app=".$_GET['app']."&mod=".$_GET['mod']."');</script>";
	
} else {
	// FORM NEW VHOST
?>
<h2><?=_KMS_ISP_HOSTINGS_VHOSTS_NEW?></h2>
<form name="newvhost" id="newvhost" method="post">
<? 

$client=$this->dbi->get_record("select * from kms_isp_clients where sr_user=".$this->user_account['id']);
if ($client['sr_client']==0) $this->_error("","client_id missing","fatal");
//$sel="select * from kms_isp_domains where sr_client=".$client['sr_client']." and hosting_id=0";
//$sel="SELECT * FROM kms_isp_domains where sr_client=".$client['sr_client']." and name not in (select name from kms_isp_hostings_vhosts)";

//determine num_free_domains:
$sel="SELECT * FROM kms_isp_domains where name not in (select name from kms_isp_hostings_vhosts) AND (sr_client=".$client['sr_client']." or sr_client in (select kms_isp_clients.sr_client from kms_isp_clients where kms_isp_clients.sr_provider=".$client['sr_client']."))";
$res1=mysql_query($sel,$dblink_cp);
$num_free_domains = mysql_num_rows($res1);


//determine num_free_hostings:
$avail_hostings=array();
if ($client['sr_client']==$client['sr_provider']) { //proveidor, cal mirar tots els clients

	$num_free_hostings=0;
	$sel="select sr_client,name from kms_isp_clients where sr_provider=".$client['sr_client'];
	$res0=mysql_query($sel,$dblink_cp);
	while ($customer=mysql_fetch_array($res0)) {
	        $sel="select * from kms_isp_hostings where sr_client=".$customer['sr_client']." and (max_vhosts>used_vhosts or max_vhosts='-1')";
	        $res2=mysql_query($sel,$dblink_cp);
		while ($hosting=mysql_fetch_array($res2)) {
               	 array_push($avail_hostings,$hosting);
		 $num_free_hostings += mysql_num_rows($res2);
        	}
		//if ($num_free_hostings>0) break;
	}

} else {
	
	$sel="select * from kms_isp_hostings where sr_client=".$client['sr_client']." and (max_vhosts>used_vhosts or max_vhosts='-1')";
	$res2=mysql_query($sel,$dblink_cp);
	$num_free_hostings = mysql_num_rows($res2);

	while ($hosting=mysql_fetch_array($res2)) {
		array_push($avail_hostings,$hosting);
	}

}
/* versio intranet 

print_r($this->user_account);
if ($this->client_account['client_id']==0) $this->_error("","client_id missing","fatal");
$sel="select * from kms_isp_domains where sr_client=".$this->client_account['client_id']." and vhost_id=0";
$res1=mysql_query($sel);
$num_free_domains = mysql_num_rows($res1);
$sel="select * from kms_isp_hostings where sr_client=".$this->client_account['client_id']." and max_vhosts>used_vhosts";
$res2=mysql_query($sel);
$num_free_hostings = mysql_num_rows($res2);


*/
if ($num_free_hostings==0) {
	echo _KMS_ISP_VHOSTS_CONFIGURE_NOHOSTINGAVAIL;
	exit;
}


if ($num_free_domains>0) {
	echo _KMS_ISP_VHOSTS_CONFIGURE."<br><br>";
	echo "<input type='radio' name='domtype'>"._KMS_ISP_VHOSTS_CONFIGURE1."<br>";
	echo "<div style='padding-left:20px;padding-top:5px'><select name=\"domain\">";
	while ($domain=mysql_fetch_array($res1)) {
		echo "<option value=\"".$domain['name']."\">".$domain['name']."</option>";
	}
	echo "</select></div><br>";
	echo "<input type='radio' name='domtype'>"._KMS_ISP_VHOSTS_CONFIGURE2."<br>";
} else {
	echo _KMS_ISP_VHOSTS_CONFIGURE1_NONE."<br><br>";
	echo "<div style='float:left;padding-right:10px;padding-top:8px'>"._KMS_ISP_DOMAINS_NAME." : </div> ";
}

?>
<script>
window.onload = function(){
bindEvents();
}
function bindEvents()
{
$('input').bind('keydown paste', checkForSpaces);
}
function checkForSpaces()
{
if (event.type == "keydown" && event.which == 32) {return false;}
if (event.type == "paste" && event.clipboardData.getData('text/plain').indexOf(" ") != -1) {return false;}
}
</script>
<div style='padding-left:20px;padding-top:5px'><input id="external_domain" style="width:250px" name="external_domain" type="text"><br></div>
<br>
<?
	echo "<b>"._KMS_TY_HOSTING."</b> : ";
	echo "<select name=\"hosting\">";
	foreach ($avail_hostings as $hosting) {
                echo "<option value=\"".$hosting['id']."\">".$hosting['type']." ".$hosting['description']."</option>";
        }
	echo "</select>";

?>
<input class="customButton highlight" type="button" name="submitting" value="Continuar" onclick="this.disabled=true;document.getElementById('newvhost').submit();"  style="cursor:pointer;cursor:hand">
</form>
<? } ?>
