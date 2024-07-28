<script>
function checkform(f,p) {
var cif=f.cif.value;
cif=cif.toUpperCase();
cif.replace("-","");
cif.replace(" ","");
if ((f.email.value == "")||(f.name.value == "")||(cif == "")) {
    alert( "Empleneu el formulari si us plau");
    f.name.focus();
    return false ;
  }
var x=false;
if (cif.substr(0,1)=="X"||cif.substr(0,1)=="Y"||cif.substr(0,1)=="Z"||cif.substr(0,1)=="K"||cif.substr(0,1)=="L"||cif.substr(0,1)=="M") var x=true;
if (f.estrangers.value!="on"&&cif.length!=9&&p&&!x) { alert('NIF incorrecte'); return false; }
if (p&&f.estrangers.value!="on") { if (!nif(cif)) { alert('NIF incorrecte'); return false;  }}
if (!f.signa.checked) { alert ("Cal marcar la casella d'adhesió al manifest"); return false; }
f.cif.value=cif;
return true;
}
</script>

<?

$filename="adhesions.txt";
$fp=fopen($filename,"r");
$contents = " ".fread($fp, filesize($filename));
fclose($fp);

$dni=$_POST['cif'];
if (strpos(strtoupper($contents),strtoupper($dni))) $duplicat=true; else $duplicat=false;

$blacklist=array(); //83.32.238.2","62.57.189.104","77.224.81.150","81.39.185.197","79.151.140.202","81.39.185.197","188.84.3.140","83.34.6.141","88.3.84.141","213.143.49.6","37.14.49.199","92.187.236.126","2.139.241.173","95.21.96.93","213.143.49.197","84.78.18.198","84.78.17.176","217.148.68.113","37.223.119.33","84.78.18.129","80.28.45.41");

function nospam($s) {
        $s=strtolower($s);
        $spam=array("Vilbeny","Presley","masturba","puta","putas","maricons","maricas","psicopat", "contra castilla", "francisco franco","nazi", "nazis", "anal ","pervertit","prostitu","tontos ","porno" ,"subnormal","sex ","sexe","sexe anal");

        foreach ($spam as $x) {
                if (strpos(" ".$s,$x)) return false;
        }
        return true;
}

