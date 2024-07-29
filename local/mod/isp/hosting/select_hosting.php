<?
// seleccionem si volem utilitzar un hosting ja existent per al domini o un de nou

include "/usr/local/kms/lib/mod/shared/db_links.php";
include "getdata.php";

if ($_POST['activate']==1) {
	$_POST['activate']=0;
	if ($_POST['sel']=="new") {
		include "/usr/local/kms/mod/isp/hosting/new_hosting.php";
	} else {
		$id=$_POST['hosting'];
		include "/usr/local/kms/mod/isp/hosting/setup.php";
	}
	exit;
}

$sel="select * from kms_isp_hostings where sr_client=".$vhost['sr_client']." AND (type='Multidomain Cloud Hosting' OR type='Virtual Private Server (VPS)' OR type='Dedicated Server' OR (id NOT IN (select id from kms_isp_hostings_vhosts where hosting_id=id and sr_client='".$vhost['sr_client']."')) OR (max_vhosts>used_vhosts))";
//echo $sel;
$res=mysqli_query($dblink_cp,$sel);
$num_free_hostings = mysqli_num_rows($res);

// FORM ?> 
<h2><?=_KMS_ISP_HOSTINGS_VHOSTS_SETUP?> <?=$vhost['name']?></h2>

<form method="POST">
<?
if ($num_free_hostings>0) {
	        echo "On voleu allotjar el domini ".$vhost['name']."?<br><br>";
	        echo "<input type=\"radio\" name=\"sel\" value=\"existant\" checked> En un dels meus hostings contractats <select id=\"hosting\" name=\"hosting\">\n";
	        while ($hosting=mysqli_fetch_array($res)) {
	                echo "<option value=\"".$hosting['id']."\">".$hosting['type']." ".$hosting['description']."</option>\n";
	        }
	        echo "</select><br>";
		echo "<input type=\"radio\" name=\"sel\" value=\"new\">Vull contractar un hosting apart per aquest domini";
?>
<?//=str_replace("[DOMAIN]",$vhost['name'],_KMS_ISP_DOMAINS_SERVICES_EXPLAIN)?>
<br>
<? if (strpos($domain['nameserver1'],"intergridnetwork.net")==0) echo "<br><div class='warn'>"._KMS_ISP_DOMAINS_SERVICES_DNS_WARNING."</div>"; ?>
<br>
<br>

<input type="hidden" name="activate" value="1">
<input class="customButton highlight" type="submit" name="submit" value="<?=_KMS_ISP_DOMAINS_SERVICES_BUT?>" style="cursor:pointer;cursor:hand">
&nbsp;&nbsp;
<input class="customButton" type="button" value="<?=_404_RTS?>" style="cursor:pointer;cursor:hand" onclick="#document.location='/?app=<?=$_GET['app']?>&mod=isp_hostings_vhosts'">
</form>
<? 
} else {
        include "/usr/local/kms/mod/isp/hosting/new_hosting.php";
}
?>
