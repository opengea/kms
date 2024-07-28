<html>
<head>
<title>extranet.<?=$client_account['domain']?></title>
<meta name="robots" content="noindex">
<link rel="stylesheet" type="text/css" href="/kms/tpl/style.css" />

<STYLE type="text/css">


td {
  padding-top:10px;
  padding-bottom:10px;
  border-top: solid 1px #cccccc;
}
</style>
</head>
<body>
<div style="padding-left:25px;width:800px">
<h2>Questionari de client</h2>

Aquest questionari te la finalitat d'avaluar el nivell d'optimitzaci&oacute;, control i d'integraci&oacute; de tecnologies a la seva empresa. Les dades recollides quedaran emagatzemades en un arxiu completament confidencial i tindran per finalitat, la confecci&oacute; d'una proposta de serveis orientada a millorar el rendiment de la seva empresa.<br>
<br>
<h3>Dades de contacte</h3>
<table>
<tr><td width=300><label>El vostre nom</label></td><td><input name="name"></td></tr>
<tr><td width=300><label>Empresa</label></td><td><input name="empresa"></td></tr>
<tr><td width=300><label>Tipus de societat</label></td><td><input name="tipus"></td></tr>
<tr><td width=300><label>Sector</label></td><td><input name="sector"></td></tr>
<tr><td width=300><label>Nombre d'empleats</label></td><td><input name="empleats"></td></tr>
</table>
<br>
<h3>Web</h3>
<table>
<tr><td width=300><label>En cas que disposi de web, indiqui'ns l'adreça:</label></td><td><input name="name"></td></tr>
<tr><td width=300><label>La seva web és autogestionable?</label></td><td><input type="radio" name="havecms" value="Si" onclick="document.getElementById('havecms-1').style.display='block';document.getElementById('havecms-2').style.display='none';">Si<input type="radio" name="havecms" value="No" onclick="document.getElementById('havecms-2').style.display='block';document.getElementById('havecms-1').style.display='none';">No
<div id="havecms-1" style="display:none;background-color:#fefa96"><br>De manera satisfactoria? Si No</div><div id="havecms-2" style="display:none;background-color:#fefa96"><br>Li interessaria que ho fos? Si No</div></td></tr>

<tr><td width=300><label>Pot publicar butlletins, noticies i documents facilment?</label></td><td><input type="radio" name="havecms" value="Si" onclick="document.getElementById('havecms-i').style.display='none'">Si<input type="radio" name="havecms" value="No" onclick="document.getElementById('havecms-i').style.display='block'">No<div id="havecms-i" style="display:none;background-color:#fefa96"><br>Li interessaria que ho fos? Si No</td></tr></div>

<tr><td width=300><label>Pot publicar butlletins, noticies i documents facilment?</label></td><td><input type="radio" name="havecms" value="Si" onclick="document.getElementById('havecms-i').style.display='none'">Si<input type="radio" name="havecms" value="No" onclick="document.getElementById('havecms-i').style.display='block'">No<div id="havecms-i" style="display:none;background-color:#fefa96"><br>Li interessa aquesta opció? Si No</td></tr></div>

<tr><td width=300><label>Podeu publicar i actualitzar el vostre cataleg de productes i serveis?</label></td><td><input type="radio" name="havecms" value="Si" onclick="document.getElementById('havecms-i').style.display='none'">Si<input type="radio" name="havecms" value="No" onclick="document.getElementById('havecms-i').style.display='block'">No<div id="havecms-i" style="display:none;background-color:#fefa96"><br>Us interessa aquesta opció? Si No</td></tr></div>

<tr><td width=300><label>Podeu vendre per internet?</label></td><td><input type="radio" name="havecms" value="Si" onclick="document.getElementById('havecms-i').style.display='none'">Si<input type="radio" name="havecms" value="No" onclick="document.getElementById('havecms-i').style.display='block'">No<div id="havecms-i" style="display:none;background-color:#fefa96"><br>Li interessa aquesta opció? Si No</td></tr></div>

<tr><td width=300><label>Els vostres clients poden conectar-se amb usuari i contrasenya propies a la vostra web per accedir als seus serveis?</label></td><td><input type="radio" name="havecms" value="Si" onclick="document.getElementById('havecms-i').style.display='none'">Si<input type="radio" name="havecms" value="No" onclick="document.getElementById('havecms-i').style.display='block'">No<div id="havecms-i" style="display:none;background-color:#fefa96"><br>Li interessa aquesta opció? Si No</td></tr></div>

<tr><td width=300><label>La web es multiidioma?</label></td><td><input type="radio" name="havecms" value="Si" onclick="document.getElementById('havecms-i').style.display='none'">Si<input type="radio" name="havecms" value="No" onclick="document.getElementById('havecms-i').style.display='block'">No<div id="havecms-i" style="display:none;background-color:#fefa96"><br>Li interessa aquesta opció? Si No</td></tr></div>

<tr><td width=300><label>La web esta connectada a xarxes socials?</label></td><td><input type="radio" name="havecms" value="Si" onclick="document.getElementById('havecms-i').style.display='none'">Si<input type="radio" name="havecms" value="No" onclick="document.getElementById('havecms-i').style.display='block'">No<div id="havecms-i" style="display:none;background-color:#fefa96"><br>Li interessa aquesta opció? Si No</td></tr></div>

<tr><td width=300><label>Cobreix totes les seves necessitats actuals?</label></td><td><input type="radio" name="satisfiedcms" value="Si">Si<input type="radio" name="satisfiedcms" value="No">No</td></tr>
<tr><td width=300><label>Voldria fer-hi reformes?</label></td><td><input type="radio" name="web" value="nova">Si, vull una web completament nova<br><input type="radio" name="web" value="reformes">Si, vull fer millores<br><input type="radio" name="web" value="No">No, ja esta bé tal com està</td></tr>
</table>
<br>
<pre>
Que es el que els vostres empleats realitzen el 80% del seu temps?
Podria automatitzar-se?

Relacions amb els vostres clients

====Comunicacions======

Avalui el nivell de immediatesa/fluidesa en les comunicacions

- Disposa d'adreçes de correu del tipus @elseudomini.com ?

- Relacions amb els vostres clients:
  *email.. nivell de fluidesa, velocitat de contacte, 

- Relacions entre empleats
  *...

- es podria millorar:
   - velocitat de resposta   - verificació de recepció   - seguretat en comunicacions    - automatitzacio de consultes

- les seves consultes s'inserten directament a la base de dades?

- compteu amb un sistema de suport automatitzat?

- Disposeu d'eines d'enviament de correu massiu?

- Realitzeu comunicacions a traves de xarxes socials?

- Publiqueu butlletins informatius o rss a internet ?

- Compartiu documents i fitxers amb facilitats internament o amb els vostres colaboradors?

- Disposeu d'un canal de video/televisio o mediabase?

- Gestor d'events

====Planificació i optimització de processos====

- temps que es passen al dia davant del programa de correu:
  100%  90% 80%  50% 0%

- Utilitzeu agenda/calendar?
  Si. google   Si. blackberry,   Si. mac.   No.

- Compteu amb eiens de gestió de projectes?

- Compteu amb un sistema de gestio integral?
  Programa que utilitzeu:

 Funcions:  - comptabilitat - facturacio - remeses  -pressupostos -balanços  -iva  

=====Nivell d'organització======

- Control de biblioteques
- Control de materials
- Clients
- usuaris
- bases de dades
</pre>



</div>
</body>
</html>
