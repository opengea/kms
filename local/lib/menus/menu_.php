<!-- menu -->
<div id="menu" style="position:relative; left:0px; top:1; width:100%; height:33px; z-index:10; visibility: visible;">

<div class="submenu" id="menu1" style="position:absolute; top:26; left:55; right:0; width:230;">
<table cellspacing="0" cellpadding="0" border="0">
<tr><td class="tdsubmenu" id="b11"><a href="?s=cr_concepto&a=2" class="mi" onmouseover="changeSubUp('b11');" onmouseout="changeSubDown('b11');">Cirug&iacute;a refractiva</a></td></tr>
<tr><td class="tdsubmenu" id="b12"><a href="?s=serveis_op&a=1" class="mi" onmouseover="changeSubUp('b12');" onmouseout="changeSubDown('b12');">Oftalmolog&iacute;a pedi&aacute;trica</a></td></tr>
<tr><td class="tdsubmenu" id="b13"><a href="?s=serveis_cataratas&a=1" class="mi" onmouseover="changeSubUp('b13');" onmouseout="changeSubDown('b13');">Cataratas</a></td></tr>
<tr><td class="tdsubmenu" id="b17"><a href="?s=serveis_sa&a=1" class="mi" onmouseover="changeSubUp('b17');" onmouseout="changeSubDown('b17');">Segmento anterior</a></td></tr>
<tr><td class="tdsubmenu" id="b18"><a href="?s=serveis_glaucoma&a=1" class="mi" onmouseover="changeSubUp('b18');" onmouseout="changeSubDown('b18');">Glaucoma</a></td></tr>
<tr><td class="tdsubmenu" id="b14"><a href="?s=serveis_c&a=1" class="mi" onmouseover="changeSubUp('b14');" onmouseout="changeSubDown('b14');">Contactolog&iacute;a</a></td></tr>
<tr><td class="tdsubmenu" id="b15"><a href="?s=serveis_cpo&a=1" class="mi" onmouseover="changeSubUp('b15');" onmouseout="changeSubDown('b15');">Cirug&iacute;a pl&aacute;stica ocular</a></td></tr>
<tr><td class="tdsubmenu" id="b16"><a href="?s=serveis_pv&a=1" class="mi" onmouseover="changeSubUp('b16');" onmouseout="changeSubDown('b16');">Patolog&iacute;as Vitreo-retinianas</a></td></tr>
</table>
</div>

<div class="submenu" id="menu3" style="position:absolute; top:26; left:355; right:0; width:200;">
<table cellspacing="0" cellpadding="0" border="0" >
<tr><td class="tdsubmenu" id="b21"><a href="?s=equip_medic&a=3" class="mi" onmouseover="changeSubUp('b21');" onmouseout="changeSubDown('b21');">Equipo m&eacute;dico</a></td></tr>
<tr><td class="tdsubmenu" id="b22"><a href="?s=equip_auxiliar&a=3" class="mi" onmouseover="changeSubUp('b22');" onmouseout="changeSubDown('b22');">Equipo m&eacute;dico auxiliar</a></td></tr>
<tr><td class="tdsubmenu" id="b23"><a href="?s=equip_atenciopacient&a=3" class="mi" onmouseover="changeSubUp('b23');" onmouseout="changeSubDown('b23');">Atenci&oacute;n al paciente</a></td></tr>
<tr><td class="tdsubmenu" id="b24"><a href="?s=equip_admin&a=3" class="mi" onmouseover="changeSubUp('b24');" onmouseout="changeSubDown('b24');">Administraci&oacute;n</a></td></tr>
</table>
</div>

<!--- menu principal -->
<table width="800" cellspacing="0" cellpadding="0" border="0"><tr>
	<td class="tdmenu" style="border-left:0px;" width="54"><a href="?s=home&a=0" class="mi" onclick="toggleMenu('0',0);" onmouseover="changeUp('b0');" onmouseout="changeDown('b0');"><span id="nb0" class="butmenu"><img id="b0" src="data/images/b0<? if ($_GET['a']=='0') echo "on"; else echo "off";?>.png" border="0"></span></a></td>
	<td class="tdmenu" width="171"><a class="mi" onclick="toggleMenu('1',1);" onmouseover="changeUp('b1');" onmouseout="changeDown('b1');"><span id="nb1" class="butmenu"><img id="b1" src="data/images/b1<? if ($_GET['a']=='1') echo "on"; else echo "off";?>.png" border="0"></span></a></td>

	<td class="tdmenu" width="129"><a href="?s=cr_concepto&a=2" class="mi" onclick="toggleMenu('2',2);" onmouseover="changeUp('b2');" onmouseout="changeDown('b2');"><span id="nb2" class="butmenu"><img id="b2" src="data/images/b2<? if ($_GET['a']=='2') echo "on"; else echo "off";?>.png" border="0"></span></a></td>
	<td class="tdmenu" width="122"><a class="mi" onclick="toggleMenu('3',3);" onmouseover="changeUp('b3');" onmouseout="changeDown('b3');"><span id="nb3" class="butmenu"><img id="b3" src="data/images/b3<? if ($_GET['a']=='3') echo "on"; else echo "off";?>.png" border="0"></span></a></td>
	<td class="tdmenu" width="138"><a href="?s=informacion_general&a=4" class="mi" onclick="changeBg(4);" onmouseover="changeUp('b4');" onmouseout="changeDown('b4');"><span id="nb4" class="butmenu"><img id="b4" src="data/images/b4<? if ($_GET['a']=='4') echo "on"; else echo "off";?>.png" border="0"></span></a></td>
	<td class="tdmenu" width="89"><a href="?s=novedades&a=6" class="mi" onclick="toggleMenu('5',5);" onmouseover="changeUp('b5');" onmouseout="changeDown('b5');"><span id="nb5" class="butmenu"><img id="b5" src="data/images/b5<? if ($_GET['a']=='5') echo "on"; else echo "off";?>.png" border="0"></span></a></td>
	<td class="tdmenu" width="66"><a href="?s=contacto&a=7" class="mi" onclick="toggleMenu('6',6);" onmouseover="changeUp('b6');" onmouseout="changeDown('b6');"><span id="nb6" class="butmenu"><img id="b6" src="data/images/b6<? if ($_GET['a']=='6') echo "on"; else echo "off";?>.png" border="0"></span></a></td>

</tr></table>

</div>

<script language="javascript">
//adjustMenuPosition();
</script>
<!-- final del menu-->
