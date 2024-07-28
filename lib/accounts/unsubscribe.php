<?
// by Jordi Berenguer <j.berenguer@intergrid.cat>


require_once('conexion.class.php');
require_once('email.class.php');

?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="javascript" type="text/javascript" src="/beta/css/niceforms.js"></script>

<link href="../../css/index.css" rel="stylesheet" type="text/css">
<style type="text/css" media="screen">
@import url(/beta/css/niceforms-default.css);
.borde_blanco {
        border: 1px solid #f5f5f5;
}   
</style>
<title>Formulario de cancelaci&oacute;n de lista de correo Scalextric</title>
<style type="text/css">
<!--
.borde_blanco {border: 1px solid #f5f5f5 class="textinput" id="textinput4";
}   
body {
        background-color: #fff;
}   
.style1 {font-size: 10px}
-->
</style>


</head>
<body bgcolor="#FFFFFF" leftmargin="10" topmargin="10" marginwidth="10" marginheight="10">

<table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>        
    <td><img src="../../imagenes/LOGOSCALEXTRIC_web.jpg" alt="scalextric" /></td>
  </tr>
  <tr>


<?
if (isset($_GET["email"]))
 
{

// borramos la direccion de la base de datos

	$result = mysql_connect("localhost", "user_tecnitoys", "tecniweb");
        mysql_select_db ("tecnitoys");

	$query = "SELECT * FROM users WHERE email='".$_GET["email"]."'";
	$result = mysql_query($query);
	$nrows = mysql_num_rows($result);	

	 if ($nrows==0) {
?>
		<td><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000000">La direcci&oacute;n <? echo $_GET['email']; ?> no se encuentra en la base de datos de la lista de correo Scalextric.</font></td>
 </tr>
  <tr>
    <td><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000000"><a href="unsubscribe.php" >Realizar otra cancelaci&oacute;n</a></font></td>
  </tr>
<?

       }  else {

	$query = "DELETE FROM users WHERE email='".$_GET["email"]."'";
	$result = mysql_query($query);

	if (!$result) {
                echo "error:".mysql_error();
	} else {

		?>
<td><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#666666">Se ha cancelado la subscripci&oacute;n del usuario con email <? echo $_GET['email']; ?></font></td>
 </tr>
  <tr>
    <td><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000000"><a href="unsubscribe.php" >Realizar otra cancelaci&oacute;n</a></font></td>
  </tr>

<?
              $body = "Este es un mensaje para confirmar que su subscripción a la lista de correo Scalextric, ha sido cancelada.";
              $email = new Email("registros@scalextric.es", $_GET["email"], "confirmaci&oacute;n de baja", $body, 0);
 	      // $email = new Email("registros@scalextric.es", "j.berenguer@intergrid.cat", "confirmación de baja", $body, 0);
              $goodemail = $email->send();

	}

	}

} else {

?>

    <td><font face="Verdana, Arial, Helvetica, sans-serif" size="3" color="#990000"><b>Formulario de cancelaci&oacute;n de la lista Scalextric</b></font></td>
  </tr>
  <tr>
    <td><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000000">Si deseas cancelar tu subscripci&oacute;n a la lista de correo Scalextric escribe tu direcci&oacute;n de email y pulsa el bot&oacute;n 'confirmar'.</font></td>
  </tr>
  <tr>
    <td><form action="unsubscribe.php" method="GET" name="form_remove">
<input name="email" type="text" class="inputbox" value="tu e-mail" size="40" onClick="document.form_remove.email.value='';"/>
   <input type="button" name="imageField" class="textinput" id="textinput4" value="confirmar" onClick="document.form_remove.submit()"/></form>
</td>
  </tr>

<?

} ?>

</table>

</body>
</html>

<?



function cerrarConexion($conexion) {
	$conexion->close_database();
	send_response_to_client();

}
function send_response_to_client(){
	global $_response;
	print $_response;
	set_response("");
}

function set_response($response){
	global $_response;
	$_response = $response;
}
?>


