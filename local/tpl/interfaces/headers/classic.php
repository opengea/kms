<table class="document" width="100%"  height="auto" border="0" cellpadding="0" cellspacing="0" style="padding:0px">
<tr>
<td width="100%" colspan="2" style="vertical-align:top">
	<table class="top" border="0" width="100%" cellspacing="0" cellpadding="0">
        <tr><td class="logo">
	<!-- logo -->
	<div class="MAIN">
	<? if (file_exists('/var/www/vhosts/'.$current_domain.'/subdomains/data/httpdocs/tpl/images/logo.png')) { ?> <img src="//data.<?=$current_domain?>/tpl/images/logo.png" border="0" height="30"><? } else { echo "<h1 class='logo'><a href=\"/index.php\" class='logo'>".$_SESSION['client_name']."</a></h1>"; } ?>
	</div>
	</td>
	<!--- missatge flotant -->
	<td align="center" id="midhead" style="vertical-align:middle">
	<div class="MAIN">
<?
        // obtain the title of the current folder

        if ($_GET['folder']=="") $_GET['folder']=0;
	if ($title=="") {
        $title_ = $title;
        // titol de la carpeta
        $result = mysql_query("SELECT name FROM kms_lib_folders WHERE id=".$_GET['folder']);
        if (!$result) {
                	$title = $this->title;;
                } else {
                    $rowdr = mysql_fetch_array($result);
                    $title = $rowdr['name'];
                    if ($title=="") $title=ucfirst($current_subdomain);
                }
        }
	if ($_GET['app']!=""&&$title=="") $title=constant('_KMS_TY_'.strtoupper($_GET['app']));
	
	if ($_GET['mod']!=""&&$_GET['mod']!="folders") {
		if ($title!="") $title.=" - ";
		$title.=constant('_KMS_TY_'.strtoupper($_GET['mod']));
		if ($title=="") { $extranet=true;include "/usr/share/kms/lib/app/sites/getlang.php";
				  $title=getlang('_KMS_TY_'.strtoupper($_GET['mod']),$lang);
				 }
	        if ($title=="") $title=$_GET['mod'];
	}
        // Constants en els noms de les carpetes (per sistema multiidioma)
	 if (substr($title,0,4)=="_FL_") $title= constant($title);
        if (substr($title,0,4)=="_KMS") $title= constant($title);
	if ($title=="") {
			include "/usr/local/kms/lib/dbi/openClientDB.php";
		        include "/usr/local/kms/lib/getClientData.php";
			$title=ucfirst($current_subdomain);
	
	}

	//titol de mods personalitzats catalegs
	if (substr($_GET['mod'],3,1)=="_") {
		$sel="select name,title from kms_sys_mod where `type`='".substr($_GET['mod'],0,3)."' and name='".substr($_GET['mod'],4)."'";
		$res=mysql_query($sel);
		$row=mysql_fetch_array($res);
		if ($row['title']!="") $title=str_replace("_"," ",ucfirst($row['title'])); else $title=str_replace("_"," ",ucfirst($row['name']));
	}

        // tornem a la base de dades predefinida
        $result = mysql_connect($_SESSION['mydb_host'],$_SESSION['mydb_user'],$_SESSION['mydb_pass']);
        mysql_select_db ($_SESSION['mydb_name']);

        $iconurl = PATH_IMG_BIG.$content_type."_big.png";
        if (!file_exists('/usr/share'.$iconurl)) $iconurl = "/kms/css/aqua/img/big/folders_big.png";

?>
	<font style="font-size:17px;color:#3a3a3a;font-weight:bold;text-shadow:#ccc 1px 0px 0px"> <?
	 print $title;
	?></font>
	<? if (isset($kms->subtitle)) { ?> <br><font style="font-size:11px;font-weight:normal"><? echo $kms->subtitle?></font> <?}?>


	<?php if ($msgs) { ?>
	  <div class="MSG">
	<?php
	foreach ($msgs as $message) {
	    echo "<img src=\"".PATH_IMG_SMALL."/note.gif\" /> ";
	    echo "<font style='font-size:12px' color='#fff'>".$message ."</font><br />\n";
	}
	?>
	</div>
	<?php } ?>
	</td>
        <!-- opcions top right -->
        <td class="topoptions" valign="top">
	<font color="#aaa" style="font-size:11px"> 
<div style="float:right;text-align:top"><span style='color:#666;padding-right:5px'>&nbsp;|&nbsp;</span><a href="/?_=logout"><? echo _CMN_LOGOUT;?></a></div> <div style="float:right;text-align:top"></div>&nbsp;&nbsp;
	<div  style="text-align:top;float:right"><? if ($_SESSION['user_id']!='') { ?><a href="/?mod=sys_users&_=e&id=<?=$_SESSION['user_id']?>"><b><?=ucfirst($_SESSION['user_name']);?></b></a><? }  else { ?><b><?=ucfirst($_SESSION['user_name']);?></b><? } ?><span style='color:#666'>&nbsp;&nbsp;&nbsp;</span></div>
	<br><br><br></font>
	</td>
	</tr>
	</table>
</td>
<tr style="border-spacing:0px">
<td class="ttt">
<!--- titols -->

</td>
</tr>

<tr>

<? if ($showMenu) { ?>
<td valign="top">
<!-- menu  -->
<div id="leftmenu" class="leftmenu" ></div>
<script language="javascript">$("div#leftmenu").load("/kms/lib/menu.php");</script>
<?// include "menu.php"; ?>
</td>
<? } ?>
