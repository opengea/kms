<?
// HOSTING SELECTOR FORM 

if ($_GET['action']=="setup_hosting")  {
?><h2><?=_KMS_ISP_HOSTINGS_VHOSTS_SETUP?> <?=$vhost['name']?></h2><? 
} else if ($_GET['action']=="add_hosting") {
?><h2><?=_KMS_ISP_HOSTINGS_NEW?></h2><?
}
?>
<form id="hostingsel" method="POST" action="/?_=f&app=<?=$_GET['app']?>&mod=isp_hostings&action=new_hosting&id=<?=$_GET['id']?>">
<?

        echo _KMS_ISP_HOSTINGS_SELECT." :<br><br>";
        echo "<input type=\"radio\" name=\"type\" onchange=\"setExplain(1)\" value=\"ch\" checked><b>"._KMS_ISP_HOSTING_CH."</b><br>";
        echo "<input type=\"radio\" name=\"type\" onchange=\"setExplain(2)\" value=\"vh\"><b>"._KMS_ISP_HOSTING_VH."</b><br>";
        echo "<input type=\"radio\" name=\"type\" onchange=\"setExplain(3)\" value=\"dh\"><b>"._KMS_ISP_HOSTING_DH."</b><br>";
//$hostings=mysqli_fetch_array($res);

?>
<?//=str_replace("[DOMAIN]",$vhost['name'],_KMS_ISP_DOMAINS_SERVICES_EXPLAIN)?>
<br><div id="explain" class="explain"></div>
<script language="javascript">
function setExplain(n) {
	if (n==1) { 
		$('#hostingsel').attr('action','/?_=f&app=<?=$_GET['app']?>&mod=isp_hostings&action=new_hosting&id=<?=$_GET['id']?>');
		$('#explain').html("<?=_KMS_ISP_HOSTINGS_EXPLAIN1?>"); 
	} else if (n==2) { 
		$('#hostingsel').attr('action','/?_=f&app=<?=$_GET['app']?>&mod=isp_hostings&action=new_vh&id=<?=$_GET['id']?>');
		$('#explain').html("<?=_KMS_ISP_HOSTINGS_EXPLAIN2?>");
	} else if (n==3) { 
		$('#hostingsel').attr('action','/?_=f&app=<?=$_GET['app']?>&mod=isp_hostings&action=new_dh&id=<?=$_GET['id']?>'); 
		$('#explain').html("<?=_KMS_ISP_HOSTINGS_EXPLAIN3?>"); 
	}
}
setExplain(1);
</script>
<br>
<? 
if ($_GET['action']=="setup_hosting")  {
	if (strpos($domain['nameserver1'],"intergridnetwork.net")==0) echo "<br><div class='warn'>"._KMS_ISP_DOMAINS_SERVICES_DNS_WARNING."</div>"; 
}
?>
<br>

<input type="hidden" name="activate" value="1">
<input class="customButton highlight" type="submit" name="submit" value="<?=_KMS_GL_CONTINUE?>" style="cursor:pointer;cursor:hand">
&nbsp;&nbsp;
<input class="customButton" type="button" value="<?=_404_RTS?>" style="cursor:pointer;cursor:hand" onclick="#document.location='/?app=<?=$_GET['app']?>&mod=isp_hostings_vhosts'">
</form>
