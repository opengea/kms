<div id="afiliat">
<h1>Dona suport al projecte Units pel Progrés d'Andorra</h1>
<? 
if ($_POST['name']!=""&&$_POST['surname']!=""&&$_POST['idf']!="") { 
error_reporting(E_ALL); ini_set('display_errors', 1); 
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
	$headers .= 'From: Units pel Progrés d\'Andorra <upa@unitsprogresandorra.com>' . "\r\n";
        $from="upa@unitsprogresandorra.com";
        $to=$_POST['email'];
	$subject="Gràcies pel vostre donatiu!";
	$body="Benvolgut/da,<br><br>Us agraïm el vostre donatiu de ".$_POST['valor']."€ al projecte Units pel Progrés d'Andorra. <br><br>Podeu fer efectiu el donatiu realitzant una transferència al compte següent: <br><br><b>MORA BANC<br><b>AD45 0004 0019 0001 4891 9012</b><br>Codi Swift: BINAADAD<br></b><br>Si us plau indiqueu el vostre nom i cognoms en el concepte. <br><br>Gràcies.";
	 echo "<p>".$body."</p>";
        $body="<span style='font-family:monospace;font-size:12px'>".$body."</span>";
        $success=mail($to, $subject, $body, $headers, "-f {$from}");
	if (!$success) echo "<b>S'ha produït un problema. Si us plau, intenteu-ho més tard.</b>";	
	// notificacio admin
	$to="upa@unitsprogresandorra.com";
	$subject="Nou donatiu rebut des del web";
	$body="Ha arribat un nou donatiu des del web http://www.unitsprogresandorra.com/donacions : <br><br>";
	$body.="Data: ".date('d-m-Y h:i')."<br>";
	$body.="Nom: ".$_POST['name']."<br>";
	$body.="Cognoms: ".$_POST['surname']."<br>";
	$body.="Identifiació fiscal: ".$_POST['idf']."<br>";
	$body.="Valor del donatiu: ".$_POST['valor']."<br>";
	$body.="E-mail: ".$_POST['email']."<br>";
	$body.="Telèfon mòbil: ".$_POST['mobile']."<br>";
	$body.="Vol rebre comunicacions: ".$_POST['sms']."<br>";
	$body.="<br><br>www.unitsprogresandorra.com<br>";	
	$to="upa@unitsprogresandorra.com";
	$success=mail($to, $subject, $body, $headers, "-f {$from}");
	if (!$success) echo "<b>S'ha produït un problema. Si us plau, intenteu-ho més tard.</b>";

} else { ?>

Col·labora amb el nostre projecte fent una donació.
<br>
<br>
La Llei de Partits polítics indica que les donacions als partits són nominatives i de fins a 6.000€ l'any. Les poden fer les persones físiques i serán públiques. 
<br>
<br>
<form id="form" method="post">
<input type="hidden" name="action" id="action" value="donacions">
Nom *:<br><input type="text" name="name"><br>
Cognoms *:<br><input type="text" name="surname"><br>
Identificació fiscal *:<br><input type="text" name="idf"><br>
Import del donatiu en Euros (fins a 6.000€ anuals) *:<br><input type="text" name="valor"><br>
Email:<br><input type="text" name="email"><br>
Telèfon mòbil:<br><input type="text" name="mobile"><br>
<input type="checkbox" name="sms" checked> Accepto rebre missatges mitjançant correu electrònic i telèfon.<br>

<input class="button" type="submit" value="Procedir amb la donació"><br><br>

</form>

<? } ?>
</div>