if ($_POST['email']!=""&&!$duplicati&&!in_array($_SERVER['REMOTE_ADDR'],$blacklist)&&nospam($_POST['name'])) {

                $from="info@del155alarepublica.cat";
                $head  = '';
                $head  .= "Date: ". date('r'). " \n";
                $head  .= "From: $from <$from>\n";
                $head  .= "X-Priority: 1 \n";
                $head  .= "MIME-Version: 1.0\n";
                $head  .= "Content-Type: text/html;charset=\"iso-8859-1\"\n";
                $head  .= "Content-Transfer-Encoding: 8bit\n\n";

                $to="info@del155alarepublica.cat";
                $subject="Nova adhesió";
                $body = print_r($_POST,true);
                $body .= "ip address:".$_SERVER['REMOTE_ADDR'];
                $headers = "Date: ".date('r')."\nFrom: <info@del155alarepublica.cat>\nMIME-Version: 1.0\nContent-type: text/html; charset=UTF-8\n";
                $sent = mail($to,$subject,utf8_encode(html_entity_decode(htmlentities($body))),$headers);

		//adhesions
		$fp=fopen("adhesions.txt","a");
                $comentari=str_replace("\n","",str_replace(";",",",$_POST['comment']));
                $line=$_POST['type'].";".trim($_POST['name']).";".$_POST['location'].";".$_POST['postalcode'].";".$_POST['job'].";".$_POST['jobplace'].";".$_POST['delegat'].";".$_POST['birthdate'].";".$_POST['email'].";".$_POST['phone'].";".$comentari.";".$_SERVER['REMOTE_ADDR']."\n";
                fwrite($fp,$line);
                fclose($fp);

		if ($_POST['public']=="si") {
                $fp=fopen("public.txt","a");
                $comentari=str_replace("\n","",str_replace(";",",",$_POST['comment']));
                $line=$_POST['type'].";".trim($_POST['name']).";".$_POST['location'].";".$_POST['job'].";".$_POST['jobplace'].";".$_SERVER['REMOTE_ADDR']."\n";
                fwrite($fp,$line);
                fclose($fp);
		}	


		?>
                <div class='thanks'><b>Gràcies per la teva adhesió.</b><br><br>Si us plau, ajuda'ns a difondre la nostra iniciativa.</div>
		<?

} else {

if ($duplicat) {
echo "<span style='color:red'>Ho sentim, però la seva adhesió ja estava registrada amb anterioritat.</span><br><br>";
} else {
?>
<? } ?>
<div class="caixa">
<?/*
<input type="radio" name="tipus" value="particular" checked onchange="$('#particular').show();$('#entitat').hide()"> Particular &nbsp;<input type="radio" name="tipus" value="entitat" onchange="$('#particular').hide();$('#entitat').show()"> Entitat
*/?>
<div id="particular">
<form id="adhesions" method="post" class="form-horizontal"
    data-fv-framework="bootstrap"
    data-fv-icon-valid="glyphicon glyphicon-ok"
    data-fv-icon-invalid="glyphicon glyphicon-remove"
    data-fv-icon-validating="glyphicon glyphicon-refresh">
Nom i cognoms:<br>
<input type="text" class="form-control" required autofocus name="name" value="<?=$_POST['name']?>">
Població:<br>
<input type="text" class="form-control" required name="location" value="<?=$_POST['location']?>">
Codi Postal:<br>
<input type="text" class="form-control" required name="postalcode" value="<?=$_POST['postalcode']?>">
Professió:<br>
<input type="text" class="form-control" required name="job" value="<?=$_POST['job']?>">
Centre de treball:<br>
<input type="text" class="form-control" required name="jobplace" value="<?=$_POST['jobplace']?>">
Ets delegat/da sindical:<br>
<div style='padding:5px 0px'><label>Sí</label> <input type="radio" name="delegat" value="si" required> <label>No</label> <input type="radio" name="delegat" value="no" required></div>
Data de naixement:<br>
<input type="date" class="form-control" required name="birthdate" value="<?=$_POST['birthdate']?>">
E-mail:<br>
<input type="email" class="form-control" data-fv-emailaddress-message="Introduiu una adreça d'email vàlida" required name="email" value="<?=$_POST['email']?>">
Telèfon de contacte:<br>
<input type="text" class="form-control" required name="phone" value="<?=$_POST['phone']?>">
Comentaris (opcional):<br>
<textarea class="form-control" name="comment" style="height:150px"></textarea>

<input type="checkbox" name="public" value="si"> Estic d'acord en que es faci pública la meva adhesió.<br><br>
<input type="hidden" name="type" value="particular">
<input  class="btn btn-lg btn-primary btn-block" type="submit" value="M'adhereixo al manifest"></td></tr>
</form>
</div>

<?/*<div id="entitat" style="display:none">
<form method="post" onsubmit="return checkform(this,0);">
<table class="signa" border=0>
<tr><td class='field' width="200">Nom de l'entitat o empresa:</td><td><input size=40 type="text" name="name"></td></tr>
<tr><td class='field'>CIF:</td><td><input type="text" name="cif"></td></tr>
<tr><td class='field'>Email:</td><td><input size=40 type="text" name="email"></td></tr>
<tr><td class='field'>Comentari opcional:</td><td><textarea name="comment" rows=5 cols=40></textarea></td></tr>
<tr><td colspan=2><br><input name="signa" type="checkbox"> He llegit i m'adhereixo al <?=$title?><br><br>
<input type="hidden" name="type" value="entitat">
<input  type="submit" value="M'adhereixo al manifest"></td></tr>
</table>
</form>
</div>*/?>

<br>
</div>

<? } ?>

<script>
$(document).ready(function() {
    $('#adhesions').formValidation();
});

</script>
