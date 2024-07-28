<?
// adquirim domini
$extpos =  strpos($_SERVER['SERVER_NAME'], '.')+1;
$current_domain = substr($_SERVER['SERVER_NAME'],$extpos,strlen($_SERVER['SERVER_NAME']));
?>


<!-- top -->
<div id="top">
 	<table class="topdocument" border="0" width="100%" marginwidth="0" marginheight="0" topmargin="0" leftmargin="0" style="padding:0px;margin:0px">
	<tr><td width="165" align="center" valign="middle" style="padding-top:3px" height="62">
	<!-- logo -->
	<a href="index.php"><img src="//data.<?=$current_domain?>/conf/<?=$extranet['logo']?>" border=0></a>
	</td>
	<!--- missatge flotant -->
	<td align="center" style="padding:0px;margin:0px">
	<div class="MAIN" style="padding:0px;margin:0px">
	<?php if ($msgs) { ?>
	  <div class="MSG" style="padding:0px;margin:0px">
	<?php
	foreach ($msgs as $message) {
	    echo "<img src=\"".PATH_IMG_SMALL."/note.gif\" /> ";
	    echo "<font style='font-size:12px' color='#666666'>".$message . "</font>\n";
	}
	?>
	</div>
	<?php } ?>
	</td>
        <!-- opcions top right -->
        <td valign="top" align="right" width="300" style="vertical-align:top;padding:0px;margin:0px;padding-right:5px">
	<font color="#888888" style="font-size:11px"><font color="#888888" style="font-size:11px"><div class="SUPPORTBT" style="text-align:top"><a href="" title="<?= _KMS_GL_EDIT;?>"><?=$_SESSION['user_name']?></a>&nbsp;| <a href="/?_=logout"><? echo _CMN_LOGOUT;?></a></div>&nbsp;</font>
	</td>
	</tr>
	</table>
</div>


