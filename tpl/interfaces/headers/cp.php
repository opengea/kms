<table class="document" width="100%"  height="auto" border="0" cellpadding="0" cellspacing="0" style="padding:0px">
<tr>
<td width="100%" colspan="2" style="vertical-align:top">
	<table class="top" border="0" width="100%" cellspacing="0" cellpadding="0">
	<tr><td class="logo">
	<!-- logo -->
	<a href="/index.php" class='logo'>
<img src="/kms/css/aqua/img/logos/intergrid-logo-white-135.png" border="0" class='logo'>
	</a>
	</td>
	<!--- missatge flotant -->
	<td align="center" style="vertical-align:middle">
	<div class="MAIN">
<?
        // obtain the title of the current folder

        if ($_GET['dr_folder']=="") $_GET['dr_folder']=0;
        include_once ('/usr/local/kms/lib/dbi/openClientDB.php');
//        require_once ('/usr/local/kms/lib/dbi/dbconnect.php');
 
	 if ($title=="") {
        $title_ = $title;
        // titol de la carpeta
        $result = mysql_query("SELECT description FROM kms_sys_folders WHERE id='".$_GET['dr_folder']."'");
        if (!$result) {
                //echo "error head.php ".mysql_error();    exit;
		
                $title = $this->title;
                } else {
                    $rowdr = mysql_fetch_array($result);
                    $title = $rowdr['description'];
                    if ($title=="") $title=ucfirst($current_subdomain);
                }
        }
	if ($_GET['app']!="") {
		$title=constant('_KMS_TY_'.strtoupper($_GET['app']));

		if (defined('_KMS_TY_'.strtoupper($_GET['app']))) $title=constant('_KMS_TY_'.strtoupper($_GET['app'])); else {
			$select="select * from kms_sys_apps where keyname='".$_GET['app']."'";
	                $res=mysql_query($select);
	                $app=mysql_fetch_array($res);
			$title=$app['name'];
		}
	}
	
/*	if ($_GET['mod']!=""&&$_GET['mod']!="folders") {
		if ($title!="") $title.=" - ";
		if (defined('_KMS_TY_'.strtoupper($_GET['mod']))) $title.=constant('_KMS_TY_'.strtoupper($_GET['mod'])); else {
			$select="select * from kms_sys_mods where keyname='".$_GET['mod']."'";
                        $res=mysql_query($select);
                        $mod=mysql_fetch_array($res);
                        $title.=$mod['name'];
		}
	}
*/
        // Constants en els noms de les carpetes (per sistema multiidioma)
       
	 if (substr($title,0,4)=="_FL_") $title= constant($title);
        if (substr($title,0,4)=="_KMS") $title= constant($title);

        // tornem a la base de dades predefinida
        $result = mysql_connect($_SESSION['mydb_host'],$_SESSION['mydb_user'],$_SESSION['mydb_pass']);
        mysql_select_db ($_SESSION['mydb_name']);

        $iconurl = PATH_IMG_BIG.$content_type."_big.png";
        if (!file_exists('/usr/share'.$iconurl)) $iconurl = "/kms/css/aqua/img/big/folders_big.png";

?>
	<font style="font-size:17px;color:#eee;font-weight:bold;text-shadow:#777 1px 0px 0px"> <?
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
<div style="float:right;text-align:top"><span style='color:#eee;font-family: sans-serif;color:#eee'>| <a href="/?_=logout" style='padding-left:5px;color:#eee;padding-right:5px'><? echo _CMN_LOGOUT;?></a></div>
<? 
	if ($_SESSION['user_groups']==2||$_SESSION['user_groups']==3) {
	$select="select * from kms_isp_clients where sr_user=".$_SESSION['user_id'];
	$res=mysql_query($select);
	$client=mysql_fetch_array($res);
	$company=$client['name'];
	} else if ($_SESSION['user_groups']==1) {
	$company="Intergrid SL";
	}
?>
	<div  style="text-align:top;float:right;color:#eee;padding-top:1px;padding-right:5px;overflow:hidden;height:40px;width:300px"><b><?=ucfirst($_SESSION['user_name']);?> - <?=$company?></b>&nbsp;</span></div> 
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

<td valign="top" height="100%" style="vertical-align:top;overflow:hidden">
