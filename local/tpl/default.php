<?
$lang = substr($_SERVER["HTTP_ACCEPT_LANGUAGE"],0,2);
$text = Array();

if (substr($_SERVER['SERVER_NAME'],0,8)=="extranet"){
 $extranet = Array();
 $extranet['ca'] = "<br>El servei d'extranet no est&agrave; activat en aquest domini. Per a m&eacute;s informaci&oacute; feu clic <a href='http://www.intergrid.cat/'>aqu&iacute;</a><br><br>";
 $extranet['es'] = "<br>El servicio extranet no est&aacute; activado para este dominio. Para m&aacute;s informaci&oacute;n haga clic <a href='http://www.intergrid.es/'>aqu&iacute;</a><br><br>";
 $extranet['en'] = "<br>The extranet service is not enabled for this domain. Click <a href='http://www.intergrid.cat/?lang=en'>here</a> for more information.<br><br>";
} else {
 $extranet = "";
}

$text['ca'] = "<b style='font-size:23px'>".$_SERVER['SERVER_NAME']."</b><br><br><br><br><br><br>".$extranet[$lang]."<br><a href='http://www.intergrid.cat' border='0'><img border='0' src='http://www.intergrid.cat/data/images/intergrid.png'></a><br><br>Serveis web per empreses : dominis, allotjament i aplicacions";
$text['es'] = "<b style='font-size:23px'>".$_SERVER['SERVER_NAME']."</b><br><br><br><br><br><br>".$extranet[$lang]."<br><a href='http://www.intergrid.es' border='0'><img border='0' src='http://www.intergrid.cat/data/images/intergrid.png'></a><br><br>Servicios web para empresas: dominios, alojamiento y aplicaciones";
$text['en'] = "<b style='font-size:23px'>".$_SERVER['SERVER_NAME']."</b><br><br><br><br><br><br>".$extranet[$lang]."<br><a href='http://www.intergrid.cat' border='0'><img border='0' src='http://www.intergrid.cat/data/images/intergrid.png'></a><br><br>Domain names, Hosting and Web Applications";



;?>
<center>
<table width="100%" height="100%"><tr><td valign="middle" align="center">
<font face="verdana" size="2">
<?echo $text[$lang]; ?>
<br>
<br>
<? // <hr style="color:#c00;background-color:#c00;height:1px;border:none;" /> ?>
<font color="#999999" style="font-size:9px">Intergrid tecnologies del coneixement SL<br>
<a href="mailto:info@intergrid.cat" style="color:#59c6fe;">info@intergrid.cat</a><br></font>
<br>
</td></tr></table>
</center>
