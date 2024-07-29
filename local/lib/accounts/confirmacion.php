<?php

if (!isset($_GET["id"]))
{
	ECHO "NO SE HA ENCONTRADO LA VARIABLE \"ID\"";
	exit;
}else{
	$id = trim($_GET["id"]);
}

?>
<HTML>
<HEAD>
<meta http-equiv=Content-Type content='text/html;  charset=ISO-8859-1'>
<TITLE>confirmacion lista correo scalextric</TITLE>
</HEAD>
<BODY bgcolor='#ffffff' leftmargin='0' topmargin='0' marginwidth='0' marginheigth='0'>
<!-- URL's used in the movie-->

<OBJECT classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0' ID='confirmacion' WIDTH='1400' HEIGHT='450' ALIGN='top'>
<PARAM NAME=movie VALUE='http://www.scalextric.es/services/registros/confirmacion.swf?id=<?php echo $id?>'> 
<PARAM NAME=quality VALUE=high> 
<PARAM NAME=scale VALUE=exactfit> 
<PARAM NAME=bgcolor VALUE=#ffffff>  
<EMBED src='http://www.scalextric.es/services/registros/confirmacion.swf?id=<?php echo $id?>' quality=high scale=exactfit bgcolor=#ffffff swLiveConnect=FALSE WIDTH='1400' HEIGHT='450' NAME='confirmacion' ALIGN='top'' TYPE='application/x-shockwave-flash' PLUGINSPAGE='http://www.macromedia.com/go/getflashplayer'>
</EMBED>
</OBJECT>

</BODY>
</HTML>
