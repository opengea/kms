<table class="document" width="100%"  height="auto" border="0" cellpadding="0" cellspacing="0" style="padding:0px">
<tr>
<td width="100%" colspan="2" style="vertical-align:top">
	<table class="top" border="0" style="height:25px" width="100%" cellspacing="0" cellpadding="0">
	<tr><td>
	<!-- home button -->
	<ul class="mobile_menu" style="display:none"> <li class="mobile_menu_item<? if ($_GET['app']=="") echo "_selected";?>_home" onclick="document.location='/index.php'" title="<?=ucfirst($current_subdomain)." ".constant('_KMS_GL_HOME')?>"><a></a></li><li class="mobile_menu_item"><? if ($_GET['mod']=="folders") echo ucfirst($current_subdomain); else echo constant("_KMS_TY_".strtoupper($_GET['mod']));?></li>
	<?/*<li style="text-align:center;list-style-type:none;padding-top:5px;padding-right:30px"><a style="color:#444;cursor:pointer;cursor:hand" title="<?=date('d-m-Y')?>"><?=date('H:i')?></a></li>*/?>
	</ul>
	
	<ul class="quick_menu">
	<li class="quick_menu_item<? if ($_GET['app']=="") echo "_selected";?>_home" onclick="document.location='/index.php'" title="<?=ucfirst($current_subdomain)." ".constant('_KMS_GL_HOME')?>"><a></a></li>
		
<?
	//quick_menu (hem de fer-lo desplegable per a que sigui realment quick!)
//include "/usr/local/kms/lib/dbi/openClientDB.php";
	$select = "SELECT * from kms_sys_bookmarks where userid='".$_SESSION['user_id']."' order by sort_order";
                                $result=mysqli_query($link_extranetdb,$select);
				if (!$result) die (mysqli_error($result)." ".$select);
                                $num_apps = mysqli_num_rows($result);
				$n=1;
                                while ($row=mysqli_fetch_array($result)) {
        	                        $var=constant("_KMS_TY_".strtoupper($row['description']));
                                	if ($var=="") $var=$row['description'];
					echo " <li class=\"quick_menu_item";
					echo "\" onclick=\"document.location='".$row['url']."'";
					//if ($n==0) echo ";$('li.quick_menu_item_home').style('background-color','#444');";
					echo "\"";
					if ($n==1&&strtolower($row['name'])!=$_GET['app']&&$_GET['app']!="") echo " onmouseover=\"$('li.quick_menu_item_home').css('background-color','#666');\" onmouseout=\"$('li.quick_menu_item_home').css('background-color','transparent');\"";
					if ($n==1&&$_GET['app']=="") echo " onmouseover=\"$('li.quick_menu_item_selected_home').css('background-color','#666');\" onmouseout=\"$('li.quick_menu_item_selected_home').css('background-color','transparent');\"";

					echo ">".$var."</li>";
					 if (strtolower($row['name'])==$_GET['app']&&$n==1) echo "<script language='javascript'>$('li.quick_menu_item_home').css('background-color','#444');</script>";             
					$n++;
                                }
				echo "</ul>";

 ?>
	</a>
	</td>

        <!-- opcions top right -->
        <td class="topoptions" width="100" valign="top">
<div style="float:right;text-align:top"><span style='color:#666'>&nbsp;| </span><a href="/?_=logout"><? echo _CMN_LOGOUT;?></a></div>
	<div  style="text-align:top;float:right"><a href="/?app=preferences&mod=sys_users&_=e&id=<?=$_SESSION['user_id']?>"><b><?=ucfirst($_SESSION['user_name']);?></b></a><span style='color:#666'>&nbsp;</span></div>
	<? $datecolor = (date('Y') < 2018) ? "#AA0000" : ""; ?>
	<div  style="text-align:top;float:right;color:<?=$datecolor?>"><?=date('d/m/Y')?><span style='color:#666'>&nbsp;|&nbsp;</span></div>
	</td>
	</tr>
	</table>
</td>
<tr>
<? if ($kms->showMenu) { ?>
<td valign="top">
<!-- menu  -->
<div id="leftmenu" class="leftmenu" ></div>
<script language="javascript">$("div#leftmenu").load("/kms/lib/menu.php");</script>
<?// include "menu.php"; ?>
</td>
<? } ?>
<td valign="top" height="100%" style="vertical-align:top">
