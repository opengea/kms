<?
include "/usr/local/kms/tpl/common_header.php";

 //include "/usr/share/kms/mod/isp/session_check.php"; ?>
<?
// Creació de fitxers d'idioma desde KMS
// funció per excloure codi HTML de la recodificació

function convertchars($str) {
	$str = str_replace("'","\'",htmlentities($str));
	$str = str_replace("&lt;","<",$str);
	$str = str_replace("&gt;",">",$str);
	return $str;
}

// definim variables de conexió

 if (!isset($_GET['host'])) $server = "localhost"; else { 
  header ('location: http://'.$_GET['host'].'/kms/lib/isp/web/makelang.php?html&db='.$_GET['db'].'&dom='.$_GET['dom'].'&l='.$_GET['l']);
 exit;
 }
 $user = "root";
 $pass = "intergrid";
 $tablename = "kms_lang";

  // capçelera
  echo "<div style='padding-left:20px'><h2>Codificaci&oacute; d'idiomes en Base de dades</h2>";

  // comprovem que pasem les variables desde la URL
  if (!isset($_GET['db']) or !isset($_GET['dom']) or !isset($_GET['l'])) {
//	echo "No s'han introduit els par&agrave;metres en la URL.<br>&uacute;s:<br>&host = hostname<br>&db = nom de taula a conectar<br>&dom = nom del domini on escriurem els fitxers a la subcarpeta /lang<br>&l = dos lletres que defineixen l'idioma exportar";exit;
?>
	
	<form method="GET" action="">
	
	<table>
	<tr><td width="200"><label>servidor </label></td><td><input name="host"></td></tr>
	<tr><td><label>base de dades </label></td><td><input name="db"></td></tr>
	<tr><td><label>domini </label></td><td><input name="dom"></td></tr>
	<tr><td><label>idioma </label></td><td><input type="radio" name="l" value="es"> Castellano</td></tr>
	<tr><td><label></label></td><td><input type="radio" name="l" value="ct"> Catal&agrave;</td></tr>
	<tr><td><label></label></td><td><input type="radio" name="l" value="en"> English</td></tr>
	<tr><td><label></label></td><td><input type="radio" name="l" value="it"> Italiano</td></tr>
	<tr><td><label></label></td><td><input type="radio" name="l" value="de"> Deutch </td></tr>
	<tr><td><label></label></td><td><input type="radio" name="l" value="fr"> Fran&ccedil;aise</td></tr>
	<tr><td><label>&nbsp;</label></td></tr>
	<tr><td><label>Proc&eacute;s </label></td><td><input type="radio" name="proc" value="enc"> Codificar</td><tr>
	<tr><td><label></label></td><td><input type="radio" name="proc" value="dec"> Decodificar</td><tr>	
	</table>
	<br>
	<input type="submit" value="generar">
	</form></div>
<?
	exit;
	}

  // conectem amb la BD
  $result = mysqli_connect($server,$user,$pass);
  if (!$result) { echo "error al connectar al host";exit; }
  mysqli_select_db ($_GET['db']);
  $select = "SELECT ".$_GET['l'].",const FROM ".$tablename;
  $result = mysqli_query($select);
  if (!$result){ echo "La conexi&oacute; a la BBDD es correcte per&ograve; hi ha un error en alg&uacute;n par&agrave;metre introduit.<br>Normalment es degut a que l&#x27;idioma seleccionat no existeix a la taula.<br><br><input type='submit' value='tornar' onclick='history.go(-1)'>";exit;}

  // Llegim contingut de la BBDD
  $str = "";
  $i =0;
  if (isset($_GET['html'])) { $entities1="html_entities("; $entities2=")"; }
        while ($row=mysqli_fetch_array($result)) {
        if (isset($_GET['html'])) $str .= "define('".$row['const']."','".convertchars($row[$_GET['l']])."');\n";
             else   $str .= "define('".$row['const']."','".$row[$_GET['l']]."');\n";
        $i++;
  }

  // Imprimim resultats

  echo "Camps modificats correctament"."<br>";;
  echo "Codificades ".$i." entrades";
  if (isset($_GET['html'])) echo " amb codificaci&oacute; HTML";
  echo "<br><br><input type='submit' value='tornar' onclick='history.go(-1)'>";
  mysqli_close();
  
?>
